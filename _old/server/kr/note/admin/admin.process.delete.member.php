<?php
/**
 * @update 2009-02-06
 * @comment 관리화면 > 멤버삭제처리
 */
@session_save_path('../session');
@session_start();
if($_SESSION['userNo'] != 1) exit();

include '../library/admin.lib.php';
$A = new Admin('../');
$no = $_POST['no'];
@mysql_query("delete from {$A->divide}users where uid = '$no' limit 1");

// 최종 작업 결과 리턴 (여기까지 왔다면 0)
@header('Content-Type: text/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?><error>0</error>';
exit();
?>