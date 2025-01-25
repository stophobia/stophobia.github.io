<?php
// 변수 처리
if(isset($_GET['id'])) $id = $_GET['id'];
if(isset($_GET['isReply'])) $isReply = true;
if(isset($_GET['select'])) $select = $_GET['select'];

// DB, 세션 연결
include 'db_info.php';
include 'php_head.php';

// 블로그 클래스를 불러온다.
include "class/blog.php";
$RSS = new BLOG;

if(!$id) {
	$RSS->allRss($select);
	exit();
}

// 권한 검사
$viewOk = @mysql_fetch_array(mysql_query("select view_level, is_rss from {$dbFIX}board_list where id = '$id'"));
if( ($viewOk['view_level'] > 1) || !$viewOk['is_rss']) {
	header('Content-Type: text/html; charset=utf-8');
	die('볼 수 있는 권한이 없습니다.');
}

// RSS 생성하기
if($isReply) $RSS->replyRss($id); else $RSS->makeRss($id);
?>