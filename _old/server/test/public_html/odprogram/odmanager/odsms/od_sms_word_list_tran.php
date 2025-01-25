<?
header("Content-Type: text/html; charset=utf-8");
#------------------------------------------------------------------------------
# 파 일 명: faq_form_tran.php
# 작업내용: 입시관련faq
# 인    수:
# 작성일자: 2010.01.03
# 작 성 자: 이후맥스
#------------------------------------------------------------------------------

// 환경파일 불러오기 //////////////////////////////////////////////////////////
include "../../odcommon/od_config.inc.php";
include "../odcommon/od_function.inc.php";   
include "../odcommon/od_adminAuthority.inc.php";

echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";

//-----------------------------------------------------------------------------
// 등록 / 수정
//-----------------------------------------------------------------------------
if ("save" == $status)
{
    $smstext = CM_getTrimNull($smstext);

    if ($smsseq)
    {
        // 수정 처리 //////////////////////////////////////////////////////////
        $Query  = " UPDATE m_sms_set SET smstext = '$smstext', smskbn = 'set' WHERE smsseq = '$smsseq'  ";
        $Result = mysql_query($Query);
    }
    else
    {
        // 신규등록 처리 //////////////////////////////////////////////////////
        $Query  = " SELECT MAX(smsseq) FROM m_sms_set   ";
        $Result = mysql_query($Query);
        $Record = mysql_fetch_array($Result);
        $smsseq = $Record[0] + 1;

        $Query  = " INSERT INTO m_sms_set  (  smsseq,  smskbn,  smstext  )   ".
                  "             VALUES     ('$smsseq','set',  '$smstext' )   ";
        $Result = mysql_query($Query);
    }

    //echo $Query;exit;
    echo "<meta http-equiv=\"refresh\" content=\"0; URL=od_sms_word_list.php?FORM_FILED=$FORM_FILED&FORM_NAME=$FORM_NAME\" />";
    exit;
}

//-----------------------------------------------------------------------------
// 삭제처리
//-----------------------------------------------------------------------------
if ("delete" == $status)
{
    $Query  = " DELETE FROM m_sms_set WHERE smsseq = '$smsseq'  ";
    $Result = mysql_query($Query);

    echo "<meta http-equiv=\"refresh\" content=\"0; URL=od_sms_word_list.php?FORM_FILED=$FORM_FILED&FORM_NAME=$FORM_NAME\" />";
    exit;
}

//-----------------------------------------------------------------------------
// 문구등록
//-----------------------------------------------------------------------------
if ("save2" == $status)
{
    if (" " == $smstext || "" == $smstext || "메시지 입력" == $smstext)
    {
        exit;
    }

    // 신규등록 처리 //////////////////////////////////////////////////////////
    $Query  = " SELECT MAX(smsseq) FROM m_sms_set   ";
    $Result = mysql_query($Query);
    $Record = mysql_fetch_array($Result);
    $smsseq = $Record[0] + 1;

    $Query  = " INSERT INTO m_sms_set  (  smsseq,  smskbn,  smstext  )   ".
              "             VALUES     ('$smsseq','set',  '$smstext' )   ";
    $Result = mysql_query($Query);

    echo "
    <script>
        alert('저장 되었습니다');
    </script>";
    exit;
}

function CM_getTrimNull($as_data) {
    $temp=trim($as_data);
    $temp=str_replace("undefined","",$temp);		
    $temp=str_replace("null","",$temp);
    return $temp;
}
?>