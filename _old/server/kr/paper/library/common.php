<?php
/*
	GR Paper 공통 라이브러리
	작성자: 박희근 (http://sirini.net)
	수정일: 2008-12-7
	내  용: Paper 에서 자주 사용되는 메소드들 정의.
	주  의: 이 클래스는 페이지 내에서 제일 먼저 불러야 함.
*/

class GRCOMMON {
	public $prefix = '';
	public $db = null;
	public $dirName = '';
	
	function __construct($path='./', $type='text/html') {
		@session_save_path($path.'/session');
		@session_start();
		if($type != 'none') @header('Content-Type: '.$type.'; charset=utf-8');
		try {
			include $path.'/db.info.php';
			$this->prefix = $dbinfo['prefix'];
			$this->db = $db;
			$this->dirName = $config['dirName'];
		} catch(Exception $e) { die('GR Paper 가 DB에 접속하지 못했습니다. (DB connect failed.)'); }
	}
	
	function move($src) {
		die('<script type="text/javascript"> location.href=\''.$src.'\'; </script>');
	}
	
	function alert($msg, $src='') {
		die('<script type="text/javascript"> alert(\''.$msg.'\'); '.(($src)?'location.href=\''.$src.'\';':'history.back();').' </script>');
	}
	
	function get($opt) {
		$result = $this->db->query('select var from '.$this->prefix.'skin where opt = \''.$opt.'\'')->fetch_array();
		return stripslashes($result['var']);
	}
	
	function set($opt, $var) {
		$isExist = $this->db->query('select uid from '.$this->prefix.'skin where opt = \''.$opt.'\'')->fetch_array();
		if($isExist['uid']) $this->db->query('update '.$this->prefix.'skin set var = \''.addslashes($var).'\' where opt = \''.$opt.'\' limit 1');
		else $this->db->query('insert into '.$this->prefix.'skin set opt = \''.$opt.'\', var = \''.addslashes($var).'\'');
	}
	
	function isAdmin() {
		if($_SESSION['login'] == 1) return true;
		else return false;
	}
	
	function isLogin() {
		if($_SESSION['login']) return true;
		else return false;
	}

	function totalSession() {
		$n=0;
		$op = opendir('../session');
		while($r = readdir($op)) $n++;
		closedir($op);
		$n -= 2;
		return $n;
	}

	function totalRowNum($t='feed_list') {
		return end($this->db->query('select count(*) from '.$this->prefix.$t)->fetch_array());
	}
}
