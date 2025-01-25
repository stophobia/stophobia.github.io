<?php
/*
	GR Paper 로그인 처리
	작성자: 박희근 (http://sirini.net)
	수정일: 2008-08-23
	내  용: Ajax 로 넘어온 id 와 password 를 확인하여 (맞을 시) 세션을 생성, 결과를 리턴한다.
	참  고: password 값은 DB에 md5() 로 암호화해야 한다.
*/

include '../library/common.php';
$c = new GRCOMMON('../', 'text/xml');

@extract($_POST);
$isValid = $c->db->query('select uid from '.$c->prefix."user where id = '$id' and password = '".md5($password)."'");
$result = $isValid->fetch_array();
if($result['uid']) {
	$_SESSION['login'] = $result['uid'];
	$result = 'true';
} else $result = 'false';

echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<grpaper>
	<result><?php echo $result; ?></result>
</grpaper>
