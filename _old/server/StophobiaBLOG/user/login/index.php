<?php
$prefix = '../../';
include $prefix.'php_head.php';
include $prefix.'lib/common.php';

if($_SESSION['no']) error('관리자로 이미 로그인 되어 있습니다.');
if($_SESSION['user_no']) error('멤버로 이미 로그인 되어 있습니다.');
@extract($_POST);
if(array_key_exists('loginStart', $_POST) && $_POST['loginStart'])
{
	dbConn($prefix);
	if(!trim($id)) error('아이디를 입력해 주세요');
	if(!trim($password)) error('비밀번호를 입력해 주세요');
	$checkQue = @mysql_fetch_array(mysql_query("select uid, perm from ".$dbFIX."user where user_id = '$id' and password = '".md5($password)."'"));
	if(!$checkQue[0]) error('등록된 멤버가 아닙니다');
	$_SESSION['user_no'] = $checkQue['uid'];
	$_SESSION['user_level'] = $checkQue['perm'];
	move('../../');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="GR Blog" />
<link rel="stylesheet" href="<?php echo $prefix; ?>/style.css" type="text/css" title="style" />
<link rel="stylesheet" href="<?php echo $prefix; ?>/css/login_style.css" type="text/css" title="style" />
<title>GR Blog 멤버 로그인 화면</title>
<style type="text/css">/*<![CDATA[*/

/*]]>*/</style>
</head>
<body>

<!-- 로그인 대화상자 -->
<div style="margin-top: 50px"><img src="<?php echo $prefix; ?>image/darkgray/top.login.logo.gif" alt="GR Blog Login" /></div>
<div id="userLogin">
	<div class="loginTop">GR Blog 멤버 로그인</div>
	<div class="loginBody">
		<form id="login" method="post" onsubmit="return login();" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<div><input type="hidden" name="loginStart" value="1" /></div>
		<div id="setting">
		<div class="option">아이디:</div>
		<div class="value"><input type="text" name="id" class="t" title="아이디를 입력해 주세요" /></div>
		<div class="option">비밀번호:</div>
		<div class="value"><input type="password" name="password" class="t" title="비밀번호를 입력해 주세요" /></div>
		<div class="ok"><a href="../join/" onclick="window.open(this.href, '_blank', 'width=550,height=350,menubar=no'); return false" title="이 블로그에 멤버를 새로이 등록 합니다."><img src="<?php echo $prefix; ?>image/darkgray/button.register.member.gif" alt="멤버등록" /></a>
		<input type="image" src="<?php echo $prefix; ?>image/darkgray/button.member.login.gif" title="이 블로그에 멤버로 로그인 합니다" /></div>
		</form>
	</div>
</div>
<div id="userLoginBack"></div>
<!--# 로그인 대화상자 -->

<script type="text/javascript" src="<?php echo $prefix; ?>js/prototype.js"></script>
<script type="text/javascript" src="<?php echo $prefix; ?>js/effects.js"></script>
<script type="text/javascript" src="<?php echo $prefix; ?>js/dragdrop.js"></script>
<script type="text/javascript" src="<?php echo $prefix; ?>js/login.js"></script>

</body>
</html>