<?php
include 'php_head.php';
include 'lib/common.php';
if($_SESSION['no']) error('이미 로그인 되어 있습니다.', 'location.href=\'admin.php\'');
@extract($_POST);
if(array_key_exists('loginStart', $_POST) && $_POST['loginStart'])
{
	dbConn();
	if(!trim($id)) error('아이디를 입력해 주세요');
	if(!trim($password)) error('비밀번호를 입력해 주세요');
	$checkQue = @mysql_query("select uid from ".$dbFIX."config where id = '$id' and password = '".md5($password)."'");
	$getCheck = @mysql_fetch_array($checkQue);
	if(!$getCheck[0]) error('등록된 사용자가 아닙니다');
	$_SESSION['no'] = $getCheck[0];
	move('admin.php?admin=20');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="GR Blog" />
<link rel="stylesheet" href="style.css" type="text/css" title="style" />
<title>GR Blog 관리자 로그인 화면</title>
<style type="text/css">/*<![CDATA[*/
@import url(css/login_style.css);
/*]]>*/</style>
</head>
<body>

<!-- 로그인 대화상자 -->
<div style="margin-top: 50px"><img src="image/darkgray/top.login.logo.gif" alt="GR Blog Login" /></div>
<div id="userLogin">
	<div class="loginTop">GR Blog 관리자 로그인</div>
	<div class="loginBody">
		<form id="login" method="post" onsubmit="return login();" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<div><input type="hidden" name="loginStart" value="1" /></div>
		<div id="setting">
		<div class="option">아이디:</div>
		<div class="value"><input type="text" name="id" class="t" title="아이디를 입력해 주세요" /></div>
		<div class="option">비밀번호:</div>
		<div class="value"><input type="password" name="password" class="t" title="비밀번호를 입력해 주세요" /></div>
		<div class="ok"><input type="image" src="image/darkgray/button.login.now.gif" title="이 블로그에 관리자로 로그인 합니다" /></div>
		</form>
	</div>
</div>
<!--# 로그인 대화상자 -->

<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/effects.js"></script>
<script type="text/javascript" src="js/dragdrop.js"></script>
<script type="text/javascript" src="js/login.js"></script>

</body>
</html>