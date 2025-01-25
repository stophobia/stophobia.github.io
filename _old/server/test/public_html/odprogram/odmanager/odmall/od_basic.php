<?
	include "../../odcommon/od_config.inc.php";
	include "../odcommon/od_function.inc.php";	
	include "../odcommon/od_adminAuthority.inc.php";
	include "../odcommon/od_head.inc.php";
	include "../odcommon/od_body.inc.php";

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
		
		$row = mysql_fetch_array(mysql_query("SELECT * FROM odtSetup WHERE serialnum='1'"));
		

		$licenseTmp = end(explode("-",$row[licenseNumber]));
		$licenseTmp = substr($licenseTmp,0,1);

		switch($licenseTmp) {
			case "1" :
				$onedaynet_solution_type = "기본형";
				break;
			case "2" :
				$onedaynet_solution_type = "고급형";
				break;
			case "3" :
				$onedaynet_solution_type = "프리미엄형";
				break;
			case "4" :
				$onedaynet_solution_type = "플러스";
				break;
			case "5" :
				$onedaynet_solution_type = "임대몰";
				break;
			case "6" :
				$onedaynet_solution_type = "분양몰";
				break;
			case "7" :
				$onedaynet_solution_type = "티켓몰";
				break;
			case "8" :
				$onedaynet_solution_type = "티켓몰플러스";
				break;
		}
		
		$ssizeTemp = explode("-",$row[sSize]);
		$msizeTemp = explode("-",$row[mSize]);
		$bsizeTemp = explode("-",$row[bSize]);
		$ssizegTemp = explode("-",$row[sSizeg]);
		$msizegTemp = explode("-",$row[mSizeg]);
		$bsizegTemp = explode("-",$row[bSizeg]);
?>
		<script language="javascript">
			function valueCheck(form) {
				var form = document.snsForm;
				if(!form.proNum.value) {
					alert("한페이지당 상품 노출수를 설정해 주세요.   ");
					form.proNum.focus();
					return false;
				}
			}
			function view(what) {
				var imgwin = window.open("",'WIN','scrollbars=no,status=no,toolbar=no,resizable=1,location=no,menu=no,width=1,height=1');
				imgwin.focus();
				imgwin.document.open();
				imgwin.document.write("<html>\n");
				imgwin.document.write("<head>\n");
				imgwin.document.write("<title>Image for guide</title>\n");
				imgwin.document.write("<sc"+"ript>\n");
				imgwin.document.write("function resize() {\n");
				imgwin.document.write("pic = document.il;\n");
				imgwin.document.write("if(eval(pic).height) { var name = navigator.appName\n");
				imgwin.document.write("  if(name == 'Microsoft Internet Explorer') { myHeight = eval(pic).height + 31; myWidth = eval(pic).width + 12;\n");
				imgwin.document.write("  }else { myHeight = eval(pic).height + 9; myWidth = eval(pic).width; }\n");
				imgwin.document.write("  clearTimeout();\n");
				imgwin.document.write("  var height = screen.height;\n");
				imgwin.document.write("  var width = screen.width;\n");
				imgwin.document.write("  self.resizeTo(myWidth, myHeight);\n");
				imgwin.document.write("}else setTimeOut(resize(), 100);}\n");
				imgwin.document.write("</sc"+"ript>\n");
				imgwin.document.write("</head>\n");
				imgwin.document.write("<META HTTP-EQUIV=imagetoolbar CONTENT=no>\n");
				imgwin.document.write('<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" bgcolor="#FFFFFF">\n');
				imgwin.document.write('<table border="0" cellspacing="0" cellpadding="0" align="center">\n');
				imgwin.document.write('<tr>\n');
				imgwin.document.write("<td><a href='javascript:window.close()' onfocus='this.blur();'><img alt='클릭하시면 창이 닫힙니다.' border=0 src="+what+" xwidth=100 xheight=9 name=il onload='resize();''></a></td>\n");
				imgwin.document.write('</tr>\n');
				imgwin.document.write('</table>\n');
				imgwin.document.write("</body>");
				imgwin.document.close();
			}
		</script>

		<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
			<tr> 
				<td height="80" bgcolor="#FFFFFF">
					<!-- top menu start -->
<? include "../odcommon/od_topMenu.inc.php"; ?>
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
<? include "../odcommon/od_leftMenu.inc.php"; ?>
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
													<td height="17" bgcolor="FFFFFF" colspan="2"></td>
												</tr>
												<tr> 
													<td><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 상점 기본관리 &gt; <span class="st"><?=$row_company[name]?> 상점 기본정보</span></font></td>
													<td align="right"></td>
												</tr>
												<tr> 
													<td height="3" bgcolor="FFFFFF" colspan="2"></td>
												</tr>
												<tr> 
													<td height="2" bgcolor="D6D6D6" colspan="2"></td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="1" cellpadding="0">
												<tr>
													<td height="5"></td>
												</tr>
											</table>

											<table width="100%" border="0" cellspacing="1" cellpadding="0">
												<tr> 
													<td height="16"></td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="18" valign="bottom"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5"><b><?=$row_company[name]?></b> 상점 기본정보를 설정합니다.</font></td>
													<td height="18" align="right" class="pro">
													</td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="5"></td>
												</tr>
											</table>
											<table width="760" border="0" cellspacing="0" cellpadding="0">
												<!-- form start -------------------------------->
												<form name="snsForm" method="post" action="od_basic.php" enctype="multipart/form-data" onSubmit="return valueCheck(this)">
													<input type="hidden" name="form" value="modifyForm">
													<input type="hidden" name="pronum3" value="0">
													<input type="hidden" name="pronum4" value="0">
													<input type="hidden" name="counter_display" value="N">
												<tr> 
													<td width="760" valign="top">
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td width="176" bgcolor="ececec" class="white" style="padding:5px;">
																  <img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">원데이몰 라이선스 정보</td>
																<td width="584" bgcolor="FAFAFA" style="padding:5px;font-size:14;LETTER-SPACING:-0.03em;"> 
																  &nbsp;<b><?=$row[licenseNumber]?></b><br><img src="" width="1" height="3"><br><font color="313D7D">
																  &nbsp;* 정식사용자임을 증명하는 정보이므로 잘 관리해 주시기 바랍니다.</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="6" bgcolor="FFFFFF" colspan="2"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;">
																  <img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">원데이넷 솔루션 정보</td>
																<td bgcolor="FAFAFA" style="padding:5px;font-size:14;LETTER-SPACING:-0.03em;"> 
																  &nbsp;<b><?=$onedaynet_solution_type;?></b></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="6" bgcolor="FFFFFF" colspan="2"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;">
																  <img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">상품 판매 시작일</td>
																<td bgcolor="FAFAFA" style="padding:5px;font-size:14;LETTER-SPACING:-0.03em;"> 
																  &nbsp;<input type="text" id='ipt01' name="mallstart" class="border" size=10 value="<?=$row[mallstart]?>" style='cursor:pointer' readonly>
																	<script>var cal1 = new jsCalendar(document.getElementById('ipt01'));</script></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
<tr> 
																<td height="6" bgcolor="FFFFFF" colspan="2"></td>
															</tr>
<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;">
																  <img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">사용자 쿠폰문자발송 횟수</td>
																<td bgcolor="FAFAFA" style="padding:5px;font-size:14;LETTER-SPACING:-0.03em;"> 
																  &nbsp;<input type="text" id='smsMaxCount' name="smsMaxCount" class="border" style="text-align:center;" size=10 value="<?=$row[smsMaxCount]?>">																	</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>



															<tr> 
																<td height="6" bgcolor="FFFFFF" colspan="2"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;">
																  <img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">상품 변경시간</td>
																<td bgcolor="FAFAFA" style="padding:5px;font-size:14;LETTER-SPACING:-0.03em;"> 
																  &nbsp;<select name="changeTime">
																	<?
																		for($o=0;$o<24;$o++) {
																			$oo = $o < 10 ? "0".$o : $o;
																			echo "<option value='".$oo."' ".($oo == $row[changeTime] ? "selected" : "").">".$oo."시</option>";
																		}
																	?>
																	</select></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="6" bgcolor="FFFFFF" colspan="2"></td>
															</tr>
															
															<tr style='display:none'> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr style='display:none'> 
																<td bgcolor="ececec" class="white" style="padding:5px;">
																  <img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">메뉴활성화</td>
																<td bgcolor="FAFAFA" style="padding:5px;font-size:14;LETTER-SPACING:-0.03em;"> 
																  &nbsp;
																	<input type="checkbox" name="today" value="Y" <?=$row[today] == "Y" ? "checked" : NULL;?>> TODAY&nbsp;&nbsp;&nbsp;
																	<input type="checkbox" name="three" value="Y" <?=$row[three] == "Y" ? "checked" : NULL;?>> THREE&nbsp;&nbsp;&nbsp;
																	<input type="checkbox" name="five"  value="Y" <?=$row[five]  == "Y" ? "checked" : NULL;?>> FIVE&nbsp;&nbsp;&nbsp;
																	<input type="checkbox" name="week"  value="Y" <?=$row[week]  == "Y" ? "checked" : NULL;?>> WEEK&nbsp;&nbsp;&nbsp;
																	<input type="checkbox" name="media" value="Y" <?=$row[media] == "Y" ? "checked" : NULL;?>> MEDIA&nbsp;&nbsp;&nbsp;
																	<input type="checkbox" name="mart" value="Y"	<?=$row[mart] == "Y" ? "checked" : NULL;?>> MART

																	
																	</td>
															</tr>
															<tr style='display:none'> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr style='display:none'> 
																<td height="6" bgcolor="FFFFFF" colspan="2"></td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
											<table width="760" border="0" cellspacing="1" cellpadding="0">
												<tr> 
													<td align="center">
														<?=$modifyTemp1?>
														<a onclick="reset();" onfocus='this.blur();' style='cursor:hand;'>
														<img src="../odimages/odmain/btn_cancel.gif" width="77" height="24" hspace="3" border="0"></a></td>
													<td width="40" align="center" valign="top">&nbsp;</td>
												</tr>
												</form>
												<!-- form end -------------------------------->
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
<? include "../odcommon/od_bottom.inc.php"; ?>
					<!-- bottom end -->
				</td>
			</tr>
		</table>
	</body>
</html>
<?
	}
	else if(!strcmp($form,"modifyForm")) {

		$que = "update odtSetup set
						mallstart		= '".$_POST[mallstart]."',
						changeTime	=	'".$_POST[changeTime]."',
						today				=	'".$_POST[today]."',
						three				=	'".$_POST[three]."',
						five				=	'".$_POST[five]."',
						week				=	'".$_POST[week]."',
						media				=	'".$_POST[media]."',
						smsMaxCount				=	'".$_POST[smsMaxCount]."',
						mart				=	'".$_POST[mart]."'
						where
						serialnum		=	1";


		$result = mysql_query($que);
		
		if($result) {
			echo "
				<script>
					window.alert('설정이 잘 되었습니다.   ');
				</script>";

			echo "<meta http-equiv='Refresh' content='0; URL=od_basic.php'>";
			exit;
		}
		else {
			echo "
				<script>
					window.alert('설정되지 않았습니다.   ');
					history.go(-1);
				</script>";

			exit;
		}
	}
	else {
		echo "<meta http-equiv='Refresh' content='0; URL=$path_home'>";
		exit;
	}
?>