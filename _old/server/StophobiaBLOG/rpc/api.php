<?php
/*
 * 파일명: rpc/api.php
 * 목적: MetaWeblog API 를 GR Blog 에 맞게 구현
 * 작성자: sirini (http://sirini.net)
 * 마지막 수정일: 2008-07-23
 * 주의사항: 미구현된 사항들이 있으므로 실험적으로만 사용할 것
 */

// xmlrpc 통신에 필요한 사항들 정의
include 'xmlrpc.php';
include '../lib/common.php';
dbConn('../');

// 브라우저 내 쿠키 오작동 방지
$_COOKIE = array();

// 태그 추출
function _tag($str, $isNew=true) {
	global $dbFIX, $grblog;
	@preg_match('|&lt;grtag&gt;(.+?)&lt;/grtag&gt;|is', $str, $match);
	$tag = $match[1];
	$tag = str_replace(' ', '', $tag);
	$tags = explode(',', $tag);
	$tCount = count($tags);
	for($i=0; $i<$tCount; $i++)
	{
		$tagExist = @mysql_fetch_array(mysql_query('select uid from '.$dbFIX."tag where tag = '".$tags[$i]."'"));
		if(!$tagExist['uid']) @mysql_query('insert into '.$dbFIX."tag set uid = '', tag = '".$tags[$i]."', count = '0'");
		else {
			if($isNew) @mysql_query('update '.$dbFIX."tag set count = count + 1 where uid = '".$tagExist['uid']."'");
		}
	}
	return $tag;
}

// 본문 재가공
function _content($str) {
	$str = str_replace('<img style="border-right: 0px; border-top: 0px; border-left: 0px; border-bottom: 0px"', '<img', $str);
	$str = str_replace('.jpg"><img', '.jpg" onclick="return hs.expand(this)"><img', $str);
	$str = str_replace('.gif"><img', '.gif" onclick="return hs.expand(this)"><img', $str);
	$str = str_replace('.png"><img', '.png" onclick="return hs.expand(this)"><img', $str);
	$str = preg_replace('|&lt;grtag&gt;(.+?)&lt;/grtag&gt;|is', '', $str);
	$str = preg_replace('|<font color="(.+?)">|is', '<span style="color: $1">', $str);
	$str = preg_replace('|<font size="(.+?)">|is', '<span style="font-size: 1$1pt">', $str);
	$str = str_replace('</font>' , '</span>', $str);
	return addslashes($str);
}

// 블로그 확인
function GRBLOG_getUsersBlogs($params) {
	global $dbFIX, $grblog;
	list($appKey, $username, $password) = $params;
	
	// 아이디 비번 확인
	$isOwner = @mysql_fetch_array(mysql_query('select uid from '.$dbFIX."config where id = '$username' and password = '".md5($password)."' limit 1"));
	if(!$isOwner['uid']) die('Invalid auth');

	$config = @mysql_fetch_array(mysql_query('select blog_title from '.$dbFIX.'config where uid = 1'));
	$struct[] = array(
		'url'      => 'http://'.$_SERVER['HTTP_HOST'] . $grblog,
		'blogid'   => '1',
		'blogName' => stripslashes($config['blog_title']),
		'xmlrpc'   => 'http://'.$_SERVER['HTTP_HOST'] . $grblog . 'rpc/api.php',
	);

	// 작업 완료
	XMLRPC_response(XMLRPC_prepare($struct), WEBLOG_XMLRPC_USERAGENT);
}

// 새 포스트 작성
function GRBLOG_newPost($params) {
	global $dbFIX, $grblog;
	list($blogid, $username, $password, $struct, $publish) = $params;
	$subject = htmlspecialchars(addslashes($struct['title']));
	$content = _content($struct['description']);
	$tag = _tag($struct['description'], true);
	$cat = addslashes($struct['categories'][0]);
	
	// 아이디 비번 확인
	$isOwner = @mysql_fetch_array(mysql_query('select uid from '.$dbFIX."config where id = '$username' and password = '".md5($password)."' limit 1"));
	if(!$isOwner['uid']) die('invalid access');

	// 분류 가져오기
	$getCat = @mysql_fetch_array(mysql_query('select id from '.$dbFIX.'category where name = \''.$cat.'\''));

	// 포스트 작성
	$que = "insert into ".$dbFIX."post set uid = '', category = '".$getCat['id']."', signdate = '".time()."', subject = '$subject', ".
		"content = '$content', post_condition = '$publish', comment_condition = '1', ".
		"trackback = '', open_rss = '$publish', comment_count = '0', trackback_count = '0', tag = '$tag', writer = '$username', make_html = '0'";
	@mysql_query($que);
	$post_id = @mysql_insert_id();
	
	// 작업 완료
	XMLRPC_response(XMLRPC_prepare((string)$post_id), WEBLOG_XMLRPC_USERAGENT);
}

// 작성한 글 수정
function GRBLOG_editPost($params) {
	global $dbFIX, $grblog;
	list($postid, $username, $password, $struct, $publish) = $params;
	$subject = htmlspecialchars(addslashes($struct['title']));
	$content = _content($struct['description']);
	$tag = _tag($struct['description'], false);
	$cat = addslashes($struct['categories'][0]);

	// 아이디 비번 확인
	$isOwner = @mysql_fetch_array(mysql_query('select uid from '.$dbFIX."config where id = '$username' and password = '".md5($password)."' limit 1"));
	if(!$isOwner['uid']) die('Invalid auth');

	// 분류 가져오기
	$getCat = @mysql_fetch_array(mysql_query('select id from '.$dbFIX.'category where name = \''.$cat.'\''));

	// 포스트 수정
	$que = "update ".$dbFIX."post set category = '".$getCat['id']."', subject = '$subject', content = '$content', post_condition = '$publish', tag = '$tag' where uid = '$postid'";
	@mysql_query($que);

	// 작업 완료
	XMLRPC_response(XMLRPC_prepare((boolean)true), WEBLOG_XMLRPC_USERAGENT);
}

// 포스트 글 가져오기
function GRBLOG_getPost($params) {
	global $dbFIX, $grblog;
	list($postid, $username, $password) = $params;
	$post = array();

	// 아이디 비번 확인
	$isOwner = @mysql_fetch_array(mysql_query('select uid from '.$dbFIX."config where id = '$username' and password = '".md5($password)."' limit 1"));
	if(!$isOwner['uid']) die('Invalid auth');

	// 게시물 내용 담기
	$getPost = @mysql_fetch_array(mysql_query('select signdate, subject, content, writer from '.$dbFIX.'post where uid = '.$postid.' limit 1'));
	$post['userId'] = $getPost['writer'];
	$post['dateCreated'] = XMLRPC_convert_timestamp_to_iso8601($getPost['signdate']);
	$post['title'] = stripslashes($getPost['subject']);
	$post['content'] = stripslashes($getPost['content']);
	$post['postid'] = $postid;

	// 작업 완료
	XMLRPC_response(XMLRPC_prepare($post), WEBLOG_XMLRPC_USERAGENT);
}

// 분류(카테고리) 가져오기
function GRBLOG_getCategories($params) {
	global $dbFIX, $grblog;
	list($blogid, $username, $password) = $params;

	// 아이디 비번 확인
	$isOwner = @mysql_fetch_array(mysql_query('select uid from '.$dbFIX."config where id = '$username' and password = '".md5($password)."' limit 1"));
	if(!$isOwner['uid']) die('Invalid auth');

	// 카테고리 가져오기
	$getCategory = @mysql_query('select name from '.$dbFIX.'category');
	while($cat = @mysql_fetch_array($getCategory)) {
		$cate = stripslashes($cat['name']);
		$struct['description'] = $cate;
		$struct['title'] = $cate;
		$catList[] = $struct;
	}

	// 작업 완료
	XMLRPC_response(XMLRPC_prepare($catList), WEBLOG_XMLRPC_USERAGENT);
}

// 미디어 파일 (거의 이미지 파일) 첨부하기
function GRBLOG_newMediaObject($params) {
	global $dbFIX, $grblog;
	list($blogid, $username, $password, $struct) = $params;
	$filename = $struct['name'];
	$filetype = $struct['type'];
	$filebits = base64_decode($struct['bits']);

	// 바이너리 작성
	$tmpName = @explode('/', $filename);
	$cntSlash = @count($tmpName);
	$filename = str_replace(array('\\\\', ' '), array('\\', '_'), $tmpName[$cntSlash-1]);
	$fileroute = 'data/'.$filename;
	if(!file_exists('../'.$fileroute)) {
		$fp = @fopen('../'.$fileroute, 'wb');
		@fwrite($fp, $filebits);
		@fclose($fp);
	}

	// 업로드 성공시 DB에도 기록
	if(file_exists('../'.$fileroute)) {
		$isExist = @mysql_fetch_array(mysql_query('select uid from '.$dbFIX.'image where file_route = \''.$fileroute.'\' limit 1'));
		if(!$isExist['uid']) @mysql_query("insert into {$dbFIX}image set uid = '', file_route = 'data/{$filename}', signdate = '".time()."'");
	}

	// 작업 완료
	$struct['url'] = 'http://'.$_SERVER['HTTP_HOST'].$grblog.$fileroute;
	XMLRPC_response(XMLRPC_prepare($struct), WEBLOG_XMLRPC_USERAGENT);
}

// 메소드가 없을 때 (미구현한 API 호출시)
function XMLRPC_method_not_found($methodName) {
	XMLRPC_error("2", "[GR Blog] 요청하신 '$methodName' 메소드는 아직 지원되지 않습니다.", WEBLOG_XMLRPC_USERAGENT);
}

$xmlrpc_methods = array(
  'metaWeblog.newPost'  => 'GRBLOG_newPost',
  'metaWeblog.editPost' => 'GRBLOG_editPost',
  'metaWeblog.getPost'  => 'GRBLOG_getPost',
  'blogger.getUsersBlogs' => 'GRBLOG_getUsersBlogs',
  'metaWeblog.newMediaObject' => 'GRBLOG_newMediaObject',
  'metaWeblog.getCategories' => 'GRBLOG_getCategories'
);

$xmlrpc_request = XMLRPC_parse($HTTP_RAW_POST_DATA);
$methodName = XMLRPC_getMethodName($xmlrpc_request);
$params = XMLRPC_getParams($xmlrpc_request);

if(!isset($xmlrpc_methods[$methodName])) {
	XMLRPC_method_not_found($methodName);
} else {
	$xmlrpc_methods[$methodName]($params);
}
?>