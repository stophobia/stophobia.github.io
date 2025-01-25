<?
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_config.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_function.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_lib.inc.php";

// 올앳 처리 //////////////////////////////////////////////////////////
include $_SERVER[DOCUMENT_ROOT]."/allat/allatutil.php";

/********************* Service Code *********************/
$at_cross_key = $row_setup[P_KEY];
$at_shop_id   = $row_setup[P_ID];
/*********************************************************/

// 요청 데이터 설정 ///////////////////////////////////////////////////
$at_data = "allat_shop_id=".$at_shop_id."&allat_enc_data=".$_POST["allat_enc_data"]."&allat_cross_key=".$at_cross_key;
$at_txt  = CancelReq($at_data,"SSL");

// 결제 결과 값 확인
//------------------
$REPLYCD  = getValue("reply_cd",  $at_txt);
$REPLYMSG = getValue("reply_msg", $at_txt);

// 결과 값이 '0000'이면 정상임. 단, allat_test_yn=Y 일경우 '0001'이 정상임.
// 실제 취소   : allat_test_yn=N 일 경우 reply_cd=0000 이면 정상
// 테스트 취소 : allat_test_yn=Y 일 경우 reply_cd=0001 이면 정상
//----------------------------------------------------------------------------------------
if ("1" == $row_setup[P_SID]) { $tmp_test = "0001"; } else { $temp_test = "0000";   } 

if (!strcmp($REPLYCD, $temp_test))
{
    ## 삭제하려는 대분류에 속한 상품 정보를 호출한다. ########################
    $orderInfo = mysql_fetch_array(mysql_query("select * from odtOrder where ordernum='".$allat_order_no."'"));

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
    alert('".iconv("euc-kr", "utf-8", "주문이 취소되었습니다")."');
    self.location.replace('/odprogram/odmanager/odorders/od_orderslist.php?page=$page$par_page');
    </script>";
    exit;
}
else
{
    echo "
    <script>
    window.alert(\"결제취소 처리 중 오류가 발생하였습니다.\\n\\n".(trim(reset(explode("-",$row_company[tel]))) ? $row_company[tel] : substr($row_company[tel],1,10))."로 전화주시거나, 고객문의에 아래 오류코드와 오류내용을 첨부하여 결제취소요청하시면 처리해드리겠습니다.\\n\\n오류 코드 : ".iconv("EUC-KR","UTF-8",$REPLYCD)."\");
    self.location.replace('/odprogram/odmanager/odorders/od_orderslist.php?page=$page$par_page');
    </script>";
    exit;
}

?>