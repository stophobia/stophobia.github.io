<?php
/*
	GR Paper RSS피드 그룹 추가(수정) 처리
	작성자: 박희근 (http://sirini.net)
	수정일: 2008-08-23
	내  용: Ajax 로 넘어온 값들을 확인하여 그룹을 추가/수정 한다.
	주  의: 관리자만 그룹 추가/수정 작업을 할 수 있다.
*/

include '../library/common.php';
$c = new GRCOMMON('../', 'text/xml');
if(!$c->isAdmin() || ($_POST['uid'] == 1)) die('<?xml version="1.0" encoding="utf-8"?><grpaper><result>false</result></grpaper>');

@extract($_POST);
$original = array('@amp;', '@plus;', '@percent;', '@rslash;', '@sharp;');
$change = array('&amp;', '+', '%', '￦', '#');
$groupName = str_replace($original, $change, $groupName);
$groupInfo = str_replace($original, $change, $groupInfo);
if($modifyUid) {
	$sql = 'update '.$c->prefix."feed_group set name = '$groupName', info = '$groupInfo' where uid = ".$modifyUid;
} else {
	$sql = 'insert into '.$c->prefix."feed_group set uid = '', name = '$groupName', info = '$groupInfo', count = 0, is_open = 1";
}
$c->db->query($sql);
echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<grpaper>
	<result>true</result>
</grpaper>
