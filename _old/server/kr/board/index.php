<?php
// $id 값이 넘어왔을 땐 바로 게시판쪽으로 이동
if($_GET['id']) @header('location: board.php?id='.$_GET['id']);

// 미설치시 설치, layout 사용시 이동
include 'class/common.php';
$GR = new COMMON;
if(!file_exists('db_info.php')) $GR->error('GR Board 가 설치되어 있지 않습니다. 설치페이지로 이동합니다.', 0, 'install.php');
else {
	$GR->dbConn();
	$getConfig = @mysql_fetch_array(mysql_query('select var from '.$dbFIX."layout_config where opt = 'useLayout'"));
	if($getConfig['var']) $GR->move('./index/index.php');
	else $GR->move('http://'.$_SERVER['HTTP_HOST']);
}
?>