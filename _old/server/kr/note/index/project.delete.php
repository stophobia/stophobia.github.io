<?php
/**
 * @update 2008-11-21
 * @comment 프로젝트 삭제
 */
include '../grnote.config.php';
include '../library/project.lib.php';
$P = new Project('../');
@extract($_POST);

// 권한체크
$getUser = @mysql_fetch_array(mysql_query('select level from '.$P->divide.'users where uid = '.$_SESSION['userNo']));
if(!$_SESSION['userNo'] || ($_SESSION['userNo'] != 1 && ($getUser['level'] < $grNote['project']['makeLevel']))) {
	@header('Content-Type: text/xml; charset=utf-8');
	echo '<?xml version="1.0" encoding="utf-8"?><error>1</error>';
	exit();
}

// 프로젝트 삭제
@mysql_query('delete from '.$P->divide.'projects where uid = '.$projectNo);
@mysql_query('delete from '.$P->divide.'goals where project_id = '.$projectNo);
@mysql_query('drop table '.$P->divide.'ticket'.$projectNo);

// 최종 작업 결과 리턴 (여기까지 왔다면 0)
@header('Content-Type: text/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?><lists><error>0</error><p>'.$keywordMd5.'</p></lists>';
?>