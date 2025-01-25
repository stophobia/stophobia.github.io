jQuery(function() {
	jQuery("#loginField", this).toggle("loginField");
});

function checkInput(t) {
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