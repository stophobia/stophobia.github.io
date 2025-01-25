<?php
/*
	GR Paper 로그인 페이지
	작성자: 박희근 (http://sirini.net)
	수정일: 2008-08-24
	내  용: 관리자 (혹은 멤버) 의 로그인을 받습니다.
	참  고: 사용중인 스킨(테마) 디자인에 영향을 받음
	주  의: 이미 로그인된 상태일 경우 첫화면으로 돌려보낸다.
*/

include '../library/common.php';
$c = new GRCOMMON('../');
include '../config/base.php';
if($c->isLogin()) $c->alert('이미 로그인되어 있습니다.', $config['absPath'].'/admin/');

$theme = $c->get('theme');
$browserTitle = $c->get('browserTitle');
$blogNumber = $c->get('blogNumber');
$tagNumber = $c->get('tagNumber');
$hotPostNumber = $c->get('hotPostNumber');
if($tagNumber) $getHotTag = $c->db->query('select tag, count from '.$c->prefix.'tag order by count desc limit '.$tagNumber);
$themePath = $config['absPath'].'/skin/'.$theme;
$getBlogList = $c->db->query('select * from '.$c->prefix.'feed_list order by uid desc limit '.$blogNumber);
if($hotPostNumber) {
	$getHotPost = $c->db->query('select uid, link, subject from '.$c->prefix.'feed where signdate > '.(time()-($c->get('hotPostTerm')*3600)).' order by hit desc limit '.$hotPostNumber);
}

include '../skin/'.$theme.'/head.php';
include '../skin/'.$theme.'/body.login.php';
include '../skin/'.$theme.'/foot.php';
?>
