<?php 
if(!defined('__GRBLOG__')) exit();
include 'photo_config.php'; 
?>
<!-- 사진첩 설정 -->
<div id="all">
	<div class="normalTitle">사진첩 설정</div>

	<form id="photoSetup" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?admin=9">
	<div id="adminAll">
	<table rules="none" summary="GR Blog Photo Setup" cellpadding="0" cellspacing="0" border="0">
	<caption></caption>
	<colgroup>
	<col style="width: 150px" />
	<col />
	</colgroup>
	<tbody>
	<tr>
		<td class="l">보여줄 개수 (블로그)</td>
		<td class="r"><input type="text" class="t" name="photo_num" value="<?php echo $photo['num']; ?>" title="블로그에서 사이드에 몇개 보여줄 지 정합니다." /> 블로그 사이드에 몇 개를 보여줄 지 정합니다.</td>
	</tr>
	<tr>
		<td class="l">썸네일 폭</td>
		<td class="r"><input type="text" class="t" name="photo_width" value="<?php echo $photo['width']; ?>" /> px(픽셀), 폭이 높이보다 작을 경우 폭을 기준으로 리사이즈 됩니다.</td>
	</tr>
	<tr>
		<td class="l">원본사진 최대폭</td>
		<td class="r"><input type="text" class="t" name="photo_max_width" value="<?php echo $photo['original_max_width']; ?>" /> px(픽셀), 원본사진의 최대폭을 설정합니다.</td>
	</tr>
	<tr>
		<td class="l">썸네일 높이</td>
		<td class="r"><input type="text" class="t" name="photo_height" value="<?php echo $photo['height']; ?>" /> px(픽셀), 높이가 폭보다 작을 경우 높이를 기준으로 리사이즈 됩니다.</td>
	</tr>
	<tr>
		<td class="l">보여줄 개수 (포토로그)</td>
		<td class="r"><input type="text" class="t" name="main_num" value="<?php echo $photo['main_num']; ?>" /> 포토로그 하단에 작게 보여지는 썸네일 개수를 지정합니다.</td>
	</tr>
	<tr>
		<td class="l">썸네일 폭 (포토로그)</td>
		<td class="r"><input type="text" class="t" name="main_width" value="<?php echo $photo['main_width']; ?>" /> px(픽셀), 포토로그 하단에 작게 보여지는 썸네일 폭 설정</td>
	</tr>
	<tr>
		<td class="l">썸네일 높이 (포토로그)</td>
		<td class="r"><input type="text" class="t" name="main_height" value="<?php echo $photo['main_height']; ?>" /> px(픽셀), 포토로그 하단에 작게 보여지는 썸네일 높이 설정</td>
	</tr>
	<tr>
		<td class="l">목록 개수 (포토로그)</td>
		<td class="r"><input type="text" class="t" name="photo_list_num" value="<?php echo $photo['photo_list_num']; ?>" /> 포토로그 목록보기에서 보여줄 개수 (4의 배수값 권장, 예: 12, 16, 20, ...)</td>
	</tr>
	<tr>
		<td class="l">목록보기 썸네일 폭</td>
		<td class="r"><input type="text" class="t" name="photo_list_width" value="<?php echo $photo['photo_list_width']; ?>" /> px(픽셀), 포토로그 목록보기에서 썸네일 폭 설정</td>
	</tr>
	<tr>
		<td class="l">목록보기 썸네일 높이</td>
		<td class="r"><input type="text" class="t" name="photo_list_height" value="<?php echo $photo['photo_list_height']; ?>" /> px(픽셀), 포토로그 목록보기에서 썸네일 높이 설정</td>
	</tr>
	<tr>
		<td class="l">사진첩 이름</td>
		<td class="r"><input type="text" class="t" name="photo_title" value="<?php echo $photo['photoTitle']; ?>" title="사진첩 페이지 상단의 제목을 입력합니다. (예: 나의 사진첩)" /> 사진첩 페이지에서 상단의 사진첩 제목을 입력합니다. (예: 나의 사진첩)</td>
	</tr>
	<tr>
		<td class="l">썸네일품질(jpg)</td>
		<td class="r"><input type="text" class="t" name="photo_quality" value="<?php echo $photo['quality']; ?>" /> 0 ~ 100 사이로, 숫자가 클수록 썸네일이 선명하게 나옵니다.</td>
	</tr>
	<tr>
		<td class="l">코멘트 사용</td>
		<td class="r"><input type="checkbox" name="use_comment" value="1" checked="checked" /> 체크시 사진에 대해 방문객들의 댓글을 받습니다.</td>
	</tr>
	<tr>
		<td class="l">썸네일삭제</td>
		<td class="r"><input type="checkbox" name="photo_del_cache" /> 체크하시면 저장된 썸네일을 캐쉬에서 삭제하고 (필요시) 다시 만듭니다.</td>
	</tr>
	<?php if(!is_writable('photo_config.php')) { ?>
	<tr>
		<td class="l">안내</td>
		<td class="r" style="color: red">※ GR Blog 디렉토리 안에 있는 <strong>photo_config.php</strong> 파일의 퍼미션(권한)을 707로 설정해 주세요!</td>
	</tr>
	<?php } 
	if(!is_writable('phpThumb/cache/')) { ?>
	<tr>
		<td class="l">안내</td>
		<td class="r" style="color: red">※ GR Blog 디렉토리 안에 있는 <strong>phpThumb/cache</strong> 디렉토리의 퍼미션(권한)을 707로 설정해 주세요!</td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="2" class="b">
			<input type="image" src="image/darkgray/button.check.gif" title="사진첩 설정을 완료 합니다." />
		</td>
	</tr>
	</tbody>
	</table>
	</div>
	</form>
</div>
<!--# 링크 설정 -->