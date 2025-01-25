var Login = {
	formValue : function(name) {
		return document.forms['registerMember'].elements[name].value;
	},
	registerWindow : function(e) {
		$('memberJoin').style.top = Event.Methods.pointerY(e) + 'px';
		$('memberJoin').style.left = Event.Methods.pointerX(e) + 'px';
		if($('memberJoin').style.display == '') Effect.Fade('memberJoin');
		else Effect.Appear('memberJoin');
	},
	closeWindow : function() {
		Effect.Fade('memberJoin');
	},
	regMember : function() {
		if(!this.formValue('id')) { alert('아이디를 입력해 주세요.'); return false; }
		if(!this.formValue('nickname')) { alert('이름(닉네임)을 입력해 주세요.'); return false; }
		if(!this.formValue('password')) { alert('비밀번호를 입력해 주세요.'); return false; }
		try {
			var request = new Ajax.Request('login.member.join.php', {
				parameters : 'id='+this.formValue('id')+'&password='+this.formValue('password')+'&nickname='+this.formValue('nickname')+'&email='+this.formValue('email')+'&homepage='+this.formValue('homepage')+'&selfInfo='+this.formValue('selfInfo'),
				onLoading : function() {
					if(nowStatus) {
						$('loadBox').style.display = '';
						$('loadBox').innerHTML = '<img src="images/wait.gif" alt="" /> 등록중입니다...';
					}
				},
				onComplete : function() {
					if(nowStatus) {
						$('loadBox').style.display = '';
						$('loadBox').innerHTML = '<img src="images/accept.gif" alt="" /> 등록이 완료되었습니다!';
					}
				},
				onSuccess : function(request) {
					var error = parseInt(request.responseXML.getElementsByTagName('error')[0].firstChild.nodeValue);
					if(error == 1) {
						alert('등록 할 수 없었습니다.');
						nowStatus = false;
						$('loadBox').style.display = 'none';
						return false;
					} else if (error == 2) {
						alert('등록하시려는 아이디가 이미 사용중입니다. 다른 아이디를 입력해 보세요.');
						nowStatus = false;
						$('loadBox').style.display = 'none';
						return false;
					} else if (error == 3) {
						alert('이 노트에서는 멤버 등록이 허용되어 있지 않습니다.');
						nowStatus = false;
						$('loadBox').style.display = 'none';
						return false;
					}
					nowStatus = true;
					alert('등록을 완료하였습니다. 로그인 해주세요.');
					location.href = '../login/';
					return false;
				},
				onFailure : function() {
					nowStatus = false;
					$('loadBox').style.display = '';
					$('loadBox').innerHTML = '<img src="images/cancel.gif" alt="" /> <span class="alert">멤버정보를 등록하지 못했습니다.</span>';
					return false;
				}
			});
		} catch(e) { alert(e);	}
		return false;
	},
	process : function() {
		var nowStatus = true;
		if(!$F('id')) { alert('아이디를 입력해 주세요.'); return false; }
		if(!$F('password')) { alert('비밀번호를 입력해 주세요.'); return false; }
		try {
			var request = new Ajax.Request('login.check.php', {
				parameters : 'id='+$F('id')+'&password='+$F('password'),
				onLoading : function() {
					if(nowStatus) {
						$('loadBox').style.display = '';
						$('loadBox').innerHTML = '<img src="images/wait.gif" alt="" /> 아이디와 비밀번호를 확인하고 있습니다...';
					}
				},
				onComplete : function() {
					if(nowStatus) {
						$('loadBox').style.display = '';
						$('loadBox').innerHTML = '<img src="images/accept.gif" alt="" /> 확인이 완료되었습니다!';		
					}
				},
				onSuccess : function(request) {
					var lists = request.responseXML.getElementsByTagName('lists')[0];
					var error = parseInt(lists.getElementsByTagName('error')[0].firstChild.nodeValue);
					var isAdmin = parseInt(lists.getElementsByTagName('isAdmin')[0].firstChild.nodeValue);
					var key = lists.getElementsByTagName('key')[0].firstChild.nodeValue;
					if(error) {
						alert('아이디 혹은 비밀번호가 올바르지 않습니다.');
						nowStatus = false;
						$('loadBox').style.display = 'none';
						return false;
					}
					nowStatus = true;
					if(isAdmin) {
						if(confirm('관리자님, 관리화면으로 가시겠습니까?\n\n'+
							'관리화면으로 가길 원하시면 확인(Yes), 첫화면으로 가길 원하시면 취소(No)를\n\n'+
							'선택해 주십시오.')) {
							location.href = '../admin/';
							return false;
						}
					}
					location.href = '../';
					return false;
				},
				onFailure : function() {
					nowStatus = false;
					$('loadBox').style.display = '';
					$('loadBox').innerHTML = '<img src="images/cancel.gif" alt="" /> <span class="alert">DB접속정보를 서버에 저장할 수 없습니다.</span>';
					return false;
				}
			});
		} catch(e) { alert(e);	}
		return false;
	}
}