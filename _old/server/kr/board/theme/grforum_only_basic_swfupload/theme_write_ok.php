<?php
/*
 * 글쓰기 완료 전 처리
 *
 * GR Forum 과 연동되므로 글타래/댓글 수 변경 갱신 등 처리해줘야함
 */
include 'core.grforum.php';

// 부모 분류의 글과 글타래 카운팅 업데이트 처리
function setParentCount($parent, $diffPost, $diffReply, $bbsID, $bbsNo, $dbFIX) {
	$isExist = @mysql_fetch_array(mysql_query('select uid, parent from ' . $dbFIX . 'category where uid = ' . $parent . ' limit 1'));
	if(!$isExist['uid']) return;
	else {
		$parentStatus = @mysql_fetch_array(mysql_query('select uid from ' . $dbFIX . 'status where cat_uid = ' . $parent . ' limit 1'));
		@mysql_query('update ' . $dbFIX . 'status set post_count = post_count + ' . $diffPost . ', reply_count = reply_count + ' . $diffReply . ', latest_id = \'' . $bbsID . '\', latest_no = ' . $bbsNo . ' where uid = ' . $parentStatus['uid']);
		return setParentCount($isExist['parent'], $diffPost, $diffReply, $bbsID, $bbsNo, $dbFIX);
	}
}

// 상태 업데이트
if(!isset($mode) || !$articleNo) {
	$getMyCat = @mysql_fetch_array(mysql_query('select * from ' . $forumFIX . 'category where bbs_id = \'' . $id . '\' limit 1'));
	$getMyStat = @mysql_fetch_array(mysql_query('select * from ' . $forumFIX . 'status where cat_uid = ' . $getMyCat['uid'] . ' limit 1'));
	$getNewPostCount = @mysql_fetch_array(mysql_query('select count(*) from ' . $dbFIX . 'bbs_' . $id));
	$getNewReplyCount = @mysql_fetch_array(mysql_query('select count(*) from ' . $dbFIX . 'comment_' . $id));
	$getNextID = @mysql_fetch_array(mysql_query('show table status where Name = \'' . $dbFIX . 'bbs_' . $id . '\''));
	if($getMyStat['uid']) {
		@mysql_query('update ' . $forumFIX . 'status set post_count = ' . ($getNewPostCount[0]+1) . ', reply_count = ' . $getNewReplyCount[0] . ', latest_id = \'' . $id . '\', latest_no = ' . $getNextID['Auto_increment'] . ' where uid = ' . $getMyStat['uid']);
	} else {
		@mysql_query('insert into ' . $forumFIX . 'status set uid = \'\', cat_uid = \'' . $getMyCat['uid'] . '\', post_count = ' . ($getNewPostCount[0]+1) . ', reply_count = ' . $getNewReplyCount[0] . ', latest_id = \'' . $id . '\', latest_no = ' . $getNextID['Auto_increment']);
	}
	$diffPost = $getNewPostCount[0] - $getMyStat['post_count'] + 1;
	$diffReply = $getNewReplyCount[0] - $getMyStat['reply_count'];
	setParentCount($getMyCat['parent'], $diffPost, $diffReply, $id, $getNextID['Auto_increment'], $forumFIX);
}
?>