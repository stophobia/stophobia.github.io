<!-- ## 방명록 시작 ## -->
<div id="content">
  <div class="postwrap">

<div id="guestbook">

	<form id="commentform" method="post" onsubmit="return chkGuest('<?php if($conf_antiSpam && !$_SESSION['no']) echo 'useSpamCheck'; ?>');" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<div><input type="hidden" name="guestbookSubmit" value="1" />
	<input type="hidden" name="modifyTarget" value="<?php echo $modifyTarget; ?>" />
	<input type="hidden" name="page" value="<?php echo $page; ?>" />
	<input type="hidden" name="replyTarget" value="<?php echo $replyTarget; ?>" /></div>
	<table rules="none" summary="GR Blog Guestbook" cellspacing="0" cellpadding="0" border="0">
	<tbody>
	<tr>
		<td class="opt1">이름</td>
		<td class="opt2"><input type="text" name="name" class="text" value="<?php echo $modify['name']; ?>" /></td>
	</tr>
	<?php if(!$_SESSION['no']) { ?>
	<tr>
		<td class="opt1">패스워드</td>
		<td class="opt2"><input type="password" name="password" class="text" value="" /></td>
	</tr>
	<?php } ?>
	<tr>
		<td class="opt1">홈페이지 (옵션)</td>
		<td class="opt2"><input type="text" name="homepage" class="text" value="<?php echo ($modify['homepage'])?$modify['homepage']:'http://'; ?>" /></td>
	</tr>
	<tr>
		<td class="opt1">이메일 (옵션)</td>
		<td class="opt2"><input type="text" name="email" class="text" value="<?php echo $modify['email']; ?>" style="width: 100px" /></td>
	</tr>
	<tr>
		<td class="opt1">내용</td>
		<td class="opt2"><textarea name="content" rows="5" cols="35" class="text"><?php echo stripslashes($modify['content']); ?></textarea></td>
	</tr>
	<?php if(!$_SESSION['no']) { ?>
	<tr>
		<td class="opt1">비밀글 (옵션)</td>
		<td class="opt2"><input type="checkbox" name="isSecret" value="1" /> 관리자에게만 보여주고 싶을 경우, 체크해 주세요</td>
	</tr>
	<?php } if($conf_antiSpam && !$_SESSION['no']) { ?>
	<tr>
		<td class="opt1">자동등록방지</td>
		<td class="opt2"><input type="text" name="antispam" class="i" style="width: 100px" /> <span style="cursor: pointer" title="여기를 클릭하여 자동등록방지 코드를 입력해 주세요." onclick="pasteCodeGuest('<?php echo $_SESSION['antiSpam']; ?>');">&nbsp;&nbsp; <?php echo $_SESSION['antiSpam']; ?></span></td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="2" style="padding: 15px"><input type="submit" id="submit" value="Leave Message" /></td>
	</tr>
	</tbody>
	</table>
	</form>

	<div style="height: 30px"></div>