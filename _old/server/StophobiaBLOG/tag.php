<?php
include 'lib/common.php';
include 'php_head.php';
include 'theme_config.php';

dbConn();
@extract($_POST);
@extract($_GET);

// 설정 가져오기
$config = @mysql_fetch_array(mysql_query('select * from '.$dbFIX.'config where uid = \'1\''));
$theme = 'theme/'.$config['theme'];
$absPath = 'http://'.$_SERVER['HTTP_HOST'].$grblog;
$blogInfo = stripslashes($config['blog_info']);

// 테마 상단
$blogTitle = stripslashes($config['blog_title']);
$getLatestPost = @mysql_fetch_array(mysql_query('select subject from '.$dbFIX.'post where post_condition = 1 order by uid desc limit 1'));
$browserTitle = $blogTitle.' - '.stripslashes($getLatestPost[0]);
include $theme.'/head.php';

// 태그 목록 전체보기
@ob_start();
getTag(10000, 'count');
$tags = @ob_get_contents();
@ob_end_clean();

// 태그 스킨 페이지가 있다면 스킨 활용 (아니면 일반 출력)
if($haveTagSkin) include $theme.'/tag.php';
else echo '<div id="content"><div id="tagClouds">'.$tags.'</div></div>';

// 테마 사이드, 하단
include $theme.'/sidebar.php';
include $theme.'/foot.php';
?>