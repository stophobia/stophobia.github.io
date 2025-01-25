<?php
if(!defined('__GRBLOG__')) exit();

// 상단 호출
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

// 페이징 처리
$fromRecord = ($page - 1) * $config['num_view_post'];
$getTotalNum = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'post'.$wqc));
$totalCount = $getTotalNum[0];
$getMaxUid = @mysql_fetch_array(mysql_query('select max(uid) from '.$dbFIX.'post'));
$maxNo = $getMaxUid[0];
$arrange = 500;

// 범주의 크기를 구분해서 처리
if($totalCount > $arrange)
{
	if(!$division) { $division = ceil($totalCount / $arrange); $originDivision = $division; }
	$moreThanMe = ($division - 1) * $arrange;
	$lessThanMe = $division * $arrange;
	if(($originDivision == $division) && ($maxNo > $lessThanMe)) $lessThanMe = $maxNo;
	$getRealMax = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'post where uid > '.$moreThanMe.' and uid <= '.$lessThanMe.$wq));
	$totalPage = ceil($getRealMax[0] / $config['num_view_post']);
	$rangeQue = ' '.(($wqc)?'and':'where').' uid >= '.$moreThanMe.' and uid <= '.$lessThanMe;
}
else
{
	if(!$division) { $division = 0; $originDivision = 0; }
	$totalPage = ceil($totalCount / $config['num_view_post']);
	$rangeQue = '';
}

// 본문 호출
if($p) include 'read.php';
else
{
	$getPost = @mysql_query('select * from '.$dbFIX.'post '.$wqc.$rangeQue.' order by uid desc limit '.$fromRecord.', '.$config['num_view_post']);
	while($gb = mysql_fetch_array($getPost))
	{
		if($gb['tag'])
		{
			$tags = explode(',', $gb['tag']);
			$tCount = count($tags);
			$tagList = '';
			for($i=0; $i<$tCount; $i++)
				$tagList .= '<a href="'.$grblog.'?tag='.urlencode($tags[$i]).'">'.$tags[$i].'</a>, ';
			$tagList = substr($tagList, 0, -2);
		}
		else $tagList = '없음';
		$postLink = 'http://'.$_SERVER['HTTP_HOST'].$grblog.$gb['uid'];
		$gb['subject'] = stripslashes($gb['subject']);
		$gb['content'] = str_replace(array('&amp;', '="data/'), array('&', '="'.$grblog.'data/'), stripslashes($gb['content']));
		if($st) $gb['content'] = str_replace($st, '<span class="findMe">'.$st.'</span>', $gb['content']);
		include $theme.'/loop.php';
	}
}

// 하단 호출
include $theme.'/foot.php';
?>