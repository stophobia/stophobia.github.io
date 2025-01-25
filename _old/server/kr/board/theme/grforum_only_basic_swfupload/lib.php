<?php
/*
 * 기본 스킨에서 사용하는 기초 라이브러리
 *
 * 필요할 경우, 스킨의 view.php 나 list.php 파일에서 include(require) 하여
 * 아래에 정의한 함수들을 사용할 수 있습니다.
 *
 */

// swfupload 적용 스킨에서 추가 업로드된 것 처리
function showDownImg($filename, $extNo)
{
	global $id, $theme, $grboard, $articleNo, $dbFIX;
	$getPdsList = @mysql_fetch_array(mysql_query('select no, name from '.$dbFIX.'pds_list where type = 1 and uid = '.$extNo));
	if($getPdsList['no']) $filename = end(explode('/', $getPdsList['name']));
	$ft = end(explode('.', $filename));
	if ($ft == 'jpg' || $ft == 'gif' || $ft == 'png' || $ft == 'bmp' || $ft == 'JPG' || $ft == 'GIF' || $ft == 'PNG' || $ft == 'BMP') {
		return '<a href="data/'.$id.'/'.$filename.'" onclick="return hs.expand(this)" title="클릭하시면 그림을 펼쳐 봅니다."><img src="phpThumb/phpThumb.php?src=../data/'.$id.'/'.$filename.'&amp;h=30&amp;q=100&amp;fltr[]=usm|99|0.5|3" alt="미리보기" /></a> &nbsp;';
	}
	else return '<a href="'.$grboard.'/download.php?id='.$id.'&amp;articleNo='.$articleNo.'&amp;extNo='.$extNo.'" title="클릭하시면 파일을 내려 받습니다.">'.$filename.'</a> &nbsp;';
}

// 기본 업로드 처리
function showImg($filename, $fl)
{
	global $id, $theme, $grboard, $articleNo, $dbFIX;
	$getPdsSave = @mysql_fetch_array(mysql_query('select no from '.$dbFIX.'pds_save where id = \''.$id.'\' and article_num = '.$articleNo.' limit 1'));
	$getPdsList = @mysql_fetch_array(mysql_query('select no, name from '.$dbFIX.'pds_list where type = 0 and uid = '.$getPdsSave['no'].' and idx = '.($fl-1)));
	if($getPdsList['no']) $filename = end(explode('/', $getPdsList['name']));
	$ft = end(explode('.', $filename));
	if($ft == 'jpg' || $ft == 'gif' || $ft == 'png' || $ft == 'bmp') {
		return '<a href="data/'.$id.'/'.$filename.'" onclick="return hs.expand(this)" title="클릭하시면 그림을 펼쳐 봅니다."><img src="phpThumb/phpThumb.php?src=../data/'.$id.'/'.$filename.'&amp;h=30&amp;q=100&amp;fltr[]=usm|99|0.5|3" alt="미리보기" /></a> &nbsp;';
	}
	else return '<a href="'.$grboard.'/download.php?id='.$id.'&amp;articleNo='.$articleNo.'&amp;num='.$fl.'" title="클릭하시면 파일을 내려 받습니다.">'.$filename.'</a> &nbsp;';
}

// 지정된 너비 이상의 이미지는 본문 보기시 자동 리사이즈
function autoImgResize($maxWidth, $content)
{
	global $grboard, $theme;
	$content = str_replace(array('class="multi-preview" src="', '" alt="미리보기"'), array('class="multi-preview" src="phpThumb/phpThumb.php?src=../',
		'&amp;w='.$maxWidth.'&amp;q=100&amp;fltr[]=usm|99|0.5|3" alt="미리보기"'), $content);
	return $content;
}

// 이 게시판에서 작성한 글 / 댓글
function getWriterStatus($key)
{
	global $id, $dbFIX;
	$result = array();
	$result['post'] = 0;
	$result['reply'] = 0;
	if($key) {
		$getBBSList = @mysql_query('select id from '.$dbFIX.'board_list');
		while($bbs = @mysql_fetch_array($getBBSList)) {
			$result['post'] += end(@mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'bbs_'.$bbs['id'].' where member_key = '.$key)));
			$result['reply'] += end(@mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'comment_'.$bbs['id'].' where member_key = '.$key)));
		}
	}
	return $result;
}

// phpBB 의 BBCode 구현 (기본 사용함)
function setBBCode($content, $use=true)
{
	if(!$use) return $content;
	$bbcode = array('#\[b\](.*?)\[/b\]#is','#\[i\](.*?)\[/i\]#is','#\[u\](.*?)\[/u\]#is',
	   '#\[s\](.*?)\[/s\]#is','#\[quote\](.*?)\[/quote\]#is','#\[code=(.*?)\](.*?)\[/code\]#ise',
	   '#\[size=([1-9]|1[0-9]|20)\](.*?)\[/size\]#is','#\[color=(.*?)\](.*?)\[/color\]#is',
	   '#\[url=((?:ftp|https?)://.*?)\](.*?)\[/url\]#i','#\[url\]((?:ftp|https?)://.*?)\[/url\]#i',
	   '#\[img\](https?://.*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]#i');
	$toHTML = array('<strong>$1</strong>','<em>$1</em>','<span style="text-decoration: underline;">$1</span>',
	   '<span style="text-decoration: line-through;">$1</span>','<blockquote>$1</blockquote>','\'<pre class="brush: $1; gutter: false;">\'.str_replace(\'<br />\', "\n", \'$2\')."</pre>"',
	   '<span style="font-size: $1px;">$2</span>','<span style="color: $1;">$2</span>',
	   '<a href="$1">$2</a>','<a href="$1">$1</a>','<img src="$1" alt="" />');
	$content = preg_replace($bbcode, $toHTML, $content);
	return $content;
}
?>
