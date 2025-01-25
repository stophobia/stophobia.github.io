<?php
// Core 설정 저장
define('__GRSHOP__', true);
include '../core.php';
$grcore = '../'.$grcore;
include $grcore.'/class/common.php';
include '../lib/shop.lib.php';
include '../lib/cart.lib.php';
$core = new Common($grcore);
$shop = new Shop($core, $dbFIX);

// GR Board 연동 설정
$grboard = '../'.$core->config['grboard'];
include $grboard.'/include.php';
if(!$shop->isLogin()) $core->alert('로그인을 먼저 해 주세요', '../login/?go=../cart/');
$cartClass = new Cart($core, $dbFIX, $grboard);

// 장바구니의 특정 상품 삭제시
if($_GET['deleteTarget']) {
	$isMine = $core->getData('select member_key from '.$shop->prefix.'carts where uid = '.$_GET['deleteTarget']);
	if($isMine['member_key'] == $_SESSION['no']) {
		$core->query('delete from '.$shop->prefix.'carts where uid = '.$_GET['deleteTarget']);
		$core->alert('선택하신 상품을 장바구니에서 삭제하였습니다.', './');
	} else $core->alert('고객님께서 담아두신 것만 제거하실 수 있습니다.', './');
}

// 레이아웃 설정 가져오기
$_layout = $shop->get('layout_skin');
$layout = '../layout/'.$_layout;

// 장바구니 스킨 설정 가져오기
$_cart = $shop->get('cart_skin');
$cart = 'skin/'.$_cart;

// 페이징 처리
include $grcore.'/class/paging.php';
$paging = new Paging;

// 장바구니 목록 데이터 세팅
if($_GET['rowNum'] && $_GET['rowNum'] > 1) $rowNum = $_GET['rowNum'];
else $rowNum = 20;
$paging->currentPage = $_GET['page'];
if(!$paging->currentPage) $paging->currentPage = 1;
$fromRecord = ($paging->currentPage - 1) * $rowNum;
$paging->totalPage = ceil(end($core->getData('select count(*) from '.$shop->prefix.'carts where member_key = '.$_SESSION['no'])) / $rowNum);
$cartList = $core->query('select * from '.$shop->prefix.'carts where member_key = '.$_SESSION['no'].' order by uid desc limit '.$fromRecord.', '.$rowNum);

// 레이아웃 상단 부르기
$dir = '..';
$design['head'] = '<link rel="stylesheet" href="'.$cart.'/style.css" type="text/css" title="style" />'."\n";
$design['head'] .= '<script type="text/javascript" src="'.$cart.'/cart.js"></script>'."\n";
include $layout.'/config.php';
include $layout.'/head.php';

// 장바구니 스킨 부르기
include $cart.'/cart.php';

// 레이아웃 하단 부르기
include $layout.'/foot.php';
?>