<?
## 무통장 입금 정보를 sms로 발송
if($orderhtel1 && $orderhtel2 && $orderhtel3) {
	$tran_phone			= $orderhtel1 ."-". $orderhtel2 ."-". $orderhtel3;
	$tran_callback	= $_companySetup[tel];
	$tran_msg				=	"주문하신상품이 발송되었습니다. 택배번호: ".$expressnumTmp." (".$expressnameTmp.")";	

	$smsQue = "insert into em_tran set tran_phone = '".$tran_phone."', tran_callback = '".$tran_callback."', tran_msg= '".$tran_msg."', tran_status = 1, tran_date = now()";
	mysql_query($smsQue);
}

?>