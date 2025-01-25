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

	$subMode = $_GET[p_idx] ? "edt" : "ins";
	if($subMode == "edt") {
		$row = mysql_fetch_array(mysql_query("select * from odtPopup where p_idx = '".$_GET[p_idx]."'"));
	}


	if($row[p_startdate] && $row[p_startdate]<>'0000-00-00') 	$p_startdate = $row[p_startdate];
	else 	 $p_startdate = date('Y-m-d');

	if($row[p_enddate] && $row[p_enddate]<>'0000-00-00')		$p_enddate = $row[p_enddate];
	else $p_enddate = date('Y-m-d',strtotime("+1 day"));


?>

		<script language="javascript">
			function valueCheck(form) {
				var form = document.snsForm;

			}
		</script>
		<iframe name="hiddenFrame" src="about:blank" style="display:none"></iframe>
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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 일반관리 &gt; <span class="st">팝업등록</span></font></td>
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
															<form name="snsForm" method="post" action="od_popupPro.php" onSubmit="return valueCheck(this)" target="hiddenFrame">
																<input type="hidden" name="p_idx"	value="<?=$row[p_idx]?>">
																<input type="hidden" name="subMode" value="<?=$subMode?>">
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td height="35" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">제목</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" size=50 name="p_title" class="border" value="<?=$row[p_title]?>"></td>
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
																<td height="35" bgcolor="ececec" class="white" style="padding:5px;" height="31"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">위치</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp; 
																	위쪽여백 <input type="text" size="4" name="p_top" class="border" value="<?=$row[p_top]?>">px, &nbsp; 
																	오른쪽여백 <input type="text" size="4" name="p_left" class="border" value="<?=$row[p_left]?>">px 
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
																<td height="35" bgcolor="ececec" class="white" style="padding:5px;" height="31"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">
																노출기간</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> &nbsp;
																노출시작일 : <input id='ipt01' type="text" name=p_startdate size=10 class="border" readonly style="cursor:hand" value="<?=$p_startdate?>">
																~ 
																노출종료일 : <input id='ipt02' type="text" name=p_enddate size=10 class="border" readonly style="cursor:hand" value="<?=$p_enddate?>"> 
																<br>&nbsp;
																<script>var cal1 = new jsCalendar(document.getElementById('ipt01'));</script>
																<script>var cal2 = new jsCalendar(document.getElementById('ipt02'));</script>
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
																<td height="35" bgcolor="ececec" class="white" style="padding:5px;" height="31"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">내용</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<textarea name="p_content" style="width:500px;height:200px" class="border" geditor><?=$row[p_content]?></textarea></td>
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
																<td height="35" bgcolor="ececec" class="white" style="padding:5px;" height="31"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">노출여부</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp; <select name="p_view">
																		<option value="N">숨김</option>
																		<option value="Y" <?=$row[p_view] == "Y" ? "selected" : NULL;?>>보임</option>
																	</select>
																	</td>
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
																	<a href="od_popupList.php" onfocus='this.blur();'><img src="../odimages/btn_list.gif" hspace="3" border="0"></a></td>
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
