<?
    include "../../odcommon/od_config.inc.php";
    include "$folderpath_manager_common/od_function.inc.php";
    include "$folderpath_manager_common/od_comAuthority.inc.php";
    include "$folderpath_manager_common/od_head.inc.php";
    include "$folderpath_manager_common/od_body.inc.php";

# 등록시간이 한시간 이상 지난 건은 임시테이블에서 삭제한다.
mysql_query("delete from odtExpressTmpTable where partnerCode = '".$com[id]."' and regidate < '".date('Y-m-d H:i:s',time()-60*60*1)."'");

# 운송정보가 들어있는 테이블을 조회
$que = "select * from odtExpressTmpTable where partnerCode = '".$com[id]."'";
$res = mysql_query($que);
while($row = mysql_fetch_array($res)) {
	if(!$row[ordernum]) continue;
	$eRow[$row[ordernum]][express]		= $row[express];
	$eRow[$row[ordernum]][expressNum] = $row[expressNum];
}


## 조건에 맞는 주문목록의 수를 구한다 ###################
$que = "SELECT * FROM odtOrder WHERE ordernum != '' and partnerCode = '".$com[id]."' and paystatus='Y' and paystatus2='Y' and canceled='N' AND orderstatus='Y' and delivstatus = 'no' order by paydate desc";
$res = mysql_query($que);
$total = mysql_num_rows($res);
?>
		<script language="javascript">

			function express() {
				frm = document.OderAllDelete;
				if(!confirm('배송정보를 일괄적으로 수정하시겠습니까.?')) return false;
				orgAction = frm.action;
				orgTarget = frm.target;
				frm.action = "od_orderexpress.php";
				frm.target = "hidden_frame";
				frm.submit();
				frm.action = orgAction;
				frm.target =	orgTarget;
			}

		</script>

		<script>
		function expressSetFun(frm) {

			res = frm.expressSet.value;
			if(!res) {
				alert('택배사를 선택해주세요.');
				frm.expressSet.focus();
				return;
			}


            obj = document.getElementsByName('expressname[]');
            obj2 = document.getElementsByName('setTmp[]');

            for(i=0;i<obj.length;i++) {
                if(obj2[i].value == "") {
					obj[i].value = res;
				}
            }

		}
		</script>

		<iframe name="hidden_frame" src="about:blank" style="display:none"></iframe>

		<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
			<tr> 
				<td height="80" bgcolor="#FFFFFF">
					<!-- top menu start -->
<? include "$folderpath_manager_common/od_topMenu.inc.php"; ?>
					<!-- top menu end -->
				</td>
			</tr>
			<tr> 
				<td valign="top"   bgcolor="#FFFFFF"> 
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="6"></td>
						</tr>
					</table>
					<table height="100%" border="0" cellpadding="0" cellspacing="0">
						<tr>
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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 주문관리 &gt; <span class="st">운송장 번호 입력</span></font></td>
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
													<td height="18"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5"><b>엑셀파일을 통해 배송정보입력하는 방법</b></font><br>
													<ol>
														<li> <a href="#none" onclick="helpInfo('help00','459cff')">배송대기 리스트</a> 페이지에서 다운받은 엑셀파일에 배송정보를 입력 후 <a href="#none" onclick="helpInfo('help01','459cff')">하단 엑셀파일 입력</a>을 통해 파일을 업로드한다.</li>
														<li>  <a href="#none" onclick="helpInfo('help02','459cff')">확인 버튼</a>을 누르면 새로고침이 되면서 <a href="#none" onclick="helpInfo('help03','459cff')">운송장번호</a>가 나타나는것을 볼 수 있다.</li>
														<li> 택배사와 운송장 번호가 이상없는지 확인후 , <a href="#none" onclick="helpInfo('help04','459cff')">배송일괄처리</a>를 눌러 배송정보를 입력한다.</li>
														<li> 이때 <a href="#none" onclick="helpInfo('help05','459cff')">배송상황</a>이 발송대기에서 발송완료로 수정되며, 고객에게 문자와 메일이 발송된다.</li>
														<li> <a href="#none" onclick="helpInfo('help06','459cff')">배송완료 리스트</a> 메뉴로 이동하여 이상이 없는지 최종 확인한다.</li>
													</ol>
													</td>
												</tr>
											</table>
											<script>
											var infoCnt = 0;
											var org_color = '';
											var new_color = '';
											var target_id = '';

											function helpInfo2() {

												if(this.infoCnt % 2 == 0) {
													document.getElementById(this.target_id).style.filter		="invert";
													document.getElementById(this.target_id).style.background=this.new_color;
												} else	{
													document.getElementById(this.target_id).style.filter		="";
													document.getElementById(this.target_id).style.background=this.org_color;
												}

												if(this.infoCnt < 3) {
													this.infoCnt = this.infoCnt + 1;
													setTimeout("helpInfo2()",500);
												}
											}

											function helpInfo(id,color) {
												this.infoCnt			=	0;
												this.new_color		= color;
												this.org_color		= document.getElementById(id).style.background;
												this.target_id		= id;

												helpInfo2();
												
											}
											</script>
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

												<table width="760" border="0" cellspacing="0" cellpadding="0">
													<tr> 
														<td colspan="3" width=760><img src="../odimages/odmain/search_piece1.gif" width="760" height="8"></td>
													</tr>
													<tr> 
														<td width="6" background="../odimages/odmain/search_bg1.gif"></td>
														<td width=748 style="padding:10">
															<form name="expressFrm" action="./od_expressInsert.php" method="post" target="hidden_frame" style='display:inline' enctype="multipart/form-data" >
															<img src="../odimages/odmain/tex_icon.gif"> 
															<span id='help01'>엑셀파일 입력</span> &nbsp;
															<input type="file" name="expressCSV" size=40 class="border">
															&nbsp;
															<input type="image" src="../odimages/odmain/btn_ok.gif" width="77" height="24" border="0" onfocus='this.blur();' align=center>
															</form>
														</td>
														<td width="6" background="../odimages/odmain/search_bg2.gif"></td>
													</tr>
													<tr> 
														<td colspan="3"><img src="../odimages/odmain/search_piece2.gif" width="760" height="8"></td>
													</tr>
												</table>
											<table width="760" border="0" cellspacing="1" cellpadding="0">
												<tr>
													<td>&nbsp;</td>
												</tr>
											</table>
											<table width="760" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td valign="top">
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<!-- all delete form start -->
															<form name="OderAllDelete" method="post" action="od_orderexpress.php">
																<input type="hidden" name="PageL" value="All">
																<input type="hidden" name="page" value="<?=$page?>">
																<input type="hidden" name="par_page" value="<?=$par_page?>">
															<tr>
																<td>
																	<img src="../odimages/odmain/page_icon.gif" width="14" height="11"> 
																	<font color="3960AC">전체 <b><?=$TotalPage?></b>페이지 [<b><?=$total?></b>]개</font>
																</td>
																<td align="right">
																	<img src="../odimages/odmain/btn_express.gif" onclick="express()" style='cursor:hand;' onfocus='this.blur();' id='help04'> 
																</td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="1" colspan="12" bgcolor="c0bebe"></td>
															</tr>
															<tr align="center"> 
																<td width="40" height="27" bgcolor="ececec" class="white">번호</td>
																<td width="30" bgcolor="ececec" class="white"><a onclick="selectAll();" onfocus='this.blur();' style='cursor:hand;'>전체</a></td>
																<td width="120" bgcolor="ececec" class="white">주문번호</td>
																<td bgcolor="ececec" class="white">상품명</td>
																<td width="30" bgcolor="ececec" class="white">수량</td>
																<td width="80" bgcolor="ececec" class="white">수령인</td>
																<td width="80" bgcolor="ececec" class="white"><span id='help05'>배송상황</span></td>
																<td width="100" bgcolor="ececec" class="white">
																	<select name="expressSet">
																		<option value=''>택배사 일괄선택</option>
<?
	for($k=0;$k<count($array_delivery);$k++) {
		echo "<option value='".$array_delivery[$k]."' >".$array_delivery[$k]."</option>";
	}
?>
																	</select><br>
																	<input type="button" value="▼일괄적용" onclick="expressSetFun(this.form)">
																</td>
																<td width="100" bgcolor="ececec" class="white"><span  id='help03'>운송장번호</span></td>
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
	
		


	$idx = $total;
	while($row = mysql_fetch_array($res)) {


		# 상품 공급가 계산
		unset($_payPrice_,$productList,$countList);
		$oLogArray3 = explode("^",preg_replace("[^\^]","",$row[oLog]));
		$pLogArray3 = explode("^",$row[pLog]);
		for($z=0;$z<count($pLogArray3);$z++) {
			$pLogArray4 = explode("|",$pLogArray3[$z]);
			if($pLogArray4[0]) {
				$purPrice4 = mysql_fetch_array(mysql_query("select name,purPrice from odtProduct where code ='".$pLogArray4[0]."'"));
				$_payPrice_ += $purPrice4[purPrice] * $pLogArray4[1];
				$productList	.= $productList ? "<br>".$purPrice4[name] : $purPrice4[name];
				$countList		.= $countList ? "<br>".$pLogArray4[1] : $pLogArray4[1];

				if($row[orderdate] < "2009-06-12") {		// 복수구매 기능 이전	

					# 옵션값 추출
					if(strstr($row[oLog],$pLogArray4[0])) {	// 해당상품에 대한 옵션내역이 있으면
						$oLogArray = explode("^",$row[oLog]);
						for($kk=0;$kk<count($oLogArray);$kk++) {
							if(strstr($oLogArray[$kk],$pLogArray4[0])) {
								$oLogTmp = explode("|",$oLogArray[$kk]);
								$productList .= " (옵션:".$oLogTmp[1].")";
							}
						}	
					}		
				
				} else {		// 복수구매 기능 이후

					# 옵션값 추출
					if($oLogArray3[$z]) {	// 해당상품에 대한 옵션내역이 있으면
						$oLogTmp = explode("|",$oLogArray3[$z]);
						$productList .= " (옵션:".$oLogTmp[1].")";
					}		

				}


			}
		}

		if($row[delivstatus] == "yes") {
			$_delivstatus_ = "<font color='red'><b>발송완료</b></font>";
		}
		else {
			$_delivstatus_ = "발송대기";
		}

		$expressname	= $row[expressname] ? $row[expressname] : $eRow[$row[ordernum]][express];
		$expressnum		= $row[expressnum] ? $row[expressnum] : $eRow[$row[ordernum]][expressNum];

		unset($expressSelect);
		for($k=0;$k<count($array_delivery);$k++) {
			$expressSelect .= "<option value='".$array_delivery[$k]."' ".($expressname == $array_delivery[$k] ? "selected" : NULL).">".$array_delivery[$k]."</option>";
		}
	


		echo "
															<tr> 
																<td width='40' height=30 align='center' bgcolor='FAFAFA'>".$idx--."</td>
																<td width='30' align='center' bgcolor='FAFAFA'><input type='checkbox' name='OrderNum[]' value='".$row[ordernum]."' checked></td>
																<td width='120' align='center' bgcolor='FAFAFA' class='cate'>".$row[ordernum]."</td>
																<td  bgcolor='FAFAFA' class='cate'>".$productList."</td>
																<td width='30' align='center' bgcolor='FAFAFA' class='cate'>".$countList."</td>
																<td width='80' align='center' bgcolor='FAFAFA' style='padding-top:3;'>".$row[recname]."</td>
																<td width='80' align='center' bgcolor='FAFAFA'><font color='#138CE5'>".$_delivstatus_."</font></td>
																<td width='100' align='center' bgcolor='FAFAFA'>
																	<input type='hidden' name='OrderNumValue[]' value='".$row[ordernum]."'>
																	<input type='hidden' name='setTmp[]' value='".trim($row[expressnum])."'>
																	<select name=expressname[] class=border>
																		<option value=''>택배사 선택</option>
																	$expressSelect
																	</select>
																</td>
																<td width='100' align='center' bgcolor='FAFAFA'><input type=text name=expressnum[] class=border size=12 value='".$expressnum."'></td>
															</tr>
															<tr> 
																<td height='1' colspan='12' bgcolor='D2D2D2'></td>
															</tr>";
															
	}
?>
															</form>
															<!-- all delete form end -->
														</table>
														<table width="760" border="0" cellspacing="1" cellpadding="0">
															<tr> 
																<td height="4"></td>
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
		<!-- 달력 히든 프레임 시작 -->
		<iframe name="calframe" width=0 height=0 src="od_cal_frame.php"></iframe>
		<!-- 달력 히든 프레임 끝 -->
	</body>
</html>