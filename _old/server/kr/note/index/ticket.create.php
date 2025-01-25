<?php
/**
 * @update 2008-11-21
 * @comment 티켓 생성하기
 */
include '../grnote.config.php';
include '../library/ticket.lib.php';
$T = new Ticket('../');
@extract($_POST);

// 권한 체크, 없다면 에러 1 리턴
$getUser = @mysql_fetch_array(mysql_query('select level from '.$T->divide.'users where uid = '.$_SESSION['userNo']));
if(!$getUser['level']) $getUser['level'] = 1;
if($_SESSION['userNo'] != 1 && ($getUser['level'] < $grNote['ticket']['sendLevel'])) {
	@header('Content-Type: text/xml; charset=utf-8');
	echo '<?xml version="1.0" encoding="utf-8"?><error>1</error>';
	exit();
}

// 특수문자 재처리
$original = array('@amp;', '@plus;', '@percent;', '@sharp;', '@question;');
$change = array('&', '+', '%', '#', '?');
$memo = addslashes(str_replace($original, $change, $memo));

// 목표 생성 or 수정
$targetNo = @mysql_fetch_array(mysql_query('select uid from '.$T->divide.'users where id = \''.$target.'\''));
if($modifyNo) {
	@mysql_query("update {$T->divide}ticket{$projectID} set target = '$targetNo[0]', memo = '$memo' where uid = $modifyNo");
} else {
	$sql = "insert into {$T->divide}ticket{$projectID} set uid = '', project_uid = $projectID, goal_uid = $goalID, writer = ".(($_SESSION['userNo'])?$_SESSION['userNo']:0).", ".
		"target = '$target', conditions = 0, memo = '$memo'";
	@mysql_query($sql);
	@mysql_query("update {$T->divide}projects set ticket_yet = ticket_yet + 1 where uid = $projectID");
	@mysql_query("update {$T->divide}goals set ticket_yet = ticket_yet + 1 where uid = $goalID");
}

// 최종 작업 결과 리턴 (여기까지 왔다면 0)
@header('Content-Type: text/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?><error>0</error>';
?>