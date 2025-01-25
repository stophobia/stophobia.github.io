<?php
/**
 * GR Forum Login Page
 * @author sirini
 * @update 2009-08-04
 * @comment GR Forum 로그인, 실제로는 GR Board 에 로그인하는 과정임
 * @warning 데이터는 GR Board 의 것을 쓰지만 처리 과정은 여기서 독자적으로 한다.
 */

// 코어 / 보드 연동
include '../core.php';
include '../' . $grcore . '/class/common.php';
include '../class/grforum.lib.php';
$core = new Common('../' . $grcore);
$grboard = '../' . $core->config['grboard'];
$core->session($grboard . '/session');
$forum = new Forum($core, $dbFIX, $bbsFIX, $grboard);
$setting = $forum->getView();
$setting['logo_pos'] = '../' . $setting['logo_pos'];
$skin = '../skin/' . $setting['layout_skin'];
define('__GRFORUM__', true);

// 로그인 처리
if($_POST['id']) {
	
	$id = $_POST['id'];
	$password = $_POST['password'];

	if(!ini_get('magic_quotes_gpc')) {
		$id = addslashes($id);
		$password = addslashes($password);
	}

	$member = $core->getData('select no, id, group_no from '.$bbsFIX.'member_list where id = \''.$id.'\' and password = password(\''.$password.'\')');
	if(!$member['no']) $core->alert('아이디 혹은 비밀번호가 올바르지 않습니다.', './');
	else {
		$_SESSION['no'] = $member['no'];
		$_SESSION['mId'] = $member['id'];

		$_time = time();
		$core->query('update '.$bbsFIX.'member_list set lastlogin = \''.$_time.'\' where no = '.$member['no'].' limit 1');
		$core->query('insert into '.$bbsFIX.'login_log set no = \'\', member_key = '.$member['no'].', signdate = '.$_time.', ip = \''.$_SERVER['REMOTE_ADDR'].'\', ref = \''.$fromPage.'\'');

		if($member['no'] == 1) $core->move('../admin/');
		else $core->move('../');
	}
}

include $skin . '/login.php';
?>