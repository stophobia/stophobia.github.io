<?php
	// 필요한 설정파일 불러오기
	include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_config.inc.php";
	include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_function.inc.php";
	include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_lib.inc.php";

	echo time().'/';
	echo strtotime(date_nextsale('03'))+60*60*$row_setup[changeTime];  	 	
?>