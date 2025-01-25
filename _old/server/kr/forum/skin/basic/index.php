<?php
if(!defined('__GRFORUM__')) exit();
$addHead = '';
$dir = '';

// 상단 공통부분 호출
include $skin . '/head.php';

// 중간 부분
switch($action) {
	case 'message': include $skin . '/message.php'; break;
	case 'view': include $skin . '/view.php'; break;
	case 'search': include $skin . '/search.php'; break;
	default: include $skin . '/main.php'; break;
}

// 하단 공통부분 호출
include $skin . '/foot.php';
?>