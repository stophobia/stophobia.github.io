<?
    include "../../odcommon/od_config.inc.php";
    include "../../odcommon/od_lib.inc.php";
    include "$folderpath_manager_common/od_function.inc.php";  
    include "$folderpath_manager_common/od_adminAuthority.inc.php";
    include "$folderpath_manager_common/od_head.inc.php";
    include "$folderpath_manager_common/od_body.inc.php";


    switch($_POST[subMode]) {
        case "edt" :
            
            $csNo               =   $_POST[csNo];
            $aContent       =   $_POST[aContent];
            $status         =   $_POST[status];

            if($aContent) {
                if($status == "N") {
                    /*
                    # 문자발송
                    $tran_phone    = @mysql_result(mysql_query("select hp from odtCS where csNo ='".$csNo."'"),0);
                    $tran_callback = $row_company[tel];
                    $tran_msg      = "고객님 문의에 대한 답변이 등록되었습니다.";
                    mysql_query("insert into em_tran set tran_phone = '".$tran_phone."', tran_callback = '".$tran_callback."', tran_msg= '".$tran_msg."', tran_status = 1, tran_date = now()");
                    # 문자발송 끝
                    */


                    // 메일로 답변 발송 처리 //////////////////////////////////
                    $row = mysql_fetch_array(mysql_query("select * from odtCS where csNo = '".$csNo."'"));

                    $mailheaders2  = "From:$row_company[name]<$row_company[email]>\n";
                    $mailheaders2 .= "Content-Type: text/html; charset=euc-kr";
                    $to1           =   iconv("utf-8","euckr","$row_company[name]<$row_company[email]>");
                    $to2           =   iconv("utf-8","euckr","$row[name] 님<$row[email]>");
                    $title2        =   iconv("utf-8","euckr","1:1문의 답변드립니다");
                    $body          =   iconv("utf-8","euckr",str_replace("\n" , "<br>" , $aContent));
                    $mailheaders2  =   iconv("utf-8","euckr",$mailheaders2);

                    mail($to2,$title2,$body,$mailheaders2);
                    ///////////////////////////////////////////////////////////


                    $que = "update odtCS set
                                    aContent                =   '".$aContent."',
                                    status                  =   'Y',
                                    aRegidate               =   now()
                                    where
                                    csNo                        =   '".$csNo."'";
                } else {
                    $que = "update odtCS set
                                    aContent                =   '".$aContent."'
                                    where
                                    csNo                        =   '".$csNo."'";
                }
            } else {

                $que = "update odtCS set
                                aContent                =   '".$aContent."',
                                where
                                csNo                        =   '".$csNo."'";
            }


            $res = mysql_query($que);
            if(!$res) {
                error_msgall('수정중 오류가 발생하였습니다.');
                exit;
            }

            break;

    case "del" :
        $no = $_POST[no];

        for($i=0;$i<count($no);$i++) {
            mysql_query("delete from odtCS where csNo='".$no[$i]."'");
        }

        break;


}

error_msgall('처리되었습니다.');
echo "<script>parent.location.reload();</script>";
exit;


?>