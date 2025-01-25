<?php
if(!defined('__GRFORUM__')) exit();

$addHead = '<script type="text/javascript" src="login.js"></script>';
$addHead .= '<link rel="stylesheet" href="' . $skin . '/skin.css" type="text/css" title="style" />';
$dir = '..';
include $skin . '/head.php';
?>
<div id="loginPage">

	<div class="navi">
		<div class="info">혹시 회원등록을 하시지 않으셨나요? 회원등록 버튼을 클릭하여 등록해 주세요!</div>
		<div class="menu right">
		<ul>
			<li><a href="<?php echo $dir; ?>/login/">로그인</a></li>
			<li><a href="<?php echo $dir; ?>/register/">회원등록</a></li>
			<li><a href="<?php echo $dir; ?>/search/">통합검색</a></li>
		</ul>
		</div>
	</div>

	<h3>아이디와 비밀번호를 입력해 주세요!</h3>

	<form name="login" method="post" onsubmit="return Login.check(this)" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<div id="loginForm">

		<div id="loginBox">
			
			<div class="opt">아이디</div>
			<div class="var"><input class="i" type="text" name="id" /></div>
			<div class="clr"></div>

			<div class="opt">비밀번호</div>
			<div class="var"><input class="i" type="password" name="password" /></div>
			<div class="clr"></div>

			<div class="btn"><input class="s" type="submit" value="확인" /></div>

		</div>
		
	</div>
	</form>

</div>

<?php include $skin . '/foot.php'; ?>