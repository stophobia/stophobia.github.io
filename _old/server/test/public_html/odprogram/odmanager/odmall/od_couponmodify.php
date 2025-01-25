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
		$row = mysql_fetch_array(mysql_query("SELECT number, kinds, couponuse, name, comment, term, duedate, couponprice, application FROM odtCoupon WHERE serialnum='$serialnum'"));
?>
		<script language="javascript">
			function valueCheck(form) {
				var form = document.snsForm;
				var count = 0;
				for(i=0;i<2;i++) {
					if(document.snsForm.kinds[i].checked == true) {
						count += 1;
					}
				}
				if(count == 0)  {
					alert("쿠폰 종류를 선택하셔야 합니다.   ");
					form.kinds[0].focus();
					return false;
				}
				for(i=0;i<2;i++) {
					if(document.snsForm.application[i].checked == true) {
						count += 1;
					}
				}
				if(count == 0)  {
					alert("쿠폰 적용방식을 선택하셔야 합니다.   ");
					form.application[0].focus();
					return false;
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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 상점 기본관리 &gt; <span class="st">쿠폰 정보수정</span></font></td>
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
													<td height="18"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5"><b>쿠폰</b> 정보를 수정합니다.</font></td>
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
															<!-- form start --------------------------------------------->
															<form name="snsForm" method="post" action="od_couponmodify.php" enctype="multipart/form-data" onSubmit="return valueCheck(this)">
																<input type="hidden" name="form" value="setupForm">
																<input type="hidden" name="serialnum" value="<?=$serialnum?>">
																<input type="hidden" name="number" value="<?=$row[number]?>">
																<input type="hidden" name="page" value="<?=$page?>">
																<input type="hidden" name="search" value="<?=$search?>">
																<input type="hidden" name="key" value="<?=$key?>">
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">쿠폰 번호</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;" height="35"> 
																	&nbsp;<font size="3"><b><?=$row[number]?></b></font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF" colspan="2"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">쿠폰 종류</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
																	<input type="radio" name="kinds" value="membersign"<?if($row[kinds]=="membersign")echo" checked";?>>신규회원가입 축하쿠폰
																	<!--<input type="radio" name="kinds" value="congratulation"<?if($row[kinds]=="congratulation")echo" checked";?>>기념일(생일) 축하쿠폰-->
																	<input type="radio" name="kinds" value="product"<?if($row[kinds]=="product")echo" checked";?>>상품에 적용되는 쿠폰<br>
																	<img src="" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 신규회원가입 축하쿠폰 : 신규로 회원 가입을 할 경우에 제공되는 쿠폰입니다.<br>
																	&nbsp;* 기념일(생일) 축하쿠폰 : 회원의 생일에 자동으로 제공되는 쿠폰 입니다.<br>
																	&nbsp;* 상품에 적용되는 쿠폰 : 상품 등록시 쿠폰 제공여부를 선택하며 해당상품을 구매시 제공되는 쿠폰입니다.</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF" colspan="2"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">쿠폰 사용여부</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
																	<input type="radio" name="couponuse" value="yes"<?if($row[couponuse]=="yes")echo" checked";?>>사용합니다.&nbsp;&nbsp;&nbsp;
																	<input type="radio" name="couponuse" value="no"<?if($row[couponuse]=="no")echo" checked";?>>사용하지 않습니다.<br>
																	<img src="" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 쿠폰을 사용하실지에 대한 사용여부를 설정 합니다.</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF" colspan="2"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">쿠폰 이름</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="name" class="border" size="31" value="<?=stripslashes($row[name])?>"><br>
																	<img src="" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 쿠폰의 이름을 입력 합니다.</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF" colspan="2"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">쿠폰 설명</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="comment" class="border" size="95" value="<?=stripslashes($row[comment])?>"><br>
																	<img src="" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 쿠폰의 간략한 설명을 입력 합니다.</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF" colspan="2"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">유효기간 설정</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;쿠폰 제공일로부터 <input name="term" type="text" class="border" size="10" value="<?=$row[term]?>"> 일간 또는 
																	<input type="checkbox" name="duedate" value="yes"<?if($row[duedate]=="yes")echo" checked";?>> 유효기간 없음<br>
																	<img src="" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 유효기간이 없는 쿠폰일 경우에는 "유효기간 없음"을 선택하시기 바랍니다.</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF" colspan="2"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">쿠폰 금액</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="couponprice" class="border" size="20" value="<?=$row[couponprice]?>"> 원<br>
																	<img src="" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 여기에 지정하신 금액만큼 회원의 포인트로 누적 합산 처리 됩니다.</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF" colspan="2"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">쿠폰 적용방식</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
																	<input type="radio" name="application" value="direct"<?if($row[application]=="direct")echo" checked";?>>쿠폰제공과 동시에 곧바로 포인트로 누적시킨다.<br>
																	<input type="radio" name="application" value="conversion"<?if($row[application]=="conversion")echo" checked";?>>회원이 제공받은 쿠폰을 포인트로 전환할 수 있도록 한다.<br>
																	<img src="" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 해당 쿠폰의 적용방식을 설정 합니다.</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF" colspan="2"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">쿠폰 이미지</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<img src="<?=$folderpath_upload?>/coupons/<?=$row[number]?>.jpg"><br>
																	<img src="blank.gif" height="3" width="1"><br>
																	&nbsp;<input type="file" name="couponimg" class="border" size="75"><br>
																	<img src="" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 쿠폰 이미지를 첨부 합니다.</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="10" bgcolor="FFFFFF"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="1" cellpadding="0">
															<tr> 
																<td align="center">
																	<?=$modifyTemp1?>
																	<a onclick="reset();" onfocus='this.blur();' style='cursor:hand;'><img src="../odimages/odmain/btn_cancel.gif" width="77" height="24" hspace="3" border="0"></a>
																	<a href="od_coupon.php?page=<?=$page?>&search=<?=$search?>&key=<?=$key?>" onfocus='this.blur();'><img src="../odimages/btn_list.gif" hspace="3" border="0"></a></td>
															</tr>
															</form>
															<!-- form end -->
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
	else if(!strcmp($form,"setupForm")) {
		$name = addslashes(trim($name));
		$comment = addslashes(trim($comment));
		
		if($duedate == "yes") $term = 0;
		else $duedate = "no";

		$modifydate = time();
		
		$result = mysql_query("UPDATE odtCoupon SET kinds='$kinds',couponuse='$couponuse',name='$name',comment='$comment',term='$term',duedate='$duedate',couponprice='$couponprice',application='$application',offernumber='$offernumber',modifydate='$modifydate' WHERE serialnum='$serialnum'");
		
		if($result) {
			//$row = mysql_fetch_array(mysql_query("SELECT * FROM odtCoupon ORDER BY serialnum DESC LIMIT 1"));
			
			$img_upload_path = $folderpath_upload_root."/coupons";
			
			## coupon img ###############################################################
			if(!$couponimg) $couponimg = "none";
			if($couponimg != "none") {
				move_uploaded_file($couponimg,"$img_upload_path/$couponimg_name");
				rename("$img_upload_path/$couponimg_name","$img_upload_path/$number.jpg");
			}
			
			echo "
				<script>
					window.alert('수정이 잘 되었습니다.   ');
				</script>";

			echo "<meta http-equiv='Refresh' content='0; URL=od_coupon.php?page=$page&search=$search&key=$key'>";
			exit;
		}
		else {
			echo "
				<script>
					window.alert('수정되지 않았습니다...   ');
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