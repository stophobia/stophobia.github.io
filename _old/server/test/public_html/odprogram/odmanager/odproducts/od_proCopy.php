<?
	include "../../odcommon/od_config.inc.php";
	include "../odcommon/od_function.inc.php";		
	include "../odcommon/od_adminAuthority.inc.php";
	include "../odcommon/od_head.inc.php";
	include "../odcommon/od_body.inc.php";

	## 세부권한 체크
	if($row_admin[productLevel] < 3) {
		error_msgloc("../","접근권한이 없습니다.   ");
	}

	 = mysql_fetch_array(mysql_query("select * from odtProduct where code ='".$_GET[code]."'"));

	if([customerCode] == "onedaynet") {
		error_msgall('상품공급서포트로 등록된 상품은 복사하실수 없습니다.','close');
		exit;
	}

	## 코드 생성.
	$random = rand(10000,99999);
	$sumTme = (time(Y)+time(m)+time(d)+time(H)+time(i)+time(s)+19)*997;
	$sumTempLength = strlen($sumTme);
	$checkSum = substr($sumTme,$sumTempLength-2,2);
	$code = "S".$checkSum.$random;

?>
<script>
// 현재 선택한 카테고리와 날짜를 체크하여 메인상품인지 서브상품인지 체크
function mainOrSubCheck() {
	frm = document.snsForm;
	hidden_frame.location.href="./mainOrSubCheck2.php?cateCode="+frm.cateCode.value+"&sale_date="+frm.sale_date.value;
}
</script>
<iframe name="hidden_frame" src="about:blank" width=300 height=300 style="display:none;" frameborder=0></iframe>
<form name="snsForm" method="post" action="proCopyPro.php">
<input type="hidden" name="cateCode" value="<?=[cateCode]?>">
<input type="hidden" name="orgCode" value="<?=[code]?>">
<input type="hidden" name="code" value="<?=$code?>">
<?
if([parent_code] == [code]) {
?>
<a href="od_proCopy.php?code=<?=$_GET[code]?>">[개별복사] - 해당상품만 복사</a><br>
<a href="od_proAllCopy.php?code=<?=$_GET[code]?>">[전체복사] - 서브상품까지 복사</a>  (이미지까지 복사)
<?
}
?>
<input type="hidden" name="parent_code" value="<?=$code?>">
<table border=0 cellpadding=0 cellspacing=0 width=100%>
	<tr>
		<td height=40 colspan=2 align=center style="font-size:20px;font-weight:bold">상품 개별 복사</td>
	</tr>
	<tr>
		<td height=40 align=center width=100> 상품방송일</td>
		<td>
			<input id='ipt01' type="text" name=sale_date size=10 class="border" readonly style="cursor:pointer" value="<?=[sale_date] ? [sale_date] : date('Y-m-d');?>" onchange="mainOrSubCheck();"><br>
			<span id="pro_type" style="color:red"></span>
			<script>var cal1 = new jsCalendar(document.getElementById('ipt01'));</script>
		</td>
	</tr>
	<tr>
		<td height=40 align=center width=100> 상품이름</td>
		<td>
			<input  type="text" name=name size=30 class="border" value="<?=[name]?>" ><br>
		</td>
	</tr>
	<tr>
		<td height=40 align=center width=100> 공급가</td>
		<td>
			<input  type="text" name=purPrice size=10 class="border" value="<?=[purPrice]?>" >
		</td>
	</tr>
	<tr>
		<td height=40 align=center width=100> 판매가</td>
		<td>
			<input  type="text" name=price size=10 class="border" value="<?=[price]?>" >
		</td>
	</tr>
	<tr>
		<td height=40 align=center width=100> 판매수량</td>
		<td>
			<input  type="text" name=stock size=7 class="border" value="<?=[stock]?>" >  
			구매가능한 갯수 <input  type="text" name=buy_limit size=3 class="border" value="<?=[buy_limit]?>" >  

		</td>
	</tr>
	<tr>
		<td height=40 align=center width=100> 쿠폰할인가</td>
		<td>
			<input  type="text" name=coupon_sale size=10 class="border" value="<?=[coupon_sale]?>" >  
		</td>
	</tr>
	<tr>
		<td height=40 align=center width=100> 생방할인가</td>
		<td>
			<input  type="text" name=live_sale size=10 class="border" value="<?=[live_sale]?>" >  
		</td>
	</tr>
	<tr>
		<td colspan=2 align=center height=40><input type="submit" value="  복  사  " class="border"> <input type="button" value= "  닫  기  " onclick="self.close()" class="border">
		</td>
	</tr>
</table>
</form>
<script>
//메인인지 서브인지 체크
mainOrSubCheck();
</script>
