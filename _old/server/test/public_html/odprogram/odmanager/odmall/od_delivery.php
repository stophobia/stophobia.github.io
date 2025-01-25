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
	}
	else {
		$modifyTemp1 = "<a href='javascript:reject();' onfocus='this.blur();'><img src='../odimages/odmain/btn_ok.gif' width='77' height='24' hspace='3' border='0'></a>";
	}
	
	if(!$form) {
		$row = mysql_fetch_array(mysql_query("SELECT delivuse, pdelivuse, delivCompany, delivery, indelivery, deliveryLocation1, delivery1, deliveryLocation2, delivery2, dtag, ddescription, rtag, rdescription FROM odtSetup WHERE serialnum='1'"));
?>
		<script language="javascript">
			function valueCheck(form) {
				var form = document.snsForm;
				if(!form.delivCompany.value) {
					alert("배송 업체명을 입력해 주세요.   ");
					form.delivCompany.focus();
					return false;
				}
			}
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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 상점 기본관리 &gt; <span class="st"><?=$row_company[name]?> 배송정보 관리</span></font></td>
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
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="18"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5"><b>배송정보</b>를 설정합니다.</font></td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="3"></td>
												</tr>
											</table>
											<table width="760" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td width="760" valign="top">
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<!-- form start -------------------------------------->
															<form name="snsForm" method="post" action="<?=$php_self?>" onSubmit="return valueCheck(this)">
																<input type="hidden" name="form" value="modifyForm">
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr <?=$isHide == true ? "style=display:none" : NULL;?>> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">배송료정책 사용여부</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
																	<input type="radio" name="delivuse" value="Y" <?if($row[delivuse] == "Y") echo" checked";?>>사용함&nbsp;&nbsp;&nbsp;
																	<input type="radio" name="delivuse" value="N" <?if($row[delivuse] == "N") echo" checked";?>>사용하지 않음<br>
																	<img src="" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* "사용하지 않음" 선택시 구매금액에 상관없이 배송료가 면제 됩니다.</font></td>
															</tr>
															<tr <?=$isHide == true ? "style=display:none" : NULL;?>> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr <?=$isHide == true ? "style=display:none" : NULL;?>> 
																<td height="7" bgcolor="FFFFFF"></td>
															</tr>
															<tr <?=$isHide == true ? "style=display:none" : NULL;?>> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr <?=$isHide == true ? "style=display:none" : NULL;?>> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">예약상품 배송정책</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
																	<input type="radio" name="pdelivuse" value="A" <?if($row[pdelivuse] == "A") echo" checked";?>>A.주문에 포함된 예약상품의 수만큼 배송료 청구<br>
																	<input type="radio" name="pdelivuse" value="B" <?if($row[pdelivuse] == "B") echo" checked";?>>B.주문에 포함된 예약상품의 합계금액을 기준으로 기본배송료  청책에 따라 청구<br>
																	<input type="radio" name="pdelivuse" value="C" <?if($row[pdelivuse] == "C") echo" checked";?>>C.예약상품을 별도로 계산하지 않고 일반상품의 합계금액에 합산하여 기본배송료 청책에 따라 청구</td>
															</tr>
															<tr <?=$isHide == true ? "style=display:none" : NULL;?>> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr <?=$isHide == true ? "style=display:none" : NULL;?>> 
																<td height="7" bgcolor="FFFFFF"></td>
															</tr>
															<tr <?=$isHide == true ? "style=display:none" : NULL;?>> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr <?=$isHide == true ? "style=display:none" : NULL;?>> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">배송 업체명</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="delivCompany" class="border" size="35" value="<?=$row[delivCompany]?>"><br>
																	<img src="" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 배송업체명을 설정합니다.</font></td>
															</tr>
															<tr <?=$isHide == true ? "style=display:none" : NULL;?>> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr <?=$isHide == true ? "style=display:none" : NULL;?>> 
																<td height="7" bgcolor="FFFFFF"></td>
															</tr>
															<tr <?=$isHide == true ? "style=display:none" : NULL;?>> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr <?=$isHide == true ? "style=display:none" : NULL;?>> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">기본배송료 설정</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="delivery" class="border" size="10" value="<?=$row[delivery]?>" style='text-align:right;'> 원<br>
																	<img src="" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 기본 배송료를 설정합니다.</font></td>
															</tr>
															<tr <?=$isHide == true ? "style=display:none" : NULL;?>> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr <?=$isHide == true ? "style=display:none" : NULL;?>> 
																<td height="7" bgcolor="FFFFFF"></td>
															</tr>
															<tr <?=$isHide == true ? "style=display:none" : NULL;?>> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr <?=$isHide == true ? "style=display:none" : NULL;?>> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">배송료 면제 기준금액</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="indelivery" class="border" size="10" value="<?=$row[indelivery]?>" style='text-align:right;'> 원<br>
																	<img src="" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 총 구매금액이 설정하신 금액 이상일 경우 배송료를 면제합니다.</font></td>
															</tr>
															<tr <?=$isHide == true ? "style=display:none" : NULL;?>> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr <?=$isHide == true ? "style=display:none" : NULL;?>> 
																<td height="7" bgcolor="FFFFFF"></td>
															</tr>
															<tr <?=$isHide == true ? "style=display:none" : NULL;?>> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr <?=$isHide == true ? "style=display:none" : NULL;?>> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">추가배송비 설정 #1</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="deliveryLocation1" class="border" size="97" value="<?=$row[deliveryLocation1]?>"><br>
																	<img src="" width="1" height="2"><br><font color="313D7D">
																	&nbsp;* 배송지 주소 중 위의 주소가 포함된 주문에 대해 기본 배송정채과는 별도로 추가 배송료가 청구 됩니다.<br>
																	&nbsp;* 추가 배송비 청구 지역을 <strong>/</strong> 로 구분하여 입력해 주시기 바랍니다.</font><br>
																	<img src="" width="1" height="7"><br><font color="313D7D">
																	&nbsp;<input type="text" name="delivery1" class="border" size="10" value="<?=$row[delivery1]?>" style='text-align:right;'> 원<br>
																	<img src="" width="1" height="2"><br><font color="313D7D">
																	&nbsp;* 추가되는 배송비는 배송료 면제시에도 추가되니 착오 없으시기 바랍니다.</font></td>
															</tr>
															<tr <?=$isHide == true ? "style=display:none" : NULL;?>> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr <?=$isHide == true ? "style=display:none" : NULL;?>> 
																<td height="7" bgcolor="FFFFFF"></td>
															</tr>
															<tr <?=$isHide == true ? "style=display:none" : NULL;?>> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr <?=$isHide == true ? "style=display:none" : NULL;?>> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">추가배송비 설정 #2</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="deliveryLocation2" class="border" size="97" value="<?=$row[deliveryLocation2]?>"><br>
																	<img src="" width="1" height="2"><br><font color="313D7D">
																	&nbsp;* 배송지 주소 중 위의 주소가 포함된 주문에 대해 기본 배송정채과는 별도로 추가 배송료가 청구 됩니다.<br>
																	&nbsp;* 추가 배송비 청구 지역을 <strong>/</strong> 로 구분하여 입력해 주시기 바랍니다.</font><br>
																	<img src="" width="1" height="7"><br><font color="313D7D">
																	&nbsp;<input type="text" name="delivery2" class="border" size="10" value="<?=$row[delivery2]?>" style='text-align:right;'> 원<br>
																	<img src="" width="1" height="2"><br><font color="313D7D">
																	&nbsp;* 추가되는 배송비는 배송료 면제시에도 추가되니 착오 없으시기 바랍니다.<br>
																	&nbsp;* 추가배송비를 하나로 운영하실 경우에는 값을 입력하지 마시기 바랍니다.</font></td>
															</tr>
															<tr <?=$isHide == true ? "style=display:none" : NULL;?>> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr <?=$isHide == true ? "style=display:none" : NULL;?>> 
																<td height="7" bgcolor="FFFFFF"></td>
															</tr>
															<tr <?=$isHide == true ? "style=display:none" : NULL;?>> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td width="165" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">배송정보 관리</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	<table width="99%" border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td>
																				<input type="radio" name="dtag" value="H" <?if($row[dtag]=="H") echo"checked";?>> html 작성 
																				<input type="radio" name="dtag" value="T" <?if($row[dtag]=="T"||!$row[dtag]) echo"checked";?>> text 작성</td>
																			<td align="right">
																				<a href="javascript:reSize(document.snsForm.ddescription,5)" onfocus='this.blur();'><img src="../odimages/button_plus.gif" border="0" align="absmiddle"></a>
																				<a href="javascript:reSize(document.snsForm.ddescription,'reset')" onfocus='this.blur();'><img src="../odimages/button_reset.gif" border="0" align="absmiddle"></a>
																				<a href="javascript:reSize(document.snsForm.ddescription,-5)" onfocus='this.blur();'><img src="../odimages/button_minus.gif" border="0" align="absmiddle"></a>
																			</td>
																		</tr>
																		<tr>
																			<td colspan="2" height="3"></td>
																		</tr>
																		<tr>
																			<td colspan="2">
																				&nbsp;<textarea name="ddescription" class="border" rows="5" cols="95"><?=stripslashes($row[ddescription])?></textarea><br>
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
																<td height="7" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td width="165" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">교환 및 반품정보</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	<table width="99%" border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td>
																				<input type="radio" name="rtag" value="H" <?if($row[rtag]=="H") echo"checked";?>> html 작성 
																				<input type="radio" name="rtag" value="T" <?if($row[rtag]=="T" || !$row[rtag]) echo"checked";?>> text 작성</td>
																			<td align="right">
																				<a href="javascript:reSize(document.snsForm.rdescription,5)" onfocus='this.blur();'><img src="../odimages/button_plus.gif" border="0" align="absmiddle"></a>
																				<a href="javascript:reSize(document.snsForm.rdescription,'reset')" onfocus='this.blur();'><img src="../odimages/button_reset.gif" border="0" align="absmiddle"></a>
																				<a href="javascript:reSize(document.snsForm.rdescription,-5)" onfocus='this.blur();'><img src="../odimages/button_minus.gif" border="0" align="absmiddle"></a>
																			</td>
																		</tr>
																		<tr>
																			<td colspan="2" height="3"></td>
																		</tr>
																		<tr>
																			<td colspan="2">
																				&nbsp;<textarea name="rdescription" class="border" rows="5" cols="95"><?=stripslashes($row[rdescription])?></textarea><br>
																				<img src="" width="1" height="2"><br><font color="313D7D">
																				&nbsp;* 상품 상세페이지 등의 교환/반품정보를 디스플레이 하는 페이지에 사용 합니다.</font></td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="7" bgcolor="FFFFFF"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="1" cellpadding="0">
															<tr> 
																<td align="center">
																	<?=$modifyTemp1?>
																	<a onclick="reset();" onfocus='this.blur();' style='cursor:hand;'><img src="../odimages/odmain/btn_cancel.gif" width="77" height="24" hspace="3" border="0"></a></td>
															</tr>
															</form>
														</table>
													</td>
												</tr>
												<tr> 
													<td height="7" valign="top"></td>
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
		$delivCompany = addslashes(trim($delivCompany));
		$ddescription = addslashes(trim($ddescription));
		$rdescription = addslashes(trim($rdescription));
		$modifydate = time();
		
		$result = mysql_query("UPDATE odtSetup SET delivuse='$delivuse',pdelivuse='$pdelivuse',delivCompany='$delivCompany',delivery='$delivery',indelivery='$indelivery',deliveryLocation1='$deliveryLocation1',delivery1='$delivery1',deliveryLocation2='$deliveryLocation2',delivery2='$delivery2',dtag='$dtag',ddescription='$ddescription',rtag='$rtag',rdescription='$rdescription',modifydate='$modifydate' WHERE serialnum='1'");
		
		if($result) {
			echo "
				<script>
					window.alert('수정이 잘 되었습니다.   ');
				</script>";

			echo "<meta http-equiv='Refresh' content='0; URL=od_delivery.php'>";
			exit;
		}
		else {
			echo "
				<script>
					window.alert('수정되지 않았습니다.   ');
					history.go(-1);
				</script>";

			exit;
		}
	}
	else {
		echo "<div align='center' class='fes'><br><br><br><br><font color='red'>허용되지 않은 접근 방식입니다.</font></div>";
		exit;
	}
?>