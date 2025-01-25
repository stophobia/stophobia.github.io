<?php
/*
	GR Paper 포스트 읽음 처리
	작성자: 박희근 (http://sirini.net)
	수정일: 2008-08-25
	내  용: 게시물은 읽기 전에 이 곳을 거쳐 조회수 등을 올린다.
*/

if(!$_GET['u'] || !$_GET['r']) die('정상적으로 접근해 주세요');

include '../db.info.php';
$db->query('update '.$dbinfo['prefix'].'feed set hit = hit + 1 where uid = '.$_GET['u']);
@header('location: '.$_GET['r']);
?>
