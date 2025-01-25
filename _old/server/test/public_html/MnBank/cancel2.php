<?
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_config.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_function.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_lib.inc.php";

$PayMethod  = $_REQUEST['PayMethod'];
$ordernum   = $_REQUEST['OID'];
$CancelAmt  = $_REQUEST['CancelAmt'];
$CancelDate = $_REQUEST['CancelDate'];
$CancelTime = $_REQUEST['CancelTime'];
$CancelNum  = $_REQUEST['CancelNum'];
$ResultCode = $_REQUEST['ResultCode'];
$ResultMsg  = iconv("euc-kr", "utf-8", $_REQUEST['ResultMsg']);

/*
echo $PayMethod  .'<br>';
echo $ordernum   .'<br>';
echo $CancelAmt  .'<br>';
echo $CancelDate .'<br>';
echo $CancelTime .'<br>';
echo $CancelNum  .'<br>';
echo $ResultCode .'<br>';
echo $ResultMsg  .'<br>';
exit;
*/

if ("2001" != $ResultCode || !$ordernum)
{ 
    echo "
    <script>
        window.alert('취소에러 : $ResultCode - $ResultMsg ');
        self.location.replace('/odprogram/odmanager/odorders/od_orderslist.php?page=$page$par_page');
    </script>";
    exit;
} 
else
{    

    ## 삭제하려는 대분류에 속한 상품 정보를 호출한다. ########################
    $orderInfo = mysql_fetch_array(mysql_query("select * from odtOrder where ordernum='".$ordernum."'"));

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
                                            pointID         = '".$pointInfo[pointID]."',
                                            pointTitle      = '".$pointTitle."', 
                                            pointPoint      = '".($pointInfo[pointPoint]*-1)."', 
                                            pointRegidate   = now(),
                                            pointStatus     = 'N',
                                            ordernum        = '".$orderInfo[ordernum]."',
                                            redRegidate     = '".date('Y-m-d')."'");
            } else {    // 아직 사용하지 않았으면 
                $pointTitle = str_replace("상품 구입시 사용","구입 취소",$pointInfo[pointTitle]);
                mysql_query("update odtPointLog set pointPoint='0', pointTitle = '".$pointTitle."', redRegidate='".date('Y-m-d')."' where pointNo ='".$pointInfo[pointNo]."'");
            }

        } else {    // 적립예정 또는 적립된 포인트 처리

            if($pointInfo[pointStatus] == "Y") { // 이미 지급 되었으면 차감처리
                $pointTitle = str_replace("상품 구입","구입 취소",$pointInfo[pointTitle]);
                mysql_query("insert into odtPointLog set 
                                            pointID         = '".$pointInfo[pointID]."',
                                            pointTitle      = '".$pointTitle."', 
                                            pointPoint      = '-".$pointInfo[pointPoint]."', 
                                            pointRegidate   = now(),
                                            pointStatus     = 'N',
                                            ordernum        = '".$orderInfo[ordernum]."',
                                            redRegidate     = '".date('Y-m-d')."'");
            } else {    // 아직 지급되지 않았으면 금액을 0으로 수정
                $pointTitle = str_replace("상품 구입","구입 취소",$pointInfo[pointTitle]);
                mysql_query("update odtPointLog set pointPoint='0', pointTitle = '".$pointTitle."', redRegidate='".date('Y-m-d')."' where pointNo ='".$pointInfo[pointNo]."'");
            }

        }
    }

    # 포인트 테이블 업데이트
    exec("/usr/local/bin/php ".$_SERVER[DOCUMENT_ROOT]."/cron/pointAutoUpdate.php");

    # 주문자에게 취소문자 발송
    if($orderInfo[orderhtel1] && $orderInfo[orderhtel2] && $orderInfo[orderhtel3]) {
        $tran_phone     = $orderInfo[orderhtel1] ."-". $orderInfo[orderhtel2] ."-". $orderInfo[orderhtel3];
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
        window.alert('취소처리 완료');
        self.location.replace('/odprogram/odmanager/odorders/od_orderslist.php?page=$page$par_page');
    </script>";
    exit;

}



?>