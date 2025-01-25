<?
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

//-----------------------------------------------------------------------------
// 등록 / 수정
//-----------------------------------------------------------------------------
if ("save" == $status)
{
    $m14_question = CM_getTrimNull($m14_question);
    $m14_answer   = CM_getTrimNull($m14_answer);

    if ($m14_no)
    {
        // 수정 처리 //////////////////////////////////////////////////////////
        $Query  = " UPDATE m_faq SET m14_question = '$m14_question', m14_answer = '$m14_answer' WHERE m14_no = '$m14_no'  ";
        $Result = mysql_query($Query);
    }
    else
    {
        // 신규등록 처리 //////////////////////////////////////////////////////
        $Query  = " SELECT MAX(m14_no) FROM m_faq   ";
        $Result = mysql_query($Query);
        $Record = mysql_fetch_array($Result);
        $m14_no = $Record[0] + 1;

        $m14_date = date('Y-m-d');
        $Query  = " INSERT INTO m_faq  (  m14_no,   m14_question,   m14_answer,   m14_date  )   ".
                  "             VALUES ('$m14_no','$m14_question','$m14_answer','$m14_date' )   ";
        $Result = mysql_query($Query);
    }

    echo "<meta http-equiv=\"refresh\" content=\"0; URL=od_faq_list.php\" />";
    exit;
}

//-----------------------------------------------------------------------------
// 삭제처리
//-----------------------------------------------------------------------------
if ("delete" == $status)
{
    $Query  = " DELETE FROM m_faq WHERE m14_no = '$m14_no'  ";
    $Result = mysql_query($Query);

    echo "<meta http-equiv=\"refresh\" content=\"0; URL=od_faq_list.php\" />";
    exit;
}

function CM_getTrimNull($as_data) {
    $temp=trim($as_data);
    $temp=str_replace("undefined","",$temp);		
    $temp=str_replace("null","",$temp);
    return $temp;
}
?>