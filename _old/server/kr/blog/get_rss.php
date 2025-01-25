<?php
//if(!$_POST['url']) exit();
include 'lib/reader.php';
@extract($_POST);
$xml = getPage($url);
@header('Content-Type: text/xml; charset=utf-8');
/**
rss 를 가져와서 그대로 출력합니다.
*/
echo $xml;
?>