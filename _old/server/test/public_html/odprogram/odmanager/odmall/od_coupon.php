<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";

	## 세부권한 체크
	if($row_admin[basicLevel] < 3) {
		error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
	}
	
	## 세부권한 체크(등록,삭제)
	if($row_admin[basicLevel]==5 || $row_admin[superLevel]==9) {
		$inputTemp1 = "od_couponinput.php";
		$deleteTemp1 = "checkSelect(this.form);";
	}
	else {
		$inputTemp1 = "javascript:reject();";
		$deleteTemp1 = "javascript:reject();";
	}
	
	if($key) $search_value .= " AND ".$search." LIKE '%".$key."%'";
	
	$qry_CL = "SELECT serialnum, number, name, couponprice, duedate, term, inputdate FROM odtCoupon WHERE serialnum!=''".$search_value." ORDER BY serialnum DESC";
	$res_CL = mysql_query($qry_CL);
	$num_CL = mysql_num_rows($res_CL);

	$total = $num_CL;
	
	$LineNumber = 10;
	$LinkNumber = 10;
	$TotalPage = ceil($total / $LineNumber);
	
	if($page>$TotalPage) { 
		$page = 1; 
		$first = 1; 
		$last = 0; 
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
				document.allDelete.target = '_self';
					document.allDelete.action = 'od_coupondelete.php';
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
			function viewHistory(cnumber) {
				var winopts = "width=780,height=570,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes";
				var popWindow = window.open('','ciTarget',winopts);
				document.allDelete.target = 'ciTarget';
				document.allDelete.cnumber.value = cnumber;
				document.allDelete.action = 'od_couponhistory.php';
				document.allDelete.submit();
			}
		</script>

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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 상점기본관리 &gt; <span class="st">쿠폰 리스트</span></font></td>
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
													<td height="18"><font color="313D7D">
														<img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">쿠폰번호를 클릭하시면 쿠폰의 발급 현황을 상세하게 보실 수 있습니다.<br>
														<img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">쿠폰의 이름를 클릭하시면 상세(수정)페이지를 보실 수 있습니다.</font></td>
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
															<form name="allDelete" method="post" action="od_coupondelete.php">
																<input type="hidden" name="cnumber" value="">
																<input type="hidden" name="page" value="<?=$page?>">
																<input type="hidden" name="search" value="<?=$search?>">
																<input type="hidden" name="key" value="<?=$key?>">
															<tr>
																<td><img src="../odimages/odmain/page_icon.gif" width="14" height="11"> 
																	<font color="3960AC">전체 <strong><?=$TotalPage?></strong>페이지 [<strong><?=$total?></strong>]개</font></td>
																<td align="right"><a href="<?=$inputTemp1?>"><img src="../odimages/btn_admin_input.gif" width="77" height="24" border="0" onfocus='this.blur();'></a> 
																	<a href="#" onClick="<?=$deleteTemp1?>"><img src="../odimages/odmain/btn_delete.gif" width="77" height="24" border="0"></a></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="1" colspan="9" bgcolor="c0bebe"></td>
															</tr>
															<tr align="center"> 
																<td width="45" height="27" bgcolor="ececec" class="white">번호</td>
																<td width="40" bgcolor="ececec" class="white"><a href="javascript:selectAll();" class="white" onfocus='this.blur();' title=' 클릭 하시면 목록 전체를 선택 또는 해제 합니다. '>전체</a></td>
																<td width="115" bgcolor="ececec" class="white">쿠폰번호</td>
																<td bgcolor="ececec" class="white" align="left"><img src="blank.gif" width="7" height="1">쿠폰이름</td>
																<td width="85" bgcolor="ececec" class="white" align='right' style='padding-right:15;'>금액</td>
																<td width="105" bgcolor="ececec" class="white">휴효기간</td>
																<td width="55" bgcolor="ececec" class="white">총발급수</td>
																<td width="80" bgcolor="ececec" class="white">등록일</td>
																<td width="45" bgcolor="ececec" class="white">수정</td>
															</tr>
															<tr> 
																<td height="1" colspan="9" bgcolor="c0bebe"></td>
															</tr>
															<tr> 
																<td height="2" colspan="9"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0" bgcolor='FAFAFA'>
															<tr> 
																<td height='1' colspan='9' bgcolor='D2D2D2'></td>
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
		mysql_data_seek($res_CL,$i);
		$row = mysql_fetch_array($res_CL);
		
		if($row[duedate] == "yes") $duedateTemp = "<font color='FF0000'><b>유효기간없음</b></font>";
		else $duedateTemp = "발급일로 <font color='blue'>".$row[term]."일</font>간";
		
		$ctotal = mysql_num_rows(mysql_query("SELECT serialnum FROM odtCouponHistory WHERE couponnumber='$row[number]'"));
		
		mysql_query("UPDATE odtCoupon SET offernumber='$ctotal' WHERE number='$row[number]'");
		
		## 세부권한 체크(수정)
		if($row_admin[basicLevel]==5 || $row_admin[superLevel]==9) 
			$modifyTemp1 = "od_couponmodify.php?serialnum=$row[serialnum]&page=$page&search=$search&key=$key";
		else $modifyTemp1 = "javascript:reject();";
		
		## 발급쿠폰 열람
		if($row_admin[basicLevel] < 3) $viewDetail = "javascript:reject();";
		else $viewDetail = "viewHistory('$row[number]');";

		echo "
															<tr> 
																<td height='5' colspan='9' bgcolor='FAFAFA'></td>
															</tr>
															<tr bgcolor='FAFAFA' style='padding-top:5;padding-bottom:5;'> 
																<td width='45' align='center'>$serialnumber</td>
																<td width='40' align='center'><input type='checkbox' name='serialnum[]' value='$row[serialnum]'></td>
																<td width='115' align='center'><font color='blue'><a onclick=\"$viewDetail\" style='cursor:hand;'>$row[number]</a></font></td>
																<td align='left' class='cate'><img src='blank.gif' width='7' height='1'><a href='$modifyTemp1'>$row[name]</a></td>
																<td width='85' align='right' style='padding-right:15;'>".number_format($row[couponprice])."원</td>
																<td width='105' align='center'>$duedateTemp</td>
																<td width='55' align='center'><b>$ctotal</b>개</td>
																<td width='80' align='center'>".date("Y-m-d",$row[inputdate])."</td>
																<td width='45' align='center' class='cate'><a href='$modifyTemp1'><img src='../odimages/btn_modify_s.gif' border='0'></a></td>
															</tr>
															<tr> 
																<td height='5' colspan='9' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td height='1' colspan='9' bgcolor='D2D2D2'></td>
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
																	<a href='od_coupon.php?page=1&search=<?=$search?>&key=<?=$key?>'>
																	<img src="../odimages/odmain/num_arrow_pre2.gif" width="13" height="11" border='0' alt="처음페이지" align="absmiddle"></a>
<?
	$TotalJump = ceil($TotalPage / $LinkNumber);
	$Jump = ceil($page / $LinkNumber);
	$FirstPage = ($Jump - 1) * $LinkNumber;
	$LastPage = $Jump * $LinkNumber;
	
	if($Jump >= $TotalJump) $LastPage = $TotalPage;
	
	if($Jump > 1) {
		$PrePage = $FirstPage;
		echo "<a href='od_coupon.php?page=$PrePage&search=$search&key=$key'><img src='../odimages/odmain/num_arrow_pre1.gif' width='35' height='11' hspace='3' border='0' alt='이전 ${LinkNumber}개'></a> / ";
	}
	else {
		echo " / ";
	}
	
	for($NowPage = $FirstPage+1; $NowPage <= $LastPage; $NowPage++) {
		if($page == $NowPage) echo "<b>$NowPage</b> / ";
		else echo "<a href='od_coupon.php?page=$NowPage&search=$search&key=$key'>$NowPage</a> / ";
	}

	if($Jump < $TotalJump) {
		$PrePage = $LastPage+1;
		echo "<a href='od_coupon.php?page=$PrePage&search=$search&key=$key'><img src='../odimages/odmain/num_arrow_next2.gif' width='35' height='11' hspace='3' border='0' alt='다음 ${LinkNumber}개'></a>";
	}
?>
																	<a href='od_coupon.php?page=<?=$TotalPage?>&search=<?=$search?>&key=<?=$key?>'>
																	<img src="../odimages/odmain/num_arrow_next1.gif" width="13" height="11" border='0' alt="마지막페이지" align="absmiddle"></a>
																</td>
																<td width="160" align="right"><a href="<?=$inputTemp1?>"><img src="../odimages/btn_admin_input.gif" width="77" height="24" border="0" onfocus='this.blur();'></a>
																	<a href="#" onClick="<?=$deleteTemp1?>"><img src="../odimages/odmain/btn_delete.gif" width="77" height="24" border='0'></a></td>
															</tr>
															<tr> 
																<td height="7" colspan="3"></td>
															</tr>
															<!-- delete form end -->
															</form>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<form method="post" action="od_coupon.php">
															<tr> 
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="37" align="center">
																	<table border="0" cellspacing="2" cellpadding="0">
																		<tr>
																			<td>
																				<select name="search">
																				<option value="name"<?if($search=="name")echo" selected"?>>쿠폰이름</option>
																				<option value="number"<?if($search=="number")echo" selected"?>>쿠폰번호</option>
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