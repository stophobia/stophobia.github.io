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
	
	unset($bankName,$bankNo);
	$bankQue = mysql_query("select no,name from odtCardTitle");
	while($bankRow = mysql_fetch_array($bankQue)) {
		$bankName[] = $bankRow[name];
		$bankNo[]		= $bankRow[no];
	}
	$sDate = $_GET[sDate] ? $_GET[sDate] : date('Y-m-01');
	$eDate = $_GET[eDate] ? $_GET[eDate] : date('Y-m-d',mktime(23,59,59,date('m')+1,0,date('Y')));


?>
		<iframe name="tmpFrame" src="about:blank" style="display:none"></iframe>
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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 정산관리 &gt; <span class="st">입출금 입력</span></font></td>
												</tr>
												<tr> 
													<td >

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
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="18"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">정산기능은 금전출납부 기능을 웹으로 구현한것으로서 조회나, 정산이 빠르고 편리합니다. </font></td>
												</tr>
												<tr> 
													<td height="18"> <font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">통장과 계정을 먼저 등록하신후에 사용하시기 바랍니다.</font></td>
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
													<!-- ID, 이름검색 -->
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td colspan="3"><img src="../odimages/odmain/search_piece1.gif" width="760" height="8"></td>
															</tr>
															<tr> 
																<td width="6" background="../odimages/odmain/search_bg1.gif">&nbsp;</td>
																<td width="748" align="center" style="padding:10px;">
																	<!-- search form start -->
																	<table width="100%" border="0" cellspacing="1" cellpadding="0">
																		<form name="view" method="get" action="<?=$_SERVER[PHP_SELF]?>">
																			<input type="hidden" name="search_value_" value="true">
																			<!--
																			<input type="hidden" name="search" value="">
																			<input type="hidden" name="key" value="">
																			-->
																		<tr> 
																			<td height="25" colspan="2"><font color="DD896B"><b>*</b> 검색조건을 선택하신 후 검색 버튼을 클릭해 주시기 바랍니다.</font></td>
																		</tr>
																		<tr> 
																			<td>
																				<table border="0" cellspacing="5" cellpadding="0">
																					<tr> 
																						<td style="padding-right:20px"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">기간&nbsp;&nbsp;
																							<input type="text" size=10 name="sDate" readonly id='calInp1' value="<?=$sDate?>" style="cursor:hand" class="border">
																							<script type="text/javascript">
																							var cal4 = new jsCalendar(document.getElementById('calInp1'));
																							</script>
																							~
																							<input type="text" size=10 name="eDate" readonly id='calInp2' value="<?=$eDate?>" style="cursor:hand" class="border">
																							<script type="text/javascript">
																							var cal5 = new jsCalendar(document.getElementById('calInp2'));
																							</script>
<script>
function changeSelectBar(obj) {
	if(obj.value == "input") {
		document.getElementById("payTitleID").style.display='';
		document.getElementById("payTitle2ID").style.display='none';
	} else if(obj.value == "output") {
		document.getElementById("payTitle2ID").style.display='';
		document.getElementById("payTitleID").style.display='none';
	}
}
</script>

																							</td>
																						<td width=250><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">분&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;류&nbsp;&nbsp;
																							<select name="insType" class="border" onchange="changeSelectBar(this)">
																								<option value="">전체</option>
																								<option value="input"		<?=$insType == "input"	? "selected" : NULL;?>>입</option>
																								<option value="output"	<?=$insType == "output" ? "selected" : NULL;?>>출</option>
																							</select>
																							<br>
<img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">계정과목&nbsp;&nbsp;
																							<select name="type" class="border" id="payTitleID" style="display:inline">
																								<option value="">전체</option>
<?
$resTmp = mysql_query("select * from odtAccountTitle where type like '%입%'");
while($rowTmp = mysql_fetch_array($resTmp)) {
?>
																								<option value="<?=$rowTmp[name]?>" <?=$rowTmp[name] == $type ? "selected" : NULL;?>><?=$rowTmp[name]?></option>
<?
}
?>


																							</select><select name="type2" class="border"  id="payTitle2ID" style="display:none">
																								<option value="">전체</option>
<?
$resTmp = mysql_query("select * from odtAccountTitle where type like '%출%'");
while($rowTmp = mysql_fetch_array($resTmp)) {
?>
																								<option value="<?=$rowTmp[name]?>" <?=$rowTmp[name] == $type2 ? "selected" : NULL;?>><?=$rowTmp[name]?></option>
<?
}
?>
																							</select>
																							</td>

																						<td><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">계좌&nbsp;&nbsp;
																							<select name="bank" class="border">
																								<option value="">전체</option>
<?
for($i=0;$i<count($bankName);$i++) {
?>
																								<option value="<?=$bankName[$i]?>" ><?=$bankName[$i]?></option>
<?
}
?>																						</select>
																							</td>
																					</tr>
																					<tr>
																						<td colspan=10 height=30 valign=bottom>
<?
for($i=0;$i<count($bankName);$i++) {
?>
																							<input type="button" value="<?=$bankName[$i]?>" class="border" style='background-color:dddddd;width:100px;height:30px' onclick="location.href='od_accountView.php?no=<?=$bankNo[$i]?>'"> &nbsp;
<?
}
?>																						</td>
																				</table>
																			</td>
																			<td align="right"><input type="image" src="../odimages/odmain/search_btn.gif" width="68" height="64" onfocus='this.blur();'></td>
																		</tr>
																		</form>
																	</table>
																	<!-- search form end -->
																</td>
																<td width="6" background="../odimages/odmain/search_bg2.gif">&nbsp;</td>
															</tr>
															<tr> 
																<td colspan="3"><img src="../odimages/odmain/search_piece2.gif" width="760" height="8"></td>
															</tr>
														</table>
													<!-- // -->
													</td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="1" cellpadding="0">
												<tr> 
													<td height="15">&nbsp;</td>
												</tr>
											</table>
														<table width="760" border="0" cellspacing="1" cellpadding="3" bgcolor=#f0d2bd>
															<tr align="center">
																<td width="50" height=30 bgcolor="ececec" class="white">선택</td>
																<td width="70" bgcolor="ececec" class="white">날짜</td>
																<td width="120" bgcolor="ececec" class="white">계정과목</td>
																<td width="60" bgcolor="ececec" class="white">입</td>
																<td width="60" bgcolor="ececec" class="white">출</td>
																<td width="70" bgcolor="ececec" class="white">잔액</td>
																<td bgcolor="ececec" class="white">적요</td>
																<td width="70" bgcolor="ececec" class="white">계좌</td>
																<td width="60" bgcolor="ececec" class="white">수정</td>
															</tr>
														<!-- 직접 입력 -->
														<script>
															function accFun(frm) {
																return true;
															}
														</script>

														<form name="accFrm" action="od_accountPro.php" target="tmpFrame" method="post" onsubmit="return accFun(this)">
														<input type="hidden" name="subMode" value="ins">
															<tr id=payTr1 style="display:">
																<td height=30 align=center bgcolor=#d3ffe1>
																	<input name="payMode" type="radio" value="input" checked id="input1"><label for="input1">입</label><br><input name="payMode" type="radio" value="output"  id="input2" onclick="if(this.checked) payTr1.style.display='none';payTr2.style.display='';this.form.payMode2[1].checked=true;"><label for="input2">출</label>
																</td>
																<td align=center bgcolor=#d3ffe1>
																	<input type="text" id="calInp3" name="payDate" size=10 class="border" readonly style="cursor:hand" value="<?=date('Y-m-d')?>" onchange='this.form.payDate2.value=this.value'>
																	<script type="text/javascript">
																	var cal6 = new jsCalendar(document.getElementById('calInp3'));
																	</script>
																</td>
																<td align=center bgcolor=#d3ffe1>
																	<select name="payTitle" class="border">
<?
$resTmp = mysql_query("select * from odtAccountTitle where type like '%입%'");
while($rowTmp = mysql_fetch_array($resTmp)) {
?>
																								<option value="<?=$rowTmp[name]?>"><?=$rowTmp[name]?></option>
<?
}
?>
																	</select>
																</td>
																<td align=center bgcolor=#d3ffe1><input type="text" name="payPrice" class="border" size=7></td>
																<td align=center bgcolor=#d3ffe1>-</td>
																<td align=center bgcolor=#d3ffe1>-</td>
																<td align=center bgcolor=#d3ffe1><input type="text" name="payMemo" class="border" size=20></td>
																<td align=center bgcolor=#d3ffe1><select name='bank' class="border" style='width:70px'>
<?
for($i=0;$i<count($bankName);$i++) {
?>
																	<option value="<?=$bankName[$i]?>"><?=$bankName[$i]?></option>
<?
}
?>
																</select></td>
																<td bgcolor=#d3ffe1 align=center>
																<input type='submit' value="ok" class='border'>
																</td>
															</tr>
															<tr id=payTr2 style="display:none">
																<td height=30 align=center bgcolor=#d3ffe1>
																	<input name="payMode2" type="radio" value="input" id="input3" onclick="if(this.checked) payTr2.style.display='none';payTr1.style.display='';this.form.payMode[0].checked=true;"><label for="input3">입</label><br><input name="payMode2" type="radio" value="output" id="input4" ><label for="input4">출</label>
																</td>
																<td align=center bgcolor=#d3ffe1>
																	<input type="text" id="calInp4" name="payDate2" size=10 class="border" readonly style="cursor:hand" value="<?=date('Y-m-d')?>" onchange='this.form.payDate.value=this.value'>
																	<script type="text/javascript">
																	var cal7 = new jsCalendar(document.getElementById('calInp4'));
																	</script>
																</td>
																<td align=center bgcolor=#d3ffe1>
																	<select name="payTitle2" class="border">
<?
$resTmp = mysql_query("select * from odtAccountTitle where type like '%출%'");
while($rowTmp = mysql_fetch_array($resTmp)) {
?>
																								<option value="<?=$rowTmp[name]?>"><?=$rowTmp[name]?></option>
<?
}
?>
																	</select>
																</td>
																<td align=center bgcolor=#d3ffe1>-</td>
																<td align=center bgcolor=#d3ffe1><input type="text" name="payPrice2" class="border" size=7></td>
																<td align=center bgcolor=#d3ffe1>-</td>
																<td align=center bgcolor=#d3ffe1><input type="text" name="payMemo2" class="border" size=20></td>
																<td align=center bgcolor=#d3ffe1><select name='bank2' class="border">
	<?
for($i=0;$i<count($bankName);$i++) {
?>
																	<option value="<?=$bankName[$i]?>"><?=$bankName[$i]?></option>
<?
}
?>															</select></td>
																<td bgcolor=#d3ffe1 align=center>
																<input type='submit' value="ok" class='border'>
																</td>
															</tr>
														</form>
														<!-- 직접 입력 끝 -->
															<!-- 합계 -->
															<tr style=display:none> 
																<td height=30 align=center bgcolor=#FFFFFF><b><font color="red">합 계</font></b></td>
																<td align=center bgcolor=#FFFFFF><font color="red"><span id='totalCnt'></span></font></td>
																<td align=center bgcolor=#FFFFFF>-</td>
																<td align=right bgcolor=#FFFFFF><font color="red"><span id='payInputTotal'></span></font></td>
																<td align=right bgcolor=#FFFFFF><font color="red"><span id='payOutputTotal'></span></font></td>
																<td align=right bgcolor=#FFFFFF><font color="red"><span id='payResultTotal'></span></font></td>
																<td align=center bgcolor=#FFFFFF>-</td>
																<td align=center bgcolor=#FFFFFF>-</td>
															</tr>
												
<?
//$iwall = mysql_result(mysql_query("select sum(price) from odtAccount where date < '".$sDate."'"),0);
?>


															
															<!-- 이월금 처리 시작 -->
															<tr style='display:none'> 
																<td height=30 align=center bgcolor=#FFFFFF><b><font color="red">이월금</font></b></td>
																<td align=center bgcolor=#FFFFFF>-</td>
																<td align=center bgcolor=#FFFFFF>-</td>
																<td align=right bgcolor=#FFFFFF>-</td>
																<td align=right bgcolor=#FFFFFF>-</td>
																<td align=right bgcolor=#FFFFFF><?=number_format($iwall)?></td>
																<td align=center bgcolor=#FFFFFF>-</td>
																<td align=center bgcolor=#FFFFFF>-</td>
															</tr>
															<!-- 이월금 처리 끝 -->


<?
## 조건 #############################################
unset($where_);
if($insType == "input") {
	$where_ .= " and price >= 0 ";
	if($type) $where_ .= " and title = '".$type."'";
} else if($insType == "output") {
	$where_ .= " and price <= 0 ";
	if($type2) $where_ .= " and title = '".$type2."'";
}
if($bank) $where_ .= " and bank = '".$bank."'";
#######################################################



## 이월금
for($i=0;$i<count($bankName);$i++) {
	$iwall[$bankName[$i]] = mysql_result(mysql_query("select sum(price) from odtAccount where date < '".$sDate."' and bank = '".$bankName[$i]."'"),0);
}

$idx=0;
$resPrice = 0;
$que = "select * from odtAccount where date >= '".$sDate."' and date <= '".$eDate."' ".$where_." order by date asc";
$res = mysql_query($que);
while($row = mysql_fetch_array($res)) {
	$idx++;

	$plusPrice	+= $row['price'] > 0 ? $row['price'] : 0;
	$minusPrice += $row['price'] < 0 ? $row['price'] : 0;
	$resPrice		+= $row['price'];

	$iwall[$row[bank]] += $row[price];

?>	

															<tr id='payTrA<?=$idx?>' style='display:'> 
																<td height=30 align=center bgcolor=#ffffff><?=$row['type'] == "output" ? "출" : "입";?></td>
																<td align=center bgcolor=#ffffff><?=$row['date']?></td>
																<td align=center bgcolor=#ffffff><?=$row['title']?></td>
																<td align=right bgcolor=#ffffff><?=$row['price'] > 0 ? number_format($row['price']) : 0;?></td>
																<td align=right bgcolor=#ffffff><?=$row['price'] < 0 ? number_format($row['price']) : 0;?></td>
																<td align=right bgcolor=#ffffff><?=$row[bank] != "법인카드" ? number_format($iwall[$row[bank]]) : "-";?></td>
																<td align=center bgcolor=#ffffff><?=$row[memo]?></td>
																<td align=center bgcolor=#ffffff><?=$bankArray[$row[bank]]?></td>
																<td align=center bgcolor=#ffffff>
																	<input type='checkbox' onclick="if(this.checked ==true) {payTrA<?=$idx?>.style.display='none';payTrB<?=$idx?>.style.display='';}">
																</td>
															</tr>
															<form name="payFrm" action="od_accountPro.php" target="tmpFrame" method="post">
															<input type="hidden" name="subMode" value="edt">
															<input type="hidden" name="type" value="<?=$row['type']?>">
															<input type="hidden" name="payNo" value="<?=$row[no]?>">
															<tr id='payTrB<?=$idx?>' style='display:none'> 
																<td height=30 align=center bgcolor=#ffffff><?=$row['type'] == "output" ? "출" : "입";?></td>
																<td align=center bgcolor=#ffffff><input type="text" name="payDate" size=10 class="border" value="<?=$row['date']?>"></td>
																<td align=center bgcolor=#ffffff>
																	<select name="payTitle" class="border">
		<?
		$resTmp = mysql_query("select * from odtAccountTitle where type like '%".($row['type'] == "output" ? "출" : "입")."%'");
		while($rowTmp = mysql_fetch_array($resTmp)) {
		?>
																		<option value="<?=$rowTmp[name]?>" <?=$rowTmp[name] == $row[title] ? "selected" : NULL;?>><?=$rowTmp[name]?></option>
		<?
		}
		?>

																	</select>
																</td>
																<td align=right bgcolor=#ffffff>
		<?
		if($row[price] >0) echo			"<input type='text' name='payPrice' size=7 class='border' value='".$row['price']."'>";
		else												"-";
		?>
																</td>
																<td align=center bgcolor=#ffffff>
		<?
		if($row[price] <0) echo			"<input type='text' name='payPrice' size=7 class='border' value='".$row['price']."'>";
		else												"-";
		?>																
																</td>
																<td align=center bgcolor=#ffffff>-</td>
																<td align=center bgcolor=#ffffff><input type="text" name="payMemo" size=20 class="border" value="<?=$row['memo']?>"></td>
																<td align=center bgcolor=#ffffff>
																<select name='bank' class="border">
		<?
		for($i=0;$i<count($bankName);$i++) {
		?>
																	<option value="<?=$bankName[$i]?>" <?=$row['bank'] == $bankName[$i] ? "selected" : NULL;?>><?=$bankName[$i]?></option>
		<?
		}
		?>
																</select>

																</td>
																<td align=center bgcolor=#ffffff>
																	<input type='submit' value="ok" class='border'>
																	<input type='button' value="del" class='border' onclick="if(confirm('삭제하시겠습니까?')) {this.form.subMode.value='del';this.form.submit();}"?>
																</td>
															</tr>
															</form>
	
<?
}
?>
	
															<tr>
															<!-- 합계 -->
																<td height=30 align=center bgcolor=#FFFFFF><b><font color="red">합 계</font></b></td>
																<td align=center bgcolor=#FFFFFF><font color="red"><?=$idx?> 건</font></td>
																<td align=center bgcolor=#FFFFFF>-</td>
																<td align=right bgcolor=#FFFFFF><font color="red"><?=number_format($plusPrice)?></span></font></td>
																<td align=right bgcolor=#FFFFFF><font color="red"><?=number_format($minusPrice)?></font></td>
																<td align=right bgcolor=#FFFFFF><font color="red"><?=number_format($resPrice)?></font></td>
																<td align=center bgcolor=#FFFFFF>-</td>
																<td align=center bgcolor=#FFFFFF>-</td>
																<td align=center bgcolor=#FFFFFF>-</td>
															</tr>
														</table>
<script>
// 상단 합계 출력을 위함
/*
document.getElementById('totalCount').innerHTML			= '<?=$idx?>건';
document.getElementById('payOutputTotal').innerHTML	= '<?=number_format($plusPrice)?>';
document.getElementById('payInputTotal').innerHTML		= '<?=number_format($minusPrice)?>';
document.getElementById('payResultTotal').innerHTML		= '<?=number_format($resPrice)?>';
*/
</script>


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