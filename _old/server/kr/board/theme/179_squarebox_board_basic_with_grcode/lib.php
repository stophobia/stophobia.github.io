<?php
/*
 * 기본 스킨에서 사용하는 기초 라이브러리
 *
 * 필요할 경우, 스킨의 view.php 나 list.php 파일에서 include(require) 하여
 * 아래에 정의한 함수들을 사용할 수 있습니다.
 * v1.7.9 부터 지원 중단되는 GR Code 를 이 곳에서 에뮬레이트 합니다.
 *
 */
// 첨부파일이 그림일 경우 처리하는 함수
function showImg($filename)
{
	global $id, $theme, $grboard, $articleNo, $dbFIX;
	$getPdsSave = @mysql_fetch_array(mysql_query('select no from '.$dbFIX.'pds_save where id = \''.$id.'\' and article_num = '.$articleNo.' limit 1'));
	$getPdsList = @mysql_fetch_array(mysql_query('select no, name from '.$dbFIX.'pds_list where type = 0 and uid = '.$getPdsSave['no'].' and idx = '.($fl-1)));
	if($getPdsList['no']) $filename = end(explode('/', $getPdsList['name']));
	$ft = end(explode('.', $filename));
	if ($ft == 'jpg' || $ft == 'gif' || $ft == 'png' || $ft == 'bmp' || $ft == 'JPG' || $ft == 'GIF' || $ft == 'PNG' || $ft == 'BMP') {
		return '<span><a href="data/'.$id.'/'.$filename.'" onclick="return hs.expand(this)"><img src="'.$grboard.'/phpThumb/phpThumb.php?src=../data/'.$id.'/'.$filename.'&amp;w=600&amp;h=500&amp;q=100&amp;fltr[]=usm|99|0.5|3" alt="그림보기" /></a></span>';
	}
	else return '<img src="'.$theme.'/image/down.gif" alt="파일을 다운로드 합니다." />';
}

// 멤버일 경우 등록된 사진과 자기소개 출력
function showMemberInfo($mem=0)
{
	if(!$mem) return;
	global $dbFIX;
	$result = '<div id="viewMemInfo">';
	$infoQue = @mysql_query("select photo, self_info from {$dbFIX}member_list where no = '$mem'");
	$m = @mysql_fetch_array($infoQue);
	if($m['photo']) $result .= '<div id="myPhoto"><img src="'.$m['photo'].'" alt="사진" title="" /></div>';
	else $result .= '<div id="myPhoto">&nbsp;</div>';
	if($m['self_info']) $result .= '<div id="myComment">'.nl2br(stripslashes($m['self_info'])).'</div>';
	else $result .= '<div id="myComment">소개글이 없습니다.</div>';
	$result .= '<div class="clear"></div></div>';
	return $result;
}

// 이름 출력 부분에 네임택이나 아이콘 출력 기능 추가
function showName($no, $name)
{
	$result = $name;
	global $dbFIX;
	$listtag = @mysql_fetch_array(mysql_query("select nametag, icon from {$dbFIX}member_list where no = '".$no."'"));
	if($listtag['nametag']) $result = '<img src="'.$listtag['nametag'].'" alt="" />';
	else $result = '<strong>'.$result.'</strong>';
	if($listtag['icon']) $result = '<img src="'.$listtag['icon'].'" alt="" /> '.$result;
	return $result;
}

// v1.7.9 이후부터 중단되는 GR Code 에뮬레이팅
if($view['is_grcode'])
{
	$grcodeArr = array('[b]', '[/b]', '[i]', '[/i]', '[img]', '[/img]', '[big]', '[/big]', '[color:', ':]', '[/color]', '[div]', 
		'[/div]', '[u]', '[/u]', '[s]', '[/s]', '[quote]', '[/quote]');
	$realtagArr = array('<strong>', '</strong>', '<em>', '</em>', '<img src="', '" alt="사용자 이미지" />', 
		'<big>', '</big>', '<span style="color:', '">', '</span>', '<div class="grcodeDIV">', '</div>', '<u>', 
		'</u>', '<del>', '</del>', '<blockquote><div>', '</div></blockquote>');
	$content = str_replace($grcodeArr, $realtagArr, $content);
	$url_patterns = array("#\[url\]([\w]+?://([\w\#$%&~/.\-;:=,?@\]+]|\[(?!url=))*?)\[/url\]#is",
		"#\[url\](.([\w\#$%&~/.\-;:=,?@\]+]|\[(?!url=))*?)\[/url\]#is",
		"#\[url=([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*?)\]([^?\n\r\t].*?)\[/url\]#is",
		"#\[url=([\w\#$%&~/.\-;:=,?@\[\]+]*?)\]([^?\n\r\t].*?)\[/url\]#is");
	$url_replacements = array("<a href=\"\\1\">\\1</a>","<a href=\"http://\\1\">\\1</a>","<a href=\"\\1\">\\2</a>","<a href=\"http://\\1\">\\2</a>");
	$content = preg_replace($url_patterns, $url_replacements, $content);
}
?>
