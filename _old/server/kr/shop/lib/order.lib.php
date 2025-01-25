<?php
/**
 * 주문조회 페이지에서 사용할 메소드들
 *  - GR Core 의 Common 클래스 선언 이후 사용가능.
 */
class Order {
	public $core, $prefix, $boardFix;

	function __construct($core, $dbFIX, $grboard) {
		$this->core = $core;
		$this->prefix = $dbFIX;
		include $grboard.'/core.php';
		$this->boardFix = $dbFIX;
	}
	
	function product($list) {
		$result = $this->core->getData('select subject, ext_money_real, ext_transport_cost, ext_product_code from '.$this->boardFix.'bbs_'.$list['bbs_id'].' where no = '.$list['bbs_no']);
		$result['subject'] = strip_tags(stripslashes($result['subject']));
		return $result;
	}

	function status($list) {
		if($list['is_payment']==1) return ' class="done"';
		elseif($list['is_payment']==2) return ' class="cancel"';
		else return '';
	}

	function totalCost($list, $product) {
		return ($product['ext_money_real']*$list['get_number']) - $list['use_save_money'] + $product['ext_transport_cost'];
	}
}
?>