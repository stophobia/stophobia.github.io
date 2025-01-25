<?php if(!defined('__GRSHOP__')) exit(); ?>

<div id="loginField" style="display: none">

<form id="loginForm" method="post" onsubmit="return checkInput(this);" action="<?php echo $_SERVER['PHP_SELF']; ?>?go=<?php echo $go; ?>">
<table id="loginFrame" rules="none" summary="GR Shop Login Page" cellpadding="0" cellspacing="0" border="0">
<caption></caption>
<thead> 
<tr>
	<th colspan="2"><img src="<?php echo $login; ?>/login-head.gif" alt="Login" /></th>
</tr>
</thead>
<tbody>
<tr>
	<td class="opt">아이디</td>
	<td class="var"><input type="text" name="id" /></td>
</tr>
<tr>
	<td class="opt">비밀번호</td>
	<td class="var"><input type="password" name="password" /></td>
</tr>
<tr>
	<td class="btn" colspan="2">
	<input type="submit" value="확 인" />
	<input type="button" value="취 소" onclick="location.href='../'" />
	</td>
</tr>
</tbody>
</table>
</form>

</div>