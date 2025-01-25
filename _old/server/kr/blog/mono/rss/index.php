<?php
$prefix = '../../';
include $prefix.'lib/common.php';
dbConn($prefix);
@header('Content-Type: text/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?><rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">';
$path = str_replace('/rss/index.php', '', $_SERVER["SCRIPT_NAME"]);

// 모노로그 설정 가져오기
$getMemoConfig = @mysql_query('select * from '.$dbFIX.'memo_config');
while($conf = @mysql_fetch_array($getMemoConfig, MYSQL_ASSOC)) {
	$config[$conf['opt']] = $conf['value'];
}
if(!$config['use_rss']) die('<error>1</error></rss>');
echo '<channel><title>'.htmlspecialchars(stripslashes($config['mono_title'])).'</title>'.
	'<link>http://'.$_SERVER['HTTP_HOST'].$path.'</link>'.
	'<description>monolog in GR Blog</description>'.
	'<generator>GR Blog</generator><language>ko</language>';
$rssView = @mysql_query("select * from {$dbFIX}memo_post order by uid desc limit 10");
while($rss = mysql_fetch_array($rssView))
{
	echo '<item><title>monolog - '.date('n/j a g:i', $rss['signdate']).'</title>'.
		'<link>http://'.$_SERVER['HTTP_HOST'].$path.'</link>'.
		'<description>'.stripslashes(htmlspecialchars($rss['content'])).'...</description>';
	echo '<author>'.$rss['name'].'</author>'.'<pubDate>'.date('r', $rss['signdate']).'</pubDate></item>';
}
echo '</channel></rss>';
?>