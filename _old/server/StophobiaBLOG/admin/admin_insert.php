<?php
$prefix = '../';
include '../php_head.php';
if(!$_SESSION['no']) {
	@extract($_POST);
	@header('Content-Type: text/xml; charset=utf-8');
	die('<?xml version="1.0" encoding="utf-8"?><lists><msg muid="'.$modifyUid.'">'.
		'<![CDATA[ <span style="color: red; font-weight: bold">[!] 글을 저장하지 못했습니다. [로그인 세션만료]</span><br /> '.
		'브라우저 새 탭을 열어서 새 탭에 로그인을 하신 후 지금 현재 탭에서 저장/출판을 다시 시도해 보세요.</span>]]></msg><open_rss>'.$open_rss.'</open_rss><c_condition>'.
		$comment_condition.'</c_condition><use_sync>'.$use_sync.'</use_sync><modify_time>'.$modifyTime.'</modify_time></lists>');
}

$e = true;
if(array_key_exists('postStart', $_POST) && $_POST['postStart'])
{
	@extract($_POST);
	if(!trim($subject)) $e = false;
	if(!trim($content)) $e = false;
	if(!$e)
	{
		@header('Content-Type: text/xml; charset=utf-8');
		die('<?xml version="1.0" encoding="utf-8"?><lists><msg>글을 저장하지 못했습니다. 글제목 혹은 글내용이 유효하지 않습니다.</msg></lists>');
	}
	include '../lib/common.php';
	dbConn('../');
	include '../lib/trackback.php';
	
	$_category = explode('.', $category);
	$category = $_category[0];
	$path = str_replace('/admin/admin_insert.php', '', $_SERVER['SCRIPT_NAME']);
	$url = 'http://'.$_SERVER['HTTP_HOST'].$path.'/?p='.$modifyTarget;
	$sinkNET = 'http://sirini.net/sink/sink.php?id=grblog&no=1';
	$original = array('#amp;', '#plus;', '#percent;', '#rslash;');
	$change = array('&amp;', '+', '%', '￦');
	$subject = addslashes(str_replace($original, $change, $subject));
	$content = addslashes(str_replace($original, $change, $content));
	if(!preg_match('/hs\.expand/i', $content)) {
		$content = preg_replace('/<img src=(.*?) alt=(.*?) \/>/i', '<a href=$1 onclick="return hs.expand(this)"><img src=$1 alt="upload image" title="" /></a>', $content);
		$content = preg_replace('/{{{(.*?)}}}/i', '<img src="image/file_icon/$1.gif" alt="lightbox" />', $content);
	}
	$trackback = str_replace('#amp;', '&', $trackback);
	$tag = str_replace($original, $change, $tag);

	// 글 수정
	if($modifyTarget) {
		if($tag) {
			$tag = str_replace(' ', '', $tag);
			$tags = explode(',', $tag);
			$tCount = count($tags);
			for($i=0; $i<$tCount; $i++) {
				$tagExist = @mysql_fetch_array(mysql_query("select uid from ".$dbFIX."tag where tag = '".$tags[$i]."'"));
				if(!$tagExist[0]) @mysql_query("insert into ".$dbFIX."tag set uid = '', tag = '".$tags[$i]."', count = '0'");
			}
		}
		$old = @mysql_fetch_array(mysql_query("select trackback from ".$dbFIX."post where uid = '$modifyTarget'"));
		if($trackback && ($old[0] != $trackback)) $answer = sendTrackback($trackback, $url, $name, $subject, $content, $encoding);
		$que = "update ".$dbFIX."post set subject = '$subject', content = '$content', ";
		if($modifyTime) $que .= "signdate = '".time()."', ";
		if($post_condition == 2) $category = 0;
		$que .= "category = '$category', open_rss = '$open_rss', comment_condition = '$comment_condition', ".
			"tag = '$tag', trackback = '$trackback', post_condition = '$post_condition', writer = '$writeID', make_html = '$makeHTML' where uid = '$modifyTarget'";
		$addMsg = '<a href="http://'.$_SERVER['HTTP_HOST'].$path.'/?p='.$modifyTarget.'" onclick="window.open(this.href, \'_blank\'); return false">[게시물 수정 확인]</a> :: 게시물을 수정 하였습니다 :: ';
		if($answer) $addMsg .= '트랙백을 보내지 못했습니다. ('.str_replace('&', '_', $answer).')';
		if($post_condition == 1) $addMsg .= '글이 공개되었습니다.';
		elseif($post_condition == 2) $addMsg .= '글이 공지글로 공개 되었습니다.';
		else $addMsg .= '글이 아직 공개되지 않았습니다.';
		if($is_autosave) $addMsg = date('H시 i분 s초').'에 글을 <strong>비밀글로 자동 저장</strong>하였습니다.';
		@mysql_query($que);
		$modifyUid = $modifyTarget;
		if($use_sync) {
			$resultSync = sendTrackback($sinkNET, $url, $name, $subject, 'GR Blog');
			if($resultSync) $addMsg .= ' (싱크실패: '.$resultSync.')'; else $addMsg .= ' (싱크성공)';
		}
		if($makeHTML && @file_exists('../cache/'.$modifyTarget.'.html')) @unlink('../cache/'.$modifyTarget.'.html');
		if(file_exists('../cache/page.1.html')) @unlink('../cache/page.1.html');
	}

	// 새 글
	else {
		if($tag) {
			$tag = str_replace(' ', '', $tag);
			$tags = explode(',', $tag);
			$tCount = count($tags);
			for($i=0; $i<$tCount; $i++) {
				$tagExist = @mysql_fetch_array(mysql_query("select uid from ".$dbFIX."tag where tag = '".$tags[$i]."'"));
				if($tagExist[0]) @mysql_query("update ".$dbFIX."tag set count = count + 1 where uid = '".$tagExist[0]."'");
				else @mysql_query("insert into ".$dbFIX."tag set uid = '', tag = '".$tags[$i]."', count = '0'");
			}
		}
		$nowTime = time();
		if($post_condition == 2) $category = 0;
		$que = "insert into ".$dbFIX."post set uid = '', category = '$category', signdate = '$nowTime', subject = '$subject', ".
			"content = '$content', post_condition = '$post_condition', comment_condition = '$comment_condition', ".
			"trackback = '$trackback', open_rss = '$open_rss', comment_count = '0', trackback_count = '0', tag = '$tag', writer = '$writeID', make_html = '$makeHTML'";
		@mysql_query($que);
		$insertID = @mysql_insert_id();
		$addMsg = '<a href="http://'.$_SERVER['HTTP_HOST'].$path.'/?p='.$insertID.'" onclick="window.open(this.href, \'_blank\'); return false">[게시물 작성 확인]</a> :: 게시물을 작성했습니다 :: ';
		if($is_autosave) $addMsg = date('H시 i분 s초').'에 글을 <strong>비밀글로 자동 저장</strong>하였습니다.';
		$modifyUid = $insertID;
		$url = 'http://'.$_SERVER['HTTP_HOST'].$path.'/?p='.$insertID;
		if($trackback) $answer = sendTrackback($trackback, $url, $name, $subject, $content, $encoding);
		if($answer) $addMsg .= '트랙백 보내기 실패 ('.str_replace('&', '_', $answer).') :: ';
		if($post_condition == 1) $addMsg .= '글이 공개되었습니다.';
		elseif($post_condition == 2) $addMsg .= '글이 공지글로 공개 되었습니다.';
		else $addMsg .= '글이 아직 공개되지 않았습니다.';
		if($use_sync) {
			$resultSync = sendTrackback($sinkNET, $url, $name, $subject, 'GR Blog');
			if($resultSync) $addMsg .= ' (싱크실패: '.$resultSync.')'; else $addMsg .= ' (싱크성공)';
		}
	}

	$xml = '<?xml version="1.0" encoding="utf-8"?><lists><msg muid="'.$modifyUid.'"><![CDATA[';
	$xml .= $addMsg.']]></msg><open_rss>'.$open_rss.'</open_rss><c_condition>'.$comment_condition.'</c_condition>';
	$xml .= '<use_sync>'.$use_sync.'</use_sync><modify_time>'.$modifyTime.'</modify_time></lists>';
	@header('Content-Type: text/xml; charset=utf-8');
	echo $xml;
}
?>
