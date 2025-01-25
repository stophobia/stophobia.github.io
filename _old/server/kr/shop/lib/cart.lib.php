<?php
/**
 * 장바구니 페이지에서 사용할 메소드들
 *  - GR Core 의 Common 클래스 선언 이후 사용가능.
 */
class Cart {
	public $core, $prefix, $boardFix, $grboard;

	function __construct($core, $dbFIX, $grboard) {
		$this->core = $core;
		$this->prefix = $dbFIX;
		$this->grboard = $grboard;
		include $grboard.'/core.php';
		$this->boardFix = $dbFIX;
	}
	
	function product($list, $strlen) {
		$result = $this->core->getData('select subject, content, ext_money_real, ext_transport_cost, ext_product_code from '.$this->boardFix.'bbs_'.$list['bbs_id'].' where no = '.$list['bbs_no']);
		$result['subject'] = strip_tags(stripslashes($result['subject']));
		$result['content'] = cutString(strip_tags(stripslashes($result['content'])), $strlen);
		return $result;
	}

	function totalCost($list, $product) {
		return ($product['ext_money_real']+$product['ext_transport_cost']);
	}

	function preview($list, $w, $h) {
		$getImg = $this->core->getData('select file_route from '.$this->boardFix.'pds_extend where id = \''.$list['bbs_id'].'\' and article_num = '.$list['bbs_no'].' limit 1');
		if(!$getImg['file_route']) return '';
		return '<a href="'.$this->grboard.'/board.php?id='.$list['bbs_id'].'&amp;articleNo='.$list['bbs_no'].'" onclick="window.open(this.href, \'_blank\'); return false" title="클릭하시면 상품 정보를 새 탭에서 확인합니다."><img src="'.$this->grboard.'/phpThumb/phpThumb.php?src=../'.$getImg['file_route'].'&amp;w='.$w.'&amp;h='.$h.'&amp;fltr[]=usm|99|0.5|3" alt="미리보기" /></a>';
	}
}
?>