<?php
if($_GET['prefix'] || $_POST['prefix']) $prefix = '';
@header('P3P : CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
@header('Pragma: no-cache');
@header('Cache-Control: max-age=1, s-maxage=1, no-cache, must-revalidate');
@header('Content-Type: text/html; charset=utf-8');
@session_save_path($prefix.'session');
@session_cache_limiter('nocache, must-revalidate');
@session_start();
@ini_set('display_errors', 'off');
?>