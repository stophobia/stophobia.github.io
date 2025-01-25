<?
$onedaynet_id = "wbshim";

## MySQL DB 접속
$idTmp = $onedaynet_id."_id";
$pwTmp = $onedaynet_id."_wb4153";
$dbTmp = $onedaynet_id."_db";


$connect = mysql_connect("localhost",$idTmp,$pwTmp) or die("Failed connecting to MySQL...   ");
mysql_select_db($dbTmp,$connect);
?>
