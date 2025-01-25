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
	
	$num = $cin - 1;
	
	for($i=1;$i<=$num;$i++) {
		if(${"Icheck$i"} == "yes") $checkTemp = "yes";
		else $checkTemp = "no";

		mysql_query("UPDATE odtImage SET Icheck='$checkTemp' WHERE serialnum='${"serialnum$i"}'");
	}

	echo "
		<script>
			window.alert('\\n선택하신 이미지로 지정이 잘 되었습니다.   \\n');
		</script>";

	echo "<meta http-equiv='Refresh' content='0; URL=od_image.php?location=$location'>";
	exit;
?>