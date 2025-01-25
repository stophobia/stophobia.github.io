
<script language="javascript">
var help_doc = new Array(5);
// 배송비면제상품 안내
help_doc[0] = "<font color='313D7D'>&nbsp;* 배송비 면제 상품으로 지정할 경우 본 상품이 포함된 주문에 대한 배송료가 면제 됩니다.<br><img src='blank.gif' width='1' height='3'><br>&nbsp;* 배송비 면제 상품으로 지정하시면 무료배송 아이콘(<img src='<?=$folderpath_upload?>/odicons/delivery.gif' align='absmiddle' border='0'>)이 상품정보에 표시되며,<br><img src='blank.gif' width='15' height='1'>무료배송 아이콘은 [<b>상점기본관리→상점기본정보설정→상품아이콘설정</b>]에서 변경할 수 있습니다.</font>";
// 상품위치 안내
help_doc[1] = "<font color='313D7D'>&nbsp;* 각 위치는 중복으로 지정할 수 있으며, 이벤트 위치로 지정할 경우 이벤트 이미지를 첨부하셔야 합니다.<br><img src='blank.gif' width='1' height='3'><br>&nbsp;* 메인페이지에 위치를 지정하지 않으실 경우에는 선택하지 않으시면 됩니다.</font>";
// MD추천상품 안내
help_doc[2] = "<font color='313D7D'>&nbsp;* MD추천 상품으로 지정하시면 MD추천 아이콘(<img src='<?=$folderpath_upload?>/odicons/md.gif' align='absmiddle' border='0'>)이 상품정보에 표시되며,<br><img src='blank.gif' width='1' height='3'><br><img src='blank.gif' width='15' height='1'>MD추천 아이콘은 [<b>상점기본관리→상점기본정보설정→상품아이콘설정</b>]에서 변경할 수 있습니다.</font>";
// 상품 항목1 안내
help_doc[3] = "<font color='313D7D'>&nbsp;* 타이틀명은 \"<b>상점기본관리→상품관련기본설정</b>\"에서 지정한 타이틀명이 우선으로 보여집니다.<br><img src='blank.gif' width='1' height='3'><br>&nbsp;* 기본으로 지정한 타이틀명과 틀리게 보여지게 하고 싶은 경우에만 입력해 주세요.</font>";
// 상품 항목2 안내
help_doc[4] = "<font color='313D7D'>&nbsp;* 타이틀명은 \"<b>상점기본관리→상품관련기본설정</b>\"에서 지정한 타이틀명이 우선으로 보여집니다.<br><img src='blank.gif' width='1' height='3'><br>&nbsp;* 기본으로 지정한 타이틀명과 틀리게 보여지게 하고 싶은 경우에만 입력해 주세요.</font>";
// 후불제상품 안내
help_doc[5] = "<font color='313D7D'>&nbsp;* 후불제 정책을 사용하실 경우 후불제 상품으로 지정된 상품은 고객이 상품 수령 후 결제하게 됩니다.<br><img src='blank.gif' width='1' height='3'><br>&nbsp;* 후불제 상품으로 지정함에 체크하시면 후불제 아이콘(<img src='<?=$folderpath_upload?>/odicons/card.gif' align='absmiddle' border='0'>)이 상품정보에 표시되며,<br><img src='blank.gif' width='1' height='3'><br><img src='blank.gif' width='15' height='1'>후불제 아이콘은 <b>[상점기본관리→상점기본정보설정→상품아이콘설정]</b>에서 변경할 수 있습니다.</font>";
// 예약상품 안내
help_doc[6] = "<font color='313D7D'>&nbsp;* 예약 상품으로 지정하실 경우 상품 대금을 미리 받고 상품이 입고된 후에 상품을 배송하게 됩니다.<br><img src='blank.gif' width='1' height='3'><br>&nbsp;* 예약 상품으로 지정하실 경우 예약상품에 대한 배송정책은 [<b>상점기본관리→배송정보설정</b>]에서 지정하실 수 있습니다.<br><img src='blank.gif' width='1' height='3'><br>&nbsp;* 예약 상품으로 지정함에 체크하시면 예약상품 아이콘(<img src='<?=$folderpath_upload?>/odicons/pree.gif' align='absmiddle' border='0'>)이 상품정보에 표시되며,<br><img src='blank.gif' width='1' height='3'><br><img src='blank.gif' width='15' height='1'>예약상품 아이콘은 [<b>상점기본관리→상점기본정보설정→상품아이콘설정</b>]에서 변경할 수 있습니다.</font>";
// 즉석쿠폰 안내
help_doc[7] = "<font color='313D7D'>&nbsp;* 즉석쿠폰을 사용하실 경우 주문시 바로 할인 혜택을 제공할 수 있습니다.<br><img src='blank.gif' width='1' height='3'><br>&nbsp;* 즉석쿠폰 사용함에 체크하시면 즉적쿠폰 아이콘(<img src='<?=$folderpath_upload?>/odicons/coupon.gif' align='absmiddle' border='0'>)이 상품정보에 표시되며,<br><img src='blank.gif' width='1' height='3'><br><img src='blank.gif' width='15' height='1'>즉석쿠폰 아이콘은 [<b>상점기본관리→상점기본정보설정→상품아이콘설정</b>]에서 변경할 수 있습니다.</font>";
// 제공쿠폰 안내
help_doc[8] = "<font color='313D7D'>&nbsp;* 본 상품을 구매시 제공할 쿠폰을 선택해 주세요. (사용하지 않으실 경우에는 선택하지 않으시면 됩니다.)<br><img src='blank.gif' width='1' height='3'><br>&nbsp;* 쿠폰을 제공하게 되면 쿠폰제공 아이콘(<img src='<?=$folderpath_upload?>/odicons/pcoupon.gif' align='absmiddle' border='0'>)이 상품정보에 표시됩니다.<br><img src='blank.gif' width='1' height='3'><br><img src='blank.gif' width='15' height='1'>쿠폰제공 아이콘은 [<b>상점기본관리→상점기본정보설정→상품아이콘설정</b>]에서 변경할 수 있습니다.</font>";
// 할인된 금액 절사기준 설정
help_doc[9] = "<font color='313D7D'>&nbsp;* 할인된 가격이 32,753원인 상품의 가격을 각각의 반올림한 경우의 가격입니다.<br><img src='blank.gif' width='1' height='3'><br><img src='blank.gif' width='15' height='1'>- <b>십원</b>단위에서 반올림한 경우 32,750원이 됩니다.<br><img src='blank.gif' width='1' height='3'><br><img src='blank.gif' width='15' height='1'>- <b>백원</b>단위에서 반올림한 경우 32,800원이 됩니다.<br><img src='blank.gif' width='1' height='3'><br><img src='blank.gif' width='15' height='1'>- <b>천원</b>단위에서 반올림한 경우 33,000원이 됩니다.</font>";
// 재고량 안내
help_doc[10] = "<font color='313D7D'>&nbsp;* 상품의 재고량이 0인 경우에는 일시품절 아이콘(<img src='<?=$folderpath_upload?>/odicons/none.gif' align='absmiddle' border='0'>)이 상품정보에 표시되며,<br><img src='blank.gif' width='1' height='3'><br><img src='blank.gif' width='15' height='1'>일시품절 아이콘은 [<b>상점기본관리→상점기본정보설정→상품아이콘설정</b>]에서 변경할 수 있습니다.</font>";
function hidden_help() {
	if(document.all.help_layer.style.display =="block") {
		document.all.help_layer.style.display="none";
		document.all.help_doc.innerHTML = "";

		document.all.help_layer.style.top = 0;
		document.all.help_layer.style.left = 0;
	}
}
function show_help(num) {
	x = (document.layers) ? e.pageX : document.body.scrollLeft+event.clientX;
	y = (document.layers) ? e.pageY : document.body.scrollTop+event.clientY;
	document.all.help_layer.style.top = y + 15;
	document.all.help_layer.style.left = x - 430;
	document.all.help_layer.style.display="block";
	document.all.help_doc.innerHTML = eval("help_doc["+num+"]");
}
document.onmouseup = hidden_help;
</script>

<!--  도움말 레이어  -->
<div id="help_layer" style="position:absolute;z-index:3;top:0;left:0;display:none">
<table border='0' cellpadding='2' cellspacing='3' bgcolor="#7B7B7B">
  <tr>
    <td nowrap bgcolor="#FFFFFF" style="padding:7;"><font id="help_doc"></font></td>
  </tr>
</table>
</div>
<!--  도움말 레이어  -->
