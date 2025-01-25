<?php
// PHP설정값, 헤더, 세션 설정
$_GET['preRoute'] = $_POST['preRoute'] = $_REQUEST['preRoute'] = false;
@header('Pragma: no-cache');
@header('Content-Type: text/html; charset=utf-8');
@session_save_path($preRoute.'session');
@session_start();
define('__GRBOARD__', true);

// GR보드 공통 클래스
class COMMON {
	var $grTime;

	// 프로그램 정보
	function grInfo($str='') {
		return 'v1.8.6.3 R2 Stable Edition (UTF-8)';
	}

	// DB 접속 함수
	function dbConn() {
		global $preRoute;
		include $preRoute.'db_info.php';
		$GLOBALS['dbFIX'] = $dbFIX;
		$this->grTime = $timeDiff;
	}

	// 에러 처리 함수
	function error($errorMsg, $saveError=0, $goRoute=0) {
		global $id, $dbFIX;
		$errorMsg = str_replace(array('script', '/script'), '', $errorMsg);
		$errorMsgPage = urlencode($errorMsg);
		$errorMsgDb = addslashes($errorMsg);
		$output = '<script>';
		if($goRoute) {
			$errorMsg = str_replace('<br />', '\\n', $errorMsg);
			if($goRoute == 'HISTORY_BACK') $output .= 'alert(\''.$errorMsg.'\'); history.back();';
			elseif($goRoute == 'CLOSE') $output .= 'alert(\''.$errorMsg.'\'); window.close();';
			else $output .= 'alert(\''.$errorMsg.'\'); location.href=\''.$goRoute.'\';';
		} else {
			$prevPage = urlencode($_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']);
			$output .= "location.href='error.php?id={$id}&error={$errorMsgPage}&prevPage={$prevPage}';";
		}
		$output .= '</script><a href="'.$src.'">[click to move]</a>';
		if($saveError) {
			$this->dbConn();
			$errorTime = $this->grTime();
			$errorMsgDb = '<span class="smallEng">['.$_SERVER['REMOTE_ADDR'].']</span> '.$errorMsgDb;
			@mysql_query("insert into {$dbFIX}error_save set no = '', error_msg = '$errorMsgDb', msg_time = '$errorTime'");
		}
		die($output);
	}

	// 페이징 처리 함수 (그누보드 4 참고 : sir.co.kr)
	function getPaging($writePages, $currentPage, $totalPage, $goUrl, $division=0, $originDivision=0, $searchOption='', $searchText='', $category='', $focusID='') {
		$str = '';
		if($searchOption && $searchText) $addSearchQue = '&amp;searchOption='.$searchOption.'&amp;searchText='.urlencode($searchText);
		if($category) $addSearchQue .= '&amp;clickCategory='.urlencode($category);
		$addSearchQue .= $focusID;
		if($originDivision > $division) $str .= '<a href="'.$goUrl.'1&amp;division='.($division + 1).$addSearchQue.'" class="page">◀ 최신 범위</a> &nbsp;'; 
		if($currentPage > 1) $str .= '<a href="'.$goUrl.'1'.$addSearchQue.'" class="page">처음</a>';
		$startPage = (((int)(($currentPage - 1 ) / $writePages )) * $writePages) + 1;
		$endPage = $startPage + $writePages - 1;
		if($endPage >= $totalPage) $endPage = $totalPage;
		if($currentPage - 1 > 0) $str .= ' &nbsp;<a href="'.$goUrl.($currentPage - 1).'&amp;division='.$division.$addSearchQue.'" class="page">이전</a>';
		if($totalPage > 1) 	{
			for($i=$startPage;$i<=$endPage;$i++) {
				if($currentPage != $i) $str .= ' &nbsp;<a href="'.$goUrl.$i.'&amp;division='.$division.$addSearchQue.'" class="page">'.$i.'</a>';
				else $str .= ' &nbsp;<strong>'.$i.'</strong> ';
			}
		}
		if($currentPage + 1 <= $totalPage) $str .= ' &nbsp;<a href="'.$goUrl.($currentPage + 1).'&amp;division='.$division.$addSearchQue.'"  class="page">다음</a>';
		if ($currentPage < $totalPage)	 $str .= ' &nbsp;<a href="'.$goUrl.$totalPage.'&amp;division='.$division.$addSearchQue.'"  class="page">마지막</a>';		
		if($division) $str .= ' &nbsp;<a href="'.$goUrl.'1&amp;division='.($division - 1).$addSearchQue.'" class="page">과거 범위 ▶</a>';
		return $str;
	}

  // 문자열 자르기
	// 2010-01-28 Coder PiconZ, Editor 이동규
	function cutString($str, $size=0) {
    if(!$size) return $str;
    $mb_cutSize = 0;
    $j = $size;
    for($i=0;($j > 0) && ($i <= mb_strlen($str, "UTF-8"));$i++){
        if( ord( mb_substr($str, $i, 1, "UTF-8") ) > 127) {
            $j -= 1; $mb_cutSize += 1;
        }
        else {
            $j -= 0.5; $mb_cutSize += 1;
        }
    }
    if($j < 0 ) $mb_cutSize -= 1;
    $result = substr($str, 0, $mb_cutSize);
    preg_match('/^([\x00-\x7e]|.{3})*/', $result, $string);
    return $string[0];
}

// 문자열 자르기
//  예기치 못한 문제가 발생할시, 위의 코드를 주석처리하거나 삭제하시고,
//	이 코드를 주석해제하여 적용해주세요.
//	function cutString($str, $size=0) {
//		if(!$size) return $str;
//		if(function_exists('mb_strcut')) return mb_strcut($str, 0, $size, 'utf-8');
//		$result = substr($str, 0, $size);
//		preg_match('/^([\\x00-\\x7e]|.{3})*/', $result, $string);
//		return $string[0];
//	}


	// 페이지 이동 함수
	function move($src) {
		die('<script type="text/javascript"> location.href=\''.$src.'\'; </script>');
	}

	// GR보드 기준시간
	function grTime() {
		return (time()+$this->grTime);
	}
}
?>