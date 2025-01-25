<?php
// 페이지 환경 초기화
define('__GRSHOP__', true);
include 'core.php';
include $grcore.'/class/common.php';
include 'lib/shop.lib.php';
$core = new Common($grcore);
$shop = new Shop($core, $dbFIX);
$grboard = $core->config['grboard'];
$grshop = $core->config['grshop'];
$grcounter = $core->config['grcounter'];

// GR카운터 연동
if($grcounter && $grid) { $grcount = $grcounter.'/'; include $grcount.'grcounter.php'; }

// 레이아웃 설정 가져오기
$_layout = $shop->get('layout_skin');
$layout = 'layout/'.$_layout;

// GR보드 연동시작
include $grboard.'/include.php';

// 레이아웃 부르기
$dir = '.';
include $layout.'/config.php';
include $layout.'/head.php';
include $layout.'/main.php';
include $layout.'/foot.php';
?>