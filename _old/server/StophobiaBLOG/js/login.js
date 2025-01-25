function login()
{
	t = document.forms['login'];
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
	return true;
}

// 움직이기
new Draggable('userLogin', {revert:false});