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

## 세부권한 체크
if($row_admin[basicLevel] < 3) {
    error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
}


$Query   = " SELECT * FROM m_sms_set WHERE smsseq = '$smsseq'    ";
$Result  = mysql_query($Query); 
$Record  = mysql_fetch_array($Result);
$smstext = $Record[smstext];

echo "
<script>
function chk_smstext(form){
    if(form.smstext.value == ''){
        form.smstext.value='';
        smstext_len_id.innerHTML='0';
        form.smstext.focus();
    }
}

function select_char(form,val){
    if(form.smstext.value == ''){
        form.smstext.value='';
        smstext_len_id.innerHTML='0';
    }

    var smstext_val = form.smstext.value;
    smstext_val = smstext_val + val;

    form.smstext.value = smstext_val;

    var len=str_length(form);

    if(len>80){
        alert('80바이트 이내로 쓰셔야 해요');
        return false;
    }
        
    smstext_len_id.innerHTML=len;

    form.smstext.focus();
}
function str_length(form) {
    if ( navigator.appCodeName != 'Mozilla' ) {
        return form.smstext.value.length;
    }
  
    var len = 0; 
  
    for (var i=0; i<form.smstext.value.length; i++) {
        if ( form.smstext.value.substr(i, 1) > '~' ) {
            len+=2;
        } 
        else {
            len++;
        }
    }
  
    return len;
}

function check_length(form){
    var len=str_length(form);

    if(len>80){
        alert('80바이트 이내로 쓰셔야 해요');
        return false;
    }
        
    smstext_len_id.innerHTML=len;
}
</script>
<link href='/css/managerstyle.css' rel='stylesheet' type='text/css'>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<table width='660' height='100%' border='0' cellpadding='10' cellspacing='1' bgcolor='D6D6D6'>
    <tr> 
        <td align='center' valign='top' bgcolor='#FFFFFF'>
            <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                <tr> 
                    <td height='17' bgcolor='FFFFFF' colspan='2'></td>
                </tr>
                <tr> 
                    <td><font color='313D7D'><img src='../odimages/odmain/title_icon.gif' width='13' height='13' hspace='1' align='absmiddle'> SMS문구 목록 - 목록을 클릭하면 해당 데이타가 sms문구상에 표시가 되고 <font color='red'>추가</font>를 클릭하시면 문구가 적용이 됩니다</td>
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
<script type='text/javascript' src='od_sms_word_list.js'></script>
<form name='PUBLIC_FORM' method='post' action='$PHP_SELF'>
<input type='hidden' name='status'      value='save'            />
<input type='hidden' name='FORM_FILED'  value='$FORM_FILED'     />
<input type='hidden' name='FORM_NAME'   value='$FORM_NAME'      />
<input type='hidden' name='smsseq'      value='$smsseq'         />
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
    <tr>
        <td height='10'></td>
    </tr>
    <tr>
        <td align='center'>";

            echo "
            <table width='100%' border='0' cellspacing='0' cellpadding='3'>
                <tr>
                    <td height='2' bgcolor='#000000' colspan='2'></td>
                </tr>
                <tr>
                    <td width='80' style='height:24px; text-align:center; font-size:9pt; background-color:#F0F0F0;'>SMS문구</td>
                    <td align='left'>&nbsp;
                        <textarea style='font-size:12px;width:500px;height:30px;padding:2px' name='smstext' onclick='chk_smstext(PUBLIC_FORM)' onkeyup='check_length(PUBLIC_FORM); return false;'>$smstext</textarea>
                        <a href='#none' onClick=\"opener.document.".$FORM_NAME.".".$FORM_FILED.".value=document.PUBLIC_FORM.smstext.value; self.close();\"><img src='/images/btn_plus.gif' width='30' height='30' border='0' align='absmiddle'/></a>
                    </td>
                </tr>
                <tr>
                    <td height='1' bgcolor='#000000' colspan='2'></td>
                </tr>
                <tr height='50'>
                    <td colspan='2' align='center'>
                        <font color='265BBC'><font id='smstext_len_id'>0</font> bytes / 80 bytes</font>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<img src='/images/btn_save.gif' width='77' height='24' onClick='f_save()' />
                        &nbsp;
						<img src='/images/btn_del.gif' width='77' height='24' onClick='f_delete()' />
                        &nbsp;
						<img src='/images/btn_reset.gif' width='77' height='24' onClick=\"location.href='od_sms_word_list.php'\" />
                        &nbsp;
						<img src='/images/btn_clo.gif' width='77' height='24' onClick='self.close()' />
                    </td>
                </tr>
            </table><br />";

            echo "
            <table width='100%' border='0' cellspacing='0' cellpadding='3'>
                <tr>
                    <td height='2' bgcolor='#000000' colspan='8'></td>
                </tr>
                <tr>
                    <td width='40' style='height:24px; text-align:center; font-size:9pt; background-color:#F0F0F0;'>번호</td>
                    <td            style='height:24px; text-align:center; font-size:9pt; background-color:#F0F0F0;'>sms문구</td>
                </tr>
                <tr>
                    <td height='1' bgcolor='#CCCCCC' colspan='8'></td>
                </tr>";


        //---------------------------------------------------------------------
        // 데이타 추출조건 작성
        //---------------------------------------------------------------------
        $sql_where = " WHERE smskbn = 'set' ";
        $sql_order = " ORDER BY smsseq      ";

        $Cnt = 1;

        $Query  = " SELECT * FROM m_sms_set ".$sql_where.$sql_order;
        $Result = mysql_query($Query); 
        while ($Record = mysql_fetch_array($Result))
        {
            $smsseq  = $Record[smsseq];
            $smstext = $Record[smstext];
    
            $smstext = CM_cutString($smstext, 60);

            echo "
            <tr height='20' onMouseOver=\"this.style.background='#F0FFFA';\" bgcolor='#FFFCF7' style='cursor:hand' onMouseOut=\"this.style.background='#FFFCF7';\" onClick=\"f_disp('$smsseq');\">
                <td align='center'>$Cnt</td>
                <td align='left'  > $smstext</td>
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
                        <table width='100%' border='0' cellspacing='0' cellpadding='0'>
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
</html>";



// =================================================================================================
// Function Name	: CM_cutString($as_data, $as_setLen=0)
// Description		: 문자를 지정한 길이보다 클 경우 '문자...'형식으로 바꾼다.(한글은 2자로 계산한다)
//					  
// $as_data			: 문자 데이터.
// $as_setLen		: 표시하고 싶은 길이.
// return			: {문자데이터}
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

