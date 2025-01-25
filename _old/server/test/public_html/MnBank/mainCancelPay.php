<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href='/css/css01.css' rel="stylesheet" type="text/css">
<?
	// 클라이언트 ip 가져오기
	$ip = $_SERVER['REMOTE_ADDR'];
?>
<title>:::초기페이지:::</title>
<script language="javascript">
<!--
function goCancelCard() {
	var formNm = document.tranMgr;
	
	// TID validation
	if(formNm.TID.value == "") {
		alert("TID를 확인하세요.");
		return;
	}
	else if(formNm.TID.value.length > 30 || formNm.TID.value.length < 30) {
		alert("TID 길이를 확인하세요.");
		return;
	}
	// 취소금액
    if(formNm.CancelAmt.value == "") {
        alert("금액을 입력하세요.");
        return false;
    } else if(formNm.CancelAmt.value.length > 12 ) {
        alert("금액 입력 길이 초과.");
        return false;
    }
	return true;
}

function goCancelInit() {
    var formNm = document.tranMgr;
    
    formNm.TID.value = "";
    formNm.Cancelpw.value = "";
    formNm.CancelAmt.value = "";
    formNm.CancelMSG.value = "";
    
    return false;
}
-->
</script>
</head>
<body>
<form name="tranMgr" method="post" action="http://pg.mnbank.co.kr/cancel/payCancelProcess.jsp">
<table align="left">
	<tr>
		<td>
			<table width="475" border="0" align="center"  cellpadding="0" cellspacing="0" bordercolor="#cccccc" style="border-collapse:collapse;">
				<tr>
					<td><img src="images/bar02.gif" width="213" height="37"></td>
				</tr>
			</table>
			<table width="475" border="1" align="center"  cellpadding="0" cellspacing="0" bordercolor="#cccccc" style="border-collapse:collapse;">
				<tr height="25">
					<td class="sTblTc">TID</td>
					<td class="TblTitA">
						<input name="TID" maxlength="30" size="30" value="">
					</td>
				</tr>
				<tr height="25">
					<td class="sTblTc">취소패스워드</td>
					<td class="TblTitA">
						<input type="password" name="Cancelpw" size="20" value="">
					</td>
				</tr>
				<tr height="25">
					<td class="sTblTc">취소금액</td>
					<td class="TblTitA">
						<input name="CancelAmt" size="20" value="">
					</td>
				</tr>
				<tr height="25">
					<td class="sTblTc">취소사유</td>
					<td class="TblTitA">
						<input name="CancelMSG" size="20" value="고객요청">
					</td>
				</tr>
				<tr height="25" align="scenter">
					<td colspan="2" class="sTblTc">
					    <input name="submit22224" type="submit" class="mmtnL03c" value="확인" onClick="return goCancelCard();">
					    &nbsp;&nbsp;
                        <input name="submit22224" type="submit" class="mmtnL03c" value="초기화" onClick="return goCancelInit();">
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<input type="hidden" name="cc_ip" size="20" value="<?=$ip?>">
<input type="hidden" name="ReturnURL" value="/MnBank/returnCancelPay.php">
</form>

</body>
</html>
