<?php
/*
	GR Paper 썸네일 이미지 보기
	작성자: 박희근 (http://sirini.net)
	수정일: 2009-7-9
	내  용: 추출된 그림만 따로 보아서 보여줍니다.
	참  고: 사용중인 스킨(테마) 디자인에 영향을 받음
*/

define('__GRPATH__', 'thumbnail');

// 캐쉬 전처리
$cacheFile = '../cache/thumbnail.list.'.$_GET['page'].'.'.$_GET['originDiv'].'.'.$_GET['division'].'.html';
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
$thumbNumber = $c->get('thumbNumber');
$thumbWidth = $c->get('thumbWidth');
$thumbHeight = $c->get('thumbHeight');
$themePath = $config['absPath'].'/skin/'.$theme;
$botTerm = $c->get('botTerm');
$hotPostNumber = $c->get('hotPostNumber');
$tagNumber = $c->get('tagNumber');
$isEnableAdd = $c->get('isEnableAdd');
$blogNumber = $c->get('blogNumber');
if($hotPostNumber) {
	$getHotPost = $c->db->query('select uid, link, subject from '.$c->prefix.'feed where signdate > '.(time()-($c->get('hotPostTerm')*3600)).' order by hit desc limit '.$hotPostNumber);
}
if($tagNumber) $getHotTag = $c->db->query('select tag, count from '.$c->prefix.'tag order by count desc limit '.$tagNumber);
if($_GET['originDiv']) $p->originDiv = $_GET['originDiv'];
if($_GET['page']) $p->currentPage = $_GET['page']; else $p->currentPage = 1;
if($_GET['division']) $p->division = $_GET['division'];

// 페이징 처리
$fromRecord = ($p->currentPage - 1) * $thumbNumber;
$getTotalNum = $c->db->query('select count(*) from '.$c->prefix.'image')->fetch_array();
$getMaxUid = $c->db->query('select max(uid) from '.$c->prefix.'image')->fetch_array();
$arrange = 1000;
$getBlogList = $c->db->query('select * from '.$c->prefix.'feed_list order by uid desc limit '.$blogNumber);

// 범주의 크기를 구분해서 처리
if($getTotalNum[0] > $arrange)
{
	if(!$p->division) { $p->division = ceil($getTotalNum[0] / $arrange); $p->originDiv = $p->division; }
	$moreThanMe = ($p->division - 1) * $arrange;
	$lessThanMe = $p->division * $arrange;
	if(($p->originDiv == $p->division) && ($getMaxUid[0] > $lessThanMe)) $lessThanMe = $getMaxUid[0];
	$getRealMax = $c->db->query('select count(*) from '.$c->prefix.'image where uid > '.$moreThanMe.' and uid <= '.$lessThanMe)->fetch_array();
	$p->totalPage = ceil($getRealMax[0] / $thumbNumber);
	$rangeQue = 'where uid >= '.$moreThanMe.' and uid <= '.$lessThanMe.' order by uid desc';
}
else
{
	$p->totalPage = ceil($getTotalNum[0] / $thumbNumber);
	$rangeQue = ' order by uid desc';
}

// 쿼리실행 및 페이징 저장
$getThumbnailList = $c->db->query('select * from '.$c->prefix.'image '.$rangeQue.' limit '.$fromRecord.', '.$thumbNumber);
$p->pageNum = $c->get('pageNumber');
$paging = $p->getPaging();

// 스킨 출력
include '../skin/'.$theme.'/head.php';
include '../skin/'.$theme.'/body.thumbnail.php';
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
