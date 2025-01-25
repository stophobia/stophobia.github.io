function checkValue(n)
{
	t = document.forms['comment'];
	if(!n && !t.elements['antispam'].value) {
		alert('자동등록방지 숫자 답 (예: 2 + 5 = ? 에서 7) 을 입력해 주십시오');
		t.elements['antispam'].focus();
		return false;
	}
	if(!n && !t.elements['name'].value) {
		alert('이름(닉네임)을 입력해 주십시오');
		t.elements['name'].focus();
		return false;
	}
	if(!n && !t.elements['password'].value) {
		alert('비밀번호를 입력해 주세요! 댓글 삭제시 사용 됩니다.');
		t.elements['password'].focus();
		return false;
	}
	if(!t.elements['content'].value) {
		alert('코멘트를 입력해 주십시오');
		t.elements['content'].focus();
		return false;
	}
	return true;
}
function deletePhoto(uid)
{
	if(confirm('정말로 보고 계시는 사진을 사진첩에서 삭제하시겠습니까?')) {
		location.href='./?photoNo='+uid+'&deleteNo='+uid;
	}
}
function deleteComment(photoNo, uid)
{
	if(confirm('정말로 선택하신 코멘트를 삭제하시겠습니까?')) {
		location.href='./?photoNo='+photoNo+'&deleteCoNo='+uid;
	}
}
function deleteUserComment(chkUid, uid, p, e)
{
	if(!chkUid && confirm('정말로 선택하신 댓글을 삭제하시겠습니까?')) {
		alert('본인 확인을 위해 비밀번호를 받겠습니다.\n\n'+
			'삭제 버튼을 다시 한 번 눌러 주세요!');
		location.href='./?photoNo='+p+'&deleteCoUid='+uid;
		return;
	}
	if(!e) e = window.event;
	x = e.clientX;
	y = e.clientY;
	st = document.documentElement.scrollTop;
	id = 'enterPass';
	t = document.getElementById(id);
	if(t.style.display == '') {
		Effect.BlindUp(id);
		return;
	}
	t.style.left = e.clientX + 'px';
	t.style.top = (e.clientY + st) + 'px';
	more(id);
}
function checkCoPass()
{
	t = document.getElementById('enterCoPass');
	if(!t.elements['coPass'].value) {
		alert('비밀번호를 입력해 주세요');
		t.elements['coPass'].focus();
		return false;
	}
	return true;
}
function more(id)
{
	t = document.getElementById(id);
	if(t.style.display == '') {
		Effect.BlindUp(id);
	} else {
		Effect.BlindDown(id);
	}
}