<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href='/css/css01.css' rel="stylesheet" type="text/css">
<?
	// 클라이언트 ip 가져오기
	$ip = $_SERVER['REMOTE_ADDR'];
	// 서버 ip 가져오기
	$server_ip = $_SERVER['SERVER_NAME'];	
	// 전문생성일시
	$ediDate = date("YmdHis");
	// 상점서명키 (꼭 해당 상점키로 바꿔주세요)
	$merchantKey = "zutht7y2mL0DQWk7mkY2Jt+2B7hxqRBtnQ0tK0nl3ZhfztnX5sXSyApEatooQODfz5wNa7DTxzogjWqbxLfa6Q==";
	// 웹링크 결제 서버 IP 세팅
	$payActionUrl = "https://pg.mnbank.co.kr";
?>
<title>:::초기페이지:::</title>
<script language='javascript' src='./js/webtoolkit.md5.js'></script>
<script language='javascript' src='./js/incMerchant.js'></script>
<?
    echo("<script language=javascript>setEdiDate(\"$ediDate\");</script>");
    echo("<script language=javascript>setMKey(\"$merchantKey\");</script>");
    echo("<script language=javascript>setPayActionUrl(\"$payActionUrl\");</script>");
?>
</head>
<body>
<form name="tranMgr" method="post" action="">
<table align="left">
	<tr>
		<td>
			<table width="560" border="0" align="center"  cellpadding="0" cellspacing="0" bordercolor="#cccccc" style="border-collapse:collapse;">
				<tr>
					<td><img src="images/bar01.gif" width="213" height="37"></td>
				</tr>
			</table>
			<table width="560" border="1" align="center"  cellpadding="0" cellspacing="0" bordercolor="#cccccc" style="border-collapse:collapse;">
				<tr>
					<td class="sTblTc">결제수단</td>
					<td class="TblTitA">
						<select name="selectType">
							<option value="">[전체]</option>
							<option value="CARD">[신용카드]</option>
							<option value="BANK">[계좌이체]</option>
							<option value="VBANK">[가상계좌]</option>
							<option value="MOBILE">[휴대폰결제]</option>
							<option value="CPBILL">[휴대폰빌링]</option>
							<option value="CARD+BANK">[신용카드/계좌이체]</option>
						</select>
					</td>
				</tr>
				
				<tr>
					<td class="sTblTc">결제타입</td>
					<td class="TblTitA">
						<input type="radio" name="TransType" value="0">일반</input>
						<input type="radio" name="TransType" value="1">에스크로</input>
					</td>
				</tr>
				<tr height="25">
					<td class="sTblTc">스킨 Color</td>
					<td class="TblTitA">
						<select name="skinType" onChange="goSelectSkin()">
							<option value="1">[:::밝은 블루:::]</option>
							<option value="2">[:::짙은 연두:::]</option>
							<option value="3">[:::브라운:::]</option>
							<option value="4">[:::핫핑크:::]</option>
							<option value="5">[:::밝은 초록:::]</option>
							<option value="6">[:::사이언:::]</option>
							<option value="7">[:::청록색:::]</option>
							<option value="8">[:::옐로우:::]</option>
						</select>
					</td>
				</tr>
				<tr height="25">
					<td class="sTblTc">상품갯수</td>
					<td class="TblTitA">
						<input name="GoodsCnt" size="20" value="1" onKeyUp="javascript:numOnly(this,document.tranMgr,false);">
					</td>
				</tr>
				<tr height="25">
					<td class="sTblTc">상품명(*)</td>
					<td class="TblTitA">
						<input name="GoodsName" size="20" value="mn_상품명">
					</td>
				</tr>
				<tr height="25">
					<td class="sTblTc">상품가격(*)</td>
					<td class="TblTitA">
						<input name="Amt" size="20" value="1004" onKeyUp="javascript:numOnly(this,document.tranMgr,false);">
					</td>
				</tr>
				<tr height="25">
					<td class="sTblTc">상품이미지URL</td>
					<td class="TblTitA">
						<input name="GoodsURL" size="50" value="">
					</td>
				</tr>
				<tr height="25">
					<td class="sTblTc">상품주문번호</td>
					<td class="TblTitA">
						<input name="Moid" size="20" value="mnoid1234567890">
					</td>
				</tr>
				<tr height="25">
					<td class="sTblTc">회원사아이디(*)</td>
					<td class="TblTitA">
						<input name="MID" size="20" value="mnbank002m">
					</td>
				</tr>
				<tr height="25">
					<td class="sTblTc">결제결과 전송 URL(*)</td>
					<td class="TblTitA">
						<input name="ReturnURL" size="50" value="http://grptime.onedaynet.co.kr/MnBank/returnPay.php">
					</td>
				</tr>
				<tr height="25">
					<td class="sTblTc">결제결과 Retry URL(*)</td>
					<td class="TblTitA">
						<input name="RetryURL" size="50" value="http://grptime.onedaynet.co.kr/MnBank/inform.php">
					</td>
				</tr>
				<tr height="25">
		                    <td class="sTblTc">결제결과창유무(*)</td>
		                    <td class="TblTitA">
		                        <input name="ResultYN" size="50" value="Y">                        
		                    </td>
		                </tr>
				<tr height="25">
					<td class="sTblTc">회원사고객ID</td>
					<td class="TblTitA">
						<input name="mallUserID" size="20" value="mn_id">
					</td>
				</tr>
				<tr height="25">
					<td class="sTblTc">구매자명</td>
					<td class="TblTitA">
						<input name="BuyerName" size="20" value="mn_구매자명">
					</td>
				</tr>
				<tr height="25">
					<td class="sTblTc">구매자인증번호</td>
					<td class="TblTitA">
						<input name="BuyerAuthNum" size="20" maxlength="13" onKeyUp="javascript:numOnly(this,document.tranMgr,false);">&nbsp;(-)없이 입력(주민번호,사업자번호)
					</td>
				</tr>
				<tr height="25">
					<td class="sTblTc">구매자연락처</td>
					<td class="TblTitA">
						<input name="BuyerTel" size="20" value="0212345678">&nbsp;(-)없이 입력
					</td>
				</tr>
				<tr height="25">
					<td class="sTblTc">구매자메일주소(*)</td>
					<td class="TblTitA">
						<input name="BuyerEmail" size="20" value="aaa@bbb.com">
					</td>
				</tr>
				<tr height="25">
					<td class="sTblTc">보호자메일주소</td>
					<td class="TblTitA">
						<input name="ParentEmail" size="20">
					</td>
				</tr>
				<tr height="25">
					<td class="sTblTc">배송지주소</td>
					<td class="TblTitA">
						<input name="BuyerAddr" size="50" value="서울시 강남구 역삼동 9-11">
					</td>
				</tr>
				<tr height="25">
					<td class="sTblTc">우편번호</td>
					<td class="TblTitA">
						<input name="BuyerPostNo" size="6" value="123456">
					</td>
				</tr>
				<tr height="25">
					<td class="sTblTc">Mall IP</td>
					<td class="TblTitA">
						<input name="MallIP" size="20" value="<?=$server_ip?>">
					</td>
				</tr>
				<tr height="25">
                    			 <td class="sTblTc">상점예비정보</td>
                    			 <td class="TblTitA">
                     		  	  <input name="MallReserved" size="20" value="MallReserved">
                    			 </td>
                		</tr>
				<!-- 가상계좌관련 -->
				<tr height="25">
					<td class="sTblTc">입금기한</td>
					<td class="TblTitA">
						<input name="VbankExpDate">
					</td>
				</tr>
				<tr height="25" align="center">
					<td colspan="2" class="sTblTc">
                        <input name="submit22224" type="submit" class="mmtnL03c" value="결제하기" onClick="return goInterface();">
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>

<form name="payForm" method="post">
<input type="hidden" name="payType">
<input type="hidden" name="skinType">
<input type="hidden" name="GoodsCnt">
<input type="hidden" name="GoodsName">
<input type="hidden" name="Amt">
<input type="hidden" name="GoodsURL">
<input type="hidden" name="Moid">
<input type="hidden" name="MID">
<input type="hidden" name="ReturnURL">
<input type="hidden" name="RetryURL">
<input type="hidden" name="ResultYN">
<input type="hidden" name="mallUserID">
<input type="hidden" name="BuyerName">
<input type="hidden" name="BuyerAuthNum">
<input type="hidden" name="BuyerTel">
<input type="hidden" name="BuyerEmail">
<input type="hidden" name="ParentEmail">
<input type="hidden" name="BuyerAddr">
<input type="hidden" name="BuyerPostNo">
<input type="hidden" name="UserIP"          value="<?=$ip?>">
<input type="hidden" name="MallIP">
<input type="hidden" name="VbankExpDate">
<input type="hidden" name="BrowserType">
<input type="hidden" name="PayMethod">
<input type="hidden" name="ediDate"		    value="<?=$ediDate?>">
<input type="hidden" name="EncryptData">
<input type="hidden" name="MallReserved">
<input type="hidden" name="FORWARD"         value="Y">
<input type="hidden" name="MallResultFWD"   value="Y">
<input type="hidden" name="TransType">
</form>

<iframe src="./blank.html" name="payFrame" frameborder="no" width="100%" height="100" scrolling="yes"  align="center"></iframe>

</body>
</html>
