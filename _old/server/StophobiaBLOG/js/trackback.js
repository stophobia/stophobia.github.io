// 댓글 삭제
function delTrackback(uid, post_uid)
{
	if(confirm('정말로 이 글을 삭제하시겠습니까?')) {
		location.href='admin.php?admin=6&deleteTarget='+uid+'&post_uid='+post_uid;
	}
}
// 댓글 수정
function modifyTrackback(uid)
{
	window.open('admin/admin_modify_trackback.php?uid='+uid, 'modify_comment', 'width=400,height=500,menubar=no');
}
// 검색어 입력 검사
function post()
{
	t = document.forms['post'];
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