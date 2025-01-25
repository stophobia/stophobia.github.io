<?php
/**
 * GR Core Common Class
 * 작성자: sirini ( http://sirini.net , sirini@gmail.com )
 * 작성일: 2009-08-05
 * 내   용: DB접속처리등 매우 기본적인 기능 제공
 **/

class Common {
	public $prefix, $db, $dirName, $dbinfo, $config, $version = '0.9.2.1';

	function __construct($path='..', $header='Content-Type: text/html; charset=utf-8') {
		@header($header);
		try {
			include $path.'/db.info.php';
			$this->prefix = $dbinfo['prefix'];
			$this->dirName = $config['dirName'];
			$this->dbinfo = $dbinfo;
			$this->config = $coreConfig;
			$this->db = $this->connect($dbinfo);
			if($dbinfo['setUTF8']) $this->db->query('set names utf8');
		} catch(Exception $e) { die('GR Core 가 DB에 접속하지 못했습니다. (DB connect failed.)'); }
	}

	function move($src) {
		die('<script type="text/javascript"> location.href=\''.$src.'\'; </script>');
	}
	
	function alert($msg, $src='') {
		die('<script type="text/javascript"> alert(\''.$msg.'\'); '.(($src)?'location.href=\''.$src.'\';':'history.back();').' </script>');
	}

	function fileWrite($filename, $content) {
		$fp = @fopen($filename, 'w');
		@fwrite($fp, $content);
		@fclose($fp);
	}

	function session($path) {
		@session_save_path($path);
		@session_start();
	}

	function connect($dbinfo) {
		return new mysqli($dbinfo['hostname'], $dbinfo['userid'], $dbinfo['password'], $dbinfo['dbname']);
	}

	function query($query) {
		return $this->db->query($query);
	}

	function fetch($result) {
		return $result->fetch_array();
	}

	function getData($query) {
		$result = $this->db->query($query);
		if($result) return $result->fetch_array();
		else return false;
	}

	function insertId() {
		return $this->db->insert_id;
	}
}