<?php
/**
 * @update 2008-11-21
 * @comment 티켓 열람하기
 */
class View {
	var $divide;
	var $wikiWriteLevel;
	var $writeKey1;
	var $writeKey2;
	/**
	 * @param none
	 * @comment 클래스 초기화시 DB연결 / 로그인 여부 확인 */
	 function View($prefix='') {
		 include $prefix.'db.info.php';
		 include $prefix.'grnote.config.php';
		 $this->divide = $divide;
		 $this->writeKey1 = mt_rand(1, 10);
		 $this->writeKey2 = mt_rand(1, 10);
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
	 * @param int writePages, currentPage, totalPage, String goUrl
	 * @comment 페이징 메소드 */
	 function getPaging($writePages, $currentPage, $totalPage, $goUrl)
	 {
		 $str = '';
		 if($searchOption && $searchText) $addSearchQue = '&amp;searchOption='.$searchOption.'&amp;searchText='.urlencode($searchText); else $addSearchQue = '';
		 if($currentPage > 1) $str .= '<a href="'.$goUrl.'1'.$addSearchQue.'" title="처음 페이지로 이동합니다" class="page">First</a>';
		 $startPage = (((int)(($currentPage - 1 ) / $writePages )) * $writePages) + 1;
		 $endPage = $startPage + $writePages - 1;
		 if($endPage >= $totalPage) $endPage = $totalPage;
		 if($startPage > 1) $str .= ' &nbsp;<a href="'.$goUrl.($startPage-1).'&amp;division='.$division.$addSearchQue.'" title="이전 페이지로 이동합니다" class="page">prev</a>';
		 if($totalPage > 1)
		 {
			 for($i=$startPage;$i<=$endPage;$i++)
			 {
				 if($currentPage != $i) $str .= ' &nbsp;<a href="'.$goUrl.$i.'&amp;division='.$division.$addSearchQue.'" class="page">'.$i.'</a>';
				 else $str .= ' &nbsp;<strong>'.$i.'</strong> ';
			 }
		 }
		 if($totalPage > $endPage) $str .= ' &nbsp;<a href="'.$goUrl.($endPage+1).'&amp;division='.$division.$addSearchQue.'" title="다음 페이지로 넘어갑니다" class="page">next</a>';
		 if ($currentPage < $totalPage)	 $str .= ' &nbsp;<a href="'.$goUrl.$totalPage.'&amp;division='.$division.$addSearchQue.'" title="맨 끝 페이지로 이동합니다" class="page">Last</a>';		
		 $str .= '';
		 return $str;
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
	 * @comment 현재 멤버의 아이디(이름) 반환 */
	 function getInfo($no=0) {
		 if(!$no) return '<span style="color: #999">없음</span>';
		 $result = @mysql_fetch_array(mysql_query('select id, nickname from '.$this->divide.'users where uid = '.$no));
		 return $result['id'].' ('.$result['nickname'].')';
	 }
	/**
	 * @param int conditions
	 * @comment 티켓의 상태를 숫자에서 문자로 변환하여 반환 */
	 function getCondition($conditions=0) {
		 if(!$conditions) return '<span style="color: #999">미확인</span>';
		 elseif($conditions == 1) return '<span style="color: #666">확인됨</span>';
		 elseif($conditions == 2) return '<span style="color: blue">진행중</span>';
		 elseif($conditions == 3) return '<span style="color: green">완료됨</span>';
		 elseif($conditions == 4) return '<span style="color: red">취소됨</span>';
	 }
}
?>
