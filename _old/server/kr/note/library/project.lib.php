<?php
/**
 * @update 2007-11-30
 * @comment 프로젝트에 사용될 메소드들 정의
 */
class Project {
	var $divide;
	/**
	 * @param none
	 * @comment 클래스 초기화시 DB연결 / 로그인 여부 확인 */
	 function Project($prefix='') {
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
	 * @param int no
	 * @comment 현재 멤버의 레벨 반환 */
	 function getLevel($no=0) {
		 if(!$no) return;
		 $result = @mysql_fetch_array(mysql_query('select level from '.$this->divide.'users where uid = '.$no));
		 return $result[0];
	 }
	/**
	 * @param int no
	 * @comment 현재 멤버의 이름, 아이디 반환 */
	 function getInfo($no=0) {
		 if(!$no) return;
		 $result = @mysql_fetch_array(mysql_query('select id, nickname from '.$this->divide.'users where uid = '.$no));
		 return $result;
	 }
	/**
	 * @param int uid
	 * @comment 프로젝트 진행률 계산 */
	 function getPercent($uid) {
		 $getTickets = @mysql_fetch_array(mysql_query('select ticket_done, ticket_yet from '.$this->divide.'projects where uid = '.$uid));
		 $sum = $getTickets[0] + $getTickets[1];
		 if(!$sum) $sum = 1;
		 return floor(($getTickets[0] / $sum) * 100);
	 }
}
?>
