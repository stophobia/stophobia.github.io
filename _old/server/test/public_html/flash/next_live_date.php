<?php
	// 필요한 설정파일 불러오기
	include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_config.inc.php";

	$que = "select live_start_time,live_time from odtProduct where cateCode='03' and code = parent_code and live_start_time > '".date('Y-m-d H:i:s')."' order by live_start_time  limit 1";
	$res = mysql_query($que);
	$row = mysql_fetch_array($res);

	$liveDate = explode("-",date('Y-m-d-H-i-s',strtotime($row[live_start_time])));

	echo time().'/';
	echo mktime($liveDate[3]*1,$liveDate[4]*1,$liveDate[5]*1,$liveDate[1],$liveDate[2],$liveDate[0]);  	
?>