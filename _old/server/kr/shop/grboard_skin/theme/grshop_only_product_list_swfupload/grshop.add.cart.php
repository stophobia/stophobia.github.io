<?php
// 세션, DB연동, 헤더시작
@header('Content-Type: text/xml; charset=utf-8');
@session_save_path('../../session');
@session_start();
echo '<?xml version="1.0" encoding="utf-8"?>';
if(!$_SESSION['no']) die('<msg>로그인을 먼저 해 주세요!</msg>');
include '../../core.php';
include '../../'.$grcore.'/db.info.php';
$db = new mysqli($dbinfo['hostname'], $dbinfo['userid'], $dbinfo['password'], $dbinfo['dbname']);
include '../../'.$coreConfig['grshop'].'/core.php';
$grshopPrefix = $dbFIX;

// 변수 초기화
$bbs_id = $_POST['bbs_id'];
$bbs_no = $_POST['bbs_no'];

// 이미 장바구니에 있는지 확인
$getExist = @$db->query('select uid from '.$grshopPrefix.'carts where member_key = '.$_SESSION['no'].' and bbs_id = \''.$bbs_id.'\' and bbs_no = \''.$bbs_no.'\'')->fetch_array();
if($getExist['uid']) die('<msg>이미 장바구니에 담아두셨습니다.</msg>');

// 장바구니에 담기
@$db->query('insert into '.$grshopPrefix."carts set uid = '', member_key = ".$_SESSION['no'].", bbs_id = '{$bbs_id}', bbs_no = '{$bbs_no}'");
echo '<msg><![CDATA[<p>이 상품을 고객님의 장바구니에 담아두었습니다.<br /><strong>Ok</strong> 를 누르시면 계속 쇼핑을 하실 수 있습니다.<br /></p>]]></msg>';
?>