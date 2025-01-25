<?php
/**
 * @update 2008-11-21
 * @comment 티켓을 삭제할 때 처리
 */
include '../grnote.config.php';
include '../library/view.lib.php';
$V = new View('../');
@extract($_POST);

// 권한체크
$getUser = @mysql_fetch_array(mysql_query('select level from '.$V->divide.'users where uid = '.$_SESSION['userNo']));
$getWriter = @mysql_fetch_array(mysql_query('select writer from '.$V->divide.'ticket'.$projectNo.' where uid = '.$uid));
if(!$_SESSION['userNo'] || ($_SESSION['userNo'] != 1 && ($getWriter['writer'] != $_SESSION['userNo']) && ($getUser['level'] < $grNote['ticket']['removeLevel']))) {
	@header('Content-Type: text/xml; charset=utf-8');
	echo '<?xml version="1.0" encoding="utf-8"?><error>1</error>';
	exit();
}

// 티켓 삭제
$getStatus = @mysql_fetch_array(mysql_query('select conditions from '.$V->divide.'ticket'.$projectNo.' where uid = '.$uid));
if($getStatus[0] == 3) $que = 'ticket_done = ticket_done - 1';
else $que = 'ticket_yet = ticket_yet - 1';
@mysql_query('delete from '.$V->divide.'ticket'.$projectNo.' where uid = '.$uid);
@mysql_query('update '.$V->divide.'goals set '.$que.' where uid = '.$goalNo);
@mysql_query('update '.$V->divide.'projects set '.$que.' where uid = '.$projectNo);

// 최종 작업 결과 리턴 (여기까지 왔다면 0)
@header('Content-Type: text/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?><error>0</error>';
?>