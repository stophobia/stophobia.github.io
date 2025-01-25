<?php
// 미설치된 경우 설치 화면으로 이동
if(!file_exists('db.info.php')) {
	@header('Location: ./install/');
	exit();
}
// 지정된 테마 인덱스 부름
include 'grnote.config.php';
include 'index/theme/'.$grNote['theme'].'/index.php';
?>