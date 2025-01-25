var View = {
	formValue : function(name) {
		return document.forms['ticketForm'].elements[name].value;
	},
	changeCondition : function(change, uid, p, g, t) {
		var nowStatus = true;
		try {
			var request = new Ajax.Request('index/view.change.php', {
				parameters : 'change='+change+'&p='+p+'&g='+g+'&uid='+uid,
				onLoading : function() {
					if(nowStatus) {
						$('loadBox').style.display = '';
						$('loadBox').innerHTML = '<img src="index/images/wait.gif" alt="" /> 티켓 상태를 수정중입니다...';
					}
				},
				onComplete : function() {
					if(nowStatus) {
						$('loadBox').style.display = '';
						$('loadBox').innerHTML = '<img src="index/images/accept.gif" alt="" /> 티켓 상태를 변경 하였습니다.';
					}
				},
				onSuccess : function(request) {
					var error = parseInt(request.responseXML.getElementsByTagName('error')[0].firstChild.nodeValue);
					if(error) {
						alert('티켓 상태를 변경하지 못했습니다.');
						nowStatus = false; 
						$('loadBox').style.display = 'none';
						return false;
					}
					location.href = './?m=view&p='+p+'&g='+g+'&t='+t;
					nowStatus = true;
				},
				onFailure : function() {
					nowStatus = false;
					$('loadBox').style.display = '';
					$('loadBox').innerHTML = '<img src="index/images/cancel.gif" alt="" /> <span class="alert">티켓 상태를 수정하지 못했습니다.</span>';
					return false;
				}
			});
		} catch(e) { alert(e);	}
		return false;
	},
	deleteTicket : function(uid, p, g, t) {
		if(confirm('정말로 이 티켓을 삭제하시겠습니까?')) {
			try {
				var request = new Ajax.Request('index/view.delete.php', {
					parameters : 'uid='+uid+'&goalNo='+g+'&projectNo='+p,
					onLoading : function() {
						if(nowStatus) {
							$('loadBox').style.display = '';
							$('loadBox').innerHTML = '<img src="index/images/wait.gif" alt="" /> 목표를 삭제중입니다...';
						}
					},
					onComplete : function() {
						if(nowStatus) {
							$('loadBox').style.display = '';
							$('loadBox').innerHTML = '<img src="index/images/accept.gif" alt="" /> 삭제가 완료되었습니다!';
						}
					},
					onSuccess : function(request) {
						var error = parseInt(request.responseXML.getElementsByTagName('error')[0].firstChild.nodeValue);
						if(error) {
							alert('삭제할 수 있는 권한이 없습니다.');
							nowStatus = false;
							$('loadBox').style.display = 'none';
							return false;
						}
						location.href = './?m=view&p='+p+'&g='+g+'&t='+t;
						nowStatus = true;
					},
					onFailure : function() {
						nowStatus = false;
						$('loadBox').style.display = '';
						$('loadBox').innerHTML = '<img src="index/images/cancel.gif" alt="" /> <span class="alert">티켓을 지우지 못했습니다.</span>';
						return false;
					}
				});
			} catch(e) { alert(e);	}
			return false;			
		}
	},
	replace : function(str1, str2, str3)
	{
		var r = new RegExp(str1, 'g');
		return str3.replace(r, str2);
	}
};