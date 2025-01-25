<?
	// 필요한 설정파일 불러오기
	include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_config.inc.php";
	include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_lib.inc.php";

	$_GET[cateCode] = $_GET[cateCode] ? $_GET[cateCode] : "05";

	$cInfo = mysql_fetch_array(mysql_query("select * from odtProduct where code = parent_code and code ='".info_nowsale($_GET[cateCode])."' limit 1"));

	echo time().'/';
	echo strtotime($cInfo[live_start_time])+($cInfo[live_time]*60)+$cInfo[live_time_sec];  	
?>