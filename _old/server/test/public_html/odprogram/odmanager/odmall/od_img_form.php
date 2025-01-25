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



if ("1" == $P_SKIN)
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
else
{
    // 스킨별 설정 화면을 불러옵니다 //////////////////////////////////////////
    echo "
    <table width='760' border='0' cellspacing='0' cellpadding='0'>
        <tr>
            <td><img src='/odprogram/odmanager/odimages/skin_top_01.jpg' ></td>
        </tr>
        <tr>
            <td>
                <iframe name='list' SRC='/pages/skin/$P_SKIN/skin_form.php' style='width:100%; height:600' Marginwidth='0' marginheight='0' scrolling='no' frameborder='0'></iframe>
            </td>
        <tr>
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

