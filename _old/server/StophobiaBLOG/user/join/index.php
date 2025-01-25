<?php
$prefix = '../../';
include $prefix.'php_head.php';
include $prefix.'lib/common.php';
if($_SESSION['no']) error('이미 관리자로 로그인 되어 있습니다.');
elseif($_SESSION['user_no']) error('이미 멤버로 로그인 되어 있습니다.');
@extract($_POST);
dbConn($prefix);
if($joinStart) {
	if(!$id) error('아이디를 입력해 주십시오.');
	if(!$password) error('비밀번호를 입력해 주십시오.');
	if(!$name) error('이름(닉네임)을 입력해 주십시오.');
	if($self_info) $self_info = addslashes($self_info);
	$getExistID = @mysql_fetch_array(mysql_query('select uid from '.$dbFIX.'user where id = '.$user_id));
	if($getExistID['uid']) error('입력하신 아이디가 이미 존재 합니다.');
	$sql = "insert into ".$dbFIX."user set uid = '', user_id = '$id', password = '".md5($password)."', homepage = '$homepage', email = '$email', ".
		"perm = '1', nickname = '$name', self_info = '$self_info', signdate = '".time()."'";
	@mysql_query($sql);
	echo '<script type="text/javascript"> alert(\'이 블로그에 멤버로 등록을 완료하였습니다!\\n\\n이제 로그인 하시면 됩니다.\'); '.
		' window.close(); </script>';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="GR Blog" />
<link rel="stylesheet" href="<?php echo $prefix; ?>style.css" type="text/css" title="style" />
<title>GR Blog 멤버 등록 화면</title>
<style type="text/css">/*<![CDATA[*/
@import url(<?php echo $prefix; ?>css/join_style.css);
/*]]>*/</style>
<script type="text/javascript" src="<?php echo $prefix; ?>js/join.js"></script>
</head>
<body>

<!-- 멤버 등록 대화상자 -->
<div class="body">
	<div class="top">GR Blog 멤버 등록</div>
	<div id="setting">
		<form id="join" method="post" onsubmit="return join();" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<div><input type="hidden" name="joinStart" value="1" /></div>
		<table rules="none" summary="GR Blog User Register" cellpadding="0" cellspacing="0" border="0">
		<caption></caption>
		<colgroup>
		<col style="width: 150px" />
		<col />
		</colgroup>
		<thead>
		<tr>
			<th>설정항목</th>
			<th>설 정 값</th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td class="l">아이디</td>
			<td class="r"><input type="text" class="t" name="id" /> <a href="#" onclick="idCheck();">[중복확인]</a></td>
		</tr>
		<tr>
			<td class="l">비밀번호</td>
			<td class="r"><input type="password" class="t" name="password" /> (4자리 이상)</td>
		</tr>
		<tr>
			<td class="l">이름(닉네임)</td>
			<td class="r"><input type="text" class="t" name="name" /> (30자 이하)</td>
		</tr>
		<tr>
			<td class="l">홈페이지</td>
			<td class="r"><input type="text" class="t" name="homepage" /> ("http://" 필요)</td>
		</tr>
		<tr>
			<td class="l">이메일</td>
			<td class="r"><input type="text" class="t" name="email" /> (한메일도 가능)</td>
		</tr>
		<tr>
			<td class="l">자기소개</td>
			<td class="r"><input type="text" class="t" name="self_info" maxlength="250" style="width: 350px" /></td>
		</tr>
		<tr>
			<td colspan="2" class="b">
				<input type="image" src="<?php echo $prefix; ?>/image/darkgray/button.check.gif" title="등록을 완료합니다." />
			</td>
		</tr>
		</tbody>
		</table>
		</form>
	</div>
</div>
<!--# 멤버 등록 대화상자 -->

</body>
</html>