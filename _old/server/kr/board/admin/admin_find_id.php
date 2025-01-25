<?php
// DB 연결
include '../db_info.php';

// 결과값 주기
if(array_key_exists('id', $_POST) && $_POST['id'])
{
	$id = $_POST['id'];
	$xml  = '<?xml version="1.0" encoding="utf-8"?><lists>';
	$sql = 'select id, nickname, realname from '.$dbFIX.'member_list where id'." like '%{$id}%' limit 10";
	$test = @mysql_fetch_array(mysql_query($sql));
	if(!$test[0]) {
		$xml .= '<ids name="none">검색 결과가 없습니다.</ids></lists>';
		@header('Content-type: text/xml; charset=utf-8');
		echo $xml;
		exit();
	}

	$result = @mysql_query($sql);
	while($list = mysql_fetch_array($result))
	{
		$xml .= '<ids name="'.stripslashes($list['nickname']).'" real="'.stripslashes($list['realname']).'">'.$list['id'].'</ids>';
	}
	$xml .= '</lists>';
	@header('Content-type: text/xml; charset=utf-8');
	echo $xml;
}
?>