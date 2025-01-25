<?php
include 'lib/common.php';
dbConn();
@header('Content-Type: text/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?><rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">';
$path = str_replace('/rss.php', '', $_SERVER["SCRIPT_NAME"]);
$config = @mysql_fetch_array(mysql_query('select * from '.$dbFIX.'config where uid = \'1\''));
echo '<channel><title>'.htmlspecialchars(stripslashes($config['blog_title'])).'</title>'.
	'<link>http://'.$_SERVER['HTTP_HOST'].$path.'</link>'.
	'<description>'.htmlspecialchars(stripslashes($config['blog_info'])).'</description>'.
	'<generator>GR Blog</generator><language>ko</language><image>'.
		'<title>http://'.$_SERVER['HTTP_HOST'].$path.'</title><url>http://'.$_SERVER['HTTP_HOST'].$path.'/image/my_photo.jpg</url>'.
		'<link>http://'.$_SERVER['HTTP_HOST'].$path.'/my_photo.jpg</link></image>';
$rssView = @mysql_query('select * from '.$dbFIX.'post where post_condition = 1 and open_rss = 1 order by uid desc limit 10');
while($rss = mysql_fetch_array($rssView))
{
	echo '<item><title>'.htmlspecialchars(stripslashes($rss['subject'])).'</title>'.
		'<link>http://'.$_SERVER['HTTP_HOST'].$path.'/?p='.$rss['uid'].'</link>'.
		'<description>'.stripslashes(htmlspecialchars(cutString(str_replace('src="data/', 'src="http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/data/', $rss['content']), $config['num_rss_content']))).'...</description>';
	if($rss['category'])
	{
		$getCG = @mysql_fetch_array(mysql_query('select name from '.$dbFIX.'category where id = \''.$rss['category'].'\''));
		echo '<category>'.htmlspecialchars(stripslashes($getCG[0])).'</category>';
	}
	if($rss['tag'])
	{
		$tags = explode(',', str_replace(' ', '', $rss['tag']));
		$tagCount = count($tags);
		for($i=0; $i<$tagCount; $i++) echo '<category>'.htmlspecialchars(stripslashes($tags[$i])).'</category>';
	}
	echo '<author>'.$config['name'].'</author>'.'<pubDate>'.date('r', $rss['signdate']).'</pubDate></item>';
}
echo '</channel></rss>';
?>