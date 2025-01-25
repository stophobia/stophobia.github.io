<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";

	if(!strcmp($Form,"StatisticsInitial")) {
		$initdate = time();
		
		$UpQuery = "UPDATE odtCart SET initial='Y',initdate='$initdate' WHERE ordernum != 'NONE'";
		$UpResult = mysql_query($UpQuery);
		
		if(!$UpResult) {
			echo "
				<script>
					window.alert('초기화에 실패하였습니다.   ');
					history.go(-1);
				</script>";

			exit;
		}
		else {
			if($TypePA == "Y") $LinkPage = "od_year.php";
			else if($TypePA == "M") $LinkPage = "od_month.php";
			else if($TypePA == "D") $LinkPage = "od_day.php";
			
			echo "
				<script>
					window.alert('초기화 작업이 잘 되었습니다.   ');
				</script>";

			echo "<meta http-equiv='Refresh' content='0; URL=$LinkPage?Year=$Year&Mon=$Mon&Day=$Day'>";
			exit;
		}
	}
	else {
		if($TypePA == "Y") $LinkPage = "od_year.php";
		else if($TypePA == "M") $LinkPage = "od_month.php";
		else if($TypePA == "D") $LinkPage = "od_day.php";
		
		echo "
			<script language=\"javascript\">
				if(confirm(\"정말로 초기화 작업을 진행 하시겠습니까?   \"))
					self.location.replace('?Form=StatisticsInitial&TypePA=$TypePA&Year=$Year&Mon=$Mon&Day=$Day')
				else
					self.location.replace('$LinkPage?Year=$Year&Mon=$Mon&Day=$Day')
			</script>";

		exit;
	}
?>