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

	if($mode && $mode=="alldelete"){
		$delete_serial_tmp = explode("/",$delete_serial);
		$delete_serial_count = sizeof($delete_serial_tmp)-1;

		$success_count = 0;

		for($i = 0; $i < $delete_serial_count; $i++) {
			$qry_d = "delete from odtSmsHistory where serialnum='$delete_serial_tmp[$i]'";
			$res_d = mysql_query($qry_d);

			if($res_d) $success_count++;

		}

		$alert_str = "선택된 $delete_serial_count 건중 $success_count 건이 삭제되었습니다.";

		echo "
			<script>
				alert('$alert_str');
				location.href='od_sms_history.php';
			</script>";

		exit;
	}

	$EncodingKey = urlencode($key);

	## 전체 회원의 수를 구한다. ###################################################
	if(!eregi("[^[:space:]]+",$key)) $qry_MSSHL = "SELECT * FROM odtSmsHistory ORDER BY serialnum DESC";
	else $qry_MSSHL = "SELECT * FROM odtSmsHistory WHERE $search LIKE '%$key%' ORDER BY serialnum DESC";

	$res_MSSHL = mysql_query($qry_MSSHL);
	$num_MSSHL = mysql_num_rows($res_MSSHL);

	$total = $num_MSSHL;

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
				var delete_serial = "";

				var check_nums = document.memberAlldelete.elements.length;
				for (var i = 0; i < check_nums;  i++) {
					var checkbox_obj = eval("document.memberAlldelete.elements[" + i + "]");
					if (checkbox_obj.checked == true && checkbox_obj.name=="memSerialnum") {
						delete_serial = delete_serial + checkbox_obj.value + "/";
					}
				}
				if(delete_serial == "") {
					alert ("먼저 삭제 처리하실 내역을 선택하여 주세요.   ");
					return;
				}
				else {
					document.memberAlldelete.delete_serial.value = delete_serial;

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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> SMS관리 &gt; <span class="st">SMS 발송로그</span></font></td>
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
													<td height="18"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">개별발송 로그 리스트를 보려면, 검색조건 "아이디"로 검색어 "each" 를 검색하시면 됩니다.</font></td>
												</tr>
												<tr> 
													<td height="18"> <font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">.</font></td>
												</tr>
												<tr> 
													<td height="18"> <font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">.</font></td>
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
																	<font color="3960AC">전체 <strong><?=$TotalPage?></strong> 페이지 [<strong><?=$total?></strong>] 건</font></td>
																<td align="right">
																	<!--a onclick="saveExcel('od_excel.php?search=<?=$search?>&key=<?=$key?>');" style='cursor:hand;' onfocus='this.blur();'><img src="../odimages/odmain/btn_excel.gif" width="77" height="24" border="0"></a--> 
																	<a onclick="selectCheck(this.form);" style='cursor:hand;' onfocus='this.blur();'><img src="../odimages/odmain/btn_delete.gif" width="77" height="24" border="0"></a> 
																	<!--a onclick="updateprice();" style='cursor:hand;' onfocus='this.blur();'><img src="../odimages/odmain/btn_price_update.gif" width="77" height="24" border="0"></a-->
																</td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="1" colspan="10" bgcolor="c0bebe"></td>
															</tr>
															<form name="memberAlldelete" method="post" action="<?=$PHP_SELF;?>">
																<input type="hidden" name="mode" value="alldelete">
																<input type="hidden" name="delete_serial">
															<tr align="center"> 
																<td width="40" height="27" bgcolor="ececec" class="white">번호</td>
																<td width="30" bgcolor="ececec" class="white"><a href="javascript:selectAll();" class="white" onfocus='this.blur();' title=' 클릭 하시면 목록 전체를 선택 또는 해제 합니다. '>전체</a></td>
																<td width="60" bgcolor="ececec" class="white">아이디</td>
																<td width="60" bgcolor="ececec" class="white">이 름</td>
																<td width="110" bgcolor="ececec" class="white">수신번호</td>
																<td width="110" bgcolor="ececec" class="white">발신번호</td>
																<td bgcolor="ececec" class="white">메세지</td>
																<td width="40" bgcolor="ececec" class="white">결과</td>
																<td width="40" bgcolor="ececec" class="white">TYPE</td>
																<td width="110" bgcolor="ececec" class="white">발신일</td>
															</tr>
															<tr> 
																<td height="1" colspan="10" bgcolor="c0bebe"></td>
															</tr>
															<tr> 
																<td height="2" colspan="10"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="1" colspan="10" bgcolor="D2D2D2"></td>
															</tr>
<?
	if(!$total) {
		echo "
															<tr>
																<td height='75' align='center' colspan='10'>SMS 발송로그가 없습니다.</td>
															</tr>";
	}

	$serialnumber = $total - $LineNumber * ($page - 1);
	
	for($i=$first;$i<=$last;$i++) {
		mysql_data_seek($res_MSSHL,$i);
		$row = mysql_fetch_array($res_MSSHL);

		$h_id_str = "";
		$h_name_str = "";
		$h_to_htel_str = "";
		$h_status_str = "";

		$h_id = explode("/",$row[id]);
		for($hi=0;$hi<sizeof($h_id);$hi++){
			$h_id_str .= $h_id[$hi]."<br>";
		}

		$h_name = explode("/",$row[name]);
		for($hn=0;$hn<sizeof($h_name);$hn++){
			$h_name_str .= $h_name[$hn]."<br>";
		}

		$h_to_htel = explode("/",$row[to_htel]);
		for($ht=0;$ht<sizeof($h_to_htel);$ht++){
			$h_to_htel_str .= $h_to_htel[$ht]."<br>";
		}

		$h_from_htel = $row[from_htel];
		$h_message = $row[message];

		$h_status = explode("/",$row[status]);
		for($hs=0;$hs<sizeof($h_status);$hs++){
			$h_status_str .= $h_status[$hs]."<br>";
		}

		$h_send_type = $row[send_type];
		if($h_send_type == "now") $h_send_type_str="즉시";
		else $h_send_type_str="예약";

		$h_send_date = $row[send_date];
		$h_send_date_str=substr($h_send_date,0,4)."년 ".substr($h_send_date,4,2)."월 ".substr($h_send_date,6,2)."일<br>".substr($h_send_date,8,2)."시 ".substr($h_send_date,10,2)."분";

		echo "
															<tr> 
																<td height='3' colspan='10' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td width='40' align='center' bgcolor='FAFAFA'>$serialnumber</td>
																<td width='30' align='center' bgcolor='FAFAFA'><input type='checkbox' name='memSerialnum' value='$row[serialnum]'></td>
																<td width='60' align='center' bgcolor='FAFAFA' class='cate'>
																	$h_id_str</td>
																<td width='60' align='center' bgcolor='FAFAFA'>$h_name_str</td>
																<td width='110' bgcolor='FAFAFA' align='center' class='cate'>
																	$h_to_htel_str</td>
																<td width='110' align='center' bgcolor='FAFAFA'>$h_from_htel</td>
																<td align='center' bgcolor='FAFAFA'>$h_message</td>
																<td width='40' align='center' bgcolor='FAFAFA'>$h_status_str</td>
																<td width='40' align='center' bgcolor='FAFAFA'>$h_send_type_str</td>
																<td width='110' align='center' bgcolor='FAFAFA'>$h_send_date_str</td>
															</tr>
															<tr> 
																<td height='3' colspan='10' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td height='1' colspan='10' bgcolor='D2D2D2'></td>
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
																	<a href='od_sms_history.php?page=1<?=$par_page?>'>
																	<img src="../odimages/odmain/num_arrow_pre2.gif" width="13" height="11" border='0' alt="처음페이지" align="absmiddle"></a>
<?
	$TotalJump = ceil($TotalPage / $LinkNumber);
	$Jump = ceil($page / $LinkNumber);
	$FirstPage = ($Jump - 1) * $LinkNumber;
	$LastPage = $Jump * $LinkNumber;
	
	if($Jump >= $TotalJump) $LastPage = $TotalPage;
	
	if($Jump > 1) {
		$PrePage = $FirstPage;
		
		echo "<a href='od_sms_history.php?page=$PrePage&search=$search&key=$key'><img src='../odimages/odmain/num_arrow_pre1.gif' width='35' height='11' hspace='3' border='0' alt='이전 ${LinkNumber}개'></a> / ";
	}
	else {
		echo " / ";
	}
	
	for($NowPage = $FirstPage+1; $NowPage <= $LastPage; $NowPage++) {
		if($page == $NowPage) echo "<b>$NowPage</b> / ";
		else echo "<a href='od_sms_history.php?page=$NowPage&search=$search&key=$key'>$NowPage</a> / ";
	}

	if($Jump < $TotalJump) {
		$PrePage = $LastPage+1;
	   
		echo "<a href='od_sms_history.php?page=$PrePage&search=$search&key=$key'><img src='../odimages/odmain/num_arrow_next2.gif' width='35' height='11' hspace='3' border='0' alt='다음 ${LinkNumber}개'></a>";
	}
?>
																	<a href='od_sms_history.php?page=<?=$LastPage?><?=$par_page?>'>
																	<img src="../odimages/odmain/num_arrow_next1.gif" width="13" height="11" border='0' alt="마지막페이지" align="absmiddle"></a></td>
																<td width="180" align="right">
																	<!--a onclick="saveExcel('od_excel.php?search=<?=$search?>&key=<?=$key?>');" style='cursor:hand;' onfocus='this.blur();'><img src="../odimages/odmain/btn_excel.gif" width="77" height="24" border="0"></a--> 
																	<a onclick="selectCheck(this.form);" style='cursor:hand;' onfocus='this.blur();'><img src="../odimages/odmain/btn_delete.gif" width="77" height="24" border="0"></a> 
																	<!--a onclick="updateprice();" style='cursor:hand;' onfocus='this.blur();'><img src="../odimages/odmain/btn_price_update.gif" width="77" height="24" border="0"></a-->
																</td>
															</tr>
															<tr> 
																<td height="10" colspan="3"></td>
															</tr>
															</form>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<form name="snsSearch" method="post" action="od_sms_history.php" onSubmit="return searchCheck(this)">
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
																				<option value="id" <?if($search=="id")echo" selected"?>>아이디</option>
																				<option value="name" <?if($search=="name")echo" selected"?>>이름</option>
																				<option value="to_htel" <?if($search=="to_htel")echo" selected"?>>수신번호</option>
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