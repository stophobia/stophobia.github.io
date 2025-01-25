<?php
// 이름 클릭할 때 뜨는 레이어에서 이메일과 홈페이지 주소 가져오는 부분
if($_POST['no']) $no = $_POST['no']; else exit();
include 'db_info.php';
$memInfo = @mysql_fetch_array(mysql_query('select email, homepage from '.$dbFIX.'member_list where no = \''.$no.'\''));
if(!$memInfo['email']) $memInfo['email'] = 0;
if(!$memInfo['homepage']) $memInfo['homepage'] = 0;
@header('Content-type: text/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?><lists><item no="'.$no.'"><email>'.$memInfo['email'].'</email><homepage>'.$memInfo['homepage'].'</homepage></item></lists>';
?>