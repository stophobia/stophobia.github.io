<?php
if(!defined('__GRBLOG__')) exit();
if(!$_SESSION['no'] && !$_SESSION['user_no']) error('로그인을 하셔야 합니다', 'location.href=\'login.php\';');
if($_GET['admin']) $admin = $_GET['admin'];
if($_GET['modifyTarget']) $modifyTarget = $_GET['modifyTarget'];
if($_GET['deleteTarget']) $deleteTarget = $_GET['deleteTarget'];
if($_GET['deleteTargets']) $deleteTarget = $_GET['deleteTargets'];
if($_GET['searchText']) $searchText = $_GET['searchText'];
if($_GET['searchOption']) $searchOption = $_GET['searchOption'];
if($_GET['post_uid']) $post_uid = $_GET['post_uid'];
if($_GET['page']) $page = $_GET['page'];
if($_GET['open']) $open = $_GET['open'];
if($_GET['category']) $category = $_GET['category'];
@extract($_POST);
if(!isset($admin)) $admin = 1;
dbConn();
$config = getConfig();
include 'prepare/prepare_'.$admin.'.php';
?>