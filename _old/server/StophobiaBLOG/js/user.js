// 포스트삭제
function delUser(uid)
{
	if(confirm('정말로 이 멤버를 삭제하시겠습니까?')) {
		location.href='admin.php?admin=15&deleteTarget='+uid;
	}
}
// 검색어 입력 검사
function user()
{
	t = document.forms['members'];
	if(!t.elements['searchText'].value) {
		alert('검색어를 입력해 주세요');
		t.elements['searchText'].focus();
		return false;
	}
	return true;
}
// 전체선택버튼
function selectAll()
{
	var j;
	for(j=0; j<document.forms["list"].length; j++)
	{
		if(document.forms["list"][j].type=='checkbox')
		{
			document.forms["list"][j].checked = !document.forms["list"][j].checked;
		}
	}
}