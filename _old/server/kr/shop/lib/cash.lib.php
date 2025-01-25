<?php
/**
 * 구매하기 페이지에서 사용할 메소드들
 *  - GR Core 의 Common 클래스 선언 이후 사용가능.
 */
class Cash {
	public $core, $prefix, $boardFix, $grboard;

	function __construct($core, $dbFIX, $grboard) {
		$this->core = $core;
		$this->prefix = $dbFIX;
		$this->grboard = $grboard;
		include $grboard.'/core.php';
		$this->boardFix = $dbFIX;
	}

	function preview($id, $articleNo, $max) {
		$getFile = $this->core->getData('select file_route from '.$this->boardFix.'pds_extend where id = \''.$id.'\' and article_num = '.$articleNo.' limit 1');
		if(!$getFile['file_route']) return '';
		return '<img src="'.$this->grboard.'/phpThumb/phpThumb.php?src=../'.$getFile['file_route'].'&amp;w='.$max.'&amp;h='.$max.'&amp;q=100&amp;fltr[]=usm|99|0.5|3" alt="미리보기" />';
	}
}
?>