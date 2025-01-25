<?
    include "../../odcommon/od_config.inc.php";
    include "../odcommon/od_function.inc.php";   
    include "../odcommon/od_adminAuthority.inc.php";
    include "../odcommon/od_head.inc.php";
    include "../odcommon/od_body.inc.php";

/*
ALTER TABLE odtSetup ADD P_SKIN CHAR(1) DEFAULT '1';
*/

    ## 세부권한 체크
    if($row_admin[basicLevel] < 3) {
        error_msgloc("$_manager_path_/","접근권한이 없습니다.   ");
    }

    ## 세부권한 체크(수정)
    if($row_admin[basicLevel]==5 || $row_admin[superLevel]==9) {
        $modifyTemp1 = "<input type='image' src='../odimages/odmain/btn_ok.gif' width='77' height='24' hspace='3' style='cursor:hand;' onfocus='this.blur();'>";
    }
    else {
        $modifyTemp1 = "<a href='javascript:valueCheck(this);' onfocus='this.blur();'><img src='../odimages/odmain/btn_ok.gif' width='77' height='24' hspace='3' border='0'></a>";
    }

    if(!$form) {
        
        $row = mysql_fetch_array(mysql_query("SELECT * FROM odtSetup WHERE serialnum='1'"));
        $P_SKIN = $row[P_SKIN];
?>

        <script>
            function valueCheck(form)
            {
            }

            function reset()
            {
                location.reload(true);
            }
        </script>
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
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr> 
                                                    <td height="17" bgcolor="FFFFFF" colspan="2"></td>
                                                </tr>
                                                <tr> 
                                                    <td><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 스킨/디자인 관리 &gt; <span class="st"> 스킨 설정</span></font></td>
                                                    <td align="right"></td>
                                                </tr>
                                                <tr> 
                                                    <td height="3" bgcolor="FFFFFF" colspan="2"></td>
                                                </tr>
                                                <tr> 
                                                    <td height="2" bgcolor="D6D6D6" colspan="2"></td>
                                                </tr>
                                            </table>
                                            <table width="100%" border="0" cellspacing="1" cellpadding="0">
                                                <tr>
                                                    <td height="5"></td>
                                                </tr>
                                            </table>

                                            <table width="100%" border="0" cellspacing="1" cellpadding="0">
                                                <tr> 
                                                    <td height="16"></td>
                                                </tr>
                                            </table>
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr> 
                                                    <td height="5"></td>
                                                </tr>
                                            </table>
                                            <table width="760" border="0" cellspacing="0" cellpadding="0">
                                                <!-- form start -------------------------------->
                                                <form name="snsForm" method="post" action="od_skin_form.php"  onSubmit="return valueCheck(this)">
                                                <input type="hidden" name="form" value="modifyForm">
                                                <tr> 
                                                    <td width="760" valign="top">

<?
// 스킨정보를 읽어서 해당 스킨을 선택할수 있도록 처리 /////////////////////////
$CUR_DIR = $_SERVER[DOCUMENT_ROOT]."/pages/skin/";

$TCnt = 0;
$dirHandle = opendir($CUR_DIR);
while ($filename = readdir($dirHandle))
{
    // 디렉토리일때만 처리 ////////////////////////////////////////////////////
    if (is_dir($CUR_DIR."/".$filename))
    {
        if (".." != $filename && "." != $filename && "images" != $filename)
        {
            $A_FILED[$TCnt][0]  = $filename;
            $TCnt++;
        }
    }
}
closedir($dirHandle);

// 정렬 ///////////////////////////////////////////////////////////////////////
if (0 < $TCnt)
{
    foreach ($A_FILED as $key => $row) 
    { 
        $aaa[$key] = $row[0];
    }

    array_multisort($aaa, SORT_ASC,  $A_FILED);
    reset($A_FILED);
}

// 배열로 저장된 이미지 목록 표시 /////////////////////////////////////////////
$RecCnt = $TCnt;

if ($RecCnt > 0) 
{
    echo "
    <table width='100%' cellpadding='0' cellspacing='0' border='0'>
        <tr>";

    $line = 1;

    for ($Cnt = 0; $Cnt < $RecCnt; $Cnt++)
    {
        echo "
        <td align='center'>
            <table>
                <tr>
                    <td><img src='/pages/skin/".$A_FILED[$Cnt][0]."/img/skintype_".$A_FILED[$Cnt][0].".jpg' border='1'></td>
                </tr>
                <tr>
                    <td align='center'>
                        <input type='radio' name='P_SKIN' value='".$A_FILED[$Cnt][0]."' "; if ($A_FILED[$Cnt][0] == $P_SKIN) { echo " checked"; } echo " > 스킨".$A_FILED[$Cnt][0]."
                    </td>
                </tr>
            </table>
        </td>";
        
        $line++;

        if (4 == $line)
        {
            echo "</tr><tr><td colspan='3' height='20'></td></tr><tr>";
            $line = 1;
        }
    }

    echo "
    </table>";
}



?>
                                                    </td>
                                                </tr>
                                            </table>
                                            <table><tr><td height='10'></td></tr></table>
                                            <table width="760" border="0" cellspacing="1" cellpadding="0">
                                                <tr> 
                                                    <td align="center">
                                                        <?=$modifyTemp1?>
                                                        <a href='#' onclick="reset();"><img src="../odimages/odmain/btn_cancel.gif" width="77" height="24" hspace="3" border="0" style='cursor:hand;'></a>
                                                    </td>
                                                </tr>
                                                </form>
                                                <!-- form end -------------------------------->
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
<?

}
else if(!strcmp($form,"modifyForm"))
{
    $que = " update odtSetup set P_SKIN = '$P_SKIN' where serialnum = 1";
    $result = mysql_query($que);
    
    if($result) {
        echo "
            <script>
                window.alert('저장 되었습니다.');
            </script>";

        echo "<meta http-equiv='Refresh' content='0; URL=od_skin_form.php'>";
        exit;
    }
    else {
        echo "
            <script>
                window.alert('오류 발생');
                history.go(-1);
            </script>";

        exit;
    }
}
else {
    echo "<meta http-equiv='Refresh' content='0; URL=$path_home'>";
    exit;
}

?>