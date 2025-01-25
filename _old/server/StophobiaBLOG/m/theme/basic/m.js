// 댓글 남길 때 항목 점검
function leaveCommentOk(t)
{
	if(!t.elements['content'].value)
	{
		alert('댓글을 입력해 주세요!');
		t.elements['message'].focus();
		return false;
	}

	if(!t.elements['name'].value)
	{
		alert('이름을 입력해 주세요!');
		t.elements['name'].focus();
		return false;
	}

	return true;
}

// 검색 실행시 항목 점검
function searchOk(t)
{
	if(!t.elements['st'].value)
	{
		alert('검색어를 입력해 주세요!');
		t.elements['st'].focus();
		return false;
	}

	return true;
}