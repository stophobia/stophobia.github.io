<?php
// DB 연결 & 선택
include 'db_info.php';
@mysql_connect($hostName, $userId, $password);
@mysql_select_db($dbName);
@mysql_query('set names utf8');

// 결과값 주기
if(array_key_exists('st', $_POST) && $_POST['st'])
{
	if(!ini_get('magic_quotes_gpc'))
	{
		$st = addslashes($_POST['st']);
		$so = addslashes($_POST['so']);
	}
	else
	{
		$st = $_POST['st'];
		$so = $_POST['so'];
	}
	$xml  = '<?xml version="1.0" encoding="utf-8"?>';
	$xml .= '<lists>';
	$sql = 'select uid, subject from '.$dbFIX.'post where '.$so." like '%".$st."%' limit 10";
	$result = @mysql_query($sql);
	while($list = mysql_fetch_array($result))
	{
		$xml .= '<item no="'.$list['uid'].'">';
		$xml .= '<title>'.stripslashes($list['subject']).'</title>';
		$xml .= '</item>';
	}
	$xml .= '</lists>';
	@header('Content-type: text/xml; charset=utf-8');
	echo $xml;
}
?>