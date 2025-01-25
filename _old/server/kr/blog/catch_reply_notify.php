<?php
$time = time();

// 기존 텍스트큐브계열 댓글알리미 수신처리
if($s_home_title) {

	// 이미 저장된 댓글이면 실행중지
	$isGetExistReply = @mysql_fetch_array(mysql_query('select uid from '.$dbFIX.'reply_catch where blog_url = \''.$url.'\' and r1_url = \''.rawurldecode($r1_url).'\' and r2_url = \''.rawurldecode($r2_url).'\''));
	if($isGetExistReply['uid']) exit();

	@mysql_query('insert into '.$dbFIX.'reply_catch set '.
		'uid = \'\', '.
		'blog_title = \''.addslashes(rawurldecode($s_home_title)).'\', '.
		'blog_url = \''.rawurldecode($url).'\', '.
		'post_title = \''.addslashes(rawurldecode($s_post_title)).'\', '.
		'post_uid = '.$s_no.', '.
		'r1_url = \''.rawurldecode($r1_url).'\', '.
		'r1_body = \''.addslashes(rawurldecode($r1_body)).'\', '.
		'r2_url = \''.rawurldecode($r2_url).'\', '.
		'r2_body = \''.rawurldecode($r2_body).'\', '.
		'signdate = '.$time);
}

// 제안된 댓글알리미 공개표준 스펙 수신처리
elseif($postTitle) {

	// 이미 저장된 댓글이면 실행중지
	$isGetExistReply = @mysql_fetch_array(mysql_query('select uid from '.$dbFIX.'reply_catch where blog_url = \''.$blogURL.'\' and r1_url = \''.rawurldecode($myURL).'\' and r2_url = \''.rawurldecode($replyURL).'\''));
	if($isGetExistReply['uid']) exit();

	@mysql_query('insert into '.$dbFIX.'reply_catch set '.
		'uid = \'\', '.
		'blog_title = \''.addslashes(rawurldecode($blogName)).'\', '.
		'blog_url = \''.rawurldecode($blogURL).'\', '.
		'post_title = \''.addslashes(rawurldecode($postTitle)).'\', '.
		'post_uid = '.(($s_no)?$s_no:0).', '.
		'r1_url = \''.rawurldecode($myURL).'\', '.
		'r1_body = \''.addslashes(rawurldecode($myBody)).'\', '.
		'r2_url = \''.rawurldecode($replyURL).'\', '.
		'r2_body = \''.rawurldecode($replyBody).'\', '.
		'signdate = '.$time);
}

// 응답 XML 페이지로 이동
move('answer_commentalimi.php');
?>