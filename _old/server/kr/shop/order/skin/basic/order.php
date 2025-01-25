<?php if(!defined('__GRSHOP__')) exit(); ?>

<div id="orderField">

<div class="infoBox">
<strong>주문목록을 이 곳에서 확인하실 수 있습니다.</strong><br />
언제나 저희 쇼핑몰을 이용해 주셔서 대단히 감사합니다.<br />
저희 쇼핑몰에서 구매하신 모든 물품들은 아래에 목록으로 보여집니다.<br />
<br />
"입금확인" 란이 <strong>확인완료</strong> 로 표시되는 제품은<br />
저희 쇼핑몰에서 고객님이 입금하신 금액을 확인하였으며, 택배를 통해<br />
물품 배송을 완료하였음을 나타냅니다. (도착까지 통상 1~3일 정도 소요됩니다.)<br />
<br />
그 밖에 '확인 대기중'은 아직 입금이 되지 않았거나, 확인되지 않은 것을 뜻하며<br />
고객님께서 부득이한 사정으로 인해 구매를 취소하신 경우에는 '구매취소됨' 으로 표시됩니다.<br />
(이미 입금하신 이후 구매를 취소하셨다면 반드시 문의게시판에 글을 남겨주세요!)<br />
<br />
상품 주문, 입금확인, 배송, 환불 등과 관련한 문의는 <a href="<?php echo $grboard; ?>/board.php?id=<?php echo $config['bbs_qna']; ?>"><?php echo $config['btn_qna']; ?></a> 에서 부탁드립니다. 감사합니다!
</div>

<table rules="none" summary="GR Shop Order List" cellpadding="0" cellspacing="0" border="0">
<caption></caption>
<thead> 
<tr>
	<th>제품 정보</th>
	<th style="width: 50px">수량</th>
	<th style="width: 80px">쓴 적립금</th>
	<th style="width: 70px">택배비</th>
	<th style="width: 100px">입금금액</th>
	<th style="width: 80px">입금확인</th>
	<th style="width: 45px">작업</th>
</tr>
</thead>
<tbody>
<?php
$paging->move = './?rowNum=20&amp;page=';
while($list = $core->fetch($orderList)) {
	$product = $orderClass->product($list);
	$status = $orderClass->status($list);
	$totalCost = $orderClass->totalCost($list, $product);
?>
<tr>
	<td<?php echo $status; ?>><a href="<?php echo $grboard; ?>/board.php?id=<?php echo $list['bbs_id']; ?>&amp;articleNo=<?php echo $list['bbs_no']; ?>" onclick="window.open(this.href, '_blank'); return false" title="클릭하시면 새 탭으로 해당 상품 정보를 확인합니다."><?php echo $product['subject']; ?></a></td>
	<td<?php echo $status; ?>><span><?php echo $list['get_number']; ?>개</span></td>
	<td<?php echo $status; ?>><span><?php echo number_format($list['use_save_money']); ?>원</span></td>
	<td<?php echo $status; ?>><span><?php echo number_format($product['ext_transport_cost']); ?>원</span></td>
	<td<?php echo $status; ?>><span><?php echo number_format($totalCost); ?>원</span></td>
	<td<?php echo $status; ?>><?php 
		if(!$list['is_payment']) echo '<span title="고객님께서 무통장입금으로 입금해주신 금액을 확인하기 전입니다.">확인 대기중</span>';
		elseif($list['is_payment']==1) echo '<strong title="제품이 택배를 통해 배송되었습니다.">확인완료</strong>';
		elseif($list['is_payment']==2) echo '<span title="고객님의 요청에 의해 거래가 취소되었습니다.">구매취소됨</span>'; 
		elseif($list['is_payment']==3) echo '<span title="신용카드를 통해 결제가 완료되었으며, 현재 물품 배송을 준비중 입니다.">배송대기</span>'; 
		elseif($list['is_payment']==4) echo '<span title="저희 쇼핑몰에서 결제된 것을 확인했으며, 물품을 배송하였습니다.">배송완료</span>'; 
		elseif($list['is_payment']==5) echo '<span title="고객님께서 상품을 배송 받으셨으며 이를 확인해 주셨습니다.">거래완료</span>'; 
	?></a></td>
	<td<?php echo $status; ?>>
		<?php 
		// 입금확인되기 전에만 취소가 가능함
		if(!$list['is_payment']) { ?><a href="#" onclick="Order.cancel(<?php echo $list['uid']; ?>, <?php echo $paging->currentPage; ?>); return false" title="클릭하시면 주문을 취소합니다. 이미 입금하신 경우, 게시판 등을 통해서 문의해 주세요.">취소</a>
		<?php }
		// 취소된 주문일경우 삭제 가능함
		elseif($list['is_payment'] == 2) { ?><a href="#" onclick="Order.remove(<?php echo $list['uid']; ?>, <?php echo $paging->currentPage; ?>); return false" title="클릭하시면 이미 주문취소된 이 항목을 주문 목록에서 완전히 삭제합니다.">삭제</a>
		<?php }
		// 카드결제 후 판매자가 물품 배송을 하여 물품을 받은 경우
		elseif($list['is_payment']==4) { ?><a href="#" onclick="Order.complete(<?php echo $list['uid']; ?>, <?php echo $paging->currentPage; ?>); return false" title="클릭하시면 상품을 배송받았음을 알려줍니다.">확인</a>
		<?php }
		// 입금확인이 되었을 경우 클릭 금지
		else echo '-'; ?>
	</td>
</tr>
<?php }
	$pagingForm = $paging->getPaging();
	if($pagingForm) { ?>
<tr>
	<td colspan="7" class="paging"><?php echo $pagingForm; ?></td>
</tr>
<?php } ?>
</tbody>
</table>

</div>