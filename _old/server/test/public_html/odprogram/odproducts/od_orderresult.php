<?
	include "../odcommon/od_config.inc.php";
	include "../odcommon/od_function.inc.php";
	include_once "../odcommon/od_lib.inc.php";


	if(!$row_member[id] || !($_POST[tPrice]>=0) ) {
		echo "<script>alert('잘못된 접근입니다.');location.href='/';</script>";
		exit;
	}


	# 주문번호 쿠키로 꾸어놓음.. 주문서 수정할경우를 위해.
	setCookie("prevOrdernum",$ordernum);

	$parent_code	=	addslashes(trim($_POST[parent_code]));// 부모 상품코드
	$ordernum		= addslashes(trim($_POST[ordernum]));		// 주문번호
	$ordertel1		= addslashes(trim($_POST[ordertel1]));	// 주문자 전화
	$ordertel2		= addslashes(trim($_POST[ordertel2]));	//
	$ordertel3		= addslashes(trim($_POST[ordertel3]));	//
	$cLog			= addslashes(trim($_POST[cLog]));				// 쿠폰사용로그
	$pLog			= addslashes(trim($_POST[pLog]));				// 상품구매로그
	$oLog			= addslashes(trim($_POST[oLog]));				// 구매한상품옵션로그
	$gPrice			= addslashes(trim($_POST[gPrice]));			// 사용한 지포인트
	$gGetPrice		= addslashes(trim($_POST[gGetPrice]));	// 적립될 지포인트
	$dPrice				= addslashes(trim($_POST[dPrice]));			// 배송비
	$sPrice				= addslashes(trim($_POST[sPrice]));			// 총할인금액
	$tPrice				= addslashes(trim($_POST[tPrice]));			// 최종결제금액
	$ordername		= addslashes(trim($_POST[ordername]));	// 주문자명
	$orderhtel1		= addslashes(trim($_POST[orderhtel1]));	// 주문자핸드폰
	$orderhtel2		= addslashes(trim($_POST[orderhtel2]));	//
	$orderhtel3		= addslashes(trim($_POST[orderhtel3]));	//
	$orderemail		= addslashes(trim($_POST[orderemail]));	// 주문자 이메일
	$recname			= addslashes(trim($_POST[recname]));		// 수취인명
	$rectel1			= addslashes(trim($_POST[rectel1]));		// 수취인전화
	$rectel2			= addslashes(trim($_POST[rectel2]));		//
	$rectel3			= addslashes(trim($_POST[rectel3]));		//
	$recemail			= addslashes(trim($_POST[recemail]));		// 수취인이메일
	$rechtel1			= addslashes(trim($_POST[rechtel1]));		// 수취인핸드폰
	$rechtel2			= addslashes(trim($_POST[rechtel2]));		//
	$rechtel3			= addslashes(trim($_POST[rechtel3]));		//
	$reczip1			= addslashes(trim($_POST[reczip1]));		// 수취인 우편번호
	$reczip2			= addslashes(trim($_POST[reczip2]));		//
	$recaddress		= addslashes(trim($_POST[recaddress]));	// 수취인 주소
	$recaddress1	= addslashes(trim($_POST[recaddress1]));//
	$viewDel			=	addslashes(trim($_POST[viewDel]));		//
	$comment			= addslashes(trim($_POST[comment]));		// 배송희망멘트
	$taxorder			= addslashes(trim($_POST[taxorder]));		// 세금계산서신청유무 (Y / N)
	$companynum		= addslashes(trim($_POST[companynum]));	// 사업자등록번호
	$companyname	= addslashes(trim($_POST[companyname]));// 상호명
	$ceoname			= addslashes(trim($_POST[ceoname]));		// 대표자명
	$companyadd		= addslashes(trim($_POST[companyadd]));	// 사업장주소
	$taxstatus		= addslashes(trim($_POST[taxstatus]));	// 사업형태
	$taxitem			= addslashes(trim($_POST[taxitem]));		// 종목
	$paymethod		= addslashes(trim($_POST[paymethod]));	// 결제방법 (무통장 B , 카드 C , 실시간계좌이체 L)
	$paybankname	= addslashes(trim($_POST[paybankname]));// 입금계좌 (은행명/예금주/계좌번호)
	$paydatey			= addslashes(trim($_POST[paydatey]));		// 입금예정일
	$paydatem			= addslashes(trim($_POST[paydatem]));		//
	$paydated			= addslashes(trim($_POST[paydated]));		//
	$payname			= addslashes(trim($_POST[payname]));		// 입금자명

	$orderid			=	$row_member[id] ? $row_member[id] : $_SESSION[Gid];				// 주문자 아이디, 비회원은 guest

	# 결제방법이 무통장이 아니면 무통장입금에 관련 변수 삭제
	if($paymethod != "B") unset($paybankname,$paydatey,$paydatem,$paydated,$payname);

	# 입금 계좌정보 쪼갬.
	$paybankname = isset($paybankname) ? explode("/",$paybankname) : NULL;

	## 데이터 무결성 체크를 한번 해야함..


	######################################

	#해당 상품의 정보 추출
	$row_product = mysql_fetch_array(mysql_query("select * from odtProduct where code = '".$parent_code."'"));

	# 품절체크
	$soldOutCheck = @mysql_result(mysql_query("select max(stock) from odtProduct where parent_code = '".$parent_code."'"),0);
	if($soldOutCheck < 1 && $parent_code) {
		error_msgall('해당 물품은 모두 품절되었습니다. 죄송합니다.','/');
		exit;
	}

	# 이미 등록된 주문인지 체크.
	$isOrder = mysql_result(mysql_query("select count(*) from odtOrder where ordernum = '".$ordernum."'"),0);

	if($isOrder)	{	 //이미 등록되어있는 주문건이면 수정.

		#수정 .
		$que = "update odtOrder set
						partnerCode			= '".$row_product[customerCode]."',
						orderid					= '".$orderid."',
						ordername				= '".$ordername."',
						orderemail			= '".$orderemail."',
						ordertel1				= '".$ordertel1."',
						ordertel2				= '".$ordertel2."',
						ordertel3				= '".$ordertel3."',
						orderhtel1			= '".$orderhtel1."',
						orderhtel2			= '".$orderhtel2."',
						orderhtel3			= '".$orderhtel3."',
						recname					= '".$recname."',
						recemail				= '".$recemail."',
						rectel1					= '".$rectel1."',
						rectel2					= '".$rectel2."',
						rectel3					= '".$rectel3."',
						rechtel1				= '".$rechtel1."',
						rechtel2				= '".$rechtel2."',
						rechtel3				= '".$rechtel3."',
						reczip1					= '".$reczip1."',
						reczip2					= '".$reczip2."',
						recaddress			= '".$recaddress."',
						recaddress1			= '".$recaddress1."',
						viewDel					=	'".$viewDel."',
						comment					= '".$comment."',
						taxorder				= '".$taxorder."',
						companynum			= '".$companynum."',
						companyname			= '".$companyname."',
						ceoname					= '".$ceoname."',
						companyadd			= '".$companyadd."',
						taxstatus				= '".$taxstatus."',
						taxitem					= '".$taxitem."',
						cLog						= '".$cLog."',
						pLog						= '".$pLog."',
						oLog						= '".$oLog."',
						gPrice					= '".$gPrice."',
						gGetPrice				= '".$gGetPrice."',
						dPrice					= '".$dPrice."',
						sPrice					= '".$sPrice."',
						tPrice					= '".$tPrice."',
						pointed					= 'N',
						paymethod				= '".$paymethod."',
						paystatus				= 'N',
						paybankname			= '".$paybankname[0]."/".$paybankname[1]."',
						paybanknum			= '".$paybankname[2]."',
						paydatey				= '".$paydatey."',
						paydatem				= '".$paydatem."',
						paydated				= '".$paydated."',
						payname					= '".$payname."',
						md_name					= '".$row_product[md_name]."',
						orderweb				=	'".$HTTP_USER_AGENT."',
						hID							=	'".$_COOKIE[hID]."',
						ip							= '".$_SERVER[REMOTE_ADDR]."'
						where
						ordernum				= '".$ordernum."'";

	}	else { // 없으면 새등록

		// 배송기능 사용시 주문 기록 - onedaynet jjc
		if($row_product[setup_delivery]=="Y") {
			$app_order_type = "product";
		}
		else {
			$app_order_type = "coupon";
		}

		#DB에 입력처리.
		$que = "insert into odtOrder set
						order_type				= '".$app_order_type."',
						ordernum				= '".$ordernum."',
						partnerCode			= '".$row_product[customerCode]."',
						orderid					= '".$orderid."',
						ordername				= '".$ordername."',
						orderemail			= '".$orderemail."',
						ordertel1				= '".$ordertel1."',
						ordertel2				= '".$ordertel2."',
						ordertel3				= '".$ordertel3."',
						orderhtel1			= '".$orderhtel1."',
						orderhtel2			= '".$orderhtel2."',
						orderhtel3			= '".$orderhtel3."',
						recname					= '".$recname."',
						recemail				= '".$recemail."',
						rectel1					= '".$rectel1."',
						rectel2					= '".$rectel2."',
						rectel3					= '".$rectel3."',
						rechtel1				= '".$rechtel1."',
						rechtel2				= '".$rechtel2."',
						rechtel3				= '".$rechtel3."',
						reczip1					= '".$reczip1."',
						reczip2					= '".$reczip2."',
						recaddress			= '".$recaddress."',
						recaddress1			= '".$recaddress1."',
						viewDel					=	'".$viewDel."',
						comment					= '".$comment."',
						taxorder				= '".$taxorder."',
						companynum			= '".$companynum."',
						companyname			= '".$companyname."',
						ceoname					= '".$ceoname."',
						companyadd			= '".$companyadd."',
						taxstatus				= '".$taxstatus."',
						taxitem					= '".$taxitem."',
						cLog						= '".$cLog."',
						pLog						= '".$pLog."',
						oLog						= '".$oLog."',
						gPrice					= '".$gPrice."',
						gGetPrice				= '".$gGetPrice."',
						dPrice					= '".$dPrice."',
						sPrice					= '".$sPrice."',
						tPrice					= '".$tPrice."',
						pointed					= 'N',
						paymethod				= '".$paymethod."',
						paystatus				= 'N',
						paybankname			= '".$paybankname[0]."/".$paybankname[1]."',
						paybanknum			= '".$paybankname[2]."',
						paydatey				= '".$paydatey."',
						paydatem				= '".$paydatem."',
						paydated				= '".$paydated."',
						payname					= '".$payname."',
						orderweb				=	'".$HTTP_USER_AGENT."',
						orderdate				=	now(),
						orderstatus			=	'Y',
						md_name					= '".$row_product[md_name]."',
						hID							=	'".$_COOKIE[hID]."',
						ip							= '".$_SERVER[REMOTE_ADDR]."'";
	}

	$res = mysql_query($que);
	if(!$res) {
		error_msgall('주문서 작성중 오류가 발생하였습니다');
		exit;
	}
	if($paymethod == "C" || $paymethod == "L" || $paymethod == "H" || $paymethod == "E" ) {

		if($paymethod == "C") $gopaymethod = "Card";
		if($paymethod == "H") $gopaymethod = "HPP";
		if($paymethod == "L") $gopaymethod = "DirectBank";
		if($paymethod == "E") $gopaymethod = "VBank";

		$pLogTmp2 = explode("^",$pLog);
		$goodnameTmp = @mysql_result(mysql_query("select name from odtProduct where code ='".reset(explode("|",$pLogTmp2[0]))."'"),0);
		if(count($pLogTmp2) > 1) {
			$goodnameTmp2 = " 외 ".(count($pLogTmp2)-1)."건";
		} else $goodnameTmp2='';

		$goodname						=	$goodnameTmp . $goodnameTmp2;
		$buyername					= $ordername;
		$buyeremail					= $orderemail;
		$buyertel						= $orderhtel1."-".$orderhtel2."-".$orderhtel3;
		$oid								= $ordernum;
		$ini_menuarea_url		= $row_product[pay_img];

		//에스크로일경우 호출할필요 없음.
		if($paymethod != "E") include "od_orderresult_ini.php";	
	
	}

	if($paymethod == "E") {
		include "../odcommon/od_order.head.esc.inc.php";
		include "../odcommon/od_order.body.esc.inc.php";
	} else {
		include "../odcommon/od_order.head.inc.php";
		include "../odcommon/od_order.body.inc.php";
	}



?>
<style>
.style20 {
	color: #FF0000;
	font-weight: bold;
	font-size: 14px;
}
.style21 {color: #333333}
.style24 {
	color: #18abe1;
	font-weight: bold;
}
.style15 {color: #FF0000}
</style>


<iframe name="hidden_frame" src="about:blank" width=100px height=100px frameborder=0 style="display:none"></iframe>

					<!-- top 시작 -->
<? include $_SERVER[DOCUMENT_ROOT]."/pages/subHead.html"; ?>
					<!-- top 끝 -->
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="31">&nbsp;</td>
						</tr>
          </table>
					<!-- main start -->


								<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td valign="top"><table width="855" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td><img src="/img/order_img_02.jpg" width="855" height="123" /></td>
                      </tr>
                    </table>
                      <table width="855" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td height="23"></td>
                            </tr>
                          </table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td><img src="/img/order_img_31.jpg" width="855" height="46" /></td>
                                  </tr>
                                </table>
                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td><img src="/img/order_img_05.jpg" width="855" height="20" /></td>
                                    </tr>
                                  </table>
                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td width="36" valign="top" background="/img/order_img_06.jpg">&nbsp;</td>
                                      <td width="783" valign="top" bgcolor="#ffffff"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td bgcolor="#ffffff"><img src="/img/order_img_32.jpg" width="75" height="24" /></td>
                                        </tr>
                                      </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                <td height="1" bgcolor="#d2dde0"></td>
                                              </tr>
                                            </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td height="30" bgcolor="#eeeeee"><table width="781" border="0" align="center" cellpadding="0" cellspacing="0">
																									<tr>
																										<td width="425" height="38"><div align="center"><strong>상 품 명</strong></div></td>
																										<td width="120"><div align="center"><b>가 격</b></div></td>
																										<td width="120"><div align="center"><b>수 량</b></div></td>
																										<td width="40">&nbsp;</td>
																										<td><div align="center"><b>합 계</b></div></td>
																									</tr>
																								</table></td>
                                                </tr>
                                              </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td height="1" bgcolor="#d2dde0"></td>
                                                </tr>
                                              </table></td>
                                          </tr>
                                        </table>
<?
// 맨 앞의 ^를 제거하기 위함..
$oLogArray = explode("^",preg_replace("[^\^]","",$oLog));
$pLog = explode("^",$pLog);
for($i=0;$i<count($pLog);$i++) {
	list($pCode,$pCount,$pPrice) = split("\|",$pLog[$i],3);
	$row_product_tmp = mysql_fetch_array(mysql_query("select * from odtProduct where code ='".$pCode."'"));
	if($oLogArray[$i]) {	// 해당상품에 대한 옵션내역이 있으면
		$oLogTmp = explode("|",$oLogArray[$i]);
		$pPrice += $oLogTmp[2];
		$row_product_tmp[name] .= "(".$oLogTmp[1].")";
	}
?>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                <td height="37" bgcolor="#ffffff"><table width="781" border="0" align="center" cellpadding="0" cellspacing="0">
																									<tr>
																										<td width="425" height="38"><div align="center"><strong><?=$row_product_tmp[name]?></strong></div></td>
																										<td width="120"><div align="center"><?=number_format($pPrice)?> 원</div></td>
																										<td width="120"><div align="center"><?=$pCount?> 개</div></td>
																										<td width="40">&nbsp;</td>
																										<td><div align="center"><?=number_format($pCount*$pPrice)?> 원</div></td>
																									</tr>
																								</table></td>
                                              </tr>
                                            </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td height="1" bgcolor="#d2dde0"></td>
                                                </tr>
                                              </table></td>
                                          </tr>
                                        </table>
<?
}
?>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td height="21" bgcolor="#ffffff"></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td bgcolor="#ffffff"><img src="/img/order_img_33.jpg" width="136" height="31" /></td>
                                          </tr>
                                        </table>

                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td height="1" bgcolor="#d2dde0"></td>
                                                </tr>
                                              </table>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr>
                                                    <td height="30" bgcolor="#eeeeee"><table width="781" border="0" align="center" cellpadding="0" cellspacing="0">
																											<tr>
																												<td width="95" height="36"><div align="center"><b>항 목</b></div></td>
																												<td width="580"><div align="center"><b>내 용</b></div></td>
																												<td width="30">&nbsp;</td>
																												<td align=right style="padding-right:10px"><b>금 액</b></td>
																											</tr>
																									</table></td>
                                                  </tr>
                                                </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr>
                                                    <td height="1" bgcolor="#d2dde0"></td>
                                                  </tr>
                                              </table></td>
                                          </tr>
                                        </table>
			<!-- 쿠폰 -->
<?
if($cLog) {
	$cLog = explode("^",$cLog);
	for($i=0;$i<count($cLog);$i++) {
		list($cName,$cPrice) = split("\|",$cLog[$i],2);
		if($cName) {
?>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                          <tr>
                                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td height="37"><table width="781" border="0" align="center" cellpadding="0" cellspacing="0">
																										<tr>
																											<td width="95" height="36"><div align="center">할인</div></td>
																											<td width="580"><div align="center"><?=$cName?></div></td>
																											<td width="30">&nbsp;</td>
																											<td align=right style="padding-right:10px">- <?=number_format($cPrice)?> 원</td>
																										</tr>
																								</table></td>
                                                </tr>
                                              </table>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr>
                                                    <td height="1" bgcolor="#d2dde0"></td>
                                                  </tr>
                                              </table></td>
                                          </tr>
                                        </table>
<?
		}
	}
}
?>

			<!-- 루프 끝 -->
<?
if($gPrice) {
?>
			<!-- 적립금 사용내역 -->
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                          <tr>
                                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td height="37"><table width="781" border="0" align="center" cellpadding="0" cellspacing="0">
																										<tr>
																											<td width="95" height="36"><div align="center">할인</div></td>
																											<td width="580"><div align="center">적립금 사용</div></td>
																											<td width="30">&nbsp;</td>
																											<td align=right style="padding-right:10px">- <?=number_format($gPrice)?> 원</td>
																										</tr>
																								</table></td>
                                                </tr>
                                              </table>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr>
                                                    <td height="1" bgcolor="#d2dde0"></td>
                                                  </tr>
                                              </table></td>
                                          </tr>
                                        </table>

<?
}
if($dPrice) {
?>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                          <tr>
                                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td height="37"><table width="781" border="0" align="center" cellpadding="0" cellspacing="0">
																										<tr>
																											<td width="95" height="36"><div align="center">추가</div></td>
																											<td width="580"><div align="center">배송비</div></td>
																											<td width="30">&nbsp;</td>
																											<td background="/images/order_m_06.jpg" align=right style="padding-right:10px">+ <?=number_format($dPrice)?> 원</td>
																										</tr>
																								</table></td>
                                                </tr>
                                              </table>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr>
                                                    <td height="1" bgcolor="#d2dde0"></td>
                                                  </tr>
                                              </table></td>
                                          </tr>
                                        </table>

<?
}
?>

                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                          <tr>
                                            <td height="15"></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                          <tr>
                                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                <td height="1" bgcolor="#d5c4b9"></td>
                                              </tr>
                                            </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="510"></td>
                                                  <td><table width="100%" border="1" bordercolor="#FFFFFF"cellspacing="0" cellpadding="0">
                                                    <tr>
                                                      <td height="28" bgcolor="#f6f2e9"><div align="center" class="style21">총 결제된 금액</div></td>
                                                      <td bgcolor="#eeeeee" align=right ><?=number_format($tPrice)?> 원</td>
                                                      </tr>
                                                    <tr>
                                                      <td height="28" bgcolor="#f6f2e9"><div align="center" class="style21">총 할인 금액</div></td>
                                                      <td bgcolor="#eeeeee" align=right ><strong><?=$sPrice ? "- ".number_format($sPrice) : "0";?> 원</strong></td>
                                                      </tr>
                                                    <tr style='display:none'>
                                                      <td height="28" bgcolor="#f6f2e9"><div align="center" class="style21">배송비</div></td>
                                                      <td bgcolor="#eeeeee" align=right ><strong><?=$dPrice ? "+ ". number_format($dPrice) : "0";?> 원</strong></td>
                                                      </tr>
                                                    <tr>
                                                      <td height="28" bgcolor="#f6f2e9"><div align="center" class="style21">금일 적립 포인트</div></td>
                                                      <td bgcolor="#eeeeee" align=right><strong><?=$gGetPrice ? number_format($gGetPrice) : "0";?> 포인트</strong></td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td height="2" bgcolor="#d5c4b9"></td>
                                                </tr>
                                              </table></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                          <tr>
                                            <td height="15"></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                          <tr>
                                            <td><img src="/img/order_img_34.jpg" width="104" height="31" /></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="171"><img src="/img/order_img_21.jpg" width="171" height="38" /></td>
                                                  <td background="/img/order_img_22.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="15"></td>
                                                        <td><?=$ordername?></td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr>
                                                    <td width="171"><img src="/img/order_img_23.jpg" width="171" height="38" /></td>
                                                    <td background="/img/order_img_22.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                          <td width="15"></td>
                                                          <td><?=$orderhtel1."-".$orderhtel2."-".$orderhtel3?></td>
                                                        </tr>
                                                    </table></td>
                                                  </tr>
                                                </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr>
                                                    <td width="171"><img src="/img/order_img_24.jpg" width="171" height="39" /></td>
                                                    <td background="/img/order_img_25.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                          <td width="15"></td>
                                                          <td><?=$orderemail?></td>
                                                        </tr>
                                                    </table></td>
                                                  </tr>
                                              </table></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                          <tr>
                                            <td height="15"></td>
                                          </tr>
                                        </table>
<?
if($viewDel == 1) {
?>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                          <tr>
                                            <td><img src="/img/order_img_26.jpg" /></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="171"><img src="/img/order_1_title_01.jpg" width="171" height="38" /></td>
                                                  <td background="/img/order_1_title_07.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="15"></td>
                                                        <td><?=$recname?></td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr>
                                                    <td width="171"><img src="/img/order_1_title_03.jpg" width="171" height="38" /></td>
                                                    <td background="/img/order_1_title_07.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                          <td width="15"></td>
                                                          <td><?=$rechtel1."-".$rechtel2."-".$rechtel3?></td>
                                                        </tr>
                                                    </table></td>
                                                  </tr>
                                                </table>
																								<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="171"><img src="/img/order_img_24_.jpg" width="171" height="38" /></td>
                                                  <td background="/img/order_1_title_07.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="15"></td>
                                                        <td><?=$recemail?></td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="171"><img src="/img/order_img_37.jpg" width="171" height="39" /></td>
                                                  <td background="/img/order_img_25.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="15"></td>
                                                        <td><?=htmlspecialchars(stripslashes($comment))?></td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                          <tr>
                                            <td height="15"></td>
                                          </tr>
                                        </table>
<?
}
?>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                          <tr>
                                            <td><img src="/img/order_img_38.jpg" width="73" height="31" /></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                          <tr>
                                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                <td width="171"><img src="/img/order_11_title_01.jpg" width="171" height="38" /></td>
                                                <td background="/img/order_1_title_07.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                      <td width="15"></td>
                                                      <td><span class="style15"><strong><?=number_format($tPrice)?> 원</strong></span></td>
                                                    </tr>
                                                </table></td>
                                              </tr>
                                            </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="171"><img src="/img/order_img_39.jpg" width="171" height="39" /></td>
                                                  <td background="/img/order_img_25.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="15"></td>
                                                        <td>
											<?
											if($paymethod == "B") echo "무통장 입금";
											if($paymethod == "C") echo "신용카드결제";
											if($paymethod == "L") echo "실시간계좌이체";
											if($paymethod == "H") echo "핸드폰결제";
											if($paymethod == "E") echo "무통장 입금 [에스크로결제]";
											?></td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                          <tr>
                                            <td height="20"></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                          <tr>
                                            <td><div align="center" class="unnamed8">결제완료 후에는 주문정보 수정이 되지 않습니다. 다시 한번 주문 사항이 맞는지 확인 하신 후 결제하여 주시기 바랍니다.</div></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                          <tr>
                                            <td height="10"></td>
                                          </tr>
                                        </table>

						<form name=ini method=post action="od_ordercomplete.php" onSubmit="return pay(this)"> 
						<input type="hidden" name="gopaymethod"		value="<?=$gopaymethod?>">
						<input type="hidden" name="paymethod"		value="">
						<input type="hidden" name="goodname"		value="<?=$goodname?>">
						<input type="hidden" name="buyername"		value="<?=$buyername?>">
						<input type="hidden" name="buyeremail"		value="<?=$buyeremail?>">
						<input type="hidden" name="buyertel"		value="<?=$buyertel?>"	>
		<?
		if($paymethod == "E") {
		?>
						<input type="hidden" name="price"			value="<?=$tPrice?>"	>
						<input type="hidden" name="mid"				value="<?=$row_setup[P_SID]?>"    >
						<input type="hidden" name="nointerest"		value="no">
						<input type="hidden" name="quotabase"		value="선택:일시불">
						<input type="hidden" name="acceptmethod"	value="SKIN(ORIGINAL):HPP(1):OCB">
		<?
		} else {
		?>

						<input type="hidden" name="acceptmethod"	value="HPP(2):Card(0):OCB:receipt:cardpoint" size=20 >
		<?
		}
		?>


						<input type="hidden" name=oid size=40		value="<?=$oid?>">

						<?/* 기타설정 */?>
						<input type=hidden name=currency size=20 value="WON">

						<?/*
						플러그인 좌측 상단 상점 로고 이미지 사용
						이미지의 크기 : 90 X 34 pixels
						플러그인 좌측 상단에 상점 로고 이미지를 사용하실 수 있으며,
						주석을 풀고 이미지가 있는 URL을 입력하시면 플러그인 상단 부분에 상점 이미지를 삽입할수 있습니다.
						*/?>
						<input type=hidden name=ini_logoimage_url  value="">


						<?/*
						좌측 결제메뉴 위치에 이미지 추가
						이미지의 크기 : 단일 결제 수단 - 91 X 148 pixels, 신용카드/ISP/계좌이체/가상계좌 - 91 X 96 pixels
						좌측 결제메뉴 위치에 미미지를 추가하시 위해서는 담당 영업대표에게 사용여부 계약을 하신 후
						주석을 풀고 이미지가 있는 URL을 입력하시면 플러그인 좌측 결제메뉴 부분에 이미지를 삽입할수 있습니다.
						*/?>
						<input type=hidden name=ini_menuarea_url value="http://<?=$_SERVER[HTTP_HOST].$ini_menuarea_url?>">


						<?/*
						플러그인에 의해서 값이 채워지거나, 플러그인이 참조하는 필드들
						삭제/수정 불가
						uid 필드에 절대로 임의의 값을 넣지 않도록 하시기 바랍니다.
						*/?>
		<?
		if($paymethod != "E") {
		?>
						<input type=hidden name=ini_encfield value="<?php echo($inipay->GetResult("encfield")); ?>">
						<input type=hidden name=ini_certid value="<?php echo($inipay->GetResult("certid")); ?>">
		<?
		}
		?>
						<input type=hidden name=quotainterest value="">
						<input type=hidden name=cardcode value="">
						<input type=hidden name=cardquota value="">
						<input type=hidden name=rbankcode value="">
						<input type=hidden name=reqsign value="DONE">
						<input type=hidden name=encrypted value="">
						<input type=hidden name=sessionkey value="">
						<input type=hidden name=uid value=""> 
						<input type=hidden name=sid value="">
						<input type=hidden name=version value=4000>
						<input type=hidden name=clickcontrol value="">


                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                          <tr>
                                            <td><div align="center"><input type="image" src="/img/order_img_40.jpg" width="133" height="40" /></div></td>
                                          </tr>
                                        </table>
						</form>


                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                          <tr>
                                            <td height="20"></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td><img src="/img/order_img_41.jpg" width="783" height="295" /></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td><img src="/img/order_img_42.jpg" width="783" height="508" /></td>
                                          </tr>
                                        </table></td>
                                      <td width="36" valign="top" background="/img/order_img_08.jpg">&nbsp;</td>
                                    </tr>
                                  </table></td>
                              </tr>
                            </table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td><img src="/img/order_img_29.jpg" width="855" height="35" /></td>
                              </tr>
                            </table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td>&nbsp;</td>
                              </tr>
                            </table></td>
                        </tr>
                      </table></td>
                  </tr>
                </table>










					<!-- main end -->
					<!-- bottom 시작 -->
<? include_once $_SERVER[DOCUMENT_ROOT]."/pages/subFoot.html"; ?>
					<!-- bottom 끝 -->
