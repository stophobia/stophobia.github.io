<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";

	## 접근권한 설정
	if($row_admin[productLevel] == 5 || $row_admin[productLevel] == 9 || $row_admin[superLevel]==9) {
	}
	else {
		error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
	}
	
	if($serialnum) {
		$userInfo = mysql_fetch_array(mysql_query("select * from odtMember where serialnum='".$serialnum."'"));
	}
?>
		<script language="javascript">
			function valueCheck(form) {
				var form = document.snsForm;
				if(!form.id.value) {
					alert("공급업체 아이디를 입력해 주시기 바랍니다.   ");
					form.id.focus();
					return false;
				}

				if(!form.passwd.value) {
					alert("비밀번호를 입력해 주시기 바랍니다.   ");
					form.passwd.focus();
					return false;
				}
				if(form.passwd.value != form.repasswd.value) {
					alert("비밀번호가 서로 다릅니다.   ");
					form.passwd.focus();
					return false;
				}
				if(!form.cName.value) {
					alert("공급업체명을 입력해 주시기 바랍니다.   ");
					form.cName.focus();
					return false;
				}
			}
			function search(obj) {
				hidden_frame.location.href= "od_search.php?id="+obj.value;
			}
		</script>
		<iframe name="hidden_frame" src="about:blank" style="display:none;"></iframe>
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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 공급업체 관리 &gt; <span class="st">공급업체 신규등록</span></font></td>
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
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="18"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5"> <span style='color:red;font-weight:bold'>*</span> 항목은 쿠폰에 사용되는 항목이므로 반드시 기입해주시기 바랍니다.</font></td>
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
															<!-- form start -------------------------------------------->
															<form name="snsForm" method="post" action="./od_pro.php" onSubmit="return valueCheck(this)" target="hidden_frame" enctype="multipart/form-data" >
																<input type="hidden" name="subMode" value="<?=$userInfo[id] ? "edt" : "ins";?>">
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td width="150" bgcolor="ececec" class="white" style="padding:5px;" height="35"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">공급업체 아이디</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
<?
if($userInfo[id]) {
?>
																	&nbsp;<?=$userInfo[id]?><input type="hidden" name="id" value=<?=$userInfo[id]?>>
<?	
} else {
?>
																	&nbsp;<input type="text" name="id" class="border" size="20" value="" onblur="search(this)">
																	<span id="searchinnerHTML"></span>
<?
}
?>
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
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td width="150" bgcolor="ececec" class="white" style="padding:5px;" height="35"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">비밀번호</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="password" name="passwd" class="border" size="20" value="">
<?
if($userInfo[id]) echo "<font color=red>변경하실 경우에만 입력하세요.</font>";
?>																	
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
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td width="150" bgcolor="ececec" class="white" style="padding:5px;" height="35"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">비밀번호 확인</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="password" name="repasswd" class="border" size="20" value=""></td>
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
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>

															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;" height="35"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">밴더사명</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="bannder" class="border" size="50" value="<?=$userInfo[bannder]?>"></td>
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
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>

															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;" height="35"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">공급업체명 <span style='color:red;font-weight:bold'>*</span></td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="cName" class="border" size="50" value="<?=$userInfo[cName]?>"></td>
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
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;" height="35"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">사업자번호 (주민번호)</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="cNumber" class="border" size="50" value="<?=$userInfo[cNumber]?>"></td>
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
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;" height="35"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">대표자</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="ceoName" class="border" size="50" value="<?=$userInfo[ceoName]?>"></td>
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
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;" height="35"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">주소 <span style='color:red;font-weight:bold'>*</span></td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="address" class="border" size="85" value="<?=$userInfo[address]?>"></td>
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
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;" height="35"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">업태</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="cItem1" class="border" size="50" value="<?=$userInfo[cItem1]?>"></td>
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
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;" height="35"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">업종</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="cItem2" class="border" size="50" value="<?=$userInfo[cItem2]?>"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="15" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="15" bgcolor="FFFFFF" colspan="2"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5"><b>담당자</b> 정보를 등록합니다.</font></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;" height="35"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">담당자이름</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="name" class="border" size="20" value="<?=$userInfo[name]?>"></td>
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
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;" height="35"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">전화번호 <span style='color:red;font-weight:bold'>*</span></td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="tel1" class="border" size="4" value="<?=$userInfo[tel1]?>">
																	- <input type="text" name="tel2" class="border" size="4" value="<?=$userInfo[tel2]?>">
																	- <input type="text" name="tel3" class="border" size="4" value="<?=$userInfo[tel3]?>">
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
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>

															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;" height="35"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">팩스번호</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="ofax1" class="border" size="4" value="<?=$userInfo[ofax1]?>"> 
																	- <input type="text" name="ofax2" class="border" size="4" value="<?=$userInfo[ofax2]?>">
																	- <input type="text" name="ofax3" class="border" size="4" value="<?=$userInfo[ofax3]?>">
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
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;" height="35"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">휴대폰번호</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="htel1" class="border" size="4" value="<?=$userInfo[htel1]?>">
																	- <input type="text" name="htel2" class="border" size="4" value="<?=$userInfo[htel2]?>">
																	- <input type="text" name="htel3" class="border" size="4" value="<?=$userInfo[htel3]?>">
																	
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
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;" height="35"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5"><font face='verdana'>E-mail <span style='color:red;font-weight:bold'>*</span></font></td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="email" class="border" size="55" value="<?=$userInfo[email]?>"></td>
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
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;" height="35"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5"><font face='verdana'>Homepage</font></td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="homepage" class="border" size="60" value="<?=$userInfo[homepage]?>"></td>
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
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;" height="35"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5"><font face='verdana'>판매자사진</font></td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="file" name="pic" class="border"> 141 x 152
																
<?
$imgName = "pic";
if($userInfo[$imgName]) {
?>
																	<br><a href="<?=$userInfo[$imgName]?>" target="_blank"><img src="<?=$userInfo[$imgName]?>" width=141 height=152 border=0></a>
																	<input type="hidden" name="<?=$imgName?>_org" value="<?=$userInfo[$imgName]?>">
																	<input type="checkbox" name="<?=$imgName?>_del" value="Y"> 삭제
<?
}
?>																				

																	</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>

														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="10" bgcolor="FFFFFF"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="1" cellpadding="0">
															<tr> 
																<td align="center">
																	<input type="image" src="../odimages/odmain/btn_ok.gif" width="77" height="24" hspace="3" style='cursor:hand;' onfocus='this.blur();'>
																	<a onclick="reset();" onfocus='this.blur();' style='cursor:hand;'><img src="../odimages/odmain/btn_cancel.gif" width="77" height="24" hspace="3" border="0"></a>
																	<a href="od_list.php" onfocus='this.blur();'><img src="../odimages/btn_list.gif" border="0" hspace="3"></a></td>
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