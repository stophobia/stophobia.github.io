<?php
if(!defined('__GRBLOG__')) exit();
include 'lib/db.php';
$DB = new DATABASE;
include 'db_info.php';
@set_time_limit(0);
$saveDay = date('Ymd', time());
$DB->dbHeader('grblog_'.$saveDay.'.sql');
$DB->allDown($dbName);
?>