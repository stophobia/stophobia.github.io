<?php
include 'lib/common.php';
if(!file_exists('db_info.php')) move('install.php');
include 'php_head.php';
include 'theme_config.php';

dbConn();
@extract($_POST);
@extract($_GET);

// 설정 가져오기
$config = @mysql_fetch_array(mysql_query('select * from '.$dbFIX.'config where uid = \'1\''));
$theme = 'theme/'.$config['theme'];

// 테마 상단
$browserTitle = $blogTitle = stripslashes($config['blog_title']);
$blogInfo = stripslashes($config['blog_info']);
include $theme.'/head.php';

// 검색범위 정하기
if($t) 
{
	$wt = 'tag like \'%'.$t.'%\'';
	if(!$_SESSION['no']) $wt .= ' and post_condition = \'1\'';
	$wq = ' and '.$wt;
	$wqc = ' where '.$wt;
}
elseif($cat)
{
	$wc = 'category = \''.$cat.'\'';
	if(!$_SESSION['no']) $wc .= ' and post_condition = \'1\'';
	$wq = ' and '.$wc;
	$wqc = ' where '.$wc;
}
elseif($ds && $dl)
{
	$wd = 'signdate > '.$ds.' and signdate < '.$dl;
	if(!$_SESSION['no']) $wd .= ' and post_condition = \'1\'';
	$wq = ' and '.$wd;
	$wqc = ' where '.$wd;
}
elseif($so && strlen($st))
{
	$ws = $so.' like \'%'.$st.'%\'';
	$wq = ' and '.$ws;
	$wqc = ' where '.$ws;
}
else 
{ 
	$wq = ''; 
	if(!$_SESSION['no']) $wqc = ' where post_condition = \'1\''; 
	else $wqc = '';
}
if(!$orderBy) $orderBy = 'uid';
if(!$desc) $desc = 'desc';
if(!$page) $page = 1;

// 페이징 처리
$perList = 25; # 한 번에 25개씩 보기
$fromRecord = ($page - 1) * $perList;
$getTotalNum = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'post'.$wqc));
$totalCount = $getTotalNum[0];
$getMaxUid = @mysql_fetch_array(mysql_query('select max(uid) from '.$dbFIX.'post'));
$maxNo = $getMaxUid[0];
$arrange = 100;

// 범주의 크기를 구분해서 처리
if($totalCount > $arrange)
{
	if(!$division) { $division = ceil($totalCount / $arrange); $originDivision = $division; }
	$moreThanMe = ($division - 1) * $arrange;
	$lessThanMe = $division * $arrange;
	if(($originDivision == $division) && ($maxNo > $lessThanMe)) $lessThanMe = $maxNo;
	$getRealMax = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'post where uid > '.$moreThanMe.' and uid <= '.$lessThanMe.$wq));
	$totalPage = ceil($getRealMax[0] / $perList);
	$rangeQue = ' '.(($wqc)?'and':'where').' uid >= '.$moreThanMe.' and uid <= '.$lessThanMe;
}
else
{
	if(!$division) { $division = 0; $originDivision = 0; }
	$totalPage = ceil($totalCount / $perList);
	$rangeQue = '';
}

// 글 목록 가져오기
echo '<div id="content">';
include $theme.'/article_list_head.php';
$getPost = @mysql_query('select * from '.$dbFIX.'post '.$wqc.$rangeQue.' order by '.$orderBy.' '.$desc.' limit '.$fromRecord.', '.$perList);
while($gb = mysql_fetch_array($getPost))
{
	if($gb['tag'])
	{
		$tags = explode(',', $gb['tag']);
		$tCount = count($tags);
		$tagList = '';
		for($i=0; $i<$tCount; $i++)
			$tagList .= '<a href="./?tag='.urlencode($tags[$i]).'">'.$tags[$i].'</a>, ';
		$tagList = substr($tagList, 0, -2);
	}
	else $tagList = '없음';
	$gb['content'] = str_replace('&amp;', '&', $gb['content']);
	if(strlen($st)) $gb['content'] = str_replace($st, '<span class="findMe">'.$st.'</span>', $gb['content']); 
	include $theme.'/article_list.php';
}
$paging = getPaging($perList, $page, $totalPage, './article_list.php?orderBy='.$orderBy.'&amp;desc='.$desc.'&amp;page=', $division, $originDivision);
include $theme.'/article_list_foot.php';
echo '</div>';

// 테마 사이드, 하단
include $theme.'/sidebar.php';
include $theme.'/foot.php';
?>