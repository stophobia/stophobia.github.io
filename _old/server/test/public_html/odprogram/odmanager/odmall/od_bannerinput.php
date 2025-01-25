<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";
	include "od_image.guide.inc.php";

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
		if(!$location || $location == "mainL1"){
			$basic_width = $mainL1_width;
			$basic_height = $mainL1_height;
		}
		else if($location == "mainL2"){
			$basic_width = $mainL2_width;
			$basic_height = $mainL2_height;
		}
		else if($location == "mainB"){
			$basic_width = $mainB_width;
			$basic_height = $mainB_height;
		}
?>

		<script language="javascript">
			function chk_size(form, width, height){
				form.size1.value = width;
				form.size2.value = height;

				id_width.innerHTML = width;
				id_height.innerHTML = height;
			}

			function go_paste(form, val){
				eval("form."+val).value = window.clipboardData.getData('Text');
			}

			function valueCheck(form) {
				var form = document.snsForm;
				var odt = form.image.value.lastIndexOf(".")-(-1);
				var odt1 = form.image.value.length;
				var extention = form.image.value.substring(sns,sns1);
				if(extention == 'swf') {
					if(!form.size1.value) {
						alert("플래시 파일의 가로 사이즈를 픽셀 단위로 입력해 주셔야 합니다.   ");
						form.size1.focus();
						return false;
					}
					if(!form.size2.value) {
						alert("플래시 파일의 세로 사이즈를 픽셀 단위로 입력해 주셔야 합니다.   ");
						form.size2.focus();
						return false;
					}
				}

				if(!form.image.value) {
					alert("이미지 또는 플래시 파일을 첨부해 주셔야 합니다.   ");
					form.image.focus();
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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 상점 기본관리 &gt; <span class="st">베너 관리</span></font></td>
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
													<td height="18"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5"><b>베너</b>를 신규로 등록합니다.</font></td>
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
															<!-- form start --------------------------------------------------->
															<form name="snsForm" method="post" action="<?=$php_self?>" enctype="multipart/form-data" onSubmit="return valueCheck(this)">
																<input type="hidden" name="form" value="modifyForm">
																<input type="hidden" name="locationTemp" value="<?=$location?>">
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">베너 표시여부 설정</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="radio" name="Icheck" value="yes" checked>표시함
																	<input type="radio" name="Icheck" value="no">표시하지 않음<br>
																	<img src="blank.gif" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 쇼핑몰 첫페이지(메인)에 베너를 표시할 것인지의 여부를 설정합니다.</font></td>
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
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td height="35" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">위치 지정</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="radio" name="location" value="mainL1" <?if(!$location || $location=="mainL1") echo "checked";?> onclick="chk_size(snsForm,<?=$mainL1_width;?>,<?=$mainL1_height;?>)">메인왼쪽 1&nbsp;<a onclick="view('<?=$_managerfolderpath_image;?>/help/mainL1.gif');" onfocus='this.blur();' style='cursor:hand;'><img src="../odimages/view.gif" border="0"></a>

																	&nbsp;<input type="radio" name="location" value="mainL2" <?if($location=="mainL2") echo "checked";?> onclick="chk_size(snsForm,<?=$mainL2_width;?>,<?=$mainL2_height;?>)">메인왼쪽 2&nbsp;<a onclick="view('<?=$_managerfolderpath_image;?>/help/mainL2.gif');" onfocus='this.blur();' style='cursor:hand;'><img src="../odimages/view.gif" border="0"></a>
																	
																	&nbsp;<input type="radio" name="location" value="mainB" <?if($location=="mainB") echo "checked";?> onclick="chk_size(snsForm,<?=$mainB_width;?>,<?=$mainB_height;?>)">메인하단배너&nbsp;<a onclick="view('<?=$_managerfolderpath_image;?>/help/mainB.gif');" onfocus='this.blur();' style='cursor:hand;'><img src="../odimages/view.gif" border="0"></a>
																</td>
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
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td width="150" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">첨부 이미지</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="file" name="image" class="border" size="57"> <font color="0000FF">(가로 <font id="id_width"><?=$basic_width;?></font> X <font id="id_height"><?=$basic_height;?></font> 픽셀)</font><br>
																	<img src="blank.gif" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 플래시 파일을 첨부하시는 경우 아래 사이즈를 반드시 입력해 주셔야 합니다.</font></td>
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
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">이미지 사이즈</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="size1" class="border" size="10" value="<?=$basic_width;?>"> Ⅹ
																	<input type="text" name="size2" class="border" size="10" value="<?=$basic_height;?>"><br>
																	<img src="blank.gif" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 플래시 파일의 가로 및 세로 사이즈를 입력해 주세요.<br>
																	&nbsp;* 플래시 파일이 아닌 이미지 파일을 첨부하시는 경우라면 입려하지 않으셔도 됩니다.</font></td>
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
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">링크경로 지정</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="linkpage" class="border" size="77">&nbsp&nbsp&nbsp
																	<a href="javascript:go_paste(snsForm,'linkpage')"><strong>붙여넣기</strong></a><br>
																	<img src="blank.gif" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 해당 이미지에 링크 기능을 사용하지 않으실 경우라면 입력하지 않으셔도 됩니다.<br>
																	&nbsp;<font color='red'>* 플래시 파일의 경우에는 플래시 제작과정에서 링크를 형성해야 합니다.</font></font></td>
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
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">링크타겟 지정</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="radio" name="target" value="none" checked>사용하지않음
																	<input type="radio" name="target" value="_blank">새창에서 열기
																	<input type="radio" name="target" value="_self">현재창에서 열기<br>
																	<img src="blank.gif" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 위의 링크 기능을 사용하지 않으실 경우에는 "사용하지않음"을 선택해 주시기 바랍니다.<br>
																	&nbsp;* "사용하지않음"에 체크된 상태에서 링크 기능을 사용할 경우에는 현재창에서 동작됩니다.<br>
																	&nbsp;<font color='red'>* 플래시 파일의 경우에는 플래시 제작과정에서 타겟을 형성해야 합니다.</font></font></td>
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
																	<a onclick="reset();" onfocus='this.blur();' style='cursor:hand;'><img src="../odimages/odmain/btn_cancel.gif" width="77" height="24" hspace="3" border="0"></a>
																	<a href="od_banner.php?location=<?=$location?>" onfocus='this.blur();'><img src="../odimages/btn_list.gif" hspace="3" border="0"></a></td>
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
		$row = mysql_fetch_row(mysql_query("SELECT MAX(serialnum) FROM odtImage"));
		
		$serialnum = $row[0]+1;
		$upload_path = $folderpath_upload_root."/banner";
		
		if(!$image) $image = "none";
		if($image != "none") {
			$FullFileName = explode(".", "$image_name");
			$extention = $FullFileName[sizeof($FullFileName)-1];
			
			move_uploaded_file($image,"$upload_path/$image_name");
			rename("$upload_path/$image_name","$upload_path/img$serialnum.$extention");
		}

		$size = $size1."/".$size2;
		$linkpage = addslashes(trim($linkpage));
		$inputdate = time();
		
		if($location) $locationTemp = $location;

		$result = mysql_query("INSERT INTO odtImage (serialnum,location,linkpage,target,extention,size,Icheck,inputdate,lineUp) VALUES ('$serialnum','$location','$linkpage','$target','$extention','$size','$Icheck','$inputdate','1')");
		
		if($result) {
			mysql_query("UPDATE odtImage SET lineUp=lineUp+1 WHERE serialnum<>'$serialnum' AND location='$location'");
			
			echo "
				<script>
					window.alert('등록이 잘 되었습니다.   ');
				</script>";

			echo "<meta http-equiv='Refresh' content='0; URL=od_banner.php?location=$locationTemp'>";
			exit;
		}
		else {
			echo "
				<script>
					window.alert('등록되지 않았습니다.   ');
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