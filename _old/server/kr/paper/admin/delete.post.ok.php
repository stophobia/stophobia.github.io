<?php
/*
	GR Paper 포스트 모두 삭제
	작성자: 박희근 (http://sirini.net)
	수정일: 2008-12-7
	내  용: 그 동안 수집했던 모든 포스트들을 삭제한다. 그림과 태그들은 별도로 해야 한다.
	주  의: 관리자만 삭제 작업을 할 수 있다.
*/

include '../library/common.php';
$c = new GRCOMMON('../', 'text/xml');
if(!$c->isAdmin()) die('<?xml version="1.0" encoding="utf-8"?><grpaper><result>false</result></grpaper>');

@extract($_POST);
$c->db->query('truncate table '.$c->prefix.'feed');
$c->db->query('update '.$c->prefix.'feed_list set last_update = \'0\', total = \'0\'');
echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<grpaper>
	<result>true</result>
</grpaper>
