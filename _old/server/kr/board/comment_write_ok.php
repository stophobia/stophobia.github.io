<?php
// 기본 클래스를 부른다
include 'class/common.php';
$GR = new COMMON;

// 불법적인 글쓰기는 아닌가 체크
if(!eregi($_SERVER['HTTP_HOST'], $_SERVER['HTTP_REFERER']) && !$_GET['openid_mode'] && ($_GET['openid_mode'] != 'id_res')) 
	$GR->error('정상적인 방법으로 게시물을 작성해 주세요.', 1);

// 변수 처리
if(array_key_exists('id', $_POST) && $_POST['id']) $id = $_POST['id']; elseif($_GET['id']) $id = $_GET['id'];
if(array_key_exists('page', $_POST) && $_POST['page']) $page = $_POST['page']; elseif($_GET['page']) $page = $_GET['page'];
if(array_key_exists('articleNo', $_POST) && $_POST['articleNo']) $articleNo = $_POST['articleNo']; elseif($_GET['articleNo']) $articleNo = $_GET['articleNo'];
if(array_key_exists('modifyTarget', $_POST) && $_POST['modifyTarget']) $modifyTarget = $_POST['modifyTarget']; elseif($_GET['modifyTarget']) $modifyTarget = $_GET['modifyTarget'];
if(array_key_exists('replyTarget', $_POST) && $_POST['replyTarget']) $replyTarget = $_POST['replyTarget']; elseif($_GET['replyTarget']) $replyTarget = $_GET['replyTarget'];
$ip = $_SERVER['REMOTE_ADDR'];
if(array_key_exists('is_grcode', $_POST) && $_POST['is_grcode']) $isGrcode = $_POST['is_grcode'];
if(array_key_exists('no', $_SESSION) && $_SESSION['no']) $sessionNo = $_SESSION['no']; else $sessionNo = 0;
if(array_key_exists('clickCategory', $_POST) && $_POST['clickCategory']) $clickCategory = $_POST['clickCategory']; // 카테고리 선택 후, 자동선택 설정 | 2010-02-07 Coder PicoZ , Editor 이동규

// DB 에 연결한다.
$GR->dbConn();

// 테마(스킨)에 있는 글쓰기 처리부터 인클루드
$tmpFetchBoard = @mysql_fetch_array(mysql_query("select * from {$dbFIX}board_list where id = '$id'"));
@include 'theme/'.$tmpFetchBoard['theme'].'/theme_comment_write_ok.php';

// 글쓴이 권한값 가져오기
if($sessionNo) {
	$tmpFetch = @mysql_fetch_array(mysql_query("select id, level from {$dbFIX}member_list where no = '$sessionNo'"));
	$writerLevel = $tmpFetch['level'];
	if($sessionNo == 1) $isAdmin = 1; else $isAdmin = 0;
	if(array_key_exists('is_secret', $_POST) && $_POST['is_secret']) $isSecret = 1; else $isSecret = 0;
	$isMember = 1;
	$getMasters[0] = $tmpFetchBoard['master'];
	$getMasters[1] = $tmpFetchBoard['group_no'];
	if($getMasters[0]) {
		$masterArr = explode('|', $getMasters[0]);
		$masterNum = count($masterArr);
		for($m=0; $m<$masterNum; $m++) {
			if($_SESSION['mId'] && $_SESSION['mId'] == $masterArr[$m]) {
				$isAdmin = 1;
				break;
			}
		}
	}
	if($getMasters[1]) {
		$getGroupMaster = @mysql_fetch_array(mysql_query('select master from '.$dbFIX.'group_list where no = '.$getMasters[1]));
		$groupMaster = explode('|', $getGroupMaster[0]);
		$cntResult = count($groupMaster);
		for($g=0; $g<$cntResult; $g++) {
			if($_SESSION['mId'] && $_SESSION['mId'] == $groupMaster[$g]) {
				$isAdmin = 1;
				break;
			}
		}
	}
}
else
{
	$writerLevel = 1; $isAdmin = 0; $isMember = 0; $isMaster = 0; $isSecret = 0;
	if(!$_SESSION['openID'] && !$_POST['openid_url'] && !$_GET['openid_mode'] && ($_GET['openid_mode'] != 'id_res') &&
		(!$_SESSION['antiSpam'] || !$_POST['antispam'] || $_SESSION['antiSpam'] != $_POST['antispam']))
		$GR->error('자동입력방지 답이 올바르지 않습니다', 0, 'HISTORY_BACK');
}

// 현재 게시판의 접근권한을 확인한다. 작성자가 댓글을 허용하지 않으면 댓글을 달 수 없다.
$isWriteOk['comment_write_level'] = $tmpFetchBoard['comment_write_level'];
$isWriteOk['is_openid'] = $tmpFetchBoard['is_openid'];
if(!$isAdmin && !$isMaster && ($writerLevel < $isWriteOk['comment_write_level'])) $GR->error('코멘트 작성 권한이 없습니다.', 0, 'board.php?id='.$id.'&amp;articleNo='.$articleNo);
$getArticleOption = @mysql_fetch_array(mysql_query("select * from {$dbFIX}article_option where id = '$id' and article_num = '$articleNo'"));
if($getArticleOption['no'] && !$getArticleOption['reply_open']) $GR->error('이 게시물에는 댓글을 작성하실 수 없습니다.', 0, 'board.php?id='.$id.'&amp;articleNo='.$articleNo);

// 제목 내용 처리
if(array_key_exists('content', $_POST) && $_POST['content']) $content = $_POST['content'];
else if($_COOKIE['tmpContent']) $content = $_COOKIE['tmpContent'];
else $GR->error('내용을 입력해 주세요', 0, 'board.php?id='.$id.'&amp;articleNo='.$articleNo);
if(array_key_exists('subject', $_POST) && $_POST['subject']) $subject = $_POST['subject'];
else if($_COOKIE['tmpSubject']) $subject = $_COOKIE['tmpSubject'];
else $GR->error('제목을 입력해 주세요', 0, 'board.php?id='.$id.'&amp;articleNo='.$articleNo);
$content = str_replace('<p>', '', str_replace('</p>', '', str_replace('<p>&nbsp;</p>', '', $content)));

// 회원의 기본 정보를 가져온다.
if($isMember) {
	$memberData = @mysql_fetch_array(mysql_query("select no, nickname, password, email, homepage from {$dbFIX}member_list where no = '$sessionNo'"));
	$name = $memberData['nickname'];
	$password = $memberData['password'];
	$email = $memberData['email'];
	$homepage = $memberData['homepage'];
	if($_POST['useCoEditor']) $content = addslashes($content);
	else $content = addslashes(str_replace("\t", '&nbsp;&nbsp;&nbsp;&nbsp;', htmlspecialchars($content)));
	$subject = addslashes(htmlspecialchars($subject));
}
// 비회원일 경우 처리
else {
	// 오픈아이디를 지원할 때 처리
	if($isWriteOk['is_openid'] && !$_SESSION['openID']) {

		// 처음 시작시 인증 절차
		if ($_POST['openid_url']) {
			include 'openid/class.openid.php';
			$openid = new SimpleOpenID;
			$openid->SetIdentity($_POST['openid_url']);
			$openid->SetTrustRoot('http://' . $_SERVER["HTTP_HOST"]);
			$openid->SetRequiredFields(array('nickname'));
			$openid->SetOptionalFields(array('email'));
			if ($openid->GetOpenIDServer()) {
				@setcookie('tmpSubject', $subject, $GR->grTime()+600);
				@setcookie('tmpContent', $content, $GR->grTime()+600);
				$openid->SetApprovedURL('http://' . $_SERVER["HTTP_HOST"] . $_SERVER["PHP_SELF"].'?id='.$id.'&articleNo='.$articleNo.'&modifyTarget='.$modifyTarget.'&replyTarget='.$replyTarget);
				$openid->Redirect();
			} else {
				$error = $openid->GetError();
				echo "ERROR CODE: " . $error['code'] . "<br>";
				echo "ERROR DESCRIPTION: " . $error['description'] . "<br>";
			}
			exit();
		}
		
		// 인증이 끝나고 이 곳으로 리다이렉션 된 이후 값 처리
		else if($_GET['openid_mode'] == 'id_res') {
			include 'openid/class.openid.php';
			$openid = new SimpleOpenID;
			$openid->SetIdentity($_GET['openid_identity']);
			$openid_validation_result = $openid->ValidateWithServer();
			if ($openid_validation_result == true) {
				$name = $_GET['openid_sreg_nickname'];
				$email = $_GET['openid_sreg_email'];
				$homepage = $_GET['openid_identity'];
				$password = substr(md5($GR->grTime()), -7);
				$_SESSION['openID'] = $_GET['openid_identity'];
				$_SESSION['openIDName'] = $_GET['openid_sreg_nickname'];
				$_SESSION['openIDEmail'] = $_GET['openid_sreg_email'];
			}else if($openid->IsError() == true){
				$error = $openid->GetError();
				echo "ERROR CODE: " . $error['code'] . "<br>";
				echo "ERROR DESCRIPTION: " . $error['description'] . "<br>";
			} else {
				echo "INVALID AUTHORIZATION";
			}
		
		// 사용자가 취소할 경우
		} else if ($_GET['openid_mode'] == 'cancel'){
			echo "USER CANCELED REQUEST";

		// 위의 처리가 끝난 후 마지막으로 값 처리
		} else {
			if($_POST['name']) $name = addslashes(htmlspecialchars(trim($_POST['name'])));
			elseif($_SESSION['openIDName']) $name = htmlspecialchars($_SESSION['openIDName']);
			if($_POST['password']) {
				$tmpPassword = @mysql_fetch_row(mysql_query("select password('".$_POST['password']."')"));
				$password = $tmpPassword[0];
			}
			if($_POST['email']) $email = addslashes(htmlspecialchars(trim($_POST['email'])));
			elseif($_SESSION['openIDEmail']) $email = $_SESSION['openIDEmail'];
			if($_POST['homepage']) $homepage = addslashes(htmlspecialchars(trim($_POST['homepage'])));
			if(!$name) $GR->error('이름을 입력해 주세요', 0, 'board.php?id='.$id.'&articleNo='.$articleNo);
			if(!$password) $GR->error('비밀번호를 입력해 주세요', 0, 'board.php?id='.$id.'&articleNo='.$articleNo);
		}

	// 오픈아이디를 사용하지 않을 경우 처리
	} else {
		if($_POST['name']) $name = addslashes(htmlspecialchars(trim($_POST['name'])));
		elseif($_SESSION['openIDName']) $name = htmlspecialchars($_SESSION['openIDName']);
		if($_POST['password']) {
			$tmpPassword = @mysql_fetch_row(mysql_query("select password('".$_POST['password']."')"));
			$password = $tmpPassword[0];
		}
		if($_POST['email']) $email = addslashes(htmlspecialchars(trim($_POST['email'])));
		elseif($_SESSION['openIDEmail']) $email = $_SESSION['openIDEmail'];
		if($_POST['homepage']) $homepage = addslashes(htmlspecialchars(trim($_POST['homepage'])));
		elseif($_SESSION['openID']) $homepage = $_SESSION['openID'];
	}
	$subject = htmlspecialchars($subject);
	if(!$_POST['useCoEditor']) $content = htmlspecialchars($content);
}

// 코멘트 수정일 때
if($modifyTarget && !$replyTarget) {
	$key = @mysql_fetch_array(mysql_query("select member_key, password from {$dbFIX}comment_{$id} where no = '$modifyTarget'"));
	if($key['member_key']) {
		if(!$isAdmin && !$isMaster && $sessionNo != $key['member_key']) $GR->error('자신이 작성한 코멘트만 수정할 수 있습니다.', 0, 'board.php?id='.$id.'&amp;articleNo='.$articleNo);
	} else {
		if(!$isAdmin && !$isMaster && $password != $key['password']) $GR->error('비밀번호가 다릅니다.', 0, 'board.php?id='.$id.'&amp;articleNo='.$articleNo);
	}
	
	$is_history = @mysql_query("select is_history from {$dbFIX}board_list where id = '{$id}'");
	if($is_history=='1') $content .= '<br /><span class="modifyTime">modified at '.date('Y.m.d H:i:s', $GR->grTime()).' by '.(($isAdmin)?'moderator':$name).'</span>';;
	if($isMember) {
		$sqlCommentUpdate = "update {$dbFIX}comment_{$id}
			set is_grcode = '$isGrcode', 
			subject = '$subject',
			content = '$content',
			is_secret = '$isSecret'
			where no = '$modifyTarget'";
		@mysql_query($sqlCommentUpdate);
	} else {
		$sqlCommentUpdate = "update {$dbFIX}comment_{$id}
			set is_grcode = '$isGrcode', 
			name = '$name',
			email = '$email',
			homepage = '$homepage',
			subject = '$subject',
			content = '$content'
			where no = '$modifyTarget'";
		@mysql_query($sqlCommentUpdate);
	}
}
// 코멘트 댓글달 때
elseif($replyTarget && !$modifyTarget)
{
	// 댓글의 답글일 경우 정렬 키 만들기
	function createOrderKey($familyNo, $parentKey) {
		global $dbFIX, $id;
		$keyWork = true;
		if($parentKey) {
			$getMaxChild = @mysql_fetch_array(mysql_query('select max(order_key) from '.$dbFIX.'comment_'.$id.' where family_no = '.$familyNo.' and order_key like \''.$parentKey.'_\''));
			if(!$getMaxChild[0]) return $parentKey.'A';
		} else {
			$getMaxChild = @mysql_fetch_array(mysql_query('select max(order_key) from '.$dbFIX.'comment_'.$id.' where family_no = '.$familyNo.' and thread = 1'));
			if(!$getMaxChild[0]) return 'AAA';
		}
		$arr = preg_split('//', $getMaxChild[0], -1, PREG_SPLIT_NO_EMPTY);
		$arrCnt = @count($arr) - 1;
		$newArr = $arr;
		$upperUp = 0;
		for($r=$arrCnt; $r>-1; $r--) {
			$ord = ord($arr[$r]);
			if(($ord + $upperUp) < 90) {
				$newArr[$r] = chr($ord+1);
				$upperUp = 0;
				break;
			} else {
				$newArr[$r] = 'A';
				$upperUp = 1;
			}
		}
		$result = '';
		for($e=0; $e<($arrCnt+1); $e++) {
			$result .= $newArr[$e];
		}
		return $result;
	}

	$originComment = @mysql_fetch_array(mysql_query("select no, family_no, thread, order_key from {$dbFIX}comment_{$id} where no = '$replyTarget'"));
	$familyNo = $originComment['family_no'];
	$parentKey = $originComment['order_key'];
	$orderKey = createOrderKey($familyNo, $parentKey);
	if(!$originComment['no']) 	$GR->error('답변글을 달 대상 코멘트가 없습니다.', 0, 'board.php?id='.$id.'&amp;articleNo='.$articleNo);
	$newThread = $originComment['thread'] + 1;
	$thisTime = $GR->grTime();
	$sqlReplyQue = "insert into {$dbFIX}comment_{$id}
		set no = '',
		board_no = '$articleNo',
		family_no = '$familyNo',
		thread = '$newThread',
		member_key = '$sessionNo',
		is_grcode = '$isGrcode',
		name = '$name',
		password = '$password',
		email = '$email',
		homepage = '$homepage',
		ip = '$ip',
		signdate = '$thisTime',
		good = '0',
		bad = '0',
		subject = '$subject',
		content = '$content',
		is_secret = '$isSecret',
		order_key = '$orderKey'";
	@mysql_query($sqlReplyQue);
	$insertNo = @mysql_insert_id();
	@mysql_query("update {$dbFIX}bbs_{$id} set comment_count = comment_count + 1 where no = '$articleNo'");
	if($isMember) @mysql_query("update {$dbFIX}member_list set point = point + 1 where no = '$sessionNo'");

	$sqlTotalCommentQue = "insert into {$dbFIX}total_comment
		set no = '',
			subject = '$subject',
			id = '$id',
			article_num = '$articleNo',
			comment_num = '$insertNo',
			signdate = '$thisTime',
			is_secret = '$isSecret'";
	@mysql_query($sqlTotalCommentQue);

	// 코멘트에 답변 코멘트시 원 코멘트 작성자에게 쪽지로 답변글을 알려주기
	$originWriter = @mysql_fetch_array(mysql_query("select member_key from {$dbFIX}comment_{$id} where no = '$replyTarget'"));
	if($originWriter[0] && $sessionNo && ($originWriter[0] != $sessionNo)) {
		$subject = '[답변글알림] ' . $subject;
		$content = addslashes('<a href="./board.php?id='.$id.'&amp;articleNo='.$articleNo.'#read'.$insertNo.
			'" onclick="window.open(this.href, \'_blank\'); return false">[※ 댓글 확인하기 (클릭)]</a><br /><br />').$content;
		$sendMemoQue = "insert into {$dbFIX}memo_save
		set no = '',
		member_key = '$originWriter[0]',
		sender_key = '$sessionNo',
		subject = '$subject',
		content = '$content',
		signdate = '$thisTime',
		is_view = '0'";
		@mysql_query($sendMemoQue);
	}

// 코멘트 신규 추가일때
} else {
	$thisTime = $GR->grTime();
	$sqlNewQue = "insert into {$dbFIX}comment_{$id}
		set no = '',
		board_no = '$articleNo',
		family_no = '0',
		thread = '0',
		member_key = '$sessionNo',
		is_grcode = '$isGrcode',
		name = '$name',
		password = '$password',
		email = '$email',
		homepage = '$homepage',
		ip = '$ip',
		signdate = '$thisTime',
		good = '0',
		bad = '0',
		subject = '$subject',
		content = '$content',
		is_secret = '$isSecret',
		order_key = ''";
	@mysql_query($sqlNewQue);
	$familyNo = mysql_insert_id();
	@mysql_query("update {$dbFIX}comment_{$id} set family_no = '$familyNo' where no = '$familyNo'");
	@mysql_query("update {$dbFIX}bbs_{$id} set comment_count = comment_count + 1 where no = '$articleNo'");
	if($isMember) @mysql_query("update {$dbFIX}member_list set point = point + 1 where no = '$sessionNo'");

	$sqlTotalCommentQue = "insert into {$dbFIX}total_comment
		set no = '',
			subject = '$subject',
			id = '$id',
			article_num = '$articleNo',
			comment_num = '$familyNo',
			signdate = '$thisTime',
			is_secret = '$isSecret'";
	@mysql_query($sqlTotalCommentQue);

	// 신규 코멘트 추가 시 원문 글 작성자에게 쪽지로 댓글을 알려주기 (글 작성자가 허용할 때만)
	if(!$getArticleOption['no'] || $getArticleOption['reply_notify']) {
		$originWriter = @mysql_fetch_array(mysql_query("select member_key from {$dbFIX}bbs_{$id} where no = '$articleNo'"));
		if($originWriter[0] && $sessionNo && ($originWriter[0] != $sessionNo)) {
			$subject = '[댓글알림] ' . $subject;
			$content = addslashes('<a href="./board.php?id='.$id.'&amp;articleNo='.$articleNo.'#read'.$familyNo.
				'" onclick="window.open(this.href, \'_blank\'); return false">[※ 댓글 확인하기 (클릭)]</a><br /><br />').$content;
			$sendMemoQue = "insert into {$dbFIX}memo_save
			set no = '',
			member_key = '$originWriter[0]',
			sender_key = '$sessionNo',
			subject = '$subject',
			content = '$content',
			signdate = '$thisTime',
			is_view = '0'";
			@mysql_query($sendMemoQue);
		}
	}
}
// 완료 처리
// 카테고리 선택 후, 자동선택 설정 | 2010-02-07 Coder PicoZ , Editor 이동규
$GR->move('board.php?id='.$id.'&articleNo='.$articleNo.'&commentPage='.$_POST['commentPage'].'&page='.$page.'&clickCategory='.$clickCategory);
?>