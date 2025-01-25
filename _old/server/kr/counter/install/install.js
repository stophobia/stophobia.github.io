function dbInfo()
{
	t = document.forms['install'];
	if(!t.elements['hostName'].value) {
		alert('호스트네임을 입력해 주세요: 대부분 localhost 입니다.');
		t.elements['hostName'].focus();
		return false;
	}
	if(!t.elements['userId'].value) {
		alert('DB아이디를 입력해 주세요: 대부분 계정아이디와 동일합니다.');
		t.elements['userId'].focus();
		return false;
	}
	if(!t.elements['password'].value) {
		alert('DB비밀번호를 입력해 주세요: 대부분 계정비밀번호와 동일합니다.');
		t.elements['password'].focus();
		return false;
	}
	if(!t.elements['dbName'].value) {
		alert('DB이름을 입력해 주세요: 대부분 계정아이디와 동일합니다.');
		t.elements['dbName'].focus();
		return false;
	}
	return true;
}
function setting()
{
	t = document.forms['set'];
	if(!t.elements['id'].value) {
		alert('아이디를 입력해 주세요.');
		t.elements['id'].focus();
		return false;
	}
	if(!t.elements['password'].value) {
		alert('비밀번호를 입력해 주세요.');
		t.elements['password'].focus();
		return false;
	}
	return true;
}