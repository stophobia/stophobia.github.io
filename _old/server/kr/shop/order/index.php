<?php
// Core 설정 저장
define('__GRSHOP__', true);
include '../core.php';
$grcore = '../'.$grcore;
include $grcore.'/class/common.php';
include '../lib/shop.lib.php';
include '../lib/order.lib.php';
$core = new Common($grcore);
$shop = new Shop($core, $dbFIX);

// GR Board 연동 설정
$grboard = '../'.$core->config['grboard'];
include $grboard.'/include.php';
if(!$shop->isLogin()) $core->alert('로그인을 먼저 해 주세요', '../login/?go=../order/');
$orderClass = new Order($core, $dbFIX, $grboard);

// 주문 삭제시
if($_GET['deleteTarget']) {
	$isMine = $core->getData('select member_key, is_payment from '.$shop->prefix.'orders where uid = '.$_GET['deleteTarget']);
	if($isMine['is_payment'] == 1) $core->alert('입금확인이 완료되어 이미 배송되었습니다.\\n\\n환불하고자 하시는 경우 게시판등을 통해서 문의해주세요.', './?page='.$_GET['page']);
	if($isMine['member_key'] == $_SESSION['no'] && $isMine['is_payment'] == 2) {
		$core->query('delete from '.$shop->prefix.'orders where uid = '.$_GET['deleteTarget'].' limit 1');
		$core->alert('취소된 주문을 완전히 삭제하였습니다.', './?page='.$_GET['page']);
	} else $core->alert('본인의 주문이 아니거나 취소된 주문이 아닙니다.', './?page='.$_GET['page']);
}

// 주문 취소시
if($_GET['cancelTarget']) {
	$isMine = $core->getData('select member_key, is_payment from '.$shop->prefix.'orders where uid = '.$_GET['cancelTarget']);
	if($isMine['is_payment'] == 1) $core->alert('입금확인이 완료되어 이미 배송되었습니다.\\n\\n환불하고자 하시는 경우 게시판등을 통해서 문의해주세요.', './?page='.$_GET['page']);
	if($isMine['member_key'] == $_SESSION['no'] && !$isMine['is_payment']) {
		$getMoney = @end($core->getData('select use_save_money from '.$shop->prefix.'orders where uid = '.$_GET['cancelTarget']));
		$core->query('update '.$shop->prefix.'members set save_money = save_money + '.$getMoney.' where member_key = '.$_SESSION['no']);
		$core->query('update '.$shop->prefix.'orders set is_payment = 2, use_save_money = 0 where uid = '.$_GET['cancelTarget']);
		$core->alert('등록된 주문을 취소하였고, 사용했던 적립금을 다시 회수하였습니다.', './?page='.$_GET['page']);
	} else $core->alert('이미 주문이 취소되었습니다.', './?page='.$_GET['page']);
}

// 배송 확인완료시
if($_GET['completeTarget']) {
	$core->query('update '.$shop->prefix.'orders set is_payment = 5 where uid = '.$_GET['completeTarget']);
	$core->alert('정상적으로 상품을 배송 받았음을 확인해 주셔서 감사합니다.', './?page='.$_GET['page']);
}

// 레이아웃 설정 가져오기
$_layout = $shop->get('layout_skin');
$layout = '../layout/'.$_layout;

// 주문조회 스킨 설정 가져오기
$_order = $shop->get('order_skin');
$order = 'skin/'.$_order;

// 페이징 처리
include $grcore.'/class/paging.php';
$paging = new Paging;

// 주문조회 목록 데이터 세팅
if($_GET['rowNum'] && $_GET['rowNum'] > 1) $rowNum = $_GET['rowNum'];
else $rowNum = 20;
$paging->currentPage = $_GET['page'];
if(!$paging->currentPage) $paging->currentPage = 1;
$fromRecord = ($paging->currentPage - 1) * $rowNum;
$paging->totalPage = ceil(end($core->getData('select count(*) from '.$shop->prefix.'orders where member_key = '.$_SESSION['no'])) / $rowNum);
$orderList = $core->query('select * from '.$shop->prefix.'orders where member_key = '.$_SESSION['no'].' order by uid desc limit '.$fromRecord.', '.$rowNum);

// 레이아웃 상단 부르기
$dir = '..';
$design['head'] = '<link rel="stylesheet" href="'.$order.'/style.css" type="text/css" title="style" />'."\n";
$design['head'] .= '<script type="text/javascript" src="'.$order.'/order.js"></script>'."\n";
include $layout.'/config.php';
include $layout.'/head.php';

// 주문조회 스킨 부르기
include $order.'/order.php';

// 레이아웃 하단 부르기
include $layout.'/foot.php';
?>