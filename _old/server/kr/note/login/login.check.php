<?php
/**
 * @update 2008-11-21
 * @comment 로그인 시 처리
 */
include '../library/login.lib.php';
$login = new Login('../');
@extract($_POST);

// 로그인 정보 받고 맞을시 세션 생성
$result = $login->idPasswordCheck($id, $password);
if(!$result) {
	@header('Content-Type: text/xml; charset=utf-8');
	echo '<?xml version="1.0" encoding="utf-8"?><lists><error>1</error><isAdmin>0</isAdmin><key>0</key></lists>';
	exit();
}

// 최종 작업 결과 리턴 (여기까지 왔다면 0)
@header('Content-Type: text/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?><lists><error>0</error><isAdmin>'.$login->isAdmin().'</isAdmin><key>'.$result.'</key></lists>';
exit();
?>