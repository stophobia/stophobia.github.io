<?

	$todayTimeStemp = time();
	$canceldateTimeStemp = $todayTimeStemp - ($row_setup[deleteterm] * 86400);
	
	## 주문취소일을 기준으로 신용카드 주문 중 승인실패인 주문내역 삭제 #######
	mysql_query("DELETE FROM odtOrder WHERE paystatus='N' AND orderdate < '$canceldateTimeStemp' AND orderstatus='N'");
	
	## 주문취소일을 기준으로 결제확인이 되지않은 주문내역 취소 처리 #######
	$result_CHK = mysql_query("SELECT ordernum FROM odtOrder WHERE paystatus='N' AND orderdate < '$canceldateTimeStemp' AND canceled='N' AND orderstatus='Y' ORDER BY serialnum ASC");
	
	while($row_CHK = mysql_fetch_array($result_CHK)) {
		## 취소된 주문수량만큼 상품 재고량을 환원 시킨다. ##################################################
		$ProUpResult = mysql_query("SELECT procode,salestock FROM odtCart WHERE ordernum='$row_CHK[ordernum]'");
		
		while($ProUpRow = mysql_fetch_array($ProUpResult)) {
			mysql_query("UPDATE odtProduct SET stock=stock+$ProUpRow[salestock],salenum=salenum-$ProUpRow[salestock] WHERE code='$ProUpRow[procode]'");
		}

		## 장바구니 및 주문테이블에서 해당 주문정보에 대해 취소처리를 한다. ##################################
		mysql_query("UPDATE odtOrder SET canceled='Y',canceldate='$todayTimeStemp' WHERE ordernum='$row_CHK[ordernum]'");
		mysql_query("UPDATE odtCart SET initial='Y',initdate=now() WHERE ordernum='$row_CHK[ordernum]'");
	}
?>