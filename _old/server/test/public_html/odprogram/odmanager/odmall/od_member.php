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
		$row = mysql_fetch_array(mysql_query("SELECT mclass, providepoint, recompoint, mcouponnumber, mclass, classname1, classration1, classround1, classname2, classration2, classround2, noneid FROM odtSetup WHERE serialnum='1'"));

		$crow = mysql_fetch_array(mysql_query("SELECT agreeinfo FROM odtCompany WHERE serialnum='1'"));
		
		if($row[mclass] == "Y") $divDisplay = "";
		else $divDisplay = "none";
?>

		<script language="javascript">
			function valueCheck(form) {
				var form = document.snsForm;
				if(!form.agreeinfo.value) {
					alert("회원가입약관을 입력해 주세요.   ");
					form.agreeinfo.focus();
					return false;
				}
			}
			function reSize(formname,size) {
				if(size == 'reset') {
					formname.rows = 10;
				}else{
					var value = formname.rows+size;
					if(value>0) formname.rows = value
					else return;
				}
			}
		</script>

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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 상점 기본관리 &gt; <span class="st"><?=$row_company[name]?> 회원 기본설정</span></font></td>
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
													<td width="760" valign="top">
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<!-- form start ---->
															<form name="snsForm" method="post" action="<?=$php_self?>" onSubmit="return valueCheck(this)">
																<input type="hidden" name="form" value="modifyForm">
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td width="150" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">회원가입시 지급 포인트</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="providepoint" class="border" size="10" value="<?=$row[providepoint]?>" style='text-align:right;'> 원<br>
																	<img src="blank.gif" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 신규회원 가입시 지급되는 포인트를 설정 합니다.</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF" colspan='2'></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">추천회원 지급 포인트</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="recompoint" class="border" size="10" value="<?=$row[recompoint]?>" style='text-align:right;'> 원<br>
																	<img src="blank.gif" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 추천받은 회원에게 지급되는 포인트를 설정 합니다.</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF" colspan='2'></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<!-- 쿠폰 사용여부 지정 시작 -->
<?
	$rows = mysql_num_rows(mysql_query("SELECT serialnum FROM odtCoupon WHERE kinds='membersign' ORDER BY serialnum DESC"));

	if($rows) {
?>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">쿠폰 선택</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;
																	<select name="mcouponnumber">
																	<option value=''>- 사용하실 쿠폰을 선택해 주세요. -</option>
<?
		$cpresult = mysql_query("SELECT name, number, couponprice FROM odtCoupon WHERE kinds='membersign' ORDER BY serialnum DESC");
		
		while($cprow = mysql_fetch_array($cpresult)) {
			$couponpriceTemp = number_format($cprow[couponprice])."원";
			
			if($row[mcouponnumber] == $cprow[number]) $selectedTemp = "selected";
			else $selectedTemp = "";

			echo "<option value='$cprow[number]' $selectedTemp>$cprow[name] ($couponpriceTemp)</option>";
		}
?>
																	</select><br>
																	<img src="blank.gif" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 사용하실 쿠폰을 선택해 주세요. (사용하지 않으실 경우에는 선택하지 않으시면 됩니다.)</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF" colspan='2'></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
<? 
	} 
?>
															<!-- 쿠폰 사용여부 지정 종료 -->
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">회원등급 사용여부</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	<input type="radio" name="mclass" value="Y" <?if($row[mclass] == "Y") echo" checked";?> onClick="document.all.memberClass.style.display='';">사용함&nbsp;&nbsp;&nbsp;
																	<input type="radio" name="mclass" value="N" <?if($row[mclass] == "N") echo" checked";?> onClick="document.all.memberClass.style.display='none';">사용하지 않음<br>
																	<img src="blank.gif" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* "사용함" 선택시 구매금액 및 포인트에 등급별 할인이 적용 됩니다.</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF" colspan='2'></td>
															</tr>
														</table>
														<!-- div start --->
														<div id="memberClass" style="display:<?=$divDisplay?>">
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td width="150" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">등급별 할인율 설정</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="classname1" class="border" size="10" value="<?=$row[classname1]?>"> : 
																	<input type="text" name="classration1" class="border" size="10" value="<?=$row[classration1]?>" style='text-align:right;'> %
																	<input type="radio" name="classround1" value="1" <?if($row[classround1]==1)echo" checked";?>>십원 단위
																	<input type="radio" name="classround1" value="2" <?if($row[classround1]==2)echo" checked";?>>백원단위
																	<input type="radio" name="classround1" value="3" <?if($row[classround1]==3)echo" checked";?>>천원단위
																	<input type="radio" name="classround1" value="4" <?if($row[classround1]==4)echo" checked";?>>만원단위에서 반올림<br>
																	<img src="blank.gif" width="1" height="3"><br>
																	&nbsp;<input type="text" name="classname2" class="border" size="10" value="<?=$row[classname2]?>"> : 
																	<input type="text" name="classration2" class="border" size="10" value="<?=$row[classration2]?>" style='text-align:right;'> %
																	<input type="radio" name="classround2" value="1" <?if($row[classround2]==1)echo" checked";?>>십원 단위
																	<input type="radio" name="classround2" value="2" <?if($row[classround2]==2)echo" checked";?>>백원단위
																	<input type="radio" name="classround2" value="3" <?if($row[classround2]==3)echo" checked";?>>천원단위
																	<input type="radio" name="classround2" value="4" <?if($row[classround2]==4)echo" checked";?>>만원단위에서 반올림<br>
																	<img src="blank.gif" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 지정하신 할인율 만큼 구매금액 및 포인트가 할인 적용 됩니다.</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF" colspan='2'></td>
															</tr>
														</table>
														</div>
														<!-- div end --->
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td width="150" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">사용불가 아이디 설정</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="noneid" class="border" size="90" value="<?=$row[noneid]?>"><br>
																	<img src="blank.gif" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 사용을 제한하실 아이디를 /로 구분하여 설정합니다.</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF" colspan='2'></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">회원가입약관</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	<table width="99%" border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td>&nbsp;</td>
																			<td align="right">
																				<a href="javascript:reSize(document.snsForm.agreeinfo,5)" onfocus='this.blur();'><img src="../odimages/button_plus.gif" border="0" align="absmiddle"></a>
																				<a href="javascript:reSize(document.snsForm.agreeinfo,'reset')" onfocus='this.blur();'><img src="../odimages/button_reset.gif" border="0" align="absmiddle"></a>
																				<a href="javascript:reSize(document.snsForm.agreeinfo,-5)" onfocus='this.blur();'><img src="../odimages/button_minus.gif" border="0" align="absmiddle"></a>
																			</td>
																		</tr>
																		<tr>
																			<td colspan="2" height="3"></td>
																		</tr>
																		<tr>
																			<td colspan="2">
																				&nbsp;<textarea name="agreeinfo" class="border" rows="10" cols="93"><?=stripslashes($crow[agreeinfo])?></textarea><br>
																				<img src="blank.gif" width="1" height="2"><br><font color="313D7D">
																				&nbsp;* 회원가입 절차에 사용하실 회원가입약관을 기입 합니다.</font></td>
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
																<td height="7" bgcolor="FFFFFF" colspan='2'></td>
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
		$ddescription = addslashes(trim($ddescription));
		$rdescription = addslashes(trim($rdescription));
		
		if(!$agreetag) $agreetag = "T";
		
		$agreeinfo = addslashes(trim($agreeinfo));
		$modifydate = time();
		
		$result = mysql_query("UPDATE odtSetup SET providepoint='$providepoint',recompoint='$recompoint',mcouponnumber='$mcouponnumber',noneid='$noneid',mclass='$mclass',classname1='$classname1',classration1='$classration1',classround1='$classround1',classname2='$classname2',classration2='$classration2',classround2='$classround2',modifydate='$modifydate' WHERE serialnum='1'");
		
		$cresult = mysql_query("UPDATE odtCompany SET agreetag='$agreetag',agreeinfo='$agreeinfo',modifydate='$modifydate' WHERE serialnum='1'");
		
		if($result AND $cresult) {
			echo "
				<script>
					window.alert('수정이 잘 되었습니다.   ');
				</script>";

			echo "<meta http-equiv='Refresh' content='0; URL=od_member.php'>";
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