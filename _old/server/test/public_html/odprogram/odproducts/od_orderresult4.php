<?
    include "../odcommon/od_config.inc.php";
    include "../odcommon/od_function.inc.php";
    include_once "../odcommon/od_lib.inc.php";

    if(!$row_member[id] || !$_POST[tPrice]) {
        echo "<script>alert('잘못된 접근입니다.');location.href='/';</script>";
        exit;
    }


    # 주문번호 쿠키로 꾸어놓음.. 주문서 수정할경우를 위해.
    setCookie("prevOrdernum",$ordernum);

    $parent_code    =   addslashes(trim($_POST[parent_code]));// 부모 상품코드
    $ordernum           = addslashes(trim($_POST[ordernum]));       // 주문번호
    $ordertel1      = addslashes(trim($_POST[ordertel1]));  // 주문자 전화
    $ordertel2      = addslashes(trim($_POST[ordertel2]));  //
    $ordertel3      = addslashes(trim($_POST[ordertel3]));  //
    $cLog                   = addslashes(trim($_POST[cLog]));               // 쿠폰사용로그
    $pLog                   = addslashes(trim($_POST[pLog]));               // 상품구매로그
    $oLog                   = addslashes(trim($_POST[oLog]));               // 구매한상품옵션로그
    $gPrice             = addslashes(trim($_POST[gPrice]));         // 사용한 지포인트
    $gGetPrice      = addslashes(trim($_POST[gGetPrice]));  // 적립될 지포인트
    $dPrice             = addslashes(trim($_POST[dPrice]));         // 배송비
    $sPrice             = addslashes(trim($_POST[sPrice]));         // 총할인금액
    $tPrice             = addslashes(trim($_POST[tPrice]));         // 최종결제금액
    $ordername      = addslashes(trim($_POST[ordername]));  // 주문자명
    $orderhtel1     = addslashes(trim($_POST[orderhtel1])); // 주문자핸드폰
    $orderhtel2     = addslashes(trim($_POST[orderhtel2])); //
    $orderhtel3     = addslashes(trim($_POST[orderhtel3])); //
    $orderemail     = addslashes(trim($_POST[orderemail])); // 주문자 이메일
    $recname            = addslashes(trim($_POST[recname]));        // 수취인명
    $rectel1            = addslashes(trim($_POST[rectel1]));        // 수취인전화
    $rectel2            = addslashes(trim($_POST[rectel2]));        //
    $rectel3            = addslashes(trim($_POST[rectel3]));        //
    $recemail           = addslashes(trim($_POST[recemail]));       // 수취인이메일
    $rechtel1           = addslashes(trim($_POST[rechtel1]));       // 수취인핸드폰
    $rechtel2           = addslashes(trim($_POST[rechtel2]));       //
    $rechtel3           = addslashes(trim($_POST[rechtel3]));       //
    $reczip1            = addslashes(trim($_POST[reczip1]));        // 수취인 우편번호
    $reczip2            = addslashes(trim($_POST[reczip2]));        //
    $recaddress     = addslashes(trim($_POST[recaddress])); // 수취인 주소
    $recaddress1    = addslashes(trim($_POST[recaddress1]));//
    $viewDel            =   addslashes(trim($_POST[viewDel]));      //
    $comment            = addslashes(trim($_POST[comment]));        // 배송희망멘트
    $taxorder           = addslashes(trim($_POST[taxorder]));       // 세금계산서신청유무 (Y / N)

    $companynum     = addslashes(trim($_POST[companynum])); // 사업자등록번호
    $companyname    = addslashes(trim($_POST[companyname]));// 상호명
    $ceoname            = addslashes(trim($_POST[ceoname]));        // 대표자명
    $companyadd     = addslashes(trim($_POST[companyadd])); // 사업장주소
    $taxstatus      = addslashes(trim($_POST[taxstatus]));  // 사업형태
    $taxitem            = addslashes(trim($_POST[taxitem]));        // 종목
    $paymethod      = addslashes(trim($_POST[paymethod]));  // 결제방법 (무통장 B , 카드 C , 실시간계좌이체 L)
    $paybankname    = addslashes(trim($_POST[paybankname]));// 입금계좌 (은행명/예금주/계좌번호)
    $paydatey           = addslashes(trim($_POST[paydatey]));       // 입금예정일
    $paydatem           = addslashes(trim($_POST[paydatem]));       //
    $paydated           = addslashes(trim($_POST[paydated]));       //
    $payname            = addslashes(trim($_POST[payname]));        // 입금자명

    $orderid            =   $row_member[id] ? $row_member[id] : $_SESSION[Gid];             // 주문자 아이디, 비회원은 guest

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

    if($isOrder)    {    //이미 등록되어있는 주문건이면 수정.

        #수정 .
        $que = "update odtOrder set
                        partnerCode         = '".$row_product[customerCode]."',
                        orderid                 = '".$orderid."',
                        ordername               = '".$ordername."',
                        orderemail          = '".$orderemail."',
                        ordertel1               = '".$ordertel1."',
                        ordertel2               = '".$ordertel2."',
                        ordertel3               = '".$ordertel3."',
                        orderhtel1          = '".$orderhtel1."',
                        orderhtel2          = '".$orderhtel2."',
                        orderhtel3          = '".$orderhtel3."',
                        recname                 = '".$recname."',
                        recemail                = '".$recemail."',
                        rectel1                 = '".$rectel1."',
                        rectel2                 = '".$rectel2."',
                        rectel3                 = '".$rectel3."',
                        rechtel1                = '".$rechtel1."',
                        rechtel2                = '".$rechtel2."',
                        rechtel3                = '".$rechtel3."',
                        reczip1                 = '".$reczip1."',
                        reczip2                 = '".$reczip2."',
                        recaddress          = '".$recaddress."',
                        recaddress1         = '".$recaddress1."',
                        viewDel                 =   '".$viewDel."',
                        comment                 = '".$comment."',
                        taxorder                = '".$taxorder."',
                        companynum          = '".$companynum."',
                        companyname         = '".$companyname."',
                        ceoname                 = '".$ceoname."',
                        companyadd          = '".$companyadd."',
                        taxstatus               = '".$taxstatus."',
                        taxitem                 = '".$taxitem."',
                        cLog                        = '".$cLog."',
                        pLog                        = '".$pLog."',
                        oLog                        = '".$oLog."',
                        gPrice                  = '".$gPrice."',
                        gGetPrice               = '".$gGetPrice."',
                        dPrice                  = '".$dPrice."',
                        sPrice                  = '".$sPrice."',
                        tPrice                  = '".$tPrice."',
                        pointed                 = 'N',
                        paymethod               = '".$paymethod."',
                        paystatus               = 'N',
                        paybankname         = '".$paybankname[0]."/".$paybankname[1]."',
                        paybanknum          = '".$paybankname[2]."',
                        paydatey                = '".$paydatey."',
                        paydatem                = '".$paydatem."',
                        paydated                = '".$paydated."',
                        payname                 = '".$payname."',
                        md_name                 = '".$row_product[md_name]."',
                        orderweb                =   '".$HTTP_USER_AGENT."',
                        hID                         =   '".$_COOKIE[hID]."',
                        ip                          = '".$_SERVER[REMOTE_ADDR]."'
                        where
                        ordernum                = '".$ordernum."'";

    }   else { // 없으면 새등록


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
                        ordernum                = '".$ordernum."',
                        partnerCode         = '".$row_product[customerCode]."',
                        orderid                 = '".$orderid."',
                        ordername               = '".$ordername."',
                        orderemail          = '".$orderemail."',
                        ordertel1               = '".$ordertel1."',
                        ordertel2               = '".$ordertel2."',
                        ordertel3               = '".$ordertel3."',
                        orderhtel1          = '".$orderhtel1."',
                        orderhtel2          = '".$orderhtel2."',
                        orderhtel3          = '".$orderhtel3."',
                        recname                 = '".$recname."',
                        recemail                = '".$recemail."',
                        rectel1                 = '".$rectel1."',
                        rectel2                 = '".$rectel2."',
                        rectel3                 = '".$rectel3."',
                        rechtel1                = '".$rechtel1."',
                        rechtel2                = '".$rechtel2."',
                        rechtel3                = '".$rechtel3."',
                        reczip1                 = '".$reczip1."',
                        reczip2                 = '".$reczip2."',
                        recaddress          = '".$recaddress."',
                        recaddress1         = '".$recaddress1."',
                        viewDel                 =   '".$viewDel."',
                        comment                 = '".$comment."',
                        taxorder                = '".$taxorder."',
                        companynum          = '".$companynum."',
                        companyname         = '".$companyname."',
                        ceoname                 = '".$ceoname."',
                        companyadd          = '".$companyadd."',
                        taxstatus               = '".$taxstatus."',
                        taxitem                 = '".$taxitem."',
                        cLog                        = '".$cLog."',
                        pLog                        = '".$pLog."',
                        oLog                        = '".$oLog."',
                        gPrice                  = '".$gPrice."',
                        gGetPrice               = '".$gGetPrice."',
                        dPrice                  = '".$dPrice."',
                        sPrice                  = '".$sPrice."',
                        tPrice                  = '".$tPrice."',
                        pointed                 = 'N',
                        paymethod               = '".$paymethod."',
                        paystatus               = 'N',
                        paybankname         = '".$paybankname[0]."/".$paybankname[1]."',
                        paybanknum          = '".$paybankname[2]."',
                        paydatey                = '".$paydatey."',
                        paydatem                = '".$paydatem."',
                        paydated                = '".$paydated."',
                        payname                 = '".$payname."',
                        orderweb                =   '".$HTTP_USER_AGENT."',
                        orderdate               =   now(),
                        orderstatus         =   'Y',
                        md_name                 = '".$row_product[md_name]."',
                        hID                         =   '".$_COOKIE[hID]."',
                        ip                          = '".$_SERVER[REMOTE_ADDR]."'";
    }

    $res = mysql_query($que);
    if(!$res) {
        error_msgall('주문서 작성중 오류가 발생하였습니다');
        exit;
    }
    if($paymethod == "C" || $paymethod == "L" || $paymethod == "H" || $paymethod == "E" ) {

        if($paymethod == "C") $gopaymethod = "card";
        if($paymethod == "H") $gopaymethod = "HPP";
        if($paymethod == "L") $gopaymethod = "iche";
        if($paymethod == "E") $gopaymethod = "VBank";

        $pLogTmp2 = explode("^",$pLog);
        $goodnameTmp = @mysql_result(mysql_query("select name from odtProduct where code ='".reset(explode("|",$pLogTmp2[0]))."'"),0);
        if(count($pLogTmp2) > 1) {
            $goodnameTmp2 = " 외 ".(count($pLogTmp2)-1)."건";
        } else $goodnameTmp2='';

        $goodname                       =   $goodnameTmp . $goodnameTmp2;
        $buyername                  = $ordername;
        $buyeremail                 = $orderemail;
        $buyertel                       = $orderhtel1."-".$orderhtel2."-".$orderhtel3;
        $oid                                = $ordernum;
        $ini_menuarea_url       = $row_product[pay_img];
    }


    include "../odcommon/od_order4.head.inc.php";
    include "../odcommon/od_order4.body.inc.php";



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
                                      <td width="783" valign="top" bgcolor="#ffffff">





<?PHP
	// 주문확인 및 결제 공통 정보 ---> PG사 추가에 따른 공통 파일 마련
	// 배송기능 추가에 따른 수신자 정보  추가
	include "od_orderresult.common_inc.php";

    if ("" == trim($recaddress)) { $recaddress = "주소없음";    }
?>

<form name="fm" method="post" action="od_ordercomplete4.php" >
<input type="hidden" name="allat_shop_id"           value="<?=$row_setup[P_ID]?>">              <!-- 상점id -->
<input type="hidden" name="allat_order_no"          value="<?=$ordernum?>">                     <!-- 주문번호 -->
<input type="hidden" name="allat_amt"               value="<?=$tPrice?>">                       <!-- 결제금액 -->
<input type="hidden" name="allat_pmember_id"        value="<?=$orderid?>">                      <!-- 회원아이디 -->
<input type="hidden" name="allat_product_cd"        value="<?=$parent_code?>">                  <!-- 상품코드 -->
<input type="hidden" name="allat_product_nm"        value="<?=$goodname?>">                     <!-- 상품명 -->
<input type="hidden" name="allat_buyer_nm"          value="<?=$ordername?>">                    <!-- 결제자성명 -->
<input type="hidden" name="allat_recp_nm"           value="<?=$recname?>">                      <!-- 수취인성명 -->
<input type="hidden" name="allat_recp_addr"         value="<?=$recaddress." ".$recaddress1?>">  <!-- 수취인주소 -->
<input type="hidden" name="allat_enc_data"          value="">                                   <!-- 주문정보암호화필드 -->

<? 

// 테스트결제 체크시 //////////////////////////////////////////////////////////
if ("1" == $row_setup[P_SID]) { $tmp_test = "Y"; } else { $temp_test = "N";   } 

// 에스크로 체크시 ////////////////////////////////////////////////////////////
if ("1" == $row_setup[P_SKBN]) { $tmp_es = "Y"; } else { $tmp_es = "N";   } 

// 결제방법 체크 //////////////////////////////////////////////////////////////
$tmp_card = "N";
$tmp_bank = "N";

if ("L" == $paymethod)
{
    $tmp_bank = "Y";
}
else
{
    $tmp_card = "Y";
}

?>
<input type="hidden" name="allat_test_yn"           value="<?=$tmp_test?>">                     <!-- 테스트여부 -->
<input type="hidden" name="allat_cardes_yn"         value="<?=$tmp_es?>">                       <!-- 카드 에스크로 -->
<input type="hidden" name="allat_bankes_yn"         value="<?=$tmp_es?>">                       <!-- 계좌이체 에스크로 -->
<input type="hidden" name="paymethod"               value="<?=$paymethod?>">                    <!-- 결제방법 -->
<input type="hidden" name="Amt"                     value="<?=$tPrice?>">                       <!-- 결제금액 -->

<input type="hidden" name="allat_card_yn"           value="<?=$tmp_card?>">                     <!-- 신용카드 사용여부 -->
<input type="hidden" name="allat_bank_yn"           value="<?=$tmp_bank?>">                     <!-- 계좌이체 사용여부 -->
<input type="hidden" name="allat_vbank_yn"          value="N">                                  <!-- 무통장 사용여부 -->
<input type="hidden" name="allat_hp_yn"             value="N">                                  <!-- 휴대폰 사용여부 -->
<input type="hidden" name="allat_ticket_yn"         value="N">                                  <!-- 상품권 사용여부 -->



                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                          <tr>
                                            <td><div align="center"><a href="javascript:ftn_approval(document.fm);"><img src="/img/order_img_40.jpg" style='width:133px; height:40px; border:0;' /></a></div></td>
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

