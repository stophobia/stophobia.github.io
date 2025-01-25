<?php
/**
 * @update 2008-11-21
 * @comment 위키 파일 업로드
 */
include '../grnote.config.php';
include '../library/wiki.lib.php';
$W = new Wiki('../');
@extract($_POST);
@extract($_FILES);
@header('Content-Type: text/html; charset=utf-8');

// 수정권한 체크, 없다면 에러 2 리턴
$getUser = @mysql_fetch_array(mysql_query('select level from '.$W->divide.'users where uid = '.$_SESSION['userNo']));
if(!$getUser['level']) $getUser['level'] = 1;
if($_SESSION['userNo'] != 1 && ($getUser['level'] < $grNote['wiki']['uploadLevel'])) {
	echo '<script> alert(\'업로드할 권한이 없습니다.\'); location.href=\'theme/'.$grNote['theme'].'/main.wiki.upload.form.php\'; </script>';
	exit();
}

// 파일 업로드 실시
if($upfile['size'] > 0) {
	if(!is_uploaded_file($upfile['tmp_name'])) {
		@header('Content-Type: text/xml; charset=utf-8');
		echo '<script> alert(\'정상적으로 파일을 업로드 해 주십시오.\'); location.href=\'theme/'.$grNote['theme'].'/main.wiki.upload.form.php\'; </script>';
		exit();
	}
	$upfile['tmp_name'] = str_replace('\\\\', '\\', $upfile['tmp_name']);
	$upfile['name'] = str_replace(' ', '_', $upfile['name']);
	$upfile['name'] = str_replace('-', '_', $upfile['name']);
	$tmp = explode('.', $upfile['name']);
	$filetype = $tmp[count($tmp) - 1];
	$onlyName = $upfile['name'];
	$y = date('Y');
	$m = date('m');
	$d = date('d');
	if(!is_dir('../data/'.$y)) {
		@mkdir('../data/'.$y, 0705);
		@chmod('../data/'.$y, 0707);
	}
	if(!is_dir('../data/'.$y.'/'.$m)) {
		@mkdir('../data/'.$y.'/'.$m, 0705);
		@chmod('../data/'.$y.'/'.$m, 0707);
	}
	if(!is_dir('../data/'.$y.'/'.$m.'/'.$d)) {
		@mkdir('../data/'.$y.'/'.$m.'/'.$d, 0705);
		@chmod('../data/'.$y.'/'.$m.'/'.$d, 0707);
	}
	$savePath = '../data/'.$y.'/'.$m.'/'.$d.'/';

	$upfile['name'] = md5($upfile['name']).'.'.$filetype;
	if(file_exists($savePath.$upfile['name'])) {
		$dirName = date('Ymd', time());
		@mkdir($savePath.$dirName.'/', 0705);
		@chmod($savePath.$dirName.'/', 0707);
		$filename = $savePath.$dirName.'/'.substr(md5(time()), -5).'_'.$upfile['name'];
	}
	else $filename = $savePath.$upfile['name'];

	if(eregi('\.inc|\.phtm|\.htm|\.shtm|\.ztx|\.php|\.dot|\.asp|\.cgi|\.pl|\.js|\.sql|\.sh|\.py|\.htaccess|\.jsp', $filename)) {
		echo '<script> alert(\'HTML 관련 파일들은 업로드 하실 수 없습니다.\'); location.href=\'theme/'.$grNote['theme'].'/main.wiki.upload.form.php\'; </script>';
		exit();
	}

	if(!move_uploaded_file($upfile['tmp_name'], $filename)) {
		echo '<script> alert(\'파일을 업로드하지 못했습니다.\'); location.href=\'theme/'.$grNote['theme'].'/main.wiki.upload.form.php\'; </script>';
		exit();
	}

	@mysql_query("insert into {$W->divide}files set uid = '', file_route = '$filename', file_name = '$onlyName', writer = '".$_SESSION['userNo']."', hit = 0");

	// 최종 작업 결과 리턴
	$filesize = @filesize($filename);
	if($filesize > 0 && $filesize < 1000) $filesize .= ' Byte';
	elseif($filesize > 1000 && $filesize < 1000000) $filesize = ceil($filesize / 1000) . ' KB';
	elseif($filesize > 1000000) $filesize = ceil($filesize / 1000000) . ' MB';
	$type = array('ai', 'alz', 'asf', 'bmp', 'dll', 'doc', 'eml', 'exe', 'fla', 'hlp', 'hwp', 'js', 'mid', 'mov', 'mp3', 'mpeg', 'pcx', 'pdf', 'ppt', 'psd', 'rar', 'reg', 'swf', 'tif', 'txt', 'url', 'wav', 'xls', 'zip', 'iso');
	$typeCount = count($type);
	for($t=0; $t<$typeCount; $t++)
	{
		if(eregi('\.'.$type[$t], $onlyName))
		{
			$ft = $type[$t];
			break;
		}
	}
	if(!isset($ft)) $ft = 'etc';
	echo '<script> alert(\'파일 업로드를 완료하였습니다.\'); 	location.href=\'theme/'.$grNote['theme'].'/main.wiki.upload.form.php?filename='.urlencode($onlyName).'&link='.$filename.'&filetype='.$ft.'&filesize='.$filesize.'\'; </script>';
}
?>