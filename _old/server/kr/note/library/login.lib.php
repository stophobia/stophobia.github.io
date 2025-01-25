<?php
/**
 * @update 2008-11-21
 * @comment 로그인 시 처리할 메소드들 정의
 */
class Login {
	var $divide;
	/**
	 * @param none
	 * @comment 클래스 초기화시 DB연결 / 로그인 여부 확인 */
	 function Login($prefix='') {
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
	 * @param String id, password
	 * @comment 아이디와 비밀번호 체크, 맞다면 세션 부여 */
	 function idPasswordCheck($id, $password) {
		 $md5Password = md5($password);
		 $md5Date = md5(date('Ymd', time()));
		 $result = md5($md5Date.$md5Password);
		 $check = @mysql_fetch_array(mysql_query('select uid from '.$this->divide.'users where id = \''.$id.'\' and password = \''.$md5Password.'\' limit 1'));
		 if($check['uid']) {
			 $_SESSION['userNo'] = $check['uid'];
			 return $result;
		 } else return false;
	 }
	/**
	 * @param none
	 * @comment 세션값을 참조하여 1이면 관리자, 아니면 사용자 */
	 function isAdmin() {
		 if($_SESSION['userNo'] == 1) return 1;
		 else return 0;
	 }
}
?>
