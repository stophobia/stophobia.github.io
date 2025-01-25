<?
	include "../odcommon/od_config.inc.php";
	include "../odcommon/od_function.inc.php";
    include "./COkname.php";

	if(!strcmp($Form,"")) {

if ( $row_setup[nauthen_use] == "yes" && $row_setup[ipin_use] == "yes" ) {
    ##아이핀사용을 위한 인증키 조회
    $sSiteID = $row_setup[nauthen_id2];  	// 사이트 id(KCB)
    $KCB = new COkName($sSiteID);
    $KCB->Set_qryRsnCd("05");   //회원정보조회용 사유코드 05는 기타
    $KCB->Exec_Ipin();    //아이핀사인키실행
    $KCB->Set_RetURL("http://".$_SERVER[HTTP_HOST]."/odprogram/odmembers/kcb_IpinResultSearch.php");   //return Page
    $KCB->Make_Inform();  //아이핀 인증데이터 폼(ReturnURL 이 설정된 후에 실행해야함)
    $KCB->Make_RunScript();  //아이인 실행 스크립트생성
}
?>
<html>
	<head>
		<title>아이디/비밀번호 찾기</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href="/css/style.css" rel="stylesheet" type="text/css">
		<script language="javascript">
			function IsNumber(formname) {
				var form = eval("document.confirmform." + formname);
				for(var i = 0; i < form.value.length; i++) {
					var chr = form.value.substr(i,1);
					if(chr < '0' || chr > '9') {            
						return false;
					}
				}
				return true;   
			}
			function CheckFORM() {
				var form = document.confirmform; 
				if(!form.name.value) {
					alert("고객님의 이름을 입력해 주셔야 합니다.   ");
					form.name.focus();
					return false;
				}
				if(form.resinum1.value) {
					if (!IsNumber(form.resinum1.name)) {
						alert("주민번호는 숫자로 입력해 주셔야 합니다.   ");
						form.resinum1.focus();
						return false;
					}
				}else {
					alert("고객님의 주민번호를 입력해 주셔야 합니다.   ");
					form.resinum1.focus();
					return false;
				}
				if(form.resinum2.value) {
					if(!IsNumber(form.resinum2.name)) {
						alert("주민번호는 숫자로 입력해 주셔야 합니다.   ");
						form.resinum2.focus();
						return false;
					}
				}else {
					alert("고객님의 주민번호를 입력해 주셔야 합니다.   ");
					form.resinum2.focus();
					return false;
				}
				if(!form.email.value) {
					alert("고객님의 전자우편 주소를 입력해 주셔야 합니다.   ");
					form.email.focus();
					return false;
				}
			}
		</script>
	</head>
	<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0">


	<table border=0 cellpadding=0 cellspacing=0 width=100% height=100%>
		<tr>
			<td background="/img/popup_img_01.jpg" height=49><table width=100%  height=49 border=0 cellpadding=0 cellspacing=0>
				<tr>
					<td width=50% height=49 style="padding-left:11px"><img src="/img/popup_img_05.jpg" border=0></td>
					<td width=50% height=49 style="padding-right:7px" align=right><a href="#none" onclick="self.close()"><img src="/img/popup_img_03.jpg" border=0></a></td>
				</tr>
			</table></td>
		</tr>
		<tr>
			<td width=100% height=100% ><table width=100% height=100% border=0 cellpadding=0 cellspacing=0>
				<tr>
					<td width=100% height=100% align=center>
					<!-- 내용 시작 -->


					<table width="330" border="0" cellspacing="1" cellpadding="0">
						<tr> 
							<td width="10" height="60" align="center" class="cate"><img src="../odimages/odmypage/icon_oranarrow.gif" width="10" height="11" align="absmiddle"><br> <br> <br>
							</td>
							<td class="locat">
								아래 사항을 기입해 주시면 회원님의 이메일로<br>아이디와 패스워드를 보내드립니다.<br><b>
<?
if ( $row_setup[nauthen_use] == "yes" && $row_setup[ipin_use] == "yes" ) {
    echo "아이핀사용자는 아이핀 확인을 하시기 바랍니다.";
} else {
    echo "<p>";
}
?></b></td>
						</tr>
					</table>
					<!-- form start -->
					<table width="330" border="0" cellspacing="0" cellpadding="0">
						<form name="confirmform" method="post" action="od_membersearch.php" onsubmit="return CheckFORM(this)">
							<input type="hidden" name="Form" value="MemSearchForm">
							<input type="hidden" name="ipinuser" value="0">
							<input type="hidden" name="kcb_dupinfo" value="0">

						<tr> 
							<td width="2" height="2"><img src="../odimages/odorder/orderw_p01.gif" width="2" height="2"></td>
							<td height="2" background="../odimages/odorder/orderw_pbg1.gif"></td>
							<td width="2" height="2"><img src="../odimages/odorder/orderw_p02.gif" width="2" height="2"></td>
						</tr>
						<tr> 
							<td width="2" background="../odimages/odorder/orderw_pbg4.gif"></td>
							<td align="center" style="padding:15px;">




								<table width="260" border="0" cellpadding="0" cellspacing="0">
									<tr> 
										<td width="65" height="32" class="cate"><img src="../odimages/odshop/icon_dot2.gif" width="8" height="11">이 름</td>
										<td width="15">:</td>
										<td>
											<input name="name" type="text" class="gray" size="23" style="width:124px"></td>
									</tr>
									<tr > 
										<td height="1" colspan="3" background="../odimages/odorder/dot_w.gif"></td>
									</tr>
									<tr> 
										<td height="32" class="cate"><img src="../odimages/odshop/icon_dot2.gif" width="8" height="11">주민번호</td>
										<td>:</td>
										<td>
											<input name="resinum1" type="text" class="gray" style="width:50px"> - 
											<input name="resinum2" type="password" class="gray" style="width:60px"> 
										</td>
									</tr>
									<tr> 
										<td height="1" colspan="3" background="../odimages/odorder/dot_w.gif"></td>
									</tr>
									<tr> 
										<td height="32" class="cate"><img src="../odimages/odshop/icon_dot2.gif" width="8" height="11">전자우편</td>
										<td>:</td>
										<td>
											<input name="email" type="text" class="gray" size="23" style="width:124px"></td>
									</tr>

<? if ( $row_setup[nauthen_use] == "yes" && $row_setup[ipin_use] == "yes" ) {
echo "<tr > 
										<td height='1' colspan='3' background='../odimages/odorder/dot_w.gif'></td>
									</tr>	

									<tr> 
										<td width='65' height='32' class='cate'><img src='../odimages/odshop/icon_dot2.gif' width='8' height='11'>아이핀</td>
										<td width='15'>:</td>
										<td>
											<input type='button' onclick='certKCBIpin();' value='아이핀확인' width='58' height='26' hspace='3'></td>
									</tr>";
}
?>
																	
									
								</table>

							</td>
							<td background="../odimages/odorder/orderw_pbg2.gif"></td>
						</tr>
						<tr> 
							<td width="2" height="2"><img src="../odimages/odorder/orderw_p04.gif" width="2" height="2"></td>
							<td height="2" background="../odimages/odorder/orderw_pbg3.gif"></td>
							<td width="2" height="2"><img src="../odimages/odorder/orderw_p03.gif" width="2" height="2"></td>
						</tr>
					</table>
					<table width="330" border="0" cellspacing="0" cellpadding="0">
						<tr> 
							<td height="50" align="center"><input type="image" src="../odimages/odshop/btn_ok.gif" width="58" height="26" hspace="3"></td>
						</tr>
						</form>
					</table>
					<!-- 내용 끝 -->
					</td>
				</tr>
			</table></td>
		</tr>
    <tr>
      <td height="6" bgcolor="#aaa698"></td>
    </tr>
	</table>
	</body>
</html>

<?
	}
	else if(!strcmp($Form,"MemSearchForm")) {
		$resinum = md5($resinum1.$resinum2);

        if ( $ipinuser == "1" ) {   //아이핀사용자는 다른데이터를 사용한다.
    		$result = mysql_query("SELECT id,repasswd,name,email FROM odtMember WHERE kcb_dupinfo='$kcb_dupinfo' and email='$email'");
        } else {
    		$result = mysql_query("SELECT id,repasswd,name,email FROM odtMember WHERE name='$name' AND resinum='$resinum' AND email='$email'");
        }
		
		if(!$result || !$rows = mysql_num_rows($result)) { 
			error_msgback_user('입력하신 정보가 일치하지 않습니다.   '); 
		}

		$row = mysql_fetch_object($result);
		
		$MemID = $row->id;
		$SIDPASSWD = $row->repasswd;
		$MemName = $row->name;
		$MemEmail = $row->email;
		## 메일발송부분 시작 ##################################################################
		$mailheaders = "From: [$row_company[name]]<".mysql_result(mysql_query("select email from odtMember where id='admin'"),0)."> \n"; 
		$mailheaders .= "Content-Type: text/html; charset=euc-kr";
		
		$to = "$MemName <$MemEmail>";
		
		$title = "[$MemName]님께서 문의하신 아이디 및 비밀번호 입니다.";
		
		$body = "
<html>
	<head>
		<title>아이디/비밀번호 안내메일</title>
		<meta http-equiv='Content-Type' content='text/html; charset=euc-kr'>
		<style>
			td{font-size:12px;color:4C4C4C;line-height:150%}
		</style>
	</head>
	<body bgcolor='#FFFFFF' leftmargin='10' topmargin='10'>
		<table width='500' border='0' align='center' cellpadding='0' cellspacing='0'>
			<tr> 
				<td>
					<!-- 로고이미지 -->
					<img src='$folderpath_upload/odmail/logo.gif' width='164' height='50' hspace='5'></td>
			</tr>
			<tr> 
				<td>
					<table width='500' border='0' cellpadding='1' cellspacing='6' bgcolor='E5E5E5'>
						<tr> 
							<td align='center' bgcolor='#FFFFFF'>
								<table border='0' cellspacing='1' cellpadding='0'>
									<tr> 
										<td>
											<!-- 타이틀 이미지 (가로 611 X 세로 86) -->
											<img src='$folderpath_upload/odmail/pass_title.gif' width='486' height='86'></td>
									</tr>
								</table>
								<table width='380' border='0' cellspacing='1' cellpadding='0'>
									<tr> 
										<td height='30'>&nbsp;</td>
									</tr>
									<tr> 
										<td>
											<b>$MemName</b> 회원님께서 요청하신 아이디와 비밀번호입니다.</td>
									</tr>
									<tr> 
										<td height='20'>&nbsp;</td>
									</tr>
								</table>
								<table border='0' cellspacing='0' cellpadding='0'>
									<tr> 
										<td><img src='$folderpath_upload/odmail/cong_piece01.gif' width='380' height='8'></td>
									</tr>
									<tr> 
										<td height='64' align='center' bgcolor='F4F4F4'>
											<table border='0' cellspacing='0' cellpadding='0'>
												<tr> 
													<td width='75' height='24'><img src='$folderpath_upload/odmail/cong_icon.gif' width='14' height='9'>아<img src='blank.gif' width='6' height='1'>이<img src='blank.gif' width='6' height='1'>디 :</td>
													<td><strong>".substr($MemID,0,strlen($MemID)-2)."**</strong></td>
												</tr>
												<tr> 
													<td height='24'><img src='$folderpath_upload/odmail/cong_icon.gif' width='14' height='9'>비밀번호 :</td>
													<td><strong>".substr($SIDPASSWD,0,strlen($SIDPASSWD)-2)."**</strong></td>
												</tr>
											</table><br><br>
											회원님의 정보보호를 위해 일부는 **로 표기됩니다.<br>
											**를 모르실경우에는 고객센터 ".$row_company[tel]."로 문의주시기 바랍니다.
										</td>
									</tr>
									<tr> 
										<td><img src='$folderpath_upload/odmail/cong_piece02.gif' width='380' height='8'></td>
									</tr>
								</table>
								<table width='380' border='0' cellspacing='1' cellpadding='0'>
									<tr> 
										<td height='40' align='right'>
											<a href='$path_home/' target='_blank'><img src='$folderpath_upload/odmail/btn_gohome.gif' width='119' height='21' border='0'></a></td>
									</tr>
									<tr> 
										<td height='25'>&nbsp;</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr> 
				<td height='22' align='center' style='font-size:11px;'>Copyright ⓒ <b>$row_company[name]</b> All rights reserved.</td>
			</tr>
		</table>
	</body>
</html>";

		$to						=	iconv("utf-8","euckr",$to);
		$title				=	iconv("utf-8","euckr",$title);
		$body					=	iconv("utf-8","euckr",$body);
		$mailheaders	=	iconv("utf-8","euckr",$mailheaders);

		mail($to,$title,$body,$mailheaders);
		
		echo "
			<script>
				window.alert('[$MemName]님의 아이디와 비밀번호를   \\n\\n메일($MemEmail)로 전송해 드렸습니다.   ');
				window.close();
			</script>";

		exit;
	}
	else {
		exit;
	}
?>