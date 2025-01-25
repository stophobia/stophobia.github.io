<?php
/*
	GR Paper 관리자 비밀번호 변경
	작성자: 박희근 (http://sirini.net)
	수정일: 2008-08-27
	내  용: 새 비밀번호로 변경한다.
	주  의: 관리자만 이 작업을 할 수 있다.
*/

include '../library/common.php';
$c = new GRCOMMON('../', 'text/xml');
if(!$c->isAdmin()) die('<?xml version="1.0" encoding="utf-8"?><grpaper><result>false</result></grpaper>');

$pass = trim($_POST['password']);
$c->db->query('update '.$c->prefix.'user set password = \''.md5($pass).'\' where uid = 1');
echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<grpaper>
	<result>true</result>
</grpaper>
