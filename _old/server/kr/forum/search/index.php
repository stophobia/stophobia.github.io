<?php
/**
 * GR Forum Search Page
 * @author sirini
 * @update 2009-08-05
 * @comment GR Forum 통합 검색
 * @warning 검색은 GR Board 의 통합 최근 게시물 / 댓글 Table 을 대상으로 한다.
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

// 스킨 호출
include $skin . '/search.php';
?>