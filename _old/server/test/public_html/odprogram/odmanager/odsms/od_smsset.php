<?
include "../../odcommon/od_config.inc.php";
include "$folderpath_manager_common/od_function.inc.php";   
include "$folderpath_manager_common/od_adminAuthority.inc.php";
include "$folderpath_manager_common/od_head.inc.php";
include "$folderpath_manager_common/od_body.inc.php";

## 세부권한 체크
if($row_admin[smsLevel]==3 || $row_admin[superLevel]==9) {
}
else {
    error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
}


?>

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="FFFFFF">
    <tr> 
        <td height="80" bgcolor="#FFFFFF">
            <!-- top menu start -->
<? include "$folderpath_manager_common/od_topMenu.inc.php"; ?>
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
                    <td width="165" height="100%" valign="top"> 
                        <!-- left menu start -->
<? include "$folderpath_manager_common/od_leftMenu.inc.php"; ?>
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
                                            <td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> SMS/메일링 관리 &gt; <span class="st">SMS발송문구 설정</span></font></td>
                                        </tr>
                                        <tr> 
                                            <td height="2" bgcolor="D6D6D6"></td>
                                        </tr>
                                    </table>
                                    <table width="760" border="0" cellspacing="0" cellpadding="0">
                                        <tr> 
                                            <td width="760" valign="top"><br>

<?

// sms문구 추출 ///////////////////////////////////////////////////////////////
$Query  = " SELECT * FROM m_sms_set WHERE smskbn != 'set'   ";
$Result = mysql_query($Query);
while ($Record = mysql_fetch_array($Result))
{
    $smskbn  = $Record[smskbn];

    ${"smsseq_".$smskbn}  = $Record[smsseq];
    ${"smschk_".$smskbn}  = $Record[smschk];
    ${"smstext_".$smskbn} = $Record[smstext];
}

// 주문취소시 구매자에게 발송되는 문구 ////////////////////////////////////////
echo "
<script language='javascript' src='od_smsset.js'></script>
<form name='PUBLIC_FORM1' method='post' action='od_smsset_tran.php' target='set'>
<input type='hidden' name='smskbn' value='cancel'>
<input type='hidden' name='smsseq' value='".$smsseq_cancel."'>
<table width='100%' border='0' cellspacing='0' cellpadding='3'>
    <tr>
        <td height='2' bgcolor='#000000' colspan='2'></td>
    </tr>
    <tr>
        <td align='left' style='height:24px; font-size:9pt; background-color:#F0F0F0;'>
            <table width='100%' cellpadding='0' cellspacing='0'>
                <tr><td><li>주문취소시 구매자에게 발송되는 문구</td>
                    <td align='right'>
                        <input type='radio' name='smschk' value='n' checked><font color='red'>미발송</font>&nbsp;&nbsp;
                        <input type='radio' name='smschk' value='y' "; if ("y" == $smschk_cancel) { echo " checked"; } echo " ><font color='red'>발송</font>&nbsp;
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td height='1' bgcolor='#cccccc' colspan='2'></td>
    </tr>
    <tr>
        <td align='left'>
            <table width='100%' cellpadding='0' cellspacing='0'>
                <tr>
                    <td>
                        ( <input type='text' name='smstext' value='".$smstext_cancel."'  size='50' style='font-size:9pt; me-mode:active;' maxlength='26' >&nbsp; 주문번호 : XXXXXXXXXXXXXX )
                    </td>
                    <td align='right'>
                        <img src='/images/btn_input.gif' style='cursor:hand;' align='absmiddle' onClick=\"f_save(document.forms['PUBLIC_FORM1'])\">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td height='1' bgcolor='#000000' colspan='2'></td>
    </tr>
</table>
</form>";

// 회원가입시 회원에게 발송되는 문구 //////////////////////////////////////////
echo "
<form name='PUBLIC_FORM2' method='post' action='od_smsset_tran.php' target='set'>
<input type='hidden' name='smskbn' value='memjoin'>
<input type='hidden' name='smsseq' value='".$smsseq_memjoin."'>
<table width='100%' border='0' cellspacing='0' cellpadding='3'>
    <tr>
        <td height='2' bgcolor='#000000' colspan='2'></td>
    </tr>
    <tr>
        <td align='left' style='height:24px; font-size:9pt; background-color:#F0F0F0;'>
            <table width='100%' cellpadding='0' cellspacing='0'>
                <tr><td><li>회원가입시 가입회원에게 발송되는 문구</td>
                    <td align='right'>
                        <input type='radio' name='smschk' value='n' checked><font color='red'>미발송</font>&nbsp;&nbsp;
                        <input type='radio' name='smschk' value='y' "; if ("y" == $smschk_memjoin) { echo " checked"; } echo " ><font color='red'>발송</font>&nbsp;
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td height='1' bgcolor='#cccccc' colspan='2'></td>
    </tr>
    <tr>
        <td align='left'>
            <table width='100%' cellpadding='0' cellspacing='0'>
                <tr>
                    <td>
                        ( XXX님의 <input type='text' name='smstext' value='".$smstext_memjoin."'  size='50' style='font-size:9pt; me-mode:active;' maxlength='26' > 아이디: XXXXX )
                    </td>
                    <td align='right'>
                        <img src='/images/btn_input.gif' style='cursor:hand;' align='absmiddle' onClick=\"f_save(document.forms['PUBLIC_FORM2'])\">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td height='1' bgcolor='#000000' colspan='2'></td>
    </tr>
</table>
</form>";


// 주문시 구매자에게 발송되는 문구 ////////////////////////////////////////////
echo "
<form name='PUBLIC_FORM3' method='post' action='od_smsset_tran.php' target='set'>
<input type='hidden' name='smskbn' value='order_mem'>
<input type='hidden' name='smsseq' value='".$smsseq_order_mem."'>
<table width='100%' border='0' cellspacing='0' cellpadding='3'>
    <tr>
        <td height='2' bgcolor='#000000' colspan='2'></td>
    </tr>
    <tr>
        <td align='left' style='height:24px; font-size:9pt; background-color:#F0F0F0;'>
            <table width='100%' cellpadding='0' cellspacing='0'>
                <tr><td><li>주문시 구매자에게 발송되는 문구</td>
                    <td align='right'>
                        <input type='radio' name='smschk' value='n' checked><font color='red'>미발송</font>&nbsp;&nbsp;
                        <input type='radio' name='smschk' value='y' "; if ("y" == $smschk_order_mem) { echo " checked"; } echo " ><font color='red'>발송</font>&nbsp;
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td height='1' bgcolor='#cccccc' colspan='2'></td>
    </tr>
    <tr>
        <td align='left'>
            <table width='100%' cellpadding='0' cellspacing='0'>
                <tr>
                    <td>
                        ( <input type='text' name='smstext' value='".$smstext_order_mem."'  size='50' style='font-size:9pt; me-mode:active;' maxlength='26' > 주문번호 : XXXXXXXXXXX )
                    </td>
                    <td align='right'>
                        <img src='/images/btn_input.gif' style='cursor:hand;' align='absmiddle' onClick=\"f_save(document.forms['PUBLIC_FORM3'])\">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td height='1' bgcolor='#000000' colspan='2'></td>
    </tr>
</table>
</form>";


// 주문시 운영자에게 발송되는 문구 ////////////////////////////////////////////
echo "
<form name='PUBLIC_FORM4' method='post' action='od_smsset_tran.php' target='set'>
<input type='hidden' name='smskbn' value='order_adm'>
<input type='hidden' name='smsseq' value='".$smsseq_order_adm."'>
<table width='100%' border='0' cellspacing='0' cellpadding='3'>
    <tr>
        <td height='2' bgcolor='#000000' colspan='2'></td>
    </tr>
    <tr>
        <td align='left' style='height:24px; font-size:9pt; background-color:#F0F0F0;'>
            <table width='100%' cellpadding='0' cellspacing='0'>
                <tr><td><li>주문시 운영자에게 발송되는 문구</td>
                    <td align='right'>
                        <input type='radio' name='smschk' value='n' checked><font color='red'>미발송</font>&nbsp;&nbsp;
                        <input type='radio' name='smschk' value='y' "; if ("y" == $smschk_order_adm) { echo " checked"; } echo " ><font color='red'>발송</font>&nbsp;
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td height='1' bgcolor='#cccccc' colspan='2'></td>
    </tr>
    <tr>
        <td align='left'>
            <table width='100%' cellpadding='0' cellspacing='0'>
                <tr>
                    <td>
                        ( <input type='text' name='smstext' value='".$smstext_order_adm."'  size='50' style='font-size:9pt; me-mode:active;' maxlength='26' > 주문번호 : XXXXXXXXXXX )
                    </td>
                    <td align='right'>
                        <img src='/images/btn_input.gif' style='cursor:hand;' align='absmiddle' onClick=\"f_save(document.forms['PUBLIC_FORM4'])\">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td height='1' bgcolor='#000000' colspan='2'></td>
    </tr>
</table>
</form>";


// 할인쿠폰 발송 문구 /////////////////////////////////////////////////////////
echo "
<form name='PUBLIC_FORM5' method='post' action='od_smsset_tran.php' target='set'>
<input type='hidden' name='smskbn' value='coupon'>
<input type='hidden' name='smsseq' value='".$smsseq_coupon."'>
<table width='100%' border='0' cellspacing='0' cellpadding='3'>
    <tr>
        <td height='2' bgcolor='#000000' colspan='2'></td>
    </tr>
    <tr>
        <td align='left' style='height:24px; font-size:9pt; background-color:#F0F0F0;'>
            <table width='100%' cellpadding='0' cellspacing='0'>
                <tr><td><li>할인쿠폰 발송 문구</td>
                    <td align='right'>
                        <input type='radio' name='smschk' value='n' checked><font color='red'>미발송</font>&nbsp;&nbsp;
                        <input type='radio' name='smschk' value='y' "; if ("y" == $smschk_coupon) { echo " checked"; } echo " ><font color='red'>발송</font>&nbsp;
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td height='1' bgcolor='#cccccc' colspan='2'></td>
    </tr>
    <tr>
        <td align='left'>
            <table width='100%' cellpadding='0' cellspacing='0'>
                <tr>
                    <td>
                        ( <input type='text' name='smstext' value='".$smstext_coupon."'  size='10' style='font-size:9pt; me-mode:active;' maxlength='10' > 상품관련정보가 같이 발송됩니다 )
                    </td>
                    <td align='right'>
                        <img src='/images/btn_input.gif' style='cursor:hand;' align='absmiddle' onClick=\"f_save(document.forms['PUBLIC_FORM5'])\">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td height='1' bgcolor='#000000' colspan='2'></td>
    </tr>
</table>
</form>";


// 상품토크등록시 운영자에게 발송되는 문구 ////////////////////////////////////////
echo "
<form name='PUBLIC_FORM6' method='post' action='od_smsset_tran.php' target='set'>
<input type='hidden' name='smskbn' value='talk'>
<input type='hidden' name='smsseq' value='".$smsseq_talk."'>
<table width='100%' border='0' cellspacing='0' cellpadding='3'>
    <tr>
        <td height='2' bgcolor='#000000' colspan='2'></td>
    </tr>
    <tr>
        <td align='left' style='height:24px; font-size:9pt; background-color:#F0F0F0;'>
            <table width='100%' cellpadding='0' cellspacing='0'>
                <tr><td><li>상품토크등록시 운영자에게 발송되는 문구</td>
                    <td align='right'>
                        <input type='radio' name='smschk' value='n' checked><font color='red'>미발송</font>&nbsp;&nbsp;
                        <input type='radio' name='smschk' value='y' "; if ("y" == $smschk_talk) { echo " checked"; } echo " ><font color='red'>발송</font>&nbsp;
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td height='1' bgcolor='#cccccc' colspan='2'></td>
    </tr>
    <tr>
        <td align='left'>
            <table width='100%' cellpadding='0' cellspacing='0'>
                <tr>
                    <td>
                        ( <input type='text' name='smstext' value='".$smstext_talk."'  size='10' style='font-size:9pt; me-mode:active;' maxlength='10' > 등록된 상품토크 내용 )
                    </td>
                    <td align='right'>
                        <img src='/images/btn_input.gif' style='cursor:hand;' align='absmiddle' onClick=\"f_save(document.forms['PUBLIC_FORM6'])\">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td height='1' bgcolor='#000000' colspan='2'></td>
    </tr>
</table>
</form>";



// 상품토크 답변시 원본글 등록자에게 발송되는 문구 ////////////////////////////
echo "
<form name='PUBLIC_FORM7' method='post' action='od_smsset_tran.php' target='set'>
<input type='hidden' name='smskbn' value='talk_re'>
<input type='hidden' name='smsseq' value='".$smsseq_talk_re."'>
<table width='100%' border='0' cellspacing='0' cellpadding='3'>
    <tr>
        <td height='2' bgcolor='#000000' colspan='2'></td>
    </tr>
    <tr>
        <td align='left' style='height:24px; font-size:9pt; background-color:#F0F0F0;'>
            <table width='100%' cellpadding='0' cellspacing='0'>
                <tr><td><li>상품토크 답변시 원본글 등록자에게 발송되는 문구</td>
                    <td align='right'>
                        <input type='radio' name='smschk' value='n' checked><font color='red'>미발송</font>&nbsp;&nbsp;
                        <input type='radio' name='smschk' value='y' "; if ("y" == $smschk_talk_re) { echo " checked"; } echo " ><font color='red'>발송</font>&nbsp;
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td height='1' bgcolor='#cccccc' colspan='2'></td>
    </tr>
    <tr>
        <td align='left'>
            <table width='100%' cellpadding='0' cellspacing='0'>
                <tr>
                    <td>
                        ( <input type='text' name='smstext' value='".$smstext_talk_re."'  size='10' style='font-size:9pt; me-mode:active;' maxlength='14' > 등록된 상품토크 답변 내용 )
                    </td>
                    <td align='right'>
                        <img src='/images/btn_input.gif' style='cursor:hand;' align='absmiddle' onClick=\"f_save(document.forms['PUBLIC_FORM7'])\">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td height='1' bgcolor='#000000' colspan='2'></td>
    </tr>
</table>
</form>";

?>

                                            </td>
                                        </tr>
                                        <tr> 
                                            <td height="15" valign="top"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr> 
                                <td height="5" bgcolor="#FFFFFF"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td height="83">
            <!-- bottom start -->
<? include "$folderpath_manager_common/od_bottom.inc.php"; ?>
            <!-- bottom end -->
        </td>
    </tr>
</table>
</body>
</html>
<iframe name='set' src='about:blank' width=0 height=0 style='display:none'></iframe>