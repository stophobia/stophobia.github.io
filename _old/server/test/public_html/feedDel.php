<?php
// 필요한 설정파일 불러오기
	include dirname(__FILE__)."/odprogram/odcommon/od_config.inc.php";
	include dirname(__FILE__)."/odprogram/odcommon/od_lib.inc.php";
	include dirname(__FILE__)."/odprogram/odcommon/od_function.inc.php";	

	if($_GET[email]) {
		// 구독자 리스트에서 제거
		mysql_query("delete from feedTable where ft_email = '".$_GET[email]."'");

		// 회원은 수신거부로 수정
		mysql_query("update odtMember set mailling='N' where email = '".$_GET[email]."'");
	}

	error_msgall('수신거부 처리 되었습니다. 감사합니다.','close');
?>