<?php
    ## ConnectINFO.inc.php 파일 인클루드 ############################
    include "../odcommon/od_config.inc.php";
    include "$folderpath_common/od_function.inc.php";
    include "$folderpath_common/od_lib.inc.php";

    $oid = $_REQUEST['oid'];

    ## 주문정보 호출
    $orow = mysql_fetch_array(mysql_query("SELECT * FROM odtOrder WHERE ordernum = '$oid'"));






	// 주문확인 및 결제 공통 정보 ---> PG사 추가에 따른 공통 파일 마련
	include "od_ordercomplete.common_inc.php";


?>