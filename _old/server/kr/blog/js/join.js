function join()
{
	t = document.forms['join'];
	if(!t.elements['id'].value) {
		alert('아이디를 입력해 주세요');
		t.elements['id'].focus();
		return false;
	}
	if(!t.elements['password'].value) {
		alert('비밀번호를 입력해 주세요');
		t.elements['password'].focus();
		return false;
	}
	if(!t.elements['name'].value) {
		alert('이름(닉네임)을 입력해 주세요');
		t.elements['name'].focus();
		return false;
	}
	return true;
}

function idCheck()
{
	t = document.forms['join'];
	if(!t.elements['id'].value) {
		alert('아이디를 입력해 주세요.');
		return;
	}
	window.open('../../user/join/id_check.php?who='+t.elements['id'].value, 'id_check', 'width=50,height=50,menubar=no');
}