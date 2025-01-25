/*
	GR Paper 로그인 처리 스크립트
	작성자: 박희근 (http://sirini.net)
	수정일: 2008-08-23
	내  용: 폼 값을 체크하고 Ajax 로 로그인 세션 처리 요청을 보내고 받는다.
	참  고: 로그인 폼 디자인은 사용중인 스킨의 body.login.php 등에 영향을 받는다.
	          이 스크립트는 prototype + script.aculo.us 가 먼저 선언되어야 제대로 동작함.
*/
var Login = {
	check : function() {
		var id = $F("id");
		var password = $F("password");
		if(!id) {
			alert("아이디를 입력해 주세요.");
			return false;
		}
		if(!password) {
			alert("비밀번호를 입력해 주세요.");
			return false;
		}
		var dirName = $F("dirName");
		var request = new Ajax.Request("login.ok.php", {
			parameters: "id="+id+"&password="+password,
			onSuccess: function(request) {
				var answer = request.responseXML.getElementsByTagName("grpaper")[0].getElementsByTagName("result")[0].firstChild.nodeValue;
				if(answer == "true") {
					location.href=dirName+"/admin/?work1";
				} else {
					alert("아이디 혹은 비밀번호가 맞지 않습니다. 다시 입력해 주세요.");
					return false;
				}
			}
		});
		return false;
	}
}
