<?php
class Common {
	var $_hostName, $_userId, $_password, $_dbName, $isExtremeMode;

	// 클래스 초기화시 처리
	function Common() {
		if(is_dir('../session/')) {
			@session_save_path('../session/');
			@session_start();
		}
		@header('Content-Type: text/html; charset=utf-8');
		@$this->dbConn();
	}
	// DB접속
	function dbConn($path='') {
		include $path.'../db_info.php';
		$this->_hostName = $hostName;
		$this->_userId = $userId;
		$this->_password = $password;
		$this->_dbName = $dbName;
		$this->isExtremeMode = $useExtremeMode;
	}
	// 관리자인지 아닌지 체크
	function isAdmin() {
		if($_SESSION['no']) return true;
		return false;
	}
	// 에러 처리 함수
	function error($errorMsg, $goRoute='HISTORY_BACK')
	{
		global $id;
		$errorMsgPage = urlencode($errorMsg);
		$errorMsgDb = addslashes($errorMsg);
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'.
		'<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">'.
		'<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>알림</title>'.
		'<script type="text/javascript">';	
		if($goRoute == 'CLOSE') echo 'alert(\''.$errorMsg.'\'); window.close();';
		elseif($goRoute == 'HISTORY_BACK') echo 'alert(\''.$errorMsg.'\'); history.back();';
		else echo 'alert(\''.$errorMsg.'\'); '.$goRoute;
		echo '</script></head><body></body></html>';
		exit();
	}
	// 퍼미션 체크 함수
	function checkPerm($directory)
	{
		if(PHP_OS == 'WINNT') return 707;
		$perm = fileperms($directory);
		$perm = sprintf('%o', $perm);
		$perm = substr($perm, -3);
		return $perm;
	}
	// 페이징 처리 함수 (그누보드 4 참고 : sir.co.kr)
	function getPaging($writePages, $currentPage, $totalPage, $goUrl, $division=0, $originDivision=0)
	{
		$str = '';
		if($originDivision > $division) $str .= '<a href="'.$goUrl.'1&amp;division='.($division + 1).'" title="앞쪽 범주를 계속 검색합니다" class="page">◀ Continue</a> &nbsp;'; 
		if($currentPage > 1) $str .= '<a href="'.$goUrl.'1'.'" title="처음 페이지로 이동합니다" class="page">First</a>';
		$startPage = (((int)(($currentPage - 1 ) / $writePages )) * $writePages) + 1;
		$endPage = $startPage + $writePages - 1;
		if($endPage >= $totalPage) $endPage = $totalPage;
		if($startPage > 1) $str .= ' &nbsp;<a href="'.$goUrl.($startPage-1).'&amp;division='.$division.'" title="이전 페이지로 이동합니다" class="page">prev</a>';
		if($totalPage > 1)
		{
			for($i=$startPage;$i<=$endPage;$i++)
			{
				if($currentPage != $i) $str .= ' &nbsp;<a href="'.$goUrl.$i.'&amp;division='.$division.'" class="page">'.$i.'</a>';
				else $str .= ' &nbsp;<strong>'.$i.'</strong> ';
			}
		}
		if($totalPage > $endPage) $str .= ' &nbsp;<a href="'.$goUrl.($endPage+1).'&amp;division='.$division.'" title="다음 페이지로 넘어갑니다" class="page">next</a>';
		if ($currentPage < $totalPage)	 $str .= ' &nbsp;<a href="'.$goUrl.$totalPage.'&amp;division='.$division.'" title="맨 끝 페이지로 이동합니다" class="page">Last</a>';		
		if($division) $str .= ' &nbsp;<a href="'.$goUrl.'1&amp;division='.($division - 1).'" title="뒤쪽 범주를 계속 검색합니다" class="page">Continue ▶</a>';
		$str .= '';
		return $str;
	}
	// 페이지 이동 함수
	function move($src)
	{
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'.
		'<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">'.
		'<head><title>이동</title><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'.
		'<script type="text/javascript"> location.href=\''.$src.'\'; </script>'.
		'</head><body><strong>※ 자동으로 페이지를 이동하지 못했습니다.</strong><br />자바스크립트를 사용할 수 없는 환경 같습니다.<br />'.
		'직접 이동하실 수 있습니다. <a href="'.$src.'">[여기를 눌러주세요]</a></body></html>';
		exit();
	}
}