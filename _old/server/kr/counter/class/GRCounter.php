<?php
class GRCounter {
	// 오늘날짜 (년, 월, 일)
	var $year, $month, $day, $hour;
	var $isExtremeMode; # 1 이면 속도위주 / 0 이면 안정위주
	
	// 객체 초기화시 오늘날짜 저장
	function GRCounter() {
		global $grcount;
		if(!$grcount) $grcount = '../';
		$this->year = date('Y');
		$this->month = date('m');
		$this->day = date('d');
		$this->hour = date('H');
		@$this->dbConn($grcount);
	}
	// DB접속 (Common 클래스와 중복됨)
	function dbConn($path='') {
		include $path.'db_info.php';
		$this->isExtremeMode = $useExtremeMode;
	}
	// gc_ip_$id 에 IP 등록
	function addIp($ip, $id, $updateTime=false) {
		if($updateTime) $upQ =', signdate = '.time(); else $upQ = '';
		if(!$this->isExtremeMode) {
			$getExistIp = @mysql_fetch_array(mysql_query('select uid from gc_ip_'.$id.' where ip = \''.$ip.'\' order by uid desc limit 1'));
			if($getExistIp['uid']) @mysql_query('update gc_ip_'.$id.' set count = count + 1'.$upQ.' where uid = '.$getExistIp['uid']);
			else @mysql_query("insert into gc_ip_{$id} set uid = '', ip = '$ip', count = 1, signdate = '".time()."'");
		} else @mysql_query("insert into gc_ip_{$id} set uid = '', ip = '$ip', count = 1, signdate = '".time()."'");
	}
	// gc_reference_$id 에 리퍼러 로그 등록 (+ 리퍼러 도메인 등록)
	function addReference($id, $ref='') {
		$tmp = @explode('/', str_replace('www.', '', $ref));
		if(!$this->isExtremeMode) {
			$getExistUrl = @mysql_fetch_array(mysql_query('select uid from gc_reference_'.$id.' where url = \''.$ref.'\' order by uid desc limit 1000'));
			if($getExistUrl['uid']) @mysql_query('update gc_reference_'.$id.' set count = count + 1 where uid = '.$getExistUrl['uid']);
			else @mysql_query('insert into gc_reference_'.$id.' set uid = \'\', url = \''.$ref.'\', count = 1');
			$getExistDomain = @mysql_fetch_array(mysql_query('select uid from gc_reference_domain where url = \''.$tmp[2].'\' and id = \''.$id.'\''));
			if($getExistDomain['uid']) @mysql_query('update gc_reference_domain set count = count + 1 where uid = '.$getExistDomain['uid']);
			else @mysql_query('insert into gc_reference_domain set uid = \'\', id = \''.$id.'\', url = \''.$tmp[2].'\', count = 1');
		} else {
			@mysql_query('insert into gc_reference_'.$id.' set uid = \'\', url = \''.$ref.'\', count = 1');
			@mysql_query('insert into gc_reference_domain set uid = \'\', id = \''.$id.'\', url = \''.$tmp[2].'\', count = 1');
		}
	}
	// 방문객 접속정보를 확인하여 DB 추가 혹은 갱신 (이 곳은 중복 여부가 필수이므로 Extreme Mode 불가)
	function inputData($ip, $id, $ref='') {
		$getLastLogIP = @mysql_fetch_array(mysql_query('select signdate from gc_ip_'.$id.' where ip = \''.$ip.'\' order by uid desc limit 1'));
		if(!$getLastLogIP['signdate']) $getLastLogIP['signdate'] = 0;
		$barTime = mktime(0, 0, 0, $this->month, $this->day, $this->year);
		if($getLastLogIP['signdate'] < $barTime) {
			$getTodayRow = @mysql_fetch_array(mysql_query('select uid from gc_visit_'.$id.' where year = '.$this->year.' and month = '.$this->month.' and day = '.$this->day.' order by uid desc limit 1'));
			if(!$getTodayRow['uid']) {
				$insertNo = @mysql_query("insert into gc_visit_{$id} set uid = '', year = '$this->year', month = '$this->month', day = '$this->day', hour = '$this->hour', uniq_view = 1, page_view = 1");
				@mysql_query("update gc_id set total_uniq_view = total_uniq_view + 1, total_page_view = total_page_view + 1 where name = '$id'");
			} else {
				$getTimeRow = @mysql_fetch_array(mysql_query('select uid from gc_visit_'.$id.' where year = '.$this->year.' and month = '.$this->month.' and day = '.$this->day.' and hour = '.$this->hour));
				if($getTimeRow['uid']) @mysql_query('update gc_visit_'.$id.' set uniq_view = uniq_view + 1, page_view = page_view + 1 where uid = '.$getTimeRow['uid']);
				else @mysql_query("insert into gc_visit_{$id} set uid = '', year = '$this->year', month = '$this->month', day = '$this->day', hour = '$this->hour', uniq_view = 1, page_view = 1");
				@mysql_query('update gc_id set total_uniq_view = total_uniq_view + 1, total_page_view = total_page_view + 1 where name = \''.$id.'\'');
			}
			$getYear = @mysql_fetch_array(mysql_query('select year from gc_year where id = \''.$id.'\' order by year desc limit 1'));
			if($getYear['year'] < $this->year) @mysql_query("insert into gc_year set id = '$id', year = '$this->year', total_uniq_year = 0, total_page_year = 0");
			@mysql_query("update gc_year set total_uniq_year = total_uniq_year + 1, total_page_year = total_page_year + 1 where id = '$id' and year = '$this->year'");
			$this->addIp($ip, $id, true);
			$this->addReference($id, $ref);
		} else {
			@mysql_query("update gc_visit_{$id} set page_view = page_view + 1 where year = '$this->year' and month = '$this->month' and day = '$this->day' and hour = '$this->hour'");
			@mysql_query("update gc_id set total_page_view = total_page_view + 1 where name = '$id'");
			@mysql_query("update gc_year set total_page_year = total_page_year + 1 where name = '$id' and year = '$this->year'");
			$this->addIp($ip, $id, false);
		}
	}
}