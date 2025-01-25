<?php
/**
 * @update 2008-11-21
 * @comment 위키 과거문서 탐색
 */
include '../grnote.config.php';
include '../library/wiki.lib.php';
$W = new Wiki('../');
@extract($_POST);

// 이전 문서 찾기
$getMd5 = @mysql_fetch_array(mysql_query('select keyword_md5 from '.$W->divide.'wikis where uid = '.$uid));
$getOld = @mysql_fetch_array(mysql_query('select uid, keyword, content, signdate, master_doc from '.$W->divide.'wikis where uid < '.$uid.' and keyword_md5 = \''.$getMd5['keyword_md5'].'\' order by uid desc limit 1'));
if(!$getOld['uid']) {
	@header('Content-Type: text/xml; charset=utf-8');
	echo '<?xml version="1.0" encoding="utf-8"?><lists><error>1</error><keyword>0</keyword><content>0</content><signdate>0</signdate><master_doc>0</master_doc></lists>';
	exit();
}

// 최종 작업 결과 리턴 (여기까지 왔다면 0)
@header('Content-Type: text/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?><lists><error>0</error><keyword>'.$getOld['keyword'].'</keyword><content><![CDATA['.$getOld['content'].
	']]></content><signdate>'.date('Y-m-d H:i:s', $getOld['signdate']).'</signdate><master_doc>'.$getOld['uid'].'</master_doc></lists>';
?>