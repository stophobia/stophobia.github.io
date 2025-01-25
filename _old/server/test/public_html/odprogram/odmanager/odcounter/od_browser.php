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
	$ToDay_Day = date("d");
	$ToDay_Hour = date("H");
	
	$result = mysql_fetch_array(mysql_query("SELECT SUM(Visit_Num) as COBSV FROM odtCounterOSBrowser WHERE Kinds='B'"));
	
	$Total = $result[COBSV];	
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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 방문로그분석 &gt; <span class="st">브라우져별 접속통계</span></font></td>
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
																	<img src="../odimages/odmain/tex_icon.gif" align="absmiddle"> <b>브라우져</b>별 <b>총방문자수</b> : <font face="tahoma" style="font-size:21;" color="FF6600"><b><?=$Total?></b></font>명
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
																<td width="135" height="27" bgcolor="ececec" class="white">브라우져</td>
																<td width="115" bgcolor="ececec" class="white">접속자수</td>
																<td width="510" bgcolor="ececec" class="white"></td>
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
																<td height='75' colspan='11' align='center'>기록이 없습니다.</td>
															</tr>
															<tr> 
																<td height='1' bgcolor='cdcdcd' colspan='11'></td>
															</tr>";
	}
	else {		
		$query = "SELECT Name, Visit_Num FROM odtCounterOSBrowser WHERE Kinds='B' ORDER BY Visit_Num DESC";
		$result = mysql_query($query,$connect);

		while($row = mysql_fetch_array($result)) {
			$Name = $row[Name];
			$Visit_Num = $row[Visit_Num];
			
			if(!$Connect_Route) $Connect_Route = "<font color='blue' face='tahoma'>즐겨찾기 OR URL 직접입력을 통한 접속</font>";
			
			$Percent = round(100*$Visit_Num/$Total, 2);
			$Percent_Width = 430*$Percent/100;
			
			if(!$Percent_Width) $Percent_Width = "1";
			if(!$Name) $Name = "기타...";
			
			$nameTemp = eregi_replace("MSIE","Explorer",$Name);
?>
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr height='23'> 
																<td width='135' bgcolor='FAFAFA' align='center'><b><?=$nameTemp?></b></td>
																<td width='115' bgcolor='FAFAFA' align='center'><b><?=$Visit_Num?></b>명</td>
																<td width='510' bgcolor='FAFAFA' align='center'>
																	<table width='505' border='0' cellspacing='0' cellpadding='0'>
																		<tr> 
																			<td width='5'>&nbsp;</td>
																			<td width='430'> 
																				<table width='<?=$Percent_Width?>' height='16' border='0' cellspacing='0' cellpadding='0' height='8'>
																					<tr> 
																						<td background='../odimages/pix03.gif'></td>
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