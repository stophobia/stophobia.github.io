<?php
@header('Content-Type: text/xml; charset=utf-8');
include '../lib/reader.php';
echo getPage('http://sirini.net/sink/rss.php');
?>