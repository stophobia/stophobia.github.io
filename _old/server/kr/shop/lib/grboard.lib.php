<?php
/**
 * 자주 쓰이는 GR Shop 용 메소드 정리 (for GR Board)
 *  - GR Board 안에서 불려지는 코드들이므로 Core 기능은 사용불가. (GR Board v1.9 이상부터 가능)
 *  - 이 클래스는 shop.lib.php 와 다소 다르며, GR Board 에 맞게 일부 수정된 것임.
 */
class Shop {
	public $prefix, $version = '0.9 beta';

	function __construct($grshop) {
		include $grshop.'/core.php';
		$this->prefix = $dbFIX;
	}

	function get($key, $default='basic') {
		$result = @mysql_fetch_array(mysql_query('select var from '.$this->prefix.'settings where opt = \''.$key.'\' limit 1'));
		if($result['var']) return $result['var']; else return $default;
	}

	function banner() {
		$banner = array();
		$banner[] = '';
		$getBanner = @mysql_query('select * from '.$this->prefix.'banners');
		while($ban = @mysql_fetch_array($getBanner)) {
			$banner[] = $ban;
		}
		return $banner;
	}

	function category($step=1, $catUid='') {
		$cat = array();
		$cat[] = '';
		$cnt = 0;
		if($step == 1) $getCategory = @mysql_query('select * from '.$this->prefix.'categories order by list_order asc');
		else $getCategory = @mysql_query('select id, title from '.$this->prefix.'bbs where category_uid = '.$catUid);
		while($c = @mysql_fetch_array($getCategory)) {
			$c['title'] = stripslashes($c['title']);
			$cat[] = $c;
			$cnt++;
		}
		$cat[0] = $cnt+1;
		return $cat;
	}

	function getCategory($id) {
		$getUid = @mysql_fetch_array(mysql_query('select category_uid from '.$this->prefix.'bbs where id = \''.$id.'\''));
		if($getUid['category_uid']) {
			$getCategory = @mysql_fetch_array(mysql_query('select * from '.$this->prefix.'categories where uid = '.$getUid['category_uid']));
			$getCategory['name'] = stripslashes($getCategory['name']);
		} else {
			$getCategory = @mysql_fetch_array(mysql_query('select id, title from '.$this->prefix.'bbs where category_uid = 0'));
			$getCategory['name'] = stripslashes($getCategory['title']);
		}
		return $getCategory;
	}

	function bbs() {
		$bbs = array();
		$getBBS = @mysql_query('select id, title from '.$this->prefix.'bbs where category_uid = 0');
		while($b = @mysql_fetch_array($getBBS)) {
			$b['title'] = stripslashes($b['title']);
			$bbs[] = $b;
		}
		return $bbs;
	}

	function bbsInfo($id) {
		$result = @mysql_fetch_array(mysql_query('select category_uid, title, sub_title, info from '.$this->prefix.'bbs where id = \''.$id.'\' limit 1'));
		$cat = @mysql_fetch_array(mysql_query('select name from '.$this->prefix.'categories where uid = '.$result['category_uid']));
		if($cat['name']) $result['category'] = stripslashes($cat['name']); else $result['category'] = '';
		$result['title'] = stripslashes($result['title']);
		$result['sub_title'] = stripslashes($result['sub_title']);
		$result['info'] = stripslashes($result['info']);
		return $result;
	}

	function isAdmin() {
		if($_SESSION['no'] == 1) return true; else return false;
	}

	function isLogin() {
		if($_SESSION['no']) return true; else return false;
	}
}
?>