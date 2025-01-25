<?
	include "../../odcommon/od_config.inc.php";
	include "../odcommon/od_function.inc.php";		
	include "../odcommon/od_adminAuthority.inc.php";
	include "../odcommon/od_head.inc.php";
	include "../odcommon/od_body.inc.php";

	## 세부권한 체크
	if($row_admin[productLevel] < 3) {
		error_msgloc("../","접근권한이 없습니다.   ");
	}
	
	## 접근권한 설정(엑셀저장)
	if($row_admin[productLevel] > 2) $excelTemp1 = "excelDownload('od_excel.php?m=a$par_page&search_value_=$search_value_');";
	else $excelTemp1 = "javascript:reject();";
	
	## 접근권한 설정(가격업데이트)
	if($row_admin[productLevel] == 5 || $row_admin[productLevel] == 7 || $row_admin[superLevel]==9) $priceupdateTemp1 = "updateprice();";
	else $priceupdateTemp1 = "javascript:reject();";
	
	## 접근권한 설정(삭제)
	if($row_admin[productLevel] > 6 || $row_admin[superLevel]==9) $deleteTemp1 = "selectCheck(this.form);";
	else $deleteTemp1 = "javascript:reject();";

	## 접근권한 설정(등록)
	if($row_admin[productLevel] > 6 || $row_admin[superLevel]==9) $inputtemp = "update_product(this.form);";
	else $inputtemp = "javascript:reject();";
	
	if(!$search_standard) $search_standard = "cateCode";
	
	if(!$page_number) $page_number = "100";
	
	$key = trim($key);

	## 검색조건 Par 정리 #####################################
	if($search_value_ == "true") {
		if($cateCode) $search_value = " AND cateCode='".$cateCode."'";
		
		if($customerCode) $search_value .= " AND customerCode='".$customerCode."'";
		if($authum) $search_value .= " AND authum='".$authum."'";
		
		if($stock) {
			if($stock == "Y") $search_value .= " AND stock>'0'";
			else $search_value .= " AND stock='0'";
		}

		if($hiddenTemp) $search_value .= " AND hiddenTemp='".$hiddenTemp."'";
		if($key) $search_value .= " AND ".$search." LIKE '%".$key."%'";
		if($order_by) $search_value .= " ORDER BY ".$order_by."";
		if($order_by_rule) $search_value .= " ".$order_by_rule."";
	}
	else {
		if($key) $search_value = " AND ".$search." LIKE '%".$key."%' ORDER BY cateCode ASC";
		else $search_value = " ORDER BY sale_date >= '".date('Y-m-d')."' DESC, sale_date ='0000-00-00', sale_date , cateCode , code = parent_code DESC, name";
	}

	include "od_parpage.inc.php";
	
	if(!strcmp($Form,"changeLineUp")) {

	}
	else {
		## 조건에 맞는 주문목록의 수를 구한다 ###################
		$qry_MPL = "SELECT * FROM odtProduct WHERE serialnum!=''".$search_value."";
		$res_MPL = mysql_query($qry_MPL);
		$num_MPL = mysql_num_rows($res_MPL);

		$total = $num_MPL;
		
		$LineNumber = $page_number;
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

		## 등록양식 설정환경
		$brow = mysql_fetch_array(mysql_query("SELECT * FROM odtFormat WHERE serialnum=1"));
?>

		<script language="javascript">
			function lineUpFunc(which) {
				var code;
				code = which.value;
				if(code != "No")
					parent.location.href = "od_list.php?"+code+"";
			}
			
			function update_product(form){
				parent.location.href = 'od_input_coupon.php';
			
			}
			
			function selectCheck(form) {
				var check_nums = document.AllDelete.elements.length;
				for (var i = 0; i < check_nums;  i++) {
					var checkbox_obj = eval("document.AllDelete.elements[" + i + "]");
					if (checkbox_obj.checked == true) {
						break;
					}
				}
				if(i == check_nums) {
					alert ("먼저 삭제하고자 하는 상품을 선택하여 주세요.   ");
					return;
				}
				else {
					document.AllDelete.submit();
				}
			}

			function selectAll() {
				var form = document.AllDelete;
				for (var i=0;i<form.elements.length;i++) {
					obj_str = eval(form.elements[i]);
					obj_str.checked = !obj_str.checked;
				}
			}
			
			function excelDownload(fileTemp) {
				top.location=''+fileTemp;
			}
			
			function viewBig(what) {
				var imgwin = window.open("",'WIN','scrollbars=no,status=no,toolbar=no,resizable=1,location=no,menu=no,width=1,height=1');
				imgwin.focus();
				imgwin.document.open();
				imgwin.document.write("<html>\n");
				imgwin.document.write("<head>\n");
				imgwin.document.write("<title>이미지 확대보기</title>\n");
				imgwin.document.write("<sc"+"ript>\n");
				imgwin.document.write("function resize() {\n");
				imgwin.document.write("pic = document.il;\n");
				imgwin.document.write("if(eval(pic).height) { var name = navigator.appName\n");
				imgwin.document.write("  if(name == 'Microsoft Internet Explorer') { myHeight = eval(pic).height + 31; myWidth = eval(pic).width + 12;\n");
				imgwin.document.write("  }else { myHeight = eval(pic).height + 9; myWidth = eval(pic).width; }\n");
				imgwin.document.write("  clearTimeout();\n");
				imgwin.document.write("  var height = screen.height;\n");
				imgwin.document.write("  var width = screen.width;\n");
				imgwin.document.write("  self.resizeTo(myWidth, myHeight);\n");
				imgwin.document.write("}else setTimeOut(resize(), 100);}\n");
				imgwin.document.write("</sc"+"ript>\n");
				imgwin.document.write("</head>\n");
				imgwin.document.write('<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" bgcolor="#FFFFFF">\n');
				imgwin.document.write('<table border="0" cellspacing="0" cellpadding="0" align="center">\n');
				imgwin.document.write('<tr>\n');
				imgwin.document.write("<td><a href='javascript:window.close()' onfocus='this.blur();'><img alt='클릭하시면 창이 닫힙니다.' border=0 src="+what+" xwidth=100 xheight=9 name=il onload='resize();''></a></td>\n");
				imgwin.document.write('</tr>\n');
				imgwin.document.write('</table>\n');
				imgwin.document.write("</body>");
				imgwin.document.close();
			}
			
			function updateprice() {
				document.AllDelete.action = 'priceupdate.inc.php';
				document.AllDelete.submit();
			}

			function copy(code) {
				window.open('od_proCopy.php?code='+code,'','width=400,height=400');
			}	

		</script>

		<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="FFFFFF">
			<tr> 
				<td height="80" bgcolor="#FFFFFF">
					<!-- top menu start -->
<? include "../odcommon/od_topMenu.inc.php"; ?>
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
<? include "../odcommon/od_leftMenu.inc.php"; ?>
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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 상품관리 &gt; <span class="st">등록되어 있는 상품 리스트</span></font></td>
												</tr>
												<tr> 
													<td height="2" bgcolor="D6D6D6"></td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="1" cellpadding="0">
												<tr>
													<td height="5"></td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="18"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">상품이름을 클릭하시면 상품 상세페이지(상품정보수정)를 보실 수 있습니다.</font></td>
												</tr>
												<tr> 
													<td height="18"> <font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5"><strong>상품 진열순위는 상품의 분류(카테고리)별로 관리됩니다.</strong></font></td>
												</tr>
												<tr> 
													<td height="18"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">상품 진열순위를 변경하실 경우 검색조건에서 해당 상품분류(카테고리)를 선택 후 검색 버튼을 클릭하셔서 변경하세요. </font></td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="1" cellpadding="0">
												<tr>
													<td height="5"></td>
												</tr>
												<tr> 
													<td height="2" bgcolor="D6D6D6"></td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="1" cellpadding="0">
												<tr> 
													<td height="11"></td>
												</tr>
											</table>
											<table width="760" border="0" cellspacing="0" cellpadding="0">
												<!-- search form start -->
												<form name="view" method="post" action="od_list.php">
													<input type="hidden" name="search_value_" value="true">
													<input type="hidden" name="page" value="<?=$page?>">
												<tr> 
													<td colspan="3"><img src="../odimages/odmain/search_piece1.gif" width="760" height="8"></td>
												</tr>
												<tr> 
													<td width="6" background="../odimages/odmain/search_bg1.gif">&nbsp;</td>
													<td width="748" align="center" style="padding:10px;">
														<table border="0" cellspacing="0" cellpadding="0" width="100%">
															<tr> 
																<td height="25" colspan="2"><font color="DD896B"><strong>*</strong> 검색조건을 선택하신 후 검색 버튼을 클릭해 주시기 바랍니다.</font></td>
															</tr>
															<tr> 
																<td>
																	<table width="100%" border="0" cellspacing="5" cellpadding="0">
																		<tr> 
																			<td><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">상품분류 
																				<select name="cateCode" style="width:555px;">
																				<option value="">상품 분류(카테고리) 선택</option>
																				<option value="">----------------------------------------------------------------------</option>
																				<option value=""<? if(!$cateCode)echo" selected"?>>▣ 전체 분류(카테고리)에 대한 상품보기</option>
																				<option value="">----------------------------------------------------------------------</option>
<?
		## 최고 상위 분류의 갯수를 구한다. #################################
		$BCateResult = mysql_query("SELECT catecode FROM odtCategory WHERE cHidden='no' AND cateparent='00' ORDER BY catecode ASC");
		$BCateTotal = mysql_num_rows($BCateResult);
		
		## 카테고리 정렬 부분 ####################################################
		for($i = 0 ; $i < $BCateTotal ; $i++) {
			$BCateRow = mysql_fetch_array($BCateResult);
			
			$BCateCode = $BCateRow[catecode];
			
			$SCateResult = mysql_query("SELECT catecode,catename FROM odtCategory WHERE LEFT(catecode,2)='$BCateCode' ORDER BY catecode ASC");
			$SCateTotal = mysql_num_rows($SCateResult);
			
			for($j = 0 ; $j < $SCateTotal ; $j++) {
				$SCateRow = mysql_fetch_array($SCateResult);

				$RCateCode = $SCateRow[catecode];
				$RCateName = $SCateRow[catename];
				$optionsdevided = explode("/",$RCateCode);
				$CateTotal = count($optionsdevided);
				
				if($cateCode == $RCateCode) echo "<option value='$RCateCode' selected>";
				else echo "<option value='$RCateCode'>";
				
				$k=0;
				
				while($optionsdevided[$k]) {
					if($k == "0") {
						$CateCoded = $optionsdevided[0];
					}
					else {
						$CateCoded = $CateCoded."/";
						$CateCoded = $CateCoded.$optionsdevided[$k];
					}
					
					$res_d = mysql_query("SELECT catecode, catename FROM odtCategory WHERE catecode='$CateCoded' ORDER BY catecode ASC");
					$row_d = mysql_fetch_array($res_d);
					
					$BankName = $row_d[catename];
					$BankCode = $row_d[catecode];
					
					if($k == "0") echo "$BankName";
					else echo " ≫ $BankName";
					
					$k++;
				}

				echo "</option>";
			}
		}
?>
																				</select>
																			</td>
																		</tr>
																		<tr> 
																			<td>
																				<img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">공급업체 
																				<select name="customerCode" style="width:100px;">
																				<option value="" <?if($customerCode=="")echo" selected";?>>공급업체</option>
																				<option value="">----------</option>
																				<option value="" <?if($customerCode=="")echo" selected";?>>전체업체</option>
<?
		$presult = mysql_query("SELECT id, cName FROM odtMember where userType ='C' ORDER BY cName DESC");

		while($prow = mysql_fetch_array($presult)) {
?>
																				<option value="<?=$prow[id]?>" <?if($customerCode==$prow[id])echo" selected";?>><?=$prow[cName]?></option>
<?
		}
?>
																				</select>
																			</td>
																		</tr>
																		<tr style=display:none> 
																			<td><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">진열위치 
																				<select name="mainDisplay" style="width:100px;">
																				<option value="">진열위치</option>
																				<option value="">-----------</option>
																				<option value="d0" <?if($mainDisplay=="d0")echo" selected";?>>디스플레이0</option>
																				<option value="d1" <?if($mainDisplay=="d1")echo" selected";?>>디스플레이1</option>
																				<option value="d2" <?if($mainDisplay=="d2")echo" selected";?>>디스플레이2</option>
																				<option value="e1" <?if($mainDisplay=="e1")echo" selected";?>>이벤트1</option>
																				<option value="e2" <?if($mainDisplay=="e2")echo" selected";?>>이벤트2</option>
																				<option value="e3" <?if($mainDisplay=="e3")echo" selected";?>>이벤트3</option>
																				<option value="e4" <?if($mainDisplay=="e4")echo" selected";?>>이벤트4</option>
																				<option value="e5" <?if($mainDisplay=="e5")echo" selected";?>>이벤트5</option>
																				<option value="e6" <?if($mainDisplay=="e6")echo" selected";?>>이벤트6</option>
																				<option value="e7" <?if($mainDisplay=="e7")echo" selected";?>>이벤트7</option>
																				<option value="e8" <?if($mainDisplay=="e8")echo" selected";?>>이벤트8</option>
																				<option value="e9" <?if($mainDisplay=="e9")echo" selected";?>>이벤트9</option>
																				<option value="e10" <?if($mainDisplay=="e10")echo" selected";?>>이벤트10</option>
																				<option value="e11" <?if($mainDisplay=="e11")echo" selected";?>>이벤트11</option>
																				</select>
																				&nbsp;<img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">재고여부 
																				<select name="stock">
																				<option value="">재고여부</option>
																				<option value="">--------</option>
																				<option value="Y" <?if($stock=="Y")echo" selected";?>>재고있음</option>
																				<option value="N" <?if($stock=="N")echo" selected";?>>재고없음</option>
																				</select>
																				&nbsp;&nbsp;<img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">표시형태 
																				<select name="hiddenTemp">
																				<option value="">표시형태</option>
																				<option value="">--------</option>
																				<option value="no" <?if($hiddenTemp=="no")echo" selected";?>>표시</option>
																				<option value="yes" <?if($hiddenTemp=="yes")echo" selected";?>>일시숨김</option>
																				</select>
																			</td>
																		</tr>
																		<tr style="display:none"> 
																			<td><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">정 렬 수&nbsp; 
																				<select name="page_number">
																				<option value="1" <?if($page_number=="1")echo" selected";?>>1</option>
																				<option value="5" <?if($page_number=="5")echo" selected";?>>5</option>
																				<option value="10" <?if($page_number=="10")echo" selected";?>>10</option>
																				<option value="20" <?if($page_number=="20")echo" selected";?>>20</option>
																				<option value="30" <?if($page_number=="30")echo" selected";?>>30</option>
																				<option value="40" <?if($page_number=="40")echo" selected";?>>40</option>
																				<option value="50" <?if($page_number=="50")echo" selected";?>>50</option>
																				<option value="60" <?if($page_number=="60")echo" selected";?>>60</option>
																				<option value="70" <?if($page_number=="70")echo" selected";?>>70</option>
																				<option value="80" <?if($page_number=="80")echo" selected";?>>80</option>
																				<option value="90" <?if($page_number=="90")echo" selected";?>>90</option>
																				<option value="100" <?if($page_number=="100")echo" selected";?>>100</option>
																				</select>
																				&nbsp; <img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">정렬기준 
																				<select name="order_by">
																				<option value="cateCode" <?if($order_by=="lineUp")echo" selected";?>>카테고리별 순위</option>
																				<option value="price" <?if($order_by=="price")echo" selected";?>>판매가격</option>
																				<option value="stock" <?if($order_by=="stock")echo" selected";?>>재고량</option>
																				<option value="saleNum" <?if($order_by=="saleNum")echo" selected";?>>판매량</option>
																				<option value="clickNum" <?if($order_by=="clickNum")echo" selected";?>>조회수</option>
																				</select>
																				&nbsp;<img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">정렬순서 
																				<select name="order_by_rule">
																				<option value="asc" <?if($order_by_rule=="asc")echo" selected";?>>오름차순</option>
																				<option value="desc" <?if($order_by_rule=="desc")echo" selected";?>>내림차순</option>
																				</select>
																			</td>
																		</tr>
																		<tr> 
																			<td><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">검 색 어&nbsp; 
																				<select name="search">
																				<option value="name"<?if($search=="name")echo" selected"?>>상품이름</option>
																				<option value="code"<?if($search=="code")echo" selected"?>>상품코드</option>
																				<option value="price"<?if($search=="price")echo" selected"?>>상품가격</option>
<? 
		if($brow[comment1_use]=="yes") { 
?>
																				<option value="comment1"<?if($search=="comment1")echo" selected"?>>간단한설명</option>
<? 
		} 
?>
																				<option value="description1"<?if($search=="description1")echo" selected"?>>상세설명</option>
<? 
		if($row_setup[modelTemp]=="yes" AND $brow[model_use]=="yes") { 
?>
																				<option value="model"<?if($search=="model")echo" selected"?>><?=$row_setup[modelTitle]?></option>
<? 
		} 
																			
		if($row_setup[makerTemp]=="yes" AND $brow[maker_use]=="yes") { 
?>
																				<option value="maker"<?if($search=="maker")echo" selected"?>><?=$row_setup[makerTitle]?></option>
<? 
		} 
																			
		if($row_setup[styleTemp]=="yes" AND $brow[style_use]=="yes") { 
?>
																				<option value="style"<?if($search=="style")echo" selected"?>><?=$row_setup[styleTitle]?></option>
<? 
		} 
																			
		if($row_setup[fabricTemp]=="yes" AND $brow[fabric_use]=="yes") { 
?>
																				<option value="fabric"<?if($search=="fabric")echo" selected"?>><?=$row_setup[fabricTitle]?></option>
<? 
		} 
?>
																				</select>&nbsp;
																				<input name="key" type="text" class="border" size="66" value="<?=$key?>">
																			</td>
																		</tr>
																	</table>
																</td>
																<td align="right">
																	<input type="image" src="../odimages/odmain/search_btn.gif" width="68" height="64" border="0"><br><img src="blank.gif" width="1" height="17"></td>
															</tr>
														</table>
													</td>
													<td width="6" background="../odimages/odmain/search_bg2.gif">&nbsp;</td>
												</tr>
												<tr> 
													<td colspan="3"><img src="../odimages/odmain/search_piece2.gif" width="760" height="8"></td>
												</tr>
												</form>
												<!-- search form end -->
											</table>
											<table width="760" border="0" cellspacing="1" cellpadding="0">
												<tr>
													<td height="11"></td>
												</tr>
											</table>
											<table width="760" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td valign="top">
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td><img src="../odimages/odmain/page_icon.gif" width="14" height="11"> 
																	<font color="3960AC">전체 <strong><?=$TotalPage?></strong>페이지 [<strong><?=$total?></strong>]개</font></td>
																<td align="right">
																	<a onclick="<?=$inputtemp?>" style='cursor:hand;' onfocus='this.blur();'><img src="../odimages/odmain/btn_ok2.gif" width="77" height="24" border="0"></a> 
																	<a onclick="<?=$deleteTemp1?>" style='cursor:hand;' onfocus='this.blur();'><img src="../odimages/odmain/btn_delete.gif" width="77" height="24" border="0"></a></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="1" colspan="11" bgcolor="c0bebe"></td>
															</tr>
															<form name="AllDelete" method="post" action="od_delete.php">
																<input type="hidden" name="PageL" value="All">
																<input type="hidden" name="page" value="<?=$page?>">
																<input type="hidden" name="par_page" value="<?=$par_page?>">
															<tr align="center"> 
																<td width="40" height="27" bgcolor="ececec" class="white">번호</td>
																<td width="30" bgcolor="ececec" class="white"><a href="javascript:selectAll();" class="white" onfocus='this.blur();' title=' 클릭 하시면 목록 전체를 선택 또는 해제 합니다. '>전체</a></td>
																<td width="85" bgcolor="ececec" class="white">이미지</td>
																<td width="60" bgcolor="ececec" class="white">상품코드</td>
																<td bgcolor="ececec" class="white" style='padding-left:11;' align="left">상품이름</td>
																<td width="75" bgcolor="ececec" class="white">판매가격</td>
																<td width="55" bgcolor="ececec" class="white">재고량</td>
																<td width="40" bgcolor="ececec" class="white">분류</td>
																<td width="63" bgcolor="ececec" class="white">판매일<br>종료일</td>
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
																<td height='55' align='center' colspan='11'>등록된 상품이 없습니다.</td>
															</tr>";
		}
		
		$serialnumber = $total - $LineNumber*($page-1);
		$cin = 1;
		$serialnumber2 = 1;
		for($i=$first;$i<=$last;$i++) {
			mysql_data_seek($res_MPL,$i);
			$row = mysql_fetch_array($res_MPL);
			
			$row[name] = stripslashes($row[name]);
			
			if($row[optionTag3] == "yes") {
				$priceTemp = "<font color='darkorange'>옵션별 가격<br>차등 적용됨</font>";
				$stockTemp = "-";
				$priceHidden = "";
			}
			else {
				$priceTemp = $row[price]."원";
				$stockTemp = $row[stock]."개";				
			}
			
			$inputDate = date("Ymd",strtotime($row[inputDate]));
			$mainDisplayDivision = explode("/",$row[mainDisplay]);
			$mainDisplay1 = "";
			
			for($z=0;$z<count($mainDisplayDivision);$z++) {
				if($mainDisplayDivision[$z]) $mainDisplay1 .= $mainDisplayDivision[$z]."<br>";
				else $mainDisplay1 .= "";
			}

			$authumTemp = "";
			
			## icon view
			include "od_iconView.inc.php";

			$imgTemp = $row[cateCode] == "06" ? $row[mart_main_img] : $row[main_img];
			$bigimgTemp = $row[big1_img];
			
			## 접근권한 설정(진열순위,분류등록,상품등록,수정)
			if($row_admin[productLevel]==5 || $row_admin[productLevel]==9 || $row_admin[superLevel]==9) {
					$lineupTemp1 = "onChange=\"lineUpFunc(this)\"";
					$modifyTemp1 = "od_input_coupon.php?code=$row[code]&page=$page$par_page";

			}
			else {
				$lineupTemp1 = "";
				$modifyTemp1 = "javascript:reject();";
			}

			unset($viewUrl);

			$viewUrl = "/?viewCode=$row[code]&cateCode=$row[cateCode]";


			if($imgTemp) {
				$imgResult = "
																	<img src='$imgTemp' width='50' height='50' class='imgborder' border='0'>";
				$imgResultTmp[$row[parent_code]] = $imgResult;
			} else {
				$imgResult = $imgResultTmp[$row[parent_code]] ? $imgResultTmp[$row[parent_code]] : "No img";
			}
	
			$catename = mysql_result(mysql_query("select catename from odtCategory where catecode ='".$row[cateCode]."'"),0);

			echo "
															$priceHidden
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td width='40' height='50' align='center' bgcolor='FAFAFA'>
																	$serialnumber</td>
																<td width='30' align='center' bgcolor='FAFAFA'>
																	<input type='checkbox' name='code[]' value='$row[code]'></td>
																<td width='85' align='center' bgcolor='FAFAFA'>
																".($row[code] != $row[parent_code] ? "&nbsp;&nbsp;<img src='/images/icon_re.gif'>&nbsp;&nbsp;" : NULL)."
																$imgResult
																</td>
																<td width='60' align='center' bgcolor='FAFAFA' class='cate'>
																	<a href='$modifyTemp1' class='fes'>$row[code]</a>".
																	($row[cateCode] != "06" && $row[code] == $row[parent_code] ? 
																	"<br>
																	<a href='$viewUrl' target='_blank' style='font-size:11px'>[미리보기]</a>" : NULL)."
																</td>
																<td bgcolor='FAFAFA' class='cate' style='padding-left:11;'>
																	$authumTemp
																	<a href='$modifyTemp1' class='fes' title=' 클릭하시면 상세(수정) 페이지로 이동합니다. '><b>$row[name]</b></a>$newTemp$coolTemp$hitTemp$hotTemp$couponnumberTemp$exDeliveryTemp$discountChuchunTemp$bestChuchunTemp$mdChuchunTemp$creditTemp$preeCheckTemp$couponTemp$stockTemp1</td>
																<td width='75' align='center' bgcolor='FAFAFA'>$priceTemp</td>
																<td width='55' align='center' bgcolor='FAFAFA'>$stockTemp</td>
																<td width='40' align='center' bgcolor='FAFAFA'><font color='165DFF'>$catename</font></td>
																<td width='63' align='center' bgcolor='FAFAFA'>".substr($row[sale_date],2,10)."<br>".substr($row[sale_enddate],2,10)."</td>
															</tr>
";
			$serialnumber--;

			if($row[optionTag3] == "no") { 
				$cin++; 
			}	
			## for price update
		}
?>
															<input type='hidden' name='cin' value='<?=$cin?>'>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td width="3" height="46"></td>
																<td align="center" class='num'>
																	<a href='od_list.php?page=1<?=$par_page?>'>
																	<img src="../odimages/odmain/num_arrow_pre2.gif" width="13" height="11" border='0' alt="처음페이지" align="absmiddle"></a>
<?
		$TotalJump = ceil($TotalPage / $LinkNumber);
		$Jump = ceil($page / $LinkNumber);
		$FirstPage = ($Jump - 1) * $LinkNumber;
		$LastPage = $Jump * $LinkNumber;
		
		if($Jump >= $TotalJump) $LastPage = $TotalPage;
		
		if($Jump > 1) {
			$PrePage = $FirstPage;
			echo "<a href='od_list.php?page=$PrePage$par_page'><img src='../odimages/odmain/num_arrow_pre1.gif' width='35' height='11' hspace='3' border='0' alt='이전 ${LinkNumber}개'></a> / ";
		}
		else {
			echo " / ";
		}
		
		for($NowPage = $FirstPage+1; $NowPage <= $LastPage; $NowPage++) {
			if($page == $NowPage) echo "<b>$NowPage</b> / ";
			else echo "<a href='od_list.php?page=$NowPage$par_page'>$NowPage</a> / ";
		}

		if($Jump < $TotalJump) {
			$PrePage = $LastPage+1;
			echo "<a href='od_list.php?page=$PrePage$par_page'><img src='../odimages/odmain/num_arrow_next2.gif' width='35' height='11' hspace='3' border='0' alt='다음 ${LinkNumber}개'></a>";
		}
?>
																	<a href='od_list.php?page=<?=$TotalPage?><?=$par_page?>'>
																	<img src="../odimages/odmain/num_arrow_next1.gif" width="13" height="11" border='0' alt="마지막페이지" align="absmiddle"></a></td>
																<td width="240" align="right">
																	<a onclick="<?=$inputtemp?>" style='cursor:hand;' onfocus='this.blur();'><img src="../odimages/odmain/btn_ok2.gif" width="77" height="24" border="0"></a> 
																	<a onclick="<?=$deleteTemp1?>" style='cursor:hand;' onfocus='this.blur();'><img src="../odimages/odmain/btn_delete.gif" width="77" height="24" border="0"></a> </td>
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
<? include "../odcommon/od_bottom.inc.php"; ?>
					<!-- bottom end -->
				</td>
			</tr>
		</table>
	</body>
</html>
<? 
	} 
?>