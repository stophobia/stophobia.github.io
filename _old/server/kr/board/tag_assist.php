<?php
// DB 연결
include 'db_info.php';

// 결과값 주기
if(array_key_exists('tag', $_POST) && $_POST['tag']) {
	$tag = $_POST['tag'];
	$id = $_POST['id'];
	$xml  = '<?xml version="1.0" encoding="utf-8"?><lists>';
	$sql = 'select tag, count from '.$dbFIX.'tag_list where id = \''.$id.'\' and tag'." like '%{$tag}%' limit 10";
	$test = @mysql_fetch_array(mysql_query($sql));
	if(!$test[0]) {
		$xml .= '<tags count="0">관련 태그를 찾을 수 없습니다.</tags></lists>';
		@header('Content-type: text/xml; charset=utf-8');
		die($xml);
	}

	$result = @mysql_query($sql);
	while($list = mysql_fetch_array($result)) $xml .= '<tags count="'.$list['count'].'">'.$list['tag'].'</tags>';
	$xml .= '</lists>';
	@header('Content-type: text/xml; charset=utf-8');
	echo $xml;
}
?>