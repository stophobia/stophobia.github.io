<?php
// 클래스 초기화
include 'class/common.php';
$GR = new COMMON;
include 'class/blog.php';
$BLOG = new BLOG;

// 허용한 태그를 제외한 나머지 태그 제거 함수
function strip_tags2($text, $tags) {
	$allowedTags = explode(',', $tags);
	preg_match_all('!<\s*(/)?\s*([a-zA-Z]+)[^>]*>!', $text, $allTags);
	array_shift($allTags);
	$slashes = $allTags[0];
	$allTags = $allTags[1];
	foreach ($allTags as $i => $tag) {
		if (in_array($tag, $allowedTags)) continue;
		$text = preg_replace('!<(\s*'.$slashes[$i].'\s*'.$tag.'[^>]*)>!', '&lt;$1&gt;', $text);
	}
	return $text;
}

// 불법적인 글쓰기는 아닌가 체크
if(!eregi($_SERVER['HTTP_HOST'], $_SERVER['HTTP_REFERER']) && !$_GET['openid_mode'] && ($_GET['openid_mode'] != 'id_res')) 
	$GR->error('정상적인 방법으로 게시물을 작성해 주세요.', 1);

// 변수 처리 1 - 비회원 / 회원
$ip = $_SERVER['REMOTE_ADDR'];
if(array_key_exists('id', $_POST) && $_POST['id']) $id = $_POST['id']; else $id = $_GET['id'];
if(array_key_exists('articleNo', $_POST) && $_POST['articleNo']) $articleNo = $_POST['articleNo'];
if(array_key_exists('mode', $_POST) && $_POST['mode']) $mode = $_POST['mode'];
if(array_key_exists('page', $_POST) && $_POST['page']) $page = $_POST['page'];
if(array_key_exists('is_secret', $_POST) && $_POST['is_secret']) $isSecret = $_POST['is_secret'];
if(array_key_exists('is_notice', $_POST) && $_POST['is_notice']) $isNotice = $_POST['is_notice'];
if(array_key_exists('is_grcode', $_POST) && $_POST['is_grcode']) $isGrcode = $_POST['is_grcode'];
if(array_key_exists('inputType', $_POST) && $_POST['inputType']) $isOpenid = (($_POST['inputType']==2)?true:false);
if(array_key_exists('openid_url', $_POST) && $_POST['openid_url']) $openid_url = $_POST['openid_url'];
if(array_key_exists('password', $_POST) && $_POST['password']) $password = $_POST['password'];
if(array_key_exists('name', $_POST) && $_POST['name']) $name = addslashes(htmlspecialchars(trim($_POST['name'])));
if(array_key_exists('category', $_POST) && $_POST['category']) $category = $_POST['category'];
if(array_key_exists('subject', $_POST) && $_POST['subject']) $subject = $_POST['subject'];
if(array_key_exists('content', $_POST) && $_POST['content']) $content = $_POST['content'];
if(array_key_exists('email', $_POST) && $_POST['email']) $email = $_POST['email'];
if(array_key_exists('homepage', $_POST) && $_POST['homepage']) $homepage = $_POST['homepage'];
if(array_key_exists('link1', $_POST) && $_POST['link1']) $link1 = $_POST['link1'];
if(array_key_exists('link2', $_POST) && $_POST['link2']) $link2 = $_POST['link2'];
if(array_key_exists('is_alert', $_POST) && $_POST['is_alert']) $isAlert = $_POST['is_alert'];
if(array_key_exists('is_timebomb', $_POST) && $_POST['is_timebomb']) $isTimeBomb = $_POST['is_timebomb'];
if(array_key_exists('bombTime', $_POST) && $_POST['bombTime']) $bombTime = $_POST['bombTime'];
if(array_key_exists('bombTerm', $_POST) && $_POST['bombTerm']) $bombTerm = $_POST['bombTerm'];
if(array_key_exists('tag', $_POST) && $_POST['tag']) $tag = htmlspecialchars(str_replace(' ', '', trim($_POST['tag'])));
if(array_key_exists('deleteExtendPds', $_POST) && $_POST['deleteExtendPds']) $deleteExtendPds = $_POST['deleteExtendPds'];
if(array_key_exists('option_reply_open', $_POST) && $_POST['option_reply_open']) $optionReplyOpen = $_POST['option_reply_open'];
if(array_key_exists('option_reply_notify', $_POST) && $_POST['option_reply_notify']) $optionReplyNotify = $_POST['option_reply_notify'];
if(array_key_exists('clickCategory', $_POST) && $_POST['clickCategory']) $clickCategory = $_POST['clickCategory']; // 카테고리 선택 후, 글쓰기 할때 자동선택 설정 | 2010-02-07 Coder PicoZ , Editor 이동규
$grboard = str_replace('/'.end(explode('/', $_SERVER['REQUEST_URI'])), '', $_SERVER['REQUEST_URI']);

// DB 에 연결한다.
$GR->dbConn();

// 게시판 설정 가져오기
$tmpFetchBoard = @mysql_fetch_array(mysql_query("select * from {$dbFIX}board_list where id = '$id'"));

// 테마(스킨)에 있는 글쓰기 처리부터 인클루드
@include 'theme/'.$tmpFetchBoard['theme'].'/theme_write_ok.php';
if(!$addExtendFieldQuery) $addExtendFieldQuery = '';

// 트랙백
if(array_key_exists('trackback', $_POST) && $_POST['trackback']) {
	$trackback = $_POST['trackback'];
	$trackbackPattern = '(http|https)://([0-9a-zA-Z./@~?&=_]+)';
	if(!ereg($trackbackPattern, $trackback)) $trackback = '올바른 트랙백 형식이 아닙니다. URL 형식으로 적어주세요.';
} else $trackback = '';

// 글쓴이 권한값 가져오기
if($_SESSION['no']) {
	$sessionNo = $_SESSION['no'];
	$getMemberInfo = @mysql_query("select id, nickname, password, email, homepage, level from {$dbFIX}member_list where no = '$sessionNo'");
	$tmpFetch = @mysql_fetch_array($getMemberInfo) or $GR->error('기본정보를 가져와서 처리하는 도중 문제가 발생했습니다.');
	$writerLevel = $tmpFetch['level'];
	if($_SESSION['no'] == 1) $isAdmin = 1; else $isAdmin = 0;
	$isMember = 1;
	$isMaster = false;
	$isGroupAdmin = false;
	$getMasters = @mysql_fetch_array(mysql_query('select master, group_no from '.$dbFIX.'board_list where id = \''.$id.'\''));

	// 게시판 관리자
	if($getMasters[0]) {
		$masterArr = explode('|', $getMasters[0]);
		$masterNum = count($masterArr);
		for($m=0; $m<$masterNum; $m++) {
			if($_SESSION['mId'] && ($_SESSION['mId'] == $masterArr[$m])) {
				$isAdmin = 1;
				$isMaster = 1;
				break;
			}
		}
	}

	// 그룹 관리자
	if($getMasters[1]) {
		$getGroupMaster = @mysql_fetch_array(mysql_query('select master from '.$dbFIX.'group_list where no = '.$getMasters[1]));
		$groupMaster = explode('|', $getGroupMaster[0]);
		$cntResult = count($groupMaster);
		for($g=0; $g<$cntResult; $g++) {
			if($_SESSION['mId'] && ($_SESSION['mId'] == $groupMaster[$g])) {
				$isAdmin = 1;
				$isGroupAdmin = 1;
				break;
			}
		}
	}

	$name = $tmpFetch['nickname'];
	$password = $tmpFetch['password'];
	$email = $tmpFetch['email'];
	$homepage = $tmpFetch['homepage'];
}
// 비회원 글쓰기시 처리
else {
	$sessionNo = 0;
	$tPass = @mysql_fetch_array(mysql_query("select password('$password')"));
	$password = $tPass[0];
	$writerLevel = 1;
	$isAdmin = 0;
	$isMember = 0;
	$isMaster = 0;

	// 오픈아이디일 경우 쿠키에 임시로 저장된 값 처리
	if($_COOKIE['tmpSubject']) $subject = $_COOKIE['tmpSubject'];
	if($_COOKIE['tmpContent']) $content = $_COOKIE['tmpContent'];
	if($_COOKIE['tmpCategory']) $category = $_COOKIE['tmpCategory'];
	if($_COOKIE['tmpTag']) $tag = $_COOKIE['tmpTag'];
	if($_COOKIE['tmpLink1']) $link1 = $_COOKIE['tmpLink1'];
	if($_COOKIE['tmpLink2']) $link2 = $_COOKIE['tmpLink2'];

	// 오픈아이디 (처음) 처리 시작
	if($tmpFetchBoard['is_openid'] && !$_SESSION['openID']) {

		// 처음 오픈아이디 주소가 들어온 후 인증 과정
		if($openid_url) {
			include 'openid/class.openid.php';
			$openid = new SimpleOpenID;
			$openid->SetIdentity($openid_url);
			$openid->SetTrustRoot('http://' . $_SERVER["HTTP_HOST"]);
			$openid->SetRequiredFields(array('nickname'));
			$openid->SetOptionalFields(array('email'));

			// 인증을 받은 후 임시로 브라우저 쿠키에 값들 저장
			if ($openid->GetOpenIDServer()) {
				$saveTerm = $GR->grTime()+60;
				@setcookie('tmpSubject', $subject, $saveTerm);
				@setcookie('tmpContent', $content, $saveTerm);
				@setcookie('tmpCategory', $category, $saveTerm);
				@setcookie('tmpTag', $tag, $saveTerm);
				@setcookie('tmpLink1', $link1, $saveTerm);
				@setcookie('tmpLink2', $link2, $saveTerm);
				$openid->SetApprovedURL('http://' . $_SERVER["HTTP_HOST"] . $_SERVER["PHP_SELF"].'?id='.$id.'&modifyTarget='.$modifyTarget.'&replyTarget='.$replyTarget);
				$openid->Redirect();
			
			// 인증을 못받았다면 에러 처리
			} else {
				$error = $openid->GetError();
				echo "오류코드: " . $error['code'] . "<br />";
				echo "오류설명: " . $error['description'] . '<br /> <a href="board.php?id='.$id.'">[게시판으로 돌아가기 (클릭!)]</a>';
			}
			exit();
		
		// 인증 처리 후 이 곳으로 다시 리다이렉션 되서 이후 세션 처리
		} else if($_GET['openid_mode'] == 'id_res') {
			include 'openid/class.openid.php';
			$openid = new SimpleOpenID;
			$openid->SetIdentity($_GET['openid_identity']);
			$openid_validation_result = $openid->ValidateWithServer();

			// 인증이 완료된 후 값들 저장 & 세션 생성
			if ($openid_validation_result == true) {
				$name = $_GET['openid_sreg_nickname'];
				$email = $_GET['openid_sreg_email'];
				$homepage = $_GET['openid_identity'];
				$password = substr(md5($GR->grTime()), -7);
				$_SESSION['openID'] = $_GET['openid_identity'];
				$_SESSION['openIDName'] = $_GET['openid_sreg_nickname'];
				$_SESSION['openIDEmail'] = $_GET['openid_sreg_email'];
			
			// 에러 처리
			} else if($openid->IsError() == true) {
				$error = $openid->GetError();
				echo "오류코드: " . $error['code'] . "<br />";
				echo "오류설명: " . $error['description'] . '<br /> <a href="board.php?id='.$id.'">[게시판으로 돌아가기 (클릭!)]</a>';
			} else {
				echo "유효하지 않은 인증입니다.";
			}
		
		// 사용자가 취소 했을시 처리
		} else if ($_GET['openid_mode'] == 'cancel'){
			echo "사용자가 요청을 취소하였습니다.";
		}
	}
	
	// 일반적인 입력일 경우 처리
	else {
		if(!$name && $_SESSION['openIDName']) $name = htmlspecialchars($_SESSION['openIDName']);
		if(!$email && $_SESSION['openIDEmail']) $email = $_SESSION['openIDEmail'];
		if(!$homepage && $_SESSION['openID']) $homepage = $_SESSION['openID'];
		if(!$password && $_SESSION['openID']) $password = substr(md5($GR->grTime()), -7);

		if(!$name) $GR->error('이름을 입력해 주세요', 0, 'HISTORY_BACK');
		if(!$password) $GR->error('비밀번호를 입력해 주세요', 0, 'HISTORY_BACK');
		if(!$subject) $GR->error('제목을 입력해 주세요', 0, 'HISTORY_BACK');
		if(!$content) $GR->error('내용을 입력해 주세요', 0, 'HISTORY_BACK');
		if(!$_SESSION['openID'] && !$_POST['openid'] && !$_GET['openid_mode'] && ($_GET['openid_mode'] != 'id_res') &&
			(!$_SESSION['antiSpam'] || !$_POST['antispam'] || $_SESSION['antiSpam'] != $_POST['antispam']))
			$GR->error('자동입력방지 답이 올바르지 않습니다', 0, 'HISTORY_BACK');
	}
}

// 입력값 재검증 (오픈아이디 미지원 서버 위해서)
if(!$name) $GR->error('이름을 입력해 주세요.', 0, 'HISTORY_BACK');
if(!$subject) $GR->error('제목을 입력해 주세요.', 0, 'HISTORY_BACK');
if(!$content) $GR->error('내용을 입력해 주세요.', 0, 'HISTORY_BACK');

// 본문 변형 처리
$content = str_replace(array('<img id="player-box-', '<img id=\"player-box-'), '<div id="player-layout"></div><img title="플레이어" id="player-box-', $content);
$content = str_replace('<p>', '', str_replace('</p>', '', str_replace('<p>&nbsp;</p>', '', $content)));
$content = preg_replace('/<p(.*?)>/i', '', $content);
$content = str_replace(array("<ul>\r\n", "<ol>\r\n", "</ul>\r\n", "</ol>\r\n", "</li>\r\n", "<br />\r\n"), array('<ul>', '<ol>', '</ul>', '</ol>', '</li>', '<br />'), $content);
$content = str_replace(array("<ul>\n", "<ol>\n", "</ul>\n", "</ol>\n", "</li>\n", "<br />\n"), array('<ul>', '<ol>', '</ul>', '</ol>', '</li>', '<br />'), $content);
$content = str_replace('src=\"http://'.$_SERVER['HTTP_HOST'].$grboard.'/', 'src=\"', $content);
$content = str_replace('src="http://'.$_SERVER['HTTP_HOST'].$grboard.'/', 'src="', $content);

// 변수 처리 2 - 관리자, 마스터 / 멤버, 비회원
if($isAdmin || $isMaster) {
	$subject = addslashes(trim($subject));
	$content = trim($content);
	$content = str_replace("\t", '&nbsp;&nbsp;&nbsp;&nbsp;', $content);
	$content = addslashes($content);
} else {
	$allowTags = @mysql_fetch_array(mysql_query('select is_html from '.$dbFIX.'board_list where id = \''.$id.'\''));
	$subject = addslashes(trim(htmlspecialchars($subject)));
	$content = trim($content);
	$content = str_replace("\t", '&nbsp;&nbsp;&nbsp;&nbsp;', $content);
	$content = addslashes($content);
	$content = strip_tags2($content, $allowTags[0]);
	$filterText = @file_get_contents('filter.txt');
	$filterArray = explode(',', $filterText);
	$filterNum = count($filterArray);
	for($tf=0; $tf<$filterNum; $tf++) {
		if(eregi($filterArray[$tf], $subject)) $GR->error('글제목에 필터링 대상 단어가 있습니다 : '.$filterArray[$tf], 1, 'HISTORY_BACK');
		if(eregi($filterArray[$tf], $content)) $GR->error('글내용에 필터링 대상 단어가 있습니다 : '.$filterArray[$tf], 1, 'HISTORY_BACK');
	}
}
$saveFileDir = 'data/'.$id; # 파일 저장위치

// 현재 게시판의 접근권한을 확인한다.
$isWriteOk = @mysql_fetch_array(mysql_query("select write_level from {$dbFIX}board_list where id = '$id'"));
if(!$isAdmin && !$isMaster && ($writerLevel < $isWriteOk['write_level'])) $GR->error('글쓰기 권한이 없습니다.', 0, 'board.php?id='.$id);

// 파일 업로드 처리 (추가 업로드 포함)
$fCount = 0;
$feCnt = 0;
$saveFile = array();
$saveExtendFile = array();
$fnameSave = array();
$fnameExtend = array();
$fnameTemp = '';
$isImageFile = false;
while(list($fKey, $fValue) = each($_FILES)) {
	$filename = strtolower($fValue['name']);
	$filetype = $fValue['type'];
	$filesize = $fValue['size'];
	$filetmpname = $fValue['tmp_name'];
	if(strpos('fileExtend', $fKey) === true) $isExtendFile = true; 
	else $isExtendFile = false;
	if($filesize > 0) {
		if(!is_dir($saveFileDir)) {
			@mkdir($saveFileDir, 0705);
			@chmod($saveFileDir, 0707);
		}
		if(!is_uploaded_file($filetmpname)) $GR->error('정상적으로 파일을 업로드 해 주세요.', 0, 'HISTORY_BACK');
		if(preg_match('/\.(inc|phtm|htm|shtm|ztx|php|dot|asp|cgi|pl|js|sql|sh|py|htaccess|jsp)/i', $filename))
			$GR->error('HTML, Server side script 관련 파일은 업로드 하실 수 없습니다.', 1, 'HISTORY_BACK');
		$filetmpname = str_replace('\\\\', '\\', $filetmpname);
		$filename = str_replace(' ', '_', $filename);
		$fnameTemp = $filename;
		if(!preg_match('/\.(jpg|jpeg|bmp|gif|png)$/i', $filename)) {
			$filename = md5($GR->grTime().'GRBOARD'.$filename);
			$isImageFile = false;
		} else {
			$ext = end(explode('.', $filename));
			$filename = md5($filename).'.'.$ext;
			$isImageFile = true;
		}
		if(file_exists($saveFileDir.'/'.$filename)) $savePos = $saveFileDir.'/'.substr(md5($GR->grTime()), -3).'_'.$filename;
		else $savePos = $saveFileDir.'/'.$filename;
		if($isExtendFile) {
			$saveExtendFile[$feCnt] = $savePos;
			if(!$isImageFile) $fnameExtend[$feCnt] = $saveFileDir.'/'.$fnameTemp;
		} else {
			$saveFile[$fCount] = $savePos;
			if(!$isImageFile) $fnameSave[$fCount] = $saveFileDir.'/'.$fnameTemp;
		}
		if(!move_uploaded_file($filetmpname, $savePos)) $GR->error('파일을 업로드 하지 못했습니다. 파일용량을 확인해 보세요.', 0, 'HISTORY_BACK');
		$isUploadEnd = 1;	
		if($isExtendFile) $feCnt++; else $fCount++;
	}
}

// 통합 태그 처리
if($tag) {
	$arrTags = @explode(',', $tag);
	$arrTagNum = @count($arrTags);
	for($ti=0; $ti<$arrTagNum; $ti++) {
		if(!$arrTags[$ti]) continue;
		$isExistTag = @mysql_fetch_array(mysql_query('select no from '.$dbFIX.'tag_list where id = \''.$id.'\' and tag = \''.$arrTags[$ti].'\' limit 1'));
		if($isExistTag['no']) @mysql_query('update '.$dbFIX.'tag_list set count = count + 1 where no = '.$isExistTag['no']);
		else @mysql_query('insert into '.$dbFIX."tag_list set no = '', id = '$id', tag = '".$arrTags[$ti]."', count = 0");
	}
}

// 수정글일 경우 먼저 처리
if(isset($mode) && $articleNo) {
	for($df=1; $df<11; $df++) {
		if(array_key_exists('delete'.$df, $_POST) && $_POST['delete'.$df]) { 
			@unlink($_POST['delete'.$df]); 
			@mysql_query("update {$dbFIX}pds_save set file_route{$df} = '' where id = '$id' and article_num = '$articleNo'"); 
			$getPdsSave = @mysql_fetch_array(mysql_query('select no from '.$dbFIX.'pds_save where id = \''.$id.'\' and article_num = '.$articleNo));
			@mysql_query('delete from '.$dbFIX.'pds_list where type = 0 and uid = '.$getPdsSave['no'].' and idx = '.($df-1).' limit 1');
		}
	}

	if(!$isAdmin && !$isMaster) {
		$getOldPassword = @mysql_query("select member_key, password from {$dbFIX}bbs_{$id} where no = '$articleNo'") or 
			$GR->error("기존 게시물의 암호정보를 가져오는데 실패했습니다.", 0, 'board.php?id='.$id);
		$oldPassword = @mysql_fetch_array($getOldPassword);
		if(($oldPassword['member_key'] != $_SESSION['no']) && ($oldPassword['password'] != $password)) $GR->error('비밀번호가 맞지 않습니다.', 0, 'HISTORY_BACK');
	}

	$old = @mysql_fetch_array(mysql_query("select member_key, name, email, homepage, ip, signdate, bad from {$dbFIX}bbs_{$id} where no = '$articleNo'"));

	// 글 수정시 이름, 홈페이지, 이메일 수정되게 하기 by 좋아
	if(!$isMember || ($sessionNo == $old['member_key'])){
		$oldName = $name;
		$oldEmail = $email;
		$oldHomepage = $homepage;
		$oldIp = $ip;
	} else {
		$oldName = $old['name'];
		$oldEmail = $old['email'];
		$oldHomepage = $old['homepage'];
		$oldIp = $old['ip'];
	}
	$oldSigndate = $old['signdate'];
	if($old['bad'] > -1000) $bad = ($isAlert) ? -99 : 0; else $bad = -1001;
	$is_history = @mysql_query("select is_history from {$dbFIX}board_list where id = '{$id}'");
	if($is_history=='1') $content .= '<br /><span class="modifyTime">modified at '.date('Y.m.d H:i:s', $GR->grTime()).' by '.(($isAdmin)?'moderator':$name).'</span>';;
	$sqlUpdateQue = "update {$dbFIX}bbs_{$id}
		set name = '$oldName',
		email = '$oldEmail',
		homepage = '$oldHomepage',
		ip = '$oldIp',
		signdate = '$oldSigndate',
		bad = '$bad',
		is_notice = '$isNotice',
		is_secret = '$isSecret',
		is_grcode = '$isGrcode',
		category = '$category',
		subject = '$subject',
		content = '$content',
		link1 = '$link1',
		link2 = '$link2',
		trackback = '$trackback',
		tag = '$tag'
		$addExtendFieldQuery
		where no = '$articleNo'";
	@mysql_query($sqlUpdateQue);
	$getArticleOption = @mysql_fetch_array(mysql_query("select no from {$dbFIX}article_option where id = '$id' and article_num = '$articleNo'"));
	if(!$getArticleOption) @mysql_query("insert into {$dbFIX}article_option set no = '', article_num = '$articleNo', id = '$id', reply_open = '$optionReplyOpen', reply_notify = '$optionReplyNotify'");
	else @mysql_query("update {$dbFIX}article_option set reply_open = '$optionReplyOpen', reply_notify = '$optionReplyNotify' where id = '$id' and article_num = '$articleNo'");
	$isAlreadyFiles = @mysql_fetch_array(mysql_query("select * from {$dbFIX}pds_save where id = '$id' and article_num = '$articleNo'"));
	if($isAlreadyFiles['no']) $isUploaded = 1; else $isUploaded = 0;
	if($isUploadEnd) {

		// 업로드 수정글일 때
		if($isUploaded) {
			$sqlUploadUpdate = 'update '.$dbFIX.'pds_save set ';
			$loopUp = 1;
			for($t=1; $t<10; $t++) {
				if(!$_FILES['file'.$t]['name']) $loopUp++;
				else break;
			}
			for($tmp=0; $tmp<10; $tmp++) {
				if($saveFile[$tmp]) $sqlUploadUpdate .= 'file_route'.($tmp+$loopUp)." = '".$saveFile[$tmp]."',";
			}
			$sqlUploadUpdate = substr($sqlUploadUpdate, 0, -1);
			$sqlUploadUpdate .= " where id = '$id' and article_num = '$articleNo'";
			@mysql_query($sqlUploadUpdate);

			$getPdsSave = @mysql_fetch_array(mysql_query('select no from '.$dbFIX.'pds_save where id = \''.$id.'\' and article_num = '.$articleNo));
			for($m=0; $m<10; $m++) {
				if($fnameSave[$m]) {
					@mysql_query('insert into '.$dbFIX.'pds_list set no = \'\', type = 0, uid = '.$getPdsSave['no'].', idx = '.($m+$loopUp-1).', name = \''.$fnameSave[$m].'\'');
				}
			}

		// 신규 업로드일 때
		} else {
			$sqlUploadInsert = "insert into {$dbFIX}pds_save
				set no = '', id = '$id', article_num = '$articleNo',
					file_route1 = '$saveFile[0]',
					file_route2 = '$saveFile[1]',
					file_route3 = '$saveFile[2]',
					file_route4 = '$saveFile[3]',
					file_route5 = '$saveFile[4]',
					file_route6 = '$saveFile[5]',
					file_route7 = '$saveFile[6]',
					file_route8 = '$saveFile[7]',
					file_route9 = '$saveFile[8]',
					file_route10 = '$saveFile[9]', hit = '0'";
			@mysql_query($sqlUploadInsert);
			
			$upInsertID = @mysql_insert_id();
			for($i=0; $i<10; $i++) {
				if($fnameSave[$i]) {
					@mysql_query('insert into '.$dbFIX.'pds_list set no = \'\', type = 0, uid = '.$upInsertID.', idx = '.$i.', name = \''.$fnameSave[$i].'\'');
				}
			}
		}
	}
}
// 신규 게시물일 경우 처리
else {
	$getLastArticle = @mysql_query("select ip, signdate from {$dbFIX}bbs_{$id} order by no desc limit 1");
	$lastArticle = @mysql_fetch_array($getLastArticle);
	if($lastArticle['ip'] && !$isAdmin && !$isMaster && ($GR->grTime()-30 < $lastArticle['signdate']) && ($ip == $lastArticle['ip'])) 
		$GR->error('너무 빠른 시간에 게시물을 연속해서 올리실 수 없습니다.', 1, 'HISTORY_BACK'); 
	$thisTime = $GR->grTime();
	$bad = ($isAlert) ? -99 : 0;
	$sqlInsertQue = "insert into {$dbFIX}bbs_{$id}
		set no = '',
			member_key = '$sessionNo',
			name = '$name',
			password = '$password',
			email = '$email',
			homepage = '$homepage',
			ip = '$ip',
			signdate = '$thisTime',
			hit = '0',
			good = '0',
			bad = '$bad',
			comment_count = '0',
			is_notice = '$isNotice',
			is_secret = '$isSecret',
			is_grcode = '$isGrcode',
			category = '$category',
			subject = '$subject',
			content = '$content',
			link1 = '$link1',
			link2 = '$link2',
			trackback = '$trackback',
			tag = '$tag'
			$addExtendFieldQuery";
	@mysql_query($sqlInsertQue);
	$insertNo = @mysql_insert_id();
	if(!$optionReplyOpen || !$optionReplyNotify) {
		@mysql_query("insert into {$dbFIX}article_option set no = '', article_num = '$insertNo', id = '$id', reply_open = '$optionReplyOpen', reply_notify = '$optionReplyNotify'");
	}
	$sqlTotalQue = "insert into {$dbFIX}total_article
		set no = '',
			subject = '$subject',
			id = '$id',
			article_num = '$insertNo',
			signdate = '$thisTime',
			is_secret = '$isSecret'";
	@mysql_query($sqlTotalQue);

	if($isUploadEnd) {
		$sqlUploadInsert = "insert into {$dbFIX}pds_save
			set no = '',
				id = '$id',
				article_num = '$insertNo',
				file_route1 = '$saveFile[0]',
				file_route2 = '$saveFile[1]',
				file_route3 = '$saveFile[2]',
				file_route4 = '$saveFile[3]',
				file_route5 = '$saveFile[4]',
				file_route6 = '$saveFile[5]',
				file_route7 = '$saveFile[6]',
				file_route8 = '$saveFile[7]',
				file_route9 = '$saveFile[8]',
				file_route10 = '$saveFile[9]',
				hit = '0'";
		@mysql_query($sqlUploadInsert);

		$upInsertID = @mysql_insert_id();
		for($i=0; $i<10; $i++) {
			if($fnameSave[$i]) {
				@mysql_query('insert into '.$dbFIX.'pds_list set no = \'\', type = 0, uid = '.$upInsertID.', idx = '.$i.', name = \''.$fnameSave[$i].'\'');
			}
		}
	}

	if($isMember) {
		@mysql_query("update {$dbFIX}member_list set point = point + 2 where no = '$sessionNo'");
	}

	if($trackback) {
		$path = str_replace('/write_ok.php', '', $_SERVER['SCRIPT_NAME']);
		$tArr = explode('/', $path);
		$grboard = $tArr[count($tArr)-1];
		$url = 'http://'.$_SERVER['HTTP_HOST'].'/'.$grboard.'/board.php?id='.$id.'&articleNo='.$insertNo;
		$resultSendTrackback = $BLOG->sendTrackback($trackback, $url, $name, $subject, $content);
		if($resultSendTrackback) $GR->error('트랙백을 보내는데 실패했습니다 :'.$resultSendTrackback, 0, 'board.php?id='.$id);
	}
}

// 삭제 체크된 것들 먼저 처리
if(is_array($deleteExtendPds)) {
	$delExtCnt = @count($deleteExtendPds);
	for($de=0; $de<$delExtCnt; $de++) {
		$getDeleteTarget = @mysql_fetch_array(mysql_query('select file_route from '.$dbFIX.'pds_extend where no = '.$deleteExtendPds[$de]));
		@mysql_query('delete from '.$dbFIX.'pds_extend where no = '.$deleteExtendPds[$de].' limit 1');
		@unlink($getDeleteTarget['file_route']);
		@mysql_query('delete from '.$dbFIX.'pds_list where type = 1 and uid = '.$deleteExtendPds[$de].' limit 1');
	}
}

// 추가 업로드된 파일 DB저장
if($isExtendFile) {
	$feCnt++;
	$setArticleNum = ($articleNo) ? $articleNo : $insertNo;
	for($eu=0; $eu<$feCnt; $eu++) {
		if($saveExtendFile[$eu]) {
			@mysql_query('insert into '.$dbFIX."pds_extend set no = '', id = '$id', article_num = '$setArticleNum', file_route = '".$saveExtendFile[$eu]."'");
			$getExtendInsertID = @mysql_insert_id();
			if($fnameExtend[$eu]) {
				@mysql_query('insert into '.$dbFIX.'pds_list set no = \'\', type = 1, uid = '.$getExtendInsertID.', idx = 0, name = \''.$fnameExtend[$eu].'\'');
			}
		}
	}
}

// 멀티업로드 (swfupload) 파일 발견시 처리
$tmp = 'data/tmpfile.'.$ip;
$isImageFile = false;
if(file_exists($tmp)) {
	$multi = @file_get_contents($tmp);
	$listArr = @explode("\n", $multi);
	$listCnt = @count($listArr)-1;
	$setArticleNum = ($articleNo) ? $articleNo : $insertNo;
	for($m=0; $m<$listCnt; $m++) {
		$lsArr = @explode('__GRBOARD__', $listArr[$m]);
		if(!preg_match('/\.(jpg|jpeg|bmp|gif|png)$/i', $lsArr[1])) {
			$swFilename = end(explode('/', $lsArr[0]));
			$newFilename = 'data/'.$id.'/'.md5($GR->grTime().'GRBOARD'.$swFilename);
			@rename($lsArr[0], $newFilename);
			$isImageFile = false;
		} else {
			$newFilename = $lsArr[1];
			$isImageFile = true;
		}
		@mysql_query('insert into '.$dbFIX."pds_extend set no = '', id = '$id', article_num = '$setArticleNum', file_route = '".$newFilename."'");
		$getExistInsertID = @mysql_insert_id();
		if(!$isImageFile) @mysql_query('insert into '.$dbFIX.'pds_list set no = \'\', type = 1, uid = '.$getExistInsertID.', idx = 0, name = \''.$lsArr[1].'\'');
	}
	@unlink($tmp);
}

// 자동폭파 사용시 세팅
if($tmpFetchBoard['is_bomb'] && $isTimeBomb) {
	$bombSetTime = $GR->grTime() + ($bombTime * $bombTerm);
	@mysql_query("insert into {$dbFIX}time_bomb set no = '', id = '$id', article_num = '".(($insertNo)?$insertNo:$articleNo)."', set_time = '$bombSetTime'");
}

// 신고된 게시물을 관리자가 수정했다면
if($_POST['isReported'] && ($_SESSION['no'] == 1)) {
	@mysql_query("update {$dbFIX}report set status = 1 where no = ".$_POST['isReported']);
	$GR->error('신고된 게시물을 수정하였습니다.', 0, 'CLOSE');
}

// 글쓰기를 완료하고 나서 목록보기로 페이지 이동
// 카테고리 선택 후, 자동선택 설정 | 2010-02-07 Coder PicoZ , Editor 이동규
if($mode) $GR->move('board.php?id='.$id.'&articleNo='.$articleNo.'&page='.$page.'&clickCategory='.$clickCategory);
else $GR->move('board.php?id='.$id.'&articleNo='.$insertNo.'&page='.$page.'&clickCategory='.$clickCategory);
?>