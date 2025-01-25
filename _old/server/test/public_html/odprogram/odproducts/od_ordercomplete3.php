<?
## ConnectINFO.inc.php 파일 인클루드 ############################
include "../odcommon/od_config.inc.php";
include "$folderpath_common/od_function.inc.php";
include "$folderpath_common/od_lib.inc.php";

// sms문구 주문시회원에게 보내는 문구 추출 ////////////////////////////////////
$mem_smsQuery  = " SELECT * FROM m_sms_set WHERE smskbn = 'order_mem' ";
$mem_smsResult = mysql_query($mem_smsQuery);
$mem_smsRecord = mysql_fetch_array($mem_smsResult);

// 주문시 운영자에게 보내는 문구 추출 /////////////////////////////////////////
$adm_smsQuery  = " SELECT * FROM m_sms_set WHERE smskbn = 'order_adm' ";
$adm_smsResult = mysql_query($adm_smsQuery);
$adm_smsRecord = mysql_fetch_array($adm_smsResult);



# 제휴마케팅 정보 추출
$cInfo = mysql_fetch_array(mysql_query("select * from odtClick where sc_idx='1'"));

// 상품레코드 입력.
function sellRecord($orow)
{
    global $_SERVER;

    // 회원정보
    $row_memberInfo = mysql_fetch_array(mysql_query("select address,age,Mlevel,actionLevel from odtMember where id ='".$orow[orderid]."'"));

    // 상품코드
    $parent_code = mysql_result(mysql_query("select parent_code from odtProduct where code = '".reset(explode("|",$orow[pLog]))."'"),0);


    // 구매까지 걸린 시간
    $reTimeTmp = @mysql_result(mysql_query("select unix_timestamp(date) from odtBuyTime where ip='".$_SERVER[REMOTE_ADDR]."' and date like '".date('Y-m-d')."%' order by date desc"),0);
    $reTimeTmp = $reTimeTmp ? $reTimeTmp : time();
    $reTime = time() - $reTimeTmp;
                            
    $reQue = "insert into odtReport set
                        reID            = '".$orow[orderid]."',
                        reCode          = '".$parent_code."',
                        reAge           = '".$row_memberInfo[age]."',
                        rePosition      = '".reset(explode(" ",$row_memberInfo[address]))."',
                        reLevel         = '".$row_memberInfo[actionLevel]."',
                        reTime          = '".$reTime."',
                        reRegidate      = now()";
    mysql_query($reQue);

    return;
}

//echo "->".$paymethod."<br>";exit;

if($paymethod == "B" || $paymethod == "G")
{ 
    //무통장 입금이나 전액 포인트 결제시 바로 주문완료페이지로 오므로 주문테이블에 입력.

    # 주문번호 쿠키로 꾸어놓음.. 주문서 수정할경우를 위해.
    setCookie("pre_ordernum",$ordernum);

    $parent_code    =   addslashes(trim($_POST[parent_code]));  // 부모 상품코드
    $ordernum       = addslashes(trim($_POST[ordernum]));       // 주문번호
    $ordertel1      = addslashes(trim($_POST[ordertel1]));      // 주문자 전화
    $ordertel2      = addslashes(trim($_POST[ordertel2]));      //
    $ordertel3      = addslashes(trim($_POST[ordertel3]));      //
    $cLog           = addslashes(trim($_POST[cLog]));           // 쿠폰사용로그
    $pLog           = addslashes(trim($_POST[pLog]));           // 상품구매로그 
    $oLog           = addslashes(trim($_POST[oLog]));           // 구매한상품옵션로그
    $gPrice         = addslashes(trim($_POST[gPrice]));         // 사용한 포인트
    $gGetPrice      = addslashes(trim($_POST[gGetPrice]));      // 적립될 포인트
    $dPrice         = addslashes(trim($_POST[dPrice]));         // 배송비
    $sPrice         = addslashes(trim($_POST[sPrice]));         // 총할인금액
    $tPrice         = addslashes(trim($_POST[tPrice]));         // 최종결제금액
    $ordername      = addslashes(trim($_POST[ordername]));      // 주문자명
    $orderhtel1     = addslashes(trim($_POST[orderhtel1]));     // 주문자핸드폰
    $orderhtel2     = addslashes(trim($_POST[orderhtel2]));     //
    $orderhtel3     = addslashes(trim($_POST[orderhtel3]));     //
    $orderemail     = addslashes(trim($_POST[orderemail]));     // 주문자 이메일
    $recname        = addslashes(trim($_POST[recname]));        // 수취인명
    $rectel1        = addslashes(trim($_POST[rectel1]));        // 수취인전화
    $recemail       = addslashes(trim($_POST[recemail]));       // 수취인이메일
    $rectel2        = addslashes(trim($_POST[rectel2]));        //
    $rectel3        = addslashes(trim($_POST[rectel3]));        //
    $rechtel1       = addslashes(trim($_POST[rechtel1]));       // 수취인핸드폰
    $rechtel2       = addslashes(trim($_POST[rechtel2]));       //
    $rechtel3       = addslashes(trim($_POST[rechtel3]));       //
    $reczip1        = addslashes(trim($_POST[reczip1]));        // 수취인 우편번호
    $reczip2        = addslashes(trim($_POST[reczip2]));        //
    $recaddress     = addslashes(trim($_POST[recaddress]));     // 수취인 주소
    $recaddress1    = addslashes(trim($_POST[recaddress1]));    //
    $viewDel        = addslashes(trim($_POST[viewDel]));        //
    $comment        = addslashes(trim($_POST[comment]));        // 배송희망멘트
    $taxorder       = addslashes(trim($_POST[taxorder]));       // 세금계산서신청유무 (Y / N)
    $companynum     = addslashes(trim($_POST[companynum]));     // 사업자등록번호
    $companyname    = addslashes(trim($_POST[companyname]));    // 상호명
    $ceoname        = addslashes(trim($_POST[ceoname]));        // 대표자명
    $companyadd     = addslashes(trim($_POST[companyadd]));     // 사업장주소
    $taxstatus      = addslashes(trim($_POST[taxstatus]));      // 사업형태
    $taxitem        = addslashes(trim($_POST[taxitem]));        // 종목
    $paymethod      = addslashes(trim($_POST[paymethod]));      // 결제방법 (무통장 B , 카드 C , 실시간계좌이체 L)
    $paybankname    = addslashes(trim($_POST[paybankname]));    // 입금계좌 (은행명/예금주/계좌번호)
    $paydatey       = addslashes(trim($_POST[paydatey]));       // 입금예정일
    $paydatem       = addslashes(trim($_POST[paydatem]));       //
    $paydated       = addslashes(trim($_POST[paydated]));       //
    $payname        = addslashes(trim($_POST[payname]));        // 입금자명

    $orderid        = $row_member[id] ? $row_member[id] : $_SESSION[Gid];             // 주문자 아이디, 비회원은 guest

    if(!$orderid) $orderid = @mysql_result(mysql_query("select id from odtMember2 where name = '".$ordername."' and  email ='".$orderemail."' limit 1"),0);


    # 입금 계좌정보 쪼갬.
    $paybankname = isset($paybankname) ? explode("/",$paybankname) : NULL;

    ## 데이터 무결성 체크를 한번 해야함..


    ######################################


    #해당 상품의 정보 추출
    $row_product = mysql_fetch_array(mysql_query("select * from odtProduct where code = '".$parent_code."'"));

    # 이미 등록된 주문인지 체크.
    $isOrder = mysql_result(mysql_query("select count(*) from odtOrder where ordernum = '".$ordernum."'"),0);


    if($isOrder)
    {   
        //이미 등록되어있는 주문건이면 수정.

        #수정 .
        $que = "update odtOrder set
                        partnerCode         = '".$row_product[customerCode]."',
                        orderid             = '".$orderid."',
                        ordername           = '".$ordername."',
                        orderemail          = '".$orderemail."',
                        ordertel1           = '".$ordertel1."',
                        ordertel2           = '".$ordertel2."',
                        ordertel3           = '".$ordertel3."',
                        orderhtel1          = '".$orderhtel1."',
                        orderhtel2          = '".$orderhtel2."',
                        orderhtel3          = '".$orderhtel3."',
                        recname             = '".$recname."',
                        recemail            = '".$recemail."',
                        rectel1             = '".$rectel1."',
                        rectel2             = '".$rectel2."',
                        rectel3             = '".$rectel3."',
                        rechtel1            = '".$rechtel1."',
                        rechtel2            = '".$rechtel2."',
                        rechtel3            = '".$rechtel3."',
                        reczip1             = '".$reczip1."',
                        reczip2             = '".$reczip2."',
                        recaddress          = '".$recaddress."',
                        recaddress1         = '".$recaddress1."',
                        viewDel             = '".$viewDel."',
                        comment             = '".$comment."',
                        taxorder            = '".$taxorder."',
                        companynum          = '".$companynum."',
                        companyname         = '".$companyname."',
                        ceoname             = '".$ceoname."',
                        companyadd          = '".$companyadd."',
                        taxstatus           = '".$taxstatus."',
                        taxitem             = '".$taxitem."',
                        cLog                = '".$cLog."',
                        pLog                = '".$pLog."',
                        oLog                = '".$oLog."',
                        gPrice              = '".$gPrice."',
                        gGetPrice           = '".$gGetPrice."',
                        dPrice              = '".$dPrice."',
                        sPrice              = '".$sPrice."',
                        tPrice              = '".$tPrice."',
                        pointed             = 'N',
                        paymethod           = '".$paymethod."',
                        paystatus           = '".($paymethod == "G" ? "Y" : "N")."',
                        paydate             =  ".($paymethod == "G" ? "now()" : "'0000-00-00 00:00:00'").",
                        paybankname         = '".$paybankname[0]."/".$paybankname[1]."',
                        paybanknum          = '".$paybankname[2]."',
                        paydatey            = '".$paydatey."',
                        paydatem            = '".$paydatem."',
                        paydated            = '".$paydated."',
                        payname             = '".$payname."',
                        md_name             = '".$row_product[md_name]."',
                        ip                  = '".$_SERVER[REMOTE_ADDR]."'
                        where
                        ordernum            = '".$ordernum."'";

        $res = mysql_query($que);

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
                        orderstep               =   'finish',
                        paymethod               = '".$paymethod."',
                        paystatus               = '".($paymethod == "G" ? "Y" : "N")."',
                        paydate                 =   ".($paymethod == "G" ? "now()" : "'0000-00-00 00:00:00'").",
                        paybankname         = '".$paybankname[0]."/".$paybankname[1]."',
                        paybanknum          = '".$paybankname[2]."',
                        paydatey                = '".$paydatey."',
                        paydatem                = '".$paydatem."',
                        paydated                = '".$paydated."',
                        payname                 = '".$payname."',
                        orderdate               =   now(),
                        orderstatus         =   'Y',
                        md_name                 = '".$row_product[md_name]."',
                        hID                         =   '".$_COOKIE[hID]."',
                        ip                          = '".$_SERVER[REMOTE_ADDR]."'";

                $res = mysql_query($que);
                
                if($paymethod=="B") {
                    ## 무통장 입금 정보를 sms로 발송
                    if($orderhtel1 && $orderhtel2 && $orderhtel3) {
                        $tran_phone         = $orderhtel1 ."-". $orderhtel2 ."-". $orderhtel3;
                        $tran_callback  = $row_company[tel];

                        if ("y" == $mem_smsRecord[smschk])
                        {                            
                            $tran_msg = "".$paybankname[0]."/".$paybankname[2]."/".$paybankname[1]."로 ".number_format($tPrice)."원 입금해주세요";
                            $smsQue = "insert into em_tran set tran_phone = '".$tran_phone."', tran_callback = '".$tran_callback."', tran_msg= '".$tran_msg."', tran_status = 1, tran_date = now()";
                            mysql_query($smsQue);
                        }

                        if ("y" == $adm_smsRecord[smschk])
                        { 
                            #관리자에게 문자발송
                            $tran_phone         = $row_company[htel];
                            $tran_callback  = $orderhtel1 ."-". $orderhtel2 ."-". $orderhtel3;
                            
                            $tran_msg = $adm_smsRecord[smstext]." 주문번호 : ".$ordernum; 
                            $smsQue = "insert into em_tran set tran_phone = '".$tran_phone."', tran_callback = '".$tran_callback."', tran_msg= '".$tran_msg."', tran_status = 1, tran_date = now()";
                            mysql_query($smsQue);
                        }
                    }

                    ## 무통장 입금 이메일 발송.
                    if($orderemail) {
                        include "od_ordercomplete_bankMail.php";
                    }
                } else if($paymethod=="G") {

                    ## 포인트 결제 정보를 sms로 발송
                    if($orderhtel1 && $orderhtel2 && $orderhtel3) {
                        $tran_phone         = $orderhtel1 ."-". $orderhtel2 ."-". $orderhtel3;
                        $tran_callback  = $row_company[tel];

                        if ("y" == $mem_smsRecord[smschk])
                        {
                            $tran_msg = $mem_smsRecord[smstext]." 주문번호 : ".$ordernum;
                            $smsQue = "insert into em_tran set tran_phone = '".$tran_phone."', tran_callback = '".$tran_callback."', tran_msg= '".$tran_msg."', tran_status = 1, tran_date = now()";
                            mysql_query($smsQue);
                        }

                        
                        #관리자에게 문자발송
                        $tran_phone         = $row_company[htel];
                        $tran_callback  = $orderhtel1 ."-". $orderhtel2 ."-". $orderhtel3;

                        if ("y" == $adm_smsRecord[smschk])
                        {
                            $tran_msg = $adm_smsRecord[smstext]." 주문번호 : ".$ordernum;
                            $smsQue   = "insert into em_tran set tran_phone = '".$tran_phone."', tran_callback = '".$tran_callback."', tran_msg= '".$tran_msg."', tran_status = 1, tran_date = now()";
                            mysql_query($smsQue);
                        }
                    }

                    ## 포인트결제 이메일 발송.
                    if($orderemail) {
                        include "od_ordercomplete_bankMail.php";
                    }
                }
                ###########################
                ## 포인트 차감
                ###########################
                if($gPrice) {
                    // 차감
                    mysql_query("update odtMember set point = point - ".$gPrice." where id ='".$orderid."'");
                    // 로그
                    mysql_query("insert into odtPointLog set 
                                                ordernum        =   '".$ordernum."',
                                                pointID         = '".$orderid."', 
                                                pointTitle  = '상품 구입시 사용(".$row_product[name].")', 
                                                pointPoint  = '-".$gPrice."',
                                                pointResult = '".(mysql_result(mysql_query("select point from odtMember where id ='".$orderid."'"),0))."',
                                                pointStatus = 'Y',
                                                pointRegidate = now()");
                }

                ###########################
                ## 포인트 차감 끝
                ###########################


                ###########################
                ## 사용한 쿠폰 처리
                ###########################
                $cLog00 = explode("^",$cLog);
                for($pp=0;$pp<count($cLog00);$pp++) {
                    $cLog000 = explode("|",$cLog00[$pp]);
                    if($cLog000[0] == "이벤트쿠폰") {
                        // 쿠폰 사용처리.
                        $queCo = "select coNo from odtCoupon where coType ='이벤트쿠폰' and coPrice ='".$cLog000[1]."' and coID='".$row_member[id]."' and coUse ='N' order by coNo limit 1 ";
                        $app_coNo = mysql_result(mysql_query($queCo),0,0);

                        mysql_query("update odtCoupon set coUse='Y' where coNo='${app_coNo}' ");
                    }
                }
                ###########################
                ## 사용한 쿠폰 처리 끝
                ###########################

                    ######################
                    ## 수량 차감
                    ######################
                    $pLog99 = explode("^",$orow[pLog]);
                    for($pp = 0;$pp < count($pLog99) ; $pp++) {
                        $pLog999 = explode("|",$pLog99[$pp]);
                        mysql_query("update odtProduct set stock = stock - ".$pLog999[1].",saleCnt = saleCnt +  ".$pLog999[1]." where code ='".$pLog999[0]."'");
                    }
                    ######################
                    ## 수량 차감 끝
                    ######################

                    ######################
                    ## 참여점수 입력
                    ######################
                    $queP = "insert into odtActionLog set
                                        acID            = '".$orow[orderid]."',
                                        acTitle     = '".$goodname." 구매',
                                        acPoint     = '300',
                                        acRegidate = now()";
                    mysql_query($queP);

                    $queP = "update odtMember set action        = action + 300 where id = '".$orow[orderid]."'";
                    mysql_query($queP);
                    ######################
                    ## 참여점수 입력 끝
                    ######################


            if($cInfo[sc_use] == "Y") {
                    ######################
                    ## 아이라이크클릭
                    ######################
                    $c_ValueFromClick = $_COOKIE["c_ValueFromClick"];

                    if ( $c_ValueFromClick != NULL )
                    {
                        $iProArrayTmp = explode("^",$pLog);
                        for($ii=0;$ii<count($iProArrayTmp);$ii++) {

                            $iCode = explode("|",$iProArrayTmp[$ii]);
                            $iProInfo = mysql_fetch_array(mysql_query("select * from odtProduct where code ='".$iCode[0]."'"));

                            $iBuyNo     = $ordernum;
                            $iCCode     = $iProInfo[cateCode];
                            $iPCode     = $iCode[0];
                            $iPopt      =   "";
                            $iPName     = urlencode(iconv("utf-8","euckr",$iProInfo[name]));
                            $iPNum      =   $iCode[1];
                            $iPrice     =   $iProInfo[price]-$iProInfo[coupon_sale];
                            $iBuyType   =   "O";
                            $iMemberID= $orderid;
                            $iUserName= urlencode(iconv("utf-8","euckr",$ordername));

                            @mysql_query("insert into odtILikeClickLog set
                                                        `ordernum`      = '".$iBuyNo."',
                                                        `proCode`           =   '".$iPCode."',
                                                        `option`            =   '".$iPopt."',
                                                        `proName`           =   '".$iProInfo[name]."',
                                                        `proCnt`            =   '".$iPNum."',
                                                        `price`             =   '".$iPrice."',
                                                        `id`                    =   '".$iMemberID."',
                                                        `ordername`     =   '".$ordername."',
                                                        `cookie`            =   '".$c_ValueFromClick."',
                                                        `regidate`      =   now()");


                            echo "<SCRIPT LANGUAGE='JavaScript' src='http://www.ilikeclick.com/tracking/sale/v1_Sale.php?MID=".$cInfo[sc_id]."&BUYNO=".$iBuyNo."&CCODE=".$iCCode."&PCODE=".$iPCode."&POPT=".$iPopt."&PNAME=".$iPName."&PNUM=".$iPNum."&PRICE=".$iPrice."&BUYTYPE=".$iBuyType."&MEMBER_ID=".$iMemberID."&USERNAME=".$iUserName."&ValueFromClick=".$c_ValueFromClick."'></SCRIPT>";
                        }
                    }

                    ######################
                    ## 아이라이크클릭 끝
                    ######################
            }



    }

    if(!$res) {
        error_msgall('주문서 작성중 오류가 발생하였습니다','back');
        exit;
    }

    ## 주문정보 호출
    $orow = mysql_fetch_array(mysql_query("SELECT * FROM odtOrder WHERE ordernum='$ordernum'"));
    

}
else if ($paymethod == "C" || $paymethod == "L")
{
    // kcp 처리 ///////////////////////////////////////////////////////////////////////////////
    include $_SERVER[DOCUMENT_ROOT]."/kcp/cfg/site_conf_inc.php";
    include $_SERVER[DOCUMENT_ROOT]."/kcp/files/pp_ax_hub_lib.php";
    
    //-------------------------------------------------------------------------
    // 01. 지불 요청 정보 설정
    //-------------------------------------------------------------------------
    $req_tx         = $_POST[ "req_tx"         ]; // 요청 종류
    $tran_cd        = $_POST[ "tran_cd"        ]; // 처리 종류

    $cust_ip        = getenv( "REMOTE_ADDR"    ); // 요청 IP
    $ordr_idxx      = $_POST[ "ordr_idxx"      ]; // 쇼핑몰 주문번호
    $good_name      = $_POST[ "good_name"      ]; // 상품명
    $good_mny       = $_POST[ "good_mny"       ]; // 결제 총금액

    //echo("good_mny :".$good_mny."<br>");exit;
    //echo("good_name :".$good_name."<br>");

    $res_cd         = "";                         // 응답코드
    $res_msg        = "";                         // 응답메시지
    $tno            = $_POST[ "tno"            ]; // KCP 거래 고유 번호

    $buyr_name      = $_POST[ "buyr_name"      ]; // 주문자명
    $buyr_tel1      = $_POST[ "buyr_tel1"      ]; // 주문자 전화번호
    $buyr_tel2      = $_POST[ "buyr_tel2"      ]; // 주문자 핸드폰 번호
    $buyr_mail      = $_POST[ "buyr_mail"      ]; // 주문자 E-mail 주소

    $mod_type       = $_POST[ "mod_type"       ]; // 변경TYPE VALUE 승인취소시 필요
    $mod_desc       = $_POST[ "mod_desc"       ]; // 변경사유

    $use_pay_method = $_POST[ "use_pay_method" ]; // 결제 방법
    $bSucc          = "";                         // 업체 DB 처리 성공 여부

    $app_time       = "";                         // 승인시간 (모든 결제 수단 공통)
    $amount         = "";                         // KCP 실제 거래 금액
    $total_amount   = 0;                          // 복합결제시 총 거래금액

    $card_cd        = "";                         // 신용카드 코드
    $card_name      = "";                         // 신용카드 명
    $app_no         = "";                         // 신용카드 승인번호
    $noinf          = "";                         // 신용카드 무이자 여부
    $quota          = "";                         // 신용카드 할부개월

    $bank_name      = "";                         // 은행명
    $bank_code      = "";                         // 은행코드

    $bankname       = "";                         // 입금할 은행명
    $depositor      = "";                         // 입금할 계좌 예금주 성명
    $account        = "";                         // 입금할 계좌 번호
    $va_date        = "";                         // 가상계좌 입금마감시간

    $pnt_issue      = "";                         // 결제 포인트사 코드
    $pt_idno        = "";                         // 결제 및 인증 아이디
    $pnt_amount     = "";                         // 적립금액 or 사용금액
    $pnt_app_time   = "";                         // 승인시간
    $pnt_app_no     = "";                         // 승인번호
    $add_pnt        = "";                         // 발생 포인트
    $use_pnt        = "";                         // 사용가능 포인트
    $rsv_pnt        = "";                         // 총 누적 포인트

    $commid         = "";                         // 통신사 코드
    $mobile_no      = "";                         // 휴대폰 번호

    $tk_shop_id     = $_POST[ "tk_shop_id"     ]; // 가맹점 고객 아이디
    $tk_van_code    = "";                         // 발급사 코드
    $tk_app_no      = "";                         // 상품권 승인 번호

    $cash_yn        = $_POST[ "cash_yn"        ]; // 현금영수증 등록 여부
    $cash_authno    = "";                         // 현금 영수증 승인 번호
    $cash_tr_code   = $_POST[ "cash_tr_code"   ]; // 현금 영수증 발행 구분
    $cash_id_info   = $_POST[ "cash_id_info"   ]; // 현금 영수증 등록 번호

    if ("1" == $row_setup[P_SKBN])
    {
        $escw_used      = $_POST[  "escw_used"     ]; // 에스크로 사용 여부
        $pay_mod        = $_POST[  "pay_mod"       ]; // 에스크로 결제처리 모드
        $deli_term      = $_POST[  "deli_term"     ]; // 배송 소요일
        $bask_cntx      = $_POST[  "bask_cntx"     ]; // 장바구니 상품 개수
        $good_info      = $_POST[  "good_info"     ]; // 장바구니 상품 상세 정보
        $rcvr_name      = $_POST[  "rcvr_name"     ]; // 수취인 이름
        $rcvr_tel1      = $_POST[  "rcvr_tel1"     ]; // 수취인 전화번호
        $rcvr_tel2      = $_POST[  "rcvr_tel2"     ]; // 수취인 휴대폰번호
        $rcvr_mail      = $_POST[  "rcvr_mail"     ]; // 수취인 E-Mail
        $rcvr_zipx      = $_POST[  "rcvr_zipx"     ]; // 수취인 우편번호
        $rcvr_add1      = $_POST[  "rcvr_add1"     ]; // 수취인 주소
        $rcvr_add2      = $_POST[  "rcvr_add2"     ]; // 수취인 상세주소
        $escw_yn        = "";                         // 에스크로 여부
    }

    //-------------------------------------------------------------------------
    // 02. 인스턴스 생성 및 초기화
    //-------------------------------------------------------------------------
    $c_PayPlus = new C_PP_CLI;

    $c_PayPlus->mf_clear();

    //-------------------------------------------------------------------------
    // 03-1. 승인 요청
    //-------------------------------------------------------------------------
    
    //echo("req_tx : ".$req_tx."<br>");exit;
    //echo("good_mny : ".$good_mny."<br>");
    //echo("use_pay_method : ".$use_pay_method."<br>");
    
    if ( $req_tx == "pay" )
    {
        $c_PayPlus->mf_set_encx_data( $_POST[ "enc_data" ], $_POST[ "enc_info" ] );
    }

    //-------------------------------------------------------------------------
    // 04. 실행
    //-------------------------------------------------------------------------
    if ( $tran_cd != "" )
    {
        $c_PayPlus->mf_do_tx( $trace_no, $g_conf_home_dir, $g_conf_site_cd, "", $tran_cd, "", $g_conf_gw_url, $g_conf_gw_port, "payplus_cli_slib", $ordr_idxx, $cust_ip, "3" , 0, 0, $g_conf_key_dir, $g_conf_log_dir); // 응답 전문 처리

        $res_cd  = $c_PayPlus->m_res_cd;  // 결과 코드
        $res_msg = $c_PayPlus->m_res_msg; // 결과 메시지
                    
        //echo("req_tx : ".$req_tx."<BR>");
        //echo("res_cd : ".$res_cd."<BR>");
        //echo("res_msg : ".$res_msg."<BR>");
    }
    else
    {
        $c_PayPlus->m_res_cd  = "9562";
        $c_PayPlus->m_res_msg = "연동 오류|Payplus Plugin이 설치되지 않았거나 tran_cd값이 설정되지 않았습니다.";
    }


    //echo $res_cd;
    //echo $c_PayPlus->m_res_msg."<br>";exit;

    //-------------------------------------------------------------------------
    // 05. 승인 결과 값 추출
    //-------------------------------------------------------------------------
    if ( $req_tx == "pay" )
    {
        if( $res_cd == "0000" )
        {
            $tno       = $c_PayPlus->mf_get_res_data( "tno"       ); // KCP 거래 고유 번호
            $amount    = $c_PayPlus->mf_get_res_data( "amount"    ); // KCP 실제 거래 금액
            $pnt_issue = $c_PayPlus->mf_get_res_data( "pnt_issue" ); // 결제 포인트사 코드

            // 05-1. 신용카드 승인 결과 처리 //////////////////////////////////
            if ( $use_pay_method == "100000000000" )
            {
                $card_cd   = $c_PayPlus->mf_get_res_data( "card_cd"   ); // 카드사 코드
                $card_name = $c_PayPlus->mf_get_res_data( "card_name" ); // 카드 종류
                $app_time  = $c_PayPlus->mf_get_res_data( "app_time"  ); // 승인 시간
                $app_no    = $c_PayPlus->mf_get_res_data( "app_no"    ); // 승인 번호
                $noinf     = $c_PayPlus->mf_get_res_data( "noinf"     ); // 무이자 여부 ( 'Y' : 무이자 )
                $quota     = $c_PayPlus->mf_get_res_data( "quota"     ); // 할부 개월 수
            }

            // 05-2. 계좌이체 승인 결과 처리 //////////////////////////////////
            if ( $use_pay_method == "010000000000" )
            {
                $app_time  = $c_PayPlus->mf_get_res_data( "app_time"   );  // 승인 시간
                $bank_name = $c_PayPlus->mf_get_res_data( "bank_name"  );  // 은행명
                $bank_code = $c_PayPlus->mf_get_res_data( "bank_code"  );  // 은행코드
            }

            // 05-3. 가상계좌 승인 결과 처리 //////////////////////////////////
            if ( $use_pay_method == "001000000000" )
            {
                $bankname  = $c_PayPlus->mf_get_res_data( "bankname"  ); // 입금할 은행 이름
                $depositor = $c_PayPlus->mf_get_res_data( "depositor" ); // 입금할 계좌 예금주
                $account   = $c_PayPlus->mf_get_res_data( "account"   ); // 입금할 계좌 번호
                $va_date   = $c_PayPlus->mf_get_res_data( "va_date"   ); // 가상계좌 입금마감시간
            }

            // 05-7. 현금영수증 결과 처리 /////////////////////////////////////
            $cash_authno  = $c_PayPlus->mf_get_res_data( "cash_authno"  ); // 현금 영수증 승인 번호
        }

        if ("1" == $row_setup[P_SKBN])  // 에스크로 사용일때만 
        {
            $escw_yn = $c_PayPlus->mf_get_res_data( "escw_yn"  ); // 에스크로 여부 
        }
    }

    //-------------------------------------------------------------------------
    // 05. 승인 결과 처리 END
    //-------------------------------------------------------------------------
    if ( $req_tx == "pay" )
    {
        if( $res_cd == "0000" )
        {
            // 06-1-1. 신용카드 || 06-1-2. 계좌이체 ///////////////////////////////////////////
            if ( $use_pay_method == "100000000000" || $use_pay_method == "010000000000")
            {  
                $que = "select count(*) from odtOrder where ordernum = '".$ordr_idxx ."'   ";
                $res = mysql_query($que);

                ############################
                ## 구매 완료 처리
                ############################
                if(mysql_result($res,0) == 1)
                {

                    # 결재완료 
                    mysql_query("update odtOrder set paystatus = 'Y' , orderstep='finish', paydate = now(), authum = '".$tno."', apprTm = '".$app_time."', dealNo = '".$app_no."', subTy = '".$card_cd."' where ordernum ='".$ordr_idxx."'");

                    ## 주문정보 호출
                    $orow = mysql_fetch_array(mysql_query("SELECT * FROM odtOrder WHERE ordernum='$ordr_idxx'"));
                    
                    ## 구매레포트에 저장
                    sellRecord($orow);

                    ############################
                    ## sms로 발송
                    ############################
                    if($orow[orderhtel1] && $orow[orderhtel2] && $orow[orderhtel3]) {
                        $tran_phone         = $orow[orderhtel1] ."-". $orow[orderhtel2] ."-". $orow[orderhtel3];
                        $tran_callback  = $row_company[tel];

                            if ("y" == $mem_smsRecord[smschk])
                            {
                                $tran_msg = $mem_smsRecord[smstext]." 주문번호 : ".$orow[ordernum];
                                $smsQue = "insert into em_tran set tran_phone = '".$tran_phone."', tran_callback = '".$tran_callback."', tran_msg= '".$tran_msg."', tran_status = 1, tran_date = now()";
                                mysql_query($smsQue);
                            }


                            if ("y" == $adm_smsRecord[smschk])
                            {
                                #운영자
                                $tran_phone = $row_company[htel];
                                $tran_msg = $adm_smsRecord[smstext]." 주문번호 : ".$orow[ordernum];
                                $smsQue     = "insert into em_tran set tran_phone = '".$tran_phone."', tran_callback = '".$tran_callback."', tran_msg= '".$tran_msg."', tran_status = 1, tran_date = now()";
                                mysql_query($smsQue);
                            }
                    }
                    ############################
                    ## sms로 발송 끝
                    ############################


                    ############################
                    ## 포인트 지급 및 차감 및 로그에 남김
                    ############################
                    $goodname = mysql_result(mysql_query("select name from odtProduct where code ='".reset(explode("|",$orow[pLog]))."'"),0);

                    if($orow[gPrice] > 0 && $row_member[id]) {
                        
                        // 차감
                        $queG = "update odtMember set point = point - ".$orow[gPrice]." where id = '".$orow[orderid]."'";
                        mysql_query($queG);

                        // 로그
                        $queL = "insert into odtPointLog set
                                            pointID         = '".$orow[orderid]."',
                                            pointTitle      = '상품 구입시 사용(".$goodname.")',
                                            pointPoint      = '-".$orow[gPrice]."',
                                            pointResult     = '".mysql_result(mysql_query("select point from odtMember where id='".$orow[orderid]."'"),0)."',
                                            pointStatus     = 'Y',
                                            ordernum        = '".$orow[ordernum]."',
                                            pointRegidate = now()";
                        mysql_query($queL);

                    
                    }
                    if($row_member[id]) {

                        if($orow[gGetPrice] > 0) {
                        //증가
//                          $queG = "update odtMember set point = point + ".$orow[gGetPrice]." where id = '".$orow[orderid]."'";
//                          mysql_query($queG);

                            // 로그
                            $queL = "insert into odtPointLog set
                                                pointID             = '".$orow[orderid]."',
                                                pointTitle      = '상품 구입(".$goodname.")',
                                                pointPoint      = '".$orow[gGetPrice]."',
                                                pointStatus     = 'N',
                                                pointRegidate = now(),
                                                ordernum            =   '".$orow[ordernum]."',
                                                redRegidate     =   '".date('Y-m-d',strtotime("+30 days"))."'";
                            mysql_query($queL);
    
                        }

                        ## 배너이벤트
                        if($_COOKIE[hID] && conn_hID($_COOKIE[hID]) != $orow[orderid] ) {
                            $queL = "insert into odtPointLog set
                                                pointID             = '".conn_hID($_COOKIE[hID])."',
                                                pointTitle      = '베너이벤트(".$goodname.")',
                                                pointPoint      = '".round($orow[tPrice]*0.01)."',
                                                pointStatus     = 'N',
                                                pointRegidate = now(),
                                                ordernum            =   '".$orow[ordernum]."',
                                                redRegidate     =   '".date('Y-m-d',strtotime("+30 days"))."'";
                            mysql_query($queL);
                        }
                    }
                    ############################
                    ## 포인트 지급 및 차감 및 로그에 남김 끝
                    ############################


                    ############################
                    ## 사용한 쿠폰 처리
                    ############################
                    $cLog00 = explode("^",$orow[cLog]);
                    for($pp=0;$pp<count($cLog00);$pp++) {
                        $cLog000 = explode("|",$cLog00[$pp]);
                        if($cLog000[0] == "이벤트쿠폰") {
                            // 쿠폰 사용처리.
                            $queCo = "select coNo from odtCoupon where coType ='이벤트쿠폰' and coPrice ='".$cLog000[1]."' and coID='".$row_member[id]."' and coUse ='N' order by coNo limit 1 ";
                            $app_coNo = mysql_result(mysql_query($queCo),0,0);

                            mysql_query("update odtCoupon set coUse='Y' where coNo='${app_coNo}' ");
                        }
                    }
                    ############################
                    ## 사용한 쿠폰 처리 끝
                    ############################

                    ######################
                    ## 수량 차감
                    ######################
                    $pLog99 = explode("^",$orow[pLog]);
                    for($pp = 0;$pp < count($pLog99) ; $pp++) {
                        $pLog999 = explode("|",$pLog99[$pp]);
                        mysql_query("update odtProduct set stock = stock - ".$pLog999[1].",saleCnt = saleCnt +  ".$pLog999[1]." where code ='".$pLog999[0]."'");
                    }
                    ######################
                    ## 수량 차감 끝
                    ######################

                    ######################
                    ## 참여점수 입력
                    ######################
                    $queP = "insert into odtActionLog set
                                        acID            = '".$orow[orderid]."',
                                        acTitle     = '".$goodname." 구매',
                                        acPoint     = '300',
                                        acRegidate = now()";
                    mysql_query($queP);

                    $queP = "update odtMember set action        = action + 300 where id = '".$orow[orderid]."'";
                    mysql_query($queP);
                    ######################
                    ## 참여점수 입력 끝
                    ######################


                    

                    ###################################
                    ## 카드결제완료 이메일 발송.
                    ###################################
                    if($orow[orderemail]) include "od_ordercomplete_cardMail.php";



                    if($cInfo[sc_use] == "Y")
                    {
                        ######################
                        ## 아이라이크클릭
                        ######################
                        $c_ValueFromClick = $_COOKIE["c_ValueFromClick"];

                        if ( $c_ValueFromClick != NULL )
                        {
                            $iProArrayTmp = explode("^",$orow[pLog]);
                            for($ii=0;$ii<count($iProArrayTmp);$ii++) {

                                $iCode = explode("|",$iProArrayTmp[$ii]);
                                $iProInfo = mysql_fetch_array(mysql_query("select * from odtProduct where code ='".$iCode[0]."'"));
                                
                                $iPayMethodArray = array("Card" => "C","VCard" => "C","DirectBank" => "O");

                                $iBuyNo     = $orow[ordernum];
                                $iCCode     = $iProInfo[cateCode];
                                $iPCode     = $iCode[0];
                                $iPopt      =   "";
                                $iPName     = urlencode(iconv("utf-8","euckr",$iProInfo[name]));
                                $iPNum      =   $iCode[1];
                                $iPrice     =   $iProInfo[price]-$iProInfo[coupon_sale];
                                $iBuyType   =   $iPayMethodArray[$paymethod];
                                $iMemberID= $orow[orderid];
                                $iUserName= urlencode(iconv("utf-8","euckr",$orow[ordername]));

                                @mysql_query("insert into odtILikeClickLog set
                                                            `ordernum`      = '".$iBuyNo."',
                                                            `proCode`           =   '".$iPCode."',
                                                            `option`            =   '".$iPopt."',
                                                            `proName`           =   '".$iProInfo[name]."',
                                                            `proCnt`            =   '".$iPNum."',
                                                            `price`             =   '".$iPrice."',
                                                            `id`                    =   '".$iMemberID."',
                                                            `ordername`     =   '".$orow[ordername]."',
                                                            `cookie`            =   '".$c_ValueFromClick."',
                                                            `regidate`      =   now()");


                                echo "<SCRIPT LANGUAGE='JavaScript' src='http://www.ilikeclick.com/tracking/sale/v1_Sale.php?MID=".$cInfo[sc_id]."&BUYNO=".$iBuyNo."&CCODE=".$iCCode."&PCODE=".$iPCode."&POPT=".$iPopt."&PNAME=".$iPName."&PNUM=".$iPNum."&PRICE=".$iPrice."&BUYTYPE=".$iBuyType."&MEMBER_ID=".$iMemberID."&USERNAME=".$iUserName."&ValueFromClick=".$c_ValueFromClick."'></SCRIPT>";
                            }
                        }
                    }
                    ######################
                    ## 아이라이크클릭 끝
                    ######################
                }
                else
                {
                    mysql_query("update odtOrder set ordersau = '구매완료 처리중 알수없는 오류' where ordernum = '".$ordr_idxx."'");
                    $bSucc = "false"; // 결제 취소를 위해서
                }
            }

        }
        //-----------------------------------------------------------------
        //  06. 승인 및 실패 결과 DB처리
        //-----------------------------------------------------------------
        else if ( $res_cd != "0000" )
        {             
            $bSucc = "false";

            // 카드결제로 넘어온값 처리.
            mysql_query("update odtOrder set ordersau = '[".$res_cd."]".iconv("euc-kr","utf-8",$c_PayPlus->m_res_msg)."', orderstep='fail' where ordernum = '".$ordr_idxx."'");
            error_msgall('결제가 이루어 지지 않았습니다. 사유('.iconv("euc-kr","utf-8",$c_PayPlus->m_res_msg).')');

            ## 실패된 주문정보 호출
            $orow = mysql_fetch_array(mysql_query("SELECT * FROM odtOrder WHERE ordernum='$ordr_idxx'"));
            
            ## 구매레포트에 저장
            sellRecord($orow);
        }

        //---------------------------------------------------------------------
        // 07-1. DB 작업 실패일 경우 자동 승인 취소
        //---------------------------------------------------------------------
        if ( $req_tx == "pay" )
        {
            if( $res_cd == "0000" )
            {   
                if( $bSucc == "false" )
                {
                    $c_PayPlus->mf_clear();

                    $tran_cd = "00200000";

                    if ("1" == $row_setup[P_SKBN])  // 에스크로 사용일때만 
                    {
                        $bSucc_mod_type = "";

                        // 에스크로 가상계좌 건의 경우 가상계좌 발급취소(STE5)
                        if ( $escw_yn == "Y" && $use_pay_method == "001000000000" )
                        {
                            $bSucc_mod_type = "STE5";
                        }
                        // 에스크로 가상계좌 이외 건은 즉시취소(STE2)
                        else if ( $escw_yn == "Y" )
                        {
                            $bSucc_mod_type = "STE2";
                        }
                        // 에스크로 거래 건이 아닌 경우(일반건)(STSC)
                        else
                        {
                            $bSucc_mod_type = "STSC"; 
                        }
                    }
                
                    $c_PayPlus->mf_set_modx_data( "tno",      $tno                         );  // KCP 원거래 거래번호
                    $c_PayPlus->mf_set_modx_data( "mod_type", "STSC"                       );  // 원거래 변경 요청 종류
                    $c_PayPlus->mf_set_modx_data( "mod_ip",   $cust_ip                     );  // 변경 요청자 IP
                    $c_PayPlus->mf_set_modx_data( "mod_desc", "결과 처리 오류 - 자동 취소" );  // 변경 사유
                
                    $c_PayPlus->mf_do_tx( $tno,  $g_conf_home_dir, $g_conf_site_cd,
                                          "",  $tran_cd,    "",
                                          $g_conf_gw_url,  $g_conf_gw_port,  "payplus_cli_slib",
                                          $ordr_idxx, $cust_ip, "3" ,
                                          0, 0, $g_conf_key_dir, $g_conf_log_dir);
                
                    $res_cd  = $c_PayPlus->m_res_cd;
                    $res_msg = $c_PayPlus->m_res_msg;
                      
                    error_msgall('카드 결제 중 오류가 발생하여 주문이 실패 되었습니다.');
                }
            }
        }
    }

}



	// 주문확인 및 결제 공통 정보 ---> PG사 추가에 따른 공통 파일 마련
	include "od_ordercomplete.common_inc.php";

?>