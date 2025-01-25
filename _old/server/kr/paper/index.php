<?php
/*
	GR Paper 첫 페이지
	작성자: 박희근 (http://sirini.net)
	수정일: 2008-08-29
	내  용: 스킨 디자인을 통해서 수집된 피드들을 보여준다.
	참  고: 사용중인 스킨(테마) 디자인에 영향을 받음.
*/

// HTML 캐쉬 전처리
$isCacheMake = false;
if($_POST['so']) $_so = $_POST['so']; elseif($_GET['so']) $_so = $_GET['so'];
if($_POST['st']) $_st = $_POST['st']; elseif($_GET['st']) $_st = $_GET['st'];
$cacheFile = './cache/page.'.$_GET['page'].'.'.$_GET['division'].'.'.$_SESSION['login'].'.'.$_so.'.'.(($_st)?base64_encode($_st):'').'.html';
if(file_exists($cacheFile)) {
	include 'db.info.php';
	$getGI = $db->query('select var from '.$dbinfo['prefix'].'skin where opt = \'grcounterID\' limit 1')->fetch_array();
	if($getGI['var']) {
		$grcount = end($db->query('select var from '.$dbinfo['prefix'].'skin where opt = \'grcounterPath\' limit 1')->fetch_array()).'/';
		$grid = $getGI['var'];
		include $grcount.'grcounter.php';
	}
	include $cacheFile;
	exit();
} else {
	$isCacheMake = true;
	ob_start();
}

// 초기화
include 'library/common.php';
$c = new GRCOMMON('./');
include 'config/base.php';
include 'library/paging.php';
$p = new GRPAGING();

// 주요 변수 저장
$p->so = $_so;
$p->st = $_st;
$theme = $c->get('theme');
$browserTitle = $c->get('browserTitle');
$themePath = $config['absPath'].'/skin/'.$theme;
$grboardPath = $c->get('grboardPath');
$grcounterPath = $c->get('grcounterPath');
$postNumber = $c->get('postNumber');
$charNumber = $c->get('charNumber');
$botTerm = $c->get('botTerm');
$thumbWidth = $c->get('thumbWidth');
$thumbHeight = $c->get('thumbHeight');
$hotPostNumber = $c->get('hotPostNumber');
$blogNumber = $c->get('blogNumber');
$tagNumber = $c->get('tagNumber');
$isEnableAdd = $c->get('isEnableAdd');
if($p->so == 'author') {
	$p->so = 'blog_uid';
	$p->st = end($c->db->query('select uid from '.$c->prefix.'feed_list where name like \'%'.$_st.'%\' limit 1')->fetch_array());
}
if($hotPostNumber) $getHotPost = $c->db->query('select uid, link, subject from '.$c->prefix.'feed where signdate > '.(time()-($c->get('hotPostTerm')*3600)).' order by hit desc limit '.$hotPostNumber);
if($blogNumber) $getBlogList = $c->db->query('select url, name, info from '.$c->prefix.'feed_list order by uid desc limit '.$blogNumber);
if($tagNumber) $getHotTag = $c->db->query('select tag, count from '.$c->prefix.'tag order by count desc limit '.$tagNumber);
if($_GET['originDiv']) $p->originDiv = $_GET['originDiv'];
if($_POST['page']) $p->currentPage = $_POST['page']; elseif($_GET['page']) $p->currentPage = $_GET['page']; else $p->currentPage = 1;
if($_GET['division']) $p->division = $_GET['division'];
$addQue = '';

// GR카운터 연동 (있을 시)
if($grcounterPath) {
	$grcount = $c->get('grcounterPath').'/';
	$grid = $c->get('grcounterID');
	include $grcount.'grcounter.php';
}

// GR보드 연동 (있을 시)
if($grboardPath) {
	$grboardID = $c->get('grboardBbsId');
	$grboardListNumber = $c->get('grboardNoticeNumber');
	include $grboardPath.'/db_info.php';
	$noteLink = $grboardPath.'/board.php?id='.$grboardID.'&amp;articleNo=';
	$getNotice = $c->db->query('select no, subject, signdate from '.$dbFIX.'bbs_'.$grboardID.' order by no desc limit '.$grboardListNumber);
}

// 탐색범위 정하기
if($p->so && $p->st) $addQue = ' and '.$p->so.' like \'%'.$p->st.'%\'';

// 페이징 처리
$fromRecord = ($p->currentPage - 1) * $postNumber;
$getTotalNum = $c->db->query('select count(*) from '.$c->prefix.'feed'.(($p->so)?' where '.$p->so.' like \'%'.$p->st.'%\'':''))->fetch_array();
$getMaxUid = $c->db->query('select max(uid) from '.$c->prefix.'feed')->fetch_array();
$arrange = 500;

// 범주의 크기를 구분해서 처리
if($getTotalNum[0] > $arrange)
{
	if(!$p->division) { $p->division = ceil($getTotalNum[0] / $arrange); $p->originDiv = $p->division; }
	$moreThanMe = ($p->division - 2) * $arrange;
	$lessThanMe = ($p->division + 1) * $arrange;
	if(($p->originDiv == $p->division) && ($getMaxUid[0] > $lessThanMe)) $lessThanMe = $getMaxUid[0];
	$getRealMax = $c->db->query('select count(*) from '.$c->prefix.'feed where uid > '.$moreThanMe.' and uid <= '.$lessThanMe.$addQue)->fetch_array();
	$p->totalPage = ceil($getRealMax[0] / $postNumber);
	$rangeQue = 'where uid > '.$moreThanMe.' and uid < '.$lessThanMe.$addQue.' order by signdate desc';
}
else
{
	$p->totalPage = ceil($getTotalNum[0] / $postNumber);
	if($addQue) $rangeQue = ' where '.$p->so.' like \'%'.$p->st.'%\' order by signdate desc';
	else $rangeQue = ' order by signdate desc';
}

// 쿼리실행 및 페이징 저장
$getFeedList = $c->db->query('select * from '.$c->prefix.'feed '.$rangeQue.' limit '.$fromRecord.', '.$postNumber);
$p->pageNum = $c->get('pageNumber');
$paging = $p->getPaging();
echo '<!-- *** '.'select * from '.$c->prefix.'feed '.$rangeQue.' limit '.$fromRecord.', '.$postNumber.' *** -->';

// 스킨 디자인 호출
include 'skin/'.$theme.'/head.php';
include 'skin/'.$theme.'/body.php';
include 'skin/'.$theme.'/foot.php';

// HTML 캐쉬 후처리
if($isCacheMake) {
	$cache = ob_get_contents();
	ob_end_clean();
	$cf = fopen($cacheFile, 'w');
	fwrite($cf, $cache);
	fclose($cf);
	echo $cache;
}
?>
