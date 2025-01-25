<?
############################################################
## Onedaynet RSS 데이터정보 : Ver 0.1-beta-
## Create by Tindevil@nate.com
## BetaVersion
############################################################
## 자유로운 편집 및 사용이 가능합니다. 제작자주석삭제는 허락하지 않습니다.
############################################################
if(@file_exists("../mall/common/db_conf.php")) {
	@include "../mall/common/db_conf.php";   //open Database 
}
else {
	@include "../odprogram/odcommon/od_db_conf.php";   //open Database 
}

##메세지박스를 표시하는 스크립트
function msgbox($data) {
    echo "<script>alert($data);</script>";
}

function getScalar($addonquery) {
    $addonResult = mysql_query($addonquery);
    $addonRecord = mysql_fetch_array($addonResult);
    return $addonRecord[0];
}
function getRow($addonquery) {
    $addonResult = mysql_query($addonquery);
    $addonRecord = mysql_fetch_array($addonResult);
    return $addonRecord;
}
function getRowCount($addonquery) {
    $addonResult = @mysql_query($addonquery);
   return @mysql_num_rows($addonResult);
}
function getRows($addonquery) {
    $addonResult = mysql_query($addonquery);
    return $addonResult;
}

?>