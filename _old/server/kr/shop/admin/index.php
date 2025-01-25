<?php
// Core 설정 저장
define('__GRSHOP__', true);
include '../core.php';
$_grcore = $grcore;
$grcore = '../'.$_grcore;
include $grcore.'/class/common.php';
include '../lib/shop.lib.php';
$core = new Common($grcore);
$shop = new Shop($core, $dbFIX);
$grboard = '../'.$core->config['grboard'];
$core->session($grboard.'/session');

// 관리자가 아니면 퇴출
if(!$shop->isAdmin()) $core->alert('관리자만 접속할 수 있습니다.', '../login/?go=../admin/');

// 상단 공통부분 부르기
include 'head.php';

// 중간 메인부분 선택 부르기
$menu = $_GET['menu'];
if(!$menu || $menu < 0 || $menu > 10) $menu = 0;
switch($menu) {
	case 1: include 'category.php'; break;
	case 2: include 'register.board.php'; break;
	case 3: include 'order.php'; break;
	case 4: include 'shop.php'; break;
	case 5: include 'banner.php'; break;
	case 6: include 'status.php'; break;
	default: include 'info.php'; break;
}

// 하단 공통부분 부르기
include 'foot.php';
?>