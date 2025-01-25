<?php
/**
 * @update 2008-11-21
 * @comment 위키 문서 삭제 처리
 */
include '../grnote.config.php';
include '../library/wiki.lib.php';
$W = new Wiki('../');
@extract($_POST);

// 권한체크
$getUser = @mysql_fetch_array(mysql_query('select level from '.$W->divide.'users where uid = '.$_SESSION['userNo']));
$getInfo = @mysql_fetch_array(mysql_query('select writer, keyword_md5 from '.$W->divide.'wikis where uid = '.$docNo));
if(!$_SESSION['userNo'] || ($_SESSION['userNo'] != 1 && $_SESSION['userNo'] != $getInfo['writer'] && ($getUser['level'] < $grNote['wiki']['deleteLevel']))) {
	@header('Content-Type: text/xml; charset=utf-8');
	echo '<?xml version="1.0" encoding="utf-8"?><error>1</error>';
	exit();
}

// 문서삭제
@mysql_query('delete from '.$W->divide.'wikis where keyword_md5 = \''.$getInfo['keyword_md5'].'\'');

// 최종 작업 결과 리턴 (여기까지 왔다면 0)
@header('Content-Type: text/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?><lists><error>0</error><p>'.$keywordMd5.'</p></lists>';
?>