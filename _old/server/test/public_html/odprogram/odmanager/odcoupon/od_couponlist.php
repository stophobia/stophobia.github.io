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

	## 접근권한 설정(엑셀저장)
	if($row_admin[memberLevel] > 2) $excelTemp1 = "saveExcel('od_excel.php?search=$search&key=$key');";
	else $excelTemp1 = "javascript:reject();";
	
	## 접근권한 설정(삭제)
	if($row_admin[memberLevel] > 6 || $row_admin[superLevel]==9) $deleteTemp1 = "selectCheck(this.form);";
	else $deleteTemp1 = "javascript:reject();";
	
	$EncodingKey = urlencode($key);

	## 전체 쿠폰의 수를 구한다. ###################################################
	if(!eregi("[^[:space:]]+",$key)) {
		$qry_LML = "SELECT * FROM odtCoupon ORDER BY coRegidate DESC";
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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 회원관리 &gt; <span class="st">쿠폰관리</span></font></td>
												</tr>
												<tr> 
													<td height="2" bgcolor="D6D6D6"></td>
												</tr>
											</table>
										<table width="760" border="0" cellspacing="1" cellpadding="0">
												<tr>
													<td height="7"></td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="18"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">회원을 지정하여 쿠폰을 발급할수 있으며, 발급된 쿠폰은 이벤트 쿠폰으로서 상품에 붙는 할인쿠폰과 중복사용이 가능합니다.</font></td>
												</tr>
												<tr> 
													<td height="18"> <font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">회원은 발급받은 쿠폰을 MY페이지에서 확인할 수 있으며, 만료일 내에 사용하여야 합니다.</font></td>
												</tr>
												<tr> 
													<td height="18"> <font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">쿠폰이 발급되면 초기 1회에 한하여 회원이 로그인했을때 알림창으로 쿠폰발급을 알려주오니, 따로 통보할 필요가 없습니다.</font></td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="7" bgcolor="FFFFFF"></td>
												</tr>
												<tr> 
													<td height="2" bgcolor="D2D2D2"></td>
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
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td><img src="../odimages/odmain/page_icon.gif" width="14" height="11"> 
																	<font color="3960AC">전체 <strong><?=$TotalPage?></strong>페이지 [<strong><?=$total?></strong>]명</font></td>
																<td align="right">
																	<a href="./od_couponinsert.php"><img src="../odimages/odmain/cou_insert.gif" width="77" height="24" border="0"></a>
																	<a  href="#none" onclick="<?=$deleteTemp1?>" style='cursor:hand;' onfocus='this.blur();'><img src="../odimages/odmain/btn_delete.gif" width="77" height="24" border="0"></a></td>
															</tr>
														</table>
															<form name="memberAlldelete" method="post" action="od_couponPro.php" target="hidden_frame">
															<input type="hidden" name="subMode" value="del">
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="1" colspan="11" bgcolor="c0bebe"></td>
															</tr>
															<tr align="center"> 
																<td width="40" bgcolor="ececec" class="white"><a href="javascript:selectAll();" class="white" onfocus='this.blur();' title=' 클릭 하시면 목록 전체를 선택 또는 해제 합니다. '>전체</a></td>
																<td width="80" bgcolor="ececec" class="white">아이디</td>
																<td bgcolor="ececec" class="white">제목</td>
																<td width="80" bgcolor="ececec" class="white">할인가격</td>
																<td width="70" bgcolor="ececec" class="white">쿠폰만료일</td>
																<td width="30" bgcolor="ececec" class="white">사용</td>
																<td width="70" bgcolor="ececec" class="white">발급일</td>
																<td width="70" bgcolor="ececec" class="white">사용일</td>
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
																<td height='75' align='center' colspan='11'>내역이 없습니다.</td>
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
																<td width='40' align='center' bgcolor='FAFAFA'><input type='checkbox' name='memSerialnum[]' value='$row[coNo]' $id_str ></td>
																<td width='80' height=30 align='center' bgcolor='FAFAFA' class='cate'>".$row[coID]."</td>
																<td bgcolor='FAFAFA' align='' class='cate'>[".$row[coType]."] ".$row[coName]."</td>
																<td width='80' align='center' bgcolor='FAFAFA'>".number_format($row[coPrice])."</td>
																<td width='70' align='center' bgcolor='FAFAFA'>".($row[coLimit] == "0000-00-00" ? "-" : date('m.d',strtotime($row[coLimit])))."</td>
																<td width='30' align='center' bgcolor='FAFAFA'>".$row[coUse]."</td>
																<td width='70' align='center' bgcolor='FAFAFA'>".(strstr($row[coRegidate],"0000-00-00") ? "-" : date('m.d',strtotime($row[coRegidate])))."</td>
																<td width='70' align='center' bgcolor='FAFAFA'>".(strstr($row[coUsedate],"0000-00-00") ? "-" : date('m.d',strtotime($row[coUsedate])))."</td>
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
																	<a href='od_couponlist.php?page=1<?=$par_page?>'>
																	<img src="../odimages/odmain/num_arrow_pre2.gif" width="13" height="11" border='0' alt="처음페이지" align="absmiddle"></a>
<?
	$TotalJump = ceil($TotalPage / $LinkNumber);
	$Jump = ceil($page / $LinkNumber);
	$FirstPage = ($Jump - 1) * $LinkNumber;
	$LastPage = $Jump * $LinkNumber;
	
	if($Jump >= $TotalJump) $LastPage = $TotalPage;
	
	if($Jump > 1) {
		$PrePage = $FirstPage;
		echo "<a href='od_couponlist.php?page=$PrePage&search=$search&key=$key'><img src='../odimages/odmain/num_arrow_pre1.gif' width='35' height='11' hspace='3' border='0' alt='이전 ${LinkNumber}개'></a> / ";
	}
	else {
		echo " / ";
	}

	for($NowPage = $FirstPage+1; $NowPage <= $LastPage; $NowPage++) {
		if($page == $NowPage) echo "<b>$NowPage</b> / ";
		else echo "<a href='od_couponlist.php?page=$NowPage&search=$search&key=$key'>$NowPage</a> / ";
	}

	if($Jump < $TotalJump) {
		$PrePage = $LastPage+1;
		echo "<a href='od_couponlist.php?page=$PrePage&search=$search&key=$key'><img src='../odimages/odmain/num_arrow_next2.gif' width='35' height='11' hspace='3' border='0' alt='다음 ${LinkNumber}개'></a>";
	}
?>
																	<a href='od_couponlist.php?page=<?=$TotalPage?><?=$par_page?>'>
																	<img src="../odimages/odmain/num_arrow_next1.gif" width="13" height="11" border='0' alt="마지막페이지" align="absmiddle"></a></td>
																<td width="180" align="right">
																	<a href="./od_couponinsert.php"><img src="../odimages/odmain/cou_insert.gif" width="77" height="24" border="0"></a>
																	<a href="#none" onclick="<?=$deleteTemp1?>" style='cursor:hand;' onfocus='this.blur();'><img src="../odimages/odmain/btn_delete.gif" width="77" height="24" border="0"></a></td>
															</tr>
															<tr> 
																<td height="10" colspan="3"></td>
															</tr>
														</table>
															</form>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<form name="snsSearch" method="post" action="<?=$PHP_SELF?>" onSubmit="return searchCheck(this)">
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
																				<option value=""<?if(!$search)echo" selected"?>>* 검색조건 선택</option>
																				<option value="">---------------</option>
																				<option value="id"<?if($search=="id")echo" selected"?>>아이디</option>
																				<option value="name"<?if($search=="name")echo" selected"?>>이름</option>
																				<option value="address"<?if($search=="address")echo" selected"?>>주소</option>
																				<option value="tel"<?if($search=="tel")echo" selected"?>>일반전화</option>
																				<option value="htel"<?if($search=="htel")echo" selected"?>>휴대전화</option>
																				<option value="">---------------</option>
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