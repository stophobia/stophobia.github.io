$(function() {
	$("#license", this).toggle("license");
});

function checkInfo(t) {
	if(!t.elements['hostName'].value) {
		alert('호스트네임을 입력해 주세요.');
		t.elements['hostName'].focus();
		return false;
	}
	if(!t.elements['userId'].value) {
		alert('DB접속시 사용할 아이디를 입력해 주세요.');
		t.elements['userId'].focus();
		return false;
	}
	if(!t.elements['password'].value) {
		alert('DB접속시 사용할 비밀번호를 입력해 주세요.');
		t.elements['password'].focus();
		return false;
	}
	if(!t.elements['dbName'].value) {
		alert('접속할 DB명을 입력해 주세요.');
		t.elements['dbName'].focus();
		return false;
	}
	if(!t.elements['corePass'].value) {
		alert('설정 변경시 사용할 비밀번호를 입력해 주세요.');
		t.elements['corePass'].focus();
		return false;
	}
	return true;
}