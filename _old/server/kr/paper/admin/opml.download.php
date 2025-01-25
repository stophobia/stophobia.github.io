<?php
/*
	GR Paper OPML 내보내기 처리
	작성자: 박희근 (http://sirini.net)
	수정일: 2008-12-7
	내  용: 등록된 RSS 구독목록을 OPML 형태로 내보낸다.
	참  고: RSS 2.0 포맷만 지원한다.
	주  의: 관리자만 작업을 할 수 있다.
*/

@header('Content-Type: application/octet-stream');
@header('Content-Disposition: attachment; filename="grpaper_'.date('Ymd').'.opml"');
@header('Expires: 0');
if(eregi('msie', $_SERVER['HTTP_USER_AGENT'])) @header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
@header('Pragma: public');

include '../library/common.php';
$c = new GRCOMMON('../', 'none');
if(!$c->isAdmin()) $c->alert('관리자만 작업 할 수 있습니다.');

echo '<?xml version="1.0" encoding="utf-8" ?>'."\n".'<opml version="1.0">'."\n".'<head>'."\n".'<title>GR Paper OPML</title>'.
	'<dateCreated>'.date('r').'</dateCreated>'."\n".'<ownerName>GR Paper</ownerName>'."\n".'</head>'."\n".'<body>'."\n".'<outline title="GR Paper OPML">';

$getFeeds = $c->db->query('select * from '.$c->prefix.'feed_list where xml != \'\'');
while($all = $getFeeds->fetch_array()) {
	echo '<outline title="'.htmlspecialchars(stripslashes($all['name'])).'" xmlUrl="http://'.htmlspecialchars(stripslashes($all['xml'])).'" type="rss" description="'.str_replace(array('  ', "\n"), '', htmlspecialchars(stripslashes($all['info']))).'" img="'.$all['img'].'" htmlUrl="http://'.$all['url'].'" />'."\n";
}

echo '</outline></body></opml>';
exit();
?>