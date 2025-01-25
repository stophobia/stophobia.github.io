var Admin = {
	modifyMemberWindow : function(no, select, e) {
		if(select && $('memberModify').style.display == 'none') {
			$('memberModify').style.display = '';
			return;
		}
		location.href='./?m=member&selectMember='+no+'&x='+Event.Methods.pointerX(e)+'&y='+Event.Methods.pointerY(e);
	},
	closeWindow : function() {
		$('memberModify').style.display = 'none';
	},
	formValue : function(name) {
		return document.forms['modifyMember'].elements[name].value;
	},
	modifyingMember : function(x, y) {
		if(!this.formValue('nickname')) { alert('이름(닉네임)을 입력해 주세요.'); return false; }
		var modifyUid = this.formValue('modifyUid');
		try {
			var request = new Ajax.Request('admin.process.modify.member.php', {
				parameters : 'modifyUid='+modifyUid+'&password='+this.formValue('password')+'&nickname='+this.formValue('nickname')+'&email='+this.formValue('email')+
					'&homepage='+this.formValue('homepage')+'&level='+this.formValue('level')+'&point='+this.formValue('point')+'&selfInfo='+this.formValue('selfInfo'),
				onLoading : function() {
					if(nowStatus) {
						$('loadBox').style.display = '';
						$('loadBox').innerHTML = '<img src="images/wait.gif" alt="" /> 수정중입니다...';
					}
				},
				onComplete : function() {
					if(nowStatus) {
						$('loadBox').style.display = '';
						$('loadBox').innerHTML = '<img src="images/accept.gif" alt="" /> 수정이 완료되었습니다!';
					}
				},
				onSuccess : function(request) {
					var error = parseInt(request.responseXML.getElementsByTagName('error')[0].firstChild.nodeValue);
					if(error) {
						alert('수정 할 수 없었습니다.');
						nowStatus = false;
						$('loadBox').style.display = 'none';
						return false;
					}
					nowStatus = true;
					location.href = './?m=member&selectMember='+modifyUid+'&x='+x+'&y='+y;
					return false;
				},
				onFailure : function() {
					nowStatus = false;
					$('loadBox').style.display = '';
					$('loadBox').innerHTML = '<img src="images/cancel.gif" alt="" /> <span class="alert">멤버정보를 수정하지 못했습니다.</span>';
					return false;
				}
			});
		} catch(e) { alert(e);	}
		return false;
	},
	deleteMember : function(no, id) {
		if(no == 1) {
			alert('관리자 자신은 삭제할 수 없습니다.');
			return false;
		}
		if(confirm('정말로 '+id+'(을)를 삭제하시겠습니까?')) {
			try {
				var request = new Ajax.Request('admin.process.delete.member.php', {
					parameters : 'id='+id+'&no='+no,
					onLoading : function() {
						if(nowStatus) {
							$('loadBox').style.display = '';
							$('loadBox').innerHTML = '<img src="images/wait.gif" alt="" /> 삭제중입니다...';
						}
					},
					onComplete : function() {
						if(nowStatus) {
							$('loadBox').style.display = '';
							$('loadBox').innerHTML = '<img src="images/accept.gif" alt="" /> 삭제가 완료되었습니다!';		
						}
					},
					onSuccess : function(request) {
						var error = parseInt(request.responseXML.getElementsByTagName('error')[0].firstChild.nodeValue);
						if(error) {
							alert('삭제를 완료 할 수 없었습니다.');
							nowStatus = false;
							$('loadBox').style.display = 'none';
							return false;
						}
						nowStatus = true;
						location.href = './?m=member';
						return false;
					},
					onFailure : function() {
						nowStatus = false;
						$('loadBox').style.display = '';
						$('loadBox').innerHTML = '<img src="images/cancel.gif" alt="" /> <span class="alert">멤버를 삭제하지 못했습니다.</span>';
						return false;
					}
				});
			} catch(e) { alert(e);	}
		}
		return false;
	},
	uninstall : function(key) {
		if(confirm('※ GR노트를 삭제하겠습니다. 계속 진행하시겠습니까?')) {
			location.href='./?m=uninstall&uninstall=yes';
		}
	}
};