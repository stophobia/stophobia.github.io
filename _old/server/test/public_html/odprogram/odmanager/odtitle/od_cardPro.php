<?
	include "../../odcommon/od_config.inc.php";
	include "../../odcommon/od_lib.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";

	## 세부권한 체크
	if($row_admin[memberLevel] < 3) {
		error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
	}

	switch($subMode) {
		case "ins" :
			$name				= $_POST[name];

			$res = mysql_query("insert into odtCardTitle set
													name		= '".$name."'");

			if(!$res) {
				error_msgall('오류가 발생하였습니다.');
				echo mysql_error();
				exit;
			}
			break;

		case "edt" :
			$no				= $_POST[no];
			$name				= $_POST[name];

			$res = mysql_query("update odtCardTitle set
													name		= '".$name."'
													where
													no			= '".$no."'");

			if(!$res) {
				error_msgall('오류가 발생하였습니다.');
				echo mysql_error();
				exit;
			}
			break;

		case "del" :
			$noArray				= $_POST[noArray];
			
			for($i=0;$i<count($noArray);$i++) {
				$res = mysql_query("delete from odtCardTitle where no = '".$noArray[$i]."'");
			}

			if(!$res) {
				error_msgall('오류가 발생하였습니다.');
				echo mysql_error();
				exit;
			}

			break;
	}
?>
<script>
parent.location.reload();
</script>