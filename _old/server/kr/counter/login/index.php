<?php
include '../class/Common.php';
$GC = new Common;
@extract($_POST);
if($id) {
	$getIdPass = @mysql_fetch_array(mysql_query("select uid from gc_admin where id = '$id' and password = '".md5($password)."'"));
	if($getIdPass['uid']) {
		$_SESSION['no'] = true;
		$GC->move('../admin/');
	} else $GC->error('아이디 혹은 비밀번호가 맞지 않습니다.');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="GR Counter" />
<link rel="stylesheet" href="../style.css" type="text/css" title="style" />
<title>GR Counter 관리자 로그인 화면</title>
<script type="text/javascript" src="../install/install.js"></script>
</head>
<body>

<!-- 로그인 상자 -->
<div id="center">
	<div style="height: 100px"></div>
	<div class="top">
	GR Counter 로그인 화면
	</div>
	<div class="body">
	<div style="padding: 10px 10px 0px 10px">
		<form id="set" method="post" onsubmit="return setting();" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<div id="setting">
		<table rules="none" summary="GR Counter Admin Login" cellpadding="0" cellspacing="0" border="0">
		<caption></caption>
		<colgroup>
		<col style="width: 150px" />
		<col />
		</colgroup>
		<tbody>
		<tr>
			<td class="l">아이디</td>
			<td class="r"><input type="text" class="t" name="id" /></td>
		</tr>
		<tr>
			<td class="l">비밀번호</td>
			<td class="r"><input type="password" class="t" name="password" /></td>
		</tr>
		<tr>
			<td colspan="2" class="b">
				<input type="submit" value="완 료" />
			</td>
		</tr>
		</tbody>
		</table>
		</div>
		</form>
	</div>
	</div>
</div>
<!--# 로그인 상자 -->

</body>
</html>