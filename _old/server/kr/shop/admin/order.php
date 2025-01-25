<?php
if(!defined('__GRSHOP__')) exit();

// GR보드 설정 가져오기
$_grcore = $grcore;
include $grboard.'/core.php';
$grcore = $_grcore;

// 주문 삭제시
if($_GET['deleteTarget']) {
	$getMoney = $core->getData('select member_key, is_payment, use_save_money from '.$shop->prefix.'orders where uid = '.$_GET['deleteTarget']);
	if(!$getMoney['is_payment']) {
		$core->query('update '.$shop->prefix.'members set save_money = save_money + '.$getMoney['use_save_money'].' where member_key = '.$getMoney['member_key'].' limit 1');
	} elseif($getMoney['is_payment'] == 1) {
		$returnMoney = ($_GET['returnMoney']) ? $_GET['returnMoney'] : 0;
		$core->query('update '.$shop->prefix.'members set save_money = save_money - '.$returnMoney.' where member_key = '.$getMoney['member_key'].' limit 1');
	}
	$core->query('delete from '.$shop->prefix.'orders where uid = '.$_GET['deleteTarget'].' limit 1');
	$core->alert('등록된 주문을 삭제하였습니다.', './?menu=3');
}

// 주문 확인 완료 / 취소시 처리
if($_GET['confirm']) {
	$giveMoney = ($_GET['giveMoney']) ? $_GET['giveMoney'] : 0;
	$returnMoney = ($_GET['returnMoney']) ? $_GET['returnMoney'] : 0;
	$receiveCost = ($_GET['receiveCost']) ? $_GET['receiveCost'] : 0;
	$giveMoney *= $_GET['num'];
	$returnMoney *= $_GET['num'];
	$getMemberKey = @end($core->getData('select member_key from '.$shop->prefix.'orders where uid = '.$_GET['confirm']));
	if($_GET['action']) {
		$core->query('update '.$shop->prefix.'orders set is_payment = 1 where uid = '.$_GET['confirm']);
		$core->query('update '.$shop->prefix.'members set save_money = save_money + '.$giveMoney.' where member_key = '.$getMemberKey.' limit 1');
		$core->query('insert into '.$shop->prefix."accounts set uid = '', order_uid = '".$_GET['confirm']."', cost = '".
			$_GET['receiveCost']."', year = '".date('Y')."', month = '".date('n')."', day = '".date('j')."', week = '".date('W')."'");
		$core->alert('입금을 확인하였고 상품배송을 했다고 고객에게 알려주겠습니다. (적립금 보충됨)', './?menu=3');
	} else {
		$core->query('update '.$shop->prefix.'orders set is_payment = 0 where uid = '.$_GET['confirm']);
		$core->query('update '.$shop->prefix.'members set save_money = save_money - '.$returnMoney.' where member_key = '.$getMemberKey.' limit 1');
		$core->query('delete from '.$shop->prefix.'accounts where order_uid = '.$_GET['confirm']);
		$core->alert('입금확인하기 이전단계로 되돌립니다. (보충했던 적립금 회수)', './?menu=3');
	}
}

// 카드결제 확인 완료시
if($_GET['cardOKTarget']) {
	$core->query('update '.$shop->prefix.'orders set is_payment = 4 where uid = '.$_GET['cardOKTarget']);
	$core->query('insert into '.$shop->prefix."accounts set uid = '', order_uid = '".$_GET['cardOKTarget']."', cost = '".
		$_GET['receiveCost']."', year = '".date('Y')."', month = '".date('n')."', day = '".date('j')."', week = '".date('W')."'");
	$core->alert('카드로 결제된 금액을 확인했고, 상품배송을 했다고 고객에게 알려주겠습니다.\\n\\n(확인 완료된 지금 시점에서, 매출통계에 이 거래내역이 반영됩니다.)', './?menu=3');
}

// 카드결제 확인 취소시
if($_GET['cardCancelTarget']) {
	$core->query('update '.$shop->prefix.'orders set is_payment = 3 where uid = '.$_GET['cardCancelTarget']);
	$core->query('delete from '.$shop->prefix.'accounts where order_uid = '.$_GET['cardCancelTarget']);
	$core->alert('상품 상태를 배송하기 전 상태로 되돌렸습니다.\\n\\n상품을 택배로 배송하신 후 다시 변경해주세요!', './?menu=3');
}

// 페이징 처리
include $grcore.'/class/paging.php';
$paging = new Paging;
$rowNum = 10;
$paging->currentPage = $_GET['page'];
$paging->move = './?menu=3&amp;page=';
if(!$paging->currentPage) $paging->currentPage = 1;
$fromRecord = ($paging->currentPage - 1) * $rowNum;
$paging->totalPage = ceil(end($core->getData('select count(*) from '.$shop->prefix.'orders')) / $rowNum);
$orderList = $core->query('select * from '.$shop->prefix.'orders order by uid desc limit '.$fromRecord.', '.$rowNum);

// 매출 결산
if($_GET['_year']) $_year = $_GET['_year']; else $_year = date('Y');
if($_GET['_month']) $_month = $_GET['_month']; else $_month = date('n');
if($_GET['_day']) $_day = $_GET['_day']; else $_day = date('j');
$_week = date('W', mktime(0, 0, 0, $_month, $_day, $_year));
$_yesterday = @explode(' ', date('Y n j', strtotime('last day')));
$_lastweek = date('W', strtotime('last week'));
$_lastmonth = @explode(' ', date('Y n', strtotime('last month')));
$_lastyear = date('Y', strtotime('last year'));
$gain['yesterday'] = number_format(@end($core->getData('select sum(cost) from '.$shop->prefix."accounts where year = '".$_yesterday[0]."' and month = '".$_yesterday[1]."' and day = '".$_yesterday[2]."'")));
$gain['lastweek'] = number_format(@end($core->getData('select sum(cost) from '.$shop->prefix."accounts where week = '{$_lastweek}'")));
$gain['lastmonth'] = number_format(@end($core->getData('select sum(cost) from '.$shop->prefix."accounts where year = '".$_lastmonth[0]."' and month = '".$_lastmonth[1]."'")));
$gain['today'] = number_format(@end($core->getData('select sum(cost) from '.$shop->prefix."accounts where year = '{$_year}' and month = '{$_month}' and day = '{$_day}'")));
$gain['week'] = number_format(@end($core->getData('select sum(cost) from '.$shop->prefix."accounts where week = '{$_week}'")));
$gain['month'] = number_format(@end($core->getData('select sum(cost) from '.$shop->prefix."accounts where year = '{$_year}' and month = '{$_month}'")));
$gain['year'] = number_format(@end($core->getData('select sum(cost) from '.$shop->prefix."accounts where year = '{$_year}'")));
?>

<div id="bbsInfo" class="infoBox">
<strong>GR Shop 주문관리 화면입니다.</strong><br />
이 곳에서는 고객의 주문신청 목록을 확인하실 수 있습니다.<br />
<br />
<strong>1) 고객이 무통장입금으로 구매신청을 한 경우</strong><br />
"매장관리" 에서 등록하신 관리자님의 "입금 계좌정보" 으로 고객이 정확한 상품 금액을 입금하였음을 확인하신 이후<br />
상품을 택배 등을 통해서 배송해 주세요. 이 때 입금을 확인하셨다면 아래 목록에서 해당 고객의 "입금확인" 란에<br />
[확인완료로 설정] 버튼을 클릭해 주세요.<br />
<br />
<strong>2) 고객이 신용카드로 결제한 경우</strong><br />
신용카드로 결제하여 실제로 고객이 결제를 완료한 경우 아래 목록상에서 "입금확인" 란에<br />
[카드 결제 확인됨] 이란 글자가 나타나면서 "상태" 란에 "완료" 로 표시가 됩니다.<br />
고객이 이미 카드결제로 "<a href="http://allthegate.com" onclick="window.open(this.href, '_blank'); return false">올더게이트</a>" 를 통해 입금을 한 경우이므로 상품을 택배로 배송하신 다음<br />
[카드 결제 확인됨] 을 클릭하셔서 [배송 완료됨] 으로 상태를 변경해 주세요.<br />
고객이 구매확인을 클릭해주었을 경우 "입금확인" 란은 최종적으로 [고객 배송받았음] 이 됩니다.
</div>

<div id="orderHelp" class="main">

<h2>등록된 주문신청 목록</h2>

<table rules="none" summary="GR Shop Order List" cellpadding="0" cellspacing="0" border="0">
<caption></caption>
<thead> 
<tr>
	<th style="width: 120px">연락처</th>
	<th style="width: 60px">고객명</th>
	<th>제품 정보 / (우편번호) 배송받을 위치</th>
	<th style="width: 45px">수량</th>
	<th style="width: 100px">사용한 적립금</th>
	<th style="width: 60px">택배비</th>
	<th style="width: 100px">입금받을 금액</th>
	<th style="width: 140px">입금확인 설정</th>
	<th style="width: 60px">상태</th>
	<th style="width: 45px">삭제</th>
</tr>
</thead>
<tbody>
<?php
while($order = $core->fetch($orderList)) {
	$member = $core->getData('select nickname, realname from '.$dbFIX.'member_list where no = '.$order['member_key']);
	$buyer = $core->getData('select * from '.$shop->prefix.'members where member_key = '.$order['member_key']);
	$product = $core->getData('select subject, ext_money_real, ext_money_save, ext_transport_cost, ext_product_code from '.$dbFIX.'bbs_'.$order['bbs_id'].' where no = '.$order['bbs_no']);
	if($order['is_payment']==1) $status = ' class="done"';
	elseif($order['is_payment']==2) $status = ' class="cancel"';
	else $status = '';
	$receiveCost = ($product['ext_money_real']*$order['get_number']) - $order['use_save_money'] + $product['ext_transport_cost'];
	$cardNo = @end($core->getData('select uid from '.$shop->prefix.'cards where member_key = '.$order['member_key'].' and order_key = '.$order['uid']));
	if($cardNo) {
		$_receiveCost = '<a href="#" onclick="Order.cardView('.$cardNo.');" title="카드로 결제된 주문입니다. 클릭하시면 이번 고객과의 거래내역을 확인 할 수 있습니다.">'.number_format($receiveCost).'</a>';
		$status = ' class="card"';
	}
	else $_receiveCost = '<span title="관리자님의 통장에 입금될 최종적인 금액입니다.">'.number_format($receiveCost).'</span>';
?>
<tr>
	<td<?php echo $status; ?>><?php if($buyer['home_phone']) echo '(집) '.$buyer['home_phone'].'<br />'; if($buyer['mobile_phone']) echo '(폰) '.$buyer['mobile_phone']; ?></td>
	<td<?php echo $status; ?>><a href="<?php echo $grboard; ?>/send_memo.php?target=<?php echo $buyer['member_key']; ?>" onclick="window.open(this.href, 'sendMemo', 'width=650,height=600,menubar=no'); return false" title="클릭하시면 <?php echo $member['realname'].'('.htmlspecialchars($member['nickname']); ?>) 님께 쪽지를 보내는 창을 팝업으로 엽니다."><?php echo stripslashes($member['realname']); ?></a></td>
	<td<?php echo $status; ?>>
		<div><a href="<?php echo $grboard; ?>/board.php?id=<?php echo $order['bbs_id']; ?>&amp;articleNo=<?php echo $order['bbs_no']; ?>" onclick="window.open(this.href, '_blank'); return false" title="클릭하시면 새 탭으로 해당 상품 정보를 확인합니다."><?php echo stripslashes($product['subject']); ?></a></div>
		<div class="address">(<?php echo $buyer['mail_code']; ?>) <?php echo stripslashes($buyer['address1'].'<br />'.$buyer['address2']); ?></div>
	</td>
	<td<?php echo $status; ?>><?php echo $order['get_number']; ?>개</td>
	<td<?php echo $status; ?>><?php echo number_format($order['use_save_money']); ?>원</td>
	<td<?php echo $status; ?>><?php echo number_format($product['ext_transport_cost']); ?>원</td>
	<td<?php echo $status; ?>><?php echo $_receiveCost; ?>원</td>
	<td<?php echo $status; ?>><?php 
		if(!$order['is_payment']) echo '<a href="#" onclick="Order.ok('.$order['uid'].', \''.$product['ext_money_save'].'\', '.$order['member_key'].', \''.$receiveCost.'\', \''.$order['get_number'].'\');" title="클릭하시면 입금확인을 완료하여 상품배송을 한 것으로 표시합니다.">[확인완료로 설정]</a>';
		elseif($order['is_payment']==1) echo '<a href="#" onclick="Order.cancel('.$order['uid'].', \''.$product['ext_money_save'].'\', '.$order['member_key'].', \''.$order['get_number'].'\');" title="클릭하시면 입금확인하기 이전 상태로 돌립니다.">[확인 전으로 되돌리기]</a>';
		elseif($order['is_payment']==2) echo '<span title="고객이 상품구매를 취소하였습니다.">[고객이 취소함]</span>'; 
		elseif($order['is_payment']==3) echo '<a href="#" onclick="Order.cardOK('.$order['uid'].', '.$receiveCost.');" title="클릭하시면 [배송 완료됨] 으로 표시됩니다. 클릭하시기 전에 택배를 통해 물품을 배송해 주세요!">[카드 결제 확인됨]</a>';
		elseif($order['is_payment']==4) echo '<a href="#" onclick="Order.cardCancel('.$order['uid'].');" title="클릭하시면 [배송 완료됨] 에서 다시 [카드 결제 확인됨] 으로 변경됩니다. 택배로 물품을 배송하지 않았는데 [배송 완료됨] 으로 나타날 경우에만 클릭해 주세요!">[배송 완료됨]</a>';
		elseif($order['is_payment']==5) echo '[고객 배송받았음]';
	?></td>
	<td<?php echo $status; ?>><?php 
		if(!$order['is_payment']) echo '<span title="고객이 아직 입금을 하지 않았거나, 관리자님이 아직 입금확인을 하지 않았습니다.">확인전</span>';
		elseif($order['is_payment']==1 || $order['is_payment']>2) echo '<strong title="고객이 입금을 하여 관리자님이 입금을 확인하였고, 상품을 택배로 발송완료 했습니다.">완료</strong>';
		else echo '<strike title="고객의 사정에 의해 구매가 취소되었습니다.">취소</strike>'; 
	?></td>
	<td<?php echo $status; ?>><a href="#" onclick="Order.remove(<?php echo $order['uid']; ?>, '<?php echo $product['ext_money_save']; ?>'); return false">삭제</a></td>
</tr>
<?php }
	$pagingForm = $paging->getPaging();
	if($pagingForm) { ?>
<tr>
	<td colspan="10" class="paging"><?php echo $pagingForm; ?></td>
</tr>
<?php } ?>
</tbody>
</table>

<h2>빠른 매출 결산 <span class="addition"><a href="./?menu=6" title="클릭하시면 일자별 상세 매출액 결산을 보실 수 있습니다.">[상세 매출 결산]</a></span></h2>

<table rules="none" summary="GR Shop Order List" cellpadding="0" cellspacing="0" border="0">
<caption></caption>
<thead> 
<tr>
	<th style="width: 120px">기간</th>
	<th>매출액</th>
	<th style="width: 120px">기간</th>
	<th>비교</th>
</tr>
</thead>
<tbody>
<tr>
	<td>오늘 (<?php echo $_day; ?>일)</td>
	<td><strong><?php echo $gain['today']; ?></strong> 원 </td>
	<td>어제 (<?php echo $_yesterday[2]; ?>일)</td>
	<td><?php echo $gain['yesterday']; ?> 원</td>
</tr>
<tr>
	<td>이번주 (<?php echo $_week; ?>주차)</td>
	<td><?php echo $gain['week']; ?> 원</td>
	<td>지난주 (<?php echo $_lastweek; ?>주차)</td>
	<td><?php echo $gain['lastweek']; ?> 원</td>
</tr>
<tr>
	<td>이번달 (<?php echo $_month; ?>월)</td>
	<td><?php echo $gain['month']; ?> 원</td>
	<td>지난달 (<?php echo $_lastmonth[1]; ?>월)</td>
	<td><?php echo $gain['lastmonth']; ?> 원</td>
</tr>
<tr>
	<td>올해 (<?php echo $_year; ?>년)</td>
	<td><?php echo $gain['year']; ?> 원</td>
	<td>작년 (<?php echo $_lastyear; ?>월)</td>
	<td><?php echo $gain['lastyear']; ?> 원</td>
</tr>
</tbody>
</table>

</div>

<div id="cardInfo" title="카드 구매정보"></div>