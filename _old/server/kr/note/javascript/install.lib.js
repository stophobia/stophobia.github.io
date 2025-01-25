var Install = {
	isAgree : function() {
		var f = document.forms['licenseCheck'].elements['agree'];
		if(f.checked) location.href='./?step=3&isLicenseAgree=yes';
		else alert('위의 라이센스에 동의해야만 설치를 계속 할 수 있습니다.');
	},
	$FV : function(fn, fe) {
		return document.forms[fn].elements[fe].value;
	},
	createDBInfo : function() {
		var nowStatus = true;
		if(!this.$FV('dbInfo', 'hostName')) { alert('호스트이름을 입력해 주세요.'); return false; }
		if(!this.$FV('dbInfo', 'userId')) { alert('DB접속 아이디를 입력해 주세요.'); return false; }
		if(!this.$FV('dbInfo', 'password')) { alert('DB접속 비밀번호를 입력해 주세요.'); return false; }
		if(!this.$FV('dbInfo', 'dbName')) { alert('DB이름을 입력해 주세요.'); return false; }
		if(!this.$FV('dbInfo', 'divide')) { alert('GR Note 구분자를 입력해 주세요.'); return false; }
		try {
			var request = new Ajax.Request('insert.db.info.php', {
				parameters : 'hostName='+this.$FV('dbInfo', 'hostName')+'&userId='+this.$FV('dbInfo', 'userId')+'&password='+this.$FV('dbInfo', 'password')+'&dbName='+this.$FV('dbInfo', 'dbName')+'&divide='+this.$FV('dbInfo', 'divide'),
				onLoading : function() {
					if(nowStatus) {
						$('loadBox').style.display = '';
						$('loadBox').innerHTML = '<img src="images/wait.gif" alt="" /> DB접속정보를 전송중입니다...';
					}
				},
				onComplete : function() {
					if(nowStatus) {
						$('loadBox').style.display = '';
						$('loadBox').innerHTML = '<img src="images/accept.gif" alt="" /> 전송이 완료되었습니다!';
						location.href='./?step=4';
					}
				},
				onSuccess : function(request) {
					var error = parseInt(request.responseXML.getElementsByTagName('error')[0].firstChild.nodeValue);
					if(error) {
						alert('DB접속정보가 올바르지 않습니다. 다시 입력해 주세요.');
						nowStatus = false;
						$('loadBox').style.display = 'none';
						return false;
					}
					nowStatus = true;
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
	},
	regAdmin : function() {
		var regSuccess = true;
		if(!this.$FV('regAdmin', 'id')) { alert('아이디를 입력해 주십시오.'); return false; }
		if(!this.$FV('regAdmin', 'password')) { alert('비밀번호를 입력해 주십시오.'); return false; }
		if(!this.$FV('regAdmin', 'nickname')) { alert('이름을 입력해 주십시오.'); return false; }
		try {
			var request = new Ajax.Request('insert.admin.info.php', {
				parameters : 'id='+this.$FV('regAdmin', 'id')+'&password='+this.$FV('regAdmin', 'password')+'&nickname='+this.$FV('regAdmin', 'nickname')+'&email='+this.$FV('regAdmin', 'email')+'&homepage='+this.$FV('regAdmin', 'homepage')+'&selfInfo='+this.$FV('regAdmin', 'selfInfo'),
				onLoading : function() {
					if(regSuccess) {
						$('loadBox').style.display = '';
						$('loadBox').innerHTML = '<img src="images/wait.gif" alt="" /> 관리자를 등록 합니다...';
					}
				},
				onComplete : function() {
					if(regSuccess) {
						$('loadBox').style.display = '';
						$('loadBox').innerHTML = '<img src="images/wait.gif" alt="" /> DB에 관리자가 등록 되었습니다!';
					}
				},
				onSuccess : function(request) {
					location.href='./?step=5';
					regSuccess = true;
				},
				onFailure : function() {
					regSuccess = false;
					$('loadBox').style.display = '';
					$('loadBox').innerHTML = '<img src="images/cancel.gif" alt="" /> <span class="alert">관리자를 등록하지 못했습니다.</span>';
					return false;
				}
			});
		} catch(e) { alert(e); }
		return false;
	}
};