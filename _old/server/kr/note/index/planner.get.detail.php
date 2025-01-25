<?php
/**
 * @update 2008-11-21
 * @comment 선택한 날짜에 있는 세부 일정을 가져온다.
 * 플래너가 전체공개 상태면 일정 상세보기는 아무나 허용된다.
 */
include '../grnote.config.php';
include '../library/planner.lib.php';
$Pn = new Planner('../');

// 권한체크
if(($grNote['planner']['open'] == 2) && !$_SESSION['userNo']) {
	@header('Content-Type: text/xml; charset=utf-8');
	echo '<?xml version="1.0" encoding="utf-8"?><error>1</error>';
	exit();
}

// 선택된 일자의 세부 일정 가져오기
@extract($_POST);
$content = '<ol>';
$startDate = mktime(23, 59, 59, $m, $d, $y);
$endDate = mktime(0, 0, 0, $m, $d, $y);
if($grNote['planner']['open'] == 2) $addQ = ' and member_key = '.$_SESSION['userNo']; else $addQ = '';
$getDetail = @mysql_query("select * from {$Pn->divide}planners where start_work <= $startDate and end_work >= $endDate".$addQ." order by start_work asc");
while($detail = @mysql_fetch_array($getDetail)) {
	$content .= '<li><span>'.date('Y년 m월 d일 a h', $detail['start_work']).'시 ~ '.date('Y년 m월 d일 a h', $detail['end_work']).'시까지</span><br /><strong>'.stripslashes($detail['subject']).'</strong>';
	if($detail['content']) $content .= '<div>'.stripslashes(nl2br($detail['content'])).'</div>';
	$content .= '</li>'; 
}
if($content == '<ol>') $content .= '<li>일정이 없습니다.</li>';
$content .= '</ol>';

// 최종 작업 결과 리턴 (여기까지 왔다면 0)
@header('Content-Type: text/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?><lists><subject><![CDATA[<strong>'.$y.'년 '.$m.'월 '.$d.'일</strong> 세부일정]]></subject><content><![CDATA['.stripslashes($content).']]></content></lists>';
?>