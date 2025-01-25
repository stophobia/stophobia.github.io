<?

## sms로 발송
if($htel1 && $htel2 && $htel3) {
    $tran_phone			= $htel1 ."-". $htel2 ."-". $htel3;
    $tran_callback	= $row_company[tel];

    $smsQuery  = " SELECT * FROM m_sms_set WHERE smskbn = 'memjoin' ";
    $smsResult = mysql_query($smsQuery);
    $smsRecord = mysql_fetch_array($smsResult);

    if ("y" == $smsRecord[smschk])
    {
        $tran_msg = $name."님의 ".$smsRecord[smstext]." 아이디: ".$id;    // 문자메시지 내용
        $smsQue = "insert into em_tran set tran_phone = '".$tran_phone."', tran_callback = '".$tran_callback."', tran_msg= '".$tran_msg."', tran_status = 1, tran_date = now()";
        mysql_query($smsQue);
    }

}
?>