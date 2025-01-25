<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";

	## 세부권한 체크
	if($row_admin[memberLevel] < 3) {
		error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
	}

	// 체험판 사용제한
	chk_authfree();

	if(!$form) {
		$row = mysql_fetch_array(mysql_query("SELECT * FROM odtMember WHERE serialnum='$serialnum'"));
		
		$row[signdate] = date("Y년 m월 d일 H시 i분 s초",$row[signdate]);
		
		if($row[maildate]) $maildate_str = date("Y년 m월 d일  H시 i분", $row[maildate]);
		else $maildate_str = "-";
?>

		<script language="javascript">
			function isnum(NUM) {
				for(var i=0;i<NUM.length;i++) {
					achar = NUM.substring(i,i+1);
					if( achar < "0" || achar > "9" ) {
						return false;
					}
				}
				return true;
			}
			function valueCheck(form) {
				var form = document.snsForm;
				if(form.passwd.value) {
					if(form.passwd.value.length < 4 || form.passwd.value.length > 12) {
						window.alert("비밀번호는 4자 이상 12자 이하의 숫자/영문 또는 숫자와 영문 조합의 문자열이어야 합니다.   ");
						form.passwd.focus();
						return false;
					}
					if(!form.repasswd.value) {
						window.alert("비밀번호 확인을 위해 비밀번호를 다시 입력하셔야 합니다.   ");
						form.repasswd.focus();
						return false;
					}
					if(form.passwd.value != form.repasswd.value) {
						window.alert("비밀번호가 서로 일치하지 않습니다.   \n\n정확하게 입력해 주세요.   ");
						form.repasswd.focus();
						return false;
					}
				}
				if(!form.email.value) {
					window.alert("E-mail을 입력해 주세요.   ");
					form.email.focus();
					return false;
				}
				if((!form.email.value) || ((form.email.value.indexOf("@") == -1) || (form.email.value.indexOf(".") == -1))) {
					window.alert("올바르지않은 E-mail 입니다.   \n\n다시 입력해 주세요.   ");
					form.email.focus();
					return false;
				}
				if(!form.zip1.value) {
					window.alert("우편번호 앞자리를 입력해 주세요.   ");
					form.zip1.focus();
					return false;
				}
				if(!form.zip2.value) {
					window.alert("우편번호 뒷자리를 입력해 주세요.   ");
					form.zip2.focus();
					return false;
				}
				if(!form.zip1.value || form.zip1.value.length != 3 || !isnum(form.zip1.value)) {
					window.alert("올바르지않은 우편번호 입니다!\n\n다시 입력해 주세요.   ");
					form.zip1.focus();
					return false;
				}
				if(!form.zip2.value || form.zip2.value.length != 3 ||  !isnum(form.zip2.value)) {
					window.alert("올바르지않은 우편번호 입니다!\n\n다시 입력해 주세요.   ");
					form.zip2.focus();
					return false;
				}
				if(!form.address.value) {
					window.alert("주소를 입력해 주세요.   ");
					form.address.focus();
					return false;
				}
				if(!form.address.value || form.address.value.length < 8) {
					window.alert("올바르지않은 주소 입니다!\n\n다시 입력해 주세요.   ");
					form.address.focus();
					return false;
				}
				if(!form.address1.value) {
					window.alert("주소를 입력해 주세요.   ");
					form.address1.focus();
					return false;
				}
				if(!form.tel1.value) {
					window.alert("전화번호 중 지역번호를 입력해 주세요.   ");
					form.tel1.focus();
					return false;
				}
				if(!form.tel2.value) {
					window.alert("전화번호 중 국번을 입력해 주세요.   ");
					form.tel2.focus();
					return false;
				}
				if(!form.tel3.value) {
					window.alert("전화번호 중 번호를 입력해 주세요.   ");
					form.tel3.focus();
					return false;
				}
				if(!form.tel1.value || !isnum(form.tel1.value)) {
					window.alert("올바르지않은 전화번호 입니다.   \n\n다시 입력해 주세요.   ");
					form.tel1.focus();
					return false;
				}
				if(!form.tel2.value || form.tel2.value.length < 3 || !isnum(form.tel2.value)) {
					window.alert("올바르지않은 전화번호 입니다.   \n\n다시 입력해 주세요.   ");
					form.tel2.focus();
					return false;
				}
				if(!form.tel3.value || form.tel3.value.length < 3 || !isnum(form.tel3.value)) {
					window.alert("올바르지않은 전화번호 입니다.   \n\n다시 입력해 주세요.   ");
					form.tel3.focus();
					return false;
				}
			}
			function postsearch() {
				  window.open('../../odpostcode/od_postsearch.php?Mode=memberModify','post_find','resizable=yes,scrollbars=yes,width=386,height=410'); 
			}
			function postsearch1() {
				  window.open('../../odpostcode/od_postsearch.php?Mode=memberOption','post_find','resizable=yes,scrollbars=yes,width=386,height=410'); 
			}
		</script>

		<iframe name="hf" src="about:blank" style="display:none"></iframe>
		<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0"  bgcolor="FFFFFF">
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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 회원 관리 &gt; <span class="st">회원정보 상세 및 수정</span></font></td>
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
													<td height="18"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5"><b><?=$row[name]?></b>님의 기본정보 수정</font></td>
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
															<!-- form start ---------------------------------------->
															<form name="snsForm" method="post" action="od_modify.php" onSubmit="return valueCheck(this)">
																<input type="hidden" name="form" value="accessForm">
																<input type="hidden" name="serialnum" value="<?=$serialnum?>">
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td height="35" width="150" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">아이디(ID)</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<b><font size="3"><?=$row[id]?></font></b></td>
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
																<td height="35" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">이름</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<b><font size="3"><?=$row[name]?> (<?=$row[sex] =="F" ? "여" : "남";?>) <?=$row[birthy].". ".$row[birthm].". ".$row[birthd]?></font></b></td>
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
																<td height="35" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">닉네임</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<?=$row[chatNickName]?> <?help_pop("닉네임은 채팅시 사용됩니다.")?></td>
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
																<td height="35" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">비밀번호</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<a href="#none" onclick="if(confirm('비밀번호를 문자로 발송하시겠습니까?')) hf.location.href='od_passSMS.php?pwID=<?=$row[id]?>';"><u>[SMS로 아이디/비밀번호 발송]</u></a> (가입시 입력한 핸드폰으로 발송됩니다.)</td>
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
																<td height="35" bgcolor="ececec" class="white" style="padding:5px;" height="31"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">E-mail</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="email" class="border" size="50" value="<?=$row[email]?>"></td>
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
																<td height="35" bgcolor="ececec" class="white" style="padding:5px;" height="31"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">우편번호</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="zip1" class="border" size="5" maxlength="3" value="<?=$row[zip1]?>"> - 
																	<input type="text" name="zip2" class="border" size="5" maxlength="3" value="<?=$row[zip2]?>">
																	<a onclick="postsearch();" onfocus='this.blur();' style='cursor:hand;'><img src="../../odimages/odorder/btn_post.gif" border="0" align="absmiddle"></a></td>
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
																<td height="35" bgcolor="ececec" class="white" style="padding:5px;" height="31"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">주소</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="address" class="border" size="85" value="<?=$row[address]?>"><br>
																	<img src="blank.gif" width="1" height="3"><br>
																	&nbsp;<input type="text" name="address1" class="border" size="55" value="<?=$row[address1]?>"></td>
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
																<td height="35" bgcolor="ececec" class="white" style="padding:5px;" height="31"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">전화번호</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="tel1" class="border" size="7" maxlength="4" value="<?=$row[tel1]?>"> - 
																	<input type="text" name="tel2" class="border" size="7" maxlength="4" value="<?=$row[tel2]?>"> - 
																	<input type="text" name="tel3" class="border" size="7" maxlength="4" value="<?=$row[tel3]?>"></td>
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
																<td height="35" bgcolor="ececec" class="white" style="padding:5px;" height="31"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">휴대폰번호</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="htel1" class="border" size="7" maxlength="4" value="<?=$row[htel1]?>"> - 
																	<input type="text" name="htel2" class="border" size="7" maxlength="4" value="<?=$row[htel2]?>"> - 
																	<input type="text" name="htel3" class="border" size="7" maxlength="4" value="<?=$row[htel3]?>"></td>
															</tr>
															<tr style=display:none> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr style=display:none> 
																<td height="7" bgcolor="FFFFFF"></td>
															</tr>
															<tr style=display:none> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr style=display:none> 
																<td height="35" bgcolor="ececec" class="white" style="padding:5px;" height="31"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">직업</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<select name="job">
																	<option value="0" <?if(!$row[job]){echo " selected";}?>>* <?=$row[name]?>님의 직업을 선택해 주세요.</option>
																	<option value="0">---------------------------------</option>
																	<option value="1" <?if($row[job]==1){echo " selected";}?>>중학교 이하</option>
																	<option value="2" <?if($row[job]==2){echo " selected";}?>>고등학생</option>
																	<option value="3" <?if($row[job]==3){echo " selected";}?>>대학(원)생</option>
																	<option value="4" <?if($row[job]==4){echo " selected";}?>>사무직</option>
																	<option value="5" <?if($row[job]==5){echo " selected";}?>>기술직</option>
																	<option value="6" <?if($row[job]==6){echo " selected";}?>>서비스/판매직</option>
																	<option value="7" <?if($row[job]==7){echo " selected";}?>>생산직</option>
																	<option value="8" <?if($row[job]==8){echo " selected";}?>>정보통신 관련직</option>
																	<option value="9" <?if($row[job]==9){echo " selected";}?>>의료인</option>
																	<option value="10" <?if($row[job]==10){echo " selected";}?>>방송/언론인</option>
																	<option value="11" <?if($row[job]==11){echo " selected";}?>>법조인</option>
																	<option value="12" <?if($row[job]==12){echo " selected";}?>>종교인</option>
																	<option value="13" <?if($row[job]==13){echo " selected";}?>>예능/예술인</option>
																	<option value="14" <?if($row[job]==14){echo " selected";}?>>전문직</option>
																	<option value="15" <?if($row[job]==15){echo " selected";}?>>주 부</option>
																	<option value="16" <?if($row[job]==16){echo " selected";}?>>자영업</option>
																	<option value="17" <?if($row[job]==17){echo " selected";}?>>농/축/수산</option>
																	<option value="18" <?if($row[job]==18){echo " selected";}?>>공무원</option>
																	<option value="19" <?if($row[job]==19){echo " selected";}?>>교사/교수</option>
																	<option value="20" <?if($row[job]==20){echo " selected";}?>>비영리단체</option>
																	<option value="21" <?if($row[job]==21){echo " selected";}?>>무 직</option>
																	<option value="22" <?if($row[job]==22){echo " selected";}?>>군 인</option>
																	<option value="23" <?if($row[job]==23){echo " selected";}?>>기 타</option>
																	</select>
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
																<td height="35" bgcolor="ececec" class="white" style="padding:5px;" height="31"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">메일링 수신</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	<input type="radio" name="mailling" value="Y" <?if($row[mailling]=="Y") echo" checked";?>>동의합니다. 
																	<input type="radio" name="mailling" value="N" <?if($row[mailling]=="N") echo" checked";?>>동의하지 않습니다.</td>
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
																<td height="35" bgcolor="ececec" class="white" style="padding:5px;" height="31"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">SMS 수신</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	<input type="radio" name="sms" value="Y" <?if($row[sms]=="Y") echo" checked";?>>동의합니다. 
																	<input type="radio" name="sms" value="N" <?if($row[sms]=="N") echo" checked";?>>동의하지 않습니다.</td>
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
																<td height="35" bgcolor="ececec" class="white" style="padding:5px;" height="31"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">가입일</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<b><?=$row[signdate]?></b></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF"></td>
															</tr>
															<tr>
																<td colspan="2">
																	<table width="760" border="0" cellspacing="0" cellpadding="0">
																		<tr> 
																			<td width="158" height="1" bgcolor="c0bebe"></td>
																			<td width="222" height="1" bgcolor="D2D2D2"></td>
																			<td width="160" height="1" bgcolor="c0bebe"></td>
																			<td width="220" height="1" bgcolor="D2D2D2"></td>
																		</tr>
																		<tr> 
																			<td height="35" bgcolor="ececec" class="white" style="padding:5px;" width="158"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">최근 접속일</td>
																			<td bgcolor="FAFAFA" style="padding:5px;" width="222"> 
																				&nbsp;<?=date("Y년 m월 d일 H시 i분 s초", $row[recentdate])?></td>
																			<td bgcolor="ececec" class="white" style="padding:5px;" width="160"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">최근 정보변경일</td>
																			<td bgcolor="FAFAFA" style="padding:5px;" width="220"> 
																				&nbsp;<?=date("Y년 m월 d일 H시 i분 s초", $row[modifydate])?></td>
																		</tr>
																		<tr> 
																			<td width="158" height="1" bgcolor="c0bebe"></td>
																			<td width="222" height="1" bgcolor="D2D2D2"></td>
																			<td width="160" height="1" bgcolor="c0bebe"></td>
																			<td width="220" height="1" bgcolor="D2D2D2"></td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td height="35" bgcolor="ececec" class="white" style="padding:5px;" height="31"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">최근메일링 일시</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<b><?=$maildate_str;?></b></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="17" bgcolor="FFFFFF" colspan="2"></td>
															</tr>
															<tr> 
																<td bgcolor="FFFFFF" colspan="2"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5"><b><?=$row[name]?></b>님의 등급, 포인트, 비밀번호 수정</font></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF" colspan="2"></td>
															</tr>
															<tr <?=$chk_hide == true ? "style=display:none" : NULL;?>> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr <?=$chk_hide == true ? "style=display:none" : NULL;?>> 
																<td height="35" bgcolor="ececec" class="white" style="padding:5px;" height="31"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">등급설정</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	<input type="radio" name="Mlevel" value="1" <?if($row[Mlevel]=="1") echo" checked";?>>일반회원 
<? 
		if($row_setup[mclass] == "Y") { 
?>
																	<input type="radio" name="Mlevel" value="3" <?if($row[Mlevel]=="3") echo" checked";?>><?=$row_setup[classname1]?>
																	<input type="radio" name="Mlevel" value="5" <?if($row[Mlevel]=="5") echo" checked";?>><?=$row_setup[classname2]?>
<? 
		} 
?>
																	<input type="radio" name="Mlevel" value="9" <?if($row[Mlevel]=="9") echo" checked";?>><b>관리자</b></td>
															</tr>
															<tr <?=$chk_hide == true ? "style=display:none" : NULL;?>> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr <?=$chk_hide == true ? "style=display:none" : NULL;?>> 
																<td height="7" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td height="35" bgcolor="ececec" class="white" style="padding:5px;" height="31"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">포인트</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="point" class="border" size="10" style='text-align:right;' value="<?=$row[point]?>"> p</td>
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
																<td height="35" bgcolor="ececec" class="white" style="padding:5px;" height="31"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">참여점수</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="action" class="border" size="10" style='text-align:right;' value="<?=$row[action]?>"> p</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF"></td>
															</tr>

															<tr>
																<td colspan="2">
																	<table width="760" border="0" cellspacing="0" cellpadding="0">
																		<tr> 
																			<td width="158" height="1" bgcolor="c0bebe"></td>
																			<td width="222" height="1" bgcolor="D2D2D2"></td>
																			<td width="160" height="1" bgcolor="c0bebe"></td>
																			<td width="220" height="1" bgcolor="D2D2D2"></td>
																		</tr>
																		<tr> 
																			<td height="35" bgcolor="ececec" class="white" style="padding:5px;" width="162"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">비밀번호</td>
																			<td bgcolor="FAFAFA" style="padding:5px;" width="218"> 
																				&nbsp;<input type="password" name="passwd" class="border" size="20" <?=$id_str;?>><br>
																				<img src="" width="1" height="2"><br><font color="FF0000">
																				&nbsp;<b>* 변경할 경우에만 입력 하세요.</b></font></td>
																			<td bgcolor="ececec" class="white" style="padding:5px;" width="160"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">비밀번호 확인</td>
																			<td bgcolor="FAFAFA" style="padding:5px;" width="220"> 
																				&nbsp;<input type="password" name="repasswd" class="border" size="20" <?=$id_str;?>><br>
																				<img src="" width="1" height="2"><br><font color="313D7D">
																				&nbsp;* 다시한번 입력해 주세요.</font></td>
																		</tr>
																		<tr> 
																			<td width="158" height="1" bgcolor="c0bebe"></td>
																			<td width="222" height="1" bgcolor="D2D2D2"></td>
																			<td width="160" height="1" bgcolor="c0bebe"></td>
																			<td width="220" height="1" bgcolor="D2D2D2"></td>
																		</tr>
																	</table>
																</td>
															</tr>
															<!-- 옵션항목 부분 ----------------->
<? // include "optionod_modify.php"; ?>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="15" bgcolor="FFFFFF"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="1" cellpadding="0">
															<tr> 
																<td align="center">
																	<!-- 접근권한(수정) -->
<? 
		if($row_admin[superLevel]==5 || $row_admin[superLevel]==9) { 
?>
																	<input type="image" src="../odimages/odmain/btn_ok.gif" width="77" height="24" hspace="3" border="0" onfocus='this.blur();'> 
<? 
		}
		else { 
?>
																	<a href='javascript:reject();' onfocus='this.blur();'><img src="../odimages/odmain/btn_ok.gif" width="77" height="24" hspace="3" border="0"></a> 
<? 
		} 
?>
																	<a onclick="reset();" onfocus='this.blur();' style='cursor:hand;'><img src="../odimages/odmain/btn_cancel.gif" width="77" height="24" hspace="3" border="0"></a>
																	<a href="od_list.php?page=<?=$page?>&search=<?=$search?>&key=<?=$key?>" onfocus='this.blur();'><img src="../odimages/btn_list.gif" hspace="3" border="0"></a></td>
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
	else if(!strcmp($form,"accessForm")) {
		$row = mysql_fetch_array(mysql_query("SELECT * FROM odtMember WHERE serialnum='$serialnum'"));
		
		$email = addslashes(trim($email));
		
		if(!$passwd) {
			$passwd = $row[passwd];
			$repasswd = $row[repasswd];
		}
		else {
			$repasswd = $passwd;

			if(!ereg("[[:alnum:]+]{4,12}",$passwd)) {
				error_msgback_user('비밀번호는 4자이상 12자이하 영문, 숫자 또는 영문/숫자 조합이어야 합니다.   ');
			}

			$result = mysql_query("SELECT password('$passwd')");
			$passwd = mysql_result($result,0,0);
		}

		if(!$recomid) $recomid = $row[recomid];
		if(!$calendar) $calendar = $row[calendar];
		if(!$birthy) $birthy = $row[birthy];
		if(!$birthm) $birthm = $row[birthm];
		if(!$birthd) $birthd = $row[birthd];
		if(!$interest) $interest = $row[interest];
		if(!$marriage) $marriage = $row[marriage];
		if(!$weddingy) $weddingy = $row[weddingy];
		if(!$weddingm) $weddingm = $row[weddingm];
		if(!$weddingd) $weddingd = $row[weddingd];
		if(!$finalsch) $finalsch = $row[finalsch];
		if(!$oname) $oname = $row[oname];
		if(!$ozip1) $ozip1 = $row[ozip1];
		if(!$ozip2) $ozip2 = $row[ozip2];
		if(!$oaddress) $oaddress = $row[oaddress];
		if(!$oaddress1) $oaddress1 = $row[oaddress1];
		if(!$otel1) $otel1 = $row[otel1];
		if(!$otel2) $otel2 = $row[otel2];
		if(!$otel3) $otel3 = $row[otel3];
		if(!$ofax1) $ofax1 = $row[ofax1];
		if(!$ofax2) $ofax2 = $row[ofax2];
		if(!$ofax3) $ofax3 = $row[ofax3];
		if(!$odept) $odept = $row[odept];
		if(!$opost) $opost = $row[opost];
		if(!$mincome) $mincome = $row[mincome];
		if(!$course) $course = $row[course];
		if(!$action) $action = $row[action];
		
		$result = mysql_query("UPDATE odtMember SET passwd='$passwd',repasswd='$repasswd',email='$email',zip1='$zip1',zip2='$zip2',address='$address',address1='$address1',tel1='$tel1',tel2='$tel2',tel3='$tel3',htel1='$htel1',htel2='$htel2',htel3='$htel3',job='$job',mailling='$mailling',recomid='$recomid',calendar='$calendar',birthy='$birthy',birthm='$birthm',birthd='$birthd',interest='$interest',marriage='$marriage',weddingy='$weddingy',weddingm='$weddingm',weddingd='$weddingd',finalsch='$finalsch',oname='$oname',ozip1='$ozip1',ozip2='$ozip2',oaddress='$oaddress',oaddress1='$oaddress1',otel1='$otel1',otel2='$otel2',otel3='$otel3',ofax1='$ofax1',ofax2='$ofax2',ofax3='$ofax3',odept='$odept',opost='$opost',mincome='$mincome',course='$course',point='$point',Mlevel='$Mlevel',action='$action' , sms='$sms' WHERE serialnum='$serialnum'");
		
		if($result) {
			error_msgloc("od_list.php","수정이 잘 되었습니다.   ");
		}
		else {
			error_msgback_user("수정되지 않았습니다.   ");
		}
	}
	else {
		echo "<div align='center' class='fes'><br><br><br><br><font color='red'>허용되지 않은 접근 방식입니다.</font></div>";
		exit;
	}
?>
