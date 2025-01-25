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
	
	$ToDay_Year = date("Y");

	$result = mysql_fetch_array(mysql_query("SELECT SUM(Visit_Num) as CDSV FROM odtCounterData"));
	
	$Total = $result[CDSV];
	if(!$Total) $Total = 0;
?>

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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 방문로그분석 &gt; <span class="st">년(年)별 접속통계</span></font></td>
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
																	<img src="../odimages/odmain/tex_icon.gif" align="absmiddle"> <b>총방문자수</b> : <font face="tahoma" style="font-size:21;" color="FF6600"><b><?=$Total?></b></font>명
																</td>
																<td align="right">&nbsp;</td>
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
	if(!$Total) {
		echo "
															<tr> 
																<td height='75' class='text-2' align='center'>기록이 없습니다.</td>
															</tr>
															<tr> 
																<td height='1' bgcolor='cdcdcd'></td>
															</tr>";
	}
	else {
		$result_year = mysql_query("SELECT Year FROM odtCounterData GROUP BY Year ORDER BY Year ASC");
		
		while($row = mysql_fetch_array($result_year)) {
			$Year_Select = $row[Year];
			
			$result = mysql_fetch_array(mysql_query("SELECT SUM(Visit_Num) as SV FROM odtCounterData WHERE Year='$Year_Select'"));	
			$Year_Num = $result[SV];

			$Percent = round(100 * $Year_Num / $Total, 2);
			$Percent_Width = 490 * $Percent / 100;

			$Back_Color = "background='../odimages/pix03.gif''";
?>
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr height='23'> 
																<td width='75' bgcolor='FAFAFA' align='center'><b><?=$row[Year]?></b>년</td>
																<td width='115' bgcolor='FAFAFA' align='center'><b><?=$Year_Num?></b>명</td>
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