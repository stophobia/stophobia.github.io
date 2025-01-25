<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";

	## 세부권한 체크
	if($row_admin[superLevel]==9) {
	}
	else {
		error_msgloc("$folderpath_manager/","슈퍼관리자만 방문로그 기본환경설정을 하실 수 있습니다.   ");
	}

	if(!strcmp($Form,"")) {
		$row = mysql_fetch_array(mysql_query("SELECT * FROM odtCounterConfig WHERE serialnum='1'"));
		
		$Cookie_Use = $row[Cookie_Use];
		$Cookie_Term = $row[Cookie_Term];
		$Counter_Use = $row[Counter_Use];
		$Now_Connect_Use = $row[Now_Connect_Use];
		$Route_Use = $row[Route_Use];
		$Now_Connect_Term = $row[Now_Connect_Term];
		$Total_Num = $row[Total_Num];
		$Total_NumD = number_format($Total_Num);
		$Admin_Check_Use = $row[Admin_Check_Use];
		$Admin_IP = $row[Admin_IP];
?>

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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 방문로그분석 &gt; <span class="st">카운터 기본환경설정</span></font></td>
												</tr>
												<tr> 
													<td height="2" bgcolor="D6D6D6"></td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="1" cellpadding="0">
												<tr>
													<td height="15">&nbsp;</td>
												</tr>
											</table>
											<!-- form start -->
											<table width="760" border="0" cellspacing="0" cellpadding="0">
												<form name="CountConfigForm" method="post" action="od_config.php">
													<input type="hidden" name="Form" value="ModifyForm">
													<input type="hidden" name="Now_Connect_Use" value="N">
													<input type="hidden" name="Now_Connect_Term" value="30">
												<tr> 
													<td width="760" valign="top">
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr style='display:'> 
																<td width="190" height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr style='display:none'> 
																<td height="35" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">카운터 사용여부</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	<input type="radio" name="Counter_Use" value="Y" <? if($Counter_Use == "Y") echo" checked"; ?>>사용함
																	<input type="radio" name="Counter_Use" value="N" <? if($Counter_Use == "N") echo" checked"; ?>>사용하지않음
																</td>
															</tr>
															<tr style='display:none'> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr style='display:none'> 
																<td height="7" colspan="2"></td>
															</tr>
															<tr style='display:none'> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr style='display:none'> 
																<td height="35" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">접속경로 사용여부</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	<input type="radio" name="Route_Use" value="Y" <? if($Route_Use == "Y") echo" checked"; ?>>사용함 
																	<input type="radio" name="Route_Use" value="N" <? if($Route_Use == "N") echo" checked"; ?>>사용하지않음
																</td>
															</tr>
															<tr style='display:none'> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr style='display:none'> 
																<td height="7" colspan="2"></td>
															</tr>
															<tr style='display:none'> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="35" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">전체 방문자수</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="Total_Num" size="10" value="<?=$Total_Num?>" class="border" style='text-align:right;'><b> 명 
																</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" colspan="2"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr style='display:none'> 
																<td height="35" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">중복 접속설정</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	<input type="radio" name="Cookie_Use" value="A" <? if($Cookie_Use == "A") echo" checked"; ?>>접속하는대로 카운터 증가<br>
																	<input type="radio" name="Cookie_Use" value="T" <? if($Cookie_Use == "T") echo" checked"; ?>>지정된시간대로 카운터 증가<br>
																	<input type="radio" name="Cookie_Use" value="O" <? if($Cookie_Use == "O") echo" checked"; ?>>하루에 한번만 카운터 증가 
																</td>
															</tr>
															<tr style='display:none'> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr style='display:none'> 
																<td height="7" colspan="2"></td>
															</tr>
															<tr style='display:none'> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr style='display:none'> 
																<td height="35" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">중복접속시간설정</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="Cookie_Term" size="10" value="<?echo"$Cookie_Term";?>" class="border" style='text-align:right;'><b> 초
																</td>
															</tr>
															<tr style='display:none'> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr style='display:none'> 
																<td height="7" colspan="2"></td>
															</tr>
															<tr style='display:none'> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="35" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">관리자 통계포함</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	<input type="radio" name="Admin_Check_Use" value="Y" <? if($Admin_Check_Use == "Y") echo" checked"; ?>>포함함 
																	<input type="radio" name="Admin_Check_Use" value="N" <? if($Admin_Check_Use == "N") echo" checked"; ?>>포함하지않음
																</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" colspan="2"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="35" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">관리자접속 아이피(IP)</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="Admin_IP" size="45" value="<?echo"$Admin_IP";?>" class="border">
																</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" colspan="2"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="35" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">접속경로별 접속자료 초기화</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="button" onClick="self.location.replace('od_delete.php?mode=ROUTE')" value=" 접속경로별 접속자료 초기화 " class="button_tag">
																</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" colspan="2"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="35" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">운영체제별 접속자료 초기화</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="button" onClick="self.location.replace('od_delete.php?mode=OS')" value=" 운영체제별 접속자료 초기화 " class="button_tag">
																</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" colspan="2"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="35" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">브라우져별접속자료 초기화</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="button" onClick="self.location.replace('od_delete.php?mode=BROWSER')" value=" 브라우져별 접속자료 초기화 " class="button_tag">
																</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" colspan="2"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="35" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">전체접속자료 초기화</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="button" onClick="self.location.replace('od_delete.php?mode=ALL')" value=" 전체 접속자료 초기화 " class="button_tag" style="height:35;font-weight:bold;color:FF0000;background-color:#F7F7F7;">
																</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
														</table>
													</td>
												</tr>
											</table> 
											<table width="760" border="0" cellspacing="1" cellpadding="0">
												<tr> 
													<td height="60" align="center">
														<input type="image" onfocus='this.blur();' src="../odimages/odmain/btn_ok.gif" width="77" height="24" hspace="3" border="0">
														<!--<a href="#"><img src="../odimages/odmain/btn_cancel.gif" width="77" height="24" hspace="3" border="0"></a></td>-->
												</tr>
												</form>
											</table>
											<table width="760" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="30">&nbsp;</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td height="5" bgcolor="#FFFFFF"></td>
									</tr>
								</table>
								<!-- main table end -->
								<strong></strong>
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
<?
	}
	else if(!strcmp($Form,"ModifyForm")) {
		mysql_query("UPDATE odtCounterConfig SET Cookie_Use='$Cookie_Use',Cookie_Term='$Cookie_Term',Counter_Use='$Counter_Use',Now_Connect_Use='$Now_Connect_Use',Route_Use='$Route_Use',Now_Connect_Term='$Now_Connect_Term',Total_Num='$Total_Num',Admin_Check_Use='$Admin_Check_Use',Admin_IP='$Admin_IP' WHERE serialnum='1'");
		
		echo "
			<script>
				window.alert('환경설정 변경이 잘 되었습니다.   ');
			</script>";

		echo "<meta http-equiv='Refresh' content='0; URL=od_config.php'>";
		exit;
	}
	else {
		exit;
	}
?>