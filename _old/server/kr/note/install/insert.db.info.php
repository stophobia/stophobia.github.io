<?php
include '../library/install.lib.php';
$install = new Install;
@extract($_POST);

// 접속 정보를 확인한 후 에러시 1 리턴
$testConnect = @mysql_connect($hostName, $userId, $password);
$testSelect = @mysql_select_db($dbName);
if(!$testConnect || !$testSelect) {
	@header('Content-Type: text/xml; charset=utf-8');
	echo '<?xml version="1.0" encoding="utf-8"?><error>1</error>';
	exit();
}

// DB접속 정보 저장 / DB 테이블들 생성 / 필요 디렉토리 생성
$install->makeDBInfo($hostName, $userId, $password, $dbName, $divide);
$install->makeDBTables($divide);
@mkdir('../session/', 0707);
@chmod('../session/', 0707);

// 최종 작업 결과 리턴 (여기까지 왔다면 0)
@header('Content-Type: text/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?><error>0</error>';
exit();
?>