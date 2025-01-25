<?php
/*
	GR Paper 피드 정리하기
	작성자: 박희근 (http://sirini.net)
	수정일: 2008-08-27
	내  용: 더 이상 수집하지 않는 피드 주소를 확인해서, 예전에 저장했던 게 있다면 마저 삭제한다.
	주  의: 관리자만 이 작업을 할 수 있다.
*/

include '../library/common.php';
$c = new GRCOMMON('../', 'text/xml');
if(!$c->isAdmin() || !$_POST['x']) die('<?xml version="1.0" encoding="utf-8"?><grpaper><result>false</result></grpaper>');

$existFeeds = array();
$getFeed = $c->db->query('select uid from '.$c->prefix.'feed_list');
while($uids = $getFeed->fetch_array()) $existFeeds[] = $uids['uid'];

$getPost = $c->db->query('select blog_uid from '.$c->prefix.'feed');
while($posts = $getPost->fetch_array()) {
	if(in_array($posts['blog_uid'], $existFeeds)) continue;
	else $c->db->query('delete from '.$c->prefix.'feed where blog_uid = '.$posts['blog_uid']);
}
echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<grpaper>
	<result>true</result>
</grpaper>
