<?

	$useName = $mail_row[viewDel] == "1" ? $mail_row[recname] : $mail_row[ordername];

	##  메일 발송  ##################################################################
	$mailheaders = "From: [$row_company[name]] <$row_company[email]> \n"; 
	$mailheaders .= "Content-Type: text/html; charset=euc-kr";
	
	$to = "$mail_row[ordername] 님 <$mail_row[orderemail]>";
	$title = "[$mail_row[ordername]]님께서 주문하신 쿠폰이 발급되었습니다.($row_company[name])";
	
	$body = "
<html>
	<head>
		<title>주문확인서</title>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
		<link href='http://".$_SERVER[HTTP_HOST]."/css/style.css' rel='stylesheet' type='text/css'>

		<style type='text/css'>
		<!--
		.style1 {color: #FFFFFF}
		.style3 {
			color: #000000;
			font-weight: bold;
		}
		.style5 {
			color: #000000;
			font-weight: bold;
			font-size: 16px;
		}
		.style6 {
			color: #FF0000;
			font-weight: bold;
		}
		.style7 {font-size: 16px}
		.style9 {color: #000000}
		-->
		</style>
	</head>
	<body bgcolor='#FFFFFF' leftmargin='0' topmargin='0'>";


	if($mail_row[paymethod] == "C")	$pay_display_temp = "신용카드결제";
	if($mail_row[paymethod] == "L")	$pay_display_temp = "실시간 계좌이체";
	if($mail_row[paymethod] == "H")	$pay_display_temp = "핸드폰결제";
	if($mail_row[paymethod] == "E") $pay_display_temp = "포인트결제";

	# 상품정보
	$oLogArray = explode("^",preg_replace("[^\^]","",$mail_row[oLog]));
	$pLogArray = explode("^",$mail_row[pLog]);
	for($z=0;$z<count($pLogArray);$z++) {
		list($buyCode,$buyCnt) = explode("|",$pLogArray[$z]);
		$tmpRow = mysql_fetch_array(mysql_query("select * from odtProduct where code ='".$buyCode."'"));
		if($oLogArray[$z]) {	// 해당상품에 대한 옵션내역이 있으면
			$oLogTmp = explode("|",$oLogArray[$z]);
			$tmpRow[price] += $oLogTmp[2];
			$tmpRow[name] .= "(".$oLogTmp[1].")";
		}
		if($z>0){
			$body .= "
			<table>
				<tr>
					<td height='30'>&nbsp;</td>
				</tr>
			</table>";
		}
		
		# 공급업체정보
		$corpRow = mysql_fetch_array(mysql_query("select * from odtMember where userType = 'C' and id !='onedaynet' and id ='".$tmpRow[customerCode]."'"));

		if($mail_row[viewDel] == "1" && $mail_row[comment]) {
			$commentTmp = "   <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                          <tr>
                            <td width='7'><img src='http://".$_SERVER[HTTP_HOST]."/images/group/popup_img_15.jpg' width='7' height='5'></td>
                            <td><strong>메세지: ".nl2br($mail_row[comment])."</strong><span class='style6'></span></td>
                          </tr>
                        </table>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                          <tr>
                            <td height='7'></td>
                          </tr>
                        </table>";
			
			
		} else {
			$commentTmp = "";
		}




		$body .= "
<table width='700' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td valign='top'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
      <tr>
        <td width='168'><img src='http://".$_SERVER[HTTP_HOST]."/images/group/popup_img_11.jpg' width='168' height='80'></td>
        <td width='326' valign='top' background='http://".$_SERVER[HTTP_HOST]."/images/group/popup_img_12.jpg'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
          <tr>
            <td height='27'></td>
          </tr>
        </table>
          <table width='100%' border='0' cellspacing='0' cellpadding='0'>
            <tr>
              <td><span class='style1'><strong>“".$mail_row[ordername]."” (".$mail_row[orderid].") 님의 주문확인서입니다.</strong><br>
              </span></td>
            </tr>
          </table>
          <table width='100%' border='0' cellspacing='0' cellpadding='0'>
            <tr>
              <td height='5'></td>
            </tr>
          </table>
          <table width='100%' border='0' cellspacing='0' cellpadding='0'>
            <tr>
              <td><span class='style3'>주문번호 : ".$expressnumTmp."</span></td>
            </tr>
          </table></td>
        <td><img src='http://".$_SERVER[HTTP_HOST]."/images/group/popup_img_13.jpg' width='206' height='80'></td>
      </tr>
    </table>
      <table width='100%' border='0' cellspacing='0' cellpadding='0'>
        <tr>
          <td width='10' height='409' valign='top' bgcolor='#fb9717'>&nbsp;</td>
          <td width='680' valign='top'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
            <tr>
              <td height='25'></td>
            </tr>
          </table>
            <table width='614' border='0' align='center' cellpadding='0' cellspacing='0'>
              <tr>
                <td valign='top'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
                  <tr>
                    <td><span class='style5'>".$tmpRow[name]."</span></td>
                  </tr>
                </table>
                  <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                    <tr>
                      <td height='17'></td>
                    </tr>
                  </table>
                  <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                    <tr>
                      <td width='171'><img src='http://".$_SERVER[HTTP_HOST]."".$tmpRow[cpDp_img]."' width='170' height='170' style='border:1px solid ##CCCCCC'></td>
                      <td width='29'></td>
                      <td valign='top'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
                        <tr>
                          <td height='7'></td>
                        </tr>
                      </table>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                        <tr>
                          <td width='7'><img src='http://".$_SERVER[HTTP_HOST]."/images/group/popup_img_15.jpg' width='7' height='5'></td>
                          <td><strong>총결제금액:</strong> <span class='style6'>".number_format($tmpRow[price] * $buyCnt)."원</span></td>
                        </tr>
                      </table>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                          <tr>
                            <td height='7'></td>
                          </tr>
                        </table>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                        <tr>
                          <td width='7'><img src='http://".$_SERVER[HTTP_HOST]."/images/group/popup_img_15.jpg' width='7' height='5'></td>
                          <td><strong>이름: ".$useName."</strong></td>
                        </tr>
                      </table>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                          <tr>
                            <td height='7'></td>
                          </tr>
                        </table>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                          <tr>
                            <td width='7'><img src='http://".$_SERVER[HTTP_HOST]."/images/group/popup_img_15.jpg' width='7' height='5'></td>
                            <td><strong>수량: ".$buyCnt."개</strong><span class='style6'></span></td>
                          </tr>
                        </table>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                          <tr>
                            <td height='7'></td>
                          </tr>
                        </table>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                          <tr>
                            <td width='7'><img src='http://".$_SERVER[HTTP_HOST]."/images/group/popup_img_15.jpg' width='7' height='5'></td>
                            <td><strong>주문시간: ".$mail_row[orderdate]."</strong><span class='style6'></span></td>
                          </tr>
                        </table>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                          <tr>
                            <td height='7'></td>
                          </tr>
                        </table>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                          <tr>
                            <td width='7'><img src='http://".$_SERVER[HTTP_HOST]."/images/group/popup_img_15.jpg' width='7' height='5'></td>
                            <td><strong>티켓번호: ".$expressnumTmp."</strong><span class='style6'></span></td>
                          </tr>
                        </table>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                          <tr>
                            <td height='7'></td>
                          </tr>
                        </table>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                          <tr>
                            <td width='7'><img src='http://".$_SERVER[HTTP_HOST]."/images/group/popup_img_15.jpg' width='7' height='5'></td>
                            <td><strong>결제방법: ".$pay_display_temp."</strong><span class='style6'></span></td>
                          </tr>
                        </table>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                          <tr>
                            <td height='7'></td>
                          </tr>
                        </table>
												".$commentTmp."
												</td>
                    </tr>
                  </table>
                  <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                    <tr>
                      <td height='18'></td>
                    </tr>
                  </table>

									<table width='100%' border='0' cellspacing='0' cellpadding='0'>
                    <tr>
                      <td valign='top'><table width='100%' border='0' cellpadding='0' cellspacing='1' bgcolor='#cccccc'>
                        <tr>
                          <td height='31' bgcolor='#e5e5e5'><span class='style8'>&nbsp;&nbsp;매장정보</span></td>
                          <td bgcolor='#e5e5e5'><span class='style8'>&nbsp;&nbsp;주의사항</span></td>
                        </tr>
                        <tr>
                          <td bgcolor='#eaeaea'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
                            <tr>
                              <td height='8'></td>
                            </tr>
                          </table>
                            <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                            <tr>
                              <td width='15'></td>
                              <td><span class='style9'>".$corpRow[cName]."</span><br>
                                  ".$corpRow[address]." ".$corpRow[address1]."<br>
                                  ".$corpRow[tel1]."-".$corpRow[tel2]."-".$corpRow[tel3]."<br>
                                  ".$corpRow[email]."</td>
                            </tr>
                          </table>
                            <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                              <tr>
                                <td height='8'></td>
                              </tr>
                            </table></td>
                          <td bgcolor='#eaeaea'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
                            <tr>
                              <td width='15'></td>
                              <td><span >".htmlspecialchars_decode($tmpRow[comment3])."</td>
                            </tr>
                          </table></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>
									<table width='100%' border='0' cellspacing='0' cellpadding='0'>
                    <tr>
                      <td align=right height=40>".$row_company[name]." 고객센터: ".$row_company[tel]."</td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
          <td valign='top' bgcolor='#fb9717'>&nbsp;</td>
        </tr>
      </table>
      <table width='100%' border='0' cellspacing='0' cellpadding='0'>
        <tr>
          <td height='11' bgcolor='#ff9900'></td>
        </tr>
      </table></td>
  </tr>
</table>
";
	}





	$body .= "
		</table>
	</body>
</html>";

	$to						=	iconv("utf-8","euckr",$to);
	$title				=	iconv("utf-8","euckr",$title);
	$body					=	iconv("utf-8","euckr",$body);
	$mailheaders	=	iconv("utf-8","euckr",$mailheaders);
	
	mail($to,$title,$body,$mailheaders);
?>
