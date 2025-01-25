<?php
// 목적지 저장
$go = $_GET['go'];
if(!$go) $go = '../';

// Core 설정 저장
define('__GRSHOP__', true);
include '../core.php';
$grcore = '../'.$grcore;
include $grcore.'/class/common.php';
include '../lib/shop.lib.php';
$core = new Common($grcore);
$shop = new Shop($core, $dbFIX);

// GR Board 연동 설정
$grboard = '../'.$core->config['grboard'];
include $grboard.'/include.php';

// 로그아웃시 처리
if($_GET['logout'] && $_SESSION['no']) {
	$_SESSION = array();
	@session_destroy();
	die('<script type="text/javascript"> location.href=\''.$go.'\'; </script>');
}

// 이미 로그인 되어 있다면
if($shop->isLogin()) $core->alert('이미 로그인되어 있습니다.', '../');

// 로그인 후 처리
if($_POST['id'] && $_POST['password']) $shop->loginCheck($_POST['id'], $_POST['password'], $grboard, $go);

// 로그인 설정 가져오기
$_login = $shop->get('login_skin');
$login = 'skin/'.$_login;

// 상단 설정
$dir = '..';
$design['head'] = '<link rel="stylesheet" href="'.$login.'/style.css" type="text/css" title="style" />'."\n";
$design['head'] .= '<script type="text/javascript" src="'.$login.'/login.js"></script>'."\n";

// 레이아웃 설정 가져오기
$_layout = $shop->get('layout_skin', '');
if($_layout) {
	$layout = '../layout/'.$_layout;

	// 레이아웃 상단 부르기
	include $layout.'/config.php';
	include $layout.'/head.php';

	// 로그인 스킨 부르기
	include $login.'/login.php';

	// 레이아웃 하단 부르기
	include $layout.'/foot.php';
} 
else { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="GR Shop" />
<script type="text/javascript" src="<?php echo $grcore; ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $layout; ?>/skin.js"></script>
<title>GR Shop 로그인하기</title>
<?php echo $design['head']; ?>
</head>
<body>
<?php 
	// 로그인 스킨 부르기
	include $login.'/login.php';
}
?>
</body>
</html>