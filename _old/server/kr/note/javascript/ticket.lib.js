var Ticket = {
	formValue : function(name) {
		return document.forms['create'].elements[name].value;
	},
	create : function() {
		var nowStatus = true;
		try {
			if(!this.formValue('projectID') || !this.formValue('goalID')) {
				alert('프로젝트/목표를 먼저 선택해 주세요.');
				return false;
			}
			if(!this.formValue('memo')) {
				alert('세부적인 할 일을 작성해 주세요.');
				document.forms['create'].elements['memo'].style.backgroundColor='#f9e8e8';
				document.forms['create'].elements['memo'].focus();
				return false;
			}
			var memo = this.filter(this.formValue('memo'));
			var projectID = this.formValue('projectID');
			var goalID = this.formValue('goalID');
			if(this.formValue('modifyNo')) {
				var msg = '수정';
				var modifyNo = this.formValue('modifyNo');
			} else {
				var msg = '추가';
				var modifyNo = 0;
			}
			var request = new Ajax.Request('index/ticket.create.php', {
				parameters : 'projectID='+projectID+'&goalID='+goalID+'&memo='+memo,
				onLoading : function() {
					if(nowStatus) {
						$('loadBox').style.display = '';
						$('loadBox').innerHTML = '<img src="index/images/wait.gif" alt="" /> 티켓을 '+msg+'중입니다...';
					}
				},
				onComplete : function() {
					if(nowStatus) {
						$('loadBox').style.display = '';
						$('loadBox').innerHTML = '<img src="index/images/accept.gif" alt="" /> 티켓을 '+msg+' 하였습니다.';
					}
				},
				onSuccess : function(request) {
					var error = parseInt(request.responseXML.getElementsByTagName('error')[0].firstChild.nodeValue);
					if(error) {
						alert('티켓을 '+msg+'하지 못했습니다. 티켓을 '+msg+'할 권한이 없습니다.');
						nowStatus = false;
						$('loadBox').style.display = 'none';
						return false;
					}
					alert('티켓을 무사히 발송하였습니다.');
					location.href = './?m=ticket&p='+projectID+'&g='+goalID;
					nowStatus = true;
				},
				onFailure : function() {
					nowStatus = false;
					$('loadBox').style.display = '';
					$('loadBox').innerHTML = '<img src="index/images/cancel.gif" alt="" /> <span class="alert">티켓을 '+msg+'하지 못했습니다.</span>';
					return false;
				}
			});
		} catch(e) { alert(e);	}
		return false;
	},
	replace : function(str1, str2, str3) {
		var r = new RegExp(str1, 'g');
		return str3.replace(r, str2);
	},
	filter : function(str) {
		str = this.replace('&', '@amp;', str);
		str = this.replace('\\+', '@plus;', str);
		str = this.replace('%', '@percent;', str);
		str = this.replace('#', '@sharp;', str);
		str = this.replace('\\?', '@question;', str);
		return str;
	}
};