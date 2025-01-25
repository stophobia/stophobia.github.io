<?php
// 초기화, Install 클래스 선언시 db.info.php 파일이 있는 경로 앞부분 지정 필요 (기본: ../)
include '../library/install.lib.php';
$install = new Install('../');
@extract($_POST);

// 관리자를 등록
$result = $install->createAdmin($id, $password, $nickname, $email, $homepage, $selfInfo);
@header('Content-Type: text/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?><error>0</error>';
?>