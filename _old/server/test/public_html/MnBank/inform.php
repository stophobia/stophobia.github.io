<?
	$PayMethod		= $_REQUEST['PayMethod'];
	$MID			= $_REQUEST['MID'];
	$Amt			= $_REQUEST['Amt'];
	$GoodsName		= $_REQUEST['GoodsName'];
	$OID			= $_REQUEST['OID'];
	$AuthDate		= $_REQUEST['AuthDate'];
	$AuthCode		= $_REQUEST['AuthCode'];
	$ResultCode		= $_REQUEST['ResultCode'];
	$ResultMsg		= $_REQUEST['ResultMsg'];
	$stateCd                  = $_REQUEST['state_cd'];   // 0: 결제승인, 1:전취소, 2:후취소
	
	// 결제 승인 
	if("0" == $stateCd){
	  if("3001" == $ResultCode){
	     // 결제 성공시 DB처리 하세요.
	  }else{
	     // 결제 실패시 DB처리 하세요.
	  }
	}else{
	// 결제 취소
	  if("2001" == $ResultCode){
	     // 취소 성공시 DB처리 하세요.
	  }else{
	     // 취소 실패시 DB처리 하세요.
	  }
	
	
	} 
	
	
?>
<?=$PayMethod . '<br>'?>
<?=$MID . '<br>'?>
<?=$Amt . '<br>'?>
<?=$GoodsName . '<br>'?>
<?=$OID . '<br>'?>
<?=$AuthDate . '<br>'?>
<?=$AuthCode . '<br>'?>
<?=$ResultCode . '<br>'?>
<?=$ResultMsg . '<br>'?>
