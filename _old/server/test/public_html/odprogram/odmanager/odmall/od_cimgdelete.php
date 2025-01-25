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
	
	if(!strcmp($Form,"imgDelete")) {
		## 해당 상품 이미지를 삭제한다. ####################
		if(file_exists("$folderpath_upload_root/company/$iname")) unlink("$folderpath_upload_root/company/$iname");
		
		echo "
			<script name=javascript>
				window.alert('삭제 되었습니다.   ')
			</script>";

		echo "<meta http-equiv='Refresh' content='0; URL=company'>";
		exit;
	}
	else {
		echo "
			<script language=\"javascript\">
				if(confirm(\"선택하신 이미지를 삭제 하시겠습니까?   \"))
					self.location.replace('?Form=imgDelete&iname=$iname')
				else
					self.location.replace('od_company.php')
			</script>";

		exit;
	}
?>