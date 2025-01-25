<?php
/**
 * @update 2008-11-21
 * @comment 기념일을 삭제한다.
 */
include '../grnote.config.php';
include '../library/planner.lib.php';
$Pn = new Planner('../');

// 권한체크
$getUser = @mysql_fetch_array(mysql_query('select member_key from '.$Pn->divide.'memorials where uid = '.$_POST['deleteNo']));
if($getUser['member_key'] != $_SESSION['userNo']) {
	@header('Content-Type: text/xml; charset=utf-8');
	echo '<?xml version="1.0" encoding="utf-8"?><error>1</error>';
	exit();
}

// 기념일 삭제
@mysql_query('delete from '.$Pn->divide.'memorials where uid = '.$_POST['deleteNo']);

// 최종 작업 결과 리턴 (여기까지 왔다면 0)
@header('Content-Type: text/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?><error>0</error>';
?>