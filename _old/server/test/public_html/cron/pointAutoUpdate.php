<?php
header("Content-Type: text/html; charset=euc-kr"); 
## MySQL DB 접속
include dirname(__FILE__)."/../odprogram/odcommon/od_db_conf.php";


$que = "select * from odtPointLog where pointStatus ='N' and pointID != '' and redRegidate <= '".date('Y-m-d')."' and redRegidate >= '2009-01-01'";

$res = mysql_query($que);
while($row = mysql_fetch_array($res)) {
	mysql_query("update odtPointLog set pointStatus='Y' where pointNo = '".$row[pointNo]."'");
	mysql_query("update odtMember set point = point + ".$row[pointPoint]." where id ='".$row[pointID]."'");
}


## snsBuyTime 3일 이후 데이터 삭제
$del_time = date("Y-m-d H:i:s" , strtotime("-3 day"));
$del_qry = "delete FROM snsBuyTime WHERE date < '$del_time'";
mysql_query($del_qry);


?>
