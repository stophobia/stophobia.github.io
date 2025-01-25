<?php
$prefix = '../';
include '../php_head.php';
if(!$_SESSION['no']) exit();

if(array_key_exists('categoryName', $_POST) && $_POST['categoryName'])
{
	$cn = $_POST['categoryName'];
	$cid = $_POST['_c'];
	include '../db_info.php';
	include '../lib/common.php';
	dbConn('../');

	// 카테고리 목록출력 호출기
	function getCategoryList($node=0, $depth=0) {
		global $dbFIX;
		static $uidStack = array();
		if($node) $sql = ' where id = '.$node.' and depth != '.$depth; else $sql = '';
		$getCategory = @mysql_query('select * from '.$dbFIX.'category'.$sql.' order by uid asc, id asc');
		while($cat = mysql_fetch_array($getCategory)) {
			if(!in_array($cat['uid'], $uidStack, true)) array_push($uidStack, $cat['uid']);
			else continue;
			echo '<item no="'.$cat['uid'].'.'.$cat['id'].'.'.$cat['depth'].'"><fullTitle>'.str_repeat(htmlspecialchars('&nbsp;&nbsp;&nbsp;&nbsp;'), $cat['depth']).' '.$cat['name'].'</fullTitle><title>'.$cat['name'].'</title></item>';
			$getChild = @mysql_fetch_array(mysql_query('select uid from '.$dbFIX.'category where id = '.$cat['uid'].' and depth > '.$cat['depth'].' limit 1'));
			if($getChild['uid']) getCategoryList($cat['uid'], $cat['depth']);
		}
	}

	if(array_key_exists('opt', $_POST) && $_POST['opt'])
	{
		$getExist = @mysql_fetch_array(mysql_query("select uid from ".$dbFIX."category where name = '$cn'"));
		if(!$getExist[0])
		{
			if($cid) {
				$tmp = explode('.', $cid);
				@mysql_query("insert into {$dbFIX}category set uid = '', id = $tmp[0], name = '".htmlspecialchars($cn)."', depth = ".($tmp[2]+1));
			} else {
				$total = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'category where depth = 0'));
				@mysql_query("insert into {$dbFIX}category set uid = '', id = 0, name = '".htmlspecialchars($cn)."', depth = 0");
				$insertID = @mysql_insert_id();
				@mysql_query("update {$dbFIX}category set id = {$insertID} where uid = {$insertID}");
			}
		}
	}
	else
	{
		$categoryName = htmlspecialchars($cn);
		$getCN = @mysql_fetch_array(mysql_query('select uid from '.$dbFIX.'category where name = \''.$categoryName.'\''));
		@mysql_query("delete from {$dbFIX}category where name = '$categoryName'");
		@mysql_query("delete from {$dbFIX}category where id = $getCN[0] and depth != 0");
	}
	$clist = @mysql_query('select * from '.$dbFIX.'category order by id asc');
	
	@header('Content-Type: text/xml; charset=utf-8');
	echo '<?xml version="1.0" encoding="utf-8"?><lists>';
	getCategoryList();
	echo '</lists>';
}
?>