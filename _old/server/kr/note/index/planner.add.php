<?php
/**
 * @update 2008-11-21
 * @comment 일정을 추가한다.
 */
include '../grnote.config.php';
include '../library/planner.lib.php';
$Pn = new Planner('../');
@extract($_POST);

// 권한 체크, 없다면 에러 1 리턴
if(!$_SESSION['userNo']) {
	@header('Content-Type: text/xml; charset=utf-8');
	echo '<?xml version="1.0" encoding="utf-8"?><error>1</error>';
	exit();
}

// 특수문자 재처리
$original = array('@amp;', '@plus;', '@percent;', '@sharp;', '@question;');
$change = array('&', '+', '%', '#', '?');
$startDate = str_replace($original, $change, $startDate);
$endDate = str_replace($original, $change, $endDate);
$subject = str_replace($original, $change, $subject);
$content = str_replace($original, $change, $content);

// 날짜 재가공
$startArray = explode('-', $startDate);
$endArray = explode('-', $endDate);
$intStartDate = mktime($startHour, 0, 0, $startArray[1], $startArray[2], $startArray[0]);
$intEndDate = mktime($endHour, 0, 0, $endArray[1], $endArray[2], $endArray[0]);

// 일정 생성 혹은 수정
if($modifyNo) {
	$sql = "update {$Pn->divide}planners set start_work = '$intStartDate', end_work = '$intEndDate', level = $level, subject = '$subject', content = '$content' where uid = $modifyNo limit 1";
} else {
	$sql = "insert into {$Pn->divide}planners set uid = '', start_work = '$intStartDate', end_work = '$intEndDate', level = '$level', subject = '$subject', content = '$content', member_key = ".$_SESSION['userNo'];
}
@mysql_query($sql);

// 최종 작업 결과 리턴 (여기까지 왔다면 0)
@header('Content-Type: text/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?><error>0</error>';
?>