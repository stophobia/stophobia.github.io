<?php
/**
 * 레이아웃 스킨 하단부분 (게시판 이외의 페이지에서 불려짐)
 * 주의: foot.grboard.php 와 비슷해 보이지만 세부적으로 경로라던지 하는 게 다르므로 차이점 숙지 필요.
 * 제작: sirini (http://sirini.net)
 **/
if(!defined('__GRSHOP__')) exit();
?>
	</div><!-- #mainCONTENT -->

	<div id="rightSide">
		<?php latest($design['latest_post'], $config['bbs_notice'], $config['row_notice'], 30, '0', '0', 'Y.m.d', $config['btn_notice'], 'no', 'desc'); ?>
		<div style="height: 15px"></div>
		<?php latest($design['latest_post'], $config['bbs_freeboard'], $config['row_freeboard'], 30, '0', '0', 'Y.m.d', $config['btn_freeboard'], 'no', 'desc'); ?>
		<div style="height: 15px"></div>
		<?php latest($design['latest_post'], $config['bbs_qna'], $config['row_qna'], 30, '0', '0', 'Y.m.d', $config['btn_qna'], 'no', 'desc'); ?>
	</div>

	<div class="clear"></div>
	<div class="clear"></div>

	<div id="footCopyright">
	<div id="fareTradeMark"></div>
	주소: <?php echo $shop->get('seller_address', ''); ?>, 
	개인정보보호책임자: <?php echo $shop->get('seller_protector', ''); ?><br />

	사업자등록번호: <?php echo $shop->get('seller_code', ''); ?>, 
	통신판매업신고: <?php echo $shop->get('seller_register_number', ''); ?>, 
	대표: <?php echo $shop->get('seller_ceo', ''); ?> (<?php echo $shop->get('seller_email', ''); ?>)<br />

	문의전화: <?php echo $shop->get('seller_telephone', ''); ?>, 
	<?php $seller_messanger = $shop->get('seller_messenger', ''); if($seller_messanger) echo '상담용 메신져: '.$seller_messanger; ?>, 
	<?php $seller_fax = $shop->get('seller_fax', ''); if($seller_fax) echo '팩스: '.$seller_fax; ?><br />
	<?php echo $config['foot_copyright']; ?>
	</div>

</div><!-- #main -->

<?php $shop->checkNewMemo($grboard, '<span id="memoIcon">&nbsp;&nbsp;&nbsp;</span> 새로운 쪽지가 도착했습니다.'); ?>

</body>
</html>