<?php
// 필요한 설정파일 불러오기
include "../../odprogram/odcommon/od_config.inc.php";
include "../../odprogram/odcommon/od_lib.inc.php";
include "../../odprogram/odcommon/od_function.inc.php";
mysql_query("insert into odtCounterSet set type='fav' , ip='".$_SERVER[REMOTE_ADDR]."', id ='".$row_member[id]."', regidate = now()");
?>