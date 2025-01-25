<?php
$prefix = '../';
include '../php_head.php';
if(!$_SESSION['no']) exit();
if($_POST['comment']) $comment = stripslashes($_POST['comment']); else $comment = '';

@header('Content-Type: text/html; charset=utf-8');
include $prefix.'lib/common.php';
dbConn($prefix);

// 이미지 삭제
if($_GET['deleteTarget']) {
	$getIMG = @mysql_fetch_array(mysql_query('select file_route from '.$dbFIX.'image where uid = '.$_GET['deleteTarget']));
	@unlink('../'.$getIMG['file_route']);
	@mysql_query('delete from '.$dbFIX.'image where uid = '.$_GET['deleteTarget'].' limit 1');
	error('이미지를 삭제하였습니다.', 'location.href=\'admin_upload.php\'');
}

// 이미지 업로드 작업
if(array_key_exists('file', $_FILES) && $_FILES['file']) 
{
	$filename = $_FILES['file']['name'];
	$filetype = $_FILES['file']['type'];
	$filesize = $_FILES['file']['size'];
	$filetmpname = $_FILES['file']['tmp_name'];

	if($filesize > 0)
	{
		if(!is_uploaded_file($filetmpname)) error('정상적으로 파일을 업로드 해 주세요');

		$filename = strtolower($filename);
		$realType = end(explode('.', $filename));
		if(!in_array('.'.$realType, array('.jpg', '.gif', '.bmp', '.png', '.jpeg'))) error('그림파일이 아닙니다');

		$year = date('Y');
		$month = date('m');
		$day = date('d');

		$filetmpname = str_replace('\\\\', '\\', $filetmpname);
		$filename = str_replace(' ', '_', $filename);
		$filename = str_replace('-', '_', $filename);

		$yearPath = '../data/'.$year.'/';
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
		
		if(preg_match("/[가-힣]/uism", $filename)) $filename = md5($filename).'.'.$realType;
		if(file_exists($dayPath.$filename)) $filename = substr(md5(time()), -5).'_'.$filename;
		if(!move_uploaded_file($filetmpname, $dayPath.$filename)) {
			error('파일을 업로드 하지 못했습니다. 파일용량을 확인해 보세요');
		}

		@mysql_query("insert into {$dbFIX}image set uid = '', file_route = '".str_replace('../', '', $dayPath.$filename)."', signdate = ".time());
	}
	?>
	<script type="text/javascript">//<![CDATA[
	// 본문 작성폼에 자동으로 밀어넣기
		opener.tinyMCE.triggerSave();
		var original = opener.document.new_post.content.value;
		opener.tinyMCE.activeEditor.setContent(original + '<img src="http://<?php echo $_SERVER['HTTP_HOST'].str_replace('admin/../', '', dirname($_SERVER['SCRIPT_NAME']).'/'.$dayPath.$filename); ?>" alt="previewImg" />' + '<?php echo ($comment) ? '<p><span style="color: #999">('.$comment.')</span></p>' : '<p>&nbsp;</p>'; ?>');

		alert('그림(사진)을 본문에 자동으로 추가했습니다.');
	//]]></script>
	<?php
	move('admin_upload.php?upfile='.$dayPath.$filename);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="GR Blog" />
<title>GR Blog 그림(사진) 첨부하기</title>
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
사진(그림) 첨부하기
</div>

<form id="upload" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
<div id="field">
	<p>간단한 설명: <input type="text" name="comment" title="(필요시 이런 형태로 사진 설명을 남길 수 있습니다.)" /></p>
	<p>파일 업로드: <input type="file" name="file" /><input type="submit" value="업로드" class="s" /></p>
</div>
<?php 
// 이미지를 업로드 한 후
if($_GET['upfile']) { ?>
<div id="helpMsg"><img src="../image/icon_information.gif" alt="" /> 아래 그림을 마우스로 드래그 하여 본문에 넣으면 됩니다. <a href="admin_upload.php">[목록보기]</a></div>
<img src="http://<?php echo $_SERVER['HTTP_HOST'].str_replace('admin/../', '', dirname($_SERVER['SCRIPT_NAME']).'/'.$_GET['upfile']); ?>" alt="previewImg" />
<?php 
// 이미지를 업로드 하지 않았을 때	
} else { ?>
<div id="imageList">
	<table rules="none" summary="GR Blog Image List" cellpadding="0" cellspacing="0" border="0">
	<caption></caption>
	<colgroup>
	<col style="width: 100px" />
	<col />
	</colgroup>
	<thead>
	<tr>
		<th>미리보기</th>
		<th>파일명/등록일자</th>
	</tr>
	</thead>
	<tbody>
	<?php
	// 업로드했던 이미지들의 목록 보기
	if(!$_GET['p']) $p = 1; else $p = $_GET['p'];
	$viewNum = 30;
	$firstRecord = ($p - 1) * $viewNum;
	$totalCount = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'image'));
	$totalPage = ceil($totalCount[0] / $viewNum);
	$paging = getPaging(10, $p, $totalPage, 'admin_upload.php?p=');
	$getImageList = @mysql_query('select uid, file_route, signdate from '.$dbFIX.'image order by uid desc limit '.$firstRecord.', '.$viewNum);
	while($imgs = @mysql_fetch_array($getImageList)) {
	?>
	<tr>
		<td><img src="../phpThumb/phpThumb.php?src=../<?php echo $imgs['file_route']; ?>&amp;w=90&amp;h=70&amp;q=100&amp;fltr[]=usm|99|0.5|3" alt="미리보기" /></td>
		<td><div class="filename">
			<a href="admin_upload.php?upfile=../<?php echo $imgs['file_route']; ?>"><?php echo end(explode('/', $imgs['file_route'])); ?></a> 
			<a href="admin_upload.php?deleteTarget=<?php echo $imgs['uid']; ?>" title="이 이미지를 삭제합니다."><img src="../image/icon_delete_blog.gif" alt="삭제" /></a></div>
			<div class="date"><?php echo date('Y.m.d H:i:s', $imgs['signdate']); ?></div></td>
	</tr>
	<?php } if($paging) { ?>
	<tr>
		<td colspan="2"><?php echo $paging; ?></td>
	</tr>
	<?php } // if $paging ?>
	</tbody>
	</table>
</div>
<?php } ?>
</form>
</body>
</html>