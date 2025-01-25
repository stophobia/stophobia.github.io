<?php
include 'lib/common.php';
if(!file_exists('db_info.php')) move('install.php');
include 'php_head.php';

// 관리자 이외에는 배제
if($_SESSION['no'] != 1) error('관리자만이 글을 작성하실 수 있습니다.');
dbConn();
@extract($_POST);

// 설정 가져오기
include 'theme_config.php';
$config = @mysql_fetch_array(mysql_query('select * from '.$dbFIX.'config where uid = \'1\''));
$theme = 'theme/'.$config['theme'];
$absPath = 'http://'.$_SERVER['HTTP_HOST'].$grblog;
$blogInfo = stripslashes($config['blog_info']);
$blogTitle = stripslashes($config['blog_title']);
$getLatestPost = @mysql_fetch_array(mysql_query('select subject from '.$dbFIX.'post where post_condition = 1 order by uid desc limit 1'));
$browserTitle = $blogTitle.' - '.stripslashes($getLatestPost[0]);

// 테마 상단부터 하단까지, 글쓰기 폼 추가
$wMode = true;
include $theme.'/head.php';
include $theme.'/write.php';
include $theme.'/sidebar.php';
include $theme.'/foot.php';
?>