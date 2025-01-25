<?

// 서브페이지일때는 페이지에 따른 head부분을 추출 /////////////////////////////
include $_SERVER[DOCUMENT_ROOT]."/pages/skin/$row_setup[P_SKIN]/subfooter.php";

echo "
<table width='950' cellpadding='0' cellspacing='0' border='0' class='smtmb50' align='center'>
    <tr>
        <td class='spr30' valign='top'><img src='/pages/skin/3/img/copy_logo.gif'></td>
        <td width='1' bgcolor='#edebe5'> </td>
        <td valign='top' class='splr30'>
            <p><a href='/?Pid=u04b06' class='copy'>서비스이용약관</a> <span class='copy_line'>ㅣ</span>
            <a href='/?Pid=u04b05' class='copy'>개인정보보호정책</a> <span class='copy_line'>ㅣ</span>
            <a href='/?Pid=u02b02' class='copy'>광고제휴문의</a> <span class='copy_line'>ㅣ</span>
            <a href='/?Pid=u04b04' class='copy'>회사소개</a></p>
            <p>".$row_company[name]." <span class='copy_line'>ㅣ</span> ".$row_company[taxaddress]." <br>
                대표이사 ".$row_company[ceoname]." <span class='copy_line'>ㅣ</span> 사업자등록번호 ".$row_company[number1]." <br>
                통신판매업신고 ".$row_company[number2]." <span class='copy_line'>ㅣ</span> 이메일 ".$row_company[email]."</p>
            <p class='s'>Copyright (c) 2010 <b>ONEDAYNET</b>. All right reserved </p>
        </td>
        <td width='1' bgcolor='#edebe5'> </td>
        <td valign='top' class='splr30'><span class='copy'>고객센터 : TEL ".$row_company[tel]." <br>
            ".$row_company[email]."</span><br>
            월 ~ 금 오전10 ~ 오후6시<br>
            토.일.공휴일 휴무</td>
    </tr>
</table>";


?>