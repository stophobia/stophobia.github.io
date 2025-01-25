// 입력값 검사
function checkValue()
{
	if(!document.forms["installFirst"].elements["hostName"].value)
	{
		alert('호스트네임을 입력해 주세요. 일반적으로는 localhost 입니다.');
		return false;
	}

	if(!document.forms["installFirst"].elements["userId"].value)
	{
		alert('계정 사용자 ID 값을 입력해주세요. 일반적인 웹호스팅 사용자의 경우\n\n'+
			'DB 이름과 동일합니다. (모르시겠다면 호스팅 관리자에게 문의해 보세요.');
		return false;
	}

	if(!document.forms["installFirst"].elements["password"].value)
	{
		alert('DB 계정에 접속가능한 비밀번호를 입력해주세요. 일반적인 웹호스팅 사용자의 경우\n\n'+
			'대부분 FTP 접속 비밀번호와 동일합니다. (모르시겠다면 호스팅 관리자에게 문의해 보세요.');
		return false;
	}

	if(!document.forms["installFirst"].elements["dbName"].value)
	{
		alert('DB 이름을 입력해주세요. 일반적인 웹호스팅 사용자의 경우\n\n'+
			'계정 사용자 ID 와 동일합니다. (모르시겠다면 호스팅 관리자에게 문의해 보세요.');
		return false;
	}
	return true;
}

// btnOver , btnOut 이벤트 잡아채기
var inputBtn = document.getElementsByTagName('input');
for(i=0; i<inputBtn.length; i++) {
	if(inputBtn[i].getAttribute('class') == 'btn') {
		inputBtn[i].onmouseover = function() { this.setAttribute('src', str_replace('.gif', '_over.gif', this.getAttribute('src'))); }
		inputBtn[i].onmouseout = function() { this.setAttribute('src', str_replace('_over.gif', '.gif', this.getAttribute('src'))); }
	}
}

// 문자열 치환
function str_replace(str1, str2, str3)
{
	var r = new RegExp(str1, 'g');
	return str3.replace(r, str2);
}

// 움직일 대상
new Draggable('checkMe', {revert:false});
new Draggable('checkEnv', {revert:false});
new Draggable('enterDBInfo', {revert:false});
new Draggable('installHelp', {revert:false});