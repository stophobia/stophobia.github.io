<?php 
if(!defined('__GRSHOP__')) exit(); 
$maxProductImgSize = 230;
?>

<div id="cashField">

<div class="infoBox">
<strong>상품 구매하기 화면에 오신 것을 환영합니다!</strong><br />
이 곳에서 고객님이 구매하고자 하시는 상품을 다시 확인하고, 구매신청을 하실 수 있습니다.<br />
구매신청을 하신 후에는 아래에 나타나는 무통장입금 계좌번호로 "입금하실 금액" 에 나온<br />
액수만큼 입금을 해 주시면 됩니다. 그 후 바로 입금확인을 원하시는 분들은 <a href="<?php echo $grboard; ?>/board.php?id=<?php echo $config['bbs_qna']; ?>"><?php echo $config['btn_qna']; ?></a> 에 비밀글로<br />
입금확인 신청글을 남겨주시면 입금확인 후 해당 제품을 택배를 통해 발송해 드립니다.<br />
(입금자명과 쇼핑몰에 등록된 성함이 같아야 합니다!)<br />
<br />
- <strong>무통장입금 계좌번호</strong>: <?php echo $moneyCode; ?><br />
- <strong>입금확인요청 작성</strong>: <a href="<?php echo $grboard; ?>/board.php?id=<?php echo $config['bbs_qna']; ?>"><?php echo $config['btn_qna']; ?></a> 을 클릭해 주세요.<br />
- <strong>주문조회 하기</strong>: <a href="../order/"><?php echo $config['btn_order']; ?></a> 을 클릭해 주세요.
</div>

<form id="purchase" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return Cash.checkAll(this);">
<div>
<input type="hidden" name="savePurchase" value="1" />
<input type="hidden" name="bbs_id" value="<?php echo $bbs_id; ?>" />
<input type="hidden" name="bbs_no" value="<?php echo $bbs_no; ?>" />
<input type="hidden" name="totalCost" value="<?php echo $sendMoney; ?>" />
<input type="hidden" name="totalSaveMoney" value="<?php echo $view['ext_money_save']; ?>" />
<input type="hidden" name="getNum" value="1" />
</div>
<table rules="none" summary="GR Shop Cash List" cellpadding="0" cellspacing="0" border="0" style="width: 100%; table-layout: fixed">
<caption></caption>
<thead>
<tr>
	<th style="width: <?php echo ($maxProductImgSize+10); ?>px">상품사진</th>
	<th style="width: 100px">항목</th>
	<th>상품정보</th>
</tr>
</thead>
<tbody>
<tr>
	<td rowspan="13" class="productImg"><?php echo $cashClass->preview($bbs_id, $bbs_no, $maxProductImgSize); ?></td>
	<td class="opt">상품명</td>
	<td class="var"><?php echo $view['subject']; ?></td>
</tr>
<tr>
	<td class="opt">판매가 (정가)</td>
	<td class="var"><?php echo number_format($view['ext_money_original']); ?>원</td>
</tr>
<tr>
	<td class="opt">할인된 판매가</td>
	<td class="var"><?php echo number_format($view['ext_money_real']); ?>원 (<?php echo $discountPercent; ?>% 할인)</td>
</tr>
<tr>
	<td class="opt">적립금</td>
	<td class="var"><span id="getSaveMoney"><?php echo number_format($view['ext_money_save']); ?></span>원</td>
</tr>
<tr>
	<td class="opt">구매할 수량</td>
	<td class="var"><select name="getProductNumber" onchange="Cash.sumCost(this, '<?php echo $sendMoney; ?>', '<?php echo $view['ext_money_save']; ?>');"><?php
	for($p=1; $p<=$view['ext_number_get']; $p++) echo '<option value="'.$p.'"'.(($p==1)?' selected="selected"':'').'>'.$p.'</option>';
	?></select>개</td>
</tr>
<tr>
	<td class="opt">제조사/원산지</td>
	<td class="var"><?php echo stripslashes($view['ext_from_made']); ?></td>
</tr>
<tr>
	<td class="opt">배송비</td>
	<td class="var"><?php echo (!$view['ext_transport_cost'])?'<img src="'.$theme.'/image/cost.free.transport.gif" alt="무료배송" />':number_format($view['ext_transport_cost']); ?></td>
</tr>
<tr>
	<td class="opt">배송기간</td>
	<td class="var"><?php echo $view['ext_transport_term']; ?>일</td>
</tr>
<tr>
	<td class="opt">반품/교환안내</td>
	<td class="var"><?php echo $view['ext_exchange_info']; ?></td>
</tr>
<tr>
	<td class="opt">상품코드</td>
	<td class="var"><?php echo $view['ext_product_code']; ?></td>
</tr>
<tr>
	<td class="opt">기타안내</td>
	<td class="var"><?php echo $view['ext_etc_info']; ?></td>
</tr>
<tr>
	<td class="opt"><strong>입금하실 금액</strong></td>
	<td class="var"><span class="sendMoneyConfirm"><?php echo number_format($sendMoney); ?></span> 원</td>
</tr>
<tr>
	<td class="opt" style="border-bottom: #ddd 1px solid"><strong>입금하실 곳</strong></td>
	<td class="var" style="border-bottom: #ddd 1px solid"><?php echo $moneyCode; ?></td>
</tr>
</tbody>
</table>

<div class="space"></div>

<table rules="none" summary="GR Shop Cash List" cellpadding="0" cellspacing="0" border="0" style="width: 100%; table-layout: fixed">
<caption></caption>
<thead>
<tr>
	<th style="width: 100px">항목</th>
	<th>구매자 정보</th>
</tr>
</thead>
<tbody>
<tr>
	<td class="opt">성 함</td>
	<td class="var"><?php echo $buyer['realname']; ?> 님</td>
</tr>
<tr>
	<td class="opt">전체 적립금</td>
	<td class="var"><input class="lock" type="text" name="total_save_money" value="<?php echo $buyer['save_money']; ?>" readonly="readonly" /> 원</td>
</tr>
<tr>
	<td class="opt">사용할 적립금</td>
	<td class="var"><input type="text" name="use_save_money" value="0" title="<?php echo $buyer['save_money']; ?>" onblur="Cash.checkSaveMoney(this, <?php echo $sendMoney; ?>);" /> 원 (※ 사용할 적립금은 ,콤마 없이 숫자만 입력해주세요!)</td>
</tr>
<tr>
	<td class="opt">우편번호</td>
	<td class="var"><input class="lock" type="text" name="mail_code" value="<?php echo $buyer['mail_code']; ?>" readonly="readonly" onclick="Cash.noInput();" /> <a href="../find.address.php" onclick="window.open(this.href, 'findAddress', 'width=600,height=550,menubar=no,scrollbars=yes'); return false" title="우편번호와 배송지(집주소)는 이 버튼을 클릭하여 찾아보세요!"><img src="<?php echo $cash; ?>/find.mail.code.icon.gif" alt="" /> 우편번호/주소 찾기</a></td>
</tr>
<tr>
	<td class="opt">배송지 (주소)</td>
	<td class="var">
		<input class="lock" type="text" name="address1" value="<?php echo $buyer['address1']; ?>" readonly="readonly" onclick="Cash.noInput();" /> 
		<input type="text" name="address2" value="<?php echo $buyer['address2']; ?>" onclick="Cash.checkInput();" /> (← 나머지 주소 입력)</td>
</tr>
<tr>
	<td class="opt" style="border-bottom: #ddd 1px solid">연락처</td>
	<td class="var" style="border-bottom: #ddd 1px solid">
		집전화: <input type="text" name="home_phone" value="<?php echo $buyer['home_phone']; ?>" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		휴대폰: <input type="text" name="mobile_phone" value="<?php echo $buyer['mobile_phone']; ?>" /></td>
</tr>
</tbody>
</table>

<!-- 구매유형 선택 -->
<div id="chooseBuyType">
	구매유형 선택 ☞ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="radio" value="1" id="buyCard" name="buyType" onclick="Cash.buyCard('<?php echo $bbs_id; ?>', <?php echo $bbs_no; ?>, '<?php echo $cashClass->boardFix; ?>');" /> <label for="buyCard" onclick="Cash.buyCard('<?php echo $bbs_id; ?>', <?php echo $bbs_no; ?>, '<?php echo $cashClass->boardFix; ?>');" title="(주)이지스효성의 올더게이트 전자지불 솔루션을 통해 안전하게 결제 합니다.">신용카드</label> 
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="radio" value="2" id="buyCash" name="buyType" checked="checked" onclick="Cash.buyCash();" /> <label for="buyCash" onclick="Cash.buyCash();" title="무통장입금으로 직거래를 합니다. 입금이 확인되면, 물품을 바로 배송해 드립니다.">무통장입금</label>
</div>

<!-- 안내 메시지 출력부분 -->
<div class="checkAgain">
<strong>※ 구매신청을 하시기 전에, 다시 한번 더 확인해 주세요!</strong><br />
<br />
혹시 배송지를 잘못 적지는 않았는지, 사용할 적립금을 정확히 입력했는지,<br />
구매하고자 하는 상품이 이 상품이 맞는지, 연락처를 수정할 필요는 없는지 등<br />
"신청하기" 버튼을 클릭하시기 전에 다시 한번 전체적으로 입력 항목들을 점검해 주세요.<br />
<br />
점검을 다 하셨다면, 아래 "신청하기" 버튼을 눌러 구매의사를 저희 쪽에 남겨주시면 됩니다.<br />
그 후에 텔레뱅킹/인터넷뱅킹등의 방법으로 <strong><?php echo $moneyCode; ?></strong> 계좌에<br />
<span class="sendMoneyConfirm"><?php echo number_format($sendMoney); ?></span> 원을 입금해 주시면 됩니다.<br />
</div>

<div id="orderNow"><input type="image" src="<?php echo $cash; ?>/order.now.gif" alt="구매신청하기" onmouseover="this.src='<?php echo $cash; ?>/order.now.over.gif'" onmouseout="this.src='<?php echo $cash; ?>/order.now.gif'" title="클릭하시면 위에 작성하신 양식에 맞춰 구매신청서를 남깁니다. 신청 후 입금을 완료하시면 확인 후에 상품을 발송해 드립니다." /></div>

<!-- 신용카드으로 구매시 안내메시지 -->
<div id="buyCardMsg">
<strong>※ 팝업창이 나타나면 해당 팝업창의 안내대로 결제해 주세요!</strong><br />
<br />
전자지불 결제대행 서비스 업체인 <a href="http://www.allthegate.com" onclick="window.open(this.href, '_blank'); return false">(주)이지스효성</a>의 "올더게이트"를 통해서 편리하게 구매하실 수 있습니다.<br />
"신용카드" 를 클릭하시면 나타나는 팝업창에서 안내된 내용에 따라<br />
차근 차근 하나씩 결제를 진행하시면 됩니다.<br />
<br />
결제는 고객님의 컴퓨터가 Windows® 운영체제이고, Internet Explorer® 브라우저를 사용하시는 것으로<br />
가정한 상태에서 진행이 됩니다. 만약 위의 운영체제/브라우저를 사용하시지 않는 고객님들 께서는<br />
"무통장입금" 방식으로 구매신청을 하신 후, 은행에서 입금해 주시면 됩니다.<br />
<br />
팝업창에서 카드 결제를 모두 완료하셨습니까?<br />
<a href="../order/">여기를 클릭</a> 하여 주문이 정상적으로 등록되었는지 확인해 보세요!
</div>

<!-- 무통장입금 구매시 안내메시지 -->
<div id="buyCashMsg">
<strong>※ 구매신청을 하시기 전에, 다시 한번 더 확인해 주세요!</strong><br />
<br />
혹시 배송지를 잘못 적지는 않았는지, 사용할 적립금을 정확히 입력했는지,<br />
구매하고자 하는 상품이 이 상품이 맞는지, 연락처를 수정할 필요는 없는지 등<br />
"신청하기" 버튼을 클릭하시기 전에 다시 한번 전체적으로 입력 항목들을 점검해 주세요.<br />
<br />
점검을 다 하셨다면, 아래 "신청하기" 버튼을 눌러 구매의사를 저희 쪽에 남겨주시면 됩니다.<br />
그 후에 텔레뱅킹/인터넷뱅킹등의 방법으로 <strong><?php echo $moneyCode; ?></strong> 계좌에<br />
<span class="sendMoneyConfirm"><?php echo number_format($sendMoney); ?></span> 원을 입금해 주시면 됩니다.<br />
</div>

</form>

</div>