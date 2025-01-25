<?php
/**
 * @update 2008-11-21
 * @comment 선택한 날짜에 대한 일정들을 가져와 보여준다.
 */
include '../grnote.config.php';
include '../library/planner.lib.php';
$Pn = new Planner('../');

// 권한체크
$getUser = @mysql_fetch_array(mysql_query('select member_key from '.$Pn->divide.'planners where uid = '.$_POST['getNo']));
if(($grNote['planner']['open'] == 2) && ($getUser['member_key'] != $_SESSION['userNo'])) {
	@header('Content-Type: text/xml; charset=utf-8');
	echo '<?xml version="1.0" encoding="utf-8"?><error>1</error>';
	exit();
}

// 선택된 일정 가져오기
$modify = @mysql_fetch_array(mysql_query('select * from '.$Pn->divide.'planners where uid = '.$_POST['getNo']));

// 최종 작업 결과 리턴 (여기까지 왔다면 0)
@header('Content-Type: text/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?><lists><startDate>'.date('Y-m-d', $modify['start_work']).'</startDate>'.
	'<endDate>'.date('Y-m-d', $modify['end_work']).'</endDate><startHour>'.date('H', $modify['start_work']).'</startHour>'.
	'<endHour>'.date('H', $modify['end_work']).'</endHour><level>'.$modify['level'].'</level>'.
	'<subject><![CDATA['.stripslashes($modify['subject']).']]></subject><content><![CDATA['.(($modify['content'])?stripslashes($modify['content']):'일정 내용이 없습니다.').']]></content></lists>';
?>