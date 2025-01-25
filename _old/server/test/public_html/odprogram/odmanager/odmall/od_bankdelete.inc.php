<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";
	
	if(!strcmp($Form,"deleteForm")) {
		$result = mysql_query("DELETE FROM odtBank WHERE serialnum='$sn'");
		
		if($result) {
			echo "
				<script>
					window.alert('삭제가 잘 되었습니다.   ');
				</script>";

			echo "<meta http-equiv='Refresh' content='0; URL=od_pay.php#bank'>";
			exit;
		}
		else {
			echo "
				<script>
					window.alert('결제 계좌정보가 삭제되지 않았습니다.   ');
					self.location.replace('od_pay.php#bank');
				</script>";
			exit;
		}
	}
	else {
		echo "
			<script language=\"javascript\">
				if(confirm(\"선택하신 결제계좌정보를 삭제 하시겠습니까?   \")) {
					self.location.replace('od_bankdelete.inc.php?Form=deleteForm&sn=$sn')
				}else {
					self.location.replace('od_pay.php#bank')
				}
			</script>";

		exit;
	}
?>