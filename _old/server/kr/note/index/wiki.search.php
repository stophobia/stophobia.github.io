<?php
/**
 * @update 2008-11-21
 * @comment 위키 문서 검색
 */
include '../grnote.config.php';
include '../library/wiki.lib.php';
$W = new Wiki('../');
@extract($_POST);
@extract($_GET);

// 이전 문서 찾기
$result = '<span class="b">`'.$searchText.'` 검색결과</span><br /><br /><ol>';
$isResult = false;
$getSearch = @mysql_query('select keyword, content from '.$W->divide.'wikis where '.$searchOption.' like \'%'.$searchText.'%\' and master_doc = 0');
while($answer = @mysql_fetch_array($getSearch)) {
	$result .= '<li><a href="./?m=wiki&amp;a=view&amp;k='.urlencode($answer['keyword']).'">'.$answer['keyword'].'</a></li>';
	$isResult = true;
}
if(!$isResult) $result .= '<li>검색된 결과가 없습니다.</li>';
$result .= '</ol>';

// 최종 작업 결과 리턴 (여기까지 왔다면 0)
@header('Content-Type: text/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?><lists><content><![CDATA['.$result.']]></content></lists>';
?>