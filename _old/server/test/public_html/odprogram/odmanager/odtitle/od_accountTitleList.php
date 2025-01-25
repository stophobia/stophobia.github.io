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
<script>
function delSubmit() {
	frm = document.delFrm;
	obj = frm.elements['noArray[]'];

	if(obj.length < 1) {
		alert('삭제할 항목을 선택하세요');
		return false;
	} else {
		if(confirm('선택한 항목을 삭제하시겠습니까?')) frm.submit();
	}
	return false;
}
</script>
		<iframe name="hiddenFrame" src="about:blank" style="display:none"></iframe>
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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 정산관리 &gt; <span class="st">입출금관리</span></font></td>
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
											<table width="760" border="0" cellspacing="1" cellpadding="0">
												<tr>
													<td height="7"></td>
												</tr>
											</table>
											<table width="760" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td valign="top">
														<form name="delFrm" method="post" action="od_accountTitlePro.php" target="hiddenFrame">
														<input type="hidden" name="subMode" value="del">
														<table width=100% border=0 cellpadding=0 cellspacing=0>
															<tr>
																<td height=40 align=right>
																<a href="./od_accountTitleInsert.php"><img type="image" src="/images/btn_input.gif" border=0></a> 
																<a href="#none" onclick="delSubmit()"><img src="/odprogram/odmanager/odimages/odmain/btn_delete.gif" border=0></a>																
																</td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="1" colspan="11" bgcolor="c0bebe"></td>
															</tr>
															<tr align="center"> 
																<td width="40" bgcolor="ececec" class="white">전체</td>
																<td width=100 bgcolor="ececec" class="white">유형</td>
																<td bgcolor="ececec" class="white" style='text-align:left'>제목</td>
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
																<td height="1" colspan="11" bgcolor="D2D2D2"></td>
															</tr>
<?

	## 전체 MD의 수를 구한다. ###################################################
	$que = "SELECT * FROM odtAccountTitle";
	$res = mysql_query($que);
	$total = mysql_num_rows($res);
	if(!$total) {
		echo "
															<tr>
																<td height='75' align='center' colspan='11'>등록된 계정이 없습니다.</td>
															</tr>";
	}
	
	while($row = mysql_fetch_array($res)) {
		echo "
															<tr> 
																<td height='3' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td width='40' height=30 align='center' bgcolor='FAFAFA' class='cate'><input type='checkbox' name='noArray[]' value='".$row[no]."'></td>
																<td  width=100 bgcolor='FAFAFA' class='cate' align=center>".$row['type']."</td>
																<td  height=30 bgcolor='FAFAFA' class='cate' align=''><a href='./od_accountTitleInsert.php?no=".$row[no]."'>".$row[name]."</a></td>
															</tr>
															<tr> 
																<td height='3' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>";


	}
?>
														</table>
														<table width=100% border=0 cellpadding=0 cellspacing=0>
															<tr>
																<td height=40 align=right>
																<a href="./od_accountTitleInsert.php"><img type="image" src="/images/btn_input.gif" border=0></a> 
																<a href="#none" onclick="delSubmit()"><img src="/odprogram/odmanager/odimages/odmain/btn_delete.gif" border=0></a>
																</td>
															</tr>
														</table>
														</form>
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