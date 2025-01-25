<?php
if(isset($_GET['photoNo'])) $photoNo = $_GET['photoNo']; else exit();
if(isset($_GET['deleteNo'])) $deleteNo = $_GET['deleteNo'];
include 'php_head.php';
include 'photo_config.php';
include 'lib/common.php';
dbConn();

// EXIF 썸네일 정보 출력
function showEXIF($file)
{
	if(!eregi('\.jpg|\.jpeg|\.tiff', $file)) return '';
	if(!function_exists('exif_read_data')) return '';
	$exif = @exif_read_data($file);
	$result = 'Camera: '.$exif['Make'].' | '.
		'Model: '.$exif['Model'].' | '.
		'EditSoftware: '.$exif['Software'].' | '.
		'DateTime: '.$exif['DateTime'].' | '.
		'FileCompressionLevel: '.$exif['THUMBNAIL']['Compression'].' | '.
		'XResolution: '.$exif['THUMBNAIL']['XResolution'].' | '.
		'YResolution: '.$exif['THUMBNAIL']['YResolution'].' | '.
		'ExposureTime: '.$exif['ExposureTime'].' | '.
		'FNumber: '.$exif['FNumber'].' | '.
		'ISOSpeedRatings: '.$exif['ISOSpeedRatings'].' | '.
		'MeteringMode: '.$exif['MeteringMode'].' | '.
		'LightSource: '.$exif['LightSource'].' | '.
		'Flash: '.$exif['Flash'].' | '.
		'FocalLength: '.$exif['FocalLength'].' | '.
		'DigitalZoomRatio: '.$exif['DigitalZoomRatio'].' | '.
		'InterOperabilityIndex: '.$exif['InterOperabilityIndex'];
	echo $result;
}

// 사진삭제하기
if($deleteNo) {
	$del = @mysql_fetch_array(mysql_query('select file_route from '.$dbFIX.'photo where uid = '.$deleteNo));
	@unlink($del['file_route']);
	@mysql_query('delete from '.$dbFIX.'photo where uid = '.$deleteNo);
	$move = @mysql_fetch_array(mysql_query('select uid from '.$dbFIX.'photo order by uid desc limit 1'));
	error('선택하신 사진을 사진첩에서 삭제 했습니다.', 'location.href=\'view_photo.php?photoNo='.$move[0].'\';');
}

// 현재 사진
$nowPhoto = @mysql_fetch_array(mysql_query('select * from '.$dbFIX.'photo where uid = '.$photoNo));
$size = @getimagesize($nowPhoto['file_route']);
$exifWidth = $size[0];
if($size[0] > $photo['original_max_width']) {
	$exifWidth = $photo['original_max_width'];
	$resizePhoto = 'phpThumb/phpThumb.php?src=../'.$nowPhoto['file_route'].'&amp;w='.$photo['original_max_width'].'&amp;q=100';
}
else $resizePhoto = $nowPhoto['file_route'];
$fileName = explode('/', $nowPhoto['file_route']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="GR BLog" />
<meta name="Nationality" content="Korean" />
<title>GR Blog - <?php echo stripslashes($photo['photoTitle']); ?> - 중앙 사진을 더블클릭 하시면 창을 닫습니다</title>
<style type="text/css">
/*<![CDATA[*/
body {
	margin: 0;
	background-color: #505050;
	color: #707070;
	font-size: 12px;
	font-family: tahoma, Gulim, sans-serif;
}
img {
	border: 0 none;
}
#layout {
	margin: 10px;
}
#title {
	text-align: center;
	font-size: 28px;
	font-family: Georgia, Dotum, sans-serif;
	color: #aaa;
	padding-top: 20px;
	height: 50px;
	background: url(image/view_photo_back.gif) repeat-x top;
}
#photo {
	margin-top: 10px;
	text-align: center;
	z-index: 100;
	line-height: 80%;
}
#photo #moveImg {
	border: #000 5px solid;
}
#photo #exif {
	margin: auto;
	width: <?php echo ($exifWidth+10); ?>px;
	background-color: #000;
	color: #555;
	font-size: 10px;
	padding: 5px 0px 10px 0px;
	line-height: 150%;
}
#photo #moveImg {
	cursor: move;
}
#comment {
	margin-top: 10px;
	text-align: center;
	color: #999;
}
#comment span {
	font-size: 10px;
	color: #777;
}
#comment span a {
	color: #777;
	text-decoration: none;
}
#comment span a:hover {
	color: #eb7d7d;
}
#another {
	position: relative;
	bottom: 0px;
	border-top: #404040 1px solid;
	margin-top: 10px;
	padding-top: 20px;
	text-align: center;
	background-color: #484848;
	width: 10000px;
	height: <?php echo $photo['height']+20; ?>px;
	overflow: auto;
}
#another div {
	float: left;
	text-align: center;
	width: <?php echo $photo['width']+50; ?>px;
}
.clr { clear: both; }
/*]]>*/
</style>
<script src="js/prototype.js" type="text/javascript"></script>
<script src="js/dragdrop.js" type="text/javascript"></script>
<script src="js/effects.js" type="text/javascript"></script>
</head>
<body>
<div id="title"><?php echo stripslashes($photo['photoTitle']); ?></div>
<div id="layout">
	<div id="photo">
		<div><img id="moveImg" src="<?php echo $resizePhoto; ?>" alt="더블클릭하시면 창을 닫습니다." ondblclick="window.close();" /></div>
		<div id="exif"><?php showEXIF($nowPhoto['file_route']); ?></div>
	</div>
	<div id="comment"><?php echo stripslashes($nowPhoto['title']); ?> 
	<span>(<?php echo date('Y. m. d H:i', $nowPhoto['signdate']); 
	if($_SESSION['no'] == 1) { echo ' / <a href="#" onclick="deletePhoto('.$nowPhoto['uid'].');" title="이 사진을 사진첩에서 삭제 합니다.">delete</a>'; } ?> / 
	<a href="<?php echo $nowPhoto['file_route']; ?>" onclick="window.open(this.href, '_blank'); return false;" title="이 사진(그림)의 원본파일을 열거나 다운로드 합니다."><?php echo $fileName[2]; ?></a>)</span></div>
</div>
<div id="another">
	<?php
	$range = ceil($photo['num']/2);
	$beforeRange = $photoNo - $range - 1;
	$beforeRange = ($beforeRange > 0)?$beforeRange:0;
	$getListBefore = @mysql_query('select * from '.$dbFIX.'photo where uid <= '.$photoNo.' limit '.$beforeRange.', '.$photoNo);
	while($before = mysql_fetch_array($getListBefore)) {
		echo '<div><a href="view_photo.php?photoNo='.$before['uid'].'"><img src="phpThumb/phpThumb.php?src=../'.$before['file_route'].
		'&w='.$photo['width'].'&h='.$photo['height'].'&q='.$photo['quality'].'" alt="'.stripslashes($before['title']).'" /></a></div>';
	}
	$getListAfter = @mysql_query('select * from '.$dbFIX.'photo where uid > '.$photoNo.' limit '.$range);
	while($after = mysql_fetch_array($getListAfter)) {
		echo '<div><a href="view_photo.php?photoNo='.$after['uid'].'"><img src="phpThumb/phpThumb.php?src=../'.$after['file_route'].
		'&w='.$photo['width'].'&h='.$photo['height'].'&q='.$photo['quality'].'" alt="'.stripslashes($after['title']).'" /></a></div>';
	}
	?>
	<div class="clr"></div>
</div>
<script type="text/javascript">
//<![CDATA[
function deletePhoto(uid)
{
	if(confirm('정말로 보고 계시는 사진을 사진첩에서 삭제하시겠습니까?')) {
		location.href='view_photo.php?photoNo='+uid+'&deleteNo='+uid;
	}
}
new Draggable('photo', {revert:false});
//]]>
</script>
</body>
</html>