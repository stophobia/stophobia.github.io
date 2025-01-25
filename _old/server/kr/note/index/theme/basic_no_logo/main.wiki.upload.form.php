<?php 
/**
 * @update 2008-11-21
 * @comment 위키 파일 업로드 디자인 폼
 */
include '../../../grnote.config.php'; 
@extract($_GET);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="GR Note" />
<meta name="Author" content="<?php echo $grNote['author']; ?>" />
<meta name="Nationality" content="<?php echo $grNote['nationality']; ?>" />
<meta name="copyright" content="<?php echo $grNote['copyright']; ?>" />
<link rel="stylesheet" href="style.css" type="text/css" title="style" />
<title><?php echo $grNote['title']; ?></title>
</head>
<body>
<div id="uploadForm">
	<div id="title<?php echo ($filename)?'Complete':''; ?>"><?php echo ($filename)?'파일이 업로드 되었습니다. (드래그로 본문에 복사하세요!)':'파일을 업로드 해 주십시오.'; ?></div>
	<div id="upload">
	<form name="uploadFile" action="../../wiki.upload.php" method="post" enctype="multipart/form-data">
		<input type="file" name="upfile" /><input type="image" src="images/wiki.upload.ok.gif" />
	</form>
	</div>
	<?php 
	if($filename) { 
		$filename = urldecode($filename);	
		$ext = end(explode('.', $filename));
		if($ext == 'jpg' || $ext == 'gif' || $ext == 'bmp' || $ext == 'png')
			$showCopy = '(아래 이미지를 마우스로 드래그 하여 본문에 떨어트려주세요 ↓)<br /><br /><img src="../../'.$link.'" class="upload-image" alt="" />';
		else
			$showCopy = '<a href="../../'.$link.'"><img src="../../images/file_icon/'.$filetype.'.gif" alt="icon" /> '.$filename.' ('.$filesize.')</a><br /><br />(↑ 위 파일명을 드래그 한 후 본문에 그대로 붙여 넣으시면 됩니다.)';
	?>

	<div id="uploadContent"><?php echo $showCopy; ?></div>
	
	<?php } ?>
</div>
<body>
</html>