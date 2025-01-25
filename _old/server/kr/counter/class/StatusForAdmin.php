<?php
class StatusForAdmin {
	function getSomedayCount($id, $b='uniq', $timestamp=0) {
		$y = date('Y', $timestamp);
		$m = date('m', $timestamp);
		$d = date('d', $timestamp);
		$getDayVisitor = @mysql_fetch_array(mysql_query('select sum('.$b.'_view) from gc_visit_'.$id.' where year = '.$y.' and month = '.$m.' and day = '.$d));
		if(!$getDayVisitor[0]) $getDayVisitor[0] = 0;
		return $getDayVisitor[0];
	}
	function getLastWeekCount($id, $b='uniq') {
		$time = time();
		$dayCount = array();
		$dayCount[] = $this->getSomedayCount($id, $b, $time);
		$dayCount[] = $this->getSomedayCount($id, $b, $time - 86400);
		$dayCount[] = $this->getSomedayCount($id, $b, $time - 172800);
		$dayCount[] = $this->getSomedayCount($id, $b, $time - 259200);
		$dayCount[] = $this->getSomedayCount($id, $b, $time - 345600);
		$dayCount[] = $this->getSomedayCount($id, $b, $time - 432000);
		$dayCount[] = $this->getSomedayCount($id, $b, $time - 518400);
		return $dayCount;
	}
	function getLast2WeekCount($id, $b='uniq') {
		$time = time() - 518400;
		$dayCount = array();
		for($i=0; $i<14; $i++)
			$dayCount[] = $this->getSomedayCount($id, $b, $time - (86400 * $i));
		return $dayCount;
	}
	function getXTick2WeekDate() {
		$time = time() - 518400;
		$tick = array();
		for($i=0; $i<14; $i++)
			$tick[] = date('m.d', $time - (86400 * $i));
		return $tick;
	}
	function getXTickDate() {
		$time = time();
		$tick = array();
		$tick[] = date('m.d', $time);
		$tick[] = date('m.d', $time - 86400);
		$tick[] = date('m.d', $time - 172800);
		$tick[] = date('m.d', $time - 259200);
		$tick[] = date('m.d', $time - 345600);
		$tick[] = date('m.d', $time - 432000);
		$tick[] = date('m.d', $time - 518400);
		return $tick;
	}
	function getTop5ReferURL($id) {
		$refer = array();
		$getURL = @mysql_query('select url from gc_reference_'.$id.' order by count desc limit 5');
		while($url = @mysql_fetch_array($getURL)) {
			if(!$url['url']) $refer[] = '직접입력';
			else {
				$tmp = @explode('/', $url['url']);
				$refer[] = str_replace('http://', '', $tmp[2]);
			}
		}
		for($c=0; $c<6; $c++) {
			if(!$refer[$c]) $refer[$c] = '없음';
		}
		return $refer;
	}
	function getTop5ReferRatio($id) {
		$top5Ratio = array();
		$result = array();
		$getTop5 = @mysql_query('select count from gc_reference_'.$id.' order by count desc limit 5');
		while($top5 = @mysql_fetch_array($getTop5)) $top5Ratio[] = $top5['count'];
		$totalTop5Count = array_sum($top5Ratio);
		if(!$totalTop5Count) $totalTop5Count = 1;
		for($i=0; $i<5; $i++) $result[$i] = floor(($top5Ratio[$i] / $totalTop5Count) * 100);
		for($c=0; $c<6; $c++) {
			if(!$result[$c]) $result[$c] = 1;
		}
		return $result;
	}
	function getTop5ReferDomain($id) {
		$refer = array();
		$getDomain = @mysql_query('select url from gc_reference_domain where id = \''.$id.'\' order by count desc limit 5');
		while($url = @mysql_fetch_array($getDomain)) {
			if($url['url']) $refer[] = $url['url'];
		}
		return $refer;
	}
	function getTop5DomainRatio($id) {
		$ratio = array();
		$getTop5 = @mysql_query('select count from gc_reference_domain where id = \''.$id.'\' order by count desc limit 5');
		while($top5 = @mysql_fetch_array($getTop5)) $ratio[] = $top5['count'];
		$sum = array_sum($ratio);
		if($sum) for($i=0; $i<5; $i++) $ratio[$i] = floor(($ratio[$i] / $sum) * 100);
		return $ratio;
	}
}
?>