<?php
/*
	GR Paper 등록된 블로그 목록보기
	작성자: 박희근 (http://sirini.net)
	수정일: 2009-7-9
	내  용: 등록된 블로그 목록을 펼쳐 봅니다.
	참  고: 사용중인 스킨(테마) 디자인에 영향을 받음
*/

define('__GRPATH__', 'list');

// 캐쉬 전처리
$cacheFile = '../cache/blog.list.'.$_GET['page'].'.'.$_GET['originDiv'].'.'.$_GET['division'].'.html';
if(file_exists($cacheFile)) {
	include $cacheFile;
	exit();
} else {
	$isCacheMake = true;
	ob_start();
}

// 초기화
include '../library/common.php';
$c = new GRCOMMON('../');
include '../config/base.php';
include '../library/paging.php';
$p = new GRPAGING();

// 주요 변수 저장
$theme = $c->get('theme');
$browserTitle = $c->get('browserTitle');
$blogListNumber = $c->get('blogListNumber');
$botTerm = $c->get('botTerm');
$blogNumber = $c->get('blogNumber');
$themePath = $config['absPath'].'/skin/'.$theme;
if($_GET['originDiv']) $p->originDiv = $_GET['originDiv'];
if($_GET['page']) $p->currentPage = $_GET['page']; else $p->currentPage = 1;
if($_GET['division']) $p->division = $_GET['division'];
$hotPostNumber = $c->get('hotPostNumber');
$tagNumber = $c->get('tagNumber');
$isEnableAdd = $c->get('isEnableAdd');
if($hotPostNumber) $getHotPost = $c->db->query('select uid, link, subject from '.$c->prefix.'feed where signdate > '.(time()-($c->get('hotPostTerm')*3600)).' order by hit desc limit '.$hotPostNumber);
if($tagNumber) $getHotTag = $c->db->query('select tag, count from '.$c->prefix.'tag order by count desc limit '.$tagNumber);

// 페이징 처리
$fromRecord = ($p->currentPage - 1) * $blogListNumber;
$getTotalNum = $c->db->query('select count(*) from '.$c->prefix.'feed_list')->fetch_array();
$p->totalPage = ceil($getTotalNum[0] / $blogListNumber);

// 쿼리실행 및 페이징 저장
$getBlogList = $c->db->query('select * from '.$c->prefix.'feed_list'.$viewSecret.' order by uid desc limit '.$fromRecord.', '.$blogListNumber);
$getLatestBlogList = $c->db->query('select * from '.$c->prefix.'feed_list order by uid desc limit '.$blogNumber);
$p->pageNum = $c->get('pageNumber');
$paging = $p->getPaging();

// 스킨 출력
include '../skin/'.$theme.'/head.php';
include '../skin/'.$theme.'/body.list.php';
include '../skin/'.$theme.'/foot.php';

// 캐쉬 후처리
if($isCacheMake) {
	$cache = ob_get_contents();
	ob_end_clean();
	$cf = fopen($cacheFile, 'w');
	fwrite($cf, $cache);
	fclose($cf);
	echo $cache;
}
?>
