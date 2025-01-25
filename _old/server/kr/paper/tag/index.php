<?php
/*
	GR Paper 자주 쓰이는 TOP 2,000 태그 보기
	작성자: 박희근 (http://sirini.net)
	수정일: 2009-7-9
	내  용: 많이 쓰이는 태그들을 상위 2,000 개까지 보여줍니다.
	참  고: 사용중인 스킨(테마) 디자인에 영향을 받음
*/

define('__GRPATH__', 'tag');

// 캐쉬 전처리
$cacheFile = '../cache/tag.list.html';
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

// 주요 변수 저장
$theme = $c->get('theme');
$botTerm = $c->get('botTerm');
$browserTitle = $c->get('browserTitle');
$postNumber = $c->get('postNumber');
$themePath = $config['absPath'].'/skin/'.$theme;
$hotPostNumber = $c->get('hotPostNumber');
$tagNumber = $c->get('tagNumber');
$blogNumber = $c->get('blogNumber');
$isEnableAdd = $c->get('isEnableAdd');
if($hotPostNumber) {
	$getHotPost = $c->db->query('select uid, link, subject from '.$c->prefix.'feed where signdate > '.(time()-($c->get('hotPostTerm')*3600)).' order by hit desc limit '.$hotPostNumber);
}
if($tagNumber) $getHotTag = $c->db->query('select tag, count from '.$c->prefix.'tag order by count desc limit '.$tagNumber);
if($blogNumber) $getBlogList = $c->db->query('select url, name, info from '.$c->prefix.'feed_list order by uid desc limit '.$blogNumber);

// 쿼리실행
$getTagList = $c->db->query('select tag, count from '.$c->prefix.'tag order by count desc limit 2000');

// 스킨 출력
include '../skin/'.$theme.'/head.php';
include '../skin/'.$theme.'/body.tag.php';
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
