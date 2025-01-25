	<?
		## order mail start
		if($tPrice > 0) {
			$pay_display_temp = $paybankname[0]."[".$paybankname[1]."] ".$paybankname[2]."<br>입금자성명 : ".$payname."<br>입금예정일 : ".$paydatey."년 ".$paydatem."월 ".$paydated."일";
		}
		else {
			$pay_display_temp = "전액 G포인트 결제";
		}

		## 주문정보 호출
		$orow = mysql_fetch_array(mysql_query("SELECT * FROM odtOrder WHERE ordernum='$ordernum'"));

		# 상품정보
		$oLogArray = explode("^",preg_replace("[^\^]","",$orow[oLog]));
		$pLogArray = explode("^",$orow[pLog]);
		for($i=0;$i<count($pLogArray);$i++) {
			list($buyCode,$buyCnt) = explode("|",$pLogArray[$i]);
			$tmpRow = mysql_fetch_array(mysql_query("select * from odtProduct where code ='".$buyCode."'"));

			if($oLogArray[$i]) {	// 해당상품에 대한 옵션내역이 있으면
				$oLogTmp = explode("|",$oLogArray[$i]);
				$tmpRow[price] += $oLogTmp[2];
				$tmpRow[name] .= "(".$oLogTmp[1].")";
			}

			$order_products_mail_ .= "
									<tr style='padding-top:7;padding-bottom:7;'> 
										<td>$tmpRow[name]</td>
										<td width='80' align='center'>".number_format($tmpRow[price])."원</td>
										<td width='60' align='center'>".$buyCnt."개</td>
										<td width='80' align='center'><font color='FF6643'>".number_format($tmpRow[price] * $buyCnt)."원</font></td>
									</tr>
									<tr> 
										<td height='1' colspan='6' bgcolor='C8C8C8'></td>
									</tr>";

			$sumProductPriceTmp += $tmpRow[price] * $buyCnt;
		}

		# 할인정보
		if($orow[cLog]) {
			$cLogArray = explode("^",$orow[cLog]);
			for($i=0;$i<count($cLogArray);$i++) {
				list($cName,$cPrice) = explode("|",$cLogArray[$i]);
				$sumCouponPriceTmp += $cPrice;
			}
		}
		$total_price_mail_ = "
												<table width='565' border='0' cellspacing='0' cellpadding='0'>
													<tr> 
														<td height='54' align='right' bgcolor='F6F6F6' style='padding-right:15px;padding-top:7;padding-bottom:7;'><font color='#000000'> 
															상품가격(<font color='FF0000'>".number_format($sumProductPriceTmp)."원</font>) + 
															배송료(<font color='FF0000'>".number_format($dPrice)."원</font>) - 
															할인쿠폰(<font color='FF0000'>".number_format($sumCouponPriceTmp)."원</font>) 
															- 적립금결제(<font color='FF0000'>".number_format($gPrice)."원</font>)
															= <font color='FF6643' style='font-size:15px'><b>".number_format($tPrice)."</b></font><br>
															<font color='005190' style='font-size:15px'>$point_icon_view<b>".number_format($gGetPrice)."</b></font></font></td>
													</tr>
													<tr> 
														<td height='1' bgcolor='C8C8C8'></td>
													</tr>
												</table>";


		$mailheaders1 = "From:$ordername<$orderemail>\n";
		$mailheaders1 .= "Content-Type: text/html; charset=euc-kr";
		$mailheaders2 = "From:$row_company[name]<$row_company[email]>\n";
		$mailheaders2 .= "Content-Type: text/html; charset=euc-kr";
		
		$to1 = "$row_company[name]<$row_company[email]>";
		$to2 = "$orow[ordername] 님<$orow[orderemail]>";
		
		$title1 = "[$orow[ordername]]님께서 주문해 주셨습니다. (주문번호: $orow[ordernum])";
		$title2 = "[$orow[ordername]]님께서 주문해주신 내역입니다. [$row_company[name]]";
		
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
					<img src='$folderpath_upload/odmail/logo.gif' hspace='5'></td>
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
											<img src='$folderpath_upload/odmail/order_title.gif' width='611' height='86'></td>
									</tr>
								</table>
								<table width='565' border='0' cellspacing='1' cellpadding='0'>
									<tr> 
										<td height='15'></td>
									</tr>
								</table>
								<table width='565' border='0' cellspacing='0' cellpadding='0'>
									<tr> 
										<td height='30'><img src='$path_home/odimages/odmail/order_st02.gif'></td>
									</tr>
									<tr> 
										<td height='2' bgcolor='4877C3'></td>
									</tr>
								</table>
								<!-- 주문내역 -->
								<table width='565' border='0' cellspacing='0' cellpadding='0'>
									<tr bgcolor='F9F9F9' height='23'> 
										<td align='center' bgcolor='F9F9F9'><font color='#000000'>상품정보</font></td>
										<td width='80' align='center'><font color='#000000'>가격</font></td>
										<td width='60' align='center'><font color='#000000'>수량</font></td>
										<td width='80' align='center'><font color='#000000'>합계</font></td>
									</tr>
									<tr bgcolor='BBBBBB'> 
										<td height='1' colspan='6'></td>
									</tr>
								</table>
								<table width='565' border='0' cellspacing='0' cellpadding='0'>
									<!-- 주문내역 시작 -->
									$order_products_mail_
									<!-- 주문내역 종료 -->
								</table>
								<!-- 합계계산 시작 -->
								$total_price_mail_
								<!-- 합계계산 종료 -->
								<table width='565' border='0' cellspacing='0' cellpadding='0'>
									<tr> 
										<td height='26'>&nbsp;</td>
									</tr>
								</table>
								<table width='565' border='0' cellspacing='0' cellpadding='0'>
									<tr> 
										<td height='30'><img src='$path_home/odimages/odmail/order_st01.gif'></td>
									</tr>
									<tr> 
										<td height='2' bgcolor='4877C3'></td>
									</tr>
								</table>
								<table width='565' border='0' cellspacing='0' cellpadding='0'>
									<tr> 
										<td width='115' height='28' align='right'>주문번호 :</td>
										<td>&nbsp;</td>
										<td><b>$ordernum</b></td>
									</tr>
									<tr> 
										<td height='1' colspan='3' bgcolor='EAEAEA'></td>
									</tr>
									<tr> 
										<td width='115' height='28' align='right'>결제금액 :</td>
										<td width='20'>&nbsp;</td>
										<td><b>".number_format($tPrice)."원</b></td>
									</tr>
									<tr> 
										<td height='1' colspan='3' bgcolor='EAEAEA'></td>
									</tr>
									<tr> 
										<td width='115' height='28' align='right'>주문자명 :</td>
										<td>&nbsp;</td>
										<td> $orow[ordername]</td>
									</tr>
									<tr> 
										<td height='1' colspan='3' bgcolor='EAEAEA'></td>
									</tr>
									<tr> 
										<td width='115' height='28' align='right'>수령인 :</td>
										<td>&nbsp;</td>
										<td> $orow[recname]</td>
									</tr>
									<tr> 
										<td height='1' colspan='3' bgcolor='EAEAEA'></td>
									</tr>
									<tr> 
										<td width='115' height='28' align='right'>수령인 전화번호 :</td>
										<td>&nbsp;</td>
										<td>$orow[rectel1]-$orow[rectel2]-$orow[rectel3]</td>
									</tr>
									<tr> 
										<td height='1' colspan='3' bgcolor='EAEAEA'></td>
									</tr>
									<tr> 
										<td width='115' height='28' align='right'>수령인 휴대폰 :</td>
										<td>&nbsp;</td>
										<td>$rechtel1-$rechtel2-$rechtel3</td>
									</tr>
									<tr> 
										<td height='1' colspan='3' bgcolor='EAEAEA'></td>
									</tr>
									<tr> 
										<td width='115' height='28' align='right'>배송지 주소 :</td>
										<td height='20'></td>
										<td height='20'>($reczip1-$reczip2) $recaddress $recaddress1</td>
									</tr>
									<tr> 
										<td height='1' colspan='3' bgcolor='EAEAEA'></td>
									</tr>
								</table>
								<table width='565' border='0' cellspacing='0' cellpadding='0'>
									<tr> 
										<td height='26'>&nbsp;</td>
									</tr>
								</table>
								<table width='565' border='0' cellspacing='0' cellpadding='0'>
									<tr> 
										<td height='26'><img src='$path_home/odimages/odmail/order_st03.gif'></td>
									</tr>
									<tr> 
										<td height='2' bgcolor='4877C3'></td>
									</tr>
								</table>
								<table width='565' border='0' cellspacing='0' cellpadding='0'>
									<tr> 
										<td height='5' colspan='3' bgcolor='FFFFFF'></td>
									</tr>
									<tr> 
										<td width='115' height='60' align='right'>계좌번호 :</td>
										<td width='20'>&nbsp;</td>
										<td>$pay_display_temp</td>
									</tr>
									<tr> 
										<td height='1' colspan='3' bgcolor='EAEAEA'></td>
									</tr>
								</table>
								<table width='565' border='0' cellspacing='1' cellpadding='0'>
									<tr> 
										<td height='30' align='right' valign='bottom'>
										  <a href='$path_home/' target='_blank'><img src='$path_home/odimages/odmail/btn_gohome.gif' width='119' height='21' border='0'></a></td>
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

	$to1					=	iconv("utf-8","euckr",$to1);
	$to2					=	iconv("utf-8","euckr",$to2);
	$title1				=	iconv("utf-8","euckr",$title1);
	$title2				=	iconv("utf-8","euckr",$title2);
	$body					=	iconv("utf-8","euckr",$body);
	$mailheaders1	=	iconv("utf-8","euckr",$mailheaders1);
	$mailheaders2	=	iconv("utf-8","euckr",$mailheaders2);

#	mail($to1,$title1,$body,$mailheaders1);
	mail($to2,$title2,$body,$mailheaders2);


	// 사용한 적립금만큼 삭감
	if($row_member[serialnum]) { 
		mysql_query("UPDATE odtMember SET point=point-$usedpoint WHERE id='$row_member[id]'"); 
	}

?>
