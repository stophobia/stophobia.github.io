<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";

	## 세부권한 체크
	if($row_admin[smanagerLevel] < 3) {
		error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
	}
	
	if(!$form) {
		$row = mysql_fetch_array(mysql_query("SELECT * FROM odtAdmin WHERE serialnum='$serialnum'"));
?>

		<script language="javascript">
			function valueCheck(form) {
				var form = document.snsForm;
				if(!form.id.value) {
					alert("아이디(ID)를 입력하셔야 합니다.   ");
					form.id.focus();
					return false;
				}
				if(form.passwd.value) {
					if(!form.repasswd.value) {
						window.alert("비밀번호 확인을 위해 비밀번호를 다시 입력하셔야 합니다.   ");
						form.repasswd.focus();
						return false;
					}
					if(form.passwd.value != form.repasswd.value) {
						window.alert("비밀번호가 일치하지 않습니다.   \n\n정확하게 입력해 주세요.   ");
						form.repasswd.focus();
						return false;
					}
				}
				if(!form.name.value) {
					alert("이름을 입력하셔야 합니다.   ");
					form.name.focus();
					return false;
				}
			}
			function agentWin() {
				  window.open('od_agentsearch.php','agent','resizable=yes,scrollbars=yes,width=420,height=410'); 
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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 상점기본관리 &gt; <span class="st"><?=$row_company[name]?> 관리자 정보 수정</span></font></td>
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
													<td height="18"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5"><b>관리자</b> 정보를 수정 합니다.</font></td>
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
															<!-- form start ------------------------------------------------->
															<form name="snsForm" method="post" action="<?=$php_self?>" onSubmit="return valueCheck(this)">
																<input type="hidden" name="form" value="setupForm">
																<input type="hidden" name="serialnum" value="<?=$serialnum?>">
																<input type="hidden" name="page" value="<?=$page?>">
																<input type="hidden" name="search" value="<?=$search?>">
																<input type="hidden" name="key" value="<?=$key?>">
																<input type="hidden" name="superLevel" value="9">
															<tr> 
																<td width="170" height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">아이디(ID)</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																  &nbsp;<input type="text" name="id" class="border" size="20" value="<?=$row[id]?>"><br>
																  <img src="blank.gif" width="1" height="3"><br><font color="313D7D">
																  &nbsp;* 관리자 아이디를 설정합니다.</font></td>
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
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">비밀번호</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																  &nbsp;<input type="password" name="passwd" class="border" size="20" <?=$id_str;?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																  재입력 <input type="password" name="repasswd" class="border" size="20" <?=$id_str;?>><br>
																  <img src="blank.gif" width="1" height="3"><br><font color="313D7D">
																  &nbsp;* 변경하시고자 할 경우에만 입력 하세요.</font></td>
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
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">이름</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																  &nbsp;<input type="text" name="name" class="border" size="20" value="<?=stripslashes($row[name])?>">
																  <img src="blank.gif" width="1" height="3"><br><font color="313D7D">
																  &nbsp;* 관리자 이름을 설정합니다.</font></td>
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
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">휴대폰번호</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																  &nbsp;<input type="text" name="htel" class="border" size="35" value="<?=$row[htel]?>">
																  <img src="blank.gif" width="1" height="3"><br><font color="313D7D">
																  &nbsp;* 관리자의 연락 가능한 연락처를 설정합니다. 예) 011-9868-0000</font></td>
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
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">E-mail</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																  &nbsp;<input type="text" name="email" class="border" size="35" value="<?=$row[email]?>">
																  <img src="blank.gif" width="1" height="3"><br><font color="313D7D">
																  &nbsp;* 관리자의 연락 가능한 E-mail을 설정합니다.</font></td>
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
																	<!-- 접근권한(수정) -->
<? 
		if($row_admin[smanagerLevel]==5 || $row_admin[superLevel]==9) { 
?>
																	<input type="image" src="../odimages/odmain/btn_ok.gif" width="77" height="24" hspace="3" style='cursor:hand;' onfocus='this.blur();'>
<? 
		}
		else { 
?>
																	<a href='javascript:reject();' onfocus='this.blur();'><img src="../odimages/odmain/btn_ok.gif" width="77" height="24" hspace="3" border="0"></a> 
<? 
		} 
?>
																	<a onclick="reset();" onfocus='this.blur();' style='cursor:hand;'><img src="../odimages/odmain/btn_cancel.gif" width="77" height="24" hspace="3" border="0"></a>
																	<a href="od_admin.php?page=<?=$page?>&search=<?=$search?>&key=<?=$key?>" onfocus='this.blur();'><img src="../odimages/btn_list.gif" border="0" hspace="3"></a></td>
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
	else if(!strcmp($form,"setupForm")) {

	chk_authfree();

		$id = addslashes(trim($id));
		$name = addslashes(trim($name));
		$email = addslashes(trim($email));
		$agentName = addslashes(trim($agentName));
		
		if($superLevel == 9) {
			$manager = "yes";
			$onedaynet_pos_level = 3;
			$smanagerLevel = 5;
			$basicLevel	 = 5;
			$imgfocusLevel = 5;
			$webposLevel = 5;
			$designLevel = 5;
			$row_memberberLevel = 9;
			$productLevel = 9;
			$orderLevel = 9;
			$statisticLevel = 3;
			$gongguLevel = 9;
			$auctionLevel = 9;
			$boardLevel = 9;
			$pollLevel = 9;
			$smsLevel = 3;
			$logLevel = 3;
			$customerLevel = 9;
			$partnerLevel = 9;
			$agentLevel = 9;
		}

		$modifyDate = time();
		
		if(!$passwd) {
			## 회원 정보를 가져온다. ##############################################
			$row = mysql_fetch_array(mysql_query("SELECT passwd, repasswd FROM odtAdmin WHERE serialnum='$serialnum'"));
			
			$passwd = $row[passwd];
			$repasswd = $row[repasswd];
		}
		else {
			$repasswd = $passwd;

			if(!ereg("[[:alnum:]+]{4,8}",$passwd)) {
				error_msgback_user('비밀번호는 4자이상 8자이하 영문, 숫자 또는 영문/숫자 조합이어야 합니다.   ');
			}
			
			## 비밀번호를 입력한 경우 비밀번호 암호화 ###############################################
			$result = mysql_query("SELECT password('$passwd')");
			$passwd = mysql_result($result,0,0);
		}

		$result = mysql_query("UPDATE odtAdmin SET id='$id',passwd='$passwd',repasswd='$repasswd',name='$name',htel='$htel',email='$email',agentCode='$agentCode',agentName='$agentName',superLevel='$superLevel',manager='$manager',onedaynet_pos_level='$onedaynet_pos_level',smanagerLevel='$smanagerLevel',basicLevel='$basicLevel',imgfocusLevel='$imgfocusLevel',webposLevel='$webposLevel',designLevel='$designLevel',memberLevel='$row_memberberLevel',productLevel='$productLevel',orderLevel='$orderLevel',statisticLevel='$statisticLevel',gongguLevel='$gongguLevel',auctionLevel='$auctionLevel',boardLevel='$boardLevel',pollLevel='$pollLevel',smsLevel='$smsLevel',logLevel='$logLevel',customerLevel='$customerLevel',partnerLevel='$partnerLevel',agentLevel='$agentLevel',modifyDate='$modifyDate' WHERE serialnum='$serialnum'");
		
		if($result) {
			echo "
				<script>
					window.alert('수정이 잘 되었습니다.   ');
				</script>";

			echo "<meta http-equiv='Refresh' content='0; URL=od_admin.php?page=$page&search=$search&key=$key'>";
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