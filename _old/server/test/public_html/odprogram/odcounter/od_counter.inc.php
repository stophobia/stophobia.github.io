<?
	$counter_config_result = mysql_query("SELECT * FROM odtCounterConfig");
	$counter_config_row = mysql_fetch_array($counter_config_result);
	
	$counter_result = mysql_query("SELECT SUM(Visit_Num) FROM odtCounterData");
	$Total_Num = mysql_result($counter_result,0,0);
	
	$CoIP = $REMOTE_ADDR;
	$CoRoute = $HTTP_REFERER;
	$CoKinds = $HTTP_USER_AGENT;
	$CoKinds = eregi_replace(")","",$CoKinds);
	$CoKindsDivision = explode(";",$CoKinds);
	$CoKinds_Browser = $CoKindsDivision[1];
	$CoKinds_OS = $CoKindsDivision[2];
	$ToDay_Year = date("Y");
	$ToDay_Month = date("m");
	$ToDay_Day = date("d");
	$ToDay_Hour = date("H");
	$ToDay_Minute = date("i");
	$ToDay_Second = date("s");
	$ToDay_Week = date("D");
	$ToDay_Time = time();
	
	if($counter_config_row[Cookie_Use] == "A") {
		$Counter_ON = "Y";
		
		setcookie("odtCounter_Term",0,0,"/");
	}

	if($counter_config_row[Cookie_Use] == "T") {
		$Cookie_Term = $counter_config_row[Cookie_Term];
		$temp = $ToDay_Time - $_COOKIE[odtCounter_Term];
		
		if($temp>$Cookie_Term) {
			$Counter_ON = "Y";
			
			setcookie("odtCounter_Term",0,0,"/");
			setcookie("odtCounter_Term",$ToDay_Time,$ToDay_Time+365*24*3600,"/");
		}
	}

	if($counter_config_row[Cookie_Use] == "O") {
		$temp1 = date('Y-m-d',$_COOKIE[odtCounter_Term2]);
		$temp2 = date('Y-m-d');
		
		if($temp1 != $temp2) {
			$Counter_ON = "Y";
			
//			setcookie("odtCounter_Term2",0,0,"/");
			setcookie("odtCounter_Term2",$ToDay_Time,$ToDay_Time+100*24*3600);
		}
	}

	if($counter_config_row[Admin_Check_Use] == "N" && $counter_config_row[Admin_IP] == $CoIP) $Counter_ON = "N";
	
	if($counter_config_row[Now_Connect_Use] == "Y") {
		$temp = $ToDay_Time-$counter_config_row[Now_Connect_Term];
		
		mysql_query("DELETE FROM odtCounterPerson WHERE Time < $temp");
		mysql_query("INSERT INTO odtCounterPerson (Connect_IP, Time) VALUES ('$CoIP', '$ToDay_Time')");
	}



	# 로봇인지 체크
	if(ereg("googlebot|yahoo|naver",strtolower($CoKinds_Browser)) || ereg("googlebot|yahoo|naver",strtolower($CoKinds_OS))) {
		$isRobot = true;
	} else {
		$isRobot = false;
	}
/* 순수 아이피 체크는 같은 아이피 사용자들을 모두 제외하기 때문에 문제가 있음.
	### 오늘 이미 카운터된 아이피인지 체크
	//만약 처음이면 임시 테이블 삭제
	mysql_query("delete from odtCounterOnly where regi < '".date('Y-m-d')."'");
	// 오늘 이미 같은 아이피 방문이 있으면 로봇으로 처리.
	$isCnt = mysql_result(mysql_query("select count(*) from odtCounterOnly where ip = '".$CoIP."'"),0);
	if($isCnt < 1) {
		mysql_query("insert into odtCounterOnly set ip ='".$CoIP."', regi = '".date('Y-m-d')."'");
	} else {
		$isRobot = true;
	}
/* 순수 아이피 체크는 같은 아이피 사용자들을 모두 제외하기 때문에 문제가 있음. */

	# 카운터 차단 아이피
	$count_deny_ip = array("222.122.78.16","222.122.78.15","118.130.232.254","61.111.15");
	if(@array_search($CoIP,$count_deny_ip) == true) $isRobot = true;

	if($Counter_ON == "Y" && !$isRobot) {
		$Total_Num++;
		
		# 판매레포트 인클루드
		include dirname(__FILE__)."/od_report.php";
		#

		if($counter_config_row[Counter_Use] == "Y") {
			if($_POST[referer]) $CoRoute .= "&referer=".$_POST[referer];

			mysql_query("INSERT INTO odtCounter (Connect_IP, Time, Year, Month, Day, Hour, Week, OS, Browser, Connect_Route) VALUES ('$CoIP', '$ToDay_Time', '$ToDay_Year', '$ToDay_Month', '$ToDay_Day', '$ToDay_Hour', '$ToDay_Week', '$CoKinds_OS', '$CoKinds_Browser', '$CoRoute')");
			
			$data_query = "SELECT serialnum FROM odtCounterData WHERE Year = '$ToDay_Year' AND Month = '$ToDay_Month' AND Day = '$ToDay_Day'";
			$data_result = mysql_num_rows(mysql_query($data_query));
			
			if($data_result) {
				mysql_query("UPDATE odtCounterData SET Hour$ToDay_Hour = Hour$ToDay_Hour+1, Visit_Num = Hour00+Hour01+Hour02+Hour03+Hour04+Hour05+Hour06+Hour07+Hour08+Hour09+Hour10+Hour11+Hour12+Hour13+Hour14+Hour15+Hour16+Hour17+Hour18+Hour19+Hour20+Hour21+Hour22+Hour23 WHERE Year = '$ToDay_Year' AND Month = '$ToDay_Month' AND Day = '$ToDay_Day'");
			}
			else {
				mysql_query("INSERT INTO odtCounterData (Year, Month, Day, Hour$ToDay_Hour, Week, Visit_Num) VALUES ('$ToDay_Year', '$ToDay_Month', '$ToDay_Day', '1', '$ToDay_Week', '1')");
			}
			
			if($CoKinds_Browser == " MSIE 7.0") $CoKinds_Browser = "MSIE 7.0";
			else if($CoKinds_Browser == " MSIE 6.0") $CoKinds_Browser = "MSIE 6.0";
			else if($CoKinds_Browser == " MSIE 5.5") $CoKinds_Browser = "MSIE 5.5";
			else if($CoKinds_Browser == " MSIE 5.01") $CoKinds_Browser = "MSIE 5.01";
			else if($CoKinds_Browser == " MSIE 5.0") $CoKinds_Browser = "MSIE 5.0";
			else if($CoKinds_Browser == " MSIE 4.0") $CoKinds_Browser = "MSIE 4.0";
			else if($CoKinds_Browser == " MSIE 6.0b") $CoKinds_Browser = "MSIE 6.0b";
			else $CoKinds_Browser = "";
			
			$browser_query = "SELECT serialnum FROM odtCounterOSBrowser WHERE Kinds = 'B' AND Name = '$CoKinds_Browser'";
			$browser_result = mysql_num_rows(mysql_query($browser_query)); 
			
			if($browser_result) 
				mysql_query("UPDATE odtCounterOSBrowser SET Visit_Num = Visit_Num+1 WHERE Kinds = 'B' AND Name = '$CoKinds_Browser'");
			else mysql_query("INSERT INTO odtCounterOSBrowser (Name, Kinds, Visit_Num) VALUES ('$CoKinds_Browser', 'B', '1')");
			
			if($CoKinds_OS == " Windows NT 5.1") $CoKinds_OS = "Windows XP";
			else if($CoKinds_OS == " Windows NT 5.0") $CoKinds_OS = "Windows 2000";
			else if($CoKinds_OS == " Windows 98") $CoKinds_OS = "Windows 98";
			else if($CoKinds_OS == " Windows NT") $CoKinds_OS = "Windows NT";
			else if($CoKinds_OS == " Windows 95") $CoKinds_OS = "Windows 95";
			else if($CoKinds_OS == " Windows NT 4.0") $CoKinds_OS = "Windows NT 4.0";
			else if($CoKinds_OS == " Windows ME") $CoKinds_OS = "Windows ME";
			else if($CoKinds_OS == " Windows 3.1") $CoKinds_OS = "Windows 3.1";
			else $CoKinds_OS = "";
			
			$osb_query = "SELECT serialnum FROM odtCounterOSBrowser WHERE Kinds = 'O' AND Name = '$CoKinds_OS'";
			$osb_result = mysql_num_rows(mysql_query($osb_query)); 
			
			if($osb_result) 
				mysql_query("UPDATE odtCounterOSBrowser SET Visit_Num = Visit_Num+1 WHERE Kinds = 'O' AND Name = '$CoKinds_OS'");
			else mysql_query("INSERT INTO odtCounterOSBrowser (Name, Kinds, Visit_Num) VALUES ('$CoKinds_OS', 'O', '1')");
			
			$route_query = "SELECT serialnum FROM odtCounterRoute WHERE Connect_Route = '$CoRoute'";
			$route_result = mysql_num_rows(mysql_query($route_query)); 
			
			if($route_result) 
				mysql_query("UPDATE odtCounterRoute SET Time = '$ToDay_Time', Visit_Num = Visit_Num+1 WHERE Connect_Route = '$CoRoute'");
			else mysql_query("INSERT INTO odtCounterRoute (Connect_Route, Time, Visit_Num) VALUES ('$CoRoute', '$ToDay_Time', '1')");
		}
	}

	mysql_query("UPDATE odtCounterConfig SET Total_Num = '$Total_Num' WHERE serialnum = 1");
?>