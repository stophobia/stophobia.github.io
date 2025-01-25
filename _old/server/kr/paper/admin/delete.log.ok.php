<?php
/*
	GR Paper 수집 기록 삭제
	작성자: 박희근 (http://sirini.net)
	수정일: 2008-12-7
	내  용: 수집기 활동 기록을 삭제.
	주  의: 관리자만 삭제 작업을 할 수 있다.
*/

include '../library/common.php';
$c = new GRCOMMON('../', 'text/xml');
if(!$c->isAdmin()) die('<?xml version="1.0" encoding="utf-8"?><grpaper><result>false</result></grpaper>');

@extract($_POST);
$c->db->query('TRUNCATE TABLE '.$c->prefix.'log');
echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<grpaper>
	<result>true</result>
</grpaper>
