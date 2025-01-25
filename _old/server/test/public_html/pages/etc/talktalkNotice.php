<?
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_config.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_lib.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_function.inc.php";

if(@array_key_exists($row_member[id],$array_adminid) == true) {
	mysql_query("update odtTt set ttIsNotice = '".$_GET[nType]."' where ttNo ='".$_GET[ttNo]."'");
	echo "<script>parent.location.reload();</script>";
}
?>