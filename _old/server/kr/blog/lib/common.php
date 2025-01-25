<?php
// ÅEêÎü¨ÅEÄ ÅE¨ÅEÅEÅEÅE
function error($msg, $go='history.back();')
{
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'.
		'<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">'.
		'<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'.
		'<script type="text/javascript">//<![CDATA['."\n".' alert(\''.$msg.'\'); '.$go.' '."\n".'//]]></script>'.
		'<title>ÅEåÎ¶º</title></head><body>'.stripslashes($msg).'</body></html>';
	exit();
}

// ÅE¥ÅEÅE
function move($go)
{
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'.
		'<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">'.
		'<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'.
		'<script type="text/javascript">//<![CDATA['."\n".' location.href=\''.$go.'\'; '."\n".'//]]></script>'.
		'<title>ÅE¥ÅEÅE/title></head><body><a href="'.$go.'">ÅE¥ÅEôÌïòÅE∞ (ÅE¨ÅE∞ÅEº ˙ù¥ÅE≠˙±òÏÑ∏ÅEÅE</a></body></html>';
	exit();
}

// DBÅEëÏÅE (˙±úÍ∏ÄÅE¥ ÅE®ÅE∏ ÅE¥ÅEº ÅEΩÅE∞ 31ÅE∏ÅEÅE# ÅEúÍ±∞)
function dbConn($prefix='')
{
	include $prefix.'db_info.php';
	$GLOBALS['dbFIX'] = $dbFIX;
	@mysql_connect($hostName, $userId, $password) or die('DBÅEÅEÅEëÏÅE˙±òÏßÄ ÅEª˙≤àÏäµÅEàÎã§');
	@mysql_select_db($dbName) or die('DBÅEº ÅE†˙üùÌïòÅEÄ ÅEª˙≤àÏäµÅEàÎã§');
	@mysql_query('set names utf8');
}

// ÅEΩÅE∞ ˙™∏˙±ÅE˙®åÏùº˙ù¨ÅE∞
function fsize($size=0)
{
	if($size < 1024) return $size.'Byte';
	elseif($size > 1024 && $size < 1048576) return (int)($size/1024).'KB';
	elseif($size > 1048576) return (int)($size/1048576).'MB';
}

// ÅE∏ÅEêÏó¥ ÅEêÎ•¥ÅE∞
function cutString($str, $size=0)
{
	if(!$size) return $str;
	if(function_exists('mb_strcut')) return mb_strcut($str, 0, $size, 'utf-8');
	$result = substr($str, 0, $size);
	preg_match('/^([\\x00-\\x7e]|.{3})*/', $result, $string);
	return $string[0];
}

// ÅE†ÅEÅE˙™òÏù¥ÅEÄ ÅE©ÅEÅEÅEúÎ†•
function getNotice()
{
	global $dbFIX, $grblog;
	$notices = @mysql_query('select uid, subject from '.$dbFIX.'post where post_condition = \'2\'');
	$result = '<ul>';
	while($n = mysql_fetch_array($notices))
		$result .= '<li><a href="'.$grblog.'?p='.$n['uid'].'">'.stripslashes($n['subject']).'</a></li>';
	echo $result.'</ul>';
}

// ÅEúÍ∑º ÅEîÎ©òÌä∏ ÅEúÎ†•
function getLatestComment($n=10, $size=30)
{
	global $dbFIX, $grblog;
	$comments = @mysql_query('select uid, post_uid, content from '.$dbFIX.'comment where is_secret = \'0\' order by uid desc limit '.$n);
	$result = '<ul>';
	while($list = mysql_fetch_array($comments)) {
		$isParentSecret = @mysql_fetch_array(mysql_query('select post_condition from '.$dbFIX.'post where uid = '.$list['post_uid']));
		$showText = '<a href="'.$grblog.'?p='.$list['post_uid'].'#viewComment'.$list['uid'].'">'.cutString(strip_tags(stripslashes($list['content'])), $size).'</a>';
		if(!$isParentSecret['post_condition']) $showText = '<a href="#">ÅEÅE∞ÄÅEÄÅEÅEÅE¨ÅE∞ ÅEìÍ∏Ä</a>';
		$result .= '<li>'.$showText.'</li>';
	}
	echo $result.'</ul>';
}

// ÅEúÍ∑º ˙¶∏ÅEôÎ∞± ÅEúÎ†•
function getLatestTrackback($n=10, $size=30)
{
	global $dbFIX, $grblog;
	$result = '<ul>';
	$trackbacks = @mysql_query('select uid, post_uid, subject from '.$dbFIX.'trackback order by uid desc limit '.$n);
	while($list = mysql_fetch_array($trackbacks))
		$result .= '<li><a href="'.$grblog.'?p='.$list['post_uid'].'#viewTrackback'.$list['uid'].'">'.cutString(stripslashes($list['subject']), $size).'</a></li>';
	echo $result.'</ul>';
}

// ÅEúÍ∑º ˙´¨ÅE§˙¶∏ ÅEúÎ†•
function getLatestPost($n=10, $size=30)
{
	global $dbFIX, $grblog;
	$result = '<ul>';
	$posts = @mysql_query('select uid, subject from '.$dbFIX.'post where post_condition = \'1\' order by uid desc limit '.$n);
	while($list = mysql_fetch_array($posts))
		$result .= '<li><a href="'.$grblog.'?p='.$list['uid'].'">'.cutString(stripslashes($list['subject']), $size).'</a></li>';
	echo $result.'</ul>';
}

// ÅEúÍ∑º ÅE®ÅE∏ÅEúÍ∑∏ ÅEúÎ†•
function getLatestMonolog($n=10, $size=30)
{
	global $dbFIX, $grblog;
	$posts = @mysql_query('select content from '.$dbFIX.'memo_post order by uid desc limit '.$n);
	$result = '<ul>';
	while($list = mysql_fetch_array($posts))
		$result .= '<li><a href="'.$grblog.'mono/">'.cutString(stripslashes($list['content']), $size).'</a></li>';
	echo $result.'</ul>';
}

// ÅEúÍ∑º ÅE©ÅEÅE°ÅEÅEúÎ†•
function getLatestGuestbook($n=10, $size=30)
{
	global $dbFIX, $grblog, $prefix;
	$posts = @mysql_query('select uid, content from '.$dbFIX.'guestbook order by uid desc limit '.$n);
	$result = '<ul>';
	while($list = mysql_fetch_array($posts))
		$result .= '<li><a href="'.$grblog.'guestbook/#guest'.$list['uid'].'">'.cutString(stripslashes($list['content']), $size).'</a></li>';
	echo $result.'</ul>';
}

// ÅEÅEÅ¨ ÅEúÎ†•
function getLink()
{
	global $dbFIX, $grblog;
	$links = @mysql_query('select url, name, info from '.$dbFIX.'link order by uid asc');
	$result = '<ul>';
	while($list = mysql_fetch_array($links))
		$result .= '<li><a href="'.$list['url'].'" title="'.$list['info'].'">'.stripslashes($list['name']).'</a></li>';
	echo $result.'</ul>';
}

// ÅE¨ÅEÅEì§ ÅEúÎ†•
function getPhoto()
{
	global $dbFIX, $grblog, $prefix;
	include $prefix.'photo_config.php';
	if($prefix) $grblog = $prefix;
	$links = @mysql_query('select uid, file_route, title from '.$dbFIX.'photo order by uid desc limit '.$photo['num']);
	$result = '<ul>';
	while($list = mysql_fetch_array($links))
		$result .= '<li><a href="'.$grblog.'photo/?photoNo='.$list['uid'].
		'" onclick="window.open(this.href, \'_blank\', \'menubar=no,scrollbars=yes,resizable=yes\'); return false">'.
		'<img src="'.$grblog.'phpThumb/phpThumb.php?src='.((!$prefix)?realpath('.').'/':$prefix).$list['file_route'].
		'&amp;w='.$photo['width'].'&amp;h='.$photo['height'].'&amp;q='.$photo['quality'].'" alt="ÅE¨ÅEÅEì§" title="'.stripslashes($list['title']).'" /></a></li>';
	echo $result.'</ul>';
}

// ˙™òÏù¥ÅEÅEÅEòÎ¶¨ ˙±®ÅEÅE
function getPaging($writePages, $currentPage, $totalPage, $goUrl, $division=0, $originDivision=0, $cat=0, $tag='', $so='', $st='')
{
	$str = '';
	if($so && $st) $asq = '&amp;so='.$so.'&amp;st='.urlencode($st);
	elseif($cat) $asq = '&amp;cat='.$cat;
	elseif($tag) $asq = '&amp;tag='.$tag;
	else $asq = '';
	if($originDivision > $division) $str .= '<a href="'.$goUrl.'1&amp;originDivision='.$originDivision.'&amp;division='.($division + 1).$asq.'" title="ÅEûÏ™Ω ÅEîÏ£ºÅEº ÅEÅEÅE ÅEÄÅEâÌï©ÅEàÎã§">‚óÄ Continue</a> &nbsp;'; 
	if($currentPage > 1) $str .= '<a href="'.$goUrl.'1'.$asq.'" title="ÅEòÏùå ˙™òÏù¥ÅEÄÅEÅEÅE¥ÅEôÌï©ÅEàÎã§">First</a>';
	$startPage = (((int)(($currentPage - 1 ) / $writePages )) * $writePages) + 1;
	$endPage = $startPage + $writePages - 1;
	if($endPage >= $totalPage) $endPage = $totalPage;
	if($startPage > 1) $str .= ' &nbsp;<a href="'.$goUrl.($startPage-1).'&amp;originDivision='.$originDivision.'&amp;division='.$division.$asq.'" title="ÅE¥ÅEÅE˙™òÏù¥ÅEÄÅEÅEÅE¥ÅEôÌï©ÅEàÎã§">prev</a>';
	if($totalPage > 1)
	{
		for($i=$startPage;$i<=$endPage;$i++)
		{
			if($currentPage != $i) $str .= ' &nbsp;<a href="'.$goUrl.$i.'&amp;originDivision='.$originDivision.'&amp;division='.$division.$asq.'">'.$i.'</a>';
			else $str .= ' &nbsp;<strong>'.$i.'</strong> ';
		}
	}
	if($totalPage > $endPage) $str .= ' &nbsp;<a href="'.$goUrl.($endPage+1).'&amp;originDivision='.$originDivision.'&amp;division='.$division.$asq.'" title="ÅE§ÅEÅE˙™òÏù¥ÅEÄÅEÅEÅEòÏñ¥ÅEëÎãàÅE§">next</a>';
	if ($currentPage < $totalPage) $str .= ' &nbsp;<a href="'.$goUrl.$totalPage.'&amp;originDivision='.$originDivision.'&amp;division='.$division.$asq.'" title="ÅE® ÅEÅE˙™òÏù¥ÅEÄÅEÅEÅE¥ÅEôÌï©ÅEàÎã§">Last</a>';		
	if($division) $str .= ' &nbsp;<a href="'.$goUrl.'1&amp;originDivision='.$originDivision.'&amp;division='.($division - 1).$asq.'" title="ÅE§ÅEΩ ÅEîÏ£ºÅEº ÅEÅEÅE ÅEÄÅEâÌï©ÅEàÎã§">Continue ‚ñ∂</a>';
	$str .= '';
	return $str;
}

// ˙¶∏ÅEôÎ∞± ÅEºÅEÅE
function trackbackURL($uid)
{
	global $dbFIX, $grblog;
	$result = 'http://'.$_SERVER['HTTP_HOST'].$grblog.'trackback.php?p='.$uid;
	$key = @mysql_fetch_array(mysql_query('select user_key from '.$dbFIX.'config'));
	$result .= '&amp;grkey='.substr(md5('grblog'.date('YmdH').$uid.$key[0]), -6);
	return $result;
}

// ˙üúÍ∑∏ ÅEúÎ†•
function getTag($n=0, $sortBy='uid')
{
	global $dbFIX, $grblog;
	if($n) $aq = ' order by '.$sortBy.' desc limit '.$n;
	else $aq = '';
	$tag = @mysql_query('select tag, count from '.$dbFIX.'tag'.$aq);
	while($t = mysql_fetch_array($tag))
	{
		$lv = @ceil($t[1] / 5);
		echo '<a href="'.$grblog.'?tag='.urlencode($t[0]).'" class="lv'.$lv.'">'.stripslashes($t[0]).'</a> ';
	}
}

// ÅE¥˙°åÍ≥†ÅE¨ ÅE©ÅEùÏ∂úÎ†• ˙¥∏ÅEúÍ∏∞
function getCategory($node=0, $depth=0) {
	global $dbFIX, $grblog;
	static $uidStack = array();
	$result = '<ul>';
	if(!$uidStack[0]) {
		$totalCount = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'post'));
		$result .= '<li><a href="#">ÅE®ÅE† ÅEÄ</a> <span>('.$totalCount[0].')</span></li>';
	}
	if($node) $sql = ' where id = '.$node.' and depth != '.$depth; else $sql = '';
	$getCategory = @mysql_query('select * from '.$dbFIX.'category'.$sql.' order by uid asc, id asc');
	while($cat = mysql_fetch_array($getCategory)) {
		if(!in_array($cat['uid'], $uidStack, true)) array_push($uidStack, $cat['uid']);
		else continue;
		$count = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'post where category = \''.$cat['uid'].'\''));
		$result .= '<li>'.str_repeat('&nbsp;&nbsp;', $cat['depth']).' '.$addImg.'<a href="'.$grblog.'?cat='.$cat['uid'].'"'.$addToggle.'>'.stripslashes($cat['name']).'</a> <span>('.$count[0].')</span></li>';
		$lastUid = $cat['uid'];
		$getChild = @mysql_fetch_array(mysql_query('select uid from '.$dbFIX.'category where id = '.$cat['uid'].' and depth != '.$cat['depth'].' limit 1'));
		if($getChild['uid']) getCategory($img, $cat['uid'], $cat['depth']);
	}
	echo $result.'</ul>';
}

// ÅE¨ÅE• ÅEúÎ†•
function getCalendar()
{
	global $theme, $dbFIX, $grblog, $prefix;
	if(!$_GET['year']) $y = date('Y'); else $y = $_GET['year'];
	if(!$_GET['month']) $m = date('m'); else $m = $_GET['month'];
	if(!$_GET['day']) $d = date('d'); else $d = $_GET['day'];
	$fmktime = mktime(0, 0, 0, $m, 1, $y);
	$firstDay = date('w', $fmktime);
	$countDay = date('t', $fmktime);
	$lmktime = mktime(0, 0, 0, $m, $countDay, $y);
	$lastDay = date('w', $lmktime);
	if(($m - 1) < 1) { 
		$pm = 12;
		$py = $y - 1; 
	} else { 
		$pm =  $m - 1;
		$py = $y;
	}
	if(($m + 1) > 12) {
		$nm = 1;
		$ny = $y + 1;
	} else {
		$nm = $m + 1;
		$ny = $y;
	}
	include $prefix.$theme.'/head_calendar.php';
	$result = '';
	if($firstDay > 0) $result .= '<tr>'.str_repeat('<td></td>', $firstDay);
	$maxLoop = $countDay + 1;
	for($i=1; $i<$maxLoop; $i++)
	{
		$s = mktime(0, 0, 0, $m, $i, $y);
		$l = mktime(23, 59, 59, $m, $i, $y);
		$isExist = @mysql_fetch_array(mysql_query('select uid from '.$dbFIX.'post where signdate > '.$s.' and signdate < '.$l.' limit 1'));
		if($isExist[0]) $link = '<a href="'.$grblog.'?ds='.$s.'&amp;dl='.$l.'&amp;year='.$y.'&amp;month='.$m.'">'.$i.'</a>'; else $link = '';
		$nw = date('w', $s);
		if(!$nw) $result .= '<tr><td class="sun">'.(($link)?$link:$i).'</td>';
		elseif($d == $i) $result .= '<td class="n">'.(($link)?$link:$i).'</td>';
		elseif($nw == 6) $result .= '<td class="sat">'.(($link)?$link:$i).'</td>';
		else $result .= '<td>'.(($link)?$link:$i).'</td>';
		if($nw == 6) $result .= '</tr>';
	}
	$ws = 6 - $lastDay;
	if($ws > 0) $result .= str_repeat('<td></td>', $ws).'</tr>';
	$result .= '</tbody></table>';
	echo $result;
}

// EXIF ÅE∏ÅE§ÅEº ÅEïÎ≥¥ ÅEúÎ†•
function showEXIF($file)
{
	if(!eregi('\.jpg|\.jpeg|\.tiff', $file)) return '';
	if(!function_exists('exif_read_data')) return '';
	$exif = @exif_read_data($file);
	$result = 'Camera: '.$exif['Make'].' | '.
		'Model: '.$exif['Model'].' | '.
		'EditSoftware: '.$exif['Software'].' | '.
		'DateTime: '.$exif['DateTime'].' | '.
		'FileCompressionLevel: '.$exif['THUMBNAIL']['Compression'].' | '.
		'XResolution: '.$exif['THUMBNAIL']['XResolution'].' | '.
		'YResolution: '.$exif['THUMBNAIL']['YResolution'].' | '.
		'ExposureTime: '.$exif['ExposureTime'].' | '.
		'FNumber: '.$exif['FNumber'].' | '.
		'ISOSpeedRatings: '.$exif['ISOSpeedRatings'].' | '.
		'MeteringMode: '.$exif['MeteringMode'].' | '.
		'LightSource: '.$exif['LightSource'].' | '.
		'Flash: '.$exif['Flash'].' | '.
		'FocalLength: '.$exif['FocalLength'].' | '.
		'DigitalZoomRatio: '.$exif['DigitalZoomRatio'].' | '.
		'InterOperabilityIndex: '.$exif['InterOperabilityIndex'];
	return $result;
}

// ˙¥ÅEû¨ ÅEëÏÅEÅEÅEÅEòÌôò
function getNowVisitNum()
{
	global $prefix;
	return file_get_contents($prefix.'get_cnt_conn.php');
}

// ˙¥ÅEû¨ÅEëÏÅEÅEêÏÅE ÅEÄÅE• (+ÅEåÎ£ÅEÅE∏ÅEÅE-300ÅEÅEÅEàÍ≥º- ÅEÅEö∞ÅE∞)
function setNowVisit()
{
	if($_SESSION['no'] || $_SESSION['user_no'] || $_SESSION['antiSpam']) return;
	$time = time();
	$sess = @opendir('session');
	$loop = 0;
	while($s = @readdir($sess)) {
		if($s == '.' || $s == '..') continue;
		if((filemtime('session/'.$s)+300) < $time) @unlink('session/'.$s);
		else $loop++;
	}
	$fp = @fopen('get_cnt_conn.php', 'w');
	@fwrite($fp, $loop);
	@fclose($fp);
}

// ÅEêÍ≤©ÅEúÎ≤ÅEóê POST ÅEÅEHTTP ˙∞ÅE°úÌÅEÅEúÏùÑ ˙¢µ˙±¥ÅEÅEÅE∞ÅE¥˙†∞ ÅEÅEã¨
function postSend($url, $post) {
	$parse = parse_url($url);
	$fp = @fsockopen($parse['host'], 80, $errno, $errstr);
	if(!$fp) return $errstr;
	@stream_set_timeout($fp, 0);
	$puts = 'POST http://'.$parse['host'].$parse['path'].' HTTP/1.1'."\r\n";
	$puts .= 'Host: '.$parse['host']."\r\n";
	$puts .= 'User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)'."\r\n";
	$puts .= 'Content-Type: application/x-www-form-urlencoded; charset=utf-8'."\r\n";
	$puts .= 'Content-Length: '.strlen($post)."\r\n\r\n";
	$puts .= $post."\r\n";
	@fputs($fp, $puts);
	@fclose($fp);
}

// ˙≥àÏö©˙±ÅE˙üúÍ∑∏ÅEº ÅEúÏô∏˙±ÅEÅEòÎ®∏ÅEÄ ˙üúÍ∑∏ ÅEúÍ±∞
function strip_tags2($text, $tags) 
{
	$allowedTags = explode(',', $tags);
	preg_match_all('!<\s*(/)?\s*([a-zA-Z]+)[^>]*>!', $text, $allTags);
	array_shift($allTags);
	$slashes = $allTags[0];
	$allTags = $allTags[1];
	foreach ($allTags as $i => $tag) {
		if (in_array($tag, $allowedTags))
		continue;
		$text = preg_replace('!<(\s*'.$slashes[$i].'\s*'.$tag.'[^>]*)>!', '&lt;$1&gt;', $text);
	}
	return $text;
}
?>