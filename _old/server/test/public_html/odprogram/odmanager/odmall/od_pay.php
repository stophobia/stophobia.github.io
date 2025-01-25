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
	
	## 세부권한 체크(수정)
	if($row_admin[basicLevel]==5 || $row_admin[superLevel]==9) {
		$modifyTemp1 = "<input type='image' src='../odimages/odmain/btn_ok.gif' width='77' height='24' hspace='3' style='cursor:hand;' onfocus='this.blur();'>";
		$bankregTemp1 = "<input type='image' src='../odimages/btn_reg.gif' align='absmiddle' onfocus='this.blur();'>";
	}
	else {
		$modifyTemp1 = "<a href='javascript:reject();' onfocus='this.blur();'><img src='../odimages/odmain/btn_ok.gif' width='77' height='24' hspace='3' border='0'></a>";
		$bankregTemp1 = "<a href='javascript:reject();' onfocus='this.blur();'><img src='../odimages/btn_reg.gif' align='absmiddle' border='0'></a>";
	}
	
	if(!$form) {
		$row = mysql_fetch_array(mysql_query("SELECT pg, storeid, authkey, carduse, escrowuse, cashratio, ptag, pdescription FROM odtSetup WHERE serialnum='1'"));
//		echo mysql_error()."<br>";
?>
		<script language="javascript">
			function reSize(formname,size) {
				if(size == 'reset') {
					formname.rows = 5;
				}else{
					var value = formname.rows+size;
					if(value>0) formname.rows = value
					else return;
				}
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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 상점 기본관리 &gt; <span class="st"><?=$row_company[name]?> 결제정보 관리</span></font></td>
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
											<table width="100%" border="0" cellspacing="0" cellpadding="0" <?=$isHide == true ? "style=display:none" : NULL;?>>
												<tr> 
													<td height="18"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5"><b>결제정보</b>를 설정합니다.</font></td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="0" cellpadding="0" <?=$isHide == true ? "style=display:none" : NULL;?>>
												<tr> 
													<td height="3"></td>
												</tr>
											</table>
											<table width="760" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td width="760" valign="top">
														<table width="760" border="0" cellspacing="0" cellpadding="0" <?=$isHide == true ? "style=display:none" : NULL;?>>
															<!-- form start ------------------------------------------------->
															<form name="snsForm" method="post" action="<?=$php_self?>">
																<input type="hidden" name="form" value="modifyForm">
																<input type="hidden" name="mode" value="infoForm">
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">PG사 설정</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
																	<input type="radio" name="pg" value="KSNET" <?if($row[pg]=="KSNET") echo" checked";?>>㈜케이에스넷
																	<!--<input type="radio" name="pg" value="INICIS" <?if($row[pg]=="INICIS") echo" checked";?>>㈜이니시스-->
																	<input type="radio" name="pg" value="KCP" <?if($row[pg]=="KCP") echo" checked";?>>KCP<br>
																	<!--<input type="radio" name="pg" value="PAYGATE" <?if($row[pg]=="PAYGATE") echo" checked";?>>㈜페이게이트-->
																	<img src="" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 고객님께서 계약하신 PG사를 설정합니다. (PG사 문의: <b>02-706-9084</b>)</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="15" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">상점아이디 설정</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input name="storeid" type="text" class="border" size="20" value="<?=$row[storeid]?>"><br>
																	<img src="" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 전자지불대행업체(PG사)로 부터 발급 받은 상정아이디를 입력 합니다.</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="15" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">인증키 (접근키)</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input name="authkey" type="text" class="border" size="55" value="<?=$row[authkey]?>"><br>
																	<img src="" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 전자지불대행업체(PG사)로 부터 발급 받은 인증키 또는 접근키 값을 입력해 주세요.<br>
																	&nbsp;* 전자지불대행업체(PG사)로 부터 발급 받지 않은 경우에는 입력하지 않으셔도 됩니다.</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="15" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">신용카드결제 사용여부</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
																	<input type="radio" name="carduse" value="Y" <?if($row[carduse] == "Y") echo" checked";?>>사용합니다.&nbsp;&nbsp;&nbsp;
																	<input type="radio" name="carduse" value="N" <?if($row[carduse] == "N") echo" checked";?>>사용하지 않습니다.<br>
																	<img src="" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 신용카드 결제방식 사용여부를 설정 합니다.</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="15" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">에스크로(가상계좌)<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;사용여부</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
																	<input type="radio" name="escrowuse" value="Y" <?if($row[escrowuse] == "Y") echo" checked";?>>사용합니다.&nbsp;&nbsp;&nbsp;
																	<input type="radio" name="escrowuse" value="N" <?if($row[escrowuse] == "N") echo" checked";?>>사용하지 않습니다.<br>
																	<img src="" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 에스크로(가상계좌) 결제방식(결제금액 10만원 이상) 사용여부를 설정 합니다.
																	</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="15" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">현금결제시 할인율</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
																	<input name="cashratio" type="text" class="border" size="20" value="<?=$row[cashratio]?>"> %<br>
																	<img src="blank.gif" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 현금결제시 구매금액에 대한 할인율을 설정 합니다.</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="15" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td width="165" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">결제정보 관리</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	<table width="99%" border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td>
																				<input type="radio" name="ptag" value="H" <?if($row[ptag]=="H") echo"checked";?>> html 작성 
																				<input type="radio" name="ptag" value="T" <?if($row[ptag]=="T"||!$row[ptag]) echo"checked";?>> text 작성</td>
																			<td align="right">
																				<a href="javascript:reSize(document.snsForm.pdescription,5)" onfocus='this.blur();'><img src="../odimages/button_plus.gif" border="0" align="absmiddle"></a>
																				<a href="javascript:reSize(document.snsForm.pdescription,'reset')" onfocus='this.blur();'><img src="../odimages/button_reset.gif" border="0" align="absmiddle"></a>
																				<a href="javascript:reSize(document.snsForm.pdescription,-5)" onfocus='this.blur();'><img src="../odimages/button_minus.gif" border="0" align="absmiddle"></a>
																			</td>
																		</tr>
																		<tr>
																			<td colspan="2" height="3"></td>
																		</tr>
																		<tr>
																			<td colspan="2">
																				&nbsp;<textarea name="pdescription" class="border" rows="5" cols="95"><?=stripslashes($row[pdescription])?></textarea><br>
																				<img src="" width="1" height="2"><br><font color="313D7D">
																				&nbsp;* 상품 상세페이지 등의 배송정보를 디스플레이 하는 페이지에 사용 합니다.</font></td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="10" bgcolor="FFFFFF"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="1" cellpadding="0" <?=$isHide == true ? "style=display:none" : NULL;?>>
															<tr> 
																<td align="center">
																	<?=$modifyTemp1?>
																	<a onclick="reset();" onfocus='this.blur();' style='cursor:hand;'><img src="../odimages/odmain/btn_cancel.gif" width="77" height="24" hspace="3" border="0"></a></td>
															</tr>
															</form>
															<!-- form end -->
														</table>
														<table width="100%" border="0" cellspacing="0" cellpadding="0" <?=$isHide == true ? "style=display:none" : NULL;?>>
															<tr> 
																<td height="15"><a name="bank"></a></td>
															</tr>
														</table>
														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="18"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5"><b>입금계좌정보</b>를 관리합니다.</font><a name="bank"></a></td>
															</tr>
														</table>
														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="3"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="1" cellpadding="0" bgcolor="c0bebe">
															<tr> 
																<td width="125" height="27" bgcolor="ececec" class="white" align="center">은행명</td>
																<td bgcolor="ececec" class="white" align="center">계좌번호</td>
																<td width="155" bgcolor="ececec" class="white" align="center">예금주</td>
																<td width="75" bgcolor="ececec" class="white" align="center">삭제</td>
															</tr>
<?
		$qry_PBL = "SELECT serialnum, bankname, banknum, name FROM odtBank ORDER BY serialnum DESC";
		$res_PBL = mysql_query($qry_PBL);
		$num_PBL = mysql_num_rows($res_PBL);

		$total = $num_PBL;
		
		if(!$total) {
			echo "
															<tr> 
																<td height='45' bgcolor='FAFAFA' align='center' colspan='4'><b>None Bank Information</b></td>
															</tr>";
		}
		
		while($row_b = mysql_fetch_array($res_PBL)) {
			## 세부권한 체크(수정)
			if($row_admin[basicLevel]==5 || $row_admin[superLevel]==9) {
				$bankdelTemp1 = "<a href='od_bankdelete.inc.php?sn=$row_b[serialnum]' onfocus='this.blur();'><img src='../odimages/btn_delete.gif' border='0'></a>";
			}
			else {
				$bankdelTemp1 = "<a href='javascript:reject();' onfocus='this.blur();'><img src='../odimages/btn_delete.gif' border='0'></a>";
			}
?>
															<tr> 
																<td height="27" bgcolor="FAFAFA" align="center"><?=$row_b[bankname]?></td>
																<td bgcolor="FAFAFA" align="center"><?=$row_b[banknum]?></td>
																<td bgcolor="FAFAFA" align="center"><?=$row_b[name]?></td>
																<td bgcolor="FAFAFA" align="center"><?=$bankdelTemp1?></td>
															</tr>
<? 
		} 
?>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="15" bgcolor="FFFFFF"></td>
															</tr>
														</table>

		<script language="javascript">
			function valueCheck(form) {
				var form = document.regForm;
				if(!form.bankname.value) {
					alert("은행명을 입력해 주세요.   ");
					form.bankname.focus(); 
					return false;
				}
				if(!form.banknum.value) {
					alert("계좌번호를 입력해 주세요.   ");
					form.banknum.focus(); 
					return false;
				}
				if(!form.name.value) {
					alert("예금주를 입력해 주세요.   ");
					form.name.focus(); 
					return false;
				}
			}
		</script>

														<table width="760" border="0" cellspacing="1" cellpadding="0" bgcolor="c0bebe">
															<!-- bank information form start -->
															<form name="regForm" method="post" action="od_pay.php" onSubmit="return valueCheck(this)">
																<input type="hidden" name="form" value="modifyForm">
																<input type="hidden" name="mode" value="bankForm">
															<tr> 
																<td height="45" bgcolor="FAFAFA" align="center">
																	은행명 <input name="bankname" type="text" class="border" size="15">&nbsp;&nbsp;&nbsp;
																	계좌번호 <input name="banknum" type="text" class="border" size="45">&nbsp;&nbsp;&nbsp;
																	예금주 <input name="name" type="text" class="border" size="15">&nbsp;&nbsp;&nbsp;
																	<?=$bankregTemp1?></td>
															</tr>
															</form>
															<!-- bank information form end -->
														</table>
													</td>
												</tr>
												<tr> 
													<td height="15" valign="top"></td>
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
	else if(!strcmp($form,"modifyForm")) {
		if($mode == "infoForm") {
			$storeid = trim($storeid);
			$authkey = trim($authkey);
			$pdescription = addslashes(trim($pdescription));
			$modifydate = time();
			$result = mysql_query("UPDATE odtSetup SET storeid='$storeid',authkey='$authkey',carduse='$carduse',escrowuse='$escrowuse',pg='$pg',cashratio='$cashratio',ptag='$ptag',pdescription='$pdescription',modifydate='$modifydate' WHERE serialnum='1'");
		}
		else if($mode == "bankForm") {
			$bankname = addslashes(trim($bankname));
			$banknum = addslashes(trim($banknum));
			$name = addslashes(trim($name));
			$brow = mysql_fetch_row(mysql_query("SELECT MAX(serialnum) FROM odtBank"));
			$newSerialnum = $brow[0]+1;
			$inputdate = time();
			$bresult = mysql_query("INSERT INTO odtBank (serialnum,bankname,banknum,name,inputdate) VALUES ('$newSerialnum','$bankname','$banknum','$name','$inputdate')");
		}
		
		if($result || $bresult) {
			echo "<script>window.alert('처리가 잘 되었습니다.   ');</script>";
			echo "<meta http-equiv='Refresh' content='0; URL=od_pay.php'>";
			exit;
		}
		else {
			echo "<script>window.alert('처리되지 않았습니다.   ');history.go(-1);</script>";
			exit;
		}
	}
	else {
		echo "<div align='center' class='fes'><br><br><br><br><font color='red'>허용되지 않은 접근 방식입니다.</font></div>";
		exit;
	}
?>