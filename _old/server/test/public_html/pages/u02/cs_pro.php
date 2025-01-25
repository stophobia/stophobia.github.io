<?php
// 필요한 설정파일 불러오기
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_config.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_function.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_lib.inc.php";

$filesrc = $_FILES[file][name] ? file_upload($_FILES[file],"/odprogram/upfiles/cs") : "";


if(!$_POST[id]) {
    # 비회원용 아이디 생성
    $_POST[id] =  get_guestid($_POST[name],$_POST[email]);
}


$que = "insert into odtCS set
                cate                = '".htmlspecialchars($_POST[cate])."',
                id                  = '".htmlspecialchars($_POST[id])."',
                name                = '".htmlspecialchars($_POST[name])."',
                filesrc         = '".htmlspecialchars($filesrc)."',
                filename        = '".htmlspecialchars($_FILES[file][name])."',
                email               = '".htmlspecialchars($_POST[email])."',
                hp                  = '".htmlspecialchars($_POST[hp])."',
                title               = '".htmlspecialchars($_POST[title])."',
                content         = '".htmlspecialchars($_POST[content])."',
                regidate        = now()";

$res = mysql_query($que);

if($res) {

    /*
    # 문자발송
    if($_POST[hp]) {    // 회원에게
        $tran_phone         = $_POST[hp];
        $tran_callback  = $row_company[tel];

        $tran_msg =   "고객님의 소중한 의견이 접수되었습니다. 감사합니다.";
        $smsQue   = "insert into em_tran set tran_phone = '".$tran_phone."', tran_callback = '".$tran_callback."', tran_msg= '".$tran_msg."', tran_status = 1, tran_date = now()";
        mysql_query($smsQue);

    }

    // 관리자에게 - 지영씨
    $tran_phone     = $row_company[htel];
    $tran_callback  = $_POST[hp];

    $tran_msg =   "[고객문의] ".$_POST[title];
    $smsQue   = "insert into em_tran set tran_phone = '".$tran_phone."', tran_callback = '".$tran_callback."', tran_msg= '".$tran_msg."', tran_status = 1, tran_date = now()";
    mysql_query($smsQue);
    # 문자발송 끝
    */

    $mailheaders1       = "From:$_POST[name]<$_POST[email]>\n";
    $mailheaders1  .= "Content-Type: text/html; charset=euc-kr";
    $to1                        = "고객센터<".$row_company[email].">";
    $title1                 = "[고객문의]".$_POST[title];
    $body                       = nl2br($_POST[content])."<br>";
    $body                       .= "<a href='http://".$_SERVER[HTTP_HOST]."/".$filesrc."'>파일다운로드</a><br>";

    $to1                    = iconv("utf-8","euckr",$to1);
    $title1             = iconv("utf-8","euckr",$title1);
    $body                   = iconv("utf-8","euckr",$body);
    $mailheaders1 = iconv("utf-8","euckr",$mailheaders1);

    mail($to1,$title1,$body,$mailheaders1);

    error_msgall('접수되었습니다.');
    echo "<script>parent.location.href='/?Pid=u02b02';</script>";
    exit;
} else {

    error_msgall('접수중 오류가 발생하였습니다');
    exit;
}

?>
