<?php
include $grcount . 'db_info.php';

// 특정일의 고유/페이지뷰 가져오기
function getSomedayCount($id, $b='uniq', $timestamp=0) {
	$y = date('Y', $timestamp);
	$m = date('m', $timestamp);
	$d = date('d', $timestamp);
	$getDayVisitor = @mysql_fetch_array(mysql_query('select sum('.$b.'_view) from gc_visit_'.$id.' where year = '.$y.' and month = '.$m.' and day = '.$d));
	if(!$getDayVisitor[0]) $getDayVisitor[0] = 0;
	return $getDayVisitor[0];
}
// 전체 고유/페이지뷰 가져오기
function getTotalCount($id) {
	return @mysql_fetch_array(mysql_query('select total_uniq_view, total_page_view from gc_id where name = \''.$id.'\''));
}
// 변수처리
function setCount($id) {
	$total = getTotalCount($id);
	$grStat = array(array());
	$grStat['today']['uniq'] = getSomedayCount($id, 'uniq', time());
	$grStat['today']['page'] = getSomedayCount($id, 'page', time());
	$grStat['yesterday']['uniq'] = getSomedayCount($id, 'uniq', time()-86400);
	$grStat['yesterday']['page'] = getSomedayCount($id, 'page', time()-86400);
	$grStat['total']['uniq'] = $total['total_uniq_view'];
	$grStat['total']['page'] = $total['total_page_view'];
	return $grStat;
}
// 일주일간의 고유방문자수 가져오기
function getWeekUniqCount($id) {
	$stat = array();
	$time = time();
	for($i=0; $i<7; $i++) {
		$stat[$i] = getSomedayCount($id, 'uniq', $time-(86400*$i));
	}
	return $stat;
}
// 일주일간의 페이지뷰수 가져오기
function getWeekPageCount($id) {
	$stat = array();
	$time = time();
	for($i=0; $i<7; $i++) {
		$stat[$i] = getSomedayCount($id, 'page', $time-(86400*$i));
	}
	return $stat;
}
// 카운터 출력
function showCount($theme, $conf=array()) {
	global $grcount, $grid;
	$grStat = setCount($grid);
	include $grcount . 'theme/' . $theme . '/thumb.php';
}
?>