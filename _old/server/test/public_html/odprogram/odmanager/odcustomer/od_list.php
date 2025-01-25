<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";

	## 세부권한 체크
	if($row_admin[customerLevel] < 3) {
		error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
	}
	
	## 접근권한 설정(엑셀저장)
	if($row_admin[customerLevel] > 2) $excelTemp1 = "saveExcel('od_excel.php');";
	else $excelTemp1 = "javascript:reject();";
	
	## 접근권한 설정(신규등록)
	if($row_admin[customerLevel] == 5 || $row_admin[customerLevel] == 9 || $row_admin[superLevel]==9) $customerinputTemp1 = "od_input.php";
	else $customerinputTemp1 = "javascript:reject();";
	
	## 접근권한 설정(삭제)
	if($row_admin[customerLevel] > 6 || $row_admin[superLevel]==9) $deleteTemp1 = "checkSelect(this.form);";
	else $deleteTemp1 = "javascript:reject();";
	
	## 검색
	unset($where_);
	if($_GET[search]) {
		$where_ = " and ".$_GET[search]." like '%".$_GET['key']."%' ";
	}

	$qry_CL = "SELECT * FROM odtMember WHERE userType = 'C' and id !='onedaynet' ".$where_." ORDER BY signdate desc ";

	$res_CL = mysql_query($qry_CL);
	$num_CL = mysql_num_rows($res_CL);

	$total = $num_CL;
	
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

            //POST방식 새창열기 (110122 : tindevil)
            function Open_NewWindow(val)
            {

                tForm= document.Alogin;
                tForm.PartCode.value = val;
                tForm.target = "_blank";
                tForm.action = "/odprogram/odmanager/od_main.php?skbn=y&mode=sub";//&cid="+value;
                tForm.submit(); 
            }

			function checkSelect(form) {
				var check_nums = document.allDelete.elements.length;
				for (var i = 0; i < check_nums;  i++) {
					var checkbox_obj = eval("document.allDelete.elements[" + i + "]");
					if (checkbox_obj.checked == true) {
						break;
					}
				}
				if(i == check_nums) {
					alert ("먼저 삭제하고자 하는 업체을 선택하여 주세요.   ");
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
			function saveExcel(fileTemp) {
				top.location=''+fileTemp;
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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 회원관리 &gt; <span class="st">공급업체 관리</span></font></td>
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
													<td height="18"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">공급업체 코드를 클릭하시면 해당 공급업체에 관련된 상품 목록 전체를 열람하실 수 있습니다.</font></td>
												</tr>
												<tr> 
													<td height="18"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">공급업체 이름을 클릭하시면 상세(수정)페이지를 보실 수 있습니다.</font></td>
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
															<form name="allDelete" method="post" action="od_delete.php">
																<input type="hidden" name="page" value="<?=$page?>">
																<input type="hidden" name="search" value="<?=$search?>">
																<input type="hidden" name="key" value="<?=$key?>">
															<tr>
																<td><img src="../odimages/odmain/page_icon.gif" width="14" height="11"> 
																	<font color="3960AC">전체 <strong><?=$TotalPage?></strong>페이지 [<strong><?=$total?></strong>]개 공급업체</font></td>
																<td align="right">
																	<a href="<?=$customerinputTemp1?>"><img src="../odimages/btn_admin_input.gif" width="77" height="24" border="0" onfocus='this.blur();'></a> 
																	<a onclick="<?=$excelTemp1?>" style='cursor:hand;' onfocus='this.blur();'><img src="../odimages/odmain/btn_excel.gif" width="77" height="24" border="0"></a>
																	<a href="#" onClick="<?=$deleteTemp1?>"><img src="../odimages/odmain/btn_delete.gif" width="77" height="24" border="0"></a></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="1" colspan="11" bgcolor="c0bebe"></td>
															</tr>
															<tr align="center"> 
																<td width="30" height="27" bgcolor="ececec" class="white">번호</td>
																<td width="40" bgcolor="ececec" class="white"><a href="javascript:selectAll();" class="white" onfocus='this.blur();' title=' 클릭 하시면 목록 전체를 선택 또는 해제 합니다. '>전체</a></td>
																<td bgcolor="ececec" class="white" >아이디</td>
																<td width="115" bgcolor="ececec" class="white" style="padding-left:3;" align="left">밴더사명</td>
																<td width="115" bgcolor="ececec" class="white" style="padding-left:3;" align="left">공급업체이름</td>
																<td width="70" bgcolor="ececec" class="white">대표자</td>
																<td width="70" bgcolor="ececec" class="white">담당자이름</td>
																<td width="90" bgcolor="ececec" class="white">전화번호</td>
																<td width="65" bgcolor="ececec" class="white">등록일</td>
															</tr>
															<tr> 
																<td height="1" colspan="11" bgcolor="c0bebe"></td>
															</tr>
															<tr> 
																<td height="2" colspan="11"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
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
		
		## 접근권한 설정(진열순위,분류등록,상품등록,수정)
		if($row_admin[customerLevel]==5 || $row_admin[customerLevel]==9 || $row_admin[superLevel]==9) 
			$modifyTemp1 = "od_input.php?serialnum=$row[serialnum]&page=$page&search=$search&key=$key";
		else $modifyTemp1 = "javascript:reject();";

		echo "
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td width='30' align='center' bgcolor='FAFAFA'>$serialnumber</td>
																<td width='40' align='center' bgcolor='FAFAFA'><input type='checkbox' name='serialnum[]' value='$row[serialnum]'></td>
																<td align='left' bgcolor='FAFAFA' class='cate'>
																	<a href='$modifyTemp1'>$row[id]</a> <a href='../odproducts/od_list.php?search_value_=true&customerCode=$row[id]'><img src='/images/btn_next7.gif' border=0></a> <a href='#none' onClick=\"Open_NewWindow('$row[id]');\">[열기]</a><input type='hidden' name='PartCode'></td>
																<td width='115' bgcolor='FAFAFA' class='cate' style='padding-left:5;'><a href='$modifyTemp1'>$row[bannder]</a></td>
																<td width='115' bgcolor='FAFAFA' class='cate' style='padding-left:5;'><a href='$modifyTemp1'>$row[cName]</a></td>
																<td width='70' bgcolor='FAFAFA' align='center'>$row[ceoName]</td>
																<td width='70' bgcolor='FAFAFA' align='center'>$row[name]</td>
																<td width='90' align='center' bgcolor='FAFAFA'>$row[tel1]-$row[tel2]-$row[tel3]<br>$row[htel1]-$row[htel2]-$row[htel3]</td>
																<td width='65' align='center' bgcolor='FAFAFA'>".date("y-m-d",$row[signdate])."</td>
															</tr>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
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
																<td align="center" class="num">
																	<a href='od_list.php?page=1&search=<?=$search?>&key=<?=$key?>'>
																	<img src="../odimages/odmain/num_arrow_pre2.gif" width="13" height="11" border='0' alt="처음페이지" align="absmiddle"></a>
<?
	$TotalJump = ceil($TotalPage / $LinkNumber);
	$Jump = ceil($page / $LinkNumber);
	$FirstPage = ($Jump - 1) * $LinkNumber;
	$LastPage = $Jump * $LinkNumber;
	
	if($Jump >= $TotalJump) $LastPage = $TotalPage;
	
	if($Jump > 1) {
		$PrePage = $FirstPage;
		echo "<a href='od_list.php?page=$PrePage&search=$search&key=$key'><img src='../odimages/odmain/num_arrow_pre1.gif' width='35' height='11' hspace='3' border='0' alt='이전 ${LinkNumber}개'></a> / ";
	}
	else {
		echo " / ";
	}
	
	for($NowPage = $FirstPage+1; $NowPage <= $LastPage; $NowPage++) {
		if($page == $NowPage) echo "<b>$NowPage</b> / ";
		else echo "<a href='od_list.php?page=$NowPage&search=$search&key=$key'>$NowPage</a> / ";
	}

	if($Jump < $TotalJump) {
		$PrePage = $LastPage+1;
		echo "<a href='od_list.php?page=$PrePage&search=$search&key=$key'><img src='../odimages/odmain/num_arrow_next2.gif' width='35' height='11' hspace='3' border='0' alt='다음 ${LinkNumber}개'></a>";
	}
?>
																	<a href='od_list.php?page=<?=$TotalPage?>&search=<?=$search?>&key=<?=$key?>'>
																	<img src="../odimages/odmain/num_arrow_next1.gif" width="13" height="11" border='0' alt="마지막페이지" align="absmiddle"></a>
																</td>
																<td width="240" align="right">
																	<a href="<?=$customerinputTemp1?>"><img src="../odimages/btn_admin_input.gif" width="77" height="24" border="0" onfocus='this.blur();'></a>
																	<a onclick="<?=$excelTemp1?>" style='cursor:hand;' onfocus='this.blur();'><img src="../odimages/odmain/btn_excel.gif" width="77" height="24" border="0"></a>
																	<a href="#" onClick="<?=$deleteTemp1?>"><img src="../odimages/odmain/btn_delete.gif" width="77" height="24" border="0"></a></td>
															</tr>
															<tr> 
																<td height="10" colspan="5"></td>
															</tr>
															<!-- delete form end -->
															</form>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<form method="get" action="od_list.php">
															<tr> 
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="37" align="center">
																	<table border="0" cellspacing="2" cellpadding="0">
																		<tr>
																			<td>
																				<select name="search">
																				<option value="cName"<?if($search=="cName")echo" selected"?>>공급업체명</option>
																				<option value="code"<?if($search=="code")echo" selected"?>>공급업체코드</option>
																				<option value="name"<?if($search=="name")echo" selected"?>>담당자명</option>
																				<option value="number"<?if($search=="number")echo" selected"?>>사업자번호</option>
																				<option value="ceoName"<?if($search=="ceoName")echo" selected"?>>대표자명</option>
																				<option value="tel"<?if($search=="tel")echo" selected"?>>전화번호</option>
																				<option value="htel"<?if($search=="htel")echo" selected"?>>휴대폰번호</option>
																				<option value="fax"<?if($search=="fax")echo" selected"?>>팩스번호</option>
																				</select>&nbsp;
																			</td>
																			<td><input name="key" type="text" class="border" size="35" value="<?=$key?>">&nbsp;</td>
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
<!-- 자동로그인 데이터 전송을 위한 폼 -->
<form name="Alogin" method="post">
<input type="hidden" name = "PartCode" value="">
</form>
<!-- 자동로그인 폼 종료 -->
	</body>
</html>