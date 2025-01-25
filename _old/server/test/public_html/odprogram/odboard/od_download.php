<?
	include "../odcommon/od_config.inc.php";
	include "../odcommon/od_function.inc.php";
	include "od_board.inc.php";
	
	authorityTest("Read");
	
	if(eregi("(MSIE*)", $HTTP_USER_AGENT)) {
		Header("Content-type: application/octet-stream");
		Header("Content-Length: ".filesize("$boardUploadImgDIR/$file_name"));
		Header("Content-Disposition: attachment; filename=$file_name");
		Header("Content-Transfer-Encoding: binary");
		Header("Pragma: no-cache");
		Header("Expires: 0");
	}
	else {
		Header("Content-type: file/unknown");  
		Header("Content-Length: ".filesize("$boardUploadImgDIR/$file_name"));
		Header("Content-Disposition: attachment; filename=$file_name");
		Header("Content-Description: PHP3 Generated Data");
		Header("Pragma: no-cache");
		Header("Expires: 0");
	}
	
	$fp = fopen("$boardUploadImgDIR/$file_name", "r");
	
	if(!fpassthru($fp)) fclose($fp);
?>