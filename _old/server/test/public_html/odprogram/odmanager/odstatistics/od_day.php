<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";

	## 세부권한 체크
	if($row_admin[statisticLevel] < 3) {
		error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
	}
	
	$StartYear = date("Y",$row_setup[inputdate]);
	
	if(!$Year) $Year = date("Y");
	$CompareY = $Year;
	
	if(!$Mon) $Mon = date("m");
	$CompareM = $Mon;
	
	if(!$Day) $Day = date("d");
	$CompareD = $Day;
	
	$Today = "$CompareY-$CompareM-$CompareD 00:00:00";
?>

		<script language="JavaScript">
			function DaySelect(which) {
				var code;
				code = which.value;
				if(code != "No")
				location.href = "od_day.php?"+code+"";
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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 판매통계 &gt; <span class="st"><?=$CompareY?>년 <?=$CompareM?>월 <?=$CompareD?>일</font> 판매통계</span></font></td>
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
																<td width="63">
																	<select id=select1 name=Year onChange="DaySelect(this)" class="fes"> 
<?
	$ToYearHTerm = date("Y");

	for($j = $StartYear ; $j <= $ToYearHTerm ; $j++) {
		echo "<option value='Year=$j&Mon=$Mon&Day=$Day'";

		if($Year == $j) echo " selected";

		echo ">* $j</option>";
	}
?>
																	</select>
																</td>
																<td width="21">년</td>
																<td width="45"> 
																	<select id=select1 name=Mon onChange="DaySelect(this)"> 
																	<option value="No" <?if(!$Mon){echo"selected";}?>>월 선택</option>
																	<option value="No">------</option>
<?
	$ToMonHTerm = date("m");

	for($j = 1 ; $j <= 12 ; $j++) {
		echo "<option value='Year=$Year&Mon=$j&Day=$Day'";

		if($Mon == $j) echo " selected";

		echo ">* $j";echo"</option>";
	}
?>
																	<option value="No">------</option>
																	</select>
																</td>
																<td width="21">월</td>
																<td width="45"> 
																	<select id=select1 name=Day onChange="DaySelect(this)"> 
																	<option value="No" <?if(!$Day){echo"selected";}?>>날짜 선택</option>
																	<option value="No">--------</option>
<?
	$ToDayHTerm = 31;
	
	if($Mon == $ToMonHTerm) {
		for($j = 1 ; $j <= $ToDayHTerm ; $j++) {
			echo "<option value='Year=$Year&Mon=$Mon&Day=$j'";
		  
			if($Day == $j) echo " selected";
			
			echo ">* $j";echo"</option>";
		}
	}
	else {
		$EndDay = date("t",mktime(0,0,1,$Mon,1,$Year));
	  
		for($j = 1 ; $j <= $EndDay ; $j++) {
			echo "<option value='Year=$Year&Mon=$Mon&Day=$j'";
		  
			if($Day == $j) echo " selected";
		  
			echo ">* $j";echo"</option>";
		}
	}
?>
																	<option value="No">--------</option>
																	</select>
																</td>
																<td width="21">일</td>
																<td align="right">
																	<a href="od_statistic_reset.php?TypePA=D&Year=<?=$Year?>&Mon=<?=$Mon?>&Day=<?=$Day?>"><img src="../odimages/btn_reset_s.gif" border="0"></a></td>
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
																<td width="135" bgcolor="ececec" class="white">판매총액</td>
																<td width="465" bgcolor="ececec" class="white"></td>
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
	##해당일 초기화
	$day = 0;
	
	## 해당년도 첫월 첫일 데이터 구하기
	$Year1 = mktime(00,00,00,$CompareM,01,$CompareY);
	
	## 초기 월 설정
	$date = $CompareM;
	
	## 해당월이 반복값과 같을 경우 일수만큼 반복
	while($CompareM==$date) {
		## 하루 = 86400
		$Year1 += 86400; 
		$date = date("m",$Year1);
		$day++;
	}
	
	## 구해진 일수 배열로 저장
	$Month[$CompareM] = $day;
	$startYear = date('Y-m-d H:i:s',mktime(0,0,0,$CompareM,$CompareD,$CompareY));
	$endYear = date('Y-m-d H:i:s',mktime(23,59,59,$CompareM,$CompareD,$CompareY));
	
	## 상품별로 오늘 클릭한 상품 통계 보이기 ###############################################################
	$query = "SELECT SUM(tPrice) as stp FROM odtOrder WHERE ordernum<>'NONE' AND paystatus='Y' AND canceled='N' AND paydate BETWEEN '$startYear' AND '$endYear'";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);


	$SaleTotalPriceS = $row[stp];
	$SaleTotalPriceSD = number_format($SaleTotalPriceS);	
	
	if(!$SaleTotalPriceS || $SaleTotalPriceS < 1) {
		$maxBg_length = 1;
		$maxPercent = 0;
	}
	else {
		$maxBg_length = 420;
		$maxPercent = 100;
	}

	echo "
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr height='23'> 
																<td width='75' bgcolor='FAFAFA' align='center'><b><font color='#FF0000'>$CompareM</font></b>월 <b><font color='#FF0000'>$CompareD</font></b>일</td>
																<td width='135' bgcolor='FAFAFA' align='center'><b><font color='#138CE5'>$SaleTotalPriceSD</font></b>원</td>
																<td width='465' bgcolor='FAFAFA' align='center'>
																	<table width='460' border='0' cellspacing='0' cellpadding='0'>
																		<tr> 
																			<td width='5'>&nbsp;</td>
																			<td width='420'> 
																				<table width='$maxBg_length' height='16' border='0' cellspacing='0' cellpadding='0' height='8' background='../odimages/pix03.gif'>
																					<tr> 
																						<td></td>
																					</tr>
																				</table>
																			</td>
																			<td width='35' class='text-2'>&nbsp;$maxPercent%</td>
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
																<td height='1' colspan='11'></td>
															</tr>
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>";

	$ToMonthHTerm = date("m");
	
	if($CompareM == $ToMonthHTerm && $CompareD == $ToDayHTerm) $TimeTerm = date("H");
	else $TimeTerm = 23;
	
	for($i = 0 ; $i <= $TimeTerm ; $i++) {
		$Today = "$CompareY-$CompareM-$CompareD $i:00:00";
		$startDate = date('Y-m-d H:i:s',mktime($i,0,0,$CompareM,$CompareD,$CompareY));
		$endDate = date('Y-m-d H:i:s',mktime($i,59,59,$CompareM,$CompareD,$CompareY));
		
		## 상품별로 오늘 클릭한 상품 통계 보이기 ###############################################################
		$query = "SELECT SUM(tPrice) as stp FROM odtOrder WHERE ordernum<>'NONE' AND paystatus='Y' AND canceled='N' AND paydate BETWEEN '$startDate' AND '$endDate'";
		$result = mysql_query($query);
		$roww = mysql_fetch_array($result);

		$SaleTotalPrice = $roww[stp];
		$SaleTotalPriceD = number_format($SaleTotalPrice);		
		
		if($SaleTotalPriceS >0 ) {
			$Percent = round(100 * $SaleTotalPrice / $SaleTotalPriceS);
			$Pixel = ceil(420 * $Percent / 100);
			$PixelE = 460 - $Pixel - 5;
			$PixelS = 460 - $PixelE - 5;
			if($PixelS < 1) $PixelS = 1;
		}
		else {
			$Percent = 0;
			$PixelE = 204;
			$PixelS = 1;
		}

		echo "
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr height='23'> 
																<td width='75' align='center' bgcolor='FAFAFA'><font color='#FF0000'><b>$i</b></font> 時사이</td>
																<td width='135' align='center' bgcolor='FAFAFA'><b><font color='#138CE5'>$SaleTotalPriceD</font></b>원</td>
																<td width='465' align='center' bgcolor='FAFAFA'>
																	<table width='460' border='0' cellspacing='0' cellpadding='0'>
																		<tr> 
																			<td width='5'>&nbsp;</td>
																			<td width='420'> 
																				<table width='$PixelS' height='16' border='0' cellspacing='0' cellpadding='0' height='8' background='../odimages/pix03.gif'>
																					<tr> 
																						<td></td>
																					</tr>
																				</table>
																			</td>
																			<td width='35' class='text-2'>&nbsp;$Percent%</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>";
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