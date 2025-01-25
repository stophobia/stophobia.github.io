<?
#------------------------------------------------------------------------------
# 파 일 명: od_faq_list.php
# 작업내용: faq
# 인    수:
# 작성일자: 2011.01.19
#------------------------------------------------------------------------------
include "../../odcommon/od_config.inc.php";
include "../odcommon/od_function.inc.php";   
include "../odcommon/od_adminAuthority.inc.php";
include "../odcommon/od_head.inc.php";
include "../odcommon/od_body.inc.php";

/*
CREATE TABLE `m_faq` (
  `m14_no` bigint(10) NOT NULL AUTO_INCREMENT,
  `m14_question` text,
  `m14_answer` text,
  `m14_date` date DEFAULT NULL,
  PRIMARY KEY (`m14_no`)
);
*/

## 세부권한 체크
if($row_admin[basicLevel] < 3) {
    error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
}


$Query  = " SELECT * FROM m_faq WHERE m14_no = '$m14_no'    ";
$Result = mysql_query($Query); 
$Record = mysql_fetch_array($Result);
$m14_question = $Record[m14_question];
$m14_answer   = $Record[m14_answer];

echo "
<table width='100%' height='100%' border='0' cellpadding='0' cellspacing='0'>
    <tr> 
        <td height='80' bgcolor='#FFFFFF'>";

include "../odcommon/od_topMenu.inc.php";

        echo "
        </td>
    </tr>
    <tr> 
        <td valign='top'> 
            <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                <tr>
                    <td height='6'></td>
                </tr>
            </table>
            <table height='100%' border='0' cellpadding='0' cellspacing='0'>
                <tr>
                    <td width='10'>&nbsp;</td>
                    <td width='165' height='100%' valign='top'>";

include "../odcommon/od_leftMenu.inc.php";

                    echo "
                    </td>
                    <td width='3'>&nbsp;</td>
                    <td width='782' valign='top'>
                        <table width='782' height='100%' border='0' cellpadding='10' cellspacing='1' bgcolor='D6D6D6'>
                            <tr> 
                                <td align='center' valign='top' bgcolor='#FFFFFF'>
                                    <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                        <tr> 
                                            <td height='17' bgcolor='FFFFFF' colspan='2'></td>
                                        </tr>
                                        <tr> 
                                            <td><font color='313D7D'><img src='../odimages/odmain/title_icon.gif' width='13' height='13' hspace='1' align='absmiddle'> 일반관리 &gt; <span class='st'> FAQ설정 (자주묻는질문)</span></font></td>
                                            <td align='right'></td>
                                        </tr>
                                        <tr> 
                                            <td height='3' bgcolor='FFFFFF' colspan='2'></td>
                                        </tr>
                                        <tr> 
                                            <td height='2' bgcolor='D6D6D6' colspan='2'></td>
                                        </tr>
                                    </table>";



// 본문시작 ///////////////////////////////////////////////////////////////////////////////////////
echo "
<script type='text/javascript' src='od_faq_list.js'></script>
<form name='PUBLIC_FORM' method='post' action='$PHP_SELF'>
<input type='hidden' name='status'      value='save'        />
<input type='hidden' name='m14_no'      value='$m14_no'     />
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
    <tr>
        <td height='10'></td>
    </tr>
    <tr>
        <td align='center'>";

            echo "
            <table width='775' border='0' cellspacing='0' cellpadding='3'>
                <tr>
                    <td height='2' bgcolor='#000000' colspan='2'></td>
                </tr>
                <tr>
                    <td width='80' style='height:24px; text-align:center; font-size:9pt; background-color:#F0F0F0;'>질문</td>
                    <td align='left'>&nbsp;
                        <textarea style='font-size:12px;width:640px;height:50px;padding:2px' name='m14_question'>$m14_question</textarea>
                    </td>
                </tr>
                <tr>
                    <td height='1' bgcolor='#cccccc' colspan='2'></td>
                </tr>
                <tr>
                    <td  style='height:24px; text-align:center; font-size:9pt; background-color:#F0F0F0;'>답변</td>
                    <td align='left'>&nbsp;
                        <textarea style='font-size:12px;width:640px;height:60px;padding:2px' name='m14_answer'>$m14_answer</textarea>
                    </td>
                </tr>
                <tr>
                    <td height='1' bgcolor='#000000' colspan='2'></td>
                </tr>
                <tr height='50'>
                    <td colspan='2' align='center'>
                        <img src='/images/btn_save.gif' width='77' height='24'  onClick=\"f_save()\"        style='cursor:hand;' />
                        <img src='/images/btn_del.gif' width='77' height='24'   onClick=\"f_delete()\"      style='cursor:hand;' />
                        <img src='/images/btn_reset.gif' width='77' height='24' onClick=\"location.href='od_faq_list.php'\" style='cursor:hand;'  />
                    </td>
                </tr>
            </table><br />";

            echo "
            <table width='775' border='0' cellspacing='0' cellpadding='3'>
                <tr>
                    <td height='2' bgcolor='#000000' colspan='8'></td>
                </tr>
                <tr>
                    <td width='40' style='height:24px; text-align:center; font-size:9pt; background-color:#F0F0F0;'>번호</td>
                    <td            style='height:24px; text-align:center; font-size:9pt; background-color:#F0F0F0;'>질문</td>
                    <td width='70' style='height:24px; text-align:center; font-size:9pt; background-color:#F0F0F0;'>등록일</td>
                </tr>
                <tr>
                    <td height='1' bgcolor='#CCCCCC' colspan='8'></td>
                </tr>";


        //---------------------------------------------------------------------
        // 데이타 추출조건 작성
        //---------------------------------------------------------------------
        $sql_where = " WHERE m14_no is not null    ";
        $sql_order = " ORDER BY m14_no       ";

        $Cnt = 1;

        $Query  = " SELECT * FROM m_faq ".$sql_where.$sql_order;
        $Result = mysql_query($Query); 
        while ($Record = mysql_fetch_array($Result))
        {
            $m14_no       = $Record[m14_no];
            $m14_question = $Record[m14_question];
            $m14_date     = $Record[m14_date];
    
            $m14_question = CM_cutString($m14_question, 60);

            echo "
            <tr height='20' onMouseOver=\"this.style.background='#F0FFFA';\" bgcolor='#FFFCF7' style='cursor:hand' onMouseOut=\"this.style.background='#FFFCF7';\" onClick=\"f_disp('$m14_no');\">
                <td align='center'>$Cnt</td>
                <td align='left'  > $m14_question</td>
                <td align='center'>$m14_date</td>
            </tr>
            <tr>
                <td colspan=8  height=1 bgcolor='#cccccc'></td>
            </tr>";

            $Cnt++;
        }
            
            echo "
            </table>
        </td>
    </tr>
</table>
</form>";

///////////////////////////////////////////////////////////////////////////////////////////////////

                                    echo "
                                    <table width='760' border='0' cellspacing='0' cellpadding='0'>
                                        <tr> 
                                            <td height='30'>&nbsp;</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr> 
                                <td height='5' bgcolor='#FFFFFF'></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td height='83'>";

include "../odcommon/od_bottom.inc.php";

        echo "
        </td>
    </tr>
</table>
</body>
</html>";



// =================================================================================================
// Function Name    : CM_cutString($as_data, $as_setLen=0)
// Description      : 문자를 지정한 길이보다 클 경우 '문자...'형식으로 바꾼다.(한글은 2자로 계산한다)
//                    
// $as_data         : 문자 데이터.
// $as_setLen       : 표시하고 싶은 길이.
// return           : {문자데이터}
// =================================================================================================
function CM_cutString($as_data, $as_setLen=0) {
    if($as_setLen<=0) return $as_data;

    $han = 0;
    $eng = 0;
    $point = 1;
    $strLength = strlen($as_data);
    $engString = "";

    for($t=0;$t<$as_setLen;$t++) if(ord($as_data[$t])>127) $han++; else $eng++;
    $as_setLen=$as_setLen+(int)$han*0.6;        
    for($i=0; $i<$strLength; $i++) {
        if($point > $as_setLen) return $endString."...";
        if(ord($as_data[$i])<=127) {
            $endString.= $as_data[$i];
            if ($point % $as_setLen==0) return $endString."..."; 
        } else {
            if($point % $as_setLen==0) return $endString."...";
            $endString .= $as_data[$i].$as_data[++$i];
            $point++;
        }
        $point++;
    }
    return $endString;
}

?>

