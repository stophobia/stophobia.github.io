<?php
/**
 * @update 2008-12-24
 * @comment 프로젝트 생성하기
 */
include '../grnote.config.php';
include '../library/project.lib.php';
$P = new Project('../');
@extract($_POST);

// 권한 체크, 없다면 에러 1 리턴
if($modifyDocNo) {
	$getUser = @mysql_fetch_array(mysql_query('select level from '.$P->divide.'users where uid = '.$_SESSION['userNo']));
	if(!$getUser['level']) $getUser['level'] = 1;
	if($_SESSION['userNo'] != 1 && ($getUser['level'] < $grNote['project']['makeLevel'])) {
		@header('Content-Type: text/xml; charset=utf-8');
		echo '<?xml version="1.0" encoding="utf-8"?><error>1</error>';
		exit();
	}
}

// 특수문자 재처리
$original = array('@amp;', '@plus;', '@percent;', '@sharp;', '@question;', '<p>', '</p>');
$change = array('&', '+', '%', '#', '?', '', '<br />');
$name = str_replace($original, $change, addslashes($name));
$summary = str_replace($original, $change, addslashes($summary));

// 프로젝트 생성
$timeNow = time();
if($modifyNo) {
	@mysql_query("update {$P->divide}projects set name = '".addslashes($name)."', summary = '$summary' where uid = $modifyNo limit 1");
} else {
	$sqlInsert = "insert into {$P->divide}projects set uid = '', name = '".addslashes($name)."', make_time = $timeNow, ".
		"update_time = $timeNow, ticket_done = 0, ticket_yet = 0, summary = '$summary', leader = ".$_SESSION['userNo'];
	@mysql_query($sqlInsert);
	$insertNo = @mysql_insert_id();
	$sqlCreate = "create table {$P->divide}ticket{$insertNo} ( uid int(11) not null auto_increment, project_uid int(11) not null default '$insertNo', ".
		"goal_uid int(11) not null default '0', writer int(11) not null default '0', target int(11) not null default '0', conditions tinyint(1) not null default '0', ".
		"memo varchar(255) not null default '', primary key(uid), key project_uid(project_uid), key goal_uid(goal_uid), key target(target), key conditions(conditions))";
	@mysql_query($sqlCreate);
}

// 최종 작업 결과 리턴 (여기까지 왔다면 0)
@header('Content-Type: text/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?><error>0</error>';
?>