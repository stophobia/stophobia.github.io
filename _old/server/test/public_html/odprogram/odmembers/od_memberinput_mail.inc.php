<?
	$ManagerMailheaders = "From: $name <$email> \n"; 
	$ManagerMailheaders .= "Content-Type: text/html; charset=euc-kr";
	
	$UserMailheaders = "From: [$row_company[name]] <$row_company[email]> \n"; 
	$UserMailheaders .= "Content-Type: text/html; charset=euc-kr";
	
	$ManagerName = "[$row_company[name]] <$row_company[email]>";
	$UserName = $name."님 <$email>";
	
	$ManagerTitle = "[$name]님이 $row_company[name] 회원으로 가입했습니다.";
	$UserTitle = $name."님의 $row_company[name] 회원가입을 축하드립니다.";
	
	$ManagerBody = "
		<font color ='blue' size='2'><b>$name</b></font><font size='2'>님께서 회원으로 가입 하셨습니다.<br><br>
		<a href='$path_home/odmanager/' target='_blank'>관리자모드</a></font>";

	$UserBody = "
<html>
	<head>
		<title>회원가입축하메일</title>
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
											<img src='$folderpath_upload/odmail/cong_title.gif' width='486' height='86'></td>
									</tr>
								</table>
								<table width='380' border='0' cellspacing='1' cellpadding='0'>
									<tr> 
										<td height='30'>&nbsp;</td>
									</tr>
									<tr> 
										<td style='line-height:180%'>
											<strong>$name</strong>님께서는 <font color='FF4E26'>$row_company[name]</font> 회원으로 가입이 되셨습니다.<br>
											저희 <font color='FF4E26'>$row_company[name]</font> 이용을 감사드리며<br>
											앞으로도 고객님들의 편의를 위해 항상 노력하겠습니다.<br>
											회원님께서 가입해주신 아이디 및 비밀번호는 아래와 같습니다.</td>
									</tr>
									<tr> 
										<td height='20'>&nbsp;</td>
									</tr>
								</table>
								<table border='0' cellspacing='0' cellpadding='0'>
									<tr> 
										<td><img src='$path_home/odimages/odmail/cong_piece01.gif' width='380' height='8'></td>
									</tr>
									<tr> 
										<td height='64' align='center' bgcolor='F4F4F4'>
											<table border='0' cellspacing='0' cellpadding='0'>
												<tr> 
													<td width='75' height='24'><img src='$path_home/odimages/odmail/cong_icon.gif' width='14' height='9'>이&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;름 :</td>
													<td><strong>$name</strong></td>
												</tr>
												<tr> 
													<td height='24'><img src='$path_home/odimages/odmail/cong_icon.gif' width='14' height='9'>아<img src='blank.gif' width='6' height='1'>이<img src='blank.gif' width='6' height='1'>디 :</td>
													<td><strong>$id</strong></td>
												</tr>
												<tr> 
													<td height='24'><img src='$path_home/odimages/odmail/cong_icon.gif' width='14' height='9'>비밀번호 :</td>
													<td><strong>".substr($repasswd,0,strlen($repasswd)-3)."*****</strong></td>
												</tr>
											</table>
										</td>
									</tr>
									<tr> 
										<td><img src='$path_home/odimages/odmail/cong_piece02.gif' width='380' height='8'></td>
									</tr>
								</table>
								<table width='380' border='0' cellspacing='1' cellpadding='0'>
									<tr> 
										<td height='40' align='right'>
											<a href='$path_domain/' target='_blank'><img src='$path_home/odimages/odmail/btn_gohome.gif' width='119' height='21' border='0'></a></td>
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

	$ManagerName				= iconv("utf-8","euckr",$ManagerName);
	$ManagerTitle				= iconv("utf-8","euckr",$ManagerTitle);
	$ManagerBody				= iconv("utf-8","euckr",$ManagerBody);
	$ManagerMailheaders	= iconv("utf-8","euckr",$ManagerMailheaders);
#	mail($ManagerName,$ManagerTitle,$ManagerBody,$ManagerMailheaders);

	$UserName						= iconv("utf-8","euckr",$UserName);
	$UserTitle					= iconv("utf-8","euckr",$UserTitle);
	$UserBody						= iconv("utf-8","euckr",$UserBody);
	$UserMailheaders		= iconv("utf-8","euckr",$UserMailheaders);
	mail($UserName,$UserTitle,$UserBody,$UserMailheaders);
?>