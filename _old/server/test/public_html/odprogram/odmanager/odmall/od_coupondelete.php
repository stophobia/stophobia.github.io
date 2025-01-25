<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";

	## 세부권한 체크
	if($row_admin[basicLevel]==5 || $row_admin[superLevel]==9) {
	}
	else {
		error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
	}
	
	if(!strcmp($Form,"deleteForm")) {
		$deleteExplode = explode("/",$serialnum);
		
		for($i=0;$i<count($deleteExplode)-1;$i++) {
			if($deleteExplode[$i]){
				## 쿠폰이미지 삭제막음, 해당 쿠폰이 적용된 상품들 쿠폰적용 해제 후 쿠폰삭제 시작
				$row = mysql_fetch_array(mysql_query("SELECT number FROM odtCoupon WHERE serialnum='$deleteExplode[$i]'"));
				
				//unlink("$folderpath_upload_root/coupons/$row[number].jpg");

				if($row[number]){
					$qry8 = "update odtProduct set couponnumber='' where couponnumber='$row[number]'";
					$res8 = mysql_query($qry8);

					if($res8){
						mysql_query("DELETE FROM odtCoupon WHERE serialnum='$deleteExplode[$i]'");
					}
				}
				## 쿠폰이미지 삭제막음, 해당 쿠폰이 적용된 상품들 쿠폰적용 해제 후 쿠폰삭제 끝
			}
		}
		
		echo "
			<script name=javascript>
				window.alert('성공적으로 삭제 되었습니다.   ');
			</script>";
		
		echo "<meta http-equiv='Refresh' content='0; URL=od_coupon.php?page=$page&search=$search&key=$key'>";
		exit;
	}
	else {
		for ($i=0;$i<sizeof($serialnum);$i++) $deleteSerialnum .= $serialnum[$i]."/";
		
		echo "
			<script language=\"javascript\">
				if(confirm('\\n선택하신 쿠폰을 삭제하셔도 이미 발급된 쿠폰은 삭제되지 않습니다.   \\n\\n정말로 선택하신 쿠폰을 삭제 하시겠습니까?   \\n'))
					self.location.replace('?Form=deleteForm&serialnum=$deleteSerialnum&page=$page&search=$search&key=$key')
				else
					self.location.replace('od_coupon.php?page=$page&search=$search&key=$key')
			</script>";
		
		exit;
	}
?>