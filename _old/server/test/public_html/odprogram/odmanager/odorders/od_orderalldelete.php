<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";

	chk_authfree();


	## 접근권한 설정(삭제)
	if($row_admin[orderLevel] == 7 || $row_admin[orderLevel] == 9 || $row_admin[superLevel]==9) {
	}
	else {
		error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
	}
	
	if($PageL == "All") {
		$PageURL = "od_orderslist.php";
		$guideTemp = " 상품의 재고량 환원 및 회원의 사용한 적립금 환원을 원하실 경우     \\n\\n 먼저 취소처리 후 삭제해 주시기 바랍니다.     \\n\\n";
	}
	else if($PageL == "Cancel") {
		$PageURL = "od_orderslistCancel.php";
		$guideTemp = "";
	}
	else {
		$PageURL = "od_orderslist.php";
		$guideTemp = " 상품의 재고량 환원 및 회원의 사용한 적립금 환원을 원하실 경우     \\n\\n 먼저 취소처리 후 삭제해 주시기 바랍니다.     \\n\\n";
	}
	
	## 페이지링크 PAR 정리 ############################################
	if($search) $par_page .= "&search=$search";
	if($key) $par_page .= "&key=$key";
	if($paymethod) $par_page .= "&paymethod=$paymethod";
	if($paystatus) $par_page .= "&paystatus=$paystatus";
	if($delivstatus) $par_page .= "&delivstatus=$delivstatus";
	if($start_date && $end_date) $par_page .= "&start_date=$start_date&end_date=$end_date";
	if($date_term) $par_page .= "&date_term=$date_term";
	if($search_standard) $par_page .= "&search_standard=$search_standard";
	if($order_by) $par_page .= "&order_by=$order_by";
	if($order_by_rule) $par_page .= "&order_by_rule=$order_by_rule";
	if($search_value_) $par_page .= "&search_value_=$search_value_";
	if($page_number) $par_page .= "&page_number=$page_number";
    if($order_type) $par_page .= "&order_type=$order_type";
	
	if(!strcmp($Form,"OrderAllDelete")) {
		$order_all_delete_Division = explode("/",$OrderNum);
		$order_all_delete_Total = count($order_all_delete_Division);
		$order_all_delete_Total = $order_all_delete_Total - 1;
		
		for($i = 0; $i < $order_all_delete_Total; $i++) {
			if($order_all_delete_Division[$i]){
				## 주문정보 삭제
				mysql_query("DELETE FROM odtOrder WHERE ordernum='$order_all_delete_Division[$i]'");
				
				## G포인트 지급 취소
				mysql_query("delete from odtPointLog where ordernum != '' and ordernum ='".$order_all_delete_Division[$i]."'");
			}
		}

		echo "
			<script name=javascript>
				window.alert('삭제 되었습니다.   ');
			</script>";

		echo "<meta http-equiv='Refresh' content='0; URL=$PageURL?page=$page$par_page'>";
	}
	else {
		for ($i=0;$i<sizeof($OrderNum);$i++) $ordernum_del .= $OrderNum[$i]."/";

		echo "
			<script language=\"javascript\">
				if(confirm(\"$guideTemp 선택하신 주문내역을 정말로 삭제 하시겠습니까?     \"))
					self.location.replace('?Form=OrderAllDelete&OrderNum=$ordernum_del&PageL=$PageL&page=$page$par_page')
				else
					self.location.replace('$PageURL?page=$page$par_page')
			</script>";

		exit;
	}
?>