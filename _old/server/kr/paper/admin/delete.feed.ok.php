<?php
/*
	GR Paper RSS피드 삭제 처리
	작성자: 박희근 (http://sirini.net)
	수정일: 2008-08-26
	내  용: Ajax 로 넘어온 uid 를 확인하여 해당 RSS피드를 수집대상에서 제외한다.
	주  의: 관리자만 추가 작업을 할 수 있다.
*/

include '../library/common.php';
$c = new GRCOMMON('../', 'text/xml');
if(!$c->isAdmin()) die('<?xml version="1.0" encoding="utf-8"?><grpaper><result>false</result></grpaper>');

@extract($_POST);
$getGroupUid = $c->db->query('select group_uid from '.$c->prefix.'feed_list where uid = '.$uid.' limit 1')->fetch_array();
$c->db->query('update '.$c->prefix.'feed_group set count = count - 1 where uid = '.$getGroupUid['group_uid']);
$c->db->query('delete from '.$c->prefix.'feed_list where uid = '.$uid.' limit 1');
if($deleteAll) {
	$getFeedUid = $c->db->query('select uid from '.$c->prefix.'feed where blog_uid = '.$uid);
	while($fuid = $getFeedUid->fetch_array()) {
		$c->db->query('delete from '.$c->prefix.'image where feed_uid = '.$fuid['uid']);
	}
	$c->db->query('delete from '.$c->prefix.'feed where blog_uid = '.$uid);
}
echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<grpaper>
	<result>true</result>
</grpaper>
