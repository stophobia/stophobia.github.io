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
	
	## 리스트로 표시할 대상 상품의 총 개수를 구한다. ########################################
	$ListTotalNum = mysql_num_rows(mysql_query("SELECT serialnum FROM odtProduct WHERE clickNum>'0'"));

	## 클릭수가 가장 많은 상품을 구한다. ############################################
	$Crow = mysql_fetch_array(mysql_query("SELECT max(clickNum) as MC FROM odtProduct"));
	
	$NewUidB = $Crow[MC];
?>

		<script language="JavaScript">
			function viewList(which) {
				var code;
				code = which.value;
				if(code != "No")
					parent.main.location.href = "od_click.php?"+code+"";
			}
		</script>

		<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
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
							<td width="10">&nbsp;</td>
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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 판매통계 &gt; <span class="st">최다클릭상품</span></font></td>
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
																<td>
																	<select name="listView" onChange="viewList(this)">
																	<option value="No">* 표시할 순위 지정</option>
																	<option value="No">--------------------------------</option>
<?
	$i = 10;
	
	while($i <= $ListTotalNum) {
?>
																	<option value="listView=<?echo"$i";?>" <?if($listView == $i) echo" selected";?>><?echo"$i";?>위 까지</option>
<?
		$i = $i + 10; 
	}

	if($i != $ListTotalNum) {
?>
																	<option value="listView=<?echo"$ListTotalNum";?>" <?if($listView == "$ListTotalNum") echo" selected";?>><?echo"$ListTotalNum";?>위 까지</option>
<? 
	} 
?>
																	<option value="No">--------------------------------</option>
																	</select>
																</td>
																<td align="right">
																	<a href="od_click_reset.php?listView=<?echo"$listView";?>"><img src="../odimages/btn_reset_s.gif" border="0"></a></td>
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
																<td width="55" height="27" bgcolor="ececec" class="white">순위</td>
																<td bgcolor="ececec" class="white" align="left"><img src='blank.gif' width='11' height='1'>상품정보</td>
																<td width="75" bgcolor="ececec" class="white">판매수량</td>
																<td width="370" bgcolor="ececec" class="white"></td>
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
	if($NewUidB > 0) {
		if($listView) $LimitNumber = $listView;
		else $LimitNumber = "20";
		
		## 제품별 클릭수를 클릭수가 많은 순으로 보여준다. ##########################################
		$query = "SELECT code, name, price, clickNum FROM odtProduct WHERE clickNum<>'0' ORDER BY clickNum DESC LIMIT $LimitNumber";
		$result = mysql_query($query);
		
		$RankingNum = 1;
		
		while($row = mysql_fetch_array($result)) {
			$ClickProCode = $row[code];
			$ClickProName = $row[name];
			$ClickPrice = number_format($row[price]);
			$ClickNum = $row[clickNum];

			$Percent = round(100 * $ClickNum / $NewUidB);
			$Pixel = ceil(325 * $Percent / 100);
			$PixelE = 365 - $Pixel - 5;
			$PixelS = 365 - $PixelE - 5;

			echo "
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr height='23'> 
																<td width='55' align='center' bgcolor='FAFAFA'>$RankingNum</td>
																<td bgcolor='FAFAFA' align='left'><img src='blank.gif' width='11' height='1'>$ClickProName</td>
																<td width='75' align='center' bgcolor='FAFAFA'><b>$ClickNum</b></td>
																<td width='370' align='center' bgcolor='FAFAFA'>
																	<table width='365' height='16' border='0' cellspacing='0' cellpadding='0'>
																		<tr> 
																			<td width='5'>&nbsp;</td>
																			<td width='$PixelS'> 
																				<table width='$PixelS' height='16' border='0' cellspacing='0' cellpadding='0' height='8' background='../odimages/pix03.gif'>
																					<tr> 
																						<td></td>
																					</tr>
																				</table>
																			</td>
																			<td width='$PixelE' class='text-2'>&nbsp;$Percent%</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>";

			$RankingNum++;
		}
	}
	else {
		echo "
															<tr>
																<td height='45' class='text-2' align='center'>클릭된 상품이 없습니다.</td>
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