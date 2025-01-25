<?php
$prefix = '../';
include '../php_head.php';
if(!$_SESSION['no']) exit();
if($_POST['comment']) $comment = stripslashes($_POST['comment']); else $comment = '';

@header('Content-Type: text/html; charset=utf-8');
@extract($_GET);
if(array_key_exists('fileDelete', $_GET) && $_GET['fileDelete']) @unlink('../data/file/'.urldecode($_GET['fileDelete']));
include $prefix.'lib/common.php';
dbConn($prefix);

if(array_key_exists('file', $_FILES) && $_FILES['file'])
{
	$filename = $_FILES['file']['name'];
	$filetype = $_FILES['file']['type'];
	$filesize = $_FILES['file']['size'];
	$filetmpname = $_FILES['file']['tmp_name'];

	if($filesize > 0)
	{
		if(!is_uploaded_file($filetmpname)) error('정상적으로 파일을 업로드 해 주세요');
		if(preg_match('/\.(inc|phtm|htm|shtm|ztx|php|dot|asp|cgi|pl|js|sql|sh|py|htaccess)/i', $filename))
			error('HTML, Server side script 관련 파일은 업로드 하실 수 없습니다.');

		$year = date('Y');
		$month = date('m');
		$day = date('d');

		$filename = strtolower($filename);
		$type = array('ai', 'alz', 'asf', 'bmp', 'dll', 'doc', 'eml', 'exe', 'fla', 'hlp', 'hwp', 'js', 'mid', 'mov', 'mp3', 'mpeg', 'pcx', 'pdf', 'ppt', 'psd', 'rar', 'reg', 'swf', 'tif', 'txt', 'url', 'wav', 'xls', 'zip');
		$typeCount = count($type);
		$realType = end(explode('.', $filename));
		for($t=0; $t<$typeCount; $t++)
		{
			if($type[$t] == $realType) {
				$ft = $type[$t];
				break;
			}
		}
		if(!isset($ft)) $ft = $realType;

		$filetmpname = str_replace('\\\\', '\\', $filetmpname);
		$filename = str_replace(' ', '_', $filename);
		$filename = str_replace('-', '_', $filename);
		$originFN = $filename;

		$basePath = '../data/file/';
		if(!is_dir($basePath))
		{
			@mkdir($basePath);
			@chmod($basePath, 0707);
		}

		$yearPath = $basePath.$year.'/';
		if(!is_dir($yearPath)) {
			@mkdir($yearPath);
			@chmod($yearPath, 0707);
		}

		$monthPath = $yearPath.$month.'/';
		if(!is_dir($monthPath)) {
			@mkdir($monthPath);
			@chmod($monthPath, 0707);
		}

		$dayPath = $monthPath.$day.'/';
		if(!is_dir($dayPath)) {
			@mkdir($dayPath);
			@chmod($dayPath, 0707);
		}

		if(preg_match("/[가-힣]/uism", $filename)) {
			$filename = md5($filename).'.'.$ft;
		}
		if(file_exists($dayPath.$filename)) $filename = substr(md5(time()), -5).'_'.$filename;

		if(!move_uploaded_file($filetmpname, $dayPath.$filename)) 
			error('파일 업로드 실패. 파일용량이 지나치게 큰 것은 아닌지 확인해 보세요.');
	}
	?>
	<script type="text/javascript">//<![CDATA[
	// 본문 작성폼에 자동으로 밀어넣기
		opener.tinyMCE.triggerSave();
		var original = opener.document.new_post.content.value;
		opener.tinyMCE.activeEditor.setContent(original + '<p><a href="<?php echo dirname($_SERVER['SCRIPT_NAME']).'/'.$dayPath.$filename; ?>" title="클릭 시 받습니다" class="down">{{{<?php echo $ft; ?>}}} <?php echo $filename; ?></a></p>' + '<?php echo ($comment) ? '<p><span style="color: #999">('.$comment.')</span></p>' : '<p>&nbsp;</p>'; ?>');

		alert('파일 다운로드 링크를 본문에 자동으로 추가했습니다.');
	//]]></script>
	<?php
	move('admin_file_upload.php?upfile='.$dayPath.$filename.'&ofn='.$originFN.'&ft='.$ft);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="GR Blog" />
<title>GR Blog 파일 첨부하기</title>
<link rel="stylesheet" href="../css/upload_style.css" type="text/css" title="style" />
<style type="text/css">/*<![CDATA[*/
#field {
	text-align: left;
	margin-left: 20px;
}
#field input {
	border: #ddd 1px solid;
	vertical-align: middle;
}
#field input[type="text"] {
	width: 150px;
}
/*]]>*/</style>
</head>
<body>
<div id="top">
일반파일 첨부하기
</div>

<form id="upload" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
<div id="field">
	<p>간단한 설명: <input type="text" name="comment" title="(필요시 이런 형태로 파일 설명을 남길 수 있습니다.)" /></p>
	<p>파일 업로드: <input type="file" name="file" /><input type="submit" value="업로드" class="s" /></p></div>
</div>
</form>
<div id="done">
<?php if($_GET['upfile']) { ?>
<p>&nbsp;<a href="<?php echo $upfile; ?>" title="클릭 시 받습니다" class="down">{{{<?php echo $ft; ?>}}} <?php echo $ofn; ?></a>&nbsp;&nbsp;</p>
<br /><br /><br /><span style="color: #999; cursor: help" title="위의 『{{{<?php echo $ft; ?>}}} <?php echo rawurldecode($ofn); ?>』을 마우스로 드래그 하신 후, 글 작성 화면에 끌어다 놓으시면 됩니다.">(위의 파일명을 드래그 한 후 편집창에 드롭 하시면 붙여넣기 됩니다.)</span>
<?php } ?>
</div>
</body>
</html>
