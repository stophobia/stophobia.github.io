<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";

	## 세부권한 체크
	if($row_admin[smsLevel]==3 || $row_admin[superLevel]==9) {
	}
	else {
		error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
	}
	
	if(!$form) {
		$row = mysql_fetch_array(mysql_query("SELECT * FROM odtSms WHERE serialnum='1'"));
		
		$minput_use_division = explode("/",$row[minput_use]);
		$oinput_use_division = explode("/",$row[oinput_use]);
		$pinput_use_division = explode("/",$row[pinput_use]);
		$cinput_use_division = explode("/",$row[cinput_use]);
		$dinput_use_division = explode("/",$row[dinput_use]);
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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 상점 기본관리 &gt; <span class="st">SMS 기본정보 설정</span></font></td>
												</tr>
												<tr> 
													<td height="2" bgcolor="D6D6D6"></td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="1" cellpadding="0">
												<tr> 
													<td height="11"></td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="18"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5"><b>SMS 서비스</b> 환경을 설정 합니다.</font></td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="3"></td>
												</tr>
											</table>
											<table width="760" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td width="760" valign="top">
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<!-- form start ------------------------------>
															<form name="modForm" method="post" action="<?=$php_self?>">
																<input type="hidden" name="form" value="modifyForm">
															<tr> 
																<td width="165" height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">SMS 아이디</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input name="sms_id" type="text" class="border" size="45" value="<?=$row[sms_id]?>"><br>
																	<img src="" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 원데이넷으로 부터 부여받으신 아이디를 설정 합니다.</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="15" bgcolor="FFFFFF" colspan="2"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">SMS 비밀번호</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input name="sms_pw" type="text" class="border" size="45" value="<?=$row[sms_pw]?>"><br>
																	<img src="" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 원데이넷으로 부터 부여받으신 비밀번호를 설정 합니다.</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="15" bgcolor="FFFFFF" colspan="2"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>

															<tr> 
																<td height="15" bgcolor="FFFFFF" colspan="2"></td>
															</tr>
															<tr> 
																<td align="center" colspan="2">
																	<input type="image" src="../odimages/odmain/btn_ok.gif" width="77" height="24" hspace="3" style='cursor:hand;' onfocus='this.blur();'>
																	<a onclick="reset();" onfocus='this.blur();' style='cursor:hand;'><img src="../odimages/odmain/btn_cancel.gif" width="77" height="24" hspace="3" border="0"></a></td>
															</tr>
															</form>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="15" bgcolor="FFFFFF"></td>
															</tr>
														</table>
													</td>
												</tr>
												<tr> 
													<td height="15" valign="top"></td>
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
<?
	}
	else if(!strcmp($form,"modifyForm")) {
		$sms_id = trim($sms_id);
		$sms_pw = trim($sms_pw);
		$minput_use = $minput_use1."/".$minput_use2."/".$minput_use3;
		$oinput_use = $oinput_use1."/".$oinput_use2."/".$oinput_use3;
		$pinput_use = $pinput_use1."/".$pinput_use2."/".$pinput_use3;
		$cinput_use = $cinput_use1."/".$cinput_use2."/".$cinput_use3;
		$dinput_use = $dinput_use1."/".$dinput_use2."/".$dinput_use3;
		
		$qry = "update odtSms set sms_id='$sms_id', sms_pw='$sms_pw', sms_port='$sms_port', minput_use='$minput_use', oinput_use='$oinput_use', pinput_use='$pinput_use', cinput_use='$cinput_use', dinput_use='$dinput_use' where serialnum='1'";
		$res = mysql_query($qry);
		
		if($res) {
			error_msgloc("od_sms.php","수정이 잘 되었습니다.   ");
		}
		else {
			Error_error_msgloc("수정되지 않았습니다.   ");
		}
		
		exit;
	}
	else {
		echo "<div align='center' class='fes'><br><br><br><br><font color='red'>허용되지 않은 접근 방식입니다.</font></div>";
		exit;
	}
?>