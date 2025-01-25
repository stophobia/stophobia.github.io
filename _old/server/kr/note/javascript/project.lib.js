var Project = {
	formValue : function(name) {
		return document.forms['create'].elements[name].value;
	},
	choose : function(no) {
		if($('projectInfo'+no).style.display == '') Effect.Fade('projectInfo'+no);
		else Effect.Appear('projectInfo'+no);
	},
	create : function() {
		tinyMCE.triggerSave();
		if(!this.formValue('name')) {
			alert('프로젝트 이름을 입력해 주십시오.');
			document.forms['create'].elements['name'].style.backgroundColor='#f9e8e8';
			document.forms['create'].elements['name'].focus();
			return false; 
		}
		var nowStatus = true;
		try {
			var summary = this.filter(this.formValue('summary'));
			var name = this.filter(this.formValue('name'));
			if(!this.formValue('modifyNo')) {
				var modifyNo = 0; 
				var condition = '생성';
			} else {
				var modifyNo = this.formValue('modifyNo');
				var condition = '수정';
			}
			var request = new Ajax.Request('index/project.create.php', {
				parameters : 'name='+name+'&summary='+summary+'&modifyNo='+modifyNo,
				onLoading : function() {
					if(nowStatus) {
						$('loadBox').style.display = '';
						$('loadBox').innerHTML = '<img src="index/images/wait.gif" alt="" /> 프로젝트 '+condition+'중입니다...';
					}
				},
				onComplete : function() {
					if(nowStatus) {
						$('loadBox').style.display = '';
						$('loadBox').innerHTML = '<img src="index/images/accept.gif" alt="" /> 프로젝트 '+condition+'이 완료되었습니다!';
					}
				},
				onSuccess : function(request) {
					var error = parseInt(request.responseXML.getElementsByTagName('error')[0].firstChild.nodeValue);
					if(error) {
						alert('프로젝트를 '+condition+'할 권한이 없습니다.');
						nowStatus = false;
						$('loadBox').style.display = 'none';
						return false;
					}
					location.href = './?m=project';
					nowStatus = true;
				},
				onFailure : function() {
					nowStatus = false;
					$('loadBox').style.display = '';
					$('loadBox').innerHTML = '<img src="index/images/cancel.gif" alt="" /> <span class="alert">프로젝트를 '+condition+'하지 못했습니다.</span>';
					return false;
				}
			});
		} catch(e) { alert(e);	}
		return false;
	},
	remove : function(uid) {
		if(confirm('정말로 이 프로젝트를 삭제하시겠습니까?')) {
			try {
				var request = new Ajax.Request('index/project.delete.php', {
					parameters : 'projectNo='+uid,
					onLoading : function() {
						if(nowStatus) {
							$('loadBox').style.display = '';
							$('loadBox').innerHTML = '<img src="index/images/wait.gif" alt="" /> 프로젝트를 삭제중입니다...';
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
						location.href = './?m=project';
						nowStatus = true;
					},
					onFailure : function() {
						nowStatus = false;
						$('loadBox').style.display = '';
						$('loadBox').innerHTML = '<img src="index/images/cancel.gif" alt="" /> <span class="alert">프로젝트를 지우지 못했습니다.</span>';
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
	}
};