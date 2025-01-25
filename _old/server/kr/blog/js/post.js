// 포스트삭제
function delPost(uid)
{
	if(confirm('정말로 이 글을 삭제하시겠습니까?')) {
		location.href='admin.php?admin=4&deleteTarget='+uid;
	}
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
// 카테고리 추가 시 체크
function chkName()
{
	t = document.forms['addCategory'];
	if(!t.elements['addName'].value) {
		alert('추가할 카테고리명을 입력해 주십시오.');
		t.elements['addName'].focus();
		return false;
	}
	return true;
}
// 댓글알리미 삭제
function delReply(uid)
{
	if(confirm('정말로 이 댓글을 삭제하시겠습니까?')) {
		location.href='admin.php?admin=19&deleteTarget='+uid;
	}
}
// 포토로그 일괄 분류변경 확인
function changePhotoCategory()
{
	var isChecked = false;
	var t = document.forms['list'];
	var changeCatNum = t.elements['changeCategory'].value;
	for(i=0; i<t.length; i++) {
		if(t[i].type == 'checkbox') {
			t[i] = true;
			isChecked = true;
		}
	}
	if( !isChecked ) {
		alert('분류를 변경할 사진을 목록에서 하나 이상 선택하세요!');
		return false;
	}
	t.elements['isChangeCategory'].value = changeCatNum;
	t.submit();
}
// 포토로그 선택 사진 삭제 확인
function deletePhoto()
{
	if(confirm('정말로 선택하신 사진들을 모두 삭제하시겠습니까?')) {
		document.forms['list'].submit();
	}
}