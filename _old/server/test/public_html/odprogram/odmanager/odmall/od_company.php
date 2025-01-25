<?
	include "../../odcommon/od_config.inc.php";
	include "../odcommon/od_function.inc.php";	
	include "../odcommon/od_adminAuthority.inc.php";
	include "../odcommon/od_head.inc.php";
	include "../odcommon/od_body.inc.php";

	## 세부권한 체크
	if($row_admin[basicLevel] < 3) {
		error_msgloc("../","접근권한이 없습니다.   ");
	}
	
	## 세부권한 체크(수정)
	if($row_admin[basicLevel]==5 || $row_admin[superLevel]==9) {
		$modifyTemp1 = "<input type='image' src='../odimages/odmain/btn_ok.gif' width='77' height='24' hspace='3' style='cursor:hand;' onfocus='this.blur();'>";
	}
	else {
		$modifyTemp1 = "<a href='javascript:reject();' onfocus='this.blur();'><img src='../odimages/odmain/btn_ok.gif' width='77' height='24' hspace='3' border='0'></a>";
	}
	
	if(!$form) {
		$row = mysql_fetch_array(mysql_query("SELECT * FROM odtCompany WHERE serialnum='1'"));
		$tel_division = explode("-",$row[tel]);
		$htel_division = explode("-",$row[htel]);
		$fax_division = explode("-",$row[fax]);
?>
		<script language="javascript">
			function valueCheck(form) {
				var form = document.modForm;
				if(!form.homepage.value) {
					alert("상점 URL(도메인)을 입력해 주세요.   ");
					form.homepage.focus();
					return false;
				}
			//	if(form.MaPassWD.value) {
			//		if(form.MaPassWD.value != form.MaRePassWD.value) {
			//			window.alert("비밀번호가 일치하지 않습니다.   \n\n정확하게 입력하셔야 합니다.   ");
			//			form.MaRePassWD.focus();
			//			return false;
			//		}
			//	}
			}
			function reSize(formname,size) {
				if(size == 'reset') {
					formname.rows = 7;
				}else{
					var value = formname.rows+size;
					if(value>0) formname.rows = value
					else return;
				}
			}
			function reSize1(formname,size) {
				if(size == 'reset') {
					formname.rows = 15;
				}else{
					var value = formname.rows+size;
					if(value>0) formname.rows = value
					else return;
				}
			}
			function view(what) {
				var imgwin = window.open("",'WIN','scrollbars=no,status=no,toolbar=no,resizable=1,location=no,menu=no,width=1,height=1');
				imgwin.focus();
				imgwin.document.open();
				imgwin.document.write("<html>\n");
				imgwin.document.write("<head>\n");
				imgwin.document.write("<title>"+what+"</title>\n");
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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 상점 기본관리 &gt; <span class="st"><?=$row_company[name]?> 회사 정보관리</span></font></td>
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
													<td height="18" valign="bottom"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5"><b><?=$row_company[name]?></b> 회사 기본정보를 설정합니다.</font></td>
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
												<tr> 
													<td width="760" valign="top">
															<form name="modForm" method="post" action="<?=$php_self?>" enctype="multipart/form-data" onSubmit="return valueCheck(this)">
																<input type="hidden" name="form" value="modifyForm">
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<!-- form start ------------------------------------------>

															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5" colspan="3"></td>
															</tr>
															<tr> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">상점 URL 설정</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;" colspan="3"> 
																	&nbsp;<input name="homepage" type="text" class="border" size="85" value="<?=$row[homepage]?>"><br>
																	<img src="" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 고객님의 상점에 대한 도메인을 설정 합니다.</font>
																</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>

															<tr> 
																<td height="7" bgcolor="FFFFFF" colspan="4"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5" colspan="3"></td>
															</tr>
															<tr> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">개인정보책임자</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;" colspan="3"> 
																	&nbsp;<input name="name1" type="text" class="border" size="20" value="<?=$row[name1]?>"><br>
																	<img src="" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 실질적인 상점 운영자 이름을 입력합니다.</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF" colspan="4"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5" colspan="3"></td>
															</tr>
															<!--
															<tr> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">관리자모드 아이디</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;" colspan="3"> 
																	&nbsp;<input name="ManagerID" type="text" class="border" size="20" value="<?=$row[ManagerID]?>"><br>
																	<img src="" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 관리자모드 로그인시 사용하실 아이디를 설정합니다.</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF" colspan="4"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">관리자모드 비밀번호</td>
																<td width="230" bgcolor="FAFAFA" style="padding:5px;">
																	&nbsp;<input type="password" name="MaPassWD" class="border" size="15"><br>
																	<img src="blank.gif" width="1" height="3"><br>
																	&nbsp;<font color="313D7D">* 관리자모드 로그인시 사용할 비밀번호</font></td>
																<td width="120" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">비밀번호 확인</td>
																<td width="230" bgcolor="FAFAFA" style="padding:5px;">
																	&nbsp;<input type="password" name="MaRePassWD" class="border" size="15"><br>
																	<img src="blank.gif" width="1" height="3"><br>
																	&nbsp;<font color="313D7D">* 비밀번호 확인</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF" colspan="4"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5" colspan="3"></td>
															</tr>
															-->
															<tr> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">통신판매업신고번호</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;" colspan="3"> 
																	&nbsp;<input name="number2" type="text" class="border" size="20" value="<?=$row[number2]?>"><br>
																	<img src="http://114.207.246.247/a" width="1" height="0"><br><font color="313D7D">
																	&nbsp;* 고객님 상점에 대한 통신판매업신고번호를 설정 합니다. (예: 마포통신 제0000호)</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF" colspan="4"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5" colspan="3"></td>
															</tr>
															<tr> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">상점 주소</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;" colspan="3"> 
																	&nbsp;<input name="address" type="text" class="border" size="65" value="<?=$row[address]?>"><br>
																	<img src="" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 반품/교환 등에 사용하실 고객님의 상점 주소를 설정 합니다.</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF" colspan="4"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
															<td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">전화번호 <?help_pop("고객에게 문자가 발송될때 발신번호로 찍힐 번호입니다.")?></td>
															<td width="230" bgcolor="FAFAFA" style="padding:5px;">
																&nbsp;<input type="text" name="tel1" class="border" size="6" maxlength="4" value="<?=$tel_division[0]?>"> - 
																<input type="text" name="tel2" class="border" size="6" maxlength="4" value="<?=$tel_division[1]?>"> - 
																<input type="text" name="tel3" class="border" size="6" maxlength="4" value="<?=$tel_division[2]?>"><br>
																<img src="blank.gif" width="1" height="3"><br>
																&nbsp;<font color="313D7D">* 상점 전화번호 설정</font></td>
															<td width="120" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">팩스번호</td>
															<td width="230" bgcolor="FAFAFA" style="padding:5px;">
																&nbsp;<input type="text" name="fax1" class="border" size="6" maxlength="4" value="<?=$fax_division[0]?>"> - 
																<input type="text" name="fax2" class="border" size="6" maxlength="4" value="<?=$fax_division[1]?>"> - 
																<input type="text" name="fax3" class="border" size="6" maxlength="4" value="<?=$fax_division[2]?>"><br>
																<img src="blank.gif" width="1" height="3"><br>
																&nbsp;<font color="313D7D">* 상점 팩스번호 설정</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF" colspan="4"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5" colspan="3"></td>
															</tr>
															<tr> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">대표 휴대폰번호 <?help_pop("주문이나 문의시 이 핸드폰번호로 문자가 발송됩니다.")?></td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;" colspan="3"> 
																	&nbsp;<input type="text" name="htel1" class="border" size="6" maxlength="4" value="<?=$htel_division[0]?>"> - 
																	<input type="text" name="htel2" class="border" size="6" maxlength="4" value="<?=$htel_division[1]?>"> - 
																	<input type="text" name="htel3" class="border" size="6" maxlength="4" value="<?=$htel_division[2]?>"><br>
																	<img src="" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 주문접수 등의 SMS 수신을 위한 회사 대표 핸드폰 번호를 설정 합니다.</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF" colspan="4"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5" colspan="3"></td>
															</tr>
															<tr> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">대표 E-mail</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;" colspan="3"> 
																  &nbsp;<input name="email" type="text" class="border" size="55" value="<?=$row[email]?>"><br>
																  <img src="" width="1" height="3"><br><font color="313D7D">
																  &nbsp;* 주문내역/회원가입 등 상점에서 대표로 사용하실 E-mail을 설정 합니다.</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF" colspan="4"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5" colspan="3"></td>
															</tr>
															<tr> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">상점 타이틀(제목)</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;" colspan="3"> 
																  &nbsp;<input name="homepage_title" type="text" class="border" size="85" value="<?=$row[homepage_title]?>"><br>
																  <img src="" width="1" height="3"><br><font color="313D7D">
																  &nbsp;* 인터넷 익스플로러 상단에 표시되어질 상점의 타이틀을 설정 합니다.</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF" colspan="4"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5" colspan="3"></td>
															</tr>
															<tr> 
																<td width="165" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">META 태그 설정</td>
																<td bgcolor="FAFAFA" style="padding:5px;" colspan="3"> 
																	<table width="99%" border="0" cellspacing="0" cellpadding="0" class="text-2">
																		<tr>
																			<td width="402">&nbsp;</td>
																			<td width="5"></td>
																			<td width="63">
																			<a href="javascript:reSize(document.modForm.metatag,5)">
																			<img src="../odimages/button_plus.gif" width="58" height="20" border="0"></a></td>
																			<td width="72">
																			<a href="javascript:reSize(document.modForm.metatag,'reset')">
																			<img src="../odimages/button_reset.gif" width="67" height="20" border="0"></a></td>
																			<td width="63">
																			<a href="javascript:reSize(document.modForm.metatag,-5)">
																			<img src="../odimages/button_minus.gif" width="58" height="20" border="0"></a></td>
																		</tr>
																		<tr>
																			<td colspan="5" height="3"></td>
																		</tr>
																		<tr>
																			<td colspan="5">
																			&nbsp;<textarea name="metatag" class="border" rows="7" cols="95"><?=stripslashes($row[metatag])?></textarea></td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF" colspan="4"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="1" cellpadding="0">
															<tr> 
																<td align="center">
																	<?=$modifyTemp1?>
																	<a onclick="reset();" onfocus='this.blur();' style='cursor:hand;'><img src="../odimages/odmain/btn_cancel.gif" width="77" height="24" hspace="3" border="0"></a></td>
															</tr>
														</table>
														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="10"><a name="1"></a></td>
															</tr>
														</table>
														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="18"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5"><b>세금계산서</b> 발행정보를 설정합니다.</font></td>
																<td height="18" align="right"><a href="#" onfocus='this.blur();' class='cate'>▲ TOP</a></td>
															</tr>
														</table>
														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="3"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5" colspan="3"></td>
															</tr>
															<tr> 
																<td height="41" width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">사업자등록번호</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;" colspan="3"> 
																	&nbsp;<input name="number1" type="text" class="border" size="35" value="<?=$row[number1]?>"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF" colspan="4"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5" colspan="3"></td>
															</tr>
															<tr> 
																<td height="41" width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">상호명 (법인명)</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;" colspan="3"> 
																	&nbsp;<input name="name" type="text" class="border" size="55" value="<?=$row[name]?>"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF" colspan="4"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5" colspan="3"></td>
															</tr>
															<tr> 
																<td height="41" width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">대표자명</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;" colspan="3"> 
																	&nbsp;<input name="ceoname" type="text" class="border" size="35" value="<?=$row[ceoname]?>"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF" colspan="4"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5" colspan="3"></td>
															</tr>
															<tr> 
																<td height="41" width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">사업장소재지</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;" colspan="3"> 
																	&nbsp;<input name="taxaddress" type="text" class="border" size="75" value="<?=$row[taxaddress]?>"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF" colspan="4"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="41" width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">업 태</td>
																<td width="230" bgcolor="FAFAFA" style="padding:5px;">
																	&nbsp;<input type="text" name="taxstatus" class="border" size="25" value="<?=$row[taxstatus]?>"></td>
																<td width="120" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">종 목</td>
																<td width="230" bgcolor="FAFAFA" style="padding:5px;">
																	&nbsp;<input type="text" name="taxitem" class="border" size="25" value="<?=$row[taxitem]?>"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF" colspan="4"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="1" cellpadding="0">
															<tr> 
																<td align="center">
																	<?=$modifyTemp1?>
																	<a onclick="reset();" onfocus='this.blur();' style='cursor:hand;'><img src="../odimages/odmain/btn_cancel.gif" width="77" height="24" hspace="3" border="0"></a></td>
															</tr>
														</table>
														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="10"><a name="4"></a></td>
															</tr>
														</table>
														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="18"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5"><b>이용약관</b>를 설정합니다.</font></td>
																<td height="18" align="right"><a href="#" onfocus='this.blur();' class='cate'>▲ TOP</a></td>
															</tr>
														</table>
														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="3"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
															<tr> 
																<td width="165" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">이용약관</td>
																<td bgcolor="FAFAFA" style="padding:5px;" colspan="3"> 
																	<table width="99%" border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td width="402">
																			<input type="radio" name="guidetag" value="H" <?if($row[guidetag]=="H") echo"checked";?>> html 작성 
																			<input type="radio" name="guidetag" value="T" <?if($row[guidetag]=="T"||!$row[guidetag]) echo"checked";?>> text 작성</td>
																			<td width="5"></td>
																			<td width="63">
																			<a href="javascript:reSize1(document.modForm.guideinfo,5)">
																			<img src="../odimages/button_plus.gif" width="58" height="20" border="0"></a></td>
																			<td width="72">
																			<a href="javascript:reSize1(document.modForm.guideinfo,'reset')">
																			<img src="../odimages/button_reset.gif" width="67" height="20" border="0"></a></td>
																			<td width="63">
																			<a href="javascript:reSize1(document.modForm.guideinfo,-5)">
																			<img src="../odimages/button_minus.gif" width="58" height="20" border="0"></a></td>
																		</tr>
																		<tr>
																			<td colspan="5" height="3"></td>
																		</tr>
																		<tr>
																			<td colspan="5">
																				&nbsp;<textarea name="guideinfo" class="border" rows="15" cols="95"><?=stripslashes($row[guideinfo])?></textarea></td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF" colspan="4"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="1" cellpadding="0">
															<tr> 
																<td align="center">
																	<?=$modifyTemp1?>
																	<a onclick="reset();" onfocus='this.blur();' style='cursor:hand;'><img src="../odimages/odmain/btn_cancel.gif" width="77" height="24" hspace="3" border="0"></a></td>
															</tr>
														</table>
														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="10"><a name="4"></a></td>
															</tr>
														</table>
														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="18"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5"><b>이용안내</b>를 설정합니다.</font></td>
																<td height="18" align="right"><a href="#" onfocus='this.blur();' class='cate'>▲ TOP</a></td>
															</tr>
														</table>
														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="3"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
															<tr> 
																<td width="165" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">이용안내</td>
																<td bgcolor="FAFAFA" style="padding:5px;" colspan="3"> 
																	<table width="99%" border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td width="402">
																			<input type="radio" name="guide2tag" value="H" <?if($row[guide2tag]=="H") echo"checked";?>> html 작성 
																			<input type="radio" name="guide2tag" value="T" <?if($row[guide2tag]=="T"||!$row[guide2tag]) echo"checked";?>> text 작성</td>
																			<td width="5"></td>
																			<td width="63">
																			<a href="javascript:reSize1(document.modForm.guideinfo,5)">
																			<img src="../odimages/button_plus.gif" width="58" height="20" border="0"></a></td>
																			<td width="72">
																			<a href="javascript:reSize1(document.modForm.guideinfo,'reset')">
																			<img src="../odimages/button_reset.gif" width="67" height="20" border="0"></a></td>
																			<td width="63">
																			<a href="javascript:reSize1(document.modForm.guideinfo,-5)">
																			<img src="../odimages/button_minus.gif" width="58" height="20" border="0"></a></td>
																		</tr>
																		<tr>
																			<td colspan="5" height="3"></td>
																		</tr>
																		<tr>
																			<td colspan="5">
																				&nbsp;<textarea name="guideinfo2" class="border" rows="15" cols="95"><?=stripslashes($row[guideinfo2])?></textarea></td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF" colspan="4"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="1" cellpadding="0">
															<tr> 
																<td align="center">
																	<?=$modifyTemp1?>
																	<a onclick="reset();" onfocus='this.blur();' style='cursor:hand;'><img src="../odimages/odmain/btn_cancel.gif" width="77" height="24" hspace="3" border="0"></a></td>
															</tr>
														</table>
														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="10"><a name="5"></a></td>
															</tr>
														</table>
														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="18"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5"><b>개인정보보호정책</b>을 설정합니다.</font></td>
																<td height="18" align="right"><a href="#" onfocus='this.blur();' class='cate'>▲ TOP</a></td>
															</tr>
														</table>
														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="3"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5" colspan="3"></td>
															</tr>
															<tr> 
																<td width="165" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">개인정보보호정책</td>
																<td bgcolor="FAFAFA" style="padding:5px;" colspan="3"> 
																	<table width="99%" border="0" cellspacing="0" cellpadding="0">
																		<tr>
																		  <td width="402">
																			<input type="radio" name="privacytag" value="H" <?if($row[privacytag]=="H") echo"checked";?>> html 작성 
																			<input type="radio" name="privacytag" value="T" <?if($row[privacytag]=="T"||!$row[privacytag]) echo"checked";?>> text 작성</td>
																		  <td width="5"></td>
																		  <td width="63">
																			<a href="javascript:reSize1(document.modForm.privacyinfo,5)">
																			<img src="../odimages/button_plus.gif" width="58" height="20" border="0"></a></td>
																		  <td width="72">
																			<a href="javascript:reSize1(document.modForm.privacyinfo,'reset')">
																			<img src="../odimages/button_reset.gif" width="67" height="20" border="0"></a></td>
																		  <td width="63">
																			<a href="javascript:reSize1(document.modForm.privacyinfo,-5)">
																			<img src="../odimages/button_minus.gif" width="58" height="20" border="0"></a></td>
																		</tr>
																		<tr>
																		  <td colspan="5" height="3"></td>
																		</tr>
																		<tr>
																		  <td colspan="5">
																			&nbsp;<textarea name="privacyinfo" class="border" rows="15" cols="95"><?=stripslashes($row[privacyinfo])?></textarea></td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF" colspan="4"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="1" cellpadding="0">
															<tr> 
																<td align="center">
																	<?=$modifyTemp1?>
																	<a onclick="reset();" onfocus='this.blur();' style='cursor:hand;'><img src="../odimages/odmain/btn_cancel.gif" width="77" height="24" hspace="3" border="0"></a></td>
															</tr>
														</table>
														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="10"><a name="4"></a></td>
															</tr>
														</table>
														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="18"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5"><b>회사소개</b>를 설정합니다.</font></td>
																<td height="18" align="right"><a href="#" onfocus='this.blur();' class='cate'>▲ TOP</a></td>
															</tr>
														</table>
														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="3"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
															<tr> 
																<td width="165" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">회사소개</td>
																<td bgcolor="FAFAFA" style="padding:5px;" colspan="3"> 
																	<table width="99%" border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td colspan="5">
																				&nbsp;<textarea name="comInfo" class="border" rows="15" cols="95" geditor><?=stripslashes($row[comInfo])?></textarea></td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2" colspan="3"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF" colspan="4"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="1" cellpadding="0">
															<tr> 
																<td align="center">
																	<?=$modifyTemp1?>
																	<a onclick="reset();" onfocus='this.blur();' style='cursor:hand;'><img src="../odimages/odmain/btn_cancel.gif" width="77" height="24" hspace="3" border="0"></a></td>
															</tr>
														</table>
															</form>
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
<? include "../odcommon/od_bottom.inc.php"; ?>
					<!-- bottom end -->
				</td>
			</tr>
		</table>

		<script language="Javascript" src="/odprogram/geditor/geditor.js"></script>
	</body>
</html>
<?
	}
	else if(!strcmp($form,"modifyForm")) {
		## upload path
		$company_upload_path = "$folderpath_upload_root/odcompany";
		
		## info1 ###############################################################
		if(!$info1) $info1 = "none";
		if($info1 != "none") {
			move_uploaded_file($info1,"$company_upload_path/$info1_name");
			rename("$company_upload_path/$info1_name","$company_upload_path/i1.jpg");
		}
		## contactus1 ###############################################################
		if(!$contactus1) $contactus1 = "none";
		if($contactus1 != "none") {
			move_uploaded_file($contactus1,"$company_upload_path/$contactus1_name");
			rename("$company_upload_path/$contactus1_name","$company_upload_path/c1.jpg");
		}
		
		if(!$MaPassWD) {
			$pw_row = mysql_fetch_array(mysql_query("SELECT MaPassWD, MaRePassWD FROM odtCompany WHERE serialnum='1'"));
			$MaPassWD = $pw_row[MaPassWD];
			$MaRePassWD = $pw_row[MaRePassWD];
		}
		else {
			## 입력한 비밀번호를 암호화한다. ###########
			$result = mysql_query("SELECT password('$MaPassWD')");
			$MaPassWD = mysql_result($result,0,0);
			$MaRePassWD = $MaRePassWD;
		}
		
		$name = addslashes(trim($name));
		$ceoname = addslashes(trim($ceoname));
		$taxaddress = addslashes(trim($taxaddress));
		$taxstatus = addslashes(trim($taxstatus));
		$taxitem = addslashes(trim($taxitem));
		$name1 = addslashes(trim($name1));
		$address = addslashes(trim($address));
		$homepage_title = addslashes(trim($homepage_title));
		$metatag = addslashes(trim($metatag));
		$information = addslashes(trim($information));
		$contactus = addslashes(trim($contactus));
		$guideinfo = addslashes(trim($guideinfo));
		$privacyinfo = addslashes(trim($privacyinfo));
		$tel = $tel1."-".$tel2."-".$tel3;
		$htel = $htel1."-".$htel2."-".$htel3;
		$fax = $fax1."-".$fax2."-".$fax3;
		$modifydate = time();
		
		$whois_day = trim($whois_day);

		$result = mysql_query("UPDATE odtCompany SET ManagerID='$ManagerID',MaPassWD='$MaPassWD',MaRePassWD='$MaRePassWD',name='$name',ceoname='$ceoname',taxaddress='$taxaddress',taxstatus='$taxstatus',taxitem='$taxitem',name1='$name1',address='$address',tel='$tel',htel='$htel',fax='$fax',email='$email',homepage_title='$homepage_title',homepage='$homepage', whois_day='$whois_day',metatag='$metatag',number1='$number1',number2='$number2',informationtag='$informationtag',information='$information',contactustag='$contactustag',contactus='$contactus',guidetag='$guidetag',guideinfo='$guideinfo',guideinfo2='$guideinfo2',comInfo='$comInfo',privacytag='$privacytag',privacyinfo='$privacyinfo',modifydate='$modifydate' WHERE serialnum='1'");
		
		if($result) {
			echo "
				<script>
					window.alert('수정이 잘 되었습니다.   ');
				</script>";

			echo "<meta http-equiv='Refresh' content='0; URL=od_company.php'>";
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