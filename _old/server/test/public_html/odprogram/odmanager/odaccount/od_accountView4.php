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

	$bankArray = array('광주은행(경비계좌)'=>'광주(경비)','광주은행(급여계좌)'=>'광주(급여)','국민은행'=>'국민','법인카드'=>'카드');

	$sDate = $_GET[sDate] ? $_GET[sDate] : date('Y-01-01');
	$eDate = $_GET[eDate] ? $_GET[eDate] : date('Y-m-d',mktime(23,59,59,date('m')+1,0,date('Y')));

	## 조건 #############################################
	unset($where_);
	if($insType == "input") {
		$where_ .= " and price >= 0 ";
		if($type) $where_ .= " and title = '".$type."'";
	} else if($insType == "output") {
		$where_ .= " and price <= 0 ";
		if($type2) $where_ .= " and title = '".$type2."'";
	}
	#######################################################

	$que = "select * from odtAccount where date >= '".$sDate."' and date <= '".$eDate."' and bank='법인카드' ".$where_." order by date asc";
	$res = mysql_query($que);
	$total = mysql_num_rows($res);

?>
	<script>	
			function saveExcel(fileTemp) {
				tmpFrame.location.href=fileTemp;
			}
	</script>
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
								<table width="782" height="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="D6D6D6">
									<tr> 
										<td align="center" valign="top" bgcolor="#FFFFFF"> 
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 정산관련 &gt; <span class="st">입출현황</span></font></td>
												</tr>
												<tr> 
													<td height="2" bgcolor="D6D6D6"></td>
												</tr>
												<tr>
													<td height=5></td>
												</tr>											
												<tr> 
													<td>
													<!-- 상단 탭 -->
														<table width="100%" border="0" cellpadding="0" cellspacing="0">
															<tr>
																<td background="../odimages/odtab/tab_off.gif" width=78 height=33 align=center class="cate">
																	<a href="od_accountView1.php">
																		국민은행
																	</a>
																</td>
																<td background="../odimages/odtab/tab_off.gif" width=78 height=33 align=center class="cate">
																	<a href="od_accountView2.php">
																		광주(경비)
																	</a>
																</td>
																<td background="../odimages/odtab/tab_off.gif" width=78 height=33 align=center class="cate">
																	<a href="od_accountView3.php">
																		광주(급여)
																	</a>
																</td>
																<td background="../odimages/odtab/tab_on.gif" width=78 height=33 align=center class="cate">
																	<a href="od_accountView4.php">
																		<b><font color=white>법인카드</font></b>
																	</a>
																</td>
																<td background="../odimages/odtab/tab_off.gif" width=78 height=33 align=center class="cate">
																	<a href="od_accountView5.php">
																		전도금
																	</a>
																</td>
																<td background="../odimages/odtab/tab_bg.gif">&nbsp;</td>
															</tr>
														</table>
													<!-- 상단 탭 끝 -->
												</tr>
												<tr>
													<td height=5></td>
												</tr>		
												<tr>
													<td>
													
													<!-- ID, 이름검색 -->
														<table width="782" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td colspan="3"><img src="../odimages/odmain/search_piece1.gif" width="782" height="8"></td>
															</tr>
															<tr> 
																<td width="6" background="../odimages/odmain/search_bg1.gif">&nbsp;</td>
																<td width="770" align="center" style="padding:10px;">
																	<!-- search form start -->
																	<table width="100%" border="0" cellspacing="1" cellpadding="0">
																		<form name="view" method="get" action="<?=$_SERVER[PHP_SELF]?>">
																			<input type="hidden" name="search_value_" value="true">
																			<!--
																			<input type="hidden" name="search" value="">
																			<input type="hidden" name="key" value="">
																			-->
																		<tr> 
																			<td height="25" colspan="2">
																			<font color="DD896B"><b>*</b> 검색조건을 선택하신 후 검색 버튼을 클릭해 주시기 바랍니다.</font>
																			</td>
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
																						<td><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">분류&nbsp;&nbsp;
																							<select name="insType" class="border" onchange="changeSelectBar(this)">
																								<option value="">전체</option>
																								<option value="input"		<?=$insType == "input"	? "selected" : NULL;?>>입</option>
																								<option value="output"	<?=$insType == "output" ? "selected" : NULL;?>>출</option>
																							</select>
																							</td>
																						<td><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">계정과목&nbsp;&nbsp;
																							<select name="type" class="border" id="payTitleID" style="display:<?=$insType == "input" || !$insType ? "yes" : "none";?>">
																								<option value="">전체</option>
<?
$resTmp = mysql_query("select * from odtAccountTitle where type like '%입%'");
while($rowTmp = mysql_fetch_array($resTmp)) {
?>
																								<option value="<?=$rowTmp[name]?>" <?=$rowTmp[name] == $type ? "selected" : NULL;?>><?=$rowTmp[name]?></option>
<?
}
?>


																							</select>
																							<select name="type2" class="border"  id="payTitle2ID" style="display:<?=$insType == "output" ? "yes" : "none";?>">
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
<!--
																						<td><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">출력&nbsp;&nbsp;
																							<select name="newListCnt">
																							<option value="20"		<?=$newListCnt == 20		|| !$newListCnt ? "selected" : NULL;?>>20개</option>
																							<option value="50"		<?=$newListCnt == 50		|| !$newListCnt ? "selected" : NULL;?>>50개</option>
																							<option value="100"		<?=$newListCnt == 100		|| !$newListCnt ? "selected" : NULL;?>>100개</option>
																							<option value="9999"	<?=$newListCnt == 9999	|| !$newListCnt ? "selected" : NULL;?>>전체</option>
																							</select>
																						</td>
-->
																					</tr>
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
																<td colspan="3"><img src="../odimages/odmain/search_piece2.gif" width="782" height="8"></td>
															</tr>
														</table>
													<!-- // -->
													</td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="1" cellpadding="0">
												<tr>
													<td height="7"></td>
												</tr>
											</table>
											<table width="782" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="7" bgcolor="FFFFFF"></td>
												</tr>
												<tr> 
													<td height="2" bgcolor="D2D2D2"></td>
												</tr>
											</table>
											<table width="782" border="0" cellspacing="1" cellpadding="0">
												<tr>
													<td height="7"></td>
												</tr>
											</table>
											<table width="782" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td valign="top">
														<table width="782" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td><img src="../odimages/odmain/page_icon.gif" width="14" height="11"> 
																	<font color="3960AC">전체 <b><?=$total?></b>건 </td>
																<td align="right">
																	<a onclick="saveExcel('od_accountExcel.php?bank=<?=rawurlencode("법인카드");?>&<?=ereg("\?",$_SERVER['REQUEST_URI']) ? end(explode("?",$_SERVER['REQUEST_URI'])) : NULL;?>');" style='cursor:hand;' onfocus='this.blur();'><img src="../odimages/odmain/btn_excel.gif" width="77" height="24" border="0"></a></td>
															</tr>
														</table>
														<table width="782" border="0" cellspacing="1" cellpadding="0" bgcolor="c0bebe">
															<tr align="center"> 
																<td width="80"  height=30 bgcolor="ececec" class="white">날짜</td>
																<td bgcolor="ececec" class="white">내용</td>
																<td width="150" bgcolor="ececec" class="white">계정과목</td>
																<td width="70" bgcolor="ececec" class="white">입금금액</td>
																<td width="70" bgcolor="ececec" class="white">출금금액</td>
																<td width="80" bgcolor="ececec" class="white">잔액</td>
																<td width="80" bgcolor="ececec" class="white">계좌</td>
															</tr>
<?
if(!$total) {
	echo	"<tr><td colspan=10 align=center height=30 bgcolor=ffffff>검색결과가 없습니다.</td></tr>";
}

# 조회기간 이전의 잔액을 추출
$resPrice = mysql_result(mysql_query("select sum(price) from odtAccount where date < '".$sDate."' and bank='법인카드' order by date asc"),0);

while($row= mysql_fetch_array($res)) {
	$resPrice		+= $row['price'];
	$plusPrice	+= $row['price'] > 0 ? $row['price'] : 0;
	$minusPrice += $row['price'] < 0 ? $row['price'] : 0;

?>
															<tr> 
																<td align='center' bgcolor='FAFAFA' class='cate' height=35><?=$row['date']?></td>
																<td align='center' bgcolor='FAFAFA' class='cate'><?=$row['memo']?></td>
																<td align='center' bgcolor='FAFAFA' class='cate'><?=$row['title']?></td>
																<td align='right' style='padding:4px' bgcolor='FAFAFA'><?=$row['price'] > 0 ? number_format($row['price']) : 0;?></td>
																<td align='right' style='padding:4px' bgcolor='FAFAFA'><?=$row['price'] < 0 ? number_format($row['price']) : 0;?></td>
																<td align='right' style='padding:4px' bgcolor='FAFAFA'><?=!$where_ ? number_format($resPrice) : "-";?></td>
																<td align='center' bgcolor='FAFAFA'><?=$bankArray[$row['bank']]?></td>
															</tr>
<?
}
?>
															<tr> 
																<td align='center' bgcolor='FAFAFA' class='cate' height=35><font color=red><b>합 계</b></font></td>
																<td align='center' bgcolor='FAFAFA' class='cate'><font color=red>-</font></td>
																<td align='center' bgcolor='FAFAFA' class='cate'><font color=red>-</font></td>
																<td align='right' style='padding:4px' bgcolor='FAFAFA'><font color=red><?=number_format($plusPrice)?></font></td>
																<td align='right' style='padding:4px' bgcolor='FAFAFA'><font color=red><?=number_format($minusPrice)?></font></td>
																<td align='right' style='padding:4px' bgcolor='FAFAFA'><font color=red><?=!$where_ ? number_format($resPrice) : "-";?></font></td>
																<td align='center' bgcolor='FAFAFA'><font color=red>-</font></td>
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