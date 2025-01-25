<?php
// Core 설정 저장
define('__GRSHOP__', true);
include '../core.php';
$grcore = '../'.$grcore;
include $grcore.'/class/common.php';
include '../lib/shop.lib.php';
$core = new Common($grcore);
$shop = new Shop($core, $dbFIX);

// GR Board 연동 설정
$grboard = '../'.$core->config['grboard'];
include $grboard.'/include.php';
if(!$shop->isLogin()) $core->alert('로그인을 먼저 해 주세요', '../login/?go=../mypage/');
include $grboard.'/core.php';
$grcore = '../'.$grcore;
$grboardPrefix = $dbFIX;

// 부가정보 수정처리
if($_POST['saveNow']) {
	@extract($_POST);
	$core->query('update '.$shop->prefix."members set mail_code = '{$mail_code}', address1 = '{$address1}', address2 = '{$address2}', ".
		"home_phone = '{$home_phone}', mobile_phone = '{$mobile_phone}', birthday_year = '{$birthday_year}', birthday_month = '{$birthday_month}', ".
		"birthday_day = '{$birthday_day}', is_married = '{$is_married}' where member_key = ".$_SESSION['no']);
	$core->alert('부가정보를 수정하였습니다.', '../mypage/');
}

// 레이아웃 설정 가져오기
$_layout = $shop->get('layout_skin');
$layout = '../layout/'.$_layout;

// 마이페이지 스킨 설정 가져오기
$_mypage = $shop->get('mypage_skin');
$mypage = 'skin/'.$_mypage;

// 마이페이지 목록 데이터 세팅
$myinfo = $core->getData('select * from '.$grboardPrefix.'member_list where no = '.$_SESSION['no']);
$addinfo = $core->getData('select * from '.$shop->prefix.'members where member_key = '.$_SESSION['no']);

// 레이아웃 상단 부르기
$dir = '..';
$design['head'] = '<link rel="stylesheet" href="'.$mypage.'/style.css" type="text/css" title="style" />'."\n";
$design['head'] .= '<script type="text/javascript" src="'.$mypage.'/mypage.js"></script>'."\n";
include $layout.'/config.php';
include $layout.'/head.php';

// 마이페이지 스킨 부르기
include $mypage.'/mypage.php';

// 레이아웃 하단 부르기
include $layout.'/foot.php';
?>