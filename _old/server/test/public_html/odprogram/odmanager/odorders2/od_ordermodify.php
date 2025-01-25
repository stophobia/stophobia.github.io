<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_comAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";

	function round_price($price,$round) {
		$salePriceTemp = round($price,-$round);
		return $salePriceTemp;
	}

	$row = mysql_fetch_array(mysql_query("SELECT * FROM odtOrder WHERE ordernum='$ordernum'"));
	
	if($row[orderid] == "guest") $orderidTemp = "비회원주문";
	else $orderidTemp = $row[orderid];
	
	$OrderSumpriceD = number_format($row[sumprice]);
	$OrderDeliveryD = number_format($row[dPrice]);
	$OrderTotalPriceD = number_format($row[tPrice]);
	$OrderUsedpointD = number_format($row[gPrice]);
	$OrderGetpointD = number_format($row[gGetPrice]);
	$OrderDate = date("Y년 m월 d일 H시 i분",strtotime($row[orderdate]));
	$payDate = date("Y년 m월 d일 H시 i분",strtotime($row[paydate]));
	
	if($PageL == "All") $PageURL = "od_orderslist.php";
	else if($PageL == "Cancel") $PageURL = "od_orderslistCancel.php";
	else $PageURL = "od_orderslist.php";	

	if(!strcmp($Form,"OrderModify")) {
		if(!$row[expressdate]) $row[expressdate] = date("Y-m-d");
		
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
		
		## 처리직원
		$srow = mysql_fetch_array(mysql_query("SELECT name, agentName, htel FROM odtAdmin WHERE id='$row[staff_id]'"));

		## 에스크로 시작
		if($row[paymethod]=="E" && $row_setup[pg]=="KCP") $deliveryF_default = ""; 
		else $deliveryF_default = ""; 	
		## 에스크로 끝

		## 에스크로 시작 - ksnet 은행코드
		$ksnet_bank = array (
			"01" => "한국은행", "02" => "산업은행", "03" => "기업은행", "04" => "국민은행", "05" => "외환은행", "06" => "주택은행", "07" => "수협은행", "08" => "수출입", "09" => "장기신용", "10" => "신농협중앙", "11" => "농협중앙", "12~15" => "농협회원", "16" => "축협중앙", "20" => "우리은행", "21" => "조흥은행", "22" => "상업은행", "23" => "제일은행", "24" => "한일은행", "25" => "서울은행", "26" => "신한은행", "27" => "한미은행", "28" => "동화은행", "29" => "동남은행", "30" => "대동은행", "31" => "대구은행", "32" => "부산은행", "33" => "충청은행", "34" => "광주은행", "35" => "제주은행", "36" => "경기은행", "37" => "전북은행", "38" => "강원은행", "39" => "경남은행", "40" => "충북은행", "53" => "씨티은행", "71" => "우체국", "76" => "신용보증", "81" => "하나은행", "82" => "보람은행", "83" => "평화은행", "93" => "새마을금고");
		## 에스크로 끝
?>

		<script language="javascript">
			function valueCheck() {
				var form = document.snsForm;
/*
				if(!form.orderemail.value) {
					alert("전자우편주소를 입력해주세요.   ");
					form.orderemail.focus();
					return false;
				}
				if(!form.recname.value) {
					alert("배송인 이름을 입력해주세요.   ");
					form.recname.focus();
					return false;
				}
				if(!form.rectel1.value) {
					alert("배송지 전화번호를 입력해주세요.   ");
					form.rectel1.focus();
					return false;
				}
				if(!form.address.value) {
					alert("주소를 입력해주세요.   ");
					form.address.focus();
					return false;
				}
				if(form.delivstatus == "[object]") {
					if(form.delivstatus[1].checked == true) {
						if(!form.expressname.value) {
							alert('택배사명을 입력하세요.');
							form.expressname.focus();
							return false;
						}
						if(!form.expressnum.value) {
							alert('택배번호를 입력하세요.');
							form.expressnum.focus();
							return false;
						}
					}
				}
*/
			}
			function postsearch() {
				window.open('../../odpostcode/od_postsearch.php?Mode=Member','post_find','resizable=yes,scrollbars=yes,width=386,height=410'); 
			}
			function openwindow(name, url, width, height, scrollbar) {
				scrollbar_str = scrollbar ? 'yes' : 'no';
				window.open(url, name, 'width='+width+',height='+height+',scrollbars='+scrollbar_str);
			}
		</script>
		<style>
		body{background-color:'#ffffff'}
		</style>
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
<? include "$folderpath_manager_common/od_leftMenu2.inc.php"; ?>
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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 
													주문관리 &gt; <span class="st">주문정보변경</span></font></td>
												</tr>
												<tr> 
													<td height="2" bgcolor="D6D6D6"></td>
												</tr>
											</table>
											<table width="760" border="0" cellspacing="1" cellpadding="0">
												<tr>
													<td height="12"><a name="saleProd"></a></td>
												</tr>
											</table>
											<table width="760" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td width="760" valign="top">
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="28">
																	<b><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 주문상품정보</font></b></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr bgcolor="D8CBAE"> 
																<td height="3" align="center"></td>
															</tr>
															<tr> 
																<td height="26" align="center" bgcolor="FAF8F3">
																	<table width="760" border="0" cellspacing="0" cellpadding="0">
																		<tr> 
																			<td height="26" align="center" bgcolor="FAF8F3"><font color="856D37"><b>상품정보</b></font></td>
																			<td width="1" bgcolor="FAF8F3"><img src="../../odimages/order/basket_line.gif" width="1" height="32"></td>
																			<td width="55" align="center" bgcolor="FAF8F3"><font color="856D37"><b>수량</b></font></td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr bgcolor="D8CBAE"> 
																<td height="1"></td>
															</tr>
															<tr> 
																<td height="3"></td>
															</tr>
<?		
		$cart_result = mysql_query("select * from odtOrder where ordernum='".$ordernum."'");
		$cart_row = mysql_fetch_array($cart_result);
		$oLogArray = explode("^",preg_replace("[^\^]","",$cart_row[oLog]));
		$pLogArray = explode("^",$cart_row[pLog]);
		$cLogArray = explode("^",$cart_row[cLog]);
		for($zz=0;$zz<count($pLogArray);$zz++) {
			$proCode = explode("|",$pLogArray[$zz]);
			$coupon = explode("|",$cLogArray[$zz]);
			$prow = mysql_fetch_array(mysql_query("SELECT * FROM odtProduct WHERE code='$proCode[0]'"));

			if($cart_row[orderdate] < "2009-06-12") {	// 복수구매 기능 이전

				# 옵션값 추출
				if(strstr($cart_row[oLog],$proCode[0])) {	// 해당상품에 대한 옵션내역이 있으면
					$oLogArray = explode("^",$cart_row[oLog]);
					for($kk=0;$kk<count($oLogArray);$kk++) {
						if(strstr($oLogArray[$kk],$proCode[0])) {
							$oLogTmp = explode("|",$oLogArray[$kk]);
							$proCode[2] += $oLogTmp[2];
							$prow[name] .= " (옵션:".$oLogTmp[1].")";
						}
					}	
				}		

			} else {	// 복수구매 기능 이후

				# 옵션값 추출
				if($oLogArray[$zz]) {	// 해당상품에 대한 옵션내역이 있으면
					$oLogTmp = explode("|",$oLogArray[$zz]);
					$proCode[2] += $oLogTmp[2];
					$prow[name] .= " (옵션:".$oLogTmp[1].")";
				}
			}	
?>
															<tr> 
																<td>
																	<table width="760" border="0" cellspacing="1" cellpadding="0">
																		<tr> 
																			<td>
																				<table width="100%" border="0" cellspacing="0" cellpadding="0">
																					<tr> 
																						<td width="65" align="center"><img src="<?=$prow[prolist_img] ? $prow[prolist_img] : $prow[oldlist_img]?>" width=80></td>
																						<td class='cate'>
																							<b><font style='font-size:13;font-family:굴림;LETTER-SPACING:-0.06em;' color='1A1A1A' face='tahoma'><?=stripslashes($prow[name])?>
																						</td>
																					</tr>
																				</table>
																			</td>
																			<td width=56 align="center" class="pro_01"><b><?=$proCode[1]?></b>개</td>
																		</tr>
																	</table>
																</td>
															</tr>
															
<? 
		}
		 
		$cart_result = mysql_query("select * from odtOrder where ordernum='".$ordernum."'");
		$cart_row = mysql_fetch_array($cart_result);
		$pLogArray = explode("^",$cart_row[pLog]);
		$cLogArray = explode("^",$cart_row[cLog]);

		for($zz=0;$zz<count($pLogArray);$zz++) {
			$proCode = explode("|",$pLogArray[$zz]);
			$coupon = explode("|",$cLogArray[$zz]);
			$prow = mysql_fetch_array(mysql_query("SELECT * FROM odtProduct WHERE code='$proCode[0]'"));

			$totalPrice += $prow[price]*$proCode[1];
		}
?>
															<tr bgcolor="D8CBAE"> 
																<td height="1"></td>
															</tr>
														</table>

														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<!-- modify form start -->
															<form name="snsForm" method="post" action="<?=$php_self?>" onSubmit="return valueCheck(this)">
																<input type="hidden" name="Form" value="accessForm">
																<input type="hidden" name="ordernum" value="<?=$ordernum?>">
																<input type="hidden" name="PageL" value="<?=$PageL?>">
																<input type="hidden" name="par_page" value="<?=$par_page?>">
																<input type="hidden" name="page" value="<?=$page?>">
																<!--<input type="hidden" name="row[paystatus]" value="<?=$row[paystatus]?>">
																<input type="hidden" name="row[paystatus]" value="<?=$row[paystatus]?>">-->
															<tr> 
																<td height="16" colspan="4"></td>
															</tr>
															<tr> 
																<td height="23" colspan="4"><b><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 관리자 관리내용</font></b></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="D2D2D2"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
															<tr height="35"> 
																<td bgcolor="FAFAFA" style="padding:5px;" colspan="4">
																	<textarea name="comment1" cols="121" rows="9" class="border"><?=stripslashes($row[comment1])?></textarea></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="D2D2D2"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
<? 
		if($row[staff_id] <> 'none' AND $row[staff_id]) { 
?>
															<tr> 
																<td height="6" colspan="4"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
															<tr height="35"> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5"><b>담당 직원</b></td>
																<td bgcolor="FAFAFA" style="padding:5px;" colspan="3"><?=$srow[agentName]?> | <?=$srow[name]?> | <?=$srow[htel]?></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
<? 
		} 
?>
															<!-- 결제 및 배송 정보 시작 -->
															<tr> 
																<td height="10" colspan="4"></td>
															</tr>
															<tr> 
																<td height="23" colspan="4"><b><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 배송 정보</font></b></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>

															<input type="hidden" name="statusUpdate" value="yes">
															<tr height="35"> 
																<td bgcolor="ececec" class="white" style="padding:5px;" width="140"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">결제상태</td>
																<td bgcolor="FAFAFA" style="padding:5px;" colspan="3">
<? 
			if($row[paystatus] == "Y" ) { 
?>
																	&nbsp;<font color="FF0000"><b>결제확인</b></font>
<?
			}
			else if($row[paymethod] != "B") {
?>
																	&nbsp;<font color="FF0000"><b>미결제</b></font>
<?
			}
?>
																</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
															<tr> 
																<td height="6" colspan="4"></td>
															</tr>
															<tr>
																<td colspan="4">
<? 
		if($row[delivstatus]<>'yes') { 
?>
																	<div id="deliveryF" style="display:<?=$deliveryF_default;?>">
<? 
		} 
?>
																	<table width="100%" border="0" cellspacing="0" cellpadding="0">
																		<tr> 
																			<td height="1" bgcolor="c0bebe"></td>
																			<td height="1" bgcolor="D2D2D2" colspan="3"></td>
																		</tr>
																		<tr height="35"> 
																			<td bgcolor="ececec" class="white" style="padding:5px;" width="138"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">쿠폰발급상태</td>
																			<td bgcolor="FAFAFA" style="padding:5px;" width="244">
<? 
		if($row[delivstatus]=="yes") { 
?>
																				&nbsp;<font color="FF0000"><b>발급완료</b></font>
																				<input type="hidden" name="delivstatus" value="<?=$row[delivstatus];?>">
<? 
		}
		else { 
			if($row[paymethod]!="B" && $row[paystatus] == "N"){
?>
																				&nbsp;<font color='red'>발급대기</font>
<?
			}
			else{
?>
																				<input type="radio" name="delivstatus" value="no"<?if($row[delivstatus]=="no")echo" checked";?> onclick="this.form.expressnum.value=''">쿠폰발급대기
																				<input type="radio" name="delivstatus" value="yes"<?if($row[delivstatus]=="yes")echo" checked";?> onclick="this.form.expressnum.value='<?=strtoupper($onedaynet_id)."_".$ordernum?>'">쿠폰발급완료<br>
																				<font color="0000FF"><input type="checkbox" name="sendSMS_delivery" value="yes" checked>문자(SMS)를 전송할 경우 체크하세요.</font>


<?
			}
		} 
?>
																			</td>
																			<td colspan=2 bgcolor="FAFAFA" >
																				<a href="#none" onclick="window.open('./od_couponView.php?ordernum=<?=$row[ordernum]?>','','width=700px,height=520px')" >[쿠폰미리보기]</a>
																			</td>
																		</tr>
																		<tr> 
																			<td height="1" bgcolor="c0bebe"></td>
																			<td height="1" bgcolor="D2D2D2"></td>
																			<td height="1" bgcolor="c0bebe"></td>
																			<td height="1" bgcolor="D2D2D2"></td>
																		</tr>
																		<tr> 
																			<td height="6" colspan="4"></td>
																		</tr>
																		<tr> 
																			<td height="1" bgcolor="c0bebe"></td>
																			<td height="1" bgcolor="D2D2D2"></td>
																			<td height="1" bgcolor="c0bebe"></td>
																			<td height="1" bgcolor="D2D2D2"></td>
																		</tr>
																		<tr height="35"> 
																			<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">발급번호</td>
																			<td bgcolor="FAFAFA" style="padding:5px;">
																				<input type="text" name="expressnum" class="border" size="22" value="<?=$row[expressnum]?>" readonly><br>자동입력됩니다.</td>
																			<td bgcolor="ececec" class="white" style="padding:6px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">쿠폰 발급일</td>
																			<td bgcolor="FAFAFA" style="padding:5px;">
																				<input type="text" name="expressdate" class="border" size="16" value="<?=$row[expressdate]?>">&nbsp;입력예) 2002-05-05</td>
																		</tr>
																		<tr> 
																			<td height="1" bgcolor="c0bebe"></td>
																			<td height="1" bgcolor="D2D2D2"></td>
																			<td height="1" bgcolor="c0bebe"></td>
																			<td height="1" bgcolor="D2D2D2"></td>
																		</tr>
																	</table>
<? 
		if($row[delivstatus]<>'yes') { 
?>
																	</div>
<? 
		} 
?>
																</td>
															</tr>
															<tr> 
																<td height="6" colspan="4"></td>
															</tr>
															<tr> 
																<td height="25" colspan="4">
																	<table width="760" border="0" cellspacing="1" cellpadding="0">
																		<tr> 
																			<td align="center">
																				<input type="image" src="../odimages/odmain/btn_ok.gif" width="77" height="24" hspace="3" border="0" onfocus='this.blur();'> 
																				<img src="../odimages/odmain/btn_cancel.gif" width="77" height="24" hspace="3" border="0" onclick="reset();" style='cursor:hand;'>
																				<a href="<?=$PageURL?>?page=<?=$page?><?=$par_page?>" onfocus='this.blur();'><img src="../odimages/btn_list.gif" hspace="3" border="0"></a>
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<!-- 결제 및 배송 정보 종료 -->
															<!-- 주문자 정보 시작 -->
															<tr> 
																<td height="6" colspan="4"></td>
															</tr>
<?
$readonly = " readonly ";
?>		
															<tr> 
																<td height="23" colspan="4"><b><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 주문자 정보</font></b></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
																<td height="1" bgcolor="D2D2D2"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr height="35"> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5"><b>결제일시</b></td>
																<td bgcolor="FAFAFA" style="padding:5px;" colspan="3">
																	<b><?=$payDate?></b></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
															<tr> 
																<td height="6" colspan="4"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
<? 
		if($PageL == "Cancel") { 
?>
															<tr height="35"> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5"><b>주문취소일시</b></td>
																<td bgcolor="FAFAFA" style="padding:5px;" colspan="3">
																	<b><font color="FF0000"><?=date("Y년 m월 d일 H시 i분 s초",$row[canceldate])?></font></b></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
															<tr> 
																<td height="6" colspan="4"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
<? 
		} 
?>
														<tr height="35"> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">주문자명</td>
																<td bgcolor="FAFAFA" style="padding:5px;font-size:15;">
																	<b><?=$row[ordername]?> 
																	<?
																		$osex = @mysql_result(mysql_query("select sex from odtMember where id='".$row[orderid]."'"),0);
																		if($osex == "F") echo "(여)";
																		else if($osex == "M") echo "(남)";

																	?></b>
																</td>
																<td width="130" bgcolor="ececec" class="white" style="padding:6px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">주문자 아이디</td>
																<td bgcolor="FAFAFA" style="padding:5px;;font-size:15;">
																	<?=$orderidTemp?>&nbsp;</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="6" colspan="4"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr height="35"> 
																<td width="130" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">전화번호</td>
																<td width="245" bgcolor="FAFAFA" style="padding:5px;"><?=$row[ordertel1]?> - <?=$row[ordertel2]?> - <?=$row[ordertel3]?></td>
																<td width="130" width="130" bgcolor="ececec" class="white" style="padding:6px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">휴대폰번호</td>
																<td width="245" bgcolor="FAFAFA" style="padding:5px;"><?=$row[orderhtel1]?> - <?=$row[orderhtel2]?> - <?=$row[orderhtel3]?></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="6" colspan="4"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
															<tr height="35"> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">E-mail</td>
																<td bgcolor="FAFAFA" style="padding:5px;" colspan="3"><?=$row[orderemail]?>&nbsp;</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
															<!-- 주문자 정보 종료 -->
															<!-- 수신자 정보 시작 -->
															<tr> 
																<td height="16" colspan="4"></td>
															</tr>
															<tr> 
																<td height="23" colspan="4"><b><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 수신자 정보</font></b></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
															<tr height="35"> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">수신자명</td>
																<td bgcolor="FAFAFA" style="padding:5px;" colspan="3"><?=$row[recname]?>&nbsp;</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
															<tr> 
																<td height="6" colspan="4"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr height="35"> 
																<td width="130" bgcolor="ececec" class="white" style="padding:6px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">연락처</td>
																<td width="245" bgcolor="FAFAFA" style="padding:5px;"><?=$row[rechtel1]?> - <?=$row[rechtel2]?> - <?=$row[rechtel3]?></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="6" colspan="4"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
															<tr height="35"> 
																<td width="130" bgcolor="ececec" class="white" style="padding:6px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">이메일</td>
																<td width="245" bgcolor="FAFAFA" style="padding:5px;"><?=$row[recemail]?></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="6" colspan="4"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
															<tr height="35" style='display:none'> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">우편번호</td>
																<td bgcolor="FAFAFA" style="padding:5px;" colspan="3"><?=$row[reczip1]?>"> - <?=$row[reczip2]?></td>
															</tr>
															<tr style='display:none'> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
															<tr style='display:none'> 
																<td height="6" colspan="4"></td>
															</tr>
															<tr style='display:none'> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
															<tr height="35" style='display:none'> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">주 소</td>
																<td bgcolor="FAFAFA" style="padding:5px;" colspan="3"><?=$row[recaddress]?><br>
																	<img src="blank.gif" width="1" height="3"><br>
																	<?=$row[recaddress1]?></td>
															</tr>
															<tr style='display:none'> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
															<tr style='display:none'> 
																<td height="6" colspan="4"></td>
															</tr>
															<tr style='display:none'> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
															<tr height="35"> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">하고싶은말</td>
																<td bgcolor="FAFAFA" style="padding:5px;" colspan="3"><?=htmlspecialchars(stripslashes($row[comment]))?>&nbsp;</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
											<table width="760" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="8"></td>
												</tr>
											</table>
											<table width="760" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td style="display:none">
														<img src="../odimages/print_addr.gif" border="0" style='cursor:hand;' onclick="openwindow('label', 'orderlabel.php?OrderNum=<?=$row[ordernum]?>',330,400,1);">&nbsp;
														<img src="../odimages/print_order.gif" border="0" style='cursor:hand;' onclick="openwindow('receipt', 'receiptP.php?OrderNum=<?=$row[ordernum]?>',640,550, 1);">&nbsp;
														<img src="../odimages/print_tax.gif" border="0" style='cursor:hand;' onclick="openwindow('taxreceipt', 'ordertax.php?OrderNum=<?=$row[ordernum]?>',610,580,1);">&nbsp;
														<img src="../odimages/print_estimate.gif" border="0" style='cursor:hand;' onclick="openwindow('estimate', 'orderestimate.php?OrderNum=<?=$row[ordernum]?>',500,580, 1);">
													</td>
													<td align="right">
														<!-- 접근권한(수정) -->
														<input type="image" src="../odimages/odmain/btn_ok.gif" width="77" height="24" border="0" onfocus='this.blur();'>&nbsp;
														<img src="../odimages/odmain/btn_cancel.gif" width="77" height="24" border="0" onclick="reset();" style='cursor:hand;'>&nbsp;
														<a href="<?=$PageURL?>?page=<?=$page?><?=$par_page?>" onfocus='this.blur();'><img src="../odimages/btn_list.gif" border="0"></a>
													</td>
												</tr>
												</form>
												<!-- form end -->
											</table>
											<table width="760" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="30">&nbsp;</td>
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
<?
	}
	else if(!strcmp($Form,"accessForm")) {
		
		chk_authfree();

		$ordernum = $_POST["ordernum"];
		
		$mail_row = mysql_fetch_array(mysql_query("SELECT * FROM odtOrder WHERE ordernum='$ordernum'"));
		
		if(!$delivstatus) $delivstatus = $row[delivstatus];
		if(!$paystatus) $paystatus = $row[paystatus];
		
		$comment = addslashes(trim($comment));
		$comment1 = addslashes(trim($comment1));
		$today = time();

		## 일괄업데이트
		if($statusUpdate == "yes") { 
			if($pointed == "Y") $cart_pointed = "yes";
			else $cart_pointed = "no";

			// 쿠폰 이미지가 등록되어있는지 체크
			$row_product_tmp2 = mysql_fetch_array(mysql_query("select * from odtProduct where code = '".reset(explode("|",$mail_row[pLog]))."'"));
			if(!$row_product_tmp2[cpDp_img]) {
				error_msgall('해당 상품의 쿠폰 이미지가 등록되어있지 않습니다. \\n\\n쿠폰이미지 등록후 다시 진행해주시기 바랍니다.','back');
				exit;
			}
			if(!$row_product_tmp2[comment3]) {
				error_msgall('해당 상품의 쿠폰사용 주의사항이 등록되어있지 않습니다. \\n\\n쿠폰사용 주의사항 등록후 다시 진행해주시기 바랍니다.','back');
				exit;
			}


			if($PageL != "Cancel" AND $row[delivstatus]<>$delivstatus AND $delivstatus=="yes") {

				if($mail_row[viewDel] == "1") {

					$orderhtel1Tmp = $mail_row[rechtel1];
					$orderhtel2Tmp = $mail_row[rechtel2];
					$orderhtel3Tmp = $mail_row[rechtel3];

					$mail_row[orderemail] = $mail_row[recemail];
//					$mail_row[ordername] = $mail_row[recname];

				} else {

					$orderhtel1Tmp = $mail_row[orderhtel1];
					$orderhtel2Tmp = $mail_row[orderhtel2];
					$orderhtel3Tmp = $mail_row[orderhtel3];

					
					$mail_row[orderemail] = $mail_row[orderemail];

				}

				$expressnumTmp = $expressnum;

				if($sendSMS_delivery == "yes") {
					include "od_sms_delivery.inc.php";
				}

				## 배송상태 메일발송
				include "od_SendEmail_02.inc.php"; 
			}

			$result1 = mysql_query("UPDATE odtOrder SET 
															pointed				= '$pointed',
															pointeddate		= '$today',
															delivstatus		= '$delivstatus',
															expressname		= '$expressname',
															expressnum		= '$expressnum',
															expressdate		= '$expressdate',
															comment1			= '$comment1'															
															WHERE 
															ordernum			= '$ordernum'");

		}

		if($paystatus == "Y") {
			$paystatus_cart="yes";
			$paydate = time();
		}
		else {
			$paystatus_cart="no";
			$paydate = 0;
		}
// 입점업체는 택배 및 메모만 수정되게.....
/*
		$result = mysql_query("UPDATE odtOrder SET 
														orderemail		='$orderemail',
														ordertel1			='$ordertel1',
														ordertel2			='$ordertel2',
														ordertel3			='$ordertel3',
														orderhtel1		='$orderhtel1',
														orderhtel2		='$orderhtel2',
														orderhtel3		='$orderhtel3',
														recname				='$recname',
														recemail			='$recemail',
														rectel1				='$rectel1',
														rectel2				='$rectel2',
														rectel3				='$rectel3',
														rechtel1			='$rechtel1',
														rechtel2			='$rechtel2',
														rechtel3			='$rechtel3',
														reczip1				='$zip1',
														reczip2				='$zip2',
														recaddress		='$address',
														recaddress1		='$address1',
														comment				='$comment',
														comment1			='$comment1',
														companynum		='$companynum',
														companyname		='$companyname',
														ceoname				='$ceoname',
														companyadd		='$companyadd',
														taxstatus			='$taxstatus',
														taxitem				='$taxitem',
														paystatus			='$paystatus',
														paydate				='$paydate',
														delivstatus		='$delivstatus'
														WHERE 
														ordernum			='$ordernum'");
		## 취소주문 수정이 아닌경우 결제확인 메일 및 문자 발송
		if($PageL != "Cancel" AND $row[paystatus]<>$paystatus AND $paystatus=="Y") {
			if($sendSMS_pay == "yes") {
				include "sms_pay.inc.php";
			}
			include "SendEmail_01.inc.php";

			## 지포인트 지급
			mysql_query("update odtMember set point = point + ".$row[gGetPrice]." where id='".$row[orderid]."'");
			## 로그에남김
			$goodname = mysql_result(mysql_query("select name from odtProduct where code ='".reset(explode("|",$row[pLog]))."'"),0);
			$queL = "insert into odtPointLog set
								pointID				= '".$row[orderid]."',
								pointTitle		= '상품 구입(".$goodname.")',
								pointPoint		= '".$row[gGetPrice]."',
								pointResult		=	'".mysql_result(mysql_query("select point from odtMember where id='".$row[orderid]."'"),0)."',
								pointStatus		= 'Y',
								pointRegidate = now()";
			mysql_query($queL);
		}
*/		
		echo "
			<script>
				window.alert(\"수정이 잘 되었습니다.   \");
			</script>";

		if($PageL == "All") $PageURL = "od_orderslist.php";
		else if($PageL == "Cancel") $PageURL = "od_orderslistCancel.php";
		else $PageURL = "od_orderslist.php";
		
		echo "<meta http-equiv='Refresh' content='0; URL=$PageURL?page=$page$par_page'>";
		exit;
	}
	else {
		exit;
	}
?>