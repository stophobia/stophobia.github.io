<?
	##  메일 발송  ##################################################################
	$mailheaders = "From: [$row_company[name]] <$row_company[email]> \n"; 
	$mailheaders .= "Content-Type: text/html; charset=euc-kr";
	
	$to = "$mail_row[ordername] 님 <$mail_row[orderemail]>";
	$title = "[$mail_row[ordername]]님께서 주문하신 상품이 발송되었습니다.($row_company[name])";
	
	$body = "
<html>
	<head>
		<title>주문내역확인 메일</title>
		<meta http-equiv='Content-Type' content='text/html; charset=euc-kr'>
		<style>
			td{font-size:12px;color:4C4C4C;line-height:150%}
		</style>
	</head>
	<body bgcolor='#FFFFFF' leftmargin='10' topmargin='10'>
		<table width='625' border='0' align='center' cellpadding='0' cellspacing='0'>
			<tr> 
				<td>
					<!-- 로고이미지 -->
					<img src='$folderpath_upload/mail/logo.gif' width='164' height='50' hspace='5'></td>
			</tr>
			<tr> 
				<td>
					<table width='625' border='0' cellpadding='1' cellspacing='6' bgcolor='E5E5E5'>
						<tr> 
							<td align='center' bgcolor='#FFFFFF'> 
								<table border='0' cellspacing='1' cellpadding='0'>
									<tr> 
										<td>
											<!-- 타이틀 이미지 (가로 611 X 세로 86) -->
											<img src='$folderpath_upload/mail/delivery_title.gif' width='611' height='86'></td>
									</tr>
								</table>
								<table width='565' border='0' cellspacing='1' cellpadding='0'>
									<tr> 
										<td height='45'>
											<strong>$mail_row[ordername]</strong>님께서 주문하신 상품이 <strong>$expressdate</strong> 발송되었습니다. </td>
									</tr>
								</table>
								<table width='565' border='0' cellspacing='0' cellpadding='0'>
									<tr> 
										<td height='30'><img src='$path_home/images/mail/order_st01.gif'></td>
									</tr>
									<tr> 
										<td height='2' bgcolor='4877C3'></td>
									</tr>
								</table>
								<table width='565' border='0' cellspacing='0' cellpadding='0'>
									<tr> 
										<td width='95' height='28' align='right'>주문번호 :</td>
										<td width='20'>&nbsp;</td>
										<td><b>$mail_row[ordernum]</b></td>
									</tr>
									<tr> 
										<td height='1' colspan='3' bgcolor='EAEAEA'></td>
									</tr>
									<tr> 
										<td height='28' align='right'> 주문자명 :</td>
										<td>&nbsp;</td>
										<td>$mail_row[ordername]</td>
									</tr>
									<tr> 
										<td height='1' colspan='3' bgcolor='EAEAEA'></td>
									</tr>
									<!--
									<tr> 
										<td height='28' align='right'>결제금액 :</td>
										<td>&nbsp;</td>
										<td><strong>".number_format($mail_row[totalprice])."원</strong></td>
									</tr>
									<tr> 
										<td height='1' colspan='3' bgcolor='EAEAEA'></td>
									</tr>
									-->
								</table>
								<table width='565' border='0' cellspacing='0' cellpadding='0'>
									<tr> 
										<td height='26'>&nbsp;</td>
									</tr>
								</table>
								<table width='565' border='0' cellspacing='0' cellpadding='0'>
									<tr> 
										<td height='30'><img src='$path_home/images/mail/order_st05.gif'></td>
									</tr>
									<tr> 
										<td height='2' bgcolor='4877C3'></td>
									</tr>
								</table>
								<table width='565' border='0' cellspacing='0' cellpadding='0'>
									<tr> 
										<td height='28' align='right'> 택배회사 :</td>
										<td>&nbsp;</td>
										<td>$expressnameTmp</td>
									</tr>
									<tr> 
										<td height='1' colspan='3' bgcolor='EAEAEA'></td>
									</tr>
									<tr> 
										<td width='95' height='28' align='right'>택배번호 :</td>
										<td width='20'>&nbsp;</td>
										<td>$expressnumTmp</td>
									</tr>
									<tr> 
										<td height='1' colspan='3' bgcolor='EAEAEA'></td>
									</tr>
									<tr> 
										<td height='28' align='right'>택배발송일 :</td>
										<td>&nbsp;</td>
										<td><strong>$expressdate</strong></td>
									</tr>
									<tr> 
										<td height='1' colspan='3' bgcolor='EAEAEA'></td>
									</tr>
								</table>
								<table width='565' border='0' cellspacing='1' cellpadding='0'>
									<tr> 
										<td height='30' align='right' valign='bottom'>
											<a href='$path_home/' target='_blank'><img src='$path_home/images/mail/btn_gohome.gif' width='119' height='21' border='0'></a></td>
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

?>