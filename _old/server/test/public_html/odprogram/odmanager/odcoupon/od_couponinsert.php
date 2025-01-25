<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";

	## 세부권한 체크
	if($row_admin[memberLevel] < 3) {
		error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
	}
?>

		<script language="javascript">
			function valueCheck(form) {
				var form = document.snsForm;

			}
			function search() {
				window.open('od_couponUserSearch.php','','width=800,height=800,scrollbars=yes');
			}
		</script>
		<iframe name="hidden_frame" src="about:blank" style="display:none"></iframe>
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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 쿠폰관리 &gt; <span class="st">쿠폰등록</span></font></td>
												</tr>
												<tr> 
													<td height="2" bgcolor="D6D6D6"></td>
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
															<!-- form start ---------------------------------------->
															<form name="snsForm" method="post" action="od_couponPro.php" onSubmit="return valueCheck(this)" target="hidden_frame">
																<input type="hidden" name="subMode" value="ins">
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td height="35" width="150" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">쿠폰유형</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<select name="coType" style="border">
																				<option value="이벤트쿠폰">이벤트쿠폰</option>
																				</select></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td height="35" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">쿠폰제목</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" size=50 name="coName" class="border" value=""></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td height="35" bgcolor="ececec" class="white" style="padding:5px;" height="31"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">쿠폰가격</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" size="10" name="coPrice" class="border" value=""></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td height="35" bgcolor="ececec" class="white" style="padding:5px;" height="31"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">쿠폰만료일</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="coLimit" size="10" id="ipt01" name="coLimit" class="border" value="<?=date('Y-m-d')?>" readonly style="cursor:hand">
																	<script>var cal1 = new jsCalendar(document.getElementById('ipt01'));</script>																	
																	</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td height="35" bgcolor="ececec" class="white" style="padding:5px;" height="31"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">발급유저</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="button" value="유저검색" class="border" onclick="search()"><br>
																	&nbsp;<textarea name="coIDArray" style="width:400px;height:100px" class="border" ></textarea><br>
																	&nbsp;2명 이상일 경우에는 쉼표(,)로 구분하세요.</td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="15" bgcolor="FFFFFF"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="1" cellpadding="0">
															<tr> 
																<td align="center">
																	<!-- 접근권한(수정) -->
<? 
		if($row_admin[superLevel]==5 || $row_admin[superLevel]==9) { 
?>
																	<input type="image" src="../odimages/odmain/btn_ok.gif" width="77" height="24" hspace="3" border="0" onfocus='this.blur();'> 
<? 
		}
		else { 
?>
																	<a href='javascript:reject();' onfocus='this.blur();'><img src="../odimages/odmain/btn_ok.gif" width="77" height="24" hspace="3" border="0"></a> 
<? 
		} 
?>
																	<a onclick="reset();" onfocus='this.blur();' style='cursor:hand;'><img src="../odimages/odmain/btn_cancel.gif" width="77" height="24" hspace="3" border="0"></a>
																	<a href="od_couponlist.php" onfocus='this.blur();'><img src="../odimages/btn_list.gif" hspace="3" border="0"></a></td>
															</tr>
															</form>
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
		<script language="Javascript" src="/odprogram/geditor/geditor.js"></script>
	</body>
</html>
