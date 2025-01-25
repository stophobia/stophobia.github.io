<?php
include '../db.info.php';
include '../grnote.config.php';
@mysql_connect($hostName, $userId, $password);
@mysql_select_db($dbName);
@extract($_POST);

// 등록을 받고 있는지 확인
if($grNote['user']['joinOK'] == 1) {
	@header('Content-Type: text/xml; charset=utf-8');
	echo '<?xml version="1.0" encoding="utf-8"?><error>3</error>';
	exit();
}

// 아이디가 중복인지 체크
$getID = @mysql_fetch_array(mysql_query('select id from '.$divide.'users where id = \''.$id.'\''));
if($getID['id']) {
	@header('Content-Type: text/xml; charset=utf-8');
	echo '<?xml version="1.0" encoding="utf-8"?><error>2</error>';
	exit();
}

// 등록
$sql = "insert {$divide}users set uid = '', id = '$id', password = '".md5($password)."', nickname = '$nickname', email = '$email', ".
	"homepage = '$homepage', make_time = '".time()."', level = '2', point = '0', self_info = '$selfInfo'";
$result = @mysql_query($sql);
if(!$result) {
	@header('Content-Type: text/xml; charset=utf-8');
	echo '<?xml version="1.0" encoding="utf-8"?><error>1</error>';
	exit();
}

// 최종 작업 결과 리턴 (여기까지 왔다면 0)
@header('Content-Type: text/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?><error>0</error>';
exit();
?>