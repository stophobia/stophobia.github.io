<?php
/**
 * @update 2008-11-21
 * @comment 티켓보기 화면에서 상태를 변경할 때 처리
 */
include '../grnote.config.php';
include '../library/view.lib.php';
$V = new View('../');
@extract($_POST);

// 권한 체크, 없다면 에러 1 리턴
if(!$_SESSION['userNo']) {
	@header('Content-Type: text/xml; charset=utf-8');
	echo '<?xml version="1.0" encoding="utf-8"?><error>1</error>';
	exit();
}

// 티켓 상태 변경
$oldStatus = @mysql_fetch_array(mysql_query('select conditions from '.$V->divide.'ticket'.$p.' where uid = '.$uid));
@mysql_query("update {$V->divide}ticket{$p} set target = ".$_SESSION['userNo'].", conditions = $change where uid = $uid");
if($change == 3 && ($oldStatus[0] < 3 || $oldStatus[0] == 4)) {
	@mysql_query("update {$V->divide}projects set ticket_yet = ticket_yet - 1, ticket_done = ticket_done + 1 where uid = $p");
	@mysql_query("update {$V->divide}goals set ticket_yet = ticket_yet - 1, ticket_done = ticket_done + 1 where uid = $g");
} elseif(($change < 3 || $change == 4) && $oldStatus[0] == 3) {
	@mysql_query("update {$V->divide}projects set ticket_yet = ticket_yet + 1, ticket_done = ticket_done - 1 where uid = $p");
	@mysql_query("update {$V->divide}goals set ticket_yet = ticket_yet + 1, ticket_done = ticket_done - 1 where uid = $g");
}

// 최종 작업 결과 리턴 (여기까지 왔다면 0)
@header('Content-Type: text/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?><error>0</error>';
?>