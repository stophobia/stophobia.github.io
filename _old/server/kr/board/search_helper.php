<?php
// DB 연결
include 'db_info.php';

// 결과값 주기
if($_POST['searchText']) {
	if(!ini_get('magic_quotes_gpc')) {
		$boardID = addslashes($_POST['boardID']);
		$searchText = addslashes($_POST['searchText']);
		$searchOption = addslashes($_POST['searchOption']);
	} else {	
		$boardID = $_POST['boardID'];
		$searchText = $_POST['searchText'];
		$searchOption = $_POST['searchOption'];
	}
	$searchText = str_replace(array('_', '%', '\\'), array('\_', '\%', '\\\\\\\\'), $searchText);
	$xml  = '<?xml version="1.0" encoding="utf-8"?><lists>';
	$sql = 'select no, subject from '.$dbFIX.'bbs_'.$boardID.' where '.$searchOption." like '%".$searchText."%' limit 10";
	$test = @mysql_fetch_array(mysql_query($sql));
	if(!$test[0]) {
		$xml .= '<item no="0"><title>검색 결과가 없습니다.</title></item></lists>';
		@header('Content-type: text/xml; charset=utf-8');
		die($xml);
	}
	$result = @mysql_query($sql);
	while($list = mysql_fetch_array($result)) {
		$xml .= '<item no="'.$list['no'].'"><title>'.htmlspecialchars(stripslashes($list['subject'])).'</title></item>';
	}
	$xml .= '</lists>';
	@header('Content-type: text/xml; charset=utf-8');
	echo $xml;
}
?>