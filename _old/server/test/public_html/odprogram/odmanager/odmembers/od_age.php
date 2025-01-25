<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "../../odcommon/od_lib.inc.php";
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";

	## 세부권한 체크
	if($row_admin[memberLevel] < 3) {
		error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
	}

	##############################################
	## 전체 회원의 수/남성회원 수/여성회원 수 시작
	##############################################
	$qry_M = "SELECT sex, count(serialnum) as cc FROM odtMember WHERE resinum != '' and birthy != '' and secession='N' and (sex = 'F' or sex = 'M') and userType='B' group by sex";
	$res_M = mysql_query($qry_M);
	$total = 0;
	$MTotal = 0;
	$FMTotal = 0;

	while($row_M = mysql_fetch_array($res_M)){
		if($row_M[sex] == "M") $MTotal = $row_M[cc];
		else if($row_M[sex] == "F") $FMTotal = $row_M[cc];

		$total += $row_M[cc];
	}

	## 테이블 가로 크기
	$table_width = 248;
	
	## % 셀을 42로 기준한 그래프 셀 가로 크기
	$graph_width = 206;
	
	## 0% 인 경우 %셀 가로 크기
	$none_width = 247;
	
	## 분할된 셀 가로 크기
	$division_width = 0;

	## 성별 회원 퍼센테이지 값 계산
	if($total >0 ) {
		$SexPercentM = floor(100*$MTotal/$total);
		$MPixel = ceil($graph_width*$SexPercentM/100);
		$MPixelE = $table_width-$MPixel;
		$MPixelS = $table_width-$MPixelE;
		
		if($MPixelS < 1) $MPixelS = 1;
		
		$SexPercentFM = ceil(100*$FMTotal/$total);
		$FPixel = ceil($graph_width*$SexPercentFM/100);
		$FPixelE = $table_width-$FPixel;
		$FPixelS = $table_width-$FPixelE;
		
		if($FPixelS < 1) $FPixelS = 1;
	}
	else {
		$SexPercentM = 0;
		$MPixelE = $none_width;
		$MPixelS = 1;
		$SexPercentFM = 0;
		$FPixelE = $none_width;
		$FPixelS = 1;
	}
	##############################################
	## 전체 회원의 수/남성회원 수/여성회원 수 끝
	##############################################

	###############################################
	## 나이대별 회원 수 시작
	###############################################
	$AgeYear = date("Y");

	## 10대 전체 회원/남성 회원/여성 회원 의 수 시작
	$TEHYearStart = $AgeYear - 18;
	$TEHYearEnd = $AgeYear - 0;

	$qry_M10 = "SELECT sex, count(serialnum) as cc FROM odtMember WHERE birthy BETWEEN '$TEHYearStart' AND '$TEHYearEnd' and birthy != '' and  resinum != ''   AND secession='N' and (sex = 'F' or sex = 'M') and userType='B' group by sex";
	$res_M10 = mysql_query($qry_M10);

	$TEHTotal = 0;
	$MTEHTotal = 0;
	$FMTEHTotal = 0;

	while($row_M10 = mysql_fetch_array($res_M10)){
		if($row_M10[sex] == "M") $MTEHTotal = $row_M10[cc];
		else if($row_M10[sex] == "F") $FMTEHTotal = $row_M10[cc];

		$TEHTotal += $row_M10[cc];
	}

	## 10대 회원 퍼센테이지 값 계산
	if($TEHTotal >0 ) {
		$MTEHPercentM = floor(100*$MTEHTotal/$total);
		$MTEHPixel = ceil($graph_width*$MTEHPercentM/100);
		$MTEHPixelE = $table_width-$MTEHPixel-$division_width;
		$MTEHPixelS = $table_width-$MTEHPixelE-$division_width;
		
		if($MTEHPixelS < 1) $MTEHPixelS = 1;
		
		$FMTEHPercentFM = ceil(100*$FMTEHTotal/$total);
		$FMTEHPixel = ceil($graph_width*$FMTEHPercentFM/100);
		$FMTEHPixelE = $table_width-$FMTEHPixel-$division_width;
		$FMTEHPixelS = $table_width-$FMTEHPixelE-$division_width;
		
		if($FMTEHPixelS < 1) $FMTEHPixelS = 1;
	}
	else {
		$MTEHPercentM = 0;
		$MTEHPixelE = 229;
		$MTEHPixelS = 1;
		$FMTEHPercentFM = 0;
		$FMTEHPixelE = 229;
		$FMTEHPixelS = 1;
	}
	## 10대 전체 회원/남성 회원/여성 회원 의 수 끝

	## 20대 전체 회원/남성회원/여성회원 의 수 시작
	$TTHYearStart = $AgeYear - 28;
	$TTHYearEnd = $AgeYear - 19;

	$qry_M20 = "SELECT sex, count(serialnum) as cc FROM odtMember WHERE birthy BETWEEN '$TTHYearStart' AND '$TTHYearEnd' AND birthy != '' and  resinum != '' and secession='N' and (sex = 'F' or sex = 'M') and userType='B' group by sex";
	$res_M20 = mysql_query($qry_M20);

	$TTHTotal = 0;
	$MTTHTotal = 0;
	$FMTTHTotal = 0;

	while($row_M20 = mysql_fetch_array($res_M20)){
		if($row_M20[sex] == "M") $MTTHTotal = $row_M20[cc];
		else if($row_M20[sex] == "F") $FMTTHTotal = $row_M20[cc];

		$TTHTotal += $row_M20[cc];
	}

	## 20대 회원 퍼센테이지 값 계산
	if($TTHTotal >0 ) {
		$MTTHPercentM = floor(100*$MTTHTotal/$total);
		$MTTHPixel = ceil($graph_width*$MTTHPercentM/100);
		$MTTHPixelE = $table_width-$MTTHPixel-$division_width;
		$MTTHPixelS = $table_width-$MTTHPixelE-$division_width;
		
		if($MTTHPixelS < 1) $MTTHPixelS = 1;
		
		$FMTTHPercentFM = ceil(100*$FMTTHTotal/$total);
		$FMTTHPixel = ceil($graph_width*$FMTTHPercentFM/100);
		$FMTTHPixelE = $table_width-$FMTTHPixel-$division_width;
		$FMTTHPixelS = $table_width-$FMTTHPixelE-$division_width;
		
		if($FMTTHPixelS < 1) $FMTTHPixelS = 1;
	}
	else {
		$MTTHPercentM = 0;
		$MTTHPixelE = $none_width;
		$MTTHPixelS = 1;
		$FMTTHPercentFM = 0;
		$FMTTHPixelE = $none_width;
		$FMTTHPixelS = 1;
	}
	## 20대 전체 회원/남성회원/여성회원 의 수 끝

	## 30대 전체 회원/남성회원/여성회원 의 수 시작
	$THYearStart = $AgeYear - 38;
	$THYearEnd = $AgeYear - 29;

	$qry_M30 = "SELECT sex, count(serialnum) as cc FROM odtMember WHERE birthy BETWEEN '$THYearStart' AND '$THYearEnd' AND birthy != '' and  resinum != '' and secession='N' and (sex = 'F' or sex = 'M') and userType='B' group by sex";
	$res_M30 = mysql_query($qry_M30);

	$THTotal = 0;
	$MTHTotal = 0;
	$FMTHTotal = 0;

	while($row_M30 = mysql_fetch_array($res_M30)){
		if($row_M30[sex] == "M") $MTHTotal = $row_M30[cc];
		else if($row_M30[sex] == "F") $FMTHTotal = $row_M30[cc];

		$THTotal += $row_M30[cc];
	}

	## 30대 회원 퍼센테이지 값 계산
	if($THTotal >0 ) {
		$MTHPercentM = floor(100*$MTHTotal/$total);
		$MTHPixel = ceil($graph_width*$MTHPercentM/100);
		$MTHPixelE = $table_width-$MTHPixel-$division_width;
		$MTHPixelS = $table_width-$MTHPixelE-$division_width;
		
		if($MTHPixelS < 1) $MTHPixelS = 1;
		
		$FMTHPercentFM = ceil(100*$FMTHTotal/$total);
		$FMTHPixel = ceil($graph_width*$FMTHPercentFM/100);
		$FMTHPixelE = $table_width-$FMTHPixel-$division_width;
		$FMTHPixelS = $table_width-$FMTHPixelE-$division_width;
		
		if($FMTHPixelS < 1) $FMTHPixelS = 1;
	}
	else {
		$MTHPercentM = 0;
		$MTHPixelE = $none_width;
		$MTHPixelS = 1;
		$FMTHPercentFM = 0;
		$FMTHPixelE = $none_width;
		$FMTHPixelS = 1;
	}
	## 30대 전체 회원/남성회원/여성회원 의 수 끝

	## 40대 전체 회원/남성회원/여성회원 의 수 시작
	$FHYearStart = $AgeYear - 48;
	$FHYearEnd = $AgeYear - 39;

	$qry_M40 = "SELECT sex, count(serialnum) as cc FROM odtMember WHERE birthy BETWEEN '$FHYearStart' AND '$FHYearEnd' AND birthy != '' and  resinum != '' and secession='N' and (sex = 'F' or sex = 'M') and userType='B' group by sex";
	$res_M40 = mysql_query($qry_M40);

	$FHTotal = 0;
	$MFHTotal = 0;
	$FMFHTotal = 0;

	while($row_M40 = mysql_fetch_array($res_M40)){
		if($row_M40[sex] == "M") $MFHTotal = $row_M40[cc];
		else if($row_M40[sex] == "F") $FMFHTotal = $row_M40[cc];

		$FHTotal += $row_M40[cc];
	}

	## 40대 회원 퍼센테이지 값 계산
	if($FHTotal >0 ) {
		$MFHPercentM = floor(100*$MFHTotal/$total);
		$MFHPixel = ceil($graph_width*$MFHPercentM/100);
		$MFHPixelE = $table_width-$MFHPixel-$division_width;
		$MFHPixelS = $table_width-$MFHPixelE-$division_width;
		
		if($MFHPixelS < 1) $MFHPixelS = 1;
		
		$FMFHPercentFM = ceil(100*$FMFHTotal/$total);
		$FMFHPixel = ceil($graph_width*$FMFHPercentFM/100);
		$FMFHPixelE = $table_width-$FMFHPixel-$division_width;
		$FMFHPixelS = $table_width-$FMFHPixelE-$division_width;
		
		if($FMFHPixelS < 1) $FMFHPixelS = 1;
	}
	else {
		$MFHPercentM = 0;
		$MFHPixelE = $none_width;
		$MFHPixelS = 1;
		$FMFHPercentFM = 0;
		$FMFHPixelE = $none_width;
		$FMFHPixelS = 1;
	}
	## 40대 전체 회원/남성회원/여성회원 의 수 끝

	## 50대 전체 회원/남성회원/여성회원 의 수 시작
	$FOHYearStart = $AgeYear - 58;
	$FOHYearEnd = $AgeYear - 49;

	$qry_M50 = "SELECT sex, count(serialnum) as cc FROM odtMember WHERE birthy BETWEEN '$FOHYearStart' AND '$FOHYearEnd' AND birthy != '' and  resinum != '' and secession='N' and (sex = 'F' or sex = 'M') and userType='B' group by sex";
	$res_M50 = mysql_query($qry_M50);

	$FOHTotal = 0;
	$MFOHTotal = 0;
	$FMFOHTotal = 0;

	while($row_M50 = mysql_fetch_array($res_M50)){
		if($row_M50[sex] == "M") $MFOHTotal = $row_M50[cc];
		else if($row_M50[sex] == "F") $FMFOHTotal = $row_M50[cc];

		$FOHTotal += $row_M50[cc];
	}

	## 50대 회원 퍼센테이지 값 계산
	if($FOHTotal >0 ) {
		$MFOHPercentM = floor(100*$MFOHTotal/$total);
		$MFOHPixel = ceil($graph_width*$MFOHPercentM/100);
		$MFOHPixelE = $table_width-$MFOHPixel-$division_width;
		$MFOHPixelS = $table_width-$MFOHPixelE-$division_width;
		
		if($MFOHPixelS < 1) $MFOHPixelS = 1;
		
		$FMFOHPercentFM = ceil(100*$FMFOHTotal/$total);
		$FMFOHPixel = ceil($graph_width*$FMFOHPercentFM/100);
		$FMFOHPixelE = $table_width-$FMFOHPixel-$division_width;
		$FMFOHPixelS = $table_width-$FMFOHPixelE-$division_width;
		
		if($FMFOHPixelS < 1) $FMFOHPixelS = 1;
	}
	else {
		$MFOHPercentM = 0;
		$MFOHPixelE = $none_width;
		$MFOHPixelS = 1;
		$FMFOHPercentFM = 0;
		$FMFOHPixelE = $none_width;
		$FMFOHPixelS = 1;
	}
	## 50대 전체 회원/남성회원/여성회원 의 수 끝

	## 60대 전체 회원/남성회원/여성회원 의 수 시작
	$SHYearStart = $AgeYear - 100;
	$SHYearEnd = $AgeYear - 59;

	$qry_M60 = "SELECT sex, count(serialnum) as cc FROM odtMember WHERE birthy BETWEEN '$SHYearStart' AND '$SHYearEnd' AND birthy != '' and  resinum != '' and secession='N' and (sex = 'F' or sex = 'M') and userType='B' group by sex";

	$res_M60 = mysql_query($qry_M60);

	$SHTotal = 0;
	$MSHTotal = 0;
	$FMSHTotal = 0;

	while($row_M60 = mysql_fetch_array($res_M60)){
		if($row_M60[sex] == "M") $MSHTotal = $row_M60[cc];
		else if($row_M60[sex] == "F") $FMSHTotal = $row_M60[cc];

		$SHTotal += $row_M60[cc];
	}

	## 60대 회원 퍼센테이지 값 계산
	if($SHTotal >0 ) {
		$MSHPercentM = floor(100*$MSHTotal/$total);
		$MSHPixel = ceil($graph_width*$MSHPercentM/100);
		$MSHPixelE = $table_width-$MSHPixel-$division_width;
		$MSHPixelS = $table_width-$MSHPixelE-$division_width;
		
		if($MSHPixelS < 1) $MSHPixelS = 1;
		
		$FMSHPercentFM = ceil(100*$FMSHTotal/$total);
		$FMSHPixel = ceil($graph_width*$FMSHPercentFM/100);
		$FMSHPixelE = $table_width-$FMSHPixel-$division_width;
		$FMSHPixelS = $table_width-$FMSHPixelE-$division_width;
		
		if($FMSHPixelS < 1) $FMSHPixelS = 1;
	}
	else {
		$MSHPercentM = 0;
		$MSHPixelE = $none_width;
		$MSHPixelS = 1;
		$FMSHPercentFM = 0;
		$FMSHPixelE = $none_width;
		$FMSHPixelS = 1;
	}
	## 60대 전체 회원/남성회원/여성회원 의 수 끝
	###############################################
	## 나이대별 회원 수 끝
	###############################################
?>

		<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 회원관리 &gt; <span class="st">연령대별 회원통계</span></font></td>
												</tr>
												<tr> 
													<td height="2" bgcolor="D6D6D6"></td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="1" cellpadding="0">
												<tr>
													<td height="25"></td>
												</tr>
											</table>
											<table width="760" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td valign="top">
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="3" colspan="11" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" colspan="11" bgcolor="c0bebe"></td>
															</tr>
															<tr align="center"> 
																<td width="144" height="27" bgcolor="ececec" class="white">전체회원</td>
																<td width="60" bgcolor="ececec" class="white" >남성회원</td>
																<td width="248" bgcolor="ececec" class="white"></td>
																<td width="60" bgcolor="ececec" class="white">여성회원</td>
																<td width="248" bgcolor="ececec" class="white"></td>
															</tr>
															<tr> 
																<td height="1" colspan="11" bgcolor="c0bebe"></td>
															</tr>
															<tr> 
																<td height="2" colspan="11"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr height='23'> 
																<td width='144' align='center' bgcolor='FAFAFA'><b><?=$total?></b>명</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$MTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0">
																		<tr> 
																			<td width="<?=$MPixelS?>"> 
																				<table width="<?=$MPixelS?>" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix03.gif">
																					<tr> 
																						<td height="16"></td>
																					</tr>
																				</table>
																			</td>
																			<td width="<?=$MPixelE?>">&nbsp;<?=$SexPercentM?>%</td>
																		</tr>
																	</table>
																</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$FMTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0">
																		<tr> 
																			<td width="<?=$FPixelS?>"> 
																				<table width="<?=$FPixelS?>" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix04.gif">
																					<tr> 
																						<td height="16"></td>
																					</tr>
																				</table>
																			</td>
																			<td width="<?=$FPixelE?>">&nbsp;<?=$SexPercentFM?>%</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="1" cellpadding="0">
															<tr> 
																<td height="25"></td>
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
																<td width="84" height="27" bgcolor="ececec" class="white">구분</td>
																<td width="60" height="27" bgcolor="ececec" class="white">전체</td>
																<td width="60" bgcolor="ececec" class="white" >남성회원</td>
																<td width="248" bgcolor="ececec" class="white"></td>
																<td width="60" bgcolor="ececec" class="white">여성회원</td>
																<td width="248" bgcolor="ececec" class="white"></td>
															</tr>
															<tr> 
																<td height="1" colspan="11" bgcolor="c0bebe"></td>
															</tr>
															<tr> 
																<td height="2" colspan="11"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr height='23'> 
																<td width='84' align='center' bgcolor='FAFAFA'><b><font color="005190">10대</font></b></td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$TEHTotal?></b>명</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$MTEHTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0">
																		<tr> 
																			<td width="<?=$FMTEHPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix03.gif">
																					<tr> 
																						<td height="16"></td>
																					</tr>
																				</table>
																			</td>
																			<td width="<?=$FMTEHPixelE?>">&nbsp;<?=$MTEHPercentM?>%</td>
																		</tr>
																	</table>
																</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$FMTEHTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0">
																		<tr> 
																			<td width="<?=$FMTEHPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix04.gif">
																					<tr> 
																						<td height="16"></td>
																					</tr>
																				</table>
																			</td>
																			<td width="<?=$FMTEHPixelE?>">&nbsp;<?=$FMTEHPercentFM?>%</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr height='23'> 
																<td width='84' align='center' bgcolor='FAFAFA'><b><font color="005190">20대</font></b></td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$TTHTotal?></b>명</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$MTTHTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0">
																		<tr> 
																			<td width="<?=$MTTHPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix03.gif">
																					<tr> 
																						<td height="16"></td>
																					</tr>
																				</table>
																			</td>
																			<td width="<?=$MTTHPixelE?>">&nbsp;<?=$MTTHPercentM?>%</td>
																		</tr>
																	</table>
																</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$FMTTHTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0">
																		<tr> 
																			<td width="<?=$FMTTHPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix04.gif">
																					<tr> 
																						<td height="16"></td>
																					</tr>
																				</table>
																			</td>
																			<td width="<?=$FMTTHPixelE?>">&nbsp;<?=$FMTTHPercentFM?>%</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr height='23'> 
																<td width='84' align='center' bgcolor='FAFAFA'><font color="005190"><b>30대</b></font></td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$THTotal?></b>명</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$MTHTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0">
																		<tr> 
																			<td width="<?=$MTHPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix03.gif">
																					<tr> 
																						<td height="16"></td>
																					</tr>
																				</table>
																			</td>
																			<td width="<?=$MTHPixelE?>">&nbsp;<?=$MTHPercentM?>%</td>
																		</tr>
																	</table>
																</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$FMTHTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td width="<?=$FMTHPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix04.gif">
																					<tr> 
																						<td height="16"></td>
																					</tr>
																				</table>
																			</td>
																			<td width="<?=$FMTHPixelE?>">&nbsp;<?=$FMTHPercentFM?>%</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr height='23'> 
																<td width='84' align='center' bgcolor='FAFAFA'><b><font color="005190">40대</font></b></td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$FHTotal?></b>명</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$MFHTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td width="<?=$MFHPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix03.gif">
																					<tr> 
																						<td height="16"></td>
																					</tr>
																				</table>
																			</td>
																			<td width="<?=$MFHPixelE?>">&nbsp;<?=$MFHPercentM?>%</td>
																		</tr>
																	</table>
																</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$FMFHTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td width="<?=$FMFHPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix04.gif">
																					<tr> 
																						<td height="16"></td>
																					</tr>
																				</table>
																			</td>
																			<td width="<?=$FMFHPixelE?>">&nbsp;<?=$FMFHPercentFM?>%</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr height='23'> 
																<td width='84' align='center' bgcolor='FAFAFA'><b><font color="005190">50대</font></b></td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$FOHTotal?></b>명</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$MFOHTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td width="<?=$MFOHPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix03.gif">
																					<tr> 
																						<td height="16"></td>
																					</tr>
																				</table>
																			</td>
																			<td width="<?=$MFOHPixelE?>">&nbsp;<?=$MFOHPercentM?>%</td>
																		</tr>
																	</table>
																</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$FMFOHTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td width="<?=$FMFOHPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix04.gif">
																					<tr> 
																						<td height="16"></td>
																					</tr>
																				</table>
																			</td>
																			<td width="<?=$FMFOHPixelE?>">&nbsp;<?=$FMFOHPercentFM?>%</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr height='23'> 
																<td width='84' align='center' bgcolor='FAFAFA'><b><font color="005190">60대</font></b></td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$SHTotal?></b>명</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$MSHTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td width="<?=$MSHPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix03.gif">
																					<tr> 
																						<td height="16"></td>
																					</tr>
																				</table>
																			</td>
																			<td width="<?=$MSHPixelE?>">&nbsp;<?=$MSHPercentM?>%</td>
																		</tr>
																	</table>
																</td>
																<td width='60' align='center' bgcolor='FAFAFA'><b><?=$FMSHTotal?></b>명</td>
																<td width='248' align='center' bgcolor='FAFAFA'>
																	<table width="248" border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td width="<?=$FMSHPixelS?>"> 
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="../images/pix04.gif">
																					<tr> 
																						<td height="16"></td>
																					</tr>
																				</table>
																			</td>
																			<td width="<?=$FMSHPixelE?>">&nbsp;<?=$FMSHPercentFM?>%</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
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