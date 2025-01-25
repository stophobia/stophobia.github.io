<?
include "../odcommon/od_config.inc.php";
include "../odcommon/od_function.inc.php";
include "../odcommon/od_lib.inc.php";
    
    if($OrderNum) {

        $cart_result = mysql_query("select * from odtOrder where ordernum='".$OrderNum."'");
        $cart_row = mysql_fetch_array($cart_result);
        $oLogArray = explode("^",preg_replace("[^\^]","",$cart_row[oLog]));
        $pLogArray = explode("^",$cart_row[pLog]);
        $cLogArray = explode("^",$cart_row[cLog]);


        if($cart_row[viewDel] == "1") {
            ## 문자발송
            $orderhtel1         = $cart_row[rechtel1];
            $orderhtel2         = $cart_row[rechtel2];
            $orderhtel3         = $cart_row[rechtel3];
        } else {
            ## 문자발송
            $orderhtel1         = $cart_row[orderhtel1];
            $orderhtel2         = $cart_row[orderhtel2];
            $orderhtel3         = $cart_row[orderhtel3];
        }
        $expressnumTmp      = $cart_row[expressnum];

        $smsQuery  = " SELECT * FROM m_sms_set WHERE smskbn = 'coupon' ";
        $smsResult = mysql_query($smsQuery);
        $smsRecord = mysql_fetch_array($smsResult);

        for($zz=0;$zz<count($pLogArray);$zz++) {
            $proCode = explode("|",$pLogArray[$zz]);
            $prow = mysql_fetch_array(mysql_query("SELECT * FROM odtProduct WHERE code='$proCode[0]'"));

            # 옵션값 추출
            if($oLogArray[$zz]) {   // 해당상품에 대한 옵션내역이 있으면
                $oLogTmp = explode("|",$oLogArray[$zz]);
                $proCode[2] += $oLogTmp[2];
                $prow[name] .= " (옵션:".$oLogTmp[1].")";
            }        


            $tran_phone     = $orderhtel1 ."-". $orderhtel2 ."-". $orderhtel3;
            $tran_callback  = $row_company[tel];

            $tran_msg   = $smsRecord[smstext]." ".$prow[name]." ".$proCode[1]."개 ".  $expressnumTmp;
            $tran_msg   = iconv("utf-8","euckr",trim($tran_msg));
            $text_array = cut_str($tran_msg,80,100);
                
            for($i=1;$i<count($text_array);$i++) {

                if ("y" == $smsRecord[smschk])
                {
                    $smsQue = "insert into em_tran set tran_phone = '".$tran_phone."', tran_callback = '".$tran_callback."', tran_msg= '".trim(iconv("euckr","utf-8",$text_array[$i]))."', tran_status = 1, tran_date = now()";
                    mysql_query($smsQue);
                    mysql_query("update odtOrder set smsCount = smsCount + 1 where ordernum ='".$OrderNum."'"); //문자발송횟수저장
                }
            }

        }

        echo "
        <script>
            parent.location.reload();
        </script>";
        exit;

    }else {
        echo"
        <SCRIPT LANGUAGE=\"JavaScript\">
        <!--
            alert('정상적인 접근이 아니거나 오류가 발생하였습니다.');
        //-->
        </SCRIPT>
        ";
    }
    exit;
?>