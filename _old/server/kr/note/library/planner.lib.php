<?php
/**
 * @update 2008-03-08
 * @comment e플래너에 사용될 메소드들 정의
 */
class Planner {
	var $divide, $y, $m, $d, $w, $totalDay, $lastWeek, $firstSunday, $position;
	/**
	 * @param none
	 * @comment 클래스 초기화시 DB연결 / 로그인 여부 확인 */
	 function Planner($prefix='') {
		 include $prefix.'db.info.php';
		 $this->divide = $divide;
	 }
	/**
	 * @param String msg, src
	 * @comment 에러 발생시 쓰는 알림창 */
	 function alert($msg, $src=false) {
		 $result = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'.
		 '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">'.
		 '<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>알림</title>'.
		 '<script type="text/javascript">//<![CDATA['."\nalert('".str_replace('<br />', '\n', $msg)."');";
		 if($src) $result .= 'location.href=\''.$src.'\';'; else $result .= 'history.back();';
		 $result .= '//]]></script></head><body>'.$msg.'</body></html>';
		 echo $result;
		 exit();
	 }
	/**
	 * @param none
	 * @comment e플래너에서 보여줄 달력 전체적인 구조 */
	 function getCalendar($time=0) {
		 if(!$time) $time = time();
		 $result = '';
		 $this->totalDay = date('t', $time);
		 $this->y = date('Y', $time);
		 $this->m = date('m', $time);
		 $this->d = date('d');
		 $this->w = date('w', mktime(0, 0, 0, $this->m, 1, $this->y));
		 $this->lastWeek = date('w', mktime(0, 0, 0, $this->m, $this->totalDay, $this->y));
		 $result .= '<table rules="none" summary="GR Note Calendar" cellpadding="0" cellspacing="0" border="0"><caption></caption><thead><tr><th class="sun">일</th><th class="n">월</th><th class="n">화</th><th class="n">수</th><th class="n">목</th><th class="n">금</th><th class="n sat">토</th></tr></thead><tbody><tr>';
		 for($a=$this->w; $a>0; $a--) $result .= '<td class="headSpace">&nbsp;</td>';
		 for($i=1; $i<($this->totalDay+1); $i++) {
			 $term = $this->w + $i;
			 $memo = $this->getDailyWork($this->y, $this->m, (($i<10)?'0'.$i:$i), $this->h);
			 $memorial = $this->getMemorial($this->m, (($i<10)?'0'.$i:$i));
			 $number = '<div class="number"><span><a href="#" onclick="Planner.memoModify('.$memorial['uid'].');">'.$memorial['subject'].'</a> | &nbsp;</span><a href="#" title="일정 추가하기" onclick="Planner.directAdd(\''.$this->y.'\', \''.$this->m.'\', \''.(($i<10)?'0'.$i:$i).'\');">'.$i.'</a></div>';
			 if($term % 7 == 0) $result .= '<td class="normal sat'.(($i == $this->d)?' today':'').'">'.$number.'<div class="memo">'.$memo.'</div></td></tr><tr>';
			 elseif(date('w', mktime(0, 0, 0, $this->m, $i, $this->y)) == 0) $result .= '<td class="normal sun'.(($i == $this->d)?' today':'').'">'.$number.'<div class="memo">'.$memo.'</div></td>';
			 else $result .= '<td class="normal'.(($i == $this->d)?' today':'').'">'.$number.'<div class="memo">'.$memo.'</div></td>';
		 }
		 for($j=(6-$this->lastWeek); $j>0; $j--) $result .= '<td class="footSpace">&nbsp;</td>';
		 $result .= '</tr></tbody></table>';
		 return $result;
	 }
	/**
	 * @param int y, m, d
	 * @comment 일자별 해야할 목록들 반환 */
	 function getDailyWork($y, $m, $d, $h) {
		 global $grNote;
		 $result = '';
		 $timeForStart = mktime(23, 59, 59, $m, $d, $y);
		 $timeForEnd = mktime(0, 0, 0, $m, $d, $y);
		 $givenWork = $y.$m.$d;
		 $startPosition = 1;
		 $lastGap = 0;
		 $totalWork = @mysql_fetch_array(mysql_query('select count(*) from '.$this->divide.'planners where start_work <= '.$timeForStart.' and end_work >= '.$timeForEnd.' and member_key = '.$_SESSION['userNo']));
		 if($grNote['planner']['open'] == 2) $addQ = ' and member_key = '.$_SESSION['userNo']; else $addQ = '';
		 $work = @mysql_query("select uid, start_work, level, subject from {$this->divide}planners where start_work <= $timeForStart and end_work >= $timeForEnd".$addQ.' order by start_work asc');
		 while($list = @mysql_fetch_array($work)) {
			 $startWork = date('Ymd', $list['start_work']);
			 if($givenWork == $startWork || !date('w', $timeForStart)) {
				 $this->position[$list['uid']] = $lastGap + 1;
				 $result .= '<div class="work lv'.$list['level'].'" onclick="Planner.modify('.$list['uid'].');" title="'.addslashes($list['subject']).' [수정하기]">'.stripslashes($list['subject']).'</div>';
			 }
			 else {
				 if($this->position[$list['uid']] > $lastGap) $positionGap = $this->position[$list['uid']] - $lastGap;
				 else $positionGap = $lastGap - $this->position[$list['uid']];
				 $result .= '<div class="work lv'.$list['level'].' gap'.$positionGap.'" onclick="Planner.modify('.$list['uid'].');" title="'.addslashes($list['subject']).' [수정하기]">&nbsp;</div>';
			 }
			 $lastGap = $this->position[$list['uid']];
			 $startPosition++;
		 }
		 $result .= '<span class="more" title="총 '.$totalWork[0].'개의 일정이 있습니다. (클릭=세부일정보기)" onclick="Planner.getDetail(\''.$y.'\', \''.$m.'\', \''.$d.'\');">(total <strong>'.$totalWork[0].'</strong>)</span>';
		 return $result;
	 }
	/**
	 * @param int y, m, d
	 * @comment 일자별 기념일 반환 */
	 function getMemorial($m, $d) {
		 $startDay = mktime(0, 0, 0, $m, $d, 2000);
		 $endDay = mktime(23, 59, 59, $m, $d, 2000);
		 $result = @mysql_fetch_array(mysql_query('select uid, subject from '.$this->divide.'memorials where day > '.$startDay.' and day < '.$endDay.' and member_key = '.$_SESSION['userNo'].' order by uid asc limit 1'));
		 return $result;
	 }
}
?>
