<?php
/*
	GR Paper 로그아웃 처리
	작성자: 박희근 (http://sirini.net)
	수정일: 2008-08-23
	내  용: 로그아웃 처리를 한다. 로그아웃 후 첫화면으로 이동한다.
*/

include '../library/common.php';
$c = new GRCOMMON('../');
include '../config/base.php';
if(!$c->isLogin()) $c->alert('이미 로그아웃 하셨습니다.', $config['absPath']);
else {
	$_SESSION = array();
	$c->alert('로그아웃 처리가 완료되었습니다.', $config['absPath']);
}
?>
