<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";

	## 세부권한 체크
	if($row_admin[orderLevel] < 3) {
		error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
	}
	
	## 접근권한 설정(엑셀저장)
	if($row_admin[orderLevel] > 2) $excelTemp1 = "saveExcel('od_orderexcel.php');";
	else $excelTemp1 = "javascript:reject();";
	
	## 접근권한 설정(삭제)
	if($row_admin[orderLevel]==7 || $row_admin[orderLevel]==9 || $row_admin[superLevel]==9) $deleteTemp1 = "selectCheck(this.form);";
	else $deleteTemp1 = "javascript:reject();";
	
	## mktime(시간,분,초,월,일,년);
	$today_time = time();
	$start_date_year = substr($start_date,0,4);
	$start_date_month = substr($start_date,4,2);
	$start_date_day = substr($start_date,6,2);
	$start_date_time = mktime(0,0,0,$start_date_month,$start_date_day,$start_date_year);
	$end_date_year = substr($end_date,0,4);
	$end_date_month = substr($end_date,4,2);
	$end_date_day = substr($end_date,6,2);
	$end_date_time = mktime(23,59,59,$end_date_month,$end_date_day,$end_date_year);
	
	if($key) $search_value = " AND ".$search." LIKE '%".$key."%'";
	if(!$search_standard) $search_standard = "canceldate";
	if(!$page_number) $page_number = "10";
	
	## 검색조건 Par 정리 #####################################
	if($search_value_ == "true") {
		$search = "";
		$key = "";
		
		if($paymethod) $search_value = " AND paymethod='".$paymethod."'";
		if($paystatus) $search_value .= " AND paystatus='".$paystatus."'";
		if($delivstatus) $search_value .= " AND delivstatus='".$delivstatus."'";
		if($start_date && $end_date) $search_value .= " AND ".$search_standard." BETWEEN '$start_date_time' AND '$end_date_time'";
		if($order_by) $search_value .= " ORDER BY ".$order_by."";
		if($order_by_rule) $search_value .= " ".$order_by_rule."";
	}
	else {
		$search_value .= " ORDER BY canceldate desc";
	}
	
	## 페이지링크 PAR 정리 ############################################
	if($search) $par_page .= "&search=$search";
	if($key) $par_page .= "&key=$key";
	if($paymethod) $par_page .= "&paymethod=$paymethod";
	if($paystatus) $par_page .= "&paystatus=$paystatus";
	if($delivstatus) $par_page .= "&delivstatus=$delivstatus";
	if($start_date && $end_date) $par_page .= "&start_date=$start_date&end_date=$end_date";
	if($date_term) $par_page .= "&date_term=$date_term";
	if($search_standard) $par_page .= "&search_standard=$search_standard";
	if($order_by) $par_page .= "&order_by=$order_by";
	if($order_by_rule) $par_page .= "&order_by_rule=$order_by_rule";
	if($search_value_) $par_page .= "&search_value_=$search_value_";
	if($page_number) $par_page .= "&page_number=$page_number";
    if($order_type) $par_page .= "&order_type=$order_type";

	
	## 조건에 맞는 주문목록의 수를 구한다 ###################
	$qry_MOCL = "SELECT * FROM odtOrder WHERE canceled='Y' AND orderstatus='Y'".$search_value."";
	$res_MOCL = mysql_query($qry_MOCL);
	$num_MOCL = mysql_num_rows($res_MOCL);

	$total = $num_MOCL;
	
	## 페이지 링크에 사용할 값들을 설정한다 ###################
	$LineNumber = $page_number;
	$LinkNumber = 10;
	
	## 전체 페이지 수 계산 ##########################################
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

		<script language="javascript">
			function set_date(opt1,opt2) {
				today = new Date();
				now_year = today.getYear();
				now_month = today.getMonth()+1;
				now_day = today.getDate();
				month_temp = now_month-1;
				
				switch(month_temp) {
					case(1): day_temp=31; 	break;
					case(2): day_temp=28; 	break;
					case(3): day_temp=31; 	break;
					case(4): day_temp=30; 	break;
					case(5): day_temp=31; 	break;
					case(6): day_temp=30; 	break;
					case(7): day_temp=31; 	break;
					case(8): day_temp=31; 	break;
					case(9): day_temp=30; 	break;
					case(10): day_temp=31; break;
					case(11): day_temp=30; break;
					case(12): day_temp=31; break;
					default: day_temp=31; break;
				}
				
				the_day = now_day;
				the_month = now_month;
				the_year = now_year;
				
				if(opt1 == 'd') {
					opt_day = now_day-opt2;
					
					if(opt_day > 0) {
						the_day = opt_day;
					}
					else{
						opt_month = now_month-1;
						the_day = day_temp+opt_day;
						
						if(opt_month > 0) {
							the_month = opt_month;
						}
						else{
							the_year = now_year-1;
							the_month = 12;
						}
					}
				}
				else if(opt1 == 'm') {
					opt_month = now_month-opt2;
					
					if(opt_month > 0) {
						the_month = opt_month;
					}
					else{
						the_year = now_year-1;
						the_month = 12+opt_month;
					}
				}
				else if(opt1 == 'y') {
					the_year = now_year-opt2;
				}
				
				if(the_month < 10) the_month = '0'+the_month;
				if(the_day < 10) the_day = '0'+the_day;
				
				the_date = the_year+''+the_month+''+the_day;
				document.view.start_date.value = the_date;
				
				if(now_month < 10) now_month = '0'+now_month;
				if(now_day < 10) now_day = '0'+now_day;
				
				now_date = now_year+''+now_month+''+now_day;
				document.view.end_date.value = now_date;
				
				if(opt1 == 'w') {
					document.view.start_date.value = '';
					document.view.end_date.value = '';
				}
			}

			function view_submit() {
				if(document.view.start_date.value) {
					if(!IsNumber(document.view.start_date)) {
						alert('조회기간에는 숫자만 입력하실 수 있습니다.  ');
						document.view.start_date.focus();
						document.view.start_date.select();
						return false;
					}
				}
				if(document.view.end_date.value) {
					if(!IsNumber(document.view.end_date)) {
						alert('조회기간에는 숫자만 입력하실 수 있습니다.   ');
						document.view.end_date.focus();
						document.view.end_date.select();
						return false;
					}
				}
				document.view.submit();
			}
			function IsNumber(formname) {
				var formstr = eval(formname);
				for(var i=0 ; i<formstr.value.length ; i++) {
					var chr=formstr.value.substr(i,1);
					if((chr<'0'||chr>'9') && chr!='-' && chr!='_') return false;
				}
				return true;
			}
		</script>

		<script language="javascript">
			function selectCheck(form) {
				var check_nums = document.OderAllDelete.elements.length;
				
				for (var i = 0; i < check_nums;  i++) {
					var checkbox_obj = eval("document.OderAllDelete.elements[" + i + "]");
					
					if (checkbox_obj.checked == true) {
						break;
					}
				}

				if(i == check_nums) {
					alert ("먼저 삭제하고자 하는 주문 항목을 선택하여 주세요.   ");
					return;
				}
				else {
					document.OderAllDelete.submit();
				}
			}

			function selectAll() {
				var form = document.OderAllDelete;
				
				for (var i=0;i<form.elements.length;i++) {
					obj_str = eval(form.elements[i]);
					obj_str.checked = !obj_str.checked;
				}
			}
			function saveExcel(fileTemp) {
				isCheck = false;
				frm = document.OderAllDelete;
				//obj = frm.elements['OrderNum[]'];
				obj = document.getElementsByName('OrderNum[]');

				for(i=0;i<obj.length;i++) {
					if(obj[i].checked == true) isCheck = true;
				}
				if(isCheck != true) {
					alert('엑셀파일로 변환하고자 하는 주문내역을 선택하세요');return false;}

				orgAction = frm.action
				frm.action = fileTemp;
				frm.submit();
				frm.action = orgAction
			}

			function reCancel(ordernum) {
				if(!confirm('취소된 주문을 복구하시겠습니까?')) return false;
				hf.location.href='orderslistReCancel.php?ordernum='+ordernum;
			}
		</script>


		<iframe name="hf" src="about:blank" width=100 height=100 style='display:none'></iframe>
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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 주문관리 &gt; <span class="st">취소된주문 목록</span></font></td>
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
													<td height="18"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5"><b>주문번호를 클릭</b>하시면 주문 상세페이지(주문정보수정)를 보실 수 있습니다.</font></td>
												</tr>
												<tr> 
													<td height="18"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5"><b>회원주문</b>인 경우에는 <b>주문번호가 볼드체(굵은글씨)로 표시</b> 됩니다.</font></td>
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
													<td height="15">&nbsp;</td>
												</tr>
											</table>
											<!-- all delete form start -->
											<table width="760" border="0" cellspacing="0" cellpadding="0">
												<form name="OderAllDelete" method="post" action="od_orderalldelete.php">
													<input type="hidden" name="PageL" value="Cancel">
													<input type="hidden" name="page" value="<?=$page?>">
													<input type="hidden" name="par_page" value="<?=$par_page?>">
												<tr> 
													<td valign="top">
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td><img src="../odimages/odmain/page_icon.gif" width="14" height="11"> 
																	<font color="3960AC">전체 <b><?=$TotalPage?></b>페이지 [<b><?=$total?></b>]개</font></td>
																<td align="right">
																	<!-- 엑셀저장 -->
																	<img src="../odimages/odmain/btn_excel.gif" width="77" height="24"onclick="<?=$excelTemp1?>" style='cursor:hand;' onfocus='this.blur();'> 
																	<!-- 선택삭제 -->
																	<img src="../odimages/odmain/btn_delete.gif" width="77" height="24" onclick="<?=$deleteTemp1?>" style='cursor:hand;' onfocus='this.blur();'></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="1" colspan="12" bgcolor="c0bebe"></td>
															</tr>
															<tr align="center"> 
																<td width="40" height="27" bgcolor="ececec" class="white">번호</td>
																<td width="30" bgcolor="ececec" class="white"><a onclick="selectAll();" onfocus='this.blur();' style='cursor:hand;'>전체</a></td>
																<td width="85" bgcolor="ececec" class="white">주문번호</td>
																<td width="60" bgcolor="ececec" class="white">주문자</td>
																<td width="60" bgcolor="ececec" class="white">수령인</td>
																<td width="70" bgcolor="ececec" class="white">결제방법</td>
																<td bgcolor="ececec" class="white">결제금액</td>
																<!--
																<td width="60" bgcolor="ececec" class="white">결제상황</td>
																<td width="60" bgcolor="ececec" class="white">배송상황</td>
																-->
																<td width="175" bgcolor="ececec" class="white">주문취소일</td>
																<td width="75" bgcolor="ececec" class="white">주문일</td>
																<td width="75" bgcolor="ececec" class="white">복구</td>
																<!--<td width="35" bgcolor="ececec" class="white">취소</td>-->
															</tr>
															<tr> 
																<td height="1" colspan="12" bgcolor="c0bebe"></td>
															</tr>
															<tr> 
																<td height="2" colspan="12"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="1" colspan="12" bgcolor="D2D2D2"></td>
															</tr>
<?	
	if(!$total)  echo "
															<tr>
																<td colspan='12' height='55' align='center'><font color='darkorange'>주문 내역이 없습니다.</font></td>
															</tr>";
	
	$serialnumber = $total - $LineNumber * ($page - 1);
	
	for($i = $first; $i <= $last; $i++) {
		mysql_data_seek($res_MOCL,$i);
		$row = mysql_fetch_array($res_MOCL);
		
		$OrderGetPointD = number_format($row[getpoint]);
		
		if($row[tPrice] > 0) $TotalOrderPriceD = "<font color='darkorange'>".number_format($row[tPrice])."원</font>";
		else $TotalOrderPriceD = "전액적립금결제";
		
		if($row[orderemail]) $OrderNameD = "<a href='mailto:$row[orderemail]' class='fes'>$row[ordername]</a>";
		else $OrderNameD = $row[ordername];
		
		if($row[paymethod] == "B") $OrderPaymethodD = "은행";
		## 에스크로 시작
		else if($row[paymethod] == "E") $OrderPaymethodD = "<font color='#ee0000'>에스크로</font>";
		else if($row[paymethod] == "L") $OrderPaymethodD = "<font color='#ee0000'>실시간</font>";
		else if($row[paymethod] == "G") $OrderPaymethodD = "<font color='#ee0000'>포인트</font>";
		## 에스크로 끝
		else $OrderPaymethodD = "카드";
		
		$orderdate = date("Ymd",strtotime($row[orderdate]));
		
		if(!$row[orderid] || $row[orderid] == "guest") $orderNumber = $row[ordernum];
		else $orderNumber = "<b>".$row[ordernum]."</b>";
		
		$cancelDate = date("Y-m-d H:i:s",$row[canceldate]);
		
		## 접근권한 설정(수정)
		if($row_admin[orderLevel]==5 || $row_admin[orderLevel]==9 || $row_admin[superLevel]==9) 
			$modifyTemp1 = "od_ordermodify.php?Form=OrderModify&ordernum=$row[ordernum]&PageL=Cancel&page=$page$par_page";
		else $modifyTemp1 = "javascript:reject();";

		echo "
															<tr> 
																<td width='40' height='45' align='center' bgcolor='FAFAFA'>$serialnumber</td>
																<td width='30' align='center' bgcolor='FAFAFA'><input type='checkbox' name='OrderNum[]' value='$row[ordernum]'></td>
																<td width='85' align='center' bgcolor='FAFAFA' class='cate'><a href='$modifyTemp1'>$orderNumber</a></td>
																<td width='60' align='center' bgcolor='FAFAFA' class='cate'>$OrderNameD</td>
																<td width='60' align='center' bgcolor='FAFAFA'>$row[recname]</td>
																<td width='70' align='center' bgcolor='FAFAFA'>$OrderPaymethodD</td>
																<td align='center' bgcolor='FAFAFA'><b><font color='#138CE5'>$TotalOrderPriceD</font></b></td>
																<td width='175' align='center' bgcolor='FAFAFA'><b><font color='FF0000'>$cancelDate</font></b></td>
																<td width='75' align='center' bgcolor='FAFAFA'>$orderdate</td>
																<td width='75' align='center' bgcolor='FAFAFA'>복구불가</td>

															</tr>
															<tr> 
																<td height='1' colspan='12' bgcolor='D2D2D2'></td>
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
																<td width="160" height="46">&nbsp;</td>
																<td width="440" align="center" class='num'>
																	<a href='od_orderslistCancel.php?page=1<?=$par_page?>'>
																	<img src="../odimages/odmain/num_arrow_pre2.gif" width="13" height="11" border='0' alt="처음페이지" align="absmiddle"></a>
<?
	$TotalJump = ceil($TotalPage / $LinkNumber);
	$Jump = ceil($page / $LinkNumber);
	$FirstPage = ($Jump - 1) * $LinkNumber;
	$LastPage = $Jump * $LinkNumber;
	
	if($Jump >= $TotalJump) $LastPage = $TotalPage;
	
	if($Jump > 1) {
		$PrePage = $FirstPage;
		echo "<a href='od_orderslistCancel.php?page=$PrePage$par_page'><img src='../odimages/odmain/num_arrow_pre1.gif' width='35' height='11' hspace='3' border='0' alt='이전 ${LinkNumber}개'></a> / ";
	}
	else {
		echo " / ";
	}
	
	for($NowPage = $FirstPage+1; $NowPage <= $LastPage; $NowPage++) {
		if($page == $NowPage) echo "<b>$NowPage</b> / ";
		else echo "<a href='od_orderslistCancel.php?page=$NowPage$par_page'>$NowPage</a> / ";
	}

	if($Jump < $TotalJump) {
		$PrePage = $LastPage+1;
		echo "<a href='od_orderslistCancel.php?page=$PrePage$par_page'><img src='../odimages/odmain/num_arrow_next2.gif' width='35' height='11' hspace='3' border='0' alt='다음 ${LinkNumber}개'></a>";
	}
?>
																	<a href='od_orderslistCancel.php?page=<?=$TotalPage?><?=$par_page?>'>
																	<img src="../odimages/odmain/num_arrow_next1.gif" width="13" height="11" border='0' alt="마지막페이지" align="absmiddle"></a>
																</td>
																<td width="160" align="right">
																	<!-- 엑셀저장 -->
																	<img src="../odimages/odmain/btn_excel.gif" width="77" height="24"onclick="<?=$excelTemp1?>" style='cursor:hand;' onfocus='this.blur();'> 
																	<!-- 선택삭제 -->
																	<img src="../odimages/odmain/btn_delete.gif" width="77" height="24" onclick="<?=$deleteTemp1?>" style='cursor:hand;' onfocus='this.blur();'></td>
															</tr>
															</form>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="37" align="center">
																	<table border="0" cellspacing="2" cellpadding="0">
																		<form method="post" action="od_orderslistCancel.php">
																		<tr>
																			<td>
																				<select name="search">
																				<option value="ordernum" <?if($search=="ordernum") echo" selected";?>>주문번호</option>
																				<option value="orderid" <?if($search=="orderid") echo" selected";?>>주문자아이디</option>
																				<option value="ordername" <?if($search=="ordername" || !$search) echo" selected";?>>주문자이름</option>
																				<option value="payname" <?if($search=="payname") echo" selected";?>>입금인이름</option>
																				<option value="recname" <?if($search=="recname") echo" selected";?>>받는사름이름</option>
																				<option value="recaddress" <?if($search=="recaddress") echo" selected";?>>주소</option>
																				<option value="paymethod" <?if($search=="paymethod") echo" selected";?>>결제방법[C or B]</option>
																				</select>
																			</td>
																			<td><input name="key" type="text" class="border" size="20" value="<?=$key?>"></td>
																			<td><input type="image" src="../odimages/odmain/btn_search.gif" width="43" height="19"></td>
																		</tr>
																		</form>
																	</table>
																</td>
															</tr>
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
