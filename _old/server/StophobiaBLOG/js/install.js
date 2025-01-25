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

function setting(n)
{
	t = document.forms['set'];
	if(!t.elements['id'].value) {
		alert('로그인 시 입력할 아이디를 입력해 주세요 (예: admin)');
		t.elements['id'].focus();
		return false;
	}
	if(!n && !t.elements['password'].value) {
		alert('로그인 시 입력할 비밀번호를 입력해 주세요. (비밀번호는 암호화되어 저장됩니다)');
		t.elements['password'].focus();
		return false;
	}
	if(!t.elements['email'].value) {
		alert('이메일 주소를 입력해 주세요.');
		t.elements['email'].focus();
		return false;
	}
	if(!t.elements['user_key'].value) {
		alert('스팸 방지를 위한 키 값을 입력해 주세요. (예: spam kin)');
		t.elements['user_key'].focus();
		return false;
	}
	if(!t.elements['name'].value) {
		alert('글 작성 시 보여줄 이름(닉네임)을 입력해 주세요. (예: 홍길동)');
		t.elements['name'].focus();
		return false;
	}
	if(!t.elements['blog_name'].value) {
		alert('블로그 이름을 입력해 주세요. (예: 홍길동의 블로그)');
		t.elements['blog_name'].focus();
		return false;
	}
	if(!t.elements['blog_info'].value) {
		alert('블로그 소개글을 입력해 주세요. (예: 홍길동의 행복한 의적활동)');
		t.elements['blog_info'].focus();
		return false;
	}
	return true;
}