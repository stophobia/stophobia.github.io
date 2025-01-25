<?php
// 필요한 설정파일 불러오기
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_config.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_lib.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_function.inc.php";

$que = "insert into sendSMS set
				ss_code			=	'".$_POST[code]."',
				ss_id				=	'".$_POST[id]."',
				ss_name			=	'".$_POST[fromName]."',
				ss_to				=	'".$_POST[toMail]."',
				ss_from			=	'".$_POST[fromMail]."',
				ss_text			=	'".$_POST[textarea]."',
				ss_regidate	=	now()";

$res = mysql_query($que);

$row_product = mysql_fetch_array(mysql_query("select mainName,a.name,main_img,cName as comName, address as comAddr, tel1 as comTel1, tel2 as comTel2, tel3 as comTel3  from odtProduct as a, odtMember as b where code ='".$_POST[code]."' and customerCode = b.id"));


	##  메일 발송  ##################################################################
	$mailheaders = "From: [".$_POST[fromName]."] <".$_POST[fromMail]."> \n"; 
	$mailheaders .= "Content-Type: text/html; charset=euc-kr";
	
	$to = $_POST[toName]." 님 <".$_POST[toMail].">";
	$title = $_POST[toName]." 님!! " .$_POST[fromName]."님께서 보내신 추천메일입니다.";
	
	$body = "
<html>
	<head>
		<title>추천 메일</title>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
		<style>
			td{font-size:12px;color:4C4C4C;line-height:150%}
		</style>
	</head>
	<body bgcolor='#FFFFFF' leftmargin='10' topmargin='10'>
		<table width='625' border='0' align='center' cellpadding='0' cellspacing='0'>
			<tr> 
				<td><img src='$folderpath_upload/odmail/logo.gif' width='164' height='50' hspace='5'></td>
			</tr>
			<tr> 
				<td>
					<table width='625' border='0' cellpadding='1' cellspacing='6' bgcolor='E5E5E5' align='center' >
						<tr> 
							<td bgcolor='#FFFFFF'> 
								<table border='0' cellspacing='1' cellpadding='0' align=center>
									<tr> 
										<td><img src='$folderpath_upload/odmail/best_title.gif' width='611' height='86'></td>
									</tr>
								</table>
								<table width='565' border='0' cellspacing='1' cellpadding='0' style='border:3px solid #cccccc' align=center>
									<tr> 
										<td height='43' style='line-height:180%' >
											<strong>".$_POST[fromName]."</strong>님께서 보내신 추천메일입니다.<br>".$_POST[textarea]."</td>
									</tr>
								</table>
								<table width='565' border='0' cellspacing='0' cellpadding='0' align=center>
									<tr>
										<td height='2'></td>
									</tr>
									<tr> 
										<td height='2' bgcolor='4877C3'></td>
									</tr>
								</table>
								<table width='565' border='0' cellspacing='0' cellpadding='0' align=center>
									<tr> 
										<td align=center height=25>".($row_product[mainName] ? $row_product[mainName] : $row_product[name])."</td>
									</tr>
									<tr> 
										<td align=center><img src='http://".$_SERVER[HTTP_HOST].$row_product[main_img]."' width='550'></td>
									</tr>
								</table>
								<table width='565' border='0' cellspacing='0' cellpadding='4' align=center>
									<tr> 
										<td width='95' height='28' align='right'><b>이용방법</b></td>
										<td width='20'>&nbsp;</td>
										<td style='line-height:180%'>
										1. 오늘의 상품을 구매합니다.<br>
										2. 쿠폰을 발급받고 필요시 전화로 예약합니다.<br>
										3. 예약한 날짜에 방문하여 쿠폰을 사용합니다..<br>
										</td>
									</tr>
									<tr> 
										<td height='1' colspan='3' bgcolor='EAEAEA'></td>
									</tr>
									<tr> 
										<td height='28' align='right'><b>매장정보</b></td>
										<td>&nbsp;</td>
										<td style='line-height:180%'>
										".$row_product[comName]."<br>
										".$row_product[comAddr]."<br>
										".$row_product[comTel1]."-".$row_product[comTel2]."-".$row_product[comTel3]."<br>
										</td>
									</tr>
									<tr> 
										<td height='1' colspan='3' bgcolor='EAEAEA'></td>
									</tr>
								</table>
								<table width='565' border='0' cellspacing='1' cellpadding='0' align=center>
									<tr> 
										<td height='30' align='right' valign='bottom'>
											<a href='$path_domain' target='_blank'><img src='$folderpath_image/odmail/btn_gohome.gif' width='119' height='21' border='0'></a></td>
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

			/* euckr 로 컨버트 */
			$to						= iconv("utf-8","euckr",$to);
			$title				= iconv("utf-8","euckr",$title);
			$body					= iconv("utf-8","euckr",$body);
			$mailheaders	= iconv("utf-8","euckr",$mailheaders);

	$res = mail($to,$title,$body,$mailheaders);

if($res) {
	error_msgall('친구에게 추천메일를 발송하였습니다.','close');
}
?>
