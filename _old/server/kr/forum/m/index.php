<?php
// 코어 / 보드 / 포럼 연동
include '../core.php';
include '../' . $grcore . '/class/common.php';
include '../class/grforum.lib.php';
$core = new Common('../' . $grcore);
$grboard = '../' . $core->config['grboard'];
$forum = new Forum($core, $dbFIX, $bbsFIX, $grboard);
$core->session($grboard . '/session');
define('__GRFORUM__', true);

// 스킨 부르기
if($_GET['parent']) $parent = $_GET['parent']; else $parent = 0;
$theme = 'theme/iphone'; # 안정화 전까진 iphone 테마로 고정
$setting = $forum->getView();
include $theme.'/head.php';
include $theme.'/main.php';
include $theme.'/foot.php';
?>