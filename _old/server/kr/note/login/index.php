<?php
/**
 * @update 2008-11-21
 * @comment 로그인 폼 출력
 */
include '../grnote.config.php';
$grNote['title'] = 'GR Note Login Page';
include $grNote['path'].'/common/head.header.php';
include $grNote['path'].'/common/head.login.html.php';
?>
<body>
<form id="loginForm" method="post" action="./" onsubmit="return Login.process();">
<div id="box">
	<div id="login">
		<div id="title"><span>GR Note</span> Login</div>
		<ul>
			<li><input type="text" id="id" /> 아이디</li>
			<li><input type="password" id="password" /> 비밀번호</li>
		</ul>
		<div id="loginBtn">
			<input type="image" src="images/button.login.ok.gif" title="로그인 합니다." class="s" /> 
			<a href="../"><img src="images/button.login.cancel.gif" title="첫화면으로 돌아 갑니다." /></a>
			<?php if($grNote['user']['joinOK'] == 2) { ?>
			<a href="#" onclick="Login.registerWindow(event);"><img src="images/button.login.register.gif" title="GR노트 사용자 등록을 합니다." /></a>
			<?php } ?>
		</div>
		<div id="loadBox" style="display: none"></div>
	</div>
</div>
</form>

<?php if($grNote['user']['joinOK'] == 2) { ?>
<div id="memberJoin" style="display: none">
<form id="registerMember" method="post" action="./" onsubmit="return Login.regMember();">
<span class="b">멤버등록</span><br /><br />
<table rules="none" summary="GR Note New Member" cellpadding="0" cellspacing="0" border="0">
<caption></caption>
<colgroup>
<col style="width: 80px" />
<col />
</colgroup>
<thead>
<tr>
	<th class="list">항목</th>
	<th class="list">값</th>
</tr>
</thead>
<tbody>
<tr>
	<td>아이디</td>
	<td class="list"><input type="text" name="id" value="" /></td>
</tr>
<tr>
	<td>비밀번호</td>
	<td class="list"><input type="password" name="password" /></td>
</tr>
<tr>
	<td>이름</td>
	<td class="list"><input type="text" name="nickname" value="" /></td>
</tr>
<tr>
	<td>이메일</td>
	<td class="list"><input type="text" name="email" value="" /></td>
</tr>
<tr>
	<td>홈페이지</td>
	<td class="list"><input type="text" name="homepage" value="" /></td>
</tr>
<tr style="height: 70px">
	<td>자기소개</td>
	<td class="list"><textarea name="selfInfo" rows="2" cols="40"><?php echo $member['self_info']; ?></textarea></td>
</tr>
<tr style="height: 50px">
	<td colspan="2">
	<input type="image" src="images/member.modify.submit.gif" title="정보를 등록 합니다." />
	</td>
</tr>
</tbody>
</table>
</form>
<div id="closeWindow"><a href="#" onclick="Login.closeWindow();"><img src="images/button.close.window.gif" alt="닫기" /></a></div>
</div>
<?php
	}
include $grNote['path'].'/common/foot.login.html.php';
?>