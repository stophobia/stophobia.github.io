<?
    include "../../odcommon/od_config.inc.php";
    include "$folderpath_manager_common/od_function.inc.php";  
    include "$folderpath_manager_common/od_adminAuthority.inc.php";
    
    chk_authfree();

    ## 페이지링크 PAR 정리 ############################################
    if($search) $par_page .= "&search=$search";
    if($key) $par_page .= "&key=$key";
    if($paymethod) $par_page .= "&paymethod=$paymethod";
    if($paystatus) $par_page .= "&paystatus=$paystatus";
    if($delivstatus) $par_page .= "&delivstatus=$delivstatus";
    if($start_date && $end_date) $par_page .= "&start_date=$start_date&end_date=$end_date";
    if($date_term) $par_page .= "&date_term=$date_term";
    if($search_standard) $par_page .= "&search_standard=$search_standard";
    if($order_by) $par_page .= "&order_by=$order_by";
    if($order_by_rule) $par_page .= "&order_by_rule=$order_by_rule";
    if($search_value_) $par_page .= "&search_value_=$search_value_";
    if($page_number) $par_page .= "&page_number=$page_number";
    if($order_type) $par_page .= "&order_type=$order_type";

    if(!strcmp($Form,"orderCancel")) {
    
        $row_member_result = mysql_query("SELECT orderid, tPrice, authum, apprTm, dealNo, subTy, paystatus, orderstep, paymethod FROM odtOrder WHERE ordernum='$ordernum'");       
        $row_member_row = mysql_fetch_array($row_member_result);

        ## 결제방식이 신용카드이고 결제가 되었고 주문상태가 완료상태이고 거래승인코드가 있을때만 실행
        if($row_member_row[paystatus]=="Y" && $row_member_row[authum]!="" && ($row_member_row[paymethod]=="C"))
        {
            if ("M" == $row_setup[P_KBN])
            {
                $ip = $_SERVER['REMOTE_ADDR'];

                echo "
                <form name='tranMgr' method='post' action='http://pg.mnbank.co.kr/cancel/payCancelProcess.jsp'>
                    <input type='hidden' name='TID'             value='$row_member_row[dealNo]'>
                    <input type='hidden' name='Cancelpw'        value='$row_setup[P_PW]'>
                    <input type='hidden' name='CancelAmt'       value='$row_member_row[tPrice]'>
                    <input type='hidden' name='CancelMSG'       value='고객요청'>
                    <input type='hidden' name='cc_ip'           value='$ip'>
                    <input type='hidden' name='ReturnURL'       value='http://".$_SERVER[HTTP_HOST]."/MnBank/cancel2.php'>
                    <input type='hidden' name='MallResultFWD'   value='Y'>
                </form>
                <iframe src='/MnBank/blank.html' name='payFrame' frameborder='no' width='100%' height='100' scrolling='yes'  align='center'></iframe>
                <script>
                    document.tranMgr.submit();
                </script>";
                exit;
            }
            else if ("A" == $row_setup[P_KBN])
            {
                #############################################################################################
                ## 올더게이트 결제 취소 START
                #############################################################################################
                require($_SERVER[DOCUMENT_ROOT]."/Ags/lib/AGSLib.php");
                
                $agspay = new agspay40;

                $agspay->SetValue("AgsPayHome",$_SERVER[DOCUMENT_ROOT]."/Ags");     
                $agspay->SetValue("log","true");                                                    //true : 로그기록, false : 로그기록안함.
                $agspay->SetValue("logLevel","ERROR");                                      //로그레벨 : DEBUG, INFO, WARN, ERROR, FATAL (해당 레벨이상의 로그만 기록됨)
                $agspay->SetValue("Type", "Cancel");                                            //고정값(수정불가)
                $agspay->SetValue("RecvLen", 7);                                                    //수신 데이터(길이) 체크 에러시 6 또는 7 설정. 

                $agspay->SetValue("StoreId", $row_setup[P_ID]);                                      //상점아이디
                $agspay->SetValue("AuthTy",  "card");                                           //결제형태
                $agspay->SetValue("SubTy",   trim($row_member_row["subTy"]));      //서브결제형태
                $agspay->SetValue("rApprNo", trim($row_member_row["authum"]));     //승인번호
                $agspay->SetValue("rApprTm", trim($row_member_row["apprTm"]));     //승인일자
                $agspay->SetValue("rDealNo", trim($row_member_row["dealNo"]));     //거래번호

                echo ($agspay->startPay());

                if($agspay->GetResult("rCancelSuccYn") != "y")
                { 
                    echo "
                        <script>
                            window.alert('취소에러 : ".iconv("EUC-KR","UTF-8",$agspay->GetResult('rCancelResMsg'))."');
                            self.location.replace('od_orderslist.php?page=$page$par_page');
                        </script>";
                } else {    

                    ## 삭제하려는 대분류에 속한 상품 정보를 호출한다. ########################
                    $orderInfo = mysql_fetch_array(mysql_query("select * from odtOrder where ordernum='".$_GET[ordernum]."'"));

                    # 상품 재고 및 현 구매량 수정
                    $pLogTmp = explode("^",$orderInfo[pLog]);
                    for($o=0;$o<count($pLogTmp);$o++) {
                        list($codeTmp,$stockTmp,$PriceTmp) = explode("|",$pLogTmp[$o]);
                        mysql_query("update odtProduct set stock=stock+".$stockTmp.", saleCnt=saleCnt-".$stockTmp." where code ='".$codeTmp."'");
                    }
                    
                    ## 주문테이블의 canceled 값을 Y 로 업데이트 한다. ####################################################
                    $canceldate = time();
                    mysql_query("UPDATE odtOrder SET canceled='Y',canceldate='".$canceldate."' WHERE ordernum='".$orderInfo[ordernum]."'");

                    ## 포인트 지급 및 사용 취소
                    $pointRes = mysql_query("select * from odtPointLog where ordernum='".$orderInfo[ordernum]."'");

                    while($pointInfo = mysql_fetch_array($pointRes)) {

                        if($pointInfo[pointPoint] < 0) {    // 사용한 포인트 처리

                            if($pointInfo[pointStatus] == "Y") {    // 이미사용한 포인트는 환불처리
                                $pointTitle = str_replace("상품 구입시 사용","구입 취소",$pointInfo[pointTitle]);
                                mysql_query("insert into odtPointLog set 
                                                            pointID             =   '".$pointInfo[pointID]."',
                                                            pointTitle      = '".$pointTitle."', 
                                                            pointPoint      =   '".($pointInfo[pointPoint]*-1)."', 
                                                            pointRegidate   =   now(),
                                                            pointStatus     =   'N',
                                                            ordernum            =   '".$orderInfo[ordernum]."',
                                                            redRegidate     =   '".date('Y-m-d')."'");
                            } else {    // 아직 사용하지 않았으면 
                                $pointTitle = str_replace("상품 구입시 사용","구입 취소",$pointInfo[pointTitle]);
                                mysql_query("update odtPointLog set pointPoint='0', pointTitle      = '".$pointTitle."', redRegidate='".date('Y-m-d')."' where pointNo ='".$pointInfo[pointNo]."'");
                            }

                        } else {    // 적립예정 또는 적립된 포인트 처리

                            if($pointInfo[pointStatus] == "Y") { // 이미 지급 되었으면 차감처리
                                $pointTitle = str_replace("상품 구입","구입 취소",$pointInfo[pointTitle]);
                                mysql_query("insert into odtPointLog set 
                                                            pointID             =   '".$pointInfo[pointID]."',
                                                            pointTitle      = '".$pointTitle."', 
                                                            pointPoint      =   '-".$pointInfo[pointPoint]."', 
                                                            pointRegidate   =   now(),
                                                            pointStatus     =   'N',
                                                            ordernum            =   '".$orderInfo[ordernum]."',
                                                            redRegidate     =   '".date('Y-m-d')."'");
                            } else {    // 아직 지급되지 않았으면 금액을 0으로 수정
                                $pointTitle = str_replace("상품 구입","구입 취소",$pointInfo[pointTitle]);
                                mysql_query("update odtPointLog set pointPoint='0', pointTitle      = '".$pointTitle."', redRegidate='".date('Y-m-d')."' where pointNo ='".$pointInfo[pointNo]."'");
                            }

                        }
                    }

                    # 포인트 테이블 업데이트
                    exec("/usr/local/bin/php ".$_SERVER[DOCUMENT_ROOT]."/cron/pointAutoUpdate.php");

                    # 주문자에게 취소문자 발송
                    if($orderInfo[orderhtel1] && $orderInfo[orderhtel2] && $orderInfo[orderhtel3]) {
                        $tran_phone         = $orderInfo[orderhtel1] ."-". $orderInfo[orderhtel2] ."-". $orderInfo[orderhtel3];
                        $tran_callback  = $row_company[tel];


                        $smsQuery  = " SELECT * FROM m_sms_set WHERE smskbn = 'cancel' ";
                        $smsResult = mysql_query($smsQuery);
                        $smsRecord = mysql_fetch_array($smsResult);

                        if ("y" == $smsRecord[smschk])
                        {
                            $tran_msg =   $smsRecord[smstext]." 주문번호 : ".$orderInfo[ordernum];
                            $smsQue = "insert into em_tran set tran_phone = '".$tran_phone."', tran_callback = '".$tran_callback."', tran_msg= '".$tran_msg."', tran_status = 1, tran_date = now()";
                            mysql_query($smsQue);
                        }
                    }

                }

                #############################################################################################
                ## 올더게이트 결제 취소 END
                #############################################################################################
            }
            else if ("I" == $row_setup[P_KBN])
            {
                #############################################################################################
                ## 이니시스 결제 취소 START
                #############################################################################################
                require($_SERVER[DOCUMENT_ROOT]."/../INIpayG/libs/INILib.php");

                $inipay = new INIpay50;

                $inipay->SetField("inipayhome", $_SERVER[DOCUMENT_ROOT]."/../INIpayG"); // 이니페이 홈디렉터리(상점수정 필요)
                $inipay->SetField("type", "cancel");                            // 고정 (절대 수정 불가)
                $inipay->SetField("debug", "true");                             // 로그모드("true"로 설정하면 상세로그가 생성됨.)
                $inipay->SetField("mid", $row_setup[P_ID]);                         // 상점아이디
                $inipay->SetField("admin", "1111");                             // 비대칭 사용키 키패스워드
                $inipay->SetField("tid", $row_member_row[authum]);                     // 취소할 거래의 거래아이디
                $inipay->SetField("cancelmsg", "");                             // 취소사유

                $inipay->startAction();

                if($inipay->getResult('ResultCode')!="00"){
                    echo "
                        <script>
                            window.alert('".iconv("EUC-KR","UTF-8",$inipay->getResult('ResultMsg'))."');
                            self.location.replace('od_orderslist.php?page=$page$par_page');
                        </script>";
                } else {    

                    ## 삭제하려는 대분류에 속한 상품 정보를 호출한다. ########################
                    $orderInfo = mysql_fetch_array(mysql_query("select * from odtOrder where ordernum='".$_GET[ordernum]."'"));

                    # 상품 재고 및 현 구매량 수정
                    $pLogTmp = explode("^",$orderInfo[pLog]);
                    for($o=0;$o<count($pLogTmp);$o++) {
                        list($codeTmp,$stockTmp,$PriceTmp) = explode("|",$pLogTmp[$o]);
                        mysql_query("update odtProduct set stock=stock+".$stockTmp.", saleCnt=saleCnt-".$stockTmp." where code ='".$codeTmp."'");
                    }
                    
                    ## 주문테이블의 canceled 값을 Y 로 업데이트 한다. ####################################################
                    $canceldate = time();
                    mysql_query("UPDATE odtOrder SET canceled='Y',canceldate='".$canceldate."' WHERE ordernum='".$orderInfo[ordernum]."'");

                    ## 포인트 지급 및 사용 취소
                    $pointRes = mysql_query("select * from odtPointLog where ordernum='".$orderInfo[ordernum]."'");

                    while($pointInfo = mysql_fetch_array($pointRes)) {

                        if($pointInfo[pointPoint] < 0) {    // 사용한 포인트 처리

                            if($pointInfo[pointStatus] == "Y") {    // 이미사용한 포인트는 환불처리
                                $pointTitle = str_replace("상품 구입시 사용","구입 취소",$pointInfo[pointTitle]);
                                mysql_query("insert into odtPointLog set 
                                                            pointID             =   '".$pointInfo[pointID]."',
                                                            pointTitle      = '".$pointTitle."', 
                                                            pointPoint      =   '".($pointInfo[pointPoint]*-1)."', 
                                                            pointRegidate   =   now(),
                                                            pointStatus     =   'N',
                                                            ordernum            =   '".$orderInfo[ordernum]."',
                                                            redRegidate     =   '".date('Y-m-d')."'");
                            } else {    // 아직 사용하지 않았으면 
                                $pointTitle = str_replace("상품 구입시 사용","구입 취소",$pointInfo[pointTitle]);
                                mysql_query("update odtPointLog set pointPoint='0', pointTitle      = '".$pointTitle."', redRegidate='".date('Y-m-d')."' where pointNo ='".$pointInfo[pointNo]."'");
                            }

                        } else {    // 적립예정 또는 적립된 포인트 처리

                            if($pointInfo[pointStatus] == "Y") { // 이미 지급 되었으면 차감처리
                                $pointTitle = str_replace("상품 구입","구입 취소",$pointInfo[pointTitle]);
                                mysql_query("insert into odtPointLog set 
                                                            pointID             =   '".$pointInfo[pointID]."',
                                                            pointTitle      = '".$pointTitle."', 
                                                            pointPoint      =   '-".$pointInfo[pointPoint]."', 
                                                            pointRegidate   =   now(),
                                                            pointStatus     =   'N',
                                                            ordernum            =   '".$orderInfo[ordernum]."',
                                                            redRegidate     =   '".date('Y-m-d')."'");
                            } else {    // 아직 지급되지 않았으면 금액을 0으로 수정
                                $pointTitle = str_replace("상품 구입","구입 취소",$pointInfo[pointTitle]);
                                mysql_query("update odtPointLog set pointPoint='0', pointTitle      = '".$pointTitle."', redRegidate='".date('Y-m-d')."' where pointNo ='".$pointInfo[pointNo]."'");
                            }

                        }
                    }

                    # 포인트 테이블 업데이트
                    exec("/usr/local/bin/php ".$_SERVER[DOCUMENT_ROOT]."/cron/pointAutoUpdate.php");

                    # 주문자에게 취소문자 발송
                    if($orderInfo[orderhtel1] && $orderInfo[orderhtel2] && $orderInfo[orderhtel3]) {
                        $tran_phone         = $orderInfo[orderhtel1] ."-". $orderInfo[orderhtel2] ."-". $orderInfo[orderhtel3];
                        $tran_callback  = $row_company[tel];

                        $smsQuery  = " SELECT * FROM m_sms_set WHERE smskbn = 'cancel' ";
                        $smsResult = mysql_query($smsQuery);
                        $smsRecord = mysql_fetch_array($smsResult);

                        if ("y" == $smsRecord[smschk])
                        {
                            $tran_msg =   $smsRecord[smstext]." 주문번호 : ".$orderInfo[ordernum];
                            $smsQue = "insert into em_tran set tran_phone = '".$tran_phone."', tran_callback = '".$tran_callback."', tran_msg= '".$tran_msg."', tran_status = 1, tran_date = now()";
                            mysql_query($smsQue);
                        }
                    }

                }
            
                #############################################################################################
                ## 이니시스 결제 취소 END
                #############################################################################################
            }
            else if ("K" == $row_setup[P_KBN])
            {
                #############################################################################################
                ## KCP 결제 취소 START
                #############################################################################################
                require $_SERVER[DOCUMENT_ROOT]."/kcp/cfg/site_conf_inc.php";       // 환경설정 파일 include
                require $_SERVER[DOCUMENT_ROOT]."/kcp/files/pp_ax_hub_lib.php";     // library [수정불가]

                $c_PayPlus = new C_PP_CLI;
                $c_PayPlus->mf_clear();

                $tno     = trim($row_member_row["authum"]);
                $tran_cd = "00200000";
                $cust_ip = getenv("REMOTE_ADDR"); // 요청 IP

                $c_PayPlus->mf_set_modx_data( "tno",      $tno                         );  // KCP 원거래 거래번호
                $c_PayPlus->mf_set_modx_data( "mod_type", "STSC"                       );  // 원거래 변경 요청 종류
                $c_PayPlus->mf_set_modx_data( "mod_ip",   $cust_ip                     );  // 변경 요청자 IP
                $c_PayPlus->mf_set_modx_data( "mod_desc", "결제 취소 - 관리자 취소" );  // 변경 사유

                $c_PayPlus->mf_do_tx( $tno,  $g_conf_home_dir, $g_conf_site_cd, "",  $tran_cd,    "", $g_conf_gw_url,  $g_conf_gw_port,  "payplus_cli_slib", $ordernum, $cust_ip, "3", 0, 0, $g_conf_key_dir, $g_conf_log_dir);

                $res_cd  = $c_PayPlus->m_res_cd;
                $res_msg = $c_PayPlus->m_res_msg;


                if ($res_cd != "0000")
                {
                    echo "
                    <script LANGUAGE='javascript'>
                        window.alert(\"실결제취소 처리 중 오류가 발생하였습니다.\\n\\n".(trim(reset(explode("-",$row_company[tel]))) ? $row_company[tel] : substr($row_company[tel],1,10))."로 전화주시거나, 고객문의에 아래 오류코드와 오류내용을 첨부하여 결제취소요청하시면 처리해드리겠습니다.\\n\\n오류 코드 : ".iconv("EUC-KR","UTF-8",$c_PayPlus->m_res_msg)."\");
                        parent.location.reload();
                    </script>";
                }
                else
                {
                    ## 삭제하려는 대분류에 속한 상품 정보를 호출한다. ########################
                    $orderInfo = mysql_fetch_array(mysql_query("select * from odtOrder where ordernum='".$_GET[ordernum]."'"));

                    # 상품 재고 및 현 구매량 수정
                    $pLogTmp = explode("^",$orderInfo[pLog]);
                    for($o=0;$o<count($pLogTmp);$o++) {
                        list($codeTmp,$stockTmp,$PriceTmp) = explode("|",$pLogTmp[$o]);
                        mysql_query("update odtProduct set stock=stock+".$stockTmp.", saleCnt=saleCnt-".$stockTmp." where code ='".$codeTmp."'");
                    }
                    
                    ## 주문테이블의 canceled 값을 Y 로 업데이트 한다. ####################################################
                    $canceldate = time();
                    mysql_query("UPDATE odtOrder SET canceled='Y',canceldate='".$canceldate."' WHERE ordernum='".$orderInfo[ordernum]."'");

                    ## 포인트 지급 및 사용 취소
                    $pointRes = mysql_query("select * from odtPointLog where ordernum='".$orderInfo[ordernum]."'");

                    while($pointInfo = mysql_fetch_array($pointRes)) {

                        if($pointInfo[pointPoint] < 0) {    // 사용한 포인트 처리

                            if($pointInfo[pointStatus] == "Y") {    // 이미사용한 포인트는 환불처리
                                $pointTitle = str_replace("상품 구입시 사용","구입 취소",$pointInfo[pointTitle]);
                                mysql_query("insert into odtPointLog set 
                                                            pointID             =   '".$pointInfo[pointID]."',
                                                            pointTitle      = '".$pointTitle."', 
                                                            pointPoint      =   '".($pointInfo[pointPoint]*-1)."', 
                                                            pointRegidate   =   now(),
                                                            pointStatus     =   'N',
                                                            ordernum            =   '".$orderInfo[ordernum]."',
                                                            redRegidate     =   '".date('Y-m-d')."'");
                            } else {    // 아직 사용하지 않았으면 
                                $pointTitle = str_replace("상품 구입시 사용","구입 취소",$pointInfo[pointTitle]);
                                mysql_query("update odtPointLog set pointPoint='0', pointTitle      = '".$pointTitle."', redRegidate='".date('Y-m-d')."' where pointNo ='".$pointInfo[pointNo]."'");
                            }

                        } else {    // 적립예정 또는 적립된 포인트 처리

                            if($pointInfo[pointStatus] == "Y") { // 이미 지급 되었으면 차감처리
                                $pointTitle = str_replace("상품 구입","구입 취소",$pointInfo[pointTitle]);
                                mysql_query("insert into odtPointLog set 
                                                            pointID             =   '".$pointInfo[pointID]."',
                                                            pointTitle      = '".$pointTitle."', 
                                                            pointPoint      =   '-".$pointInfo[pointPoint]."', 
                                                            pointRegidate   =   now(),
                                                            pointStatus     =   'N',
                                                            ordernum            =   '".$orderInfo[ordernum]."',
                                                            redRegidate     =   '".date('Y-m-d')."'");
                            } else {    // 아직 지급되지 않았으면 금액을 0으로 수정
                                $pointTitle = str_replace("상품 구입","구입 취소",$pointInfo[pointTitle]);
                                mysql_query("update odtPointLog set pointPoint='0', pointTitle      = '".$pointTitle."', redRegidate='".date('Y-m-d')."' where pointNo ='".$pointInfo[pointNo]."'");
                            }

                        }
                    }

                    # 포인트 테이블 업데이트
                    exec("/usr/local/bin/php ".$_SERVER[DOCUMENT_ROOT]."/cron/pointAutoUpdate.php");

                    # 주문자에게 취소문자 발송
                    if($orderInfo[orderhtel1] && $orderInfo[orderhtel2] && $orderInfo[orderhtel3]) {
                        $tran_phone         = $orderInfo[orderhtel1] ."-". $orderInfo[orderhtel2] ."-". $orderInfo[orderhtel3];
                        $tran_callback  = $row_company[tel];

                        $smsQuery  = " SELECT * FROM m_sms_set WHERE smskbn = 'cancel' ";
                        $smsResult = mysql_query($smsQuery);
                        $smsRecord = mysql_fetch_array($smsResult);

                        if ("y" == $smsRecord[smschk])
                        {
                            $tran_msg =   $smsRecord[smstext]." 주문번호 : ".$orderInfo[ordernum];
                            $smsQue = "insert into em_tran set tran_phone = '".$tran_phone."', tran_callback = '".$tran_callback."', tran_msg= '".$tran_msg."', tran_status = 1, tran_date = now()";
                            mysql_query($smsQue);
                        }
                    }

                }
            
                #############################################################################################
                ## KCP 결제 취소 END
                #############################################################################################
            }
            else if ("S" == $row_setup[P_KBN])
            {
                echo "
                <script language=JavaScript charset='euc-kr' src='https://tx.allatpay.com/common/AllatPayRE.js'></script>
                <script language=javascript>
                function ftn_cancel(dfm) {
                  var ret;
                  ret = invisible_Cancel(dfm);//Function 내부에서 submit을 하게 되어있음.
                  if( ret.substring(0,4)!='0000' && ret.substring(0,4)!='9999'){
                    // 오류 코드 : 0001~9998 의 오류에 대해서 적절한 처리를 해주시기 바랍니다.
                    alert(ret.substring(4,ret.length));   // Message 가져오기
                  }
                  if( ret.substring(0,4)=='9999' ){
                    // 오류 코드 : 9999 의 오류에 대해서 적절한 처리를 해주시기 바랍니다.
                    alert(ret.substring(8,ret.length));     // Message 가져오기
                  }
                }
                </script>
                <form name='fm' method='post' action='/allat/cancel.php'>
                    <input type='hidden' name='allat_shop_id'       value='$row_setup[P_ID]'>
                    <input type='hidden' name='allat_order_no'      value='$_GET[ordernum]'>
                    <input type='hidden' name='allat_amt'           value='$row_member_row[dealNo]'>
                    <input type='hidden' name='allat_pay_type'      value='$row_member_row[apprTm]'>
                    <input type='hidden' name='allat_enc_data'      value=''>
                    <input type='hidden' name='allat_opt_pin'       value='NOVIEW'>
                    <input type='hidden' name='allat_opt_mod'       value='WEB'>
                </form>
                <script>
                    ftn_cancel(document.fm);
                </script>";
                exit;
            }


            echo "
            <script>
                window.alert('주문취소 절차가 완료 되었습니다. ');
                self.location.replace('od_orderslist.php?page=$page$par_page');
            </script>";

        } 
        ## 포인트 결제 취소
        else if($row_member_row[paymethod]=="G" || $row_member_row[paymethod]=="L" )
        {

                ## 삭제하려는 대분류에 속한 상품 정보를 호출한다. ########################
                $orderInfo = mysql_fetch_array(mysql_query("select * from odtOrder where ordernum='".$_GET[ordernum]."'"));

                # 상품 재고 및 현 구매량 수정
                $pLogTmp = explode("^",$orderInfo[pLog]);
                for($o=0;$o<count($pLogTmp);$o++) {
                    list($codeTmp,$stockTmp,$PriceTmp) = explode("|",$pLogTmp[$o]);
                    mysql_query("update odtProduct set stock=stock+".$stockTmp.", saleCnt=saleCnt-".$stockTmp." where code ='".$codeTmp."'");
                }
                
                ## 주문테이블의 canceled 값을 Y 로 업데이트 한다. ####################################################
                $canceldate = time();
                mysql_query("UPDATE odtOrder SET canceled='Y',canceldate='".$canceldate."' WHERE ordernum='".$orderInfo[ordernum]."'");

                ## 포인트 지급 및 사용 취소
                $pointRes = mysql_query("select * from odtPointLog where ordernum='".$orderInfo[ordernum]."'");

                while($pointInfo = mysql_fetch_array($pointRes)) {

                    if($pointInfo[pointPoint] < 0) {    // 사용한 포인트 처리

                        if($pointInfo[pointStatus] == "Y") {    // 이미사용한 포인트는 환불처리
                            $pointTitle = str_replace("상품 구입시 사용","구입 취소",$pointInfo[pointTitle]);
                            mysql_query("insert into odtPointLog set 
                                                        pointID             =   '".$pointInfo[pointID]."',
                                                        pointTitle      = '".$pointTitle."', 
                                                        pointPoint      =   '".($pointInfo[pointPoint]*-1)."', 
                                                        pointRegidate   =   now(),
                                                        pointStatus     =   'N',
                                                        ordernum            =   '".$orderInfo[ordernum]."',
                                                        redRegidate     =   '".date('Y-m-d')."'");
                        } else {    // 아직 사용하지 않았으면 
                            $pointTitle = str_replace("상품 구입시 사용","구입 취소",$pointInfo[pointTitle]);
                            mysql_query("update odtPointLog set pointPoint='0', pointTitle      = '".$pointTitle."', redRegidate='".date('Y-m-d')."' where pointNo ='".$pointInfo[pointNo]."'");
                        }

                    } else {    // 적립예정 또는 적립된 포인트 처리

                        if($pointInfo[pointStatus] == "Y") { // 이미 지급 되었으면 차감처리
                            $pointTitle = str_replace("상품 구입","구입 취소",$pointInfo[pointTitle]);
                            mysql_query("insert into odtPointLog set 
                                                        pointID             =   '".$pointInfo[pointID]."',
                                                        pointTitle      = '".$pointTitle."', 
                                                        pointPoint      =   '-".$pointInfo[pointPoint]."', 
                                                        pointRegidate   =   now(),
                                                        pointStatus     =   'N',
                                                        ordernum            =   '".$orderInfo[ordernum]."',
                                                        redRegidate     =   '".date('Y-m-d')."'");
                        } else {    // 아직 지급되지 않았으면 금액을 0으로 수정
                            $pointTitle = str_replace("상품 구입","구입 취소",$pointInfo[pointTitle]);
                            mysql_query("update odtPointLog set pointPoint='0', pointTitle      = '".$pointTitle."', redRegidate='".date('Y-m-d')."' where pointNo ='".$pointInfo[pointNo]."'");
                        }

                    }
                }

                # 포인트 테이블 업데이트
                exec("/usr/local/bin/php ".$_SERVER[DOCUMENT_ROOT]."/cron/pointAutoUpdate.php");

                # 주문자에게 취소문자 발송
                if($orderInfo[orderhtel1] && $orderInfo[orderhtel2] && $orderInfo[orderhtel3]) {
                    $tran_phone         = $orderInfo[orderhtel1] ."-". $orderInfo[orderhtel2] ."-". $orderInfo[orderhtel3];
                    $tran_callback  = $row_company[tel];

                    $smsQuery  = " SELECT * FROM m_sms_set WHERE smskbn = 'cancel' ";
                    $smsResult = mysql_query($smsQuery);
                    $smsRecord = mysql_fetch_array($smsResult);

                    if ("y" == $smsRecord[smschk])
                    {
                        $tran_msg =   $smsRecord[smstext]." 주문번호 : ".$orderInfo[ordernum];
                        $smsQue = "insert into em_tran set tran_phone = '".$tran_phone."', tran_callback = '".$tran_callback."', tran_msg= '".$tran_msg."', tran_status = 1, tran_date = now()";
                        mysql_query($smsQue);
                    }
                }


                echo "
                <script>
                    window.alert('주문취소 절차가 완료 되었습니다. ');
                    self.location.replace('od_orderslist.php?page=$page$par_page');
                </script>";

        }


        else
        {

            ## 주문테이블의 canceled 값을 Y 로 업데이트 한다. ####################################################
            $canceldate = time();
            mysql_query("UPDATE odtOrder SET canceled='Y',canceldate='".$canceldate."' WHERE ordernum='".$_GET[ordernum]."'");

            echo "
            <script>
                window.alert('주문취소 절차가 완료 되었습니다. ');
                self.location.replace('od_orderslist.php?page=$page$par_page');
            </script>";

        }

            #############################################################################################
            ## 이니시스 결제 취소 START
            #############################################################################################

    }
    else
    {
        echo "
            <script language=\"javascript\">
                if(confirm(\"선택하신 주문에 대한 취소 절차를 진행 하시겠습니까?   \")) {
                    self.location.replace('?Form=orderCancel&ordernum=$ordernum&page=$page$par_page')
                }
                else {
                    self.location.replace('od_orderslist.php?page=$page$par_page')
                }
            </script>";
        
        exit;
    }


?>