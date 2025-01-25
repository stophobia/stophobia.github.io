<?php if(!defined('__GRBLOG__')) exit(); ?>

<!-- 사진 올리기 -->
<form id="new_post" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?admin=10&amp;modifyTarget=<?php echo $modify['uid']; ?>" enctype="multipart/form-data">
<div id="all">
	<div class="normalTitle">사진 올리기</div>
	<div id="modifyDIV"><input type="hidden" name="photo_modifyTarget" value="<?php echo $modify['uid']; ?>" /></div>
	<div id="setting">
		<?php if($modify['file_route']) { ?>
		<div class="option">업로드된 사진:</div>
		<div class="value"><img src="phpThumb/phpThumb.php?src=../<?php echo $modify['file_route']; ?>&amp;w=240&amp;h=150&amp;q=<?php echo $photo['quality']; ?>&amp;fltr[]=usm|99|0.5|3" alt="uploaded image" /></div>
		<?php } ?>
		<div class="option">분류:</div>
		<div class="value">
			<select name="selectCategory">
			<?php
			$getCategory = @mysql_query('select * from '.$dbFIX.'photo_category');
			while($ca = @mysql_fetch_array($getCategory)) { ?>
			<option value="<?php echo $ca['uid']; ?>"<?php echo (($ca['uid']==$modify['category'])?' selected="selected"':''); ?>><?php echo $ca['name']; ?></option>
			<?php } ?>
			</select>
		</div>
		<div class="option">사진:</div>
		<div class="value"><input type="file" name="file" class="t" title="찾아보기... 를 클릭하여 업로드할 사진을 선택해 주세요." /></div>
		<div class="option">제목 / 내용:</div>
		<div class="value"><input type="text" name="title" class="t" value="<?php echo $modify['title']; ?>" title="포스팅 제목을 입력해 주세요." /></div>
		<div class="value"><textarea name="content" id="content" rows="20" cols="90"><?php echo $modify['content']; ?></textarea></div>
		<div class="btn">
		<input type="image" src="image/darkgray/button.write.publish.gif" title="작성을 완료하고 사진첩에 추가 합니다." />
		</div>
		<?php 
		if($_GET['filename']) { 
			include 'photo_config.php';
		?>
		<!-- 업로드 후 미리보기 -->
		<div id="thumbnailPreview">
		<div class="option">미리보기:</div>
		<div style="padding: 20px; text-align: center">
		<img src="phpThumb/phpThumb.php?src=../<?php echo urldecode($_GET['filename']); ?>&amp;w=<?php echo $photo['photo_list_width']; ?>&amp;h=<?php echo $photo['photo_list_height']; ?>&amp;q=<?php echo $photo['quality']; ?>&amp;fltr[]=usm|99|0.5|3" alt="포토로그 목록화면 미리보기" style="vertical-align: middle" /> &nbsp;&nbsp;&nbsp;&nbsp;
		<img src="phpThumb/phpThumb.php?src=../<?php echo urldecode($_GET['filename']); ?>&amp;w=<?php echo $photo['width']; ?>&amp;h=<?php echo $photo['height']; ?>&amp;q=<?php echo $photo['quality']; ?>&amp;fltr[]=usm|99|0.5|3" alt="블로그 첫화면에서 미리보기" style="vertical-align: middle" /> &nbsp;&nbsp;&nbsp;&nbsp;
		<img src="phpThumb/phpThumb.php?src=../<?php echo urldecode($_GET['filename']); ?>&amp;w=<?php echo $photo['main_width']; ?>&amp;h=<?php echo $photo['main_height']; ?>&amp;q=<?php echo $photo['quality']; ?>&amp;fltr[]=usm|99|0.5|3" alt="포토로그 첫화면 하단 미리보기" style="vertical-align: middle" /> 
		
		</div>
		<?php } ?>
	</div>
</div>
</form>
<!--# 새글 작성 -->