<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";

	// 세부권한 체크
	if($row_admin[basicLevel]==5 || $row_admin[superLevel]==9) {
	}
	else {
		error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
	}
	
	if(!strcmp($Form,"deleteForm")) {
		$crow = mysql_fetch_array(mysql_query("SELECT * FROM odtCouponHistory WHERE serialnum='$serialnum'"));
		
		if($crow[status] == "yes") {	// 쿠폰이 발급된 상태라면 해당 회원의 적립금에서 쿠폰 금액만큼 적립금 회수
			mysql_query("UPDATE odtMember SET point=point-$crow[price] WHERE id='$crow[id]'");
		}

		mysql_query("DELETE FROM odtCouponHistory WHERE serialnum='$serialnum'");
		mysql_query("UPDATE odtCouponHistory SET couponstatus='no',status='no',statusdate='0' WHERE serialnum='$serialnum'");
		
		echo "
			<script name=javascript>
				window.alert('쿠폰회수 작업이 잘 되었습니다.   ');
			</script>";

		echo "<meta http-equiv='Refresh' content='0; URL=od_couponhistory.php?cnumber=$cnumber&page=$page&search=$search&key=$key'>";
		exit;
	}
	else {
		echo "
			<script language=\"javascript\">
				if(confirm('\\n선택하시 쿠폰에 대해 정말로 쿠폰회수 작업을 진행 하시겠습니까?   \\n'))
					self.location.replace('?Form=deleteForm&serialnum=$serialnum&cnumber=$cnumber&page=$page&search=$search&key=$key')
				else
					self.location.replace('od_couponhistory.php?cnumber=$cnumber&page=$page&search=$search&key=$key')
			</script>";

		exit;
	}
?>