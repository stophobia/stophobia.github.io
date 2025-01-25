var Goal = {
	formValue : function(name) {
		return document.forms['create'].elements[name].value;
	},
	create : function() {
		tinyMCE.triggerSave();
		var nowStatus = true;
		try {
			if(!this.formValue('projectID')) {
				alert('프로젝트를 먼저 선택해 주세요.');
				return false;
			}
			var content = this.filter(this.formValue('goal'));
			var version = this.filter(this.formValue('version'));
			var codename = this.filter(this.formValue('codename'));
			var projectID = this.formValue('projectID');
			if(this.formValue('modifyNo')) {
				var msg = '수정';
				var modifyNo = this.formValue('modifyNo');
			} else {
				var msg = '추가';
				var modifyNo = 0;
			}
			var request = new Ajax.Request('index/goal.create.php', {
				parameters : 'codename='+codename+'&version='+version+'&goal='+content+'&modifyNo='+modifyNo+'&projectID='+projectID,
				onLoading : function() {
					if(nowStatus) {
						$('loadBox').style.display = '';
						$('loadBox').innerHTML = '<img src="index/images/wait.gif" alt="" /> 목표를 '+msg+'중입니다...';
					}
				},
				onComplete : function() {
					if(nowStatus) {
						$('loadBox').style.display = '';
						$('loadBox').innerHTML = '<img src="index/images/accept.gif" alt="" /> 목표를 '+msg+' 하였습니다.';
					}
				},
				onSuccess : function(request) {
					var error = parseInt(request.responseXML.getElementsByTagName('error')[0].firstChild.nodeValue);
					if(error) {
						alert('목표를 '+msg+'하지 못했습니다. 목표를 '+msg+'할 권한이 없습니다.');
						nowStatus = false;
						$('loadBox').style.display = 'none';
						return false;
					}
					location.href = './?m=goal&p='+projectID;
					nowStatus = true;
				},
				onFailure : function() {
					nowStatus = false;
					$('loadBox').style.display = '';
					$('loadBox').innerHTML = '<img src="index/images/cancel.gif" alt="" /> <span class="alert">목표를 '+msg+'하지 못했습니다.</span>';
					return false;
				}
			});
		} catch(e) { alert(e);	}
		return false;
	},
	remove : function(uid, p) {
		if(confirm('정말로 이 목표를 삭제하시겠습니까?')) {
			try {
				var request = new Ajax.Request('index/goal.delete.php', {
					parameters : 'goalNo='+uid+'&projectNo='+p,
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
						location.href = './?m=goal&p='+p;
						nowStatus = true;
					},
					onFailure : function() {
						nowStatus = false;
						$('loadBox').style.display = '';
						$('loadBox').innerHTML = '<img src="index/images/cancel.gif" alt="" /> <span class="alert">목표를 지우지 못했습니다.</span>';
						return false;
					}
				});
			} catch(e) { alert(e);	}
			return false;			
		}
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
	},
	nonProject : function(p) {
		if(p != '') location.href='./?m=goal&a=create&p='+p;
		else alert('프로젝트를 먼저 선택하셔야 합니다.\n\n선택하지 않고 작성된 문서는 소실될 수 있습니다.');
	}
};