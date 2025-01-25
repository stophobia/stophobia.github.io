<?php
class Status {
	// 접속자수 (고유, 페이지뷰) 반환
	function getVisitNum($id, $y, $m=false, $d=false, $h=false) {
		$result['uniqView'] = 0;
		$result['pageView'] = 0;
		$getRows = 'select uniq_view, page_view from gc_visit_'.$id.' where year = '.$y;
		if($m) $getRows .= ' and month = '.$m;
		if($d) $getRows .= ' and day = '.$d;
		if($h) $getRows .= ' and hour = '.$h;
		$query = @mysql_query($getRows);
		if(!$query) return array('uniqView'=>1, 'pageView'=>1);
		while($list = mysql_fetch_array($query)) {
			$result['uniqView'] += $list['uniq_view'];
			$result['pageView'] += $list['page_view'];
		}
		return $result;
	}
	// 기본 아이디값 반환
	function getDefaultID() {
		$id = @mysql_fetch_array(mysql_query('select name from gc_id limit 1'));
		return $id['name'];
	}
	// 처음 년도 선택
	function getFirstYear($id) {
		$year = @mysql_fetch_array(mysql_query('select year from gc_visit_'.$id.' limit 1'));
		if(!$year['year']) return date('Y');
		return $year['year'];
	}
	// 연 고유클릭 or 페이지뷰 최대값 반환
	function getMaxVisitYear($id, $y, $b='uniq') {
		$result = array();
		$getYear = @mysql_query('select total_'.$b.'_year from gc_year where id = \''.$id.'\'');
		while($years = mysql_fetch_array($getYear)) {
			$result[] = $years['total_'.$b.'_year'];
		}
		if(!$result[0]) $result[0] = 1;
		return max($result);
	}
	// 월 고유클릭 or 페이지뷰 최대값 반환
	function getMaxVisitMonth($id, $y, $b='uniq') {
		$result = array();
		$getMonth = @mysql_query('select '.$b.'_view, month from gc_visit_'.$id.' where year = '.$y);
		while($month = mysql_fetch_array($getMonth)) {
			$m = intval($month['month']) - 1;
			if(!$result[$m]) $result[$m] = 0;
			$result[$m] += $month[$b.'_view'];
		}
		if(!$result[0]) $result[0] = 1;
		return max($result);
	}
	// 일일 고유클릭 or 페이지뷰 최대값 반환
	function getMaxVisitDay($id, $y, $m, $b='uniq') {
		$result = array();
		$getDay = @mysql_query('select '.$b.'_view, day from gc_visit_'.$id.' where year = '.$y.' and month = '.$m);
		while($day = mysql_fetch_array($getDay)) {
			$d = intval($day['day']) - 1;
			if(!$result[$d]) $result[$d] = 0;
			$result[$d] += $day[$b.'_view'];
		}
		if(!$result[0]) $result[0] = 1;
		return max($result);
	}
	// 일일 24시간 중 고유클릭 or 페이지뷰 최대값 반환
	function getMaxVisitHour($id, $y, $m, $d, $b='uniq') {
		$result = array();
		$getHour = @mysql_query('select '.$b.'_view, hour from gc_visit_'.$id.' where year = '.$y.' and month = '.$m.' and day = '.$d);
		while($hour = mysql_fetch_array($getHour)) {
			$h = intval($hour['hour']) - 1;
			if(!$result[$d]) $result[$h] = 0;
			$result[$h] += $hour[$b.'_view'];
		}
		if(!$result[0]) $result[0] = 1;
		return max($result);
	}
}
?>