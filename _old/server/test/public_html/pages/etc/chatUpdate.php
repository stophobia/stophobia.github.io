<?php
// 필요한 설정파일 불러오기
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_config.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_lib.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_function.inc.php";

if($row_member[id]) {
	if($_GET[type] == "nick")  @mysql_query("update odtMember set chatNickName = '".$_GET[nick]."' where id='".$row_member[id]."'");
	if($_GET[type] == "color") @mysql_query("update odtMember set chatColor = '".$_GET[color]."' where id='".$row_member[id]."'");
}
?>