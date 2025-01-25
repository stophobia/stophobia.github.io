<?
	$PayMethod			= $_REQUEST['PayMethod'];
	$MID				= $_REQUEST['MID'];
	$Amt				= $_REQUEST['Amt'];
	$name				= $_REQUEST['name'];
	$GoodsName			= $_REQUEST['GoodsName'];
	$OID				= $_REQUEST['OID'];
	$AuthDate			= $_REQUEST['AuthDate'];
	$AuthCode			= $_REQUEST['AuthCode'];
	$ResultCode			= $_REQUEST['ResultCode'];
	$ResultMsg			= $_REQUEST['ResultMsg'];
	$VbankNum			= $_REQUEST['VbankNum'];
	$MallReserved	    = $_REQUEST['MallReserved'];
	
	
	if("3001" == $ResultCode){
	   // 결제 성공시 DB처리 하세요.
	}else{
	   // 결제 실패시 DB처리 하세요.
	}
?>
<?=$PayMethod . '<br>'?>
<?=$MID . '<br>'?>
<?=$Amt . '<br>'?>
<?=$name . '<br>'?>
<?=$GoodsName . '<br>'?>
<?=$OID . '<br>'?>
<?=$AuthDate . '<br>'?>
<?=$AuthCode . '<br>'?>
<?=$ResultCode . '<br>'?>
<?=$ResultMsg . '<br>'?>
<?=$VbankNum . '<br>'?>
<?=$MallReserved . '<br>'?>
