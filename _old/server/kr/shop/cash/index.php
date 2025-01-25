<?php
// id 와 no 값 체크
if((!$_GET['bbs_id'] || !$_GET['bbs_no']) && (!$_POST['bbs_id'] || !$_POST['bbs_no'])) exit();

// Core 설정 저장
define('__GRSHOP__', true);
include '../core.php';
$grcore = '../'.$grcore;
include $grcore.'/class/common.php';
include '../lib/shop.lib.php';
include '../lib/cash.lib.php';
$core = new Common($grcore);
$shop = new Shop($core, $dbFIX);
$moneyCode = $shop->get('seller_money_code', '');

// GR Board 연동 설정
$grboard = '../'.$core->config['grboard'];
include $grboard.'/include.php';
if(!$shop->isLogin()) $core->alert('로그인을 먼저 해 주세요', '../login/?go=../order/');
$cashClass = new Cash($core, $dbFIX, $grboard);

// 구매신청 처리하기
if($_POST['savePurchase']) {
	@extract($_POST);
	if(!$mail_code) $core->alert('우편번호를 입력해 주세요.', './?bbs_id='.$bbs_id.'&bbs_no='.$bbs_no);
	if(!$address1 || !$address2) $core->alert('배송지(주소)를 정확히 입력해 주세요.', './?bbs_id='.$bbs_id.'&bbs_no='.$bbs_no);
	$address1 = addslashes($address1);
	$address2 = addslashes($address2);
	$isBuyerInfo = @end($core->getData('select uid from '.$shop->prefix.'members where member_key = '.$_SESSION['no']));
	if(!$isBuyerInfo) {
		$core->query('insert into '.$shop->prefix."members set uid = '', member_key = '".$_SESSION['no']."', save_money = 0, mail_code = '{$mail_code}', address1 = '{$address1}', ".
			"address2 = '{$address2}', home_phone = '{$home_phone}', mobile_phone = '{$mobile_phone}', birthday_year = '2000', birthday_month = '1', birthday_day = '1', is_married = '0'");
	}
	if(!$use_save_money || $use_save_money < 0) $use_save_money = 0;
	$isOverMoney = @end($core->getData('select save_money from '.$shop->prefix.'members where member_key = '.$_SESSION['no']));
	if($isOverMoney < $use_save_money) $core->alert('보관중인 적립금보다 사용할 적립금이 더 큽니다. 다시 입력해주세요.', './?bbs_id='.$bbs_id.'&bbs_no='.$bbs_no);
	$core->query('insert into '.$shop->prefix."orders set uid = '', member_key = '".$_SESSION['no']."', bbs_id = '{$bbs_id}', bbs_no = '{$bbs_no}', ".
		"get_number = '{$getProductNumber}', is_payment = 0, use_save_money = '{$use_save_money}'");
	$core->query('delete from '.$shop->prefix."carts where member_key = '".$_SESSION['no']."' and bbs_id = '{$bbs_id}' and bbs_no = '{$bbs_no}' limit 1");
	$core->query('update '.$shop->prefix."members set save_money = save_money - $use_save_money, mail_code = '{$mail_code}', address1 = '{$address1}', address2 = '{$address2}', ".
		"home_phone = '{$home_phone}', mobile_phone = '{$mobile_phone}' where member_key = '".$_SESSION['no']."' limit 1");
	$core->alert('구매신청을 완료하였습니다. 구매해 주셔서 감사합니다.\\n\\n입금계좌정보와 입금금액은 아래와 같습니다.\\n\\n입금계좌: '.$moneyCode.'\\n\\n입금금액: '.number_format($totalCost-$use_save_money).' 원', '../order/');
}

// 레이아웃 설정 가져오기
$_layout = $shop->get('layout_skin');
$layout = '../layout/'.$_layout;

// 구매하기 스킨 설정 가져오기
$_cash = $shop->get('cash_skin');
$cash = 'skin/'.$_cash;

// 구매할 상품 정보 가져오기
$bbs_id = $_GET['bbs_id'];
$bbs_no = $_GET['bbs_no'];
$view = $core->getData('select * from '.$cashClass->boardFix.'bbs_'.$bbs_id.' where no = '.$bbs_no);
$theme = $grboard.'/theme/'.@end($core->getData('select theme from '.$cashClass->boardFix.'board_list where id = \''.$bbs_id.'\' limit 1'));
$_member = $core->getData('select realname from '.$cashClass->boardFix.'member_list where no = '.$_SESSION['no']);
$buyer = $core->getData('select * from '.$shop->prefix.'members where member_key = '.$_SESSION['no']);
$buyer['realname'] = stripslashes($_member['realname']);
$buyer['address1'] = stripslashes($buyer['address1']);
$buyer['address2'] = stripslashes($buyer['address2']);
$buyer['save_money'] = ($buyer['save_money']) ? $buyer['save_money'] : 0;
$discountPercent = round(100 - (($view['ext_money_real']/$view['ext_money_original'])*100), 2);
$view['subject'] = strip_tags(stripslashes($view['subject']));
$view['ext_etc_info'] = stripslashes($view['ext_etc_info']);
$view['ext_product_code'] = stripslashes($view['ext_product_code']);
$view['ext_exchange_info'] = stripslashes($view['ext_exchange_info']);
$sendMoney = $view['ext_money_real'] + $view['ext_transport_cost'];

// 레이아웃 상단 부르기
$dir = '..';
$design['head'] = '<link rel="stylesheet" href="'.$cash.'/style.css" type="text/css" title="style" />'."\n";
$design['head'] .= '<script type="text/javascript" src="'.$cash.'/cash.js"></script>'."\n";
include $layout.'/config.php';
include $layout.'/head.php';

// 구매하기 스킨 부르기
include $cash.'/cash.php';

// 레이아웃 하단 부르기
include $layout.'/foot.php';
?>