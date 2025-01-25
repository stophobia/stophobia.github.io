<?
if($orderhtel1Tmp && $orderhtel2Tmp && $orderhtel3Tmp) {

        $cart_result = mysql_query("select * from odtOrder where ordernum='".$ordernum."'");
        $cart_row = mysql_fetch_array($cart_result);
        $oLogArray = explode("^",preg_replace("[^\^]","",$cart_row[oLog]));
        $pLogArray = explode("^",$cart_row[pLog]);
        $cLogArray = explode("^",$cart_row[cLog]);

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


            $tran_phone     = $orderhtel1Tmp ."-". $orderhtel2Tmp ."-". $orderhtel3Tmp;
            $tran_callback  = $row_company[tel];
            $tran_msg       =   $smsRecord[smstext]." ".$prow[name]." ".$proCode[1]."개 ".  $expressnumTmp;   

            $tran_msg = iconv("utf-8","euckr",trim($tran_msg));
            $text_array = cut_str($tran_msg,80,100);
                
            for($ii=1;$ii<count($text_array);$ii++) {
                
                if ("y" == $smsRecord[smschk])
                {
                    $smsQue = "insert into em_tran set tran_phone = '".$tran_phone."', tran_callback = '".$tran_callback."', tran_msg= '".trim(iconv("euckr","utf-8",$text_array[$ii]))."', tran_status = 1, tran_date = now()";
                    mysql_query($smsQue);
                }

            }

        }

}



?>