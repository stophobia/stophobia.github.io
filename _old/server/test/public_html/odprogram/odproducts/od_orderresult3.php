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


    include "../odcommon/od_order3.head.inc.php";
    include "../odcommon/od_order3.body.inc.php";



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
?>









<form name="order_info" method="post" action="od_ordercomplete3.php" >
<input type=hidden name=paymethod           value="<?=$paymethod?>">    <!-- 결제방법 -->
<input type=hidden name=OrdNo               value="<?=$ordernum?>">     <!-- 주문번호 -->
<input type=hidden name=Amt                 value="<?=$tPrice ?>">          <!-- 금액 -->
<input type=hidden name=StoreNm             value="<?=$StoreNm ?>">     <!-- 상점명 -->
<input type=hidden name=ProdNm              value="<?=$goodname?>">     <!-- 상품명 -->
<input type=hidden name=MallUrl             value="<?=$_SERVER[HTTP_HOST]?>">       <!-- 상점url -->
<input type=hidden name=UserId              value="<?=$orderid?>">      <!-- 아이디 -->
<input type=hidden name=UserEmail           value="<?=$orderemail?>">   <!-- 주문자 메일 -->
<input type=hidden name=OrdNm               value="<?=$ordername?>">    <!-- 주문자명 -->
<input type=hidden name=RcpNm               value="<?=$recname?>">      <!-- 수취인 -->
<input type=hidden name=RcpPhone            value="<?=$rechtel1."-".$rechtel2."-".$rechtel3?>"> <!-- 수취인 연락처 -->
<input type=hidden name=DlvAddr             value="<?=$recaddress." ".$recaddress1?>">  <!-- 배송지주소 -->
<input type=hidden name=Remark              value="<?=$comment?>">  <!-- 요구사항 -->
<?

if      ("C" == $paymethod) { $pay_method = "100000000000"; }   // 신용카드
else if ("L" == $paymethod) { $pay_method = "010000000000"; }   // 실시간 계좌이체

?>
<input type="hidden" name="pay_method"      value="<?= $pay_method ?>" />   <!-- 결제방법(pay_method)-->
<input type="hidden" name="ordr_idxx"       value="<?= $ordernum ?>" />     <!-- 주문번호(ordr_idxx) -->
<input type="hidden" name="good_name"       value="<?= $goodname?>" />      <!-- 상품명(good_name) -->
<input type="hidden" name="good_mny"        value="<?= $tPrice ?>" />           <!-- 결제금액(good_mny) - ※ 필수 : 값 설정시 ,(콤마)를 제외한 숫자만 입력하여 주십시오. -->
<input type="hidden" name="buyr_name"       value="<?= $ordername ?>"/>             <!-- 주문자명(buyr_name) -->
<input type="hidden" name="buyr_mail"       value="<?= $orderemail ?>" />   <!-- 주문자 E-mail(buyr_mail) -->
<input type="hidden" name="buyr_tel1"       value="<?= $orderhtel1."-".$orderhtel2."-".$orderhtel3 ?>"/><!-- 주문자 연락처1(buyr_tel1) -->
<input type="hidden" name="buyr_tel2"       value="<?= $orderhtel1."-".$orderhtel2."-".$orderhtel3 ?>"/><!-- 휴대폰번호(buyr_tel2) -->
<input type="hidden" name="req_tx"          value="pay" /><?    // 요청종류 : 승인(pay)/취소,매입(mod) 요청시 사용 ?>
<input type="hidden" name="site_cd"         value="<?=$g_conf_site_cd   ?>" />
<input type="hidden" name="site_key"        value="<?=$g_conf_site_key  ?>" />
<input type="hidden" name="site_name"       value="<?=$g_conf_site_name ?>" />
<input type="hidden" name="quotaopt"        value="12"/>
<input type="hidden" name="currency"        value="WON"/><!-- 필수 항목 : 결제 금액/화폐단위 -->
<input type="hidden" name="module_type"     value="01"/><!-- PLUGIN 설정 정보입니다(변경 불가) -->
<input type="hidden" name="epnt_issu"       value="" /><!-- 복합 포인트 결제시 넘어오는 포인트사 코드 : OK캐쉬백(SCSK), 베네피아 복지포인트(SCWB) -->
<input type="hidden" name="res_cd"          value=""/>
<input type="hidden" name="res_msg"         value=""/>
<input type="hidden" name="tno"             value=""/>
<input type="hidden" name="trace_no"        value=""/>
<input type="hidden" name="enc_info"        value=""/>
<input type="hidden" name="enc_data"        value=""/>
<input type="hidden" name="ret_pay_method"  value=""/>
<input type="hidden" name="tran_cd"         value=""/>
<input type="hidden" name="bank_name"       value=""/>
<input type="hidden" name="bank_issu"       value=""/>
<input type="hidden" name="use_pay_method"  value=""/>
<!--  현금영수증 관련 정보 : Payplus Plugin 에서 설정하는 정보입니다 -->
<input type="hidden" name="cash_tsdtime"    value=""/>
<input type="hidden" name="cash_yn"         value=""/>
<input type="hidden" name="cash_authno"     value=""/>
<input type="hidden" name="cash_tr_code"    value=""/>
<input type="hidden" name="cash_id_info"    value=""/>

<!-- 에스크로 관련 부분 -->
<?
if ("1" == $row_setup[P_SKBN])
{
?>
    <input type="hidden" name="rcvr_name" value="<?=$recname?>"/>   <!-- 수취인 -->
    <input type="hidden" name="rcvr_tel1" value="<?=$rechtel1."-".$rechtel2."-".$rechtel3?>"/> <!-- 수취인 연락처 -->
    <input type="hidden" name="rcvr_tel2" value="<?=$rechtel1."-".$rechtel2."-".$rechtel3?>"/>    <!-- 수취인 핸드폰 -->
    <input type="hidden" name="rcvr_mail" value="<?=$orderemail?>" />  <!-- 수취인 이메일 -->
    <input type="hidden" name="rcvr_zipx" value=""/>   <!-- 우편번호 -->
    <input type="hidden" name="rcvr_add1" value=""/>
    <input type="hidden" name="rcvr_add2" value="<?=$recaddress." ".$recaddress1?>"/>

    <input type="hidden" name="escw_used"       value="Y"/>
    <!-- 에스크로 결제처리 모드 : 에스크로: Y, 일반: N, KCP 설정 조건: O  -->
    <input type="hidden" name="pay_mod"         value="O"/>
    <!-- 배송 소요일 : 예상 배송 소요일을 입력 -->
    <input type="hidden"  name="deli_term" value="01"/>
    <!-- 장바구니 상품 개수 : 장바구니에 담겨있는 상품의 개수를 입력(good_info의 seq값 참조) -->
    <input type="hidden"  name="bask_cntx" value="1"/>
    <!-- 장바구니 상품 상세 정보 (자바 스크립트 샘플 create_goodInfo()가 온로드 이벤트시 설정되는 부분입니다.) -->
    <input type="hidden" name="good_info"       value="" />
<?
}
?>

<?
/* 해당 카드를 결제창에서 보이지 않게 하여 고객이 해당 카드로 결제할 수 없도록 합니다. (카드사 코드는 매뉴얼을 참고)
<input type="hidden" name="not_used_card" value="CCPH:CCSS:CCKE:CCHM:CCSH:CCLO:CCLG:CCJB:CCHN:CCCH"/> */

/* 신용카드 결제시 OK캐쉬백 적립 여부를 묻는 창을 설정하는 파라미터 입니다
 OK캐쉬백 포인트 가맹점의 경우에만 창이 보여집니다
<input type="hidden" name="save_ocb"        value="Y"/> */

/* 고정 할부 개월 수 선택 value값을 "7" 로 설정했을 경우 => 카드결제시 결제창에 할부 7개월만 선택가능
<input type="hidden" name="fix_inst"        value="07"/> */

/*  무이자 옵션
※ 설정할부    (가맹점 관리자 페이지에 설정 된 무이자 설정을 따른다)                             - "" 로 설정
※ 일반할부    (KCP 이벤트 이외에 설정 된 모든 무이자 설정을 무시한다)                           - "N" 로 설정
※ 무이자 할부 (가맹점 관리자 페이지에 설정 된 무이자 이벤트 중 원하는 무이자 설정을 세팅한다)   - "Y" 로 설정
<input type="hidden" name="kcp_noint"       value=""/> */
/*  무이자 설정
※ 주의 1 : 할부는 결제금액이 50,000 원 이상일 경우에만 가능
※ 주의 2 : 무이자 설정값은 무이자 옵션이 Y일 경우에만 결제 창에 적용
예) 전 카드 2,3,6개월 무이자(국민,비씨,엘지,삼성,신한,현대,롯데,외환) : ALL-02:03:04
BC 2,3,6개월, 국민 3,6개월, 삼성 6,9개월 무이자 : CCBC-02:03:06,CCKM-03:06,CCSS-03:06:04
<input type="hidden" name="kcp_noint_quota" value="CCBC-02:03:06,CCKM-03:06,CCSS-03:06:09"/> */

/*  가상계좌 은행 선택 파라미터
※ 해당 은행을 결제창에서 보이게 합니다.(은행코드는 매뉴얼을 참조) */
?>
<input type="hidden" name="wish_vbank_list" value="05:03:04:07:11:23:26:32:34:81:71"/>
<?
/*  가상계좌 입금 기한 설정하는 파라미터 - 발급일 + 3일
<input type="hidden" name="vcnt_expire_term" value="3"/> */

/*  가상계좌 입금 시간 설정하는 파라미터
HHMMSS형식으로 입력하시기 바랍니다
설정을 안하시는경우 기본적으로 23시59분59초가 세팅이 됩니다
<input type="hidden" name="vcnt_expire_term_time" value="120000"/> */


/* 포인트 결제시 복합 결제(신용카드+포인트) 여부를 결정할 수 있습니다.- N 일경우 복합결제 사용안함 */
?>
<input type="hidden" name="complex_pnt_yn" value="N"/>

<?
/* 문화상품권 결제시 가맹점 고객 아이디 설정을 해야 합니다.(필수 설정)
<input type="hidden" name="tk_shop_id" value=""/>    */


/* 현금영수증 등록 창을 출력 여부를 설정하는 파라미터 입니다
※ Y : 현금영수증 등록 창 출력
※ N : 현금영수증 등록 창 출력 안함
※ 주의 : 현금영수증 사용 시 KCP 상점관리자 페이지에서 현금영수증 사용 동의를 하셔야 합니다 */
?>
<input type="hidden" name="disp_tax_yn"     value="Y"/>
<?
/* 결제창에 가맹점 사이트의 로고를 플러그인 좌측 상단에 출력하는 파라미터 입니다
업체의 로고가 있는 URL을 정확히 입력하셔야 하며, 최대 150 X 50  미만 크기 지원
※ 주의 : 로고 용량이 150 X 50 이상일 경우 site_name 값이 표시됩니다. */
?>
<!--<input type="hidden" name="site_logo"       value="http://<?= $_SERVER[HTTP_HOST] ?>/images/group/pg_logo.gif" />-->

<?  /* 결제창 영문 표시 파라미터 입니다. 영문을 기본으로 사용하시려면 Y로 세팅하시기 바랍니다
2010-06월 현재 신용카드와 가상계좌만 지원됩니다 */
?>
<input type="hidden" name="eng_flag"      value="N">
<?
/* KCP는 과세상품과 비과세상품을 동시에 판매하는 업체들의 결제관리에 대한 편의성을 제공해드리고자,
복합과세 전용 사이트코드를 지원해 드리며 총 금액에 대해 복합과세 처리가 가능하도록 제공하고 있습니다

복합과세 전용 사이트 코드로 계약하신 가맹점에만 해당이 됩니다

상품별이 아니라 금액으로 구분하여 요청하셔야 합니다

총결제 금액은 과세금액 + 부과세 + 비과세금액의 합과 같아야 합니다.
(good_mny = comm_tax_mny + comm_vat_mny + comm_free_mny)

<input type="hidden" name="tax_flag"          value="TG03">     <!-- 변경불가    -->
<input type="hidden" name="comm_tax_mny"      value="">         <!-- 과세금액    -->
<input type="hidden" name="comm_vat_mny"      value="">         <!-- 부가세      -->
<input type="hidden" name="comm_free_mny"     value="">         <!-- 비과세 금액 -->

skin_indx 값은 스킨을 변경할 수 있는 파라미터이며 총 7가지가 지원됩니다.
변경을 원하시면 1부터 7까지 값을 넣어주시기 바랍니다. */
?>
<input type="hidden" name="skin_indx"      value="1">



                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                          <tr>
                                            <td><div align="center"><a href="javascript:onload_pay(document.order_info);"><img src="/img/order_img_40.jpg" style='width:133px; height:40px; border:0;' /></a></div></td>
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

