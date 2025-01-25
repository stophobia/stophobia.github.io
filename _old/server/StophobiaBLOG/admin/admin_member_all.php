<?php if(!defined('__GRBLOG__')) exit(); ?>

<div class="normalTitle"><?php echo $member['nickname']; ?>님의 관리화면</div>

<!-- 전체 설정 -->
<div id="all">
	<form id="set" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?admin=100" enctype="multipart/form-data">
	<div><input type="hidden" name="target" value="<?php echo $member['uid']; ?>" /></div>
	<div id="setting">
	<table rules="none" summary="GR Blog Setting" cellpadding="0" cellspacing="0" border="0">
	<caption></caption>
	<colgroup>
	<col style="width: 150px" />
	<col />
	</colgroup>
	<tbody>
	<tr>
		<td class="l"><strong>업데이트소식</strong></td>
		<td class="r"><?php echo $versionInfo; ?></td>
	</tr>
	<tr>
		<td class="l">아이디</td>
		<td class="r"><input type="text" class="t" name="id" value="<?php echo $member['user_id']; ?>" readonly="readonly" title="아이디는 수정하실 수 없습니다" /> (아이디는 수정하실 수 없습니다)</td>
	</tr>
	<tr>
		<td class="l">비밀번호</td>
		<td class="r"><input type="password" class="t" name="password" value="" title="수정 시 덮어씌워집니다" /> (수정 시 덮어씌워집니다)</td>
	</tr>
	<tr>
		<td class="l">이름(닉네임)</td>
		<td class="r"><input type="text" class="t" name="nickname" value="<?php echo htmlspecialchars(stripslashes($member['nickname'])); ?>" /></td>
	</tr>
	<tr>
		<td class="l">홈페이지</td>
		<td class="r">
		<input type="text" class="t" name="homepage" value="<?php echo $member['homepage']; ?>" />
		</td>
	</tr>
	<tr>
		<td class="l">이메일</td>
		<td class="r"><input type="text" class="t" name="email" value="<?php echo $member['email']; ?>" /></td>
	</tr>
	<tr>
		<td class="l">자기 소개</td>
		<td class="r"><input type="text" class="t" name="self_info" value="<?php echo htmlspecialchars(stripslashes($member['self_info'])); ?>" /></td>
	</tr>
	<tr>
		<td colspan="2" class="b">
			<input type="image" src="image/darkgray/button.check.gif" title="설정 수정하기" />
		</td>
	</tr>
	</tbody>
	</table>
	</div>
	</form>
</div>
<!--# 전체 설정 -->