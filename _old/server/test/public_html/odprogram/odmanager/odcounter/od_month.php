<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";

	## 세부권한 체크
	if($row_admin[logLevel]==3 || $row_admin[superLevel]==9) {
	}
	else {
		error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
	}
	
	$ToDay_Time = time();
	$ToDay_Year = date("Y");
	$ToDay_Month = date("m");
	
	if(!$Select_Year) $Select_Year = $ToDay_Year;
	
	$result = mysql_fetch_array(mysql_query("SELECT SUM(Visit_Num) as CDSV FROM odtCounterData WHERE Year = '$Select_Year'"));
	
	$Total = $result[CDSV];
	if(!$Total) $Total = 0;

	## 시작년도 구함
	$result_start = mysql_fetch_array(mysql_query("SELECT MIN(Year) as CDMY FROM odtCounterData"));
	
	$Start_Year = $result_start[CDMY];
	if(!$Start_Year) $Start_Year = $ToDay_Year;
?>

		<script language="JavaScript">
			function Select_Menu(which) {
				var code;
				code = which.value;
				if(code != "NONE")
				location.href = "od_month.php?"+code+"";
			}
		</script>

		<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="FFFFFF">
			<tr> 
				<td height="80" bgcolor="#FFFFFF">
					<!-- top menu start -->
<? include "$folderpath_manager_common/od_topMenu.inc.php"; ?>
					<!-- top menu end -->
				</td>
			</tr>
			<tr> 
				<td valign="top"> 
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="6"></td>
						</tr>
					</table>
					<table height="100%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="165" height="100%" valign="top"> 
								<!-- left menu start -->
<? include "$folderpath_manager_common/od_leftMenu.inc.php"; ?>
								<!-- left menu end -->
							</td>
							<td width="3">&nbsp;</td>
							<td width="782" valign="top">
								<!-- main table start -->
								<table width="782" height="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="D6D6D6">
									<tr> 
										<td align="center" valign="top" bgcolor="#FFFFFF"> 
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 방문로그분석 &gt; <span class="st">월(月)별 접속통계</span></font></td>
												</tr>
												<tr> 
													<td height="2" bgcolor="D6D6D6"></td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="1" cellpadding="0">
												<tr>
													<td height="7"></td>
												</tr>
											</table>
											<table width="760" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td valign="top">
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td width="7"></td>
																<td>
																	<img src="../odimages/odmain/tex_icon.gif" align="absmiddle"> <b><?=$Select_Year?></b>년 <b>총방문자수</b> : <font face="tahoma" style="font-size:21;" color="FF6600"><b><?=$Total?></b></font>명
																</td>
																<td align="right">
																	<select name=Select_Year onChange="Select_Menu(this)"> 
																	<option value="NONE" <?if(!$Select_Year){echo"selected";}?>>년도 선택</option>
																	<option value="NONE">------</option>
<?
	for($i = $Start_Year ; $i <= $ToDay_Year ; $i++) {
		if($Select_Year == $i) $Choice = "selected";
		else $Choice = "";

		echo "<option value='Select_Year=$i' $Choice>* $i</option>";
	}
?>
																	<option value="NONE">------</option>
																	</select>년
																</td>
																<td width="7"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="3" colspan="11" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" colspan="11" bgcolor="c0bebe"></td>
															</tr>
															<tr align="center"> 
																<td width="75" height="27" bgcolor="ececec" class="white">구분</td>
																<td width="115" bgcolor="ececec" class="white">접속자수</td>
																<td width="570" bgcolor="ececec" class="white"></td>
															</tr>
															<tr> 
																<td height="1" colspan="11" bgcolor="c0bebe"></td>
															</tr>
															<tr> 
																<td height="2" colspan="11"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
<?
	for($i=1;$i<=12;$i++) {
		$today_hit_temp = mysql_fetch_array(mysql_query("SELECT SUM(Visit_Num) as SV FROM odtCounterData WHERE Year = '$Select_Year' AND Month='$i'"));
		
		$temp = $today_hit_temp[SV];
		if($max<$temp) $max = $temp;
	}

	for($i=1;$i<=12;$i++) {
		$result = mysql_fetch_array(mysql_query("SELECT SUM(Visit_Num) as SV2 FROM odtCounterData WHERE Year = '$Select_Year' AND Month='$i'")); 
		
		$Month_Num = $result[SV2]; 
		if(!$Month_Num) $Month_Num = 0;
		
		if($Total) {
			$Percent = round(100 * $Month_Num / $Total, 2);
			$Percent1 = round(100 * $Month_Num / $max, 2);
			$Percent_Width = 490 * $Percent1 / 100;
		}

		if(!$Percent_Width) $Percent_Width = "1";
		
		if($max == $Month_Num) $Back_Color = "background='../odimages/pix04.gif'";
		else $Back_Color = "background='../odimages/pix03.gif'";
?>
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr height='23'> 
																<td width='75' bgcolor='FAFAFA' align='center'><b><?=$i?></b>월</td>
																<td width='115' bgcolor='FAFAFA' align='center'><b><?=$Month_Num?></b>명</td>
																<td width='570' bgcolor='FAFAFA' align='center'>
																	<table width='565' border='0' cellspacing='0' cellpadding='0'>
																		<tr> 
																			<td width='5'>&nbsp;</td>
																			<td width='490'> 
																				<table width='<?=$Percent_Width?>' height='16' border='0' cellspacing='0' cellpadding='0' height='8'>
																					<tr> 
																						<td <?=$Back_Color?>></td>
																					</tr>
																				</table>
																			</td>
																			<td width='70' class='text-2'>&nbsp;<b><?=$Percent?></b>%</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
<? 
	} 
?>
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="1" cellpadding="0">
															<tr> 
																<td height="30">&nbsp;</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td height="5" bgcolor="#FFFFFF"></td>
									</tr>
								</table>
								<!-- main table end -->
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td height="83">
					<!-- bottom start -->
<? include "$folderpath_manager_common/od_bottom.inc.php"; ?>
					<!-- bottom end -->
				</td>
			</tr>
		</table>
	</body>
</html>