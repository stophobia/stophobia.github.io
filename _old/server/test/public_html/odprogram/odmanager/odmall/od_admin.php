<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";

	## 세부권한 체크
	if($row_admin[smanagerLevel] < 3) {
		error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
	}

	if($row_admin[superLevel] == 9) {
		$adminTemp1 = "od_admininput.php";
		$deleteTemp1 = "checkSelect(this.form);";		
	}
	else {
		$adminTemp1 = "javascript:reject();";
		$deleteTemp1 = "javascript:reject();";
	}
	
	if($key) $search_value .= " AND ".$search." LIKE '%".$key."%'";
	
	$qry_MAL = "SELECT serialnum, id, name, email, agentName, htel, superLevel, inputDate FROM odtAdmin WHERE serialnum!=''".$search_value." ORDER BY superLevel DESC,serialnum DESC";
	$res_MAL = mysql_query($qry_MAL);
	$num_MAL = mysql_num_rows($res_MAL);

	$total = $num_MAL;
	
	$LineNumber = 10;
	$LinkNumber = 10;
	$TotalPage = ceil($total / $LineNumber);
	
	if($page>$TotalPage) { 
		$page=1; 
		$first=1; 
		$last=0; 
	}

	if(!$page) $page = 1;
	
	if(!$total) {
		$first = 1;
		$last = 0;   
	}
	else {
		$first = $LineNumber * ($page - 1);
		$last = $LineNumber * $page;
		$NomLine = $total - $last;
		
		if($NomLine > 0) $last -= 1;
		else $last = $total - 1;
	}
?>

		<script>
			function checkSelect(form) {
				var check_nums = document.allDelete.elements.length;
				for (var i = 0; i < check_nums;  i++) {
					var checkbox_obj = eval("document.allDelete.elements[" + i + "]");
					if (checkbox_obj.checked == true) {
						break;
					}
				}
				if(i == check_nums) {
					alert ("먼저 삭제하고자 하는 상품을 선택하여 주세요.   ");
					return;
				}else {
					document.allDelete.submit();
				}
			}
			function selectAll() {
				var form = document.allDelete;
				for (var i=0;i<form.elements.length;i++) {
					obj_str = eval(form.elements[i]);
					obj_str.checked = !obj_str.checked;
				}
			}
		</script>

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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 상점기본관리 &gt; <span class="st">관리자 리스트</span></font></td>
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
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="18"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">관리자의 이름 또는 아이디를 클릭하시면 상세(수정)페이지를 보실 수 있습니다.</font></td>
												</tr>
												<tr>
													<td height="7"></td>
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
															<!-- delete form start -->
															<form name="allDelete" method="post" action="od_admindelete.php">
																<input type="hidden" name="page" value="<?=$page?>">
																<input type="hidden" name="search" value="<?=$search?>">
																<input type="hidden" name="key" value="<?=$key?>">
															<tr>
																<td><img src="../odimages/odmain/page_icon.gif" width="14" height="11"> 
																	<font color="3960AC">전체 <strong><?=$TotalPage?></strong>페이지 [<strong><?=$total?></strong>]명</font></td>
																<td align="right"><a href="<?=$adminTemp1?>"><img src="../odimages/btn_admin_input.gif" width="77" height="24" border="0" onfocus='this.blur();'></a> 
																	<a href="#" onClick="<?=$deleteTemp1?>"><img src="../odimages/odmain/btn_delete.gif" width="77" height="24" border="0"></a></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="1" colspan="11" bgcolor="c0bebe"></td>
															</tr>
															<tr align="center"> 
																<td width="45" height="27" bgcolor="ececec" class="white">번호</td>
																<td width="40" bgcolor="ececec" class="white"><a href="javascript:selectAll();" class="white" onfocus='this.blur();' title=' 클릭 하시면 목록 전체를 선택 또는 해제 합니다. '>전체</a></td>
																<td bgcolor="ececec" class="white">아이디</td>
																<td width="85" bgcolor="ececec" class="white">이름</td>
																<td width="198" bgcolor="ececec" class="white" style="padding-left:7;" align="left">E-mail</td>
																<td width="105" bgcolor="ececec" class="white">전화번호</td>
																<td width="80" bgcolor="ececec" class="white">슈펴관리자</td>
																<td width="80" bgcolor="ececec" class="white">등록일</td>
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
<?	
	if(!$total) {
		echo "
															<tr>
																<td height='55' align='center' colspan='11'>등록된 관리자가 없습니다.</td>
															</tr>";
	}

	$serialnumber = $total - $LineNumber * ($page - 1);
	$cin = 1;

	for($i=$first;$i<=$last;$i++) {
		mysql_data_seek($res_MAL,$i);
		$row = mysql_fetch_array($res_MAL);
		
		if($row[superLevel] == 9) $superTemp = "<font color='FF0000'><b>슈퍼관리자</b></font>";
		else $superTemp = "-";
		
		## 접근권한 설정(수정)
		if($row_admin[smanagerLevel]==5 || $row_admin[superLevel]==9) 
			$modifyTemp1 = "od_adminmodify.php?serialnum=$row[serialnum]&page=$page&search=$search&key=$key";
		else $modifyTemp1 = "javascript:reject();";

		echo "
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td width='45' align='center' bgcolor='FAFAFA'>$serialnumber</td>
																<td width='40' align='center' bgcolor='FAFAFA'><input type='checkbox' name='serialnum[]' value='$row[serialnum]' $id_str ></td>
																<td align='center' bgcolor='FAFAFA' class='cate'>
																	<a href='$modifyTemp1'>$row[id]</a></td>
																<td width='85' align='center' bgcolor='FAFAFA' class='cate'>
																	<a href='$modifyTemp1'>$row[name]</a></td>
																<td width='198' bgcolor='FAFAFA' style='padding-left:7;'>$row[email]</td>
																<td width='105' align='center' bgcolor='FAFAFA'>$row[htel]</td>
																<td width='80' align='center' bgcolor='FAFAFA'>$superTemp</td>
																<td width='80' align='center' bgcolor='FAFAFA'>".date("Y-m-d",$row[inputDate])."</td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>";

		$serialnumber--;
	}
?>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="2" colspan="3"></td>
															</tr>
															<tr> 
																<td height="1" colspan="3" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="3" colspan="3"></td>
															</tr>
															<tr> 
																<td width="160">&nbsp;</td>
																<td width="440" align="center" class="num">
																	<a href='od_admin.php?page=1&search=<?=$search?>&key=<?=$key?>'>
																	<img src="../odimages/odmain/num_arrow_pre2.gif" width="13" height="11" border='0' alt="처음페이지" align="absmiddle"></a>
<?
	$TotalJump = ceil($TotalPage / $LinkNumber);
	$Jump = ceil($page / $LinkNumber);
	$FirstPage = ($Jump - 1) * $LinkNumber;
	$LastPage = $Jump * $LinkNumber;
	
	if($Jump >= $TotalJump) $LastPage = $TotalPage;
	
	if($Jump > 1) {
		$PrePage = $FirstPage;
		echo "<a href='od_admin.php?page=$PrePage&search=$search&key=$key'><img src='../odimages/odmain/num_arrow_pre1.gif' width='35' height='11' hspace='3' border='0' alt='이전 ${LinkNumber}개'></a> / ";
	}
	else {
		echo " / ";
	}
	
	for($NowPage = $FirstPage+1; $NowPage <= $LastPage; $NowPage++) {
		if($page == $NowPage) echo "<b>$NowPage</b> / ";
		else echo "<a href='od_admin.php?page=$NowPage&search=$search&key=$key'>$NowPage</a> / ";
	}

	if($Jump < $TotalJump) {
		$PrePage = $LastPage+1;
		echo "<a href='od_admin.php?page=$PrePage&search=$search&key=$key'><img src='../odimages/odmain/num_arrow_next2.gif' width='35' height='11' hspace='3' border='0' alt='다음 ${LinkNumber}개'></a>";
	}
?>
																	<a href='od_admin.php?page=<?=$TotalPage?>&search=<?=$search?>&key=<?=$key?>'>
																	<img src="../odimages/odmain/num_arrow_next1.gif" width="13" height="11" border='0' alt="마지막페이지" align="absmiddle"></a>
																</td>
																<td width="160" align="right"><a href="od_admininput.php"><img src="../odimages/btn_admin_input.gif" width="77" height="24" border="0" onfocus='this.blur();'></a>
																	<a href="#" onClick="<?=$deleteTemp1?>"><img src="../odimages/odmain/btn_delete.gif" width="77" height="24" border="0"></a></td>
															</tr>
															<tr> 
																<td height="7" colspan="3"></td>
															</tr>
															<!-- delete form end -->
															</form>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<form method="post" action="od_admin.php">
															<tr> 
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="37" align="center">
																	<table border="0" cellspacing="2" cellpadding="0">
																		<tr>
																			<td>
																				<select name="search">
																				<option value="name"<?if($search=="name")echo" selected"?>>이름</option>
																				<option value="id"<?if($search=="id")echo" selected"?>>아이디</option>
																				<option value="agentName"<?if($search=="agentName")echo" selected"?>>소속지점명</option>
																				</select>
																			</td>
																			<td><input name="key" type="text" class="border" size="35" value="<?=$key?>"></td>
																			<td><input type="image" src="../odimages/odmain/btn_search.gif" width="43" height="19"></td>
																		</tr>
																	</table>
																</td>
															</tr>
															</form>
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