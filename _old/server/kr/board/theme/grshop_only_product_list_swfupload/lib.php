<?php
/*
 * 기본 스킨에서 사용하는 기초 라이브러리
 *
 * 필요할 경우, 스킨의 view.php 나 list.php 파일에서 include(require) 하여
 * 아래에 정의한 함수들을 사용할 수 있습니다.
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

// swfupload 적용 스킨에서 추가 업로드된 것 처리
function showDownImg($filename, $extNo)
{
	global $id, $theme, $grboard;
	$getPdsList = @mysql_fetch_array(mysql_query('select no, name from '.$dbFIX.'pds_list where type = 1 and uid = '.$extNo));
	if($getPdsList['no']) $filename = end(explode('/', $getPdsList['name']));
	$ft = end(explode('.', $filename));
	if($ft == 'jpg' || $ft == 'gif' || $ft == 'png' || $ft == 'bmp') {
		return '<a href="data/'.$id.'/'.$filename.'" onclick="return hs.expand(this)">'.$filename.'</a> &nbsp;';
	}
	else return '<a href="'.$grboard.'/download.php?id='.$id.'&amp;articleNo='.$articleNo.'&amp;extNo='.$extNo.'">'.$filename.'</a> &nbsp;';
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

// 지정된 너비 이상의 이미지는 본문 보기시 자동 리사이즈
function autoImgResize($maxWidth, $content)
{
	global $grboard, $theme;
	$content = str_replace(array('class="multi-preview" src="', '" alt="미리보기"'), array('class="multi-preview" src="phpThumb/phpThumb.php?src=../',
		'&amp;w='.$maxWidth.'&amp;q=100&amp;fltr[]=usm|99|0.5|3" alt="미리보기"'), $content);
	return $content;
}
?>
