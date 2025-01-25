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

	$EncodingKey = urlencode($key);

	## 전체 쿠폰의 수를 구한다. ###################################################
	if(!eregi("[^[:space:]]+",$key)) {
		$qry_LML = "SELECT * FROM odtPointLog ORDER BY pointRegidate DESC";
	} else {
		$qry_LML = "SELECT * FROM odtPointLog where ".$search." like '%".$key."%' ORDER BY pointRegidate DESC";
	}

	$res_LML = mysql_query($qry_LML);
	$num_LML = mysql_num_rows($res_LML);

	$total = $num_LML;
	
	$LineNumber = 10;
	$LinkNumber = 10;
	
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

	$TotalPage = ceil($total / $LineNumber);
?>

		<script language="javascript">
			function selectCheck(form) {
				if(!confirm('선택한 내역을 삭제하시겠습니까?')) return false;
				var check_nums = document.memberAlldelete.elements.length;
				for (var i = 0; i < check_nums;  i++) {
					var checkbox_obj = eval("document.memberAlldelete.elements[" + i + "]");
					if (checkbox_obj.checked == true) {
						break;
					}
				}
				if(i == check_nums) {
					alert ("먼저 삭제할 항목을 선택하여 주세요.   ");
					return;
				}else {
					document.memberAlldelete.submit();
				}
			}
			function selectAll() {
				var form = document.memberAlldelete;
				for(var i=0;i<form.elements.length;i++) {
					obj_str = eval(form.elements[i]);
					obj_str.checked = !obj_str.checked;
				}
			}
			function searchCheck(form) {
				var form = document.snsSearch;
				if(!form.search.value) {
					alert("검색조건을 선택해 주세요.   ");
					form.search.focus();
					return false;
				}
			}
			function saveExcel(fileTemp) {
				top.location=''+fileTemp;
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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 회원관리 &gt; <span class="st">포인트관리</span></font></td>
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
															<form name="memberAlldelete" method="post" action="od_pointPro.php" target="hiddenFrame">
															<input type="hidden" name="subMode" value="del">
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td><img src="../odimages/odmain/page_icon.gif" width="14" height="11"> 
																	<font color="3960AC">전체 <strong><?=$TotalPage?></strong>페이지</font></td>
																<td align="right">
																	<a href="./od_pointinsert.php"><img src="../odimages/odmain/point_insert.gif" width="77" height="24" border="0"></a>
																	<a onclick="selectCheck()" style='cursor:hand;' onfocus='this.blur();'><img src="../odimages/odmain/btn_delete.gif" width="77" height="24" border="0"></a></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="1" colspan="11" bgcolor="c0bebe"></td>
															</tr>
															<tr align="center"> 
																<td width="40" bgcolor="ececec" class="white"><a href="javascript:selectAll();" class="white" onfocus='this.blur();' title=' 클릭 하시면 목록 전체를 선택 또는 해제 합니다. '>전체</a></td>
																<td width="80" bgcolor="ececec" class="white">아이디</td>
																<td bgcolor="ececec" class="white">제목</td>
																<td width="80" bgcolor="ececec" class="white">지급포인트</td>
																<td width="80" bgcolor="ececec" class="white">사용포인트</td>
																<td width="80" bgcolor="ececec" class="white">상태</td>
																<td width="80" bgcolor="ececec" class="white">지급예정일</td>
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
	if(!$total) {
		echo "
															<tr>
																<td height='75' align='center' colspan='11'>가입된 회원이 없습니다.</td>
															</tr>";
	}
	
	$serialnumber = $total - $LineNumber * ($page - 1);
	
	for($i=$first;$i<=$last;$i++) {
		mysql_data_seek($res_LML,$i);
		$row = mysql_fetch_array($res_LML);
		
		echo "
															<tr> 
																<td height='3' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td width='40' align='center' bgcolor='FAFAFA'><input type='checkbox' name='memSerialnum[]' value='$row[pointNo]' $id_str ></td>
																<td width='80' height=30 align='center' bgcolor='FAFAFA' class='cate'>".$row[pointID]."</td>
																<td bgcolor='FAFAFA' align='' class='cate'>".$row[pointTitle]."</td>
																<td width='80' align='center' bgcolor='FAFAFA'>".($row[pointPoint] > 0 ? number_format($row[pointPoint]) : NULL)."</td>
																<td width='80' align='center' bgcolor='FAFAFA'>".($row[pointPoint] < 0 ? number_format($row[pointPoint]) : NULL)."</td>
																<td width='80' align='center' bgcolor='FAFAFA'>".($row[pointStatus] == "Y" ? "처리완료" : "지급예정")."</td>
																<td width='80' align='center' bgcolor='FAFAFA'>".$row[redRegidate]."</td>
															</tr>
															<tr> 
																<td height='3' colspan='11' bgcolor='FAFAFA'></td>
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
																<td height="5" colspan="3"></td>
															</tr>
															<tr> 
																<td width="3"></td>
																<td align="center" class='num'>
																	<a href='od_pointlist.php?page=1<?=$par_page?>&search=<?=$search?>&key=<?=$key?>'>
																	<img src="../odimages/odmain/num_arrow_pre2.gif" width="13" height="11" border='0' alt="처음페이지" align="absmiddle"></a>
<?
	$TotalJump = ceil($TotalPage / $LinkNumber);
	$Jump = ceil($page / $LinkNumber);
	$FirstPage = ($Jump - 1) * $LinkNumber;
	$LastPage = $Jump * $LinkNumber;
	
	if($Jump >= $TotalJump) $LastPage = $TotalPage;
	
	if($Jump > 1) {
		$PrePage = $FirstPage;
		echo "<a href='od_pointlist.php?page=$PrePage&search=$search&key=$key'><img src='../odimages/odmain/num_arrow_pre1.gif' width='35' height='11' hspace='3' border='0' alt='이전 ${LinkNumber}개'></a> / ";
	}
	else {
		echo " / ";
	}

	for($NowPage = $FirstPage+1; $NowPage <= $LastPage; $NowPage++) {
		if($page == $NowPage) echo "<b>$NowPage</b> / ";
		else echo "<a href='od_pointlist.php?page=$NowPage&search=$search&key=$key'>$NowPage</a> / ";
	}

	if($Jump < $TotalJump) {
		$PrePage = $LastPage+1;
		echo "<a href='od_pointlist.php?page=$PrePage&search=$search&key=$key'><img src='../odimages/odmain/num_arrow_next2.gif' width='35' height='11' hspace='3' border='0' alt='다음 ${LinkNumber}개'></a>";
	}
?>
																	<a href='od_pointlist.php?page=<?=$TotalPage?>&search=<?=$search?>&key=<?=$key?>'>
																	<img src="../odimages/odmain/num_arrow_next1.gif" width="13" height="11" border='0' alt="마지막페이지" align="absmiddle"></a></td>
																<td width="180" align="right">
																	<a href="./od_pointinsert.php"><img src="../odimages/odmain/point_insert.gif" width="77" height="24" border="0"></a>
																	<a onclick="selectCheck()" style='cursor:hand;' onfocus='this.blur();'><img src="../odimages/odmain/btn_delete.gif" width="77" height="24" border="0"></a></td>
															</tr>
															<tr> 
																<td height="10" colspan="3"></td>
															</tr>
														</table>
															</form>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<form name="snsSearch" method="post" action="od_pointlist.php" onSubmit="return searchCheck(this)">
															<tr> 
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="11" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td align="center">
																	<table border="0" cellspacing="2" cellpadding="0">
																		<tr>
																			<td>
																				<select name="search">
																				<option value="pointID"<?if($search=="pointID")echo" selected"?>>아이디</option>
																				<option value="pointTitle"<?if($search=="pointTitle")echo" selected"?>>제목</option>
																				<option value="pointRegidate"<?if($search=="address")echo" selected"?>>지급일</option>
																				</select>&nbsp;
																			</td>
																			<td><input name="key" type="text" class="border" size="35" value="<?=$key?>">&nbsp;</td>
																			<td><input type="image" src="../odimages/odmain/btn_search.gif" width="43" height="19" onfocus='this.blur();'></td>
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