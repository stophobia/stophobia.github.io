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
		mysql_query("DELETE FROM odtImage WHERE serialnum='$serialnum'");
		
		if(file_exists("$folderpath_upload_root/banner/$iname")) unlink("$folderpath_upload_root/banner/$iname");
		
		mysql_query("UPDATE odtImage SET lineUp=lineUp-1 WHERE location='$dlocation' AND lineUp>'$pLineUp'");
		
		echo "
			<script name=javascript>
				window.alert('성공적으로 삭제 되었습니다.   ');
			</script>";

		echo "<meta http-equiv='Refresh' content='0; URL=od_banner.php?location=$location'>";
		exit;
	}
	else {
		echo "
			<script language=\"javascript\">
				if(confirm(\"선택하신 데이타를 정말로 삭제 하시겠습니까?   \"))
					self.location.replace('?Form=deleteForm&serialnum=$serialnum&iname=$iname&dlocation=$dlocation&pLineUp=$pLineUp&location=$location')
				else
					self.location.replace('od_image.php?location=$location')
			</script>";

		exit;
	}
?>