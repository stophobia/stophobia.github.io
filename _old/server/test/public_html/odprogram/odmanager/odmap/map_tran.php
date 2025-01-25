<?
include "../../odcommon/od_config.inc.php";
include "../odcommon/od_function.inc.php";
include "../odcommon/od_adminAuthority.inc.php";

$Query  = " UPDATE odtProduct SET com_mapx = '$x', com_mapy = '$y', com_mapzoom = '$zoom' WHERE code = '$code'  ";
$Result = mysql_query($Query);
exit;


?>