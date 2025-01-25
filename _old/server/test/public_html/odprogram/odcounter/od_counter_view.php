<?
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
	
	$counter_query = "SELECT * FROM odtCounterData WHERE Year = '$ToDay_Year' AND Month = '$ToDay_Month' AND Day = '$ToDay_Day'";
	$counter_row = mysql_fetch_array(mysql_query($counter_query,$connect));
	
	$ToDay_Num = $counter_row[Visit_Num];
	$YesterDay_Time = time();
	$YesterDay_Time = $YesterDay_Time - (24*3600);
	$YesterDay_Year = date('Y', $YesterDay_Time);
	$YesterDay_Month = date('m', $YesterDay_Time);
	$YesterDay_Day = date('d', $YesterDay_Time);
	
	$counter_query = "SELECT * FROM odtCounterData WHERE Year = '$YesterDay_Year' AND Month = '$YesterDay_Month' AND Day = '$YesterDay_Day'";
	$counter_row = mysql_fetch_array(mysql_query($counter_query,$connect));
	
	$YesterDay_Num = $counter_row[Visit_Num];
	
	if(!$YesterDay_Num) $YesterDay_Num = 0;
	
	$Total_NumD = number_format($Total_Num);
	$ToDay_NumD = number_format($ToDay_Num);
	$YesterDay_NumD = number_format($YesterDay_Num);
	$Now_Person_NumD = number_format($Now_Person_Num);
?>
		<table width="172" border="0" cellpadding="3" cellspacing="5" bgcolor="DCDCDC">
			<tr>
				<td height="60" align="center" bgcolor="#FFFFFF"> 
					<table width="140" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="69" height="16"><img src="<?=$folderpath_image?>/main/odcounter_t01.gif" width="69" height="11"></td>
							<td align="right" class="foot"><strong><font color="E94269"><?=$Total_NumD?></font></strong> 명</td>
						</tr>
						<tr>
							<td height="16"><img src="<?=$folderpath_image?>/main/odcounter_t02.gif" width="69" height="11"></td>
							<td align="right" class="foot"><font color="E94269"><strong><?=$ToDay_NumD?></strong></font> 명</td>
						</tr>
						<tr>
							<td height="16"><img src="<?=$folderpath_image?>/main/odcounter_t03.gif" width="69" height="11"></td>
							<td align="right" class="foot"><font color="E94269"><strong><?=$YesterDay_NumD?></strong></font> 명</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>