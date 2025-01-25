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

?>
<script>
// 현재 선택한 카테고리와 날짜를 체크하여 메인상품인지 서브상품인지 체크
function mainOrSubCheck() {
	frm = document.snsForm;
	hidden_frame.location.href="./mainOrSubCheck3.php?cateCode="+frm.cateCode.value+"&sale_date="+frm.sale_date.value;
}
</script>
<iframe name="hidden_frame" src="about:blank" width=300 height=300 style="display:none;" frameborder=0></iframe>
<form name="snsForm" method="post" action="proAllCopyPro.php">
<input type="hidden" name="orgCode" value="<?=[code]?>">
<?
if([parent_code] == [code]) {
?>
<a href="od_proCopy.php?code=<?=$_GET[code]?>">[개별복사] - 해당상품만 복사</a><br>
<a href="od_proAllCopy.php?code=<?=$_GET[code]?>">[전체복사] - 서브상품까지 복사</a> (이미지까지 복사)
<?
}
?>
<input type="hidden" name="parent_code" value="<?=$code?>">
<table border=0 cellpadding=0 cellspacing=0 width=100%>
	<tr>
		<td height=40 colspan=2 align=center style="font-size:20px;font-weight:bold">상품 전체 복사</td>
	</tr>
	<tr>
		<td height=40 align=center width=100> 카테고리</td>
		<td>
																	<img src="blank.gif" width="1" height="1"><select name="cateCode" class="border" onchange="mainOrSubCheck();">
<?
$res3 = mysql_query("select * from odtCategory");
while($row3 = mysql_fetch_array($res3)) {
?>
																		<option value="<?=$row3[catecode]?>" <?=[cateCode] == $row3[catecode] ? "selected" : NULL;?>><?=$row3[catename]?></option>
<?
}
?>
																	</select>
		</td>
	</tr>
	<tr>
		<td height=40 align=center width=100> 상품판매일</td>
		<td>
			<input id='ipt01' type="text" name=sale_date size=10 class="border" readonly style="cursor:pointer" value="<?=[sale_date] ? [sale_date] : date('Y-m-d');?>" onchange="mainOrSubCheck();"><br>
			<span id="pro_type" style="color:red"></span>
			<script>var cal1 = new jsCalendar(document.getElementById('ipt01'));</script>
		</td>
	</tr>
	<tr>
		<td height=40 align=center width=100> 상품이름</td>
		<td><?=[mainName]?><br>
		</td>
	</tr>
	<tr>
		<td height=40 align=center width=100> 토크복사</td>
		<td><input type="checkbox" name="talkCopy" value="1"> 복사<br>
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
