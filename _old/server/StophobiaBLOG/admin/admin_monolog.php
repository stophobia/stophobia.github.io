<?php if(!defined('__GRBLOG__')) exit(); ?>

<div class="normalTitle">모노로그 설정</div>

<!-- 모노로그 설정 -->
<div id="all">
	<form id="set" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?admin=18" enctype="multipart/form-data">
	<div id="adminAll">
	<table rules="none" summary="GR Blog Monolog Setting" cellpadding="0" cellspacing="0" border="0">
	<caption></caption>
	<colgroup>
	<col style="width: 150px" />
	<col />
	</colgroup>
	<tbody>
	<tr>
		<td class="l">모노로그 테마(스킨)</td>
		<td class="r">
			<select name="theme">
			<?php
			$themeDir = @opendir('mono/theme');
			while($theme = @readdir($themeDir)) { 
				if($theme == '.' or $theme == '..') continue; ?>
			<option value="<?php echo $theme; ?>" <?php echo (($mono['theme'] == $theme)?'selected="selected"':''); ?>><?php echo $theme; ?></option>
			<?php } ?>
			</select>
		</td>
	</tr>
	<tr>
		<td class="l">로그 작성 권한</td>
		<td class="r"><select name="write_level">
			<option value="1"<?php echo (($mono['write_level']==1)?' selected="selected"':''); ?>>레벨 1 이상</option>
			<option value="2"<?php echo (($mono['write_level']==2)?' selected="selected"':''); ?>>레벨 2 이상</option>
			<option value="3"<?php echo (($mono['write_level']==3)?' selected="selected"':''); ?>>레벨 3 이상</option>
			<option value="4"<?php echo (($mono['write_level']==4)?' selected="selected"':''); ?>>레벨 4 이상</option>
			<option value="5"<?php echo (($mono['write_level']==5)?' selected="selected"':''); ?>>레벨 5 이상</option></select> 등록된 멤버들에게 레벨 조정으로 쓰기 권한을 줄 수 있습니다.</td>
	</tr>
	<tr>
		<td class="l">댓글 작성 권한</td>
		<td class="r"><select name="reply_level">
			<option value="1"<?php echo (($mono['reply_level']==1)?' selected="selected"':''); ?>>레벨 1 이상</option>
			<option value="2"<?php echo (($mono['reply_level']==2)?' selected="selected"':''); ?>>레벨 2 이상</option>
			<option value="3"<?php echo (($mono['reply_level']==3)?' selected="selected"':''); ?>>레벨 3 이상</option>
			<option value="4"<?php echo (($mono['reply_level']==4)?' selected="selected"':''); ?>>레벨 4 이상</option>
			<option value="5"<?php echo (($mono['reply_level']==5)?' selected="selected"':''); ?>>레벨 5 이상</option></select> 등록된 멤버들에게 레벨 조정으로 댓글 작성 권한을 줄 수 있습니다.</td>
	</tr>
	<tr>
		<td class="l">목록에 보일 일자</td>
		<td class="r"><input type="text" class="t" name="term_day" value="<?php echo $mono['term_day']; ?>" /> 목록에 <strong>n</strong>일치 로그를 보여줍니다.</td>
	</tr>
	<tr>
		<td class="l">모노로그 이름</td>
		<td class="r"><input type="text" class="t" name="mono_title" value="<?php echo htmlspecialchars(stripslashes($mono['mono_title'])); ?>" /></td>
	</tr>
	<tr>
		<td class="l">RSS 외부로 보내기</td>
		<td class="r"><input type="checkbox" name="use_rss" value="1" <?php if($mono['use_rss']) { ?>checked="checked"<?php } ?> /> 체크하시면 외부로 RSS 피드를 발송해 줍니다.</td>
	</tr>
	<tr>
		<td class="l">오픈아이디 사용</td>
		<td class="r"><input type="checkbox" name="use_openid" value="1" <?php if($mono['use_openid']) { ?>checked="checked"<?php } ?> /> 체크하시면 오픈아이디를 이용해 댓글을 남길 수 있도록 합니다.</td>
	</tr>
	<tr>
		<td colspan="2" class="b" style="padding: 10px">
			<input type="image" src="image/darkgray/button.check.gif" title="설정 수정하기" />
		</td>
	</tr>
	</tbody>
	</table>
	</div>
	</form>
</div>
<!--# 모노로그 설정 -->