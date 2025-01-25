<?php
// PHP설정값, 헤더, 세션 설정
$_GET['preRoute'] = $_POST['preRoute'] = $_REQUEST['preRoute'] = false;
@header('Pragma: no-cache');
@header('Cache-Control: max-age=1, s-maxage=1, no-cache, must-revalidate');
@header('Content-Type: text/html; charset=utf-8');
@session_save_path($preRoute.'session');
@session_start();
?>