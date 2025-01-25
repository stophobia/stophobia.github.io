<?
    include "../../odcommon/od_config.inc.php";
    include "../odcommon/od_function.inc.php";   
    include "../odcommon/od_adminAuthority.inc.php";
    include "../odcommon/od_head.inc.php";
    include "../odcommon/od_body.inc.php";


    ## 세부권한 체크
    if($row_admin[basicLevel] < 3) {
        error_msgloc("$_manager_path_/","접근권한이 없습니다.   ");
    }
        
    $row = mysql_fetch_array(mysql_query("SELECT * FROM odtSetup WHERE serialnum='1'"));
    $P_SKIN = $row[P_SKIN];

?>

        <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
            <tr> 
                <td height="80" bgcolor="#FFFFFF">
                    <!-- top menu start -->
<? include "../odcommon/od_topMenu.inc.php"; ?>
                    <!-- top menu end -->
                </td>
            </tr>
            <tr> 
                <td valign="top"> 
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td height="6"></td>
                        </tr>
                    </table>
                    <table height="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="10">&nbsp;</td>
                            <td width="165" height="100%" valign="top"> 
                                <!-- left menu start -->
<? include "../odcommon/od_leftMenu.inc.php"; ?>
                                <!-- left menu end -->
                            </td>
                            <td width="3">&nbsp;</td>
                            <td width="782" valign="top">
                                <!-- main table start -->
                                <table width="782" height="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="D6D6D6">
                                    <tr> 
                                        <td align="center" valign="top" bgcolor="#FFFFFF">
                                            <table width="760" border="0" cellspacing="0" cellpadding="0">
<?
//-------------------------------------------------------------------------------------------------
// 이미지 변경 부분 start
//-------------------------------------------------------------------------------------------------
echo "
<script>
    function f_win_form(img)
    {
        window.open('img_form.php?img_name='+img, 'image','scrollbars=no, resizable=no, width=650,height=500,top=0,left=0');
    }

    function f_order(filed)
    {
        document.PUBLIC_FORM.ORDER_FILED.value = filed;
        var order_kbn = document.PUBLIC_FORM.ORDER_KBN.value;

        if ('DESC' == order_kbn)
        {
            document.PUBLIC_FORM.ORDER_KBN.value = 'ASC';
        }
        else
        {
            document.PUBLIC_FORM.ORDER_KBN.value = 'DESC';
        }

        PUBLIC_FORM.submit();
    }

</script>";


if ("1" != $P_SKIN)
{
    if (!$ORDER_FILED) { $ORDER_FILED = "1";      }
    if (!$ORDER_KBN  ) { $ORDER_KBN   = "DESC";   }

    switch ($ORDER_FILED)
    {
        case "1" : if ("DESC" == $ORDER_KBN) { $VIEW_1 = "<font color='red'>↑</font>"; } else { $VIEW_1 = "<font color='red'>↓</font>"; }; break;
        case "2" : if ("DESC" == $ORDER_KBN) { $VIEW_2 = "<font color='red'>↑</font>"; } else { $VIEW_2 = "<font color='red'>↓</font>"; }; break;
        case "3" : if ("DESC" == $ORDER_KBN) { $VIEW_3 = "<font color='red'>↑</font>"; } else { $VIEW_3 = "<font color='red'>↓</font>"; }; break;
        case "4" : if ("DESC" == $ORDER_KBN) { $VIEW_4 = "<font color='red'>↑</font>"; } else { $VIEW_4 = "<font color='red'>↓</font>"; }; break;
        case "5" : if ("DESC" == $ORDER_KBN) { $VIEW_5 = "<font color='red'>↑</font>"; } else { $VIEW_5 = "<font color='red'>↓</font>"; }; break;
    }

    // 스킨별 이미지 수정화면 /////////////////////////////////////////////////
    echo "
    <form name='PUBLIC_FORM' action='$PHP_SELF' method='POST'>
    <input type='hidden' name='ORDER_KBN'   value='$ORDER_KBN'>
    <input type='hidden' name='ORDER_FILED' value='$ORDER_FILED'>
    <table width='760' border='0' cellspacing='0' cellpadding='0'>
        <tr>
            <td align='center'>본화면은 스킨별 이미지 전체 파일을 변경할수 있도록 처리한 프로그램 화면 입니다 (임시)</td>
        </tr>
        <tr>
            <td height='20'></td>
        </tr>
        <tr>
            <td>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type='text' name='find_img' size='20' value='$find_img' style='border:1 solid rgb(#000000);'>
                <img src='/odprogram/odmanager/odimages/odmain/btn_search.gif' align='absmiddle' onClick='PUBLIC_FORM.submit();' style='cursor:hand;'>
            </td>
        </tr>
        <tr>
            <td height='5'></td>
        </tr>
        <tr>
            <td align='center'>
                <table border='1' bgcolor='#eeeeee' cellpadding='1' cellspacing='0' style='text-align:center;' bordercolordark='white' bordercolorlight='silver'>
                    <tr style='height:25px;'>
                        <td nowrap style='width:200px;' style='cursor:hand;' onClick=\"f_order('1');\" >이미지명 $VIEW_1</td>
                        <td nowrap style='width:100px;' style='cursor:hand;' onClick=\"f_order('2');\" >크기 $VIEW_2</td>
                        <td nowrap style='width:100px;'>사이즈</td>
                        <td nowrap style='width:50px;'  style='cursor:hand;' onClick=\"f_order('4');\" >종류 $VIEW_4</td>
                        <td nowrap style='width:160px;' style='cursor:hand;' onClick=\"f_order('5');\" >바뀐날자 $VIEW_5</td>
                        <td nowrap style='width:15px;'>↕</td>
                    </tr>
                    <tr>
                        <td colspan='6' height='700'>
                            <iframe name='list' SRC='od_img_form2_tran.php?P_SKIN=$P_SKIN&ORDER_FILED=$ORDER_FILED&ORDER_KBN=$ORDER_KBN&find_img=$find_img' style='width:100%; height:100%' Marginwidth='0' marginheight='0' scrolling='auto' frameborder='0'></iframe>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td height='10'></td>
        </tr>
   </table>
   </form>";
}
else
{
    // 스킨1은 이미지 수정을 할수 없음 ////////////////////////////////////////
    echo "
    <table width='760' border='0' cellspacing='0' cellpadding='0'>
        <tr>
            <td><img src='/odprogram/odmanager/odimages/skin_top_01.jpg' ></td>
        </tr>
        <tr>
            <td align='center'><font color='red'>1번 스킨은 기본스킨으로 이미지변경을 하실수 없습니다</font></td>
        </tr>
    </table>";
}


//-------------------------------------------------------------------------------------------------
// 이미지 변경 부분 end
//-------------------------------------------------------------------------------------------------


?>
                                            </table>
                                            <table width="760" border="0" cellspacing="0" cellpadding="0">
                                                <tr> 
                                                    <td height="30">&nbsp;</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr> 
                                        <td height="5" bgcolor="#FFFFFF"></td>
                                    </tr>
                                </table>
                                <!-- main table end -->
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td height="83">
                    <!-- bottom start -->
<? include "../odcommon/od_bottom.inc.php"; ?>
                    <!-- bottom end -->
                </td>
            </tr>
        </table>
    </body>
</html>

