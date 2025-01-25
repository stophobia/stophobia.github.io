<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";

	## 접근권한 설정
	if($row_admin[productLevel] == 7 || $row_admin[productLevel] == 9 || $row_admin[superLevel]==9) {
	}
	else {
		error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
	}
	
	if(!strcmp($Form,"deleteForm")) {
		$deleteExplode = explode("/",$serialnum);
		
		for($i=0;$i<count($deleteExplode)-1;$i++) {
			if($deleteExplode[$i]){
				mysql_query("DELETE FROM odtMember WHERE serialnum='$deleteExplode[$i]'");
			}
		}

		echo "
			<script name=javascript>
				window.alert('성공적으로 삭제 되었습니다.   ');
			</script>";

		echo "<meta http-equiv='Refresh' content='0; URL=od_list.php?page=$page&search=$search&key=$key'>";
		exit;
	}
	else {
		for ($i=0;$i<sizeof($serialnum);$i++) $deleteSerialnum .= $serialnum[$i]."/";
		
		echo "
			<script language=\"javascript\">
				if(confirm(\"선택하신 데이타를 정말로 삭제 하시겠습니까?   \"))
					self.location.replace('?Form=deleteForm&serialnum=$deleteSerialnum&page=$page&search=$search&key=$key')
				else
					self.location.replace('od_list.php?page=$page&search=$search&key=$key')
			</script>";

		exit;
	}
?>