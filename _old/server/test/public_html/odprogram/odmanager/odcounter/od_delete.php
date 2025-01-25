<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";

	// 세부권한 체크
	if($row_admin[superLevel]==9) {
	}
	else {
		error_msgloc("$folderpath_manager/","슈퍼관리자만 방문로그 자료를 초기화 하실 수 있습니다.   ");
	}
	
	if(!strcmp($Form,"DataDelete")) {
		if($mode == "ROUTE") {
			## 접속경로 데이타를 삭제한다. ###################################
			mysql_query("DELETE FROM odtCounterRoute");
			
			echo "
				<script>
					window.alert('접속경로 데이타가 모두 삭제되었습니다. ');
				</script>";
		}
		else if($mode == "OS") {
			## 접속 OS 데이타를 삭제한다. ###################################
			mysql_query("DELETE FROM odtCounterOSBrowser WHERE Kinds = 'O'");
			
			echo "
				<script>
					window.alert('접속 OS 데이타가 모두 삭제되었습니다. ');
				</script>";
		}
		else if($mode == "BROWSER") {
			## 접속 Browser 데이타를 삭제한다. ###################################
			mysql_query("DELETE FROM odtCounterOSBrowser WHERE Kinds = 'B'");
			
			echo "
				<script>
					window.alert('접속 BROWSER 데이타가 모두 삭제되었습니다. ');
				</script>";
		}
		else if($mode == "ALL") {
			mysql_query("DELETE FROM odtCounterRoute");
			mysql_query("DELETE FROM odtCounterOSBrowser");
			mysql_query("DELETE FROM odtCounterData");
			mysql_query("DELETE FROM odtCounterPerson");
			mysql_query("DELETE FROM odtCounter");
			
			$query="UPDATE odtCounterConfig SET Total_Num = 0 WHERE serialnum = '1'";
			mysql_query($query,$connect);
			
			echo "
				<script>
					window.alert('작업을 잘 완료 하였습니다.   ');
				</script>";
		}

		echo "<meta http-equiv='Refresh' content='0; URL=od_config.php'>";
	}
	else {
		if($mode == "ROUTE") $comment = "접속경로별";
		else if($mode == "OS") $comment = "접속OS별";
		else if($mode == "BROWSER") $comment = "접속브라우져별";
		else if($mode == "ALL") $comment = "모든";
		
		echo "
			<script language=\"javascript\">
				if(confirm(\"$comment 통계 자료에 대해 정말 초기화 하시겠습니까?   \"))
					self.location.replace('?Form=DataDelete&mode=$mode')
				else
					self.location.replace('od_config.php')
			</script>";

		exit;
	}
?>