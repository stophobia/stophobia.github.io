<?php
$hostName = 'localhost';
$userId = 'stophobia';
$password = '16871687';
$dbName = 'stophobia';
$_conn = @mysql_connect($hostName, $userId, $password);
$useExtremeMode = 0;
@mysql_select_db($dbName);
#@mysql_query('set names utf8'); // 한글이 깨져나올 시 맨 앞 # 을 제거
?>