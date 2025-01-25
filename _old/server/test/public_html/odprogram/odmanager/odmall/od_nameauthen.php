<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";

    ##없는필드확인하여서 추가
    include "../../../odprogram/odmembers/COkname.php";
    $KCB = new COkName("test");
    $add_fields = "'ipin_use','recharge','nauthen_id2'";
    $add_fields_type = "varchar(3),varchar(3),varchar(20)";
    $add_fields_value = "no,no,";
    $KCB->Add_Fileds("odtSetup",$add_fields,$add_fields_type,$add_fields_value);

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
		$row = mysql_fetch_array(mysql_query("SELECT nauthen_com, nauthen_id, nauthen_id2, nauthen_pw, nauthen_path, nauthen_use, ipin_use, recharge FROM odtSetup WHERE serialnum='1'"));
?>
			<script>
				function chk_com(form,com){
					if(com=="S"){
						document.all.div_id_s.style.display="block";
						document.all.div_id_k1.style.display="none";
						document.all.div_id_k2.style.display="none";
						document.all.div_id_k3.style.display="none";
					}
					else if(com=="K"){
						document.all.div_id_s.style.display="none";
						document.all.div_id_k1.style.display="block";
						document.all.div_id_k2.style.display="block";
						document.all.div_id_k3.style.display="block";
					}
				}
			</script>

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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 상점 기본관리 &gt; <span class="st">실명인증(i-PIN) 서비스 설정</span></font></td>
												</tr>
												<tr> 
													<td height="2" bgcolor="D6D6D6"></td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="1" cellpadding="0">
												<tr> 
													<td height="11"></td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="18"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5"><b>실명인증(i-PIN) 서비스</b> 환경을 설정 합니다.</font></td>
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
															<!-- form start -------------------->
															<form name="modForm" method="post" action="<?=$php_self?>">
																<input type="hidden" name="form" value="modifyForm">
															<tr> 
																<td width="165" height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
<script>

//실명인증회사 선택시
function changeNametype(value)
{
    if ( value == "S" ) //신용평가정보
    {
        document.getElementById("NametypeS1").style.display="";                
        document.getElementById("NametypeK1").style.display="none";                
        document.getElementById("NametypeS2").style.display="";                
        document.getElementById("NametypeK2").style.display="none";                
        document.getElementById("NametypeS3").style.display="";                

        //하단의 회사정보부분
        document.getElementById("NameDocuS").style.display="";                
        document.getElementById("NameDocuK").style.display="none";            

    } else {
        document.getElementById("NametypeS1").style.display="none";                
        document.getElementById("NametypeK1").style.display="";            
        document.getElementById("NametypeS2").style.display="none";                
        document.getElementById("NametypeK2").style.display="";            
        document.getElementById("NametypeS3").style.display="none";                

        //하단의 회사정보부분
        document.getElementById("NameDocuS").style.display="none";                
        document.getElementById("NameDocuK").style.display="";            
    }
}

</script>

                                            <td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">사용 신용평가정보사</td>
                                            <td bgcolor="FAFAFA" style="padding:5px;"> 
                                                <input type="radio" name="nauthen_com" onClick="changeNametype(this.value);" value="K" <?if($row[nauthen_com]=="K")echo" checked";?>>KCB (코리아크레딧뷰로)
                                                <input type="radio" name="nauthen_com" onClick="changeNametype(this.value);" value="S" <?if($row[nauthen_com]=="S")echo" checked";?>>한국신용평가정보
                                                <img src="" width="1" height="3"><br><font color="313D7D">&nbsp;* 실명인증(i-PIN) 서비스의 계약사를 설정합니다..</font>
                                            </td>

															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="15" bgcolor="FFFFFF" colspan="2"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
<!-- 한국신용평가정보 -->
<tr id ="NametypeS1"> 
    <td bgcolor="ececec" class="white" style="padding:5px;">
        <img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">회원사 ID
    </td>
    <td bgcolor="FAFAFA" style="padding:5px;"> 
    &nbsp;<input name="nauthen_id" type="text" class="border" size="45" value="<?=$row[nauthen_id]?>"><br>
    <img src="" width="1" height="3"><br><font color="313D7D">
    &nbsp;* <b>대문자</b>로 구성되어 있으며, 한국신용평가정보로 부터 부여 받으신 회원사 ID를 설정 합니다.</font>
    </td>
</tr>
<tr id = "NametypeS2">
    <td bgcolor="ececec" class="white" style="padding:5px;">
        <img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">회원사 PW
    </td>
    <td bgcolor="FAFAFA" style="padding:5px;"> 
        &nbsp;<input name="nauthen_pw" type="text" class="border" size="45" value="<?=$row[nauthen_pw]?>"><br>
        <img src="" width="1" height="3"><br><font color="313D7D">
        &nbsp;* <b>숫자</b>로 구성되어 있으며, 한국신용평가정보로 부터 부여 받으신 회원사 암호를 설정 합니다.</font>
    </td>
</tr>
<tr id = "NametypeS3">
    <td bgcolor="ececec" class="white" style="padding:5px;">
        <img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">결제 방식
    </td>
    <td bgcolor="FAFAFA" style="padding:5px;"> 
        <input type="radio" name="recharge" value="yes"<?if($row[recharge]=="yes")echo" checked";?>>충전식
        <input type="radio" name="recharge" value="no"<?if($row[recharge]=="no")echo" checked";?>>정액식<br>
    </td>
</tr>
<!-- //한국신용평가정보 -->

<!-- KCB -->
<tr id = "NametypeK1"> 
    <td bgcolor="ececec" class="white" style="padding:5px;">
        <img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">회원사 ID
    </td>
    <td bgcolor="FAFAFA" style="padding:5px;"> 
    &nbsp;<input name="nauthen_id2" type="text" class="border" size="45" value="<?=$row[nauthen_id2]?>"><br>
    <img src="" width="1" height="3"><br><font color="313D7D">
    &nbsp;* <b>KCB</b>로 부터 부여 받으신 회원사 ID를 설정 합니다.</font>
    </td>
</tr>
<tr id = "NametypeK2"> 
    <td bgcolor="ececec" class="white" style="padding:5px;">
        <img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">I-PIN 사용 여부
    </td>
    <td bgcolor="FAFAFA" style="padding:5px;">
        <input type="radio" name="ipin_use" value="yes"<?if($row[ipin_use]=="yes")echo" checked";?>>사용함
        <input type="radio" name="ipin_use" value="no"<?if($row[ipin_use]=="no")echo" checked";?>>사용하지않음<br>
        <img src="" width="1" height="3"><br><font color="313D7D">&nbsp;
        * <b>아이핀</b>이란 주민등록번호 대체수단으로 인터넷 사이트에 주민등록번호를 입력하지 않고 회원가입을 할 수 있도록 지원합니다. 회원님의 주민등록번호가 저장되지 않습니다.</font>
    </td>
</tr>
<!-- //KCB -->

															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="15" bgcolor="FFFFFF" colspan="2"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">서비스 사용 여부</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	<input type="radio" name="nauthen_use" value="yes"<?if($row[nauthen_use]=="yes")echo" checked";?>>사용함
																	<input type="radio" name="nauthen_use" value="no"<?if($row[nauthen_use]=="no")echo" checked";?>>사용하지않음<br>
																	<img src="" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 실명인증(i-PIN) 서비스의 사용여부를 설정 합니다.</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="15" bgcolor="FFFFFF" colspan="2"></td>
															</tr>
															<tr> 
																<td align="center" colspan="2">
																	<?=$modifyTemp1?>
																	<a onclick="reset();" onfocus='this.blur();' style='cursor:hand;'><img src="../odimages/odmain/btn_cancel.gif" width="77" height="24" hspace="3" border="0"></a></td>
															</tr>
															</form>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="15" bgcolor="FFFFFF"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="1" cellpadding="0" bgcolor="c0bebe" style="padding-left:15px;padding-top:10;padding-bottom:10;">
															<tr id="NameDocuS" style="display:"> 
																<td height="45" bgcolor="FAFAFA">
																	* 실명인증 서비스는 한국신용평가정보(주)에서 제공합니다.<br>
																	<img src="blank.gif" width="1" height="3"><br>
																	* 문의전화 : 02-3771-1588 / namecheck@kisinfo.com </td>
															</tr>
															<tr id="NameDocuk" style="display:none"> 
																<td height="45" bgcolor="FAFAFA">
																	* KCB(코리아크레딧뷰로) ID 등록후 꼭 KCB담당자에게 통보해주세요.<br>
																	<img src="blank.gif" width="1" height="3"><br>
																	* 문의전화 : 김대영 대리 02-708-6083, 오현주 주임 02-708-6079 / FAX : 02-708-606?</td>
															</tr>
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
		$modifydate = time();
		
        $Query = " UPDATE odtSetup SET nauthen_com='$nauthen_com',
                                       nauthen_id='$nauthen_id',
                                       nauthen_id2='$nauthen_id2',
                                       nauthen_pw='$nauthen_pw',
                                       nauthen_path='$nauthen_path',
                                       nauthen_use='$nauthen_use',
                                       modifydate='$modifydate',
                                       ipin_use='$ipin_use' ,
                                       recharge='$recharge' 
                                       WHERE serialnum='1'";

		$result = mysql_query($Query);
		
		if($result) {
			echo "
				<script>
					window.alert('수정되었습니다.   ');
					location.href='od_nameauthen.php';
				</script>";

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
<script>changeNametype('<?=$row[nauthen_com]?>')</script>