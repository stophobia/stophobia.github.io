<?php
// 워드프레스 ---> GR Blog 컨버터
@header('Content-Type: text/html; charset=utf-8');
include 'lib/common.php';
dbConn();
$nowTime = time();
$getWP_post = @mysql_query('select * from wp_posts');
$i=0;
$error = array();
while($post = @mysql_fetch_array($getWP_post))
{
	@extract($post);
	if($post_status != 'publish') continue;
	$que = "insert into ".$dbFIX."post set uid = '$ID', category = '$cat_ID', signdate = '$nowTime', subject = '$post_title', ".
		"content = '".addslashes($post_content)."', post_condition = '1', comment_condition = '1', ".
		"trackback = '', open_rss = '1', comment_count = '$comment_count', trackback_count = '0', tag = ''";
	$e = @mysql_query($que);
	if(!$e) $error[$i] = mysql_error();
	$i++;
	if($i % 1000 == 0) sleep(1);
}

$getWP_comment = @mysql_query('select * from wp_comments');
$i=0;
while($co = @mysql_fetch_array($getWP_comment))
{
	@extract($co);
	$que_co = "insert into ".$dbFIX."comment set uid = '$comment_ID', family_uid = '$comment_ID', post_uid = '$comment_post_ID', ".
		"is_secret = '0', is_reply = '0', name = '$comment_author', ".
		"email = '$comment_author_email', homepage = '$comment_author_url', ip = '$comment_author_IP', ".
		"signdate = '$nowTime', content = '$comment_content'";
	@mysql_query($que_co);
	$i++;
	if($i % 1000 == 0) sleep(1);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="GR Blog" />
<link rel="stylesheet" href="style.css" type="text/css" title="style" />
<title>Wordpress to GR Blog :: Converter</title>
</head>
<body>
<strong>성공적으로 컨버팅 하였습니다!</strong>
</body>
</html>