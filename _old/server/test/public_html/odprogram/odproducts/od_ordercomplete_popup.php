<?php
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
$cInfo = mysql_fetch_array(mysql_query("select * from odtClick where sc_idx = '1'"));

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

if ($PayMethod == "CARD")
{
    $paymethod   = "C";
    $success_key = "3001";
}
else if ($PayMethod == "BANK")
{
    $paymethod   = "L";
    $success_key = "4000";
}
else
{
    $success_key = "";
}

if($paymethod == "B" || $paymethod == "G")
{ 
    //무통장 입금이나 전액 포인트 결제시 바로 주문완료페이지로 오므로 주문테이블에 입력.

    # 주문번호 쿠키로 꾸어놓음.. 주문서 수정할경우를 위해.
    setCookie("pre_ordernum",$ordernum);

    $parent_code    = addslashes(trim($_POST[parent_code]));    // 부모 상품코드
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

    $orderid        = $row_member[id] ? $row_member[id] : $_SESSION[Gid];     // 주문자 아이디, 비회원은 guest

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
                        where   ordernum    = '".$ordernum."'";

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
                        ordernum            = '".$ordernum."',
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
                        orderstep           =   'finish',
                        paymethod           = '".$paymethod."',
                        paystatus           = '".($paymethod == "G" ? "Y" : "N")."',
                        paydate             =   ".($paymethod == "G" ? "now()" : "'0000-00-00 00:00:00'").",
                        paybankname         = '".$paybankname[0]."/".$paybankname[1]."',
                        paybanknum          = '".$paybankname[2]."',
                        paydatey            = '".$paydatey."',
                        paydatem            = '".$paydatem."',
                        paydated            = '".$paydated."',
                        payname             = '".$payname."',
                        orderdate           =   now(),
                        orderstatus         =   'Y',
                        md_name             = '".$row_product[md_name]."',
                        hID                 = '".$_COOKIE[hID]."',
                        ip                  = '".$_SERVER[REMOTE_ADDR]."'";

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
                        mysql_query("update odtCoupon set coUse='Y' where coType ='이벤트쿠폰' and coPrice ='".$cLog000[1]."' and coID='".$row_member[id]."'");
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
                                    acID        = '".$orow[orderid]."',
                                    acTitle     = '".$goodname." 구매',
                                    acPoint     = '300',
                                    acRegidate = now()";
                mysql_query($queP);

                $queP = "update odtMember set action        = action + 300 where id = '".$orow[orderid]."'";
                mysql_query($queP);
                ######################
                ## 참여점수 입력 끝
                ######################


    }

    if(!$res) {
        error_msgall('주문서 작성중 오류가 발생하였습니다','back');
        exit;
    }

    ## 주문정보 호출
    $orow = mysql_fetch_array(mysql_query("SELECT * FROM odtOrder WHERE ordernum='$ordernum'"));
    

}
else if($paymethod == "C" || $paymethod == "L")
{
    $PayMethod    = $_REQUEST['PayMethod'];
    $MID          = $_REQUEST['MID'];
    $Amt          = $_REQUEST['Amt'];
    $name         = $_REQUEST['name'];
    $GoodsName    = iconv('euc-kr', 'utf-8', $_REQUEST['GoodsName']);
    $OID          = $_REQUEST['OID'];
    $AuthDate     = $_REQUEST['AuthDate'];
    $AuthCode     = $_REQUEST['AuthCode'];
    $ResultCode   = $_REQUEST['ResultCode'];
    $ResultMsg    = iconv('euc-kr', 'utf-8', $_REQUEST['ResultMsg']);
    $VbankNum     = $_REQUEST['VbankNum'];
    $MallReserved = $_REQUEST['MallReserved'];
    $fn_name      = iconv('euc-kr', 'utf-8', $_REQUEST['fn_name']);

    // 카드결제로 넘어온값 처리.
    if($ResultCode != $success_key)
    { 
        mysql_query("update odtOrder set ordersau = '".$ResultMsg."', orderstep='fail' where ordernum = '".$OID."'");
        error_msgall('결제가 이루어 지지 않았습니다. 사유('.$ResultMsg.')');
        echo "<script>history.go(-2);</script>";
        exit;
    } 
    else
    {

        $authum         = $AuthCode;
        $ordernumResult = $OID;
        $tPriceResult   = $Amt;
        $apprTm         = $AuthDate;
        $dealNo         = $TID;
        $subTy          = $fn_name;

        $que = "select count(*) from odtOrder where ordernum = '".$ordernumResult ."' and tPrice = '".$tPriceResult."' AND paystatus = 'N'";
        $res = mysql_query($que);

        ############################
        ## 구매 완료 처리
        ############################
        if(mysql_result($res,0) == 1) {

            # 결재완료 
            mysql_query("update odtOrder set paystatus = 'Y' , orderstep='finish', paydate = now(), authum = '".$authum."', apprTm = '".$apprTm."', dealNo = '".$dealNo."', subTy = '".$subTy."' where ordernum ='".$ordernumResult."'");

            ## 주문정보 호출
            $orow = mysql_fetch_array(mysql_query("SELECT * FROM odtOrder WHERE ordernum='$ordernumResult'"));
            
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
                                    pointID             = '".$orow[orderid]."',
                                    pointTitle      = '상품 구입시 사용(".$goodname.")',
                                    pointPoint      = '-".$orow[gPrice]."',
                                    pointResult     =   '".mysql_result(mysql_query("select point from odtMember where id='".$orow[orderid]."'"),0)."',
                                    pointStatus     = 'Y',
                                    ordernum            =   '".$orow[ordernum]."',
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
                    mysql_query("update odtCoupon set coUse='Y' where coType ='이벤트쿠폰' and coPrice ='".$cLog000[1]."' and coID='".$row_member[id]."'");
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
                                acID        = '".$orow[orderid]."',
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


        ############################
        ## 구매 완료 처리 끝
        ############################
        } else {
            mysql_query("update odtOrder set ordersau = '구매완료 처리중 알수없는 오류' where ordernum = '".$OID."'");
            error_msgall('결제중 오류가 발생하였습니다.');
            echo "<script>self.close;</script>";
            exit;
        }

    }

} else {
    error_msgall('결제중 오류가 발생하였습니다.');
    @mysql_query("update odtOrder set ordersau = '카드결제방법 오류', orderstep='fail' where ordernum = '".$OID."'");
    @mysql_query("insert into errorLog set content='카드결제 오류 paymethod = ".$paymethod."', url = '".$_SERVER[PHP_SELF]."' , regidate = now()");
    echo "<script>self.close();</script>";
    exit;
}


if($paymethod == "B" || $paymethod == "G")
{ 
    echo "
    <script>
    location.href = 'od_ordercomplete2.php?oid=$ordernum';
    </script>";
    exit;
}
else
{
    echo "
    <script>
    opener.location.href = 'od_ordercomplete2.php?oid=$OID';
    self.close();
    </script>";
    exit;
}

?>

