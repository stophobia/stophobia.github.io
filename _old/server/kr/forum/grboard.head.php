<?php
/**
 * GR Forum Pre-Process for GR Board
 * @author sirini
 * @update 2009-08-04
 * @comment GR Board 게시판 연동 처리
 * @warning GR Board 게시판 영역 내에서 호출되므로, Core 와 연동되지 않는다.
 *          쿼리문은 GR Board 의 방식을 따른다.
 */

// 내비게이션용 경로
function getPath($parent=0, $result=array(array()), $count=0, $forumFIX, $grforum) {
	$get = @mysql_fetch_array(mysql_query('select name, parent from ' . $forumFIX . 'category where uid = ' . $parent));
	if(!$get['parent']) {
		arsort($result);
		$html = '<ul><li><a href="' . $grforum . '">처음화면</a></li>';
		for($i=count($result)-1; $i>=0; $i--) {
			list($p, $n) = each($result[$i]);
			$html .= '<li><a href="' . $grforum . '/?parent=' . $p . '&amp;action=view">' . $n . '</a></li>';
		}
		$html .= '</ul>';
		return $html;
	}
	$result[$count][$parent] = stripslashes($get['name']);
	return getPath($get['parent'], $result, ++$count, $forumFIX, $grforum);
}

// 포럼 통계
function getTotalStatus() {
	global $forumFIX, $dbFIX;
	$result['post'] = 0;
	$result['reply'] = 0;
	$result['member'] = end(@mysql_fetch_array(mysql_query('select count(*) from ' . $dbFIX . 'member_list')));
	$result['latest_member'] = stripslashes(end(@mysql_fetch_array(mysql_query('select nickname from ' . $dbFIX . 'member_list order by no desc limit 1'))));
	$bbs = @mysql_query('select bbs_id from ' . $forumFIX . 'category where bbs_id != \'\'');
	while($id = @mysql_fetch_array($bbs)) {
		$post = @mysql_fetch_array(mysql_query('select count(*) from ' . $dbFIX . 'bbs_' . $id['bbs_id']));
		$reply = @mysql_fetch_array(mysql_query('select count(*) from ' . $dbFIX . 'comment_' . $id['bbs_id']));
		$result['post'] += $post[0];
		$result['reply'] += $reply[0];
	}
	return $result;
}

// 현재 접속 회원 목록
function getNowConnList() {
	global $dbFIX;
	$result = '<ul><li>현재 접속중인 회원: </li>';
	$list = @mysql_query('select nickname from ' . $dbFIX . 'member_list where lastlogin > ' . (time()-600) . ' order by lastlogin desc');
	while($now = @mysql_fetch_array($list)) {
		$result .= '<li>' . stripslashes($now['nickname']) . '</li>';
		$isLooped = true;
	}
	if($isLooped) $result .= '</ul>';
	else $result .= '<li class="notFound">접속중인 회원이 없습니다.</li></ul>';
	return $result;
}

// 설정값 저장
define('__GRFORUM__', true);
$addHead = '<link rel="stylesheet" href="' . $theme . '/style.css" type="text/css" title="style" />';
$setting = array();
if($boardId) $id = $boardId;
$getSetting = @mysql_query('select opt, var from ' . $forumFIX . 'view');
while($set = @mysql_fetch_array($getSetting)) $setting[$set['opt']] = $set['var'];
$skin = $grforum . '/skin/' . $setting['layout_skin'];
$setting['logo_pos'] = $grforum . '/' . $setting['logo_pos'];
$myCatInfo = @mysql_fetch_array(mysql_query('select name, parent from ' . $forumFIX . 'category where bbs_id = \'' . $id . '\''));
$path = getPath($myCatInfo['parent'], array(array()), 0, $forumFIX, $grforum);
$forumTitle = stripslashes($myCatInfo['name']);
?>