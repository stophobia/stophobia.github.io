<?php
// 초기화
$prefix = '../';
include $prefix.'lib/common.php';
include $prefix.'php_head.php';
dbConn($prefix);

// 댓글 삭제시 처리
if($_GET['deleteComment'] && ($_SESSION['no'] || ($_SESSION['user_no'] && ($_SESSION['user_no'] == $co['member_key'])))) {
	@mysql_query('delete from '.$dbFIX.'memo_comment where uid = '.$_GET['deleteComment']);
	error('댓글을 삭제했습니다.', 'location.href=\'./\'');
}

// 글 삭제시 처리
if($_GET['deletePost'] && ($_SESSION['no'] || ($_SESSION['user_no'] && ($_SESSION['user_no'] == $co['member_key'])))) {
	@mysql_query('delete from '.$dbFIX.'memo_post where uid = '.$_GET['deletePost']);
	error('메모를 삭제했습니다.', 'location.href=\'./\'');
}

// 메모 등록시 처리
if($_POST['writeMemo'] && trim($_POST['content'])) {
	$content = addslashes($_POST['content']);
	if($_SESSION['no']) {
		$key = 0;
		$name = @mysql_fetch_array(mysql_query('select name from '.$dbFIX.'config where uid = 1'));
	} else {
		$key = $_SESSION['user_no'];
		$name = @mysql_fetch_array(mysql_query('select nickname from '.$dbFIX.'user where uid = '.$_SESSION['user_no']));
	}
	@mysql_query("insert into {$dbFIX}memo_post set uid = '', member_key = '$key', name = '$name[0]', content = '$content', signdate = '".time()."'");
	error('메모를 입력했습니다.', 'location.href=\'./\'');
}

// 메모에 댓글 작성시 처리
if(($_POST['writeComment'] && trim($_POST['content'])) || $_GET['authByOpenid'] || $_GET['openid_mode'] == 'id_res') {
	$content = addslashes(htmlspecialchars($_POST['content']));
	if($_SESSION['no']) {
		$key = 0;
		$name = @mysql_fetch_array(mysql_query('select name from '.$dbFIX.'config where uid = 1'));
		@mysql_query("insert into {$dbFIX}memo_comment set uid = '', post_num = '".$_POST['post_num']."', member_key = '$key', name = '$name[0]', content = '$content', ip = '".$_SERVER['REMOTE_ADDR']."', signdate = '".time()."'");
	} elseif($_SESSION['user_no']) { 
		$key = $_SESSION['user_no'];
		$name = @mysql_fetch_array(mysql_query('select nickname from '.$dbFIX.'user where uid = '.$_SESSION['user_no']));
		@mysql_query("insert into {$dbFIX}memo_comment set uid = '', post_num = '".$_POST['post_num']."', member_key = '$key', name = '$name[0]', content = '$content', ip = '".$_SERVER['REMOTE_ADDR']."', signdate = '".time()."'");
	} elseif($_POST['openid'] || $_GET['openid_mode'] == 'id_res') {
		$key = 0;
		if(!$openid_url) $openid_url = $_POST['openid'];
		if ($openid_url && !$_SESSION['openID'])
		{
			include $prefix.'openid/class.openid.php';
			$openid = new SimpleOpenID;
			$openid->SetIdentity($openid_url);
			$openid->SetTrustRoot('http://' . $_SERVER["HTTP_HOST"]);
			$openid->SetRequiredFields(array('nickname'));
			$openid->SetOptionalFields(array('email'));
			if ($openid->GetOpenIDServer()) {
				@setcookie('tmpContent', $content, time()+600);
				$openid->SetApprovedURL('http://' . $_SERVER["HTTP_HOST"] . $_SERVER["PHP_SELF"].'?authByOpenid=1');
				$openid->Redirect();
			} else {
				$error = $openid->GetError();
				echo "문제발생: " . $error['code'] . '<br />';
				echo "오류내용: " . $error['description'] . '<br />';
			}
			exit();
		}
		else if($_GET['openid_mode'] == 'id_res' && !$_SESSION['openID'])
		{
			include $prefix.'openid/class.openid.php';
			$openid = new SimpleOpenID;
			$openid->SetIdentity($_GET['openid_identity']);
			$openid_validation_result = $openid->ValidateWithServer();
			if ($openid_validation_result == true) {
				$name = $_GET['openid_sreg_nickname'];
				$content = $_COOKIE['tmpContent'];
				$_SESSION['openID'] = $_GET['openid_identity'];
				$_SESSION['openIDName'] = $_GET['openid_sreg_nickname'];
			}else if($openid->IsError() == true){
				$error = $openid->GetError();
				echo "문제발생: " . $error['code'] . '<br />';
				echo "오류내용: " . $error['description'] . '<br />';
			} else {
				echo '유효하지 않은 인증입니다.';
			}
		} else if ($_GET['openid_mode'] == 'cancel' && !$_SESSION['openID']){
			echo "USER CANCELED REQUEST";
		} else if ($_SESSION['openID']) {
			$name = $_SESSION['openIDName'];
			$openid_url = $_SESSION['openID'];
		}
		@mysql_query("insert into {$dbFIX}memo_comment set uid = '', post_num = '".$_POST['post_num']."', member_key = '$key', name = '$name', content = '$content', ip = '".$_SERVER['REMOTE_ADDR']."', signdate = '".time()."'");
	} else error('로그인을 하지 않았거나, 오픈아이디가 정상적이지 않습니다.', 'location.href=\'./\'');
	error('댓글을 입력했습니다. 고맙습니다~ ^^', 'location.href=\'./\'');
}

// 모노로그 설정 가져오기
$getMemoConfig = @mysql_query('select * from '.$dbFIX.'memo_config');
while($conf = @mysql_fetch_array($getMemoConfig, MYSQL_ASSOC)) {
	$mono[$conf['opt']] = $conf['value'];
}

// 테마 부르기
if($_GET['prevDay']) $prevDay = $_GET['prevDay']; else $prevDay = 0;
if($_GET['nextDay']) $nextDay = $_GET['nextDay']; else $nextDay = 0;
$path = 'theme/'.$mono['theme'];
$time = time() - (86400 * $prevDay);
$termDayStart = $time - (86400 * $mono['term_day']);
include $path.'/head.php';
if($_SESSION['no'] || ($_SESSION['user_level'] >= $mono['write_level'])) include $path.'/write.memo.php';
$getList = @mysql_query('select * from '.$dbFIX.'memo_post where signdate > '.$termDayStart.' and signdate < '.$time.' order by signdate desc');
while($memo = @mysql_fetch_array($getList)) {
	$getComment = @mysql_query('select * from '.$dbFIX.'memo_comment where post_num = '.$memo['uid'].' order by uid asc');
	$memo['comment_num'] = @mysql_num_rows($getComment);
	include $path.'/list.php';
	echo '<div id="comment'.$memo['uid'].'" class="commentBox" style="display: none">';
	while($co = @mysql_fetch_array($getComment)) {
		$content = stripslashes($co['content']);
		include $path.'/comment.php';
	}
	include $path.'/write.comment.php';
	echo '</div>';
}
include $path.'/foot.php';
?>