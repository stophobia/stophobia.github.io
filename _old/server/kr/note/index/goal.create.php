<?php
/**
 * @update 2008-12-24
 * @comment 목표 생성시 처리
 */
include '../grnote.config.php';
include '../library/goal.lib.php';
$G = new Goal('../');
@extract($_POST);

// 권한 체크, 없다면 에러 1 리턴
$getUser = @mysql_fetch_array(mysql_query('select level from '.$G->divide.'users where uid = '.$_SESSION['userNo']));
if(!$getUser['level']) $getUser['level'] = 1;
if($_SESSION['userNo'] != 1 && ($getUser['level'] < $grNote['goal']['makeLevel'])) {
	@header('Content-Type: text/xml; charset=utf-8');
	echo '<?xml version="1.0" encoding="utf-8"?><error>1</error>';
	exit();
}

// 특수문자 재처리
$original = array('@amp;', '@plus;', '@percent;', '@sharp;', '@question;', '<p>', '</p>');
$change = array('&', '+', '%', '#', '?', '', '<br />');
$codename = addslashes(str_replace($original, $change, $codename));
$version = addslashes(str_replace($original, $change, $version));
$goal = str_replace($original, $change, addslashes($goal));

// 목표 생성 or 수정
if($modifyNo) {
	$sql = "update {$G->divide}goals set codename = '$codename', version = '$version', goal = '$goal' where uid = $modifyNo";
} else {
	$sql = "insert into {$G->divide}goals set uid = '', project_id = '$projectID', codename = '$codename', ".
		"version = '$version', goal = '$goal', ticket_done = 0, ticket_yet = 0";
}
@mysql_query($sql);

// 최종 작업 결과 리턴 (여기까지 왔다면 0)
@header('Content-Type: text/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?><error>0</error>';
?>