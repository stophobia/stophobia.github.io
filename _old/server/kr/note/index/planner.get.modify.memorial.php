<?php
/**
 * @update 2008-11-21
 * @comment 가져온 기념일을 수정한다.
 */
include '../grnote.config.php';
include '../library/planner.lib.php';
$Pn = new Planner('../');

// 권한체크
$getUser = @mysql_fetch_array(mysql_query('select member_key from '.$Pn->divide.'memorials where uid = '.$_POST['getNo']));
if($getUser['member_key'] != $_SESSION['userNo']) {
	@header('Content-Type: text/xml; charset=utf-8');
	echo '<?xml version="1.0" encoding="utf-8"?><error>1</error>';
	exit();
}

// 선택된 일정 가져오기
$modify = @mysql_fetch_array(mysql_query('select * from '.$Pn->divide.'memorials where uid = '.$_POST['getNo']));

// 전체 기념일 가져오기
$content = '<ol>';
$getMemos = @mysql_query("select * from {$Pn->divide}memorials where member_key = ".$_SESSION['userNo']." order by day asc");
while($memos = @mysql_fetch_array($getMemos)) {
	$content .= '<li><span>'.date('m월 d일 a h', $memos['day']).'시 |</span> &nbsp;<strong style="cursor: pointer" onclick="Planner.memoModify('.$memos['uid'].');">'.stripslashes($memos['subject']).'</strong>';
	if($memos['content']) $content .= '<div>'.stripslashes(nl2br($memos['content'])).'</div>';
	$content .= '</li>'; 
}
if($content == '<ol>') $content .= '<li>기념일이 없습니다.</li>';
$content .= '</ol>';

// 최종 작업 결과 리턴 (여기까지 왔다면 0)
@header('Content-Type: text/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?><lists><setDate>'.date('Y-m-d', $modify['day']).'</setDate>'.
	'<setHour>'.date('H', $modify['day']).'</setHour><subject><![CDATA['.stripslashes($modify['subject']).']]></subject>'.
	'<content><![CDATA['.(($modify['content'])?stripslashes($modify['content']):'일정 내용이 없습니다.').']]></content><fullList><![CDATA['.stripslashes($content).']]></fullList></lists>';
?>