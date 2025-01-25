<?php
if(!defined('__GRBLOG__')) exit();

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

	// 페이지별 캐쉬
	$isGuest = ($_SESSION['no']) ? '' : '.guest';
	$modifyTime = @filemtime('cache/page.'.$page.$isGuest.'.html');
	if($config['use_cache']) {
		if($conf_antiSpam) {
			$antispam = '<script type="text/javascript">//<![CDATA['."\n".'var strKey = \''.$_SESSION['antiSpam'].'\';'."\n".
				'//]]></script><script type="text/javascript" src="js/html.cache.correct.js"></script></body></html>';
		} else $antispam = '</body></html>';
		if(time() < ($modifyTime + $config['cache_time'])) {
			@include 'cache/page.'.$page.$isGuest.'.html';
			echo $antispam;
			exit();
		} else {
			$isCacheStart = true;
			@ob_start();
		}
	}
}

// 테마 상단
$getLatestPost = @mysql_fetch_array(mysql_query('select subject from '.$dbFIX.'post where post_condition = 1 order by uid desc limit 1'));
$browserTitle .= stripslashes($getLatestPost[0]);
include $theme.'/head.php';

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
?>
<!-- 최근 포스팅들 -->
<div id="content">
<?php
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
	if($conf_preview) {
		if($conf_preview_thumbnail) {
			preg_match('|<img src="(.+?)" alt="upload image"|i', $gb['content'], $preview);
			if(!$preview[1]) preg_match('|<a href="(.+?)" onclick="return hs|i', $gb['content'], $preview);
		}
		$gb['content'] = cutString(strip_tags($gb['content']), $conf_preview_count);
	}
	include $theme.'/list.php';
}
?>
</div>
<!-- 사이드바 / 하단 -->
<?php
$paging = getPaging($config['num_per_page'], $page, $totalPage, $grblog.'?page=', $division, $originDivision, $cat, $t, $so, $st);
include $theme.'/sidebar.php';
include $theme.'/foot.php';
if($config['use_cache'] && $isCacheStart) {
	$viewPage = @ob_get_contents();
	@ob_end_clean();
	$f = @fopen('cache/page.'.$page.$isGuest.'.html', 'w');
	@fwrite($f, $viewPage);
	@fclose($f);
	echo $viewPage.'</body></html>';
}
?>