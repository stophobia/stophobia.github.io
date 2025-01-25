<?php
/**
 * @update 2008-11-21
 * @comment 기념일 등록을 처리한다.
 */
include '../grnote.config.php';
include '../library/planner.lib.php';
$Pn = new Planner('../');
@extract($_POST);

// 특수문자 재처리
$original = array('@amp;', '@plus;', '@percent;', '@sharp;', '@question;');
$change = array('&', '+', '%', '#', '?');
$setDate = str_replace($original, $change, $setDate);
$subject = str_replace($original, $change, $subject);
$content = str_replace($original, $change, $content);

// 날짜 재가공
$startArray = explode('-', $setDate);
$intDate = mktime($setHour, 0, 0, $startArray[1], $startArray[2], 2000);

// 기념일 생성 혹은 수정
if($modifyNo) {
	$sql = "update {$Pn->divide}memorials set day = '$intDate', subject = '$subject', content = '$content' where uid = $modifyNo limit 1";
} else {
	$sql = "insert into {$Pn->divide}memorials set uid = '', day = '$intDate', subject = '$subject', content = '$content', member_key = ".$_SESSION['userNo'];
}
@mysql_query($sql);

// 기념일 목록 가져오기
$result = '<ol>';
$getMemo = @mysql_query('select * from '.$Pn->divide.'memorials where member_key = '.$_SESSION['userNo'].' order by day asc');
while($memos = @mysql_fetch_array($getMemo)) {
	$result .= '<li><span>'.date('m월 d일 a h', $memos['day']).'시 |</span> &nbsp;<strong style="cursor: pointer" onclick="Planner.memoModify('.$memos['uid'].');">'.stripslashes($memos['subject']).'</strong>';
	if($memos['content']) $result .= '<div>'.stripslashes(nl2br($memos['content'])).'</div>';
	$result .= '</li>';
}
if($result == '<ol>') $content .= '<li>기념일이 없습니다.</li>';
$result .= '</ol>';

// 최종 작업 결과 리턴 (여기까지 왔다면 0)
@header('Content-Type: text/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?><lists><![CDATA['.$result.']]></lists>';
?>