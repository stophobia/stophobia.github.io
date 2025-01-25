<?
	# 2011-01-21 오전 10:50 박종익 수정중
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";

	## 세부권한 체크
	if($row_admin[gongguLevel]==5 || $row_admin[gongguLevel]==9 || $row_admin[superLevel]==9) {
	}
	else {
		error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
	}
	
	if(!$form) {
		$row = mysql_fetch_array(mysql_query("SELECT * FROM odtBoardFilter"));
?>

		<script language="javascript">
			function reSize(formname,size) {
				if(size == 'reset') {
					formname.rows = 15;
				}else{
					var value = formname.rows+size;
					if(value>0) formname.rows = value
					else return;
				}
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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 필터링 관리 &gt; <span class="st">필터링 관리</span></font></td>
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
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="18"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">필터링 할 단어를 <font color="red">쉼표(<b>,</b>)로 구분</font>하여 설정해 주시기 바랍니다.</font></td>
												</tr>
												<tr> 
													<td height="18"> <font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">올바른 입력 : 단어1,단어2,단어3,단어4,단어5,단어6,단어7,단어8,단어9,단어10,단어11</font></td>
												</tr>
												<tr> 
													<td height="18"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">올바르지 않은 입력 : 단어1,단어2,단어3,단어4,단어5, → (마지막에 , 를 입력하시면 안됩니다.)</font></td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="1" cellpadding="0">
												<tr> 
													<td height="3"></td>
												</tr>
											</table>
											<table width="760" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td width="760" valign="top">
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<!-- form start --------------------------------------------->
															<form name="snsForm" method="post" action="od_boardfiltermodify.php" enctype="multipart/form-data">
																<input type="hidden" name="form" value="setupForm">
															<tr> 
																<td width="160" height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">필터링할 단어(문장)</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	<table width="99%" border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td>&nbsp;</td>
																			<td align="right">
																				<a href="javascript:reSize(document.snsForm.filter,5)" onfocus='this.blur();'><img src="../odimages/button_plus.gif" border="0" align="absmiddle"></a>
																				<a href="javascript:reSize(document.snsForm.filter,'reset')" onfocus='this.blur();'><img src="../odimages/button_reset.gif" border="0" align="absmiddle"></a>
																				<a href="javascript:reSize(document.snsForm.filter,-5)" onfocus='this.blur();'><img src="../odimages/button_minus.gif" border="0" align="absmiddle"></a>
																			</td>
																		</tr>
																		<tr>
																			<td colspan="2" height="3"></td>
																		</tr>
																		<tr>
																			<td colspan="2">
																				&nbsp;<textarea name="filter" class="border" rows="15" cols="93"><?=stripslashes($row[filter])?></textarea><br>
																				<img src="blank.gif" width="1" height="2"><br><font color="313D7D">
																				&nbsp;* 필터링할 단어나 혹은 문장을 입력하시면 글 등록시 글내용과의 비교를 통해 글등록이 제한됩니다.</font></td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="15" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">첨부파일 필터설정</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	<table width="99%" border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td>&nbsp;</td>
																			<td align="right">
																				<a href="javascript:reSize(document.snsForm.filefilter,5)" onfocus='this.blur();'><img src="../odimages/button_plus.gif" border="0" align="absmiddle"></a>
																				<a href="javascript:reSize(document.snsForm.filefilter,'reset')" onfocus='this.blur();'><img src="../odimages/button_reset.gif" border="0" align="absmiddle"></a>
																				<a href="javascript:reSize(document.snsForm.filefilter,-5)" onfocus='this.blur();'><img src="../odimages/button_minus.gif" border="0" align="absmiddle"></a>
																			</td>
																		</tr>
																		<tr>
																			<td colspan="2" height="3"></td>
																		</tr>
																		<tr>
																			<td colspan="2">
																				&nbsp;<textarea name="filefilter" class="border" rows="15" cols="93"><?=stripslashes($row[filefilter])?></textarea><br>
																				<img src="blank.gif" width="1" height="2"><br><font color="313D7D">
																				&nbsp;* 필터링할 파일의 확장자명을 설정하시면 설정된 확장자를 갖는 파일은 업로드가 제한됩니다.</font></td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
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
																	<input type="image" src="../odimages/odmain/btn_ok.gif" width="77" height="24" hspace="3" style='cursor:hand;' onfocus='this.blur();'>
																	<a onclick="reset();" onfocus='this.blur();' style='cursor:hand;'><img src="../odimages/odmain/btn_cancel.gif" width="77" height="24" hspace="3" border="0"></a></td>
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
	</body>
</html>
<?
	}
	else if(!strcmp($form,"setupForm")) {
		$filter = addslashes(trim($filter));
		$filefilter = addslashes(trim($filefilter));
		
		$result = mysql_query("UPDATE odtBoardFilter SET filter='$filter',filefilter='$filefilter'");
		
		if($result) {
			echo "
				<script>
					window.alert('수정이 잘 되었습니다.   ');
				</script>";

			echo "<meta http-equiv='Refresh' content='0; URL=od_boardfiltermodify.php'>";
			exit;
		}
		else {
			echo "
				<script>
					window.alert('수정되지 않았습니다.   ');
					history.go(-1);
				</script>";

			exit;
		}
	}
	else {
		echo "<div align='center' class='fes'><br><br><br><br><font color='red'>허용되지 않은 접근 방식입니다.</font></div>";
		exit;
	}
?>