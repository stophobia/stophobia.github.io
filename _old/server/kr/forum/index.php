<?php
/**
 * GR Forum Index Page
 * @author sirini
 * @update 2009-08-01
 * @comment GR Forum 첫화면
 * @information 관리화면에서 지정한 스킨을 이 곳에서 include 한다.
 */

// 코어 / 보드 / 포럼 / 카운터 연동
include 'core.php';
include $grcore . '/class/common.php';
include 'class/grforum.lib.php';
$core = new Common($grcore);
$grboard = $core->config['grboard'];
$forum = new Forum($core, $dbFIX, $bbsFIX, $grboard);
$core->session($grboard . '/session');
define('__GRFORUM__', true);
if($grid) { $grcount = $core->config['grcounter'].'/'; include $grcount.'grcounter.php'; }

// 설정값 저장 / 스킨 호출
$parent = ($_GET['parent']) ? $_GET['parent'] : 0;
$action = ($_GET['action']) ? $_GET['action'] : 'index';
$setting = $forum->getView();
$skin = 'skin/' . $setting['layout_skin'];
include $skin . '/index.php';

// 로그인 상태면 lastlogin 시간 업데이트
if($_SESSION['no']) $core->query('update ' . $bbsFIX . 'member_list set lastlogin = ' . time() . ' where no = ' . $_SESSION['no']);
?>