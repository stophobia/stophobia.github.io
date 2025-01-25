<?php
/*
	GR Paper 썸네일 정보 모두 삭제
	작성자: 박희근 (http://sirini.net)
	수정일: 2008-09-06
	내  용: 그림보기시 사용되는 이미지 정보들을 모두 제거
	주  의: 관리자만 작업을 할 수 있다.
*/

include '../library/common.php';
$c = new GRCOMMON('../', 'text/xml');
if(!$c->isAdmin()) die('<?xml version="1.0" encoding="utf-8"?><grpaper><result>false</result></grpaper>');

$c->db->query('truncate table '.$c->prefix.'image');
echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<grpaper>
	<result>true</result>
</grpaper>
