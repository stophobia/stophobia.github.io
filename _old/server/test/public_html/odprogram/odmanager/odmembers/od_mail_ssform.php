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

?>
<iframe name="hidden_frame" src="about:blank" style='display:none'></iframe>
		<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="FFFFFF">
			<tr> 
				<td height="80" bgcolor="#FFFFFF">
					<!-- top menu start -->
<? include "$folderpath_manager_common/od_topMenu.inc.php"; ?>
					<!-- top menu end -->
				</td>
			</tr>
			<tr> 
				<td  width="100%" valign="top"> 
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="6"></td>
						</tr>
					</table>
					<table  width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="165" height="100%" valign="top"> 
								<!-- left menu start -->
<? include "$folderpath_manager_common/od_leftMenu.inc.php"; ?>
								<!-- left menu end -->
							</td>
							<td width="3">&nbsp;</td>
							<td  width="100%"  valign="top">
								<!-- main table start -->
								<table width="700"  height="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="D6D6D6">
									<tr> 
										<td  width="100%" align="center" valign="top" bgcolor="#FFFFFF"> 
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 회원목록 &gt; <span class="st">구독자 일괄등록</span></font> </td>
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




											<table  width="100%"  border="0" cellspacing="1" cellpadding="5" bgcolor=aaaaaa>
<form name="feedFrm" method="post" enctype="multipart/form-data" action="od_mail_sspro.php">
												<tr height='27'>
													<td width="100" bgcolor="ececec" class="white">CSV파일</td>
													<td width="750" bgcolor='FAFAFA'>
														<input type="file" name="all_reg" class="border" size=40><br>
														반드시 <font color="red"><b>등록하시는 파일은 CSV(쉼표로 분리)</b></font>여야 합니다.
													</td>
												</tr>
												<tr height='30'>
													<td colspan=2 bgcolor='FAFAFA' align=center>

														<input type="image" src="../odimages/odmain/btn_ok.gif" width="77" height="24" hspace="3" border="0" onfocus='this.blur();'> 
														<a href="od_mailSMSList.php" onfocus='this.blur();'><img src="../odimages/btn_list.gif" hspace="3" border="0"></a></td>
						

													</td>
												</tr>
</form>
											</table><br>


											<table  width="100%"  border="0" cellspacing="1" cellpadding="5" bgcolor=aaaaaa>
												<tr height='30'>
													<td bgcolor='FAFAFA'><b>※일괄등록할 CSV 내용 예제는 아래와 같습니다.</b></td>
												</tr>
												<tr height='30'>
													<td bgcolor='FFFFFF' align=center>

																<br><table  width="50%"  border="0" cellspacing="1" cellpadding="5" bgcolor=aaaaaa align=center>
																	<tr align="center" height="27" bgcolor="ececec"> 
																		<td width="50%" class="white">A열 - E-mail</td>
																		<td width="50%" class="white">B열 - 핸드폰</td>
																	</tr>
																	<tr height='27' align='center'> 
																		<td bgcolor='FAFAFA'>help@onedaynet.co.kr</td>
																		<td bgcolor='FAFAFA'>010-1234-5678</td>
																	</tr>
																	<tr height='27' align='center'> 
																		<td bgcolor='FAFAFA'>tech@onedaynet.co.kr</td>
																		<td bgcolor='FAFAFA'>&nbsp;</td>
																	</tr>
																	<tr height='27' align='center'> 
																		<td bgcolor='FAFAFA'>&nbsp;</td>
																		<td bgcolor='FAFAFA'>010-9876-5432</td>
																	</tr>
																</table><br>

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