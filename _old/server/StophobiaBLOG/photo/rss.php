<?php		
include '../lib/common.php';
dbConn('../');
@header('Content-Type: text/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">';
$path = str_replace('/rss.php', '', $_SERVER["SCRIPT_NAME"]);
$config = @mysql_fetch_array(mysql_query('select * from '.$dbFIX.'config where uid = \'1\''));
echo '<channel><title>'.htmlspecialchars(stripslashes($config['blog_title'])).'</title>'.
	'<link>http://'.$_SERVER['HTTP_HOST'].$path.'</link>'.
	'<description>'.htmlspecialchars(stripslashes($config['blog_info'])).'</description>'.
	'<generator>GR Blog photolog</generator><language>ko</language>';
$rssView = @mysql_query('select * from '.$dbFIX.'photo order by uid desc limit 10');
while($rss = mysql_fetch_array($rssView))
{
	echo '<item><title>'.htmlspecialchars(stripslashes($rss['title'])).'</title>'.
		'<link>http://'.$_SERVER['HTTP_HOST'].$path.'/?photoNo='.$rss['uid'].'</link>'.
		'<description>'.stripslashes(htmlspecialchars(nl2br($rss['content']))).'</description>'.
		'<category>GR Blog photolog</category><author>'.$config['name'].
		'</author><pubDate>'.date('r', $rss['signdate']).'</pubDate></item>';
}
echo '</channel></rss>';
?>