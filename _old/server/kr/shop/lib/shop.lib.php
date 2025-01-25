<?php
/**
 * 자주 쓰이는 GR Shop 용 메소드 정리
 *  - GR Core 의 Common 클래스 선언 이후 사용가능.
 */
class Shop {
	public $core, $prefix, $version = '0.93 beta';

	function __construct($core, $dbFIX) {
		$this->core = $core;
		$this->prefix = $dbFIX;
	}

	function get($key, $default='basic') {
		$result = $this->core->getData('select var from '.$this->prefix.'settings where opt = \''.$key.'\' limit 1');
		if($result['var']) return $result['var']; else return $default;
	}

	function banner() {
		$banner = array();
		$banner[] = '';
		$getBanner = $this->core->query('select * from '.$this->prefix.'banners');
		while($ban = $this->core->fetch($getBanner)) {
			$banner[] = $ban;
		}
		return $banner;
	}

	function category($step=1, $catUid='') {
		$cat = array();
		$cat[] = '';
		$cnt = 0;
		if($step == 1) $getCategory = $this->core->query('select * from '.$this->prefix.'categories order by list_order asc');
		else $getCategory = $this->core->query('select id, title from '.$this->prefix.'bbs where category_uid = '.$catUid);
		while($c = $this->core->fetch($getCategory)) {
			$c['title'] = stripslashes($c['title']);
			$cat[] = $c;
			$cnt++;
		}
		$cat[0] = $cnt+1;
		return $cat;
	}

	function set($key, $value='') {
		if(!$value) return false;
		$isKey = $this->core->getData('select uid from '.$this->prefix.'settings where opt = \''.$key.'\' limit 1');
		if($isKey['uid']) $this->core->query('update '.$this->prefix.'settings set var = \''.addslashes($value).'\' where uid = '.$isKey['uid']);
		else $this->core->query('insert into '.$this->prefix.'settings set uid = \'\', opt = \''.$key.'\', var = \''.addslashes($value).'\'');
	}

	function isAdmin() {
		if($_SESSION['no'] == 1) return true; else return false;
	}

	function isLogin() {
		if($_SESSION['no']) return true; else return false;
	}

	function loginCheck($id, $password, $grboard, $go) {
		include $grboard.'/core.php';
		$result = $this->core->getData('select no from '.$dbFIX."member_list where id = '$id' and password = password('$password')");
		if($result['no']) {
			$_SESSION['no'] = $result['no'];
			$this->core->move($go);
		} else $this->core->alert('아이디 혹은 비밀번호가 올바르지 않습니다.', '../login/?go=../admin/');
	}

	function checkNewMemo($grboard, $msg) {
		if(!$_SESSION['no']) return false;
		include $grboard.'/core.php';
		$isNewMemo = $this->core->getData('select is_view from '.$dbFIX.'memo_save where member_key = '.$_SESSION['no'].' order by no desc limit 1');
		if($isNewMemo['is_view'] == '0') {
			$getNotify = $this->core->getData('select var from '.$dbFIX.'layout_config where opt = \'notify_skin\' limit 1');
			echo '<div id="newMsgCheck"><a href="'.$grboard.'/view_memo.php" onclick="window.open(this.href, \'_blank\', \'width=600,height=700,menubar=no,scrollbars=yes\'); return false" title="이 곳을 클릭하여 새로온 쪽지를 확인합니다.">'.$msg.'</a></div>';
		}
	}
}
?>