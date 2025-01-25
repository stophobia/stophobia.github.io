<?php
/*
	GR Paper RSS피드 그룹 삭제 처리
	작성자: 박희근 (http://sirini.net)
	수정일: 2008-08-23
	내  용: Ajax 로 넘어온 uid 를 확인하여 해당 그룹을 삭제한다.
	참  고: 그룹은 관리 목적용으로 사용되는 개념으로, 삭제한다고 해서 그 그룹에 속한 피드들이 삭제되진 않는다.
	          삭제된 그룹에 속한 RSS피드들은 모두 기본 그룹(uid: 1)으로 소속 변경된다.
	          기본 그룹은 삭제할 수 없다. 수정만 가능하다.
	주  의: 관리자만 추가 작업을 할 수 있다.
*/

include '../library/common.php';
$c = new GRCOMMON('../', 'text/xml');
if(!$c->isAdmin()) die('<?xml version="1.0" encoding="utf-8"?><grpaper><result>false</result></grpaper>');

@extract($_POST);
$getCount = $c->db->query('select count from '.$c->prefix.'feed_group where uid = '.$uid);
$plus = $getCount->fetch_array();
$c->db->query('delete from '.$c->prefix.'feed_group where uid = '.$uid.' limit 1');
$c->db->query('update '.$c->prefix.'feed_list set group_uid = 1, count = count + '.$plus['count'].' where group_uid = '.$uid);
echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<grpaper>
	<result>true</result>
</grpaper>
