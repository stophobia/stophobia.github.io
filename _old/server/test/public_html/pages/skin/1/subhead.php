<?

//-----------------------------------------------------------------------------
// 서브페이지 head부분
//-----------------------------------------------------------------------------
if ("u02b01" == $Pid) { $subtitle_img = "<img src='/images/group/custom_subject_01.gif' width='677' height='72'>";   }   // 고객센타
if ("u02b02" == $Pid) { $subtitle_img = "<img src='/images/group/custom_subject_02.gif' width='677' height='72'>";   }   // 고객문의
if ($board) { $subtitle_img = "<img src='/images/group/custom_subject_00".$board.".gif' width='677' height='72'>";   }   // 게시판

if ("u04b04" == $Pid) { $subtitle_img = "<img src='images/company_img_01.jpg' width='853' height='163' />";   }   // 회사소개
if ("u04b05" == $Pid) { $subtitle_img = "<img src='images/company_img_06.jpg' width='853' height='163' />";   }   // 개인보호정책
if ("u04b06" == $Pid) { $subtitle_img = "<img src='images/company_img_08.jpg' width='853' height='163' />";   }   // 서비스이용약관
if ("u04b09" == $Pid) { $subtitle_img = "<img src='images/company_img_10.jpg' width='853' height='163' />";   }   // 이용안내

//-----------------------------------------------------------------------------
// 회원정보수정, 참여점수,주문내역, 포인트적립내역, my쿠폰함, 1:1상담내역, 나의글모음, 회원탈퇴
//-----------------------------------------------------------------------------
if (ereg("od_modify.php|od_ordersearchresult.php", $_SERVER[PHP_SELF]) || "u03b02" == $Pid || "u03b04" == $Pid || "u03b05" == $Pid || "u03b06" == $Pid || "u03b07" == $Pid || "u03b08" == $Pid)
{
    echo "
    <table width='100%' border='0' cellspacing='0' cellpadding='0'>
        <tr>
            <td height='31'>&nbsp;</td>
        </tr>
    </table>
    <table width='960' border='0' align='center' cellpadding='0' cellspacing='0'>
        <tr>
            <td width='180'  valign='top' height=100%  bgcolor='f0f0f0'>";


    include $_SERVER[DOCUMENT_ROOT]."/odprogram/odmembers/od_leftMenu.inc.php";

            echo "
            </td>
            <td width='20' valign='top'></td>
            <td width=760 valign='top'>
                <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                    <tr>
                        <td><img src='/img/modify_img_02.jpg' width='760' height='110' /></td>
                    </tr>
                </table>";
}
//-----------------------------------------------------------------------------
// 고객센타, 고객문의, 게시판
//-----------------------------------------------------------------------------
else if ("u02b01" == $Pid || "u02b02" == $Pid || $board)
{
    echo "
    <table width='960' cellpadding='0' cellspacing='0' border='0'>
        <tr>
            <td width='698' valign='top'><br>

                <table width='677' cellpadding='0' cellspacing='0' border='0'>
                    <tr>
                        <td><img src='/images/group/sub_img_custom.gif' width='677' height='49'></td>
                    </tr>
                    <tr>
                        <td class='spt20'>";

                        include $_SERVER[DOCUMENT_ROOT]."/pages/u02/u02.head.php";

                        echo "
                        </td>
                    </tr>
                    <tr>
                        <td class='sptb20'>".$subtitle_img."</td>
                    </tr>
                    <tr>
                        <td>";
}
//-----------------------------------------------------------------------------
// 회사소개, 개인보호정책, 서비스이용약관, 이용안내
//-----------------------------------------------------------------------------
else if ("u04b04" == $Pid || "u04b05" == $Pid || "u04b06" == $Pid || "u04b09" == $Pid)
{

    echo "
    <link href='css/inno.css' rel='stylesheet' type='text/css' />
    <table width='100%' border='0' cellspacing='0' cellpadding='0'>
        <tr>
            <td valign='top'><table width='853' border='0' align='center' cellpadding='0' cellspacing='0'>
        <tr>
            <td>".$subtitle_img."</td>
        </tr>
    </table>
    <table width='853' border='0' align='center' cellpadding='0' cellspacing='0'>
        <tr>
            <td width='37' valign='top' background='images/company_img_02.jpg'>&nbsp;</td>
            <td width='779' valign='top'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
        <tr>
            <td>&nbsp;</td>
        </tr>
    </table>
    <table width='100%' border='0' cellspacing='0' cellpadding='0'>
        <tr>
            <td valign='top'>";
}

?>