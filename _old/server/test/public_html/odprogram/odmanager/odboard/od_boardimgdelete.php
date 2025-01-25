<?
	# 2011-01-21 오전 10:50 박종익 수정중
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";

	if(!strcmp($Form,"boardimgDelete")) {
		if($type == "Mmenu1" && file_exists("$folderpath_upload_root/boards/menu/Mboard_menu${serialnum}.jpg"))
			unlink("$folderpath_upload_root/boards/menu/Mboard_menu${serialnum}.jpg");
		else if($type=="Mmenu2" && file_exists("$folderpath_upload_root/boards/menu/Mboard_menu${serialnum}_.jpg")) 
			unlink("$folderpath_upload_root/boards/menu/Mboard_menu${serialnum}_.jpg");
		else if($type=="Cmenu1" && file_exists("$folderpath_upload_root/boards/menu/Cboard_menu${serialnum}.jpg")) 
			unlink("$folderpath_upload_root/boards/menu/Cboard_menu${serialnum}.jpg");
		else if($type=="Cmenu2" && file_exists("$folderpath_upload_root/boards/menu/Cboard_menu${serialnum}_.jpg")) 
			unlink("$folderpath_upload_root/boards/menu/Cboard_menu${serialnum}_.jpg");
		else{ 
			if(file_exists("$folderpath_upload_root/boards/titleimg/title${serialnum}.jpg"))
				unlink("$folderpath_upload_root/boards/titleimg/title$serialnum.jpg");
		}
		
		echo "
			<script name=javascript>
				window.alert('삭제 되었습니다.   ');
			</script>";

		echo "<meta http-equiv='Refresh' content='0; URL=od_boardkindmodify.php?serialnum=$serialnum'>";
		exit;
	}
	else {
		echo "
			<script language=\"javascript\">
				if(confirm(\"정말로 삭제 하시겠습니까?   \"))
					self.location.replace('?Form=boardimgDelete&serialnum=$serialnum&type=$type')
				else
					self.location.replace('od_boardkindmodify.php?serialnum=$serialnum')
			</script>";

		exit;
	}
?>