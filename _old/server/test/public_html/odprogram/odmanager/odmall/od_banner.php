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

	## 세부권한 체크(업데이트,등록)
	if($row_admin[basicLevel]==5 || $row_admin[superLevel]==9) {
		$inputTemp1 = "od_bannerinput.php?location=$location";
		$updateTemp1 = "imgUpdate();";
	}
	else {
		$inputTemp1 = "javascript:reject();";
		$updateTemp1 = "javascript:reject();";
	}
			
	if($location == "mainL1") {
		$pageComment = " (메인왼쪽1)";
		$imgname1 = "btn_mainL1_.gif";
		$imgname2 = "btn_mainL2.gif";
		$imgname3 = "btn_mainB.gif";
		$imgname5 = "btn_all_img.gif";
	}
	else if($location == "mainL2") {
		$pageComment = " (메인왼쪽2)";
		$imgname1 = "btn_mainL1.gif";
		$imgname2 = "btn_mainL2_.gif";
		$imgname3 = "btn_mainB.gif";
		$imgname5 = "btn_all_img.gif";
	}
	else if($location == "mainB") {
		$pageComment = " (메인하단배너)";
		$imgname1 = "btn_mainL1.gif";
		$imgname2 = "btn_mainL2.gif";
		$imgname3 = "btn_mainB_.gif";
		$imgname5 = "btn_all_img.gif";
	}
	else {
		$pageComment = "";
		$imgname1 = "btn_mainL1.gif";
		$imgname2 = "btn_mainL2.gif";
		$imgname3 = "btn_mainB.gif";
		$imgname5 = "btn_all1_img.gif";
	}
	
	if(!strcmp($Form,"changeLineUp")) {
		mysql_query("UPDATE odtImage SET lineUp='$nLineUp' WHERE serialnum='$serialnum'");
		
		## 한개씩 증가
		if($pLineUp > $nLineUp) { 
			mysql_query("UPDATE odtImage SET lineUp=lineUp+1 WHERE serialnum!='$serialnum' AND location='$uLocation' AND lineUp < '$pLineUp' AND lineUp >= '$nLineUp'");
		}
		## 한개씩 감소 2가 3이 될경우 lineUp BETWEEN '$pLineUp' AND '$nLineUp'
		else if($pLineUp < $nLineUp) { 
			mysql_query("UPDATE odtImage SET lineUp=lineUp-1 WHERE serialnum!='$serialnum' AND location='$uLocation' AND lineUp > '$pLineUp' AND lineUp <= '$nLineUp'");
		}
		else {
			echo "<meta http-equiv='Refresh' content='0; URL=od_banner.php?location=$location'>";
			exit;
		}
		
		echo "
			<script name=javascript>
				window.alert('수정 되었습니다.   ');
			</script>";

		echo "<meta http-equiv='Refresh' content='0; URL=od_banner.php?location=$location'>";
		exit;
	}
	else {
?>

		<script>
			function lineUpFunc(which) {
				var code;
				code = which.value;
				if(code != "No")
					parent.location.href = "od_banner.php?"+code+"";
			}
			function selectAll() {
				var form = document.allDelete;
				for (var i=0;i<form.elements.length;i++) {
					obj_str = eval(form.elements[i]);
					obj_str.checked = !obj_str.checked;
				}
			}
			function imgUpdate() {
				document.allDelete.action = 'od_bannerupdate.inc.php';
				document.allDelete.submit();
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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 
													상점기본관리 &gt; <span class="st">베너 목록<?=$pageComment?></span></font></td>
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
													<td valign="top">
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<!-- delete form start -->
															<form name="allDelete" method="post" action="od_imagedelete.php">
																<input type="hidden" name="location" value="<?=$location?>">
															<tr>
																<td><img src="../odimages/odmain/page_icon.gif" width="14" height="11"> 
																	<a href="od_banner.php?location=mainL1" onfocus='this.blur();'><img src="../odimages/<?=$imgname1?>" align="absmiddle" border="0"></a>
																	<a href="od_banner.php?location=mainL2" onfocus='this.blur();'><img src="../odimages/<?=$imgname2?>" align="absmiddle" border="0"></a>
																	<a href="od_banner.php?location=mainB" onfocus='this.blur();'><img src="../odimages/<?=$imgname3?>" align="absmiddle" border="0"></a>
																	<a href="od_banner.php" onfocus='this.blur();'><img src="../odimages/<?=$imgname5?>" align="absmiddle" border="0"></a></td>
																<td align="right">
																	<a onclick="<?=$updateTemp1?>" style='cursor:hand;' onfocus='this.blur();'><img src="../odimages/btn_all_update.gif" border="0" onfocus='this.blur();'></a> 
																	<a href="<?=$inputTemp1?>"><img src="../odimages/btn_admin_input.gif" width="77" height="24" border="0" onfocus='this.blur();'></a></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="1" colspan="11" bgcolor="c0bebe"></td>
															</tr>
															<tr align="center"> 
																<td width="45" height="27" bgcolor="ececec" class="white">번호</td>
																<td bgcolor="ececec" class="white" align="center">이미지 또는 플래시</td>
																<td width="90" bgcolor="ececec" class="white">위치</td>
																<td width="90" bgcolor="ececec" class="white">진열순위</td>
																<td width="90" height="27" bgcolor="ececec" class="white">표시여부</td>
																<td width="60" bgcolor="ececec" class="white">수정</td>
																<td width="60" bgcolor="ececec" class="white">삭제</td>
															</tr>
															<tr> 
																<td height="1" colspan="11" bgcolor="c0bebe"></td>
															</tr>
															<tr> 
																<td height="2" colspan="11"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
<?
		if($location) $whereTemp = "where location='".$location."'";
		else $whereTemp = "where (location='mainL1' or location='mainL2' or location='mainB')";
		
		$result = mysql_query("SELECT serialnum, extention, size, location, Icheck, linkpage, lineUp FROM odtImage $whereTemp ORDER BY location, lineUp ASC");
		$total = mysql_num_rows($result);
?>
		<script language="javascript">
			function checkAll(str) {
				var f = document.allDelete;
				for (i=1;i<=<?=$total?>;i++) {
					if(i==str) {
						eval("document.allDelete.Icheck"+i).checked = true;
					}else {
						eval("document.allDelete.Icheck"+i).checked = false;
					}
				}
			}
		</script>
<?
		if(!$total) {
			echo "
															<tr>
																<td height='55' align='center' colspan='11'>자료가 없습니다.</td>
															</tr>";
		}

		$serialnumber = $total;
		$cin = 1;
		
		while($row = mysql_fetch_array($result)) {
			$img_location = "$folderpath_upload/banner/img$row[serialnum].$row[extention]";
			$sizeDivision = explode("/",$row[size]);
			
			if($row[extention] == 'swf') {
				$imgViewTemp = "
					<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0' width='$sizeDivision[0]' height='$sizeDivision[1]'>
					<param name='movie' value='$img_location'>
					<param name='quality' value='high'>
					<param name='wmode' value='transparent'>
					<embed src='$img_location' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='$sizeDivision[0]' height='$sizeDivision[1]'></embed></object>";
			}
			else {
				$imgViewTemp = "<img src='$img_location'>";
			}

			if($row[location] == "mainL1") $locationTemp = "메인왼쪽1";
			else if($row[location] == "mainL2") $locationTemp = "메인왼쪽2";
			else if($row[location] == "mainB") $locationTemp = "메인하단배너";
			else $locationTemp = "&nbsp;";
			
			if($row[Icheck]=="yes") $checkedTemp = "checked";
			else $checkedTemp = "";
			
			if($row[extention] <> 'swf') {
				if($row[linkpage]) $linkpageTemp = "<a href='$row[linkpage]' target='_blank' class='cate'>$row[linkpage]</a>";
				else $linkpageTemp = "<font class='cate'>사용하지 않음</class>";
			}
			else {
				$linkpageTemp = "<font color='red'>플래시 파일의 경우에는 플래시 제작과정에서 링크를 형성해야 합니다.</font>";
			}
			
			$maxLineUp = mysql_result(mysql_query("SELECT max(lineUp) FROM odtImage WHERE location='$row[location]'"),0);
			
			// 세부권한 체크(수정,삭제)
			if($row_admin[basicLevel]==5 || $row_admin[superLevel]==9) {
				$modifyTemp1 = "od_bannermodify.php?serialnum=$row[serialnum]&location=$location";
				$deleteTemp1 = "od_bannerdelete.php?serialnum=$row[serialnum]&iname=img$row[serialnum].$row[extention]&dlocation=$row[location]&pLineUp=$row[lineUp]&location=$location";
			}
			else {
				$modifyTemp1 = "javascript:reject();";
				$deleteTemp1 = "javascript:reject();";
			}

			echo "
															<tr> 
																<td height='1' colspan='7' bgcolor='D2D2D2'></td>
															</tr>
															<tr> 
																<td height='5' colspan='7' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td width='45' align='center' bgcolor='FAFAFA'>$serialnumber</td>
																<td bgcolor='FAFAFA' style='padding-left:7;'>$imgViewTemp</td>
																<td width='90' align='center' bgcolor='FAFAFA'>$locationTemp</td>
																<td width='90' align='center' bgcolor='FAFAFA'>
																	<select name='select' onChange=\"lineUpFunc(this)\">";

			for($j=1;$j<=$maxLineUp;$j++) {
				echo "<option value='Form=changeLineUp&serialnum=$row[serialnum]&uLocation=$row[location]&pLineUp=$row[lineUp]&nLineUp=$j&location=$location'";
				
				if($row[lineUp] == $j) echo " selected";
				
				echo ">$j</option>";
			}

			echo "
																	</select></td>
																<td width='90' align='center' bgcolor='FAFAFA'>
																	<input type='hidden' name='serialnum$cin' value='$row[serialnum]'>
																	<input type='checkbox' name='Icheck$cin' value='yes' $checkedTemp>표시함</td>
																	<!--<input type='checkbox' name='Icheck$cin' value='yes' $checkedTemp onclick=\"checkAll($cin)\">표시함</td>-->
																<td width='60' align='center' bgcolor='FAFAFA'><a href='$modifyTemp1'><img src='../odimages/btn_modify.gif' border='0'></a></td>
																<td width='60' align='center' bgcolor='FAFAFA'><a href='$deleteTemp1'><img src='../odimages/btn_delete.gif' border='0'></a></td>
															</tr>
															<tr> 
																<td height='7' colspan='7' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td height='21' bgcolor='F1F1F1'></td>
																<td height='21' colspan='6' bgcolor='F1F1F1' style='padding-left:7;'>링크경로 : $linkpageTemp</td>
															</tr>";

			$serialnumber--;
			$cin++;
		}
?>
															<input type='hidden' name='cin' value='<?=$cin?>'>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="2" colspan="3"></td>
															</tr>
															<tr> 
																<td height="1" colspan="3" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="3" colspan="3"></td>
															</tr>
															<tr> 
																<td width="160">&nbsp;</td>
																<td align="center" class="num">&nbsp;</td>
																<td align="right">
																	<a onclick="<?=$updateTemp1?>" style='cursor:hand;' onfocus='this.blur();'><img src="../odimages/btn_all_update.gif" border="0" onfocus='this.blur();'></a>
																	<a href="<?=$inputTemp1?>"><img src="../odimages/btn_admin_input.gif" width="77" height="24" border="0" onfocus='this.blur();'></a></td>
															</tr>
															<tr> 
																<td height="7" colspan="3"></td>
															</tr>
															<!-- delete form end -->
															</form>
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
<? 
	} 
?>