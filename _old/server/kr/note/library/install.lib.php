<?php
/**
 * @update 2008-11-21
 * @comment GR Note 설치시 필요한 메소드들 정의
 */
class Install {
	var $divide; // 테이블 구분자, 기본 gn_
	/**
	 * @param none
	 * @comment db.info.php 파일이 있을 경우 클래스 초기화와 동시에 DB접속 */
	 function Install($prefix='') {
			@include $prefix.'db.info.php';
			$this->divide = $divide;
	 }
	/**
	 * @param none
	 * @comment 이미 설치되어 있는지 여부 확인함 */
	 function isAlreadyInstalled() {
		if(file_exists('../db.info.php')) die('<body>GR Note 는 이미 설치되어 있습니다.</body></html>');
	 }
	/**
	 * @param none
	 * @comment 라이센스 내용 읽어오는 부분 처리하기. */
	function readLicense() {
		$buffer = @file_get_contents('license.txt');
		return $buffer;
	}
	/**
	 * @param String hostName, userId, password, dbName, divide
	 * @comment DB접속 정보를 생성하는 부분. GR위키용 캐쉬 디렉토리도 같이 생성함 */
	 function makeDBInfo($hostName, $userId, $password, $dbName, $divide) {
		$connString = '<?php'."\n"
			.'$hostName=\''.$hostName.'\';'."\n"
			.'$userId=\''.$userId.'\';'."\n"
			.'$password=\''.$password.'\';'."\n"
			.'$dbName=\''.$dbName.'\';'."\n"
			.'$divide=\''.$divide.'\';'."\n"
			.'@mysql_connect($hostName, $userId, $password);'."\n"
			.'@mysql_select_db($dbName);'."\n"
			.'//@mysql_query(\'set names utf8\');'." # 한글이 깨져나올 때 앞의 // 제거 후 저장 → 서버에 덮어씌우기\n"
			.'@session_save_path($prefix.\'session/\');'."\n"
			.'@session_start();'."\n"
			.'?>';
		$f = @fopen('../db.info.php', 'w');
		@fwrite($f, $connString);
		@fclose($f);
		@chmod('../db.info.php', 0604);
		@mkdir('../cache/');
		@chmod('../cache/', 0707);
	 }
	/**
	 * @param String divide
	 * @comment GR Note가 사용할 테이블들 생성 */
	 function makeDBTables($divide='gn_') {
		 include '../install/db.make.query.php';
		 for($i=0; $i<count($query); $i++) {
			 @mysql_query($query[$i]);
		 }
	 }
	/**
	 * @param String id, password, nickname, email, homepage, selfInfo
	 * @comment GR Note를 관리할 관리자 등록 */
	 function createAdmin($id, $password, $nickname, $email='', $homepage='', $selfInfo='') {
		 $sql = "insert into ".$this->divide."users set uid = '', id = '$id', password = '".md5($password)."', nickname = '$nickname', ".
			"email = '$email', homepage = '$homepage', make_time = ".time().", level = 99, point = 0, self_info = '$selfInfo'";
		 @mysql_query($sql);
	 }
}
?>