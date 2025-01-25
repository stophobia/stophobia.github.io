<!-- 방명록 -->
<div id="guestbook">

	<h2><a href="<?php echo $path; ?>">방명록</a></h2>
	
	<form id="guest" method="post" onsubmit="return chkGuest('<?php if($conf_antiSpam && !$_SESSION['no']) echo 'useSpamCheck'; ?>');" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<div><input type="hidden" name="guestbookSubmit" value="1" />
	<input type="hidden" name="modifyTarget" value="<?php echo $modifyTarget; ?>" />
	<input type="hidden" name="page" value="<?php echo $page; ?>" />
	<input type="hidden" name="replyTarget" value="<?php echo $replyTarget; ?>" /></div>
	<table rules="none" summary="GR Blog Guestbook" cellspacing="0" cellpadding="0" border="0">
	<tbody>
	<tr>
		<td class="opt1">이름</td>
		<td class="opt2"><input type="text" name="name" class="i" value="<?php echo $modify['name']; ?>" /></td>
	</tr>
	<?php if(!$_SESSION['no']) { ?>
	<tr>
		<td class="opt1">패스워드</td>
		<td class="opt2"><input type="password" name="password" class="i" value="" /></td>
	</tr>
	<?php } ?>
	<tr>
		<td class="opt1">홈페이지 (옵션)</td>
		<td class="opt2"><input type="text" name="homepage" class="i" value="<?php echo ($modify['homepage'])?$modify['homepage']:'http://'; ?>" /></td>
	</tr>
	<tr>
		<td class="opt1">이메일 (옵션)</td>
		<td class="opt2"><input type="text" name="email" class="i" value="<?php echo $modify['email']; ?>" style="width: 100px" />
		이메일 주소로 <a href="http://gravatar.com" onclick="window.open(this.href, '_blank'); return false" title="클릭하시면 새 창으로 관련 설명을 봅니다. (영문)">그라바타 이미지</a>를 가져옵니다.</td>
	</tr>
	<tr>
		<td class="opt1">내용</td>
		<td class="opt2"><textarea name="content" rows="5" class="text"><?php echo stripslashes($modify['content']); ?></textarea></td>
	</tr>
	<?php if(!$_SESSION['no']) { ?>
	<tr>
		<td class="opt1">비밀글 (옵션)</td>
		<td class="opt2"><input type="checkbox" name="isSecret" value="1" /> 관리자에게만 보여주고 싶을 경우, 체크해 주세요</td>
	</tr>
	<?php } if($conf_antiSpam && !$_SESSION['no']) { ?>
	<tr>
		<td class="opt1">자동등록방지</td>
		<td class="opt2"><input type="text" name="antispam" class="i" style="width: 100px" /> <span>&nbsp;&nbsp; <?php echo $_SESSION['antiSpam']; ?></span> &nbsp;&nbsp;(왼쪽의 8자리 코드를 입력해 주세요.)</td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="2" class="btn"><input type="submit" value="글을 작성합니다" /></td>
	</tr>
	</tbody>
	</table>
	</form>