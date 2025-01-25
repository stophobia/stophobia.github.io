<?
//-----------------------------------------------------------------------------
// 서브페이지 head부분
//-----------------------------------------------------------------------------


//-----------------------------------------------------------------------------
// 회원정보수정, 참여점수,주문내역, 포인트적립내역, my쿠폰함, 1:1상담내역, 나의글모음, 회원탈퇴
//-----------------------------------------------------------------------------
if (ereg("od_modify.php|od_ordersearchresult.php", $_SERVER[PHP_SELF]) || "u03b02" == $Pid || "u03b04" == $Pid || "u03b05" == $Pid || "u03b06" == $Pid || "u03b07" == $Pid || "u03b08" == $Pid)
{
    if (ereg("modify.php", $_SERVER[PHP_SELF])) { $id_title = "sub_con5";  }
    if ("u03b02" == $Pid) { $id_title = "sub_con6";     }
    if (ereg("od_ordersearchresult.php", $_SERVER[PHP_SELF])) { $id_title = "sub_con7";  }
    if ("u03b04" == $Pid) { $id_title = "sub_con8";     }
    if ("u03b05" == $Pid) { $id_title = "sub_con9";     }
    if ("u03b06" == $Pid) { $id_title = "sub_con10";    }
    if ("u03b07" == $Pid) { $id_title = "sub_con11";    }
    if ("u03b08" == $Pid) { $id_title = "sub_con12";    }

    echo "
    <table width='950' cellpadding='0' cellspacing='0' border='0' bgcolor='#FFFFFF' id=table_layer>
        <tr>
            <td align='center' class='sptb30'>
                <table width='886' border='0' cellspacing='0' cellpadding='0'>
                    <tr>
                        <td width='146'><img src='/pages/skin/3/img/sub_title_mypage.gif' width='170' height='43'></td>
                        <td align='right'>";


    include $_SERVER[DOCUMENT_ROOT]."/pages/skin/3/u03.head.php";

                        echo "
                        </td>
                    </tr>
                </table>
                <table id='tt_line' cellpadding='0' cellspacing='0'>
                    <tr><td> </td></tr>
                </table>
                <div id='".$id_title."'>
                    <table width='100%' cellpadding='0' cellspacing='0' border='0'>
                        <tr>
                            <td valign='top' align='center'>";
}
//-----------------------------------------------------------------------------
// 고객센타, 고객문의, 게시판
//-----------------------------------------------------------------------------
else if ("u02b01" == $Pid || "u02b02" == $Pid || $board)
{
    if ("u02b01" == $Pid) { $id_title = "sub_con1";     }
    if ("u02b02" == $Pid) { $id_title = "sub_con2";     }
    if ("1" == $Pid) { $id_title = "sub_con3";    }
    if ("2" == $Pid) { $id_title = "sub_con4";    }

    echo "
    <table width='950' cellpadding='0' cellspacing='0' border='0' bgcolor='#FFFFFF' id=table_layer>
        <tr>
            <td align='center' class='sptb30'>
                <table width='886' border='0' cellspacing='0' cellpadding='0'>
                    <tr>
                        <td width='146'><img src='/pages/skin/3/img/sub_title_customer.gif' width='146' height='43'></td>
                        <td align='right'>";

    include $_SERVER[DOCUMENT_ROOT]."/pages/skin/3/u02.head.php";

                        echo "
                        </td>
                    </tr>
                </table>
                <table id='tt_line' cellpadding='0' cellspacing='0'>
                    <tr><td> </td></tr>
                </table>
                <div id='".$id_title."'>
                    <table width='100%' cellpadding='0' cellspacing='0' border='0'>
                        <tr>
                            <td valign='top' align='center'>";
}
//-----------------------------------------------------------------------------
// 회사소개, 개인보호정책, 서비스이용약관, 이용안내
//-----------------------------------------------------------------------------
else if ("u04b04" == $Pid || "u04b05" == $Pid || "u04b06" == $Pid || "u04b09" == $Pid)
{
    if ("u04b04" == $Pid) { $subtitle_img = "<img src='/pages/skin/3/img/sub_title_company.gif' width='358' height='43'>";   }   // 회사소개
    if ("u04b05" == $Pid) { $subtitle_img = "<img src='/pages/skin/3/img/sub_title_guide1.gif'  width='256' height='43'>";   }   // 개인보호정책
    if ("u04b06" == $Pid) { $subtitle_img = "<img src='/pages/skin/3/img/sub_title_guide2.gif'  width='238' height='43'>";   }   // 서비스이용약관
    if ("u04b09" == $Pid) { $subtitle_img = "<img src='/pages/skin/3/img/sub_title_guide3.gif'  width='141' height='43'>";   }   // 이용안내

    echo "
    <table width='950' cellpadding='0' cellspacing='0' border='0' bgcolor='#FFFFFF' id=table_layer>
        <tr>
            <td align='center' class='sptb30'>
                <table width='886' border='0' cellspacing='0' cellpadding='0'>
                    <tr>
                        <td>".$subtitle_img."</td>
                    </tr>
                </table>
                <table id='tt_line' cellpadding='0' cellspacing='0'>
                    <tr><td> </td></tr>
                </table>
                <table width='886' border='0' cellspacing='0' cellpadding='0' class='smt35'>
                    <tr>
                        <td>";
}
else
{
    echo "
    <table width='950' cellpadding='0' cellspacing='0' border='0' bgcolor='#FFFFFF' id=table_layer>
        <tr>
            <td align='center'>";
}



?>