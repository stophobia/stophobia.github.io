<?php
// 기본 클래스를 부르고 DB 연결
include 'class/common.php';
$GR = new COMMON;
$GR->dbConn();

// 작성자 아이피와 현재 방문객의 아이피가 일치하면 비밀번호 확인과정 패스함 (오픈아이디일 경우에만)
if($_GET['readyWork'] == 'c_delete' && $_SESSION['openID']) {
	$savedPW = @mysql_fetch_array(mysql_query("select ip, homepage from {$dbFIX}comment_".$_GET['id']." where no = '".$_GET['commentNo']."' and member_key = 0"));
	if(($_SERVER['REMOTE_ADDR'] == $savedPW['ip']) && $savedPW['homepage']) {
		@mysql_query("delete from {$dbFIX}comment_".$_GET['id']." where no = '".$_GET['commentNo']."'");
		@mysql_query("update {$dbFIX}bbs_".$_GET['id']." set comment_count = comment_count - 1 where no = '".$_GET['articleNo']."'");
		$GR->error('코멘트를 삭제하였습니다.', 0, 'board.php?id='.$id.'&articleNo='.$articleNo);
	}
}

// 비밀번호를 입력했을 경우 체크 후 게시물 보기 (혹은 삭제)
if(array_key_exists('enterPassword', $_POST) && $_POST['enterPassword']) {
	@extract($_POST);
	if(!ini_get('magic_quotes_gpc')) {
		$id = addslashes($_POST['id']);
		$password = addslashes($_POST['password']);
	} else {
		$id = $_POST['id'];
		$password = $_POST['password'];
	}
	
	if($readyWork == 'view' || $readyWork == 'delete' || $readyWork == 'write') {
		$table = $dbFIX.'bbs_'.$id;
		$valueNo = $articleNo; 
	}
	elseif($readyWork == 'c_delete') {
		$table = $dbFIX.'comment_'.$id;
		$valueNo = $commentNo;
	}
	else $table = $dbFIX.'bbs_'.$id;
	
	$fetchPassword = @mysql_fetch_array(mysql_query("select password from {$table} where no = '$valueNo'"));
	$tmpPassword = @mysql_fetch_array(mysql_query("select password('$password') as passwd"));

	if($tmpPassword['passwd'] == $fetchPassword['password']) {
		$pass = sha1($tmpPassword[0]);
		if($readyWork == 'write') $goFile = 'write.php';
		elseif($readyWork == 'delete' or $readyWork == 'c_delete') $goFile = 'delete.php';
		else $goFile = 'board.php';
		$GR->move($goFile.'?id='.$id.'&amp;page='.$page.'&amp;articleNo='.$articleNo.'&amp;alreadyEnterPassword='.
			$pass.'&amp;mode=modify&amp;targetTable='.$targetTable.'&amp;commentNo='.$commentNo.'&amp;modifyTarget='.$modifyTarget);
	}
	else $GR->error('비밀번호가 맞지 않습니다.', 0, 'enter_password.php?id='.$id.'&amp;articleNo='.$articleNo.'&amp;readyWork='.$readyWork.'&amp;targetTable='.$targetTable.'&amp;page='.$page);

// 비밀번호 입력 전
} else {
	$id = $_GET['id'];
	$page = $_GET['page'];
	$articleNo = $_GET['articleNo'];
	$commentNo = $_GET['commentNo'];
	$readyWork = $_GET['readyWork'];
	$password = $_POST['password'];
	$targetTable = $_GET['targetTable'];
	$modifyTarget = $_GET['modifyTarget'];
}
$setup = @mysql_fetch_array(mysql_query("select head_file, head_form, foot_form, foot_file, theme from {$dbFIX}board_list where id = '$id'"));

// 상단 설정
if($id && ($setup['head_file'] || $setup['head_form'])) {
	$move = 'board.php?id='.$id;
	$theme = 'theme/'.$setup['theme'];
	if($setup['head_file']) {
		ob_start();
		include $setup['head_file'];
		$content = ob_get_contents();
		ob_clean();
		echo str_replace('</head>', '<link rel="stylesheet" href="out_style.css" type="text/css" title="style" /></head>', $content);
	}
	if($setup['head_form']) {
		$setup['head_form'] = str_replace('</head>', '<link rel="stylesheet" href="out_style.css" type="text/css" title="style" /></head>', $setup['head_form']);
		echo str_replace('[theme]', $theme, $setup['head_form']);
	}
	$hasHeadFoot = true;

// 상/하단 페이지가 없을 떄
} else {
	$move = $fromPage;
	$title = 'GR Board Check Password Page';
	$encoding = 'utf-8';
	include 'html_head.php';
	echo '<body>';
	$hasHeadFoot = false;
}

if($_GET['id']) $id = $_GET['id'];
if($_GET['page']) $page = $_GET['page'];
if($_GET['articleNo']) $articleNo = $_GET['articleNo'];
if($_GET['readyWork']) $readyWork = $_GET['readyWork'];
if($_GET['targetTable']) $targetTable = $_GET['targetTable'];

// 비밀번호 입력 디자인 가져오기
if(file_exists('theme/'.$setup['theme'].'/theme_enter_password.php')) include 'theme/'.$setup['theme'].'/theme_enter_password.php';
else include 'enter_password_default.php';

// 하단 설정
if($hasHeadFoot) {
	if($setup['foot_file']) include $setup['foot_file'];
	echo $setup['foot_form'];
} else { ?></body></html><?php } ?>