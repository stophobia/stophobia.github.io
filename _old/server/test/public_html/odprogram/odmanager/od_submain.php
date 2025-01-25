<?
	include "../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";
	include "../odcommon/od_lib.inc.php";
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";

	// 방문로그 시작
	$counter_result = mysql_query("SELECT SUM(Visit_Num) FROM odtCounterData");
	$Total_Num = mysql_result($counter_result,0,0);
	
	$CoIP = $REMOTE_ADDR;
	$CoRoute = $HTTP_REFERER;
	$CoKinds = $HTTP_USER_AGENT;
	$CoKinds = eregi_replace(")","",$CoKinds);
	$CoKindsDivision = explode(";",$CoKinds);
	$CoKinds_Browser = $CoKindsDivision[1];
	$CoKinds_OS = $CoKindsDivision[2];
	$ToDay_Year = date("Y");
	$ToDay_Month = date("m");
	$ToDay_Day = date("d");
	$ToDay_Hour = date("H");
	$ToDay_Minute = date("i");
	$ToDay_Second = date("s");
	$ToDay_Week = date("D");
	$ToDay_Time = time();
	
	$counter_query = "SELECT * FROM odtCounterData WHERE Year = '$ToDay_Year' AND Month = '$ToDay_Month' AND Day = '$ToDay_Day'";
	$counter_row = mysql_fetch_array(mysql_query($counter_query,$connect));
	
	$ToDay_Num = $counter_row[Visit_Num];
	$YesterDay_Time = time();
	$YesterDay_Time = $YesterDay_Time - (24*3600);
	$YesterDay_Year = date('Y', $YesterDay_Time);
	$YesterDay_Month = date('m', $YesterDay_Time);
	$YesterDay_Day = date('d', $YesterDay_Time);
	
	$counter_query = "SELECT * FROM odtCounterData WHERE Year = '$YesterDay_Year' AND Month = '$YesterDay_Month' AND Day = '$YesterDay_Day'";
	$counter_row = mysql_fetch_array(mysql_query($counter_query,$connect));
	
	$YesterDay_Num = $counter_row[Visit_Num];
	if(!$YesterDay_Num) $YesterDay_Num = 0;
	$Total_NumD = number_format($Total_Num);
	$ToDay_NumD = number_format($ToDay_Num);
	$YesterDay_NumD = number_format($YesterDay_Num);
	$Now_Person_NumD = number_format($Now_Person_Num);
	// 방문로그 종료

	$date_value_start = date("Y-m-d")." 00:01:01";
	
	$result_start = mysql_query("SELECT UNIX_TIMESTAMP('$date_value_start')");
	$today_start = mysql_result($result_start,0,0);
	
	$date_value_end = date("Y-m-d")." 23:59:59";
	
	$result_end = mysql_query("SELECT UNIX_TIMESTAMP('$date_value_end')");
	$today_end = mysql_result($result_end,0,0);
	
	// 오늘의 회원가입현황
	$qry_TML = "SELECT * FROM odtMember WHERE signdate  BETWEEN '$today_start' AND '$today_end' and userType = 'B' and resinum !='' ";
	$res_TML = mysql_query($qry_TML);
	$num_TML = mysql_num_rows($res_TML);

	$member_today_total = $num_TML;
	
	// 전체회원수
	$member_total = mysql_result(mysql_query("SELECT count(*) FROM odtMember where userType = 'B' and resinum !='' "),0);
	
	// 오늘의 주문현황
	$qry_TOL = "SELECT * FROM odtOrder WHERE orderdate  BETWEEN '".date('Y-m-d H:i:s',$today_start)."' AND '".date('Y-m-d H:i:s',$today_end)."' AND canceled='N' AND orderstatus='Y' ORDER BY serialnum DESC";
	$res_TOL = mysql_query($qry_TOL);
	$num_TOL = mysql_num_rows($res_TOL);

	$order_today_total = $num_TOL;
	
	// 전체주문수
	$order_total = mysql_num_rows(mysql_query("SELECT * FROM odtOrder WHERE canceled='N' AND orderstatus='Y'"));
?>

<script>
// 회원상세정보 출럭 Ajax 시작

var selfID;
// request 객체 생성
var req = null;
function create_request() {
    var request = null;
    try {
        request = new XMLHttpRequest();
    } catch (trymicrosoft) {
        try {
            request = new ActiveXObject("Msxml12.XMLHTTP");
        } catch (othermicrosoft) {
            try {
                request = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (failed) {
                request = null;
            }
        }
    }
    if (request == null)
        alert("Error creating request object!");
    else
        return request;
}

function showInfo(id,name,divID) {

	selfID = divID;

	// 백그라운드로 DB 추출.
	param = "id="+id+"&name="+name;
	req = create_request();
	req.open("POST", "/showUserInfo.php", true);
	req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=UTF-8");
	req.setRequestHeader("Cache-Control","no-cache, must-revalidate");
	req.setRequestHeader("Pragma","no-cache");
	req.send(param);
	req.onreadystatechange = function () {
		printHTML();
	}

	document.getElementById(divID).style.display='';
}
function printHTML() {
	if (req.readyState == 4) {
		if(req.status == 200) {
			// 값이 있을때만 처리
				resultText = req.responseText;
				document.getElementById(selfID+"_1").innerHTML = resultText;
		}
	}
}

// 회원상세정보 출럭 Ajax 끝

</script>
		<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
			<tr> 
				<td height="80">
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
											<table width="100%" border="0" cellspacing="1" cellpadding="0">
												<tr> 
													<td height="6"></td>
												</tr>
											</table>
											<table width="760" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td width="760" valign="top">
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td width="380">
																	<table width="372" border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td height="22">
																				<font color="313D7D"><img src="odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> <b>오늘</b>현황</font></td>
																		</tr>
																	</table>
																	<table width="372" border="0" cellspacing="1" cellpadding="0" bgcolor="D5D5D5">
																		<tr>
																			<td bgcolor="ececec" align="center" class="white" width="126" height="28">가입회원수</td>
																			<td bgcolor="FAFAFA" style="padding-left:16;"><b><?=$member_today_total;?></b>명</td>
																		</tr>
																		<tr>
																			<td bgcolor="ececec" align="center" class="white" height="28">주문현황</td>
																			<td bgcolor="FAFAFA" style="padding-left:16;"><b><?=$order_today_total;?></b>건</td>
																		</tr>
																		<tr>
																			<td bgcolor="ececec" align="center" class="white" height="28">접속현황</td>
																			<td bgcolor="FAFAFA" style="padding-left:16;"><b><?=$ToDay_NumD?></b>명</td>
																		</tr>
																	</table>
																</td>
																<td width="380" align="right">
																	<table width="372" border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td height="22">
																				<font color="313D7D"><img src="odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> <b>전체</b>현황</font></td>
																		</tr>
																	</table>
																	<table width="372" border="0" cellspacing="1" cellpadding="0" bgcolor="D5D5D5">
																		<tr>
																			<td bgcolor="ececec" align="center" class="white" width="126" height="28">가입회원수</td>
																			<td bgcolor="FAFAFA" style="padding-left:16;"><b><?=$member_total;?></b>명</td>
																		</tr>
																		<tr>
																			<td bgcolor="ececec" align="center" class="white" height="28">주문현황</td>
																			<td bgcolor="FAFAFA" style="padding-left:16;"><b><?=$order_total;?></b>건</td>
																		</tr>
																		<tr>
																			<td bgcolor="ececec" align="center" class="white" height="28">접속현황</td>
																			<td bgcolor="FAFAFA" style="padding-left:16;"><b><?=$Total_NumD?></b>명</td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td height="26"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td height="22">
																	<font color="313D7D"><img src="odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> <b>오늘</b>의 주문현황 (<b><?=$order_today_total;?></b>건)</font></td>
																<td align="right" class="cate"><a href="odorders/od_orderslist.php"><font face="tahoma"><b>MORE</b></font></a>&nbsp;&nbsp;</td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="1" colspan="12" bgcolor="c0bebe"></td>
															</tr>
															<tr align="center"> 
																<td width="100" bgcolor="ececec" class="white" height="27">주문번호</td>
																<td width="75" bgcolor="ececec" class="white">주문일</td>
																<td width="86" bgcolor="ececec" class="white">주문자</td>
																<td bgcolor="ececec" class="white">전화번호</td>
																<td width="70" bgcolor="ececec" class="white">결제방법</td>
																<td width='90' bgcolor="ececec" class="white">결제금액</td>
																<td width="60" bgcolor="ececec" class="white">결제상황</td>
																<td width="70" bgcolor="ececec" class="white">상세정보</td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
<?
	if(!$order_today_total)  echo "
															<tr>
																<td colspan='12' height='66' align='center'>오늘 주문 내역이 없습니다.</td></tr><tr><td height='1' colspan='12' bgcolor='D2D2D2'></td>
															</tr>";

	$serialnumber = $total - $LineNumber*($page-1);
	
	while($row = mysql_fetch_array($res_TOL)) {
		if($row[tPrice] > 0) $_totalprice_ = "<font color='FF6600'>".number_format($row[tPrice])."원</font>";
		else $_totalprice_ = "전액적립금결제";
		
		if($row[orderemail]) $_ordername_ = "<a href='mailto:$row[orderemail]' class='fes'>$row[ordername]</a>";
		else $_ordername_ = $row[ordername];
		
		if($row[paymethod] == "B") $_paymethod_ = "은행입금";
		else if($row[paymethod] == "C") $_paymethod_ = "카드";
		else if($row[paymethod] == "L") $_paymethod_ = "실시간";
		else if($row[paymethod] == "H") $_paymethod_ = "핸드폰";
		else if($row[paymethod] == "E") $_paymethod_ = "에스크로";

		else $_paymethod_ = "신용카드";
		
		if($row[paystatus] == "Y") $_paystatus_ = "<font color='red'><b>결제확인</b></font>";
		else {
			if(ereg("B|E",$row[paymethod])) $_paystatus_ = "결제전";
			else													 $_paystatus_ = "결제취소";
		}
		
		if($row[orderid] == "guest") {
			$_pointed_ = "<font color='blue'>비회원<br>주문</font>";
		}
		else {
			if($row[pointed] == "Y") $_pointed_ = number_format($row[getpoint])."원";
			else $_pointed_ = number_format($row[getpoint])."원";
		}

		$orderdate = date("Y-m-d",$row[orderdate]);
		
		if(!$row[orderid] || $row[orderid] == "guest") $orderNumber = $row[ordernum];
		else $orderNumber = "<b>".$row[ordernum]."</b>";

		$randID = rand(1,999999);

		echo "
															<tr style='padding-top:4;padding-bottom:4;'> 
																<td width='100' align='center' bgcolor='FAFAFA' class='cate'>$orderNumber</td>
																<td width='75' align='center' bgcolor='FAFAFA'>".$row[orderdate]."</td>
																<td width='86' align='center' bgcolor='FAFAFA' class='cate'>
										<div id=".$randID." style='Z-INDEX: 1; LEFT: 0px; WIDTH: 0px; POSITION: relative; TOP: 0px; HEIGHT: 0px;display:none'><div id='".$randID."_1' style='position:absolute;z-index:3;top:20;left:0;'></div></div><span style='font-weight:;cursor:pointer' onclick=\"showInfo('".$row[orderid]."','".$row[ordername]."','".$randID."')\">".$row[ordername]."</span>
																</td>
																<td align='center' bgcolor='FAFAFA' style='padding-top:3;'>
																	$row[ordertel1]-$row[ordertel2]-$row[ordertel3]<br>$row[orderhtel1]-$row[orderhtel2]-$row[orderhtel3]</td>
																<td width='70' align='center' bgcolor='FAFAFA'>$_paymethod_</td>
																<td width='90' align='center' bgcolor='FAFAFA'><b><font color='#0000FF'>$_totalprice_</font></b></td>
																<td width='60' align='center' bgcolor='FAFAFA'><font color='#138CE5'>$_paystatus_</font></td>
																<td width='70' align='center' bgcolor='FAFAFA'><a href='odorders/od_ordermodify.php?Form=OrderModify&ordernum=$row[ordernum]&PageL=All&page=1'><img src='odimages/b_detail.gif' border='0'></a></td>
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
																<td height="26"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td height="22">
																	<font color="313D7D"><img src="odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> <b>오늘</b>의 회원가입현황 (<b><?=$member_today_total;?></b>명)</font></td>
																<td align="right" class="cate"><a href="odmembers/od_list.php"><font face="tahoma"><b>MORE</b></font></a>&nbsp;&nbsp;</td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="1" colspan="11" bgcolor="c0bebe"></td>
															</tr>
															<tr align="center"> 
																<td width="86" bgcolor="ececec" class="white" height="27">아이디</td>
																<td width="86" bgcolor="ececec" class="white">이 름</td>
																<td bgcolor="ececec" class="white">E-mail</td>
																<td width="110" bgcolor="ececec" class="white">전화번호</td>
																<td width="66" bgcolor="ececec" class="white">권 한</td>
																<td width="66" bgcolor="ececec" class="white">포인트</td>
																<td width="78" bgcolor="ececec" class="white">가입일</td>
																<td width="70" bgcolor="ececec" class="white">상세정보</td>
															</tr>
															<tr> 
																<td height="1" colspan="11" bgcolor="c0bebe"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height='3' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
<?
	if(!$member_today_total) {
		echo "
															<tr>
																<td height='66' align='center' colspan='11'>오늘 가입한 회원이 없습니다.</td></tr><tr><td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>";
	}
	
	$serialnumber = $total - $LineNumber*($page-1);
	
	while($row = mysql_fetch_array($res_TML)) {
		$telTemp = $row[tel1]."-".$row[tel2]."-".$row[tel3];
		
		if($row[htel1] && $row[htel2] && $row[htel3]) {
			$htelTemp = "<br><font color='3333FF'>".$row[htel1]."-".$row[htel2]."-".$row[htel3]."</font>";
		}
		else {
			$htelTemp = "";
		}
		
		$signdateTemp1 = date("Y-m-d",$row[signdate]);
		$signdateTemp2 = date("H:i:s",$row[signdate]);
		
		if($row[Mlevel] == 9) $MlevelTemp = "<font color='blue'><b>관리자</b></font>";
		else if($row[Mlevel] == 5) $MlevelTemp = "<font color='FF6600'>$row_setup[classname2]</font>";
		else if($row[Mlevel] == 3) $MlevelTemp = "<font color='3333FF'>$row_setup[classname1]</font>";
		else if($row[Mlevel] == 1) $MlevelTemp = "일반회원";
		
		$visitnumTemp = number_format($row[visitnum]);
		$pointTemp = number_format($row[point]);

		$randID = rand(1,999999);

		echo "
															<tr> 
																<td width='86' align='center' bgcolor='FAFAFA' class='cate'>".$row[id]."</td>
																<td width='86' align='center' bgcolor='FAFAFA'>
																	<div id=".$randID." style='Z-INDEX: 1; LEFT: 0px; WIDTH: 0px; POSITION: relative; TOP: 0px; HEIGHT: 0px;display:none'><div id='".$randID."_1' style='position:absolute;z-index:3;top:20;left:0;'></div></div><span style='font-weight:;cursor:pointer' onclick=\"showInfo('".$row[id]."','".$row[name]."','".$randID."')\">".$row[name]."</span></td>
																<td bgcolor='FAFAFA' align='center' class='cate'>
																	<a href='mailto:$row[email]'>$row[email]</a></td>
																<td width='110' align='center' bgcolor='FAFAFA'>$telTemp$htelTemp</td>
																<td width='66' align='center' bgcolor='FAFAFA'>$MlevelTemp</td>
																<td width='66' align='center' bgcolor='FAFAFA'>$pointTemp</td>
																<td width='78' align='center' bgcolor='FAFAFA'>$signdateTemp1<br>$signdateTemp2</td>
																<td width='70' align='center' bgcolor='FAFAFA'><a href='odmembers/od_modify.php?serialnum=$row[serialnum]'><img src='odimages/b_detail.gif' border='0'></a></td>
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
													</td>
												</tr>
												<tr> 
													<td height="46"></td>
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
