<?php
// 사용자 권한 리턴
function getPerm()
{
	global $dbFIX;
	if(!$_SESSION['user_no']) return false;
	$getPerm = @mysql_fetch_array(mysql_query('select perm from '.$dbFIX.'user where uid = '.$_SESSION['user_no']));
	return $getPerm['perm'];
}
// 사용자 정보 리턴
function getMemberInfo($target=false)
{
	global $dbFIX;
	if(!$_SESSION['user_no'] && !$target) return false;
	if($target) $where = $target; else $where = $_SESSION['user_no'];
	$getInfo = @mysql_fetch_array(mysql_query('select * from '.$dbFIX.'user where uid = '.$where));
	return $getInfo;
}
?>