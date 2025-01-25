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
    if ("" == document.PUBLIC_FORM.m14_question.value)
    {
        alert("질문을 입력해 주십시오");
        document.PUBLIC_FORM.m14_question.focus();
    }
    else if ("" == document.PUBLIC_FORM.m14_answer.value)
    {
        alert("답변을 입력해 주십시오");
        document.PUBLIC_FORM.m14_answer.focus();
    }
    else
    {
        PUBLIC_FORM.action = "od_faq_list_tran.php";
        PUBLIC_FORM.submit();
    }
}

//-----------------------------------------------------------------------------
// 수정
//-----------------------------------------------------------------------------
function f_disp(no)
{
    document.PUBLIC_FORM.m14_no.value = no;
    PUBLIC_FORM.action = "od_faq_list.php";
    PUBLIC_FORM.submit();
}

//-----------------------------------------------------------------------------
// 삭제
//-----------------------------------------------------------------------------
function f_delete()
{
    if (document.PUBLIC_FORM.m14_no.value)
    {
        chkDel = confirm('해당 데이타를 하시겠습니까?');
        if(true == chkDel) 
        {
            document.PUBLIC_FORM.status.value = "delete";
            PUBLIC_FORM.action = "od_faq_list_tran.php";
            PUBLIC_FORM.submit();
        }
    }
}