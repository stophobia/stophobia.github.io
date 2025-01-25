<?php
/**
 * @update 2008-11-21
 * @comment 목표 삭제시 처리
 */
include '../grnote.config.php';
include '../library/goal.lib.php';
$G = new Goal('../');
@extract($_POST);

// 권한체크
$getUser = @mysql_fetch_array(mysql_query('select level from '.$G->divide.'users where uid = '.$_SESSION['userNo']));
if(!$_SESSION['userNo'] || ($_SESSION['userNo'] != 1 && ($getUser['level'] < $grNote['goal']['makeLevel']))) {
	@header('Content-Type: text/xml; charset=utf-8');
	echo '<?xml version="1.0" encoding="utf-8"?><error>1</error>';
	exit();
}

// 목표 삭제
@mysql_query('delete from '.$G->divide.'goals where uid = '.$goalNo);
@mysql_query('delete from '.$G->divide.'ticket'.$projectNo.' where goal_uid = '.$goalNo);

// 최종 작업 결과 리턴 (여기까지 왔다면 0)
@header('Content-Type: text/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?><lists><error>0</error><p>'.$keywordMd5.'</p></lists>';
exit();
?>