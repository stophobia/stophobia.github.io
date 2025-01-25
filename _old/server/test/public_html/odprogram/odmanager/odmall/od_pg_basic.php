<?
    include "../../odcommon/od_config.inc.php";
    include "../odcommon/od_function.inc.php";   
    include "../odcommon/od_adminAuthority.inc.php";
    include "../odcommon/od_head.inc.php";
    include "../odcommon/od_body.inc.php";

/*
ALTER TABLE odtSetup ADD P_KBN  CHAR(1) DEFAULT 'A';         // A : 올더게이트, M : 인포뱅크, I : 이니시스, K : kcp, S : 올앳(삼성)
ALTER TABLE odtSetup ADD P_ID   CHAR(100)    default '';     // 아이디
ALTER TABLE odtSetup ADD P_SID  CHAR(100)    default '';     // 에스크로 아이디
ALTER TABLE odtSetup ADD P_KEY  VARCHAR(200) default '';     // KEY (인포뱅크만 이용)
ALTER TABLE odtSetup ADD P_PW   VARCHAR(100) default '';     // 비밀번호 (인포뱅크만 이용)
ALTER TABLE odtSetup ADD P_SKBN CHAR(1)      default '0';    // 에스크로관련

alter table odtOrder change apprTm apprTm varchar(30);
alter table odtOrder change dealNo dealNo varchar(30);
alter table odtOrder change subTy  subTy varchar(30);
*/

    ## 세부권한 체크
    if($row_admin[basicLevel] < 3) {
        error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
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
        $P_KBN  = $row[P_KBN];
        $P_ID   = $row[P_ID];
        $P_KEY  = $row[P_KEY];
        $P_PW   = $row[P_PW];
        $P_SKBN = $row[P_SKBN];
        $P_SID  = $row[P_SID];

        switch ($P_KBN)
        {
            case "A" : $A_ID = $P_ID;   break;
            case "I" : $I_ID = $P_ID; $I_SKBN = $P_SKBN; $I_SID = $P_SID;   break;
            case "M" : $M_ID = $P_ID; $M_KEY  = $P_KEY; $M_PW = $P_PW; $M_SKBN = $P_SKBN;  break;
            case "K" : $K_ID = $P_ID; $K_KEY  = $P_KEY; $K_SKBN = $P_SKBN;  break;
            case "S" : $S_ID = $P_ID; $S_KEY  = $P_KEY; $S_SKBN = $P_SKBN; $S_SID = $P_SID; break;
        }

?>

        <script>
            function valueCheck(form)
            {
                var form = document.snsForm;
                if (true == form.P_KBN[0].checked)
                {
                    if ("" == form.A_ID.value)
                    {
                        alert('올더게이트 아이디를 입력해 주십시오');
                        form.A_ID.focus();
                        return false;
                    }
                }
                else if (true == form.P_KBN[1].checked)
                {
                    if ("" == form.I_ID.value)
                    {
                        alert('이니시스 아이디를 입력해 주십시오');
                        form.I_ID.focus();
                        return false;
                    }
                }
                else if (true == form.P_KBN[2].checked)
                {
                    if ("" == form.M_ID.value)
                    {
                        alert('인포뱅크 아이디를 입력해 주십시오');
                        form.M_ID.focus();
                        return false;
                    }
                    else if ("" == form.M_KEY.value)
                    {
                        alert('인포뱅크 상점서명키를 입력해 주십시오');
                        form.M_KEY.focus();
                        return false;
                    }
                }
                else if (true == form.P_KBN[3].checked)
                {
                    if ("" == form.K_ID.value)
                    {
                        alert('인포뱅크 아이디를 입력해 주십시오');
                        form.K_ID.focus();
                        return false;
                    }
                    else if ("" == form.K_KEY.value)
                    {
                        alert('인포뱅크 상점서명키를 입력해 주십시오');
                        form.K_KEY.focus();
                        return false;
                    }
                }
                else if (true == form.P_KBN[4].checked)
                {
                    if ("" == form.S_ID.value)
                    {
                        alert('올앳 아이디를 입력해 주십시오');
                        form.S_ID.focus();
                        return false;
                    }
                    else if ("" == form.S_KEY.value)
                    {
                        alert('올앳 상점서명키를 입력해 주십시오');
                        form.S_KEY.focus();
                        return false;
                    }
                }
            }

            function f_view(kbn)
            {
                document.all.A_disp.style.display = "none";
                document.all.M_disp.style.display = "none";
                document.all.I_disp.style.display = "none";
                document.all.K_disp.style.display = "none";
                document.all.S_disp.style.display = "none";

                eval("document.all."+kbn+"_disp.style.display = ''");  
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
                                                    <td><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 상점 기본관리 &gt; <span class="st"> PG사 설정</span></font></td>
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
                                                    <td height="18" valign="bottom"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5"><b>결제 PG사 기본정보를 설정합니다. (모든결제는 카드, 실시간계좌이체만 지원합니다)</font></td>
                                                    <td height="18" align="right" class="pro">
                                                    </td>
                                                </tr>
                                            </table>
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr> 
                                                    <td height="5"></td>
                                                </tr>
                                            </table>
                                            <table width="760" border="0" cellspacing="0" cellpadding="0">
                                                <!-- form start -------------------------------->
                                                <form name="snsForm" method="post" action="od_pg_basic.php"  onSubmit="return valueCheck(this)">
                                                <input type="hidden" name="form" value="modifyForm">
                                                <tr> 
                                                    <td width="760" valign="top">
                                                        <table border="0" cellspacing="0" cellpadding="0">
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td width="143" bgcolor="ececec" class="white" style="padding:5px;">
                                                                  <img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">PG사 선택</td>
                                                                <td width="595" bgcolor="FAFAFA" style="padding:5px;font-size:12;LETTER-SPACING:-0.03em;"> 
                                                                    <input type='radio' name='P_KBN' value='A' <? if ("A" == $P_KBN) { echo " checked"; } ?> onClick="f_view('A');">올더게이트 &nbsp;
                                                                    <input type='radio' name='P_KBN' value='I' <? if ("I" == $P_KBN) { echo " checked"; } ?> onClick="f_view('I');">이니시스 &nbsp;
                                                                    <input type='radio' name='P_KBN' value='M' <? if ("M" == $P_KBN) { echo " checked"; } ?> onClick="f_view('M');">인포뱅크 &nbsp;
                                                                    <input type='radio' name='P_KBN' value='K' <? if ("K" == $P_KBN) { echo " checked"; } ?> onClick="f_view('K');">KCP &nbsp;
                                                                    <input type='radio' name='P_KBN' value='S' <? if ("S" == $P_KBN) { echo " checked"; } ?> onClick="f_view('S');">올앳
                                                                </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="D2D2D2"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="6" bgcolor="FFFFFF" colspan="2"></td>
                                                            </tr>
                                                        </table>

                                                        <div id='A_disp' style='display:<? if ("A" == $P_KBN) { echo ""; } else { echo "none"; } ?>'>
                                                        <table border="0" cellspacing="0" cellpadding="0">
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td width="143" bgcolor="ececec" class="white" style="padding:5px;">
                                                                  <img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">올더게이트 아이디</td>
                                                                <td width="595" bgcolor="FAFAFA" style="padding:5px;font-size:14;LETTER-SPACING:-0.03em;"> 
                                                                    <input type="text" name="A_ID" class="border" size="25" value="<?=$A_ID?>">
                                                                </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                        </table>
                                                        <table><tr><td height='10'></td></tr></table>
                                                        <table width="760" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td>
                                                                    ※ 올더게이트 테스트 아이디는 <font color='red'>aegis</font> 입니다 (테스트 결제시에는 카드만 가능합니다)<br />
                                                                    ※ 올더게이트에서 승인절차가 끝나시면 필히 상위에 고객님의 올더게이트 아이디를 등록하셔야만 정상 결제가 이루어 집니다<br />
                                                                    ※ 올더게이트는 에스크로관련하여 별도 셋팅이 필요치 않습니다 (올더게이트측에 에스크로 신청만 하시면 됩니다)<br />
                                                                    ※ 결제취소시에는 카드결제같은 경우에는 사이트에서 취소처리 하시면 pg사와 연동하여 카드사까지 한번에 취소처리가 됩니다<br />
                                                                    <font color='blue'>※ 실시간계좌이체같은 경우에는 사이트에서 취소처리후 pg사 관리자모드에서 또한번 취소처리를 하셔야 합니다</font><br />
                                                                    <font color='blue'>※ 결제취소시 사이트에서 먼저 하시고 pg사에서 하셔야 합니다 반대로 하실경우 오류가 발생합니다</font><br />
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        </div>


                                                        <div id='I_disp' style='display:<? if ("I" == $P_KBN) { echo ""; } else { echo "none"; } ?>'>
                                                        <table border="0" cellspacing="0" cellpadding="0">
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td width="143" bgcolor="ececec" class="white" style="padding:5px;">
                                                                  <img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">이니시스 아이디</td>
                                                                <td width="595" bgcolor="FAFAFA" style="padding:5px;font-size:14;LETTER-SPACING:-0.03em;"> 
                                                                    <input type="text" name="I_ID" class="border" size="25" value="<?=$I_ID?>">
                                                                </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="6" bgcolor="FFFFFF" colspan="2"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td bgcolor="ececec" class="white" style="padding:5px;">
                                                                  <img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">에스크로 아이디</td>
                                                                <td bgcolor="FAFAFA" style="padding:5px;font-size:14;LETTER-SPACING:-0.03em;"> 
                                                                    <input type="text" name="I_SID" class="border" size="25" value="<?=$I_SID?>">
                                                                </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                        </table>
                                                        <table><tr><td height='10'></td></tr></table>
                                                        <table width="760" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td>
                                                                    ※ 이니시스 테스트 아이디는 <font color='red'>INIpayTest</font> 입니다 (테스트 결제시에는 카드만 가능합니다)<br />
                                                                    ※ 이니시스 승인절차가 끝나시면 필히 상위에 고객님의 key 아이디를 등록하셔야만 정상 결제가 이루어 집니다<br />
                                                                       &nbsp;&nbsp;&nbsp;&nbsp;<font color='red'>이니시스에서 받으신 키파일을 압축을 푸시면 디렉토리가 생성됩니다 사이트에 ftp로 접속하셔서<br />
                                                                       &nbsp;&nbsp;&nbsp;&nbsp;/INIpayG/key 경로에 디렉토리까지 포함한 파일전체를 올려주십시오</font><br />
                                                                       &nbsp;&nbsp;&nbsp;&nbsp;(key 파일 디렉토리가 없으면 아이디를 등록하셔도 정상결제가 되지 않습니다)<br />
                                                                    <font color='blue'>※ 에스크로 이용시 에스크로 아이디를 등록하시고 위와 같은 방법으로 /public_html/INIescrow41/key 에 키파일을 올려주십시오</font><br />
                                                                    ※ 결제취소시에는 카드결제같은 경우에는 사이트에서 취소처리 하시면 pg사와 연동하여 카드사까지 한번에 취소처리가 됩니다<br />
                                                                    <font color='blue'>※ 실시간계좌이체같은 경우에는 사이트에서 취소처리후 pg사 관리자모드에서 또한번 취소처리를 하셔야 합니다</font><br />
                                                                    <font color='blue'>※ 결제취소시 사이트에서 먼저 하시고 pg사에서 하셔야 합니다 반대로 하실경우 오류가 발생합니다</font><br /><br><p align="center">이니시스 키파일 업로드방법</p><br>
                                                                    <img src="../../../../img/introkey.png">
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        </div>

                                                        <div id='M_disp' style='display:<? if ("M" == $P_KBN) { echo ""; } else { echo "none"; } ?>'>
                                                        <table border="0" cellspacing="0" cellpadding="0">
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td width="143" bgcolor="ececec" class="white" style="padding:5px;">
                                                                  <img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">인포뱅크 아이디</td>
                                                                <td width="595" bgcolor="FAFAFA" style="padding:5px;font-size:14;LETTER-SPACING:-0.03em;"> 
                                                                    <input type="text" name="M_ID" class="border" size="25" value="<?=$M_ID?>">
                                                                </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="6" bgcolor="FFFFFF" colspan="2"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td bgcolor="ececec" class="white" style="padding:5px;">
                                                                  <img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">인포뱅크 상점서명키</td>
                                                                <td bgcolor="FAFAFA" style="padding:5px;font-size:14;LETTER-SPACING:-0.03em;"> 
                                                                    <input type="text" name="M_KEY" class="border" size="80" value="<?=$M_KEY?>">
                                                                </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="6" bgcolor="FFFFFF" colspan="2"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="6" bgcolor="FFFFFF" colspan="2"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td bgcolor="ececec" class="white" style="padding:5px;">
                                                                  <img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">에스크로 사용여부</td>
                                                                <td bgcolor="FAFAFA" style="padding:5px;font-size:14;LETTER-SPACING:-0.03em;"> 
                                                                    <input type="radio" name="M_SKBN" value="0" checked style='border:0;'><font style='font-size:12;'> 미사용</font> &nbsp;&nbsp;
                                                                    <input type="radio" name="M_SKBN" value="1" <? if ("1" == $M_SKBN) { echo " checked";  } ?> style='border:0;'><font style='font-size:12;'> 사용</font>
                                                                </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td bgcolor="ececec" class="white" style="padding:5px;">
                                                                  <img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">인포뱅크 비밀번호</td>
                                                                <td bgcolor="FAFAFA" style="padding:5px;font-size:14;LETTER-SPACING:-0.03em;"> 
                                                                    <input type="text" name="M_PW" class="border" size="25" value="<?=$M_PW?>">
                                                                </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                        </table>
                                                        <table><tr><td height='10'></td></tr></table>
                                                        <table width="760" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td>
                                                                    ※ 인포뱅크 테스트 아이디는 <font color='red'>mnbank002m</font> 입니다 (테스트 결제시에는 카드만 가능합니다)<br />
                                                                    ※ 테스트 상점서명키 <font color='red'>zutht7y2mL0DQWk7mkY2Jt+2B7hxqRBtnQ0tK0nl3ZhfztnX5sXSyApEatooQODfz5wNa7DTxzogjWqbxLfa6Q==</font><br />
                                                                    ※ 인포뱅크 승인절차가 끝나시면 필히 상위에 고객님의 아이디와 상점서명키를 등록하셔야만 정상 결제가 이루어 집니다<br />
                                                                    ※ 인포뱅크 비밀번호는 취소시에 암호체크 부분입니다 (인포뱅크 관리자모드에서 설정하신 비밀번호가 있을때만 등록하십시오)<br />
                                                                    ※ 결제취소시에는 카드결제같은 경우에는 사이트에서 취소처리 하시면 pg사와 연동하여 카드사까지 한번에 취소처리가 됩니다</font><br />
                                                                    <font color='blue'>※ 실시간계좌이체같은 경우에는 사이트에서 취소처리후 pg사 관리자모드에서 또한번 취소처리를 하셔야 합니다</font><br />
                                                                    <font color='blue'>※ 결제취소시 사이트에서 먼저 하시고 pg사에서 하셔야 합니다 반대로 하실경우 오류가 발생합니다</font><br />
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        </div>

                                                        <div id='K_disp' style='display:<? if ("K" == $P_KBN) { echo ""; } else { echo "none"; } ?>'>
                                                        <table border="0" cellspacing="0" cellpadding="0">
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td width="143" bgcolor="ececec" class="white" style="padding:5px;">
                                                                  <img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">사이트코드</td>
                                                                <td width="595" bgcolor="FAFAFA" style="padding:5px;font-size:14;LETTER-SPACING:-0.03em;"> 
                                                                    <input type="text" name="K_ID" class="border" size="25" value="<?=$K_ID?>">
                                                                </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="6" bgcolor="FFFFFF" colspan="2"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td bgcolor="ececec" class="white" style="padding:5px;">
                                                                  <img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">사이트키</td>
                                                                <td bgcolor="FAFAFA" style="padding:5px;font-size:14;LETTER-SPACING:-0.03em;"> 
                                                                    <input type="text" name="K_KEY" class="border" size="80" value="<?=$K_KEY?>" >
                                                                </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="6" bgcolor="FFFFFF" colspan="2"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="6" bgcolor="FFFFFF" colspan="2"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td bgcolor="ececec" class="white" style="padding:5px;">
                                                                  <img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">에스크로 사용여부</td>
                                                                <td bgcolor="FAFAFA" style="padding:5px;font-size:14;LETTER-SPACING:-0.03em;"> 
                                                                    <input type="radio" name="K_SKBN" value="0" checked style='border:0;'><font style='font-size:12;'> 미사용</font> &nbsp;&nbsp;
                                                                    <input type="radio" name="K_SKBN" value="1" <? if ("1" == $K_SKBN) { echo " checked";  } ?> style='border:0;'><font style='font-size:12;'> 사용</font>
                                                                </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                        </table>
                                                        <table><tr><td height='10'></td></tr></table>
                                                        <table width="760" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td>
                                                                    ※ KCP 테스트 사이트코드 <font color='red'>T0000</font>, 테스트 사이트키 <font color='red'>3grptw1.zW0GSo4PQdaGvsF__</font> 입니다<br />
                                                                    ※ KCP 승인절차가 끝나시면 필히 상위에 발급한 사이트코드와 사이트키를 등록하셔야만 정상 결제가 이루어 집니다<br />
                                                                    ※ 결제취소시에는 카드결제같은 경우에는 사이트에서 취소처리 하시면 pg사와 연동하여 카드사까지 한번에 취소처리가 됩니다</font><br />
                                                                    <font color='blue'>※ 실시간계좌이체같은 경우에는 사이트에서 취소처리후 pg사 관리자모드에서 또한번 취소처리를 하셔야 합니다</font><br />
                                                                    <font color='blue'>※ 결제취소시 사이트에서 먼저 하시고 pg사에서 하셔야 합니다 반대로 하실경우 오류가 발생합니다</font><br />
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        </div>


                                                        <div id='S_disp' style='display:<? if ("S" == $P_KBN) { echo ""; } else { echo "none"; } ?>'>
                                                        <table border="0" cellspacing="0" cellpadding="0">
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td width="143" bgcolor="ececec" class="white" style="padding:5px;">
                                                                  <img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">상점ID</td>
                                                                <td width="595" bgcolor="FAFAFA" style="padding:5px;font-size:14;LETTER-SPACING:-0.03em;"> 
                                                                    <input type="text" name="S_ID" class="border" size="25" value="<?=$S_ID?>">
                                                                </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="6" bgcolor="FFFFFF" colspan="2"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td bgcolor="ececec" class="white" style="padding:5px;">
                                                                  <img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">Cross Key</td>
                                                                <td bgcolor="FAFAFA" style="padding:5px;font-size:14;LETTER-SPACING:-0.03em;"> 
                                                                    <input type="text" name="S_KEY" class="border" size="80" value="<?=$S_KEY?>" >
                                                                </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="6" bgcolor="FFFFFF" colspan="2"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="6" bgcolor="FFFFFF" colspan="2"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td bgcolor="ececec" class="white" style="padding:5px;">
                                                                  <img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">에스크로 사용여부</td>
                                                                <td bgcolor="FAFAFA" style="padding:5px;font-size:14;LETTER-SPACING:-0.03em;"> 
                                                                    <input type="radio" name="S_SKBN" value="0" checked style='border:0;'><font style='font-size:12;'> 미사용</font> &nbsp;&nbsp;
                                                                    <input type="radio" name="S_SKBN" value="1" <? if ("1" == $S_SKBN) { echo " checked";  } ?> style='border:0;'><font style='font-size:12;'> 사용</font>
                                                                </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="6" bgcolor="FFFFFF" colspan="2"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="6" bgcolor="FFFFFF" colspan="2"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                            <tr> 
                                                                <td bgcolor="ececec" class="white" style="padding:5px;">
                                                                  <img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">테스트 여부</td>
                                                                <td bgcolor="FAFAFA" style="padding:5px;font-size:14;LETTER-SPACING:-0.03em;"> 
                                                                    <input type="radio" name="S_SID" value="0" checked style='border:0;'><font style='font-size:12;'> 미사용</font> &nbsp;&nbsp;
                                                                    <input type="radio" name="S_SID" value="1" <? if ("1" == $S_SID) { echo " checked";  } ?> style='border:0;'><font style='font-size:12;'> 사용</font>
                                                                </td>
                                                            </tr>
                                                            <tr> 
                                                                <td height="1" bgcolor="c0bebe"></td>
                                                                <td height="1" bgcolor="#D5D5D5"></td>
                                                            </tr>
                                                        </table>
                                                        <table><tr><td height='10'></td></tr></table>
                                                        <table width="760" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td>
                                                                    ※ 올앳 테스트는 부여받으신 상점ID 와 크로스키를 등록후에 테스트여부를 사용으로 하시면 됩니다<br />
                                                                    <font color='blue'>※ 결제취소시 사이트에서 먼저 하시고 pg사에서 하셔야 합니다 반대로 하실경우 오류가 발생합니다</font><br />
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        </div>


                                                    </td>
                                                </tr>
                                            </table>
                                            <table><tr><td height='10'></td></tr></table>
                                            <table width="760" border="0" cellspacing="1" cellpadding="0">
                                                <tr> 
                                                    <td align="center">
                                                        <?=$modifyTemp1?>
                                                        <a onclick="reset();" onfocus='this.blur();' style='cursor:hand;'>
                                                        <img src="../odimages/odmain/btn_cancel.gif" width="77" height="24" hspace="3" border="0"></a>
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
    $P_ID   = "";
    $P_KEY  = "";
    $P_PW   = "";
    $P_SKBN = "0";
    $P_SID  = "";

    if ("A" == $P_KBN)
    {
        $P_ID = trim($A_ID);
    }
    else if ("I" == $P_KBN)
    {
        $P_ID   = trim($I_ID);
        $P_SID  = trim($I_SID);
        if ($P_SID) { $P_SKBN = "1"; } else { $P_SKBN = "0";    }
    }
    else if ("M" == $P_KBN)
    {
        $P_ID   = trim($M_ID);
        $P_KEY  = trim($M_KEY);
        $P_PW   = trim($M_PW);
        $P_SKBN = $M_SKBN;
    }
    else if ("K" == $P_KBN)
    {
        $P_ID   = trim($K_ID);
        $P_KEY  = trim($K_KEY);
        $P_SKBN = $K_SKBN;
    }
    else if ("S" == $P_KBN)
    {
        $P_ID   = trim($S_ID);
        $P_KEY  = trim($S_KEY);
        $P_SKBN = $S_SKBN;
        $P_SID  = $S_SID;
    }


    $que = " update odtSetup set P_KBN = '$P_KBN', P_ID = '$P_ID', P_KEY = '$P_KEY', P_PW = '$P_PW', P_SKBN = '$P_SKBN', P_SID = '$P_SID' where serialnum = 1";
    $result = mysql_query($que);
    
    if($result) {
        echo "
            <script>
                window.alert('저장 되었습니다.');
            </script>";

        echo "<meta http-equiv='Refresh' content='0; URL=od_pg_basic.php'>";
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