<?php
$hostName='localhost';
$userId='stophobia';
$password='16871687';
$dbName='stophobia';
$divide='gr_note_kr';
@mysql_connect($hostName, $userId, $password);
@mysql_select_db($dbName);
//@mysql_query('set names utf8'); # 한글이 깨져나올 때 앞의 // 제거 후 저장 → 서버에 덮어씌우기
@session_save_path($prefix.'session/');
@session_start();
?>