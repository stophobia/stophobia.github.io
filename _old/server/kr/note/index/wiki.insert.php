<?php
/**
 * @update 2008-11-21
 * @comment 위키 문서 작성 후처리
 */
include '../grnote.config.php';
include '../library/wiki.lib.php';
$W = new Wiki('../');
@extract($_POST);

// 스팸방지체크, 틀리면 에러 1 리턴
if(!$W->isAdmin() && (!$writer && $_SESSION['writeKey'] != $antispam)) {
	@header('Content-Type: text/xml; charset=utf-8');
	echo '<?xml version="1.0" encoding="utf-8"?><lists><error>1</error><p>0</p></lists>';
	exit();
}

// 수정권한 체크, 없다면 에러 2 리턴
if($modifyDocNo) {
	$getUser = @mysql_fetch_array(mysql_query('select level from '.$W->divide.'users where uid = '.$_SESSION['userNo']));
	$getInfo = @mysql_fetch_array(mysql_query('select writer, keyword_md5 from '.$W->divide.'wikis where uid = '.$docNo));
	if(!$getUser['level']) $getUser['level'] = 1;
	if(!$getInfo['writer']) $getInfo['writer'] = 99999;
	if($_SESSION['userNo'] != 1 && $_SESSION['userNo'] != $getInfo['writer'] && ($getUser['level'] < $grNote['wiki']['modifyLevel'])) {
		@header('Content-Type: text/xml; charset=utf-8');
		echo '<?xml version="1.0" encoding="utf-8"?><lists><error>2</error><p>0</p></lists>';
		exit();
	}
}

// 키워드, 내용 특수문자 재처리
$original = array('@amp;', '@plus;', '@percent;', '@sharp;', '@question;');
$change = array('&', '+', '%', '#', '?');
$keyword = str_replace($original, $change, $keyword);
$content = str_replace($original, $change, $content);
$content = str_replace('<p>', '', str_replace('</p>', '<br />', str_replace('<p>&nbsp;</p>', '<br />', $content)));
$keywordMd5 = md5($keyword);

// 문서 신규작성
if(!$modifyDocNo || ($grNote['wiki']['saveOriginal'] == 1)) {
	$sql = "insert into {$W->divide}wikis set uid = '', keyword = '$keyword', keyword_md5 = '$keywordMd5', content = '$content', writer = '$writer', ".
		"signdate = '".time()."', view = 0, master_doc = 0";
	@mysql_query($sql);
	$insertNo = @mysql_insert_id();
	if($modifyDocNo) @mysql_query("update {$W->divide}wikis set master_doc = $insertNo where uid = $modifyDocNo");
}
// 기존 문서 수정
elseif($modifyDocNo && ($grNote['wiki']['saveOriginal'] == 2)) {
	@mysql_query("update {$W->divide}wikis set content = '$content', writer = '$writer', signdate = '".time()."' where uid = $modifyDocNo");
}

// 이전에 저장된 캐쉬 삭제
@unlink('../cache/'.$keywordMd5.'.html');

// 최종 작업 결과 리턴 (여기까지 왔다면 0)
@header('Content-Type: text/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?><lists><error>0</error><p>'.$keywordMd5.'</p></lists>';
exit();
?>