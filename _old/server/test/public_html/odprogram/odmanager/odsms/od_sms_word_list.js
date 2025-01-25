/******************************************************************************
* 파 일 명: faq_list.js
* 작업내용: faq
* 인    수: 
 ******************************************************************************/


//-----------------------------------------------------------------------------
// 저장
//-----------------------------------------------------------------------------
function f_save()
{
    if ("" == document.PUBLIC_FORM.smstext.value)
    {
        alert("SMS문구를 입력해 주십시오");
        document.PUBLIC_FORM.smstext.focus();
    }
    else
    {
        PUBLIC_FORM.action = "od_sms_word_list_tran.php";
        PUBLIC_FORM.submit();
    }
}

//-----------------------------------------------------------------------------
// 수정
//-----------------------------------------------------------------------------
function f_disp(no)
{
    document.PUBLIC_FORM.smsseq.value = no;
    PUBLIC_FORM.action = "od_sms_word_list.php";
    PUBLIC_FORM.submit();
}

//-----------------------------------------------------------------------------
// 삭제
//-----------------------------------------------------------------------------
function f_delete()
{
    if (document.PUBLIC_FORM.smsseq.value)
    {
        chkDel = confirm('해당 데이타를 하시겠습니까?');
        if(true == chkDel) 
        {
            document.PUBLIC_FORM.status.value = "delete";
            PUBLIC_FORM.action = "od_sms_word_list_tran.php";
            PUBLIC_FORM.submit();
        }
    }
}