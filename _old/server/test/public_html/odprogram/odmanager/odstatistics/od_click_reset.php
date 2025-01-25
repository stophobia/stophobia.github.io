<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";

	if(!strcmp($Form,"resetClick")) {
		$UpQuery = "UPDATE odtProduct SET clicknum = '0'";
		$UpResult = mysql_query($UpQuery);
		
		if(!$UpResult) {
			echo "
				<script>
					window.alert('데이타 초기화에 실패하였습니다.   ');
					history.go(-1);
				</script>";

			exit;
		}
		else {
			echo "
				<script>
					window.alert('성공적으로 초기화 되었습니다.   ');
				</script>";

			echo "<meta http-equiv='Refresh' content='0; URL=od_click.php?listView=$listView'>";
			exit;
		}
	}
	else {
		echo "
			<script language=\"javascript\">
				if(confirm(\"통계 데이타의 초기화를 진행 하시겠습니까?  \"))
					self.location.replace('?Form=resetClick&listView=$listView')
				else
					self.location.replace('od_click.php?listView=$listView')
			</script>";

		exit;
	}
?>