<?php
/**
 * GR Forum Logout Process
 * @author sirini
 * @update 2009-08-01
 * @comment GR Forum 로그아웃 처리
 * @information 로그아웃 후에는 무조건 첫화면으로 이동한다.
 */

// 코어 / 보드 연동
include '../core.php';
include '../' . $grcore . '/class/common.php';
$core = new Common('../' . $grcore);
$grboard = '../' . $core->config['grboard'];
$core->session($grboard . '/session');

// 로그인 상태인지 확인 후 멤버 로긴시간을 0으로 초기화한다.
if(!$_SESSION['no']) $core->alert('로그인 상태가 아닙니다.');
$core->query('update ' . $bbsFIX . 'member_list set lastlogin = 0 where no = ' . $_SESSION['no'] . ' limit 1');

// 세션을 삭제처리한다.
$_SESSION = array();
@session_destroy();
@setcookie('memberKey', '', time()+31536000, '/');

// 첫화면으로 이동
$core->move('../');
?>