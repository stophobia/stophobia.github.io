<?php 
if(!defined('__GRSHOP__')) exit(); 
$width = 100;
$height = 85;
$strlen = 300;
?>

<div id="cartField">

<div class="infoBox">
<strong>장바구니에 담아두신 상품들을 이 곳에서 확인하실 수 있습니다.</strong><br />
저희 쇼핑몰에서 소개해 드린 상품들 중 고객님께서 장바구니에 담아두신 목록을<br />
이 곳에서 모두 확인하실 수 있습니다. 담아두신 상품들은 "구매하기" 란의 버튼을 통해서<br />
바로 구매가 가능합니다.<br />
<br />
이 곳에서 구매하신 상품들은 "<?php echo $config['btn_order']; ?>" 메뉴를 통해서<br />
입금확인이 되었는지 등을 확인하실 수 있습니다.<br />
구매신청이 완료되면 해당 상품은 "<?php echo $config['btn_order']; ?>" 메뉴로 이동됩니다.<br />
<br />
<strong>무통장입금 계좌안내</strong>: <?php echo $shop->get('seller_money_code', ''); ?>
</div>

<table rules="none" summary="GR Shop Order List" cellpadding="0" cellspacing="0" border="0">
<caption></caption>
<thead> 
<tr>
	<th style="width: <?php echo $width+10; ?>px">상품사진</th>
	<th>제품 정보</th>
	<th style="width: 100px">할인판매가</th>
	<th style="width: 100px">구매하기</th>
	<th style="width: 45px">삭제</th>
</tr>
</thead>
<tbody>
<?php
$paging->move = './?rowNum=20&amp;page=';
while($list = $core->fetch($cartList)) {
	$product = $cartClass->product($list, $strlen);
	$totalCost = $cartClass->totalCost($list, $product);
	$preview = $cartClass->preview($list, $width, $height);
?>
<tr>
	<td><?php echo $preview; ?></td>
	<td class="top">
		<div class="subject"><a href="<?php echo $grboard; ?>/board.php?id=<?php echo $list['bbs_id']; ?>&amp;articleNo=<?php echo $list['bbs_no']; ?>" onclick="window.open(this.href, '_blank'); return false" title="클릭하시면 새 탭으로 해당 상품 정보를 확인합니다."><?php echo $product['subject']; ?></a></div>
		<div class="content"><?php echo $product['content']; ?></div>
	</td>
	<td><?php echo number_format($totalCost); ?>원</td>
	<td><a href="../cash/?bbs_id=<?php echo $list['bbs_id']; ?>&amp;bbs_no=<?php echo $list['bbs_no']; ?>" onclick="window.open(this.href, '_blank'); return false" title="클릭하시면 새 탭으로 구매하기 페이지에 연결됩니다." class="cash"><img src="<?php echo $cart; ?>/cart.icon.gif" alt="" /> 구매하기</a></td>
	<td><a href="#" onclick="Cart.remove(<?php echo $list['uid']; ?>, <?php echo $paging->currentPage; ?>); return false">삭제</a></td>
</tr>
<?php }
	$pagingForm = $paging->getPaging();
	if($pagingForm) { ?>
<tr>
	<td colspan="5" class="paging"><?php echo $pagingForm; ?></td>
</tr>
<?php } ?>
</tbody>
</table>

</div>