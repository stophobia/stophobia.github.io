var Planner = {
	formValue : function(form, name) {
		return document.forms[form].elements[name].value;
	},
	add : function() {
		if(!this.formValue('addPlan', 'startDate')) {
			alert('일정의 시작일을 설정해 주세요.');
			document.forms['addPlan'].elements['startDate'].style.backgroundColor='#f9e8e8';
			document.forms['addPlan'].elements['startDate'].focus();
			return false; 
		}
		if(!this.formValue('addPlan', 'endDate')) {
			alert('일정의 종료일을 설정해 주세요.');
			document.forms['addPlan'].elements['endDate'].style.backgroundColor='#f9e8e8';
			document.forms['addPlan'].elements['endDate'].focus();
			return false;
		}
		if(!this.formValue('addPlan', 'subject')) {
			alert('일정의 요약 설명을 입력해 주세요.');
			document.forms['addPlan'].elements['subject'].style.backgroundColor='#f9e8e8';
			document.forms['addPlan'].elements['subject'].focus();
			return false;
		}
		try {
			var startDate = this.filter(this.formValue('addPlan', 'startDate'));
			var endDate = this.filter(this.formValue('addPlan', 'endDate'));
			var subject = this.filter(this.formValue('addPlan', 'subject'));
			var content = this.filter(this.formValue('addPlan', 'content'));
			var modifyTarget = this.formValue('addPlan', 'modifyTarget');
			var level = this.formValue('addPlan', 'level');
			var y = this.formValue('addPlan', 'y');
			var m = this.formValue('addPlan', 'm');
			var sh = parseInt(this.formValue('addPlan', 'startHour'));
			var eh = parseInt(this.formValue('addPlan', 'endHour'));
			var intStart = parseInt(this.replace('-', '', startDate));
			var intEnd = parseInt(this.replace('-', '', endDate));
			if(intStart > intEnd) {
				alert('일정이 시작되는 시점이 종료되는 시점보다도 늦습니다.');
				document.forms['addPlan'].elements['startDate'].focus();
				return false;
			} else if(intStart == intEnd) {
				if(sh > eh) {
					alert('일정 시작 시간이 종료 시간보다도 늦습니다. sh:'+sh+'/eh:'+eh);
					document.forms['addPlan'].elements['startHour'].focus();
					return false;
				}
			}
			var request = new Ajax.Request('index/planner.add.php', {
				parameters : 'startDate='+startDate+'&endDate='+endDate+'&startHour='+sh+'&endHour='+eh+'&level='+level+'&subject='+subject+'&content='+content+'&modifyNo='+modifyTarget,
				onLoading : function() {
					$('loadBox').style.display = '';
					$('loadBox').innerHTML = '<img src="index/images/wait.gif" alt="" /> 일정 작성중입니다...';
				},
				onComplete : function() {
					$('loadBox').style.display = '';
					$('loadBox').innerHTML = '<img src="index/images/accept.gif" alt="" /> 일정 작성이 완료되었습니다!';
				},
				onSuccess : function(request) {
					var error = parseInt(request.responseXML.getElementsByTagName('error')[0].firstChild.nodeValue);
					if(error) {
						alert('일정을 추가/수정할 권한이 없습니다.');
						$('loadBox').style.display = 'none';
					}
					location.href = './?m=planner&year='+y+'&month='+m;
				},
				onFailure : function() {
					$('loadBox').style.display = '';
					$('loadBox').innerHTML = '<img src="index/images/cancel.gif" alt="" /> <span class="alert">일정을 작성하지 못했습니다.</span>';
					return false;
				}
			});
		} catch(e) { alert(e); }
		return false;
	},
	addMemorial : function() {
		if(!this.formValue('addMemorial', 'setDate')) {
			alert('기념일을 설정해 주세요.');
			document.forms['addMemorial'].elements['setDate'].style.backgroundColor='#f9e8e8';
			document.forms['addMemorial'].elements['setDate'].focus();
			return false; 
		}
		if(!this.formValue('addMemorial', 'setSubject')) {
			alert('일정의 요약 설명을 입력해 주세요.');
			document.forms['addPlan'].elements['setSubject'].style.backgroundColor='#f9e8e8';
			document.forms['addPlan'].elements['setSubject'].focus();
			return false;
		}
		try {
			var setDate = this.filter(this.formValue('addMemorial', 'setDate'));
			var setHour = this.filter(this.formValue('addMemorial', 'setHour'));
			var subject = this.filter(this.formValue('addMemorial', 'setSubject'));
			var content = this.filter(this.formValue('addMemorial', 'setContent'));
			var setTarget = this.formValue('addMemorial', 'setTarget');
			var request = new Ajax.Request('index/planner.set.memorial.php', {
				parameters : 'setDate='+setDate+'&setHour='+setHour+'&subject='+subject+'&content='+content+'&modifyNo='+setTarget,
				onLoading : function() {
					$('loadBox').style.display = '';
					$('loadBox').innerHTML = '<img src="index/images/wait.gif" alt="" /> 기념일을 작성중입니다...';
				},
				onComplete : function() {
					$('loadBox').style.display = '';
					$('loadBox').innerHTML = '<img src="index/images/accept.gif" alt="" /> 기념일 작성이 완료되었습니다!';
				},
				onSuccess : function(request) {
					var lists = request.responseXML.getElementsByTagName('lists')[0].firstChild.nodeValue;
					$('memorialList').innerHTML = lists;
					if($('setMemorial').style.display == 'none') Planner.toggle('setMemorial');
					$('loadBox').style.display = 'none';
				},
				onFailure : function() {
					$('loadBox').style.display = '';
					$('loadBox').innerHTML = '<img src="index/images/cancel.gif" alt="" /> <span class="alert">기념일을 작성하지 못했습니다.</span>';
					return false;
				}
			});
		} catch(e) { alert(e); }
		return false;
	},
	remove : function(uid) {
		if(!uid) {
			this.toggle('addPlanBox');
			return false;
		}
		if(confirm('정말로 이 일정을 삭제하시겠습니까?')) {
			try {
				var y = this.formValue('addPlan', 'y');
				var m = this.formValue('addPlan', 'm');
				var request = new Ajax.Request('index/planner.delete.php', {
					parameters : 'deleteNo='+uid,
					onLoading : function() {
						$('loadBox').style.display = '';
						$('loadBox').innerHTML = '<img src="index/images/wait.gif" alt="" /> 일정을 삭제중입니다...';
					},
					onComplete : function() {
						$('loadBox').style.display = '';
						$('loadBox').innerHTML = '<img src="index/images/accept.gif" alt="" /> 삭제가 완료되었습니다!';
					},
					onSuccess : function(request) {
						var error = parseInt(request.responseXML.getElementsByTagName('error')[0].firstChild.nodeValue);
						if(error) {
							alert('삭제할 수 있는 권한이 없습니다. 자신의 일정만 삭제 가능합니다.');
							nowStatus = false;
							$('loadBox').style.display = 'none';
						}
						location.href = './?m=planner&year='+y+'&month='+m;
					},
					onFailure : function() {
						$('loadBox').style.display = '';
						$('loadBox').innerHTML = '<img src="index/images/cancel.gif" alt="" /> <span class="alert">일정을 삭제하지 못했습니다.</span>';
						return false;
					}
				});
			} catch(e) { alert(e); }
		}
	},
	deleteMemorial : function(uid) {
		if(!uid) {
			this.toggle('setMemorial');
			return false;
		}
		if(confirm('정말로 이 기념일을 삭제하시겠습니까?')) {
			try {
				var y = this.formValue('addPlan', 'y');
				var m = this.formValue('addPlan', 'm');
				var request = new Ajax.Request('index/planner.delete.memorial.php', {
					parameters : 'deleteNo='+uid,
					onLoading : function() {
						$('loadBox').style.display = '';
						$('loadBox').innerHTML = '<img src="index/images/wait.gif" alt="" /> 기념일을 삭제중입니다...';
					},
					onComplete : function() {
						$('loadBox').style.display = '';
						$('loadBox').innerHTML = '<img src="index/images/accept.gif" alt="" /> 삭제가 완료되었습니다!';
					},
					onSuccess : function(request) {
						var error = parseInt(request.responseXML.getElementsByTagName('error')[0].firstChild.nodeValue);
						if(error) {
							alert('삭제할 수 있는 권한이 없습니다. 자신의 기념일만 삭제 가능합니다.');
							nowStatus = false;
							$('loadBox').style.display = 'none';
						}
						location.href = './?m=planner&year='+y+'&month='+m;
					},
					onFailure : function() {
						$('loadBox').style.display = '';
						$('loadBox').innerHTML = '<img src="index/images/cancel.gif" alt="" /> <span class="alert">기념일을 삭제하지 못했습니다.</span>';
						return false;
					}
				});
			} catch(e) { alert(e); }
		}
	},
	modify : function(uid) {
		try {
			var request = new Ajax.Request('index/planner.get.modify.php', {
				parameters : 'getNo='+uid,
				onLoading : function() {
					$('loadBox').style.display = '';
					$('loadBox').innerHTML = '<img src="index/images/wait.gif" alt="" /> 일정을 불러들이는 중입니다...';
				},
				onComplete : function() {
					$('loadBox').style.display = '';
					$('loadBox').innerHTML = '<img src="index/images/accept.gif" alt="" /> 수정/삭제할 일정을 가져왔습니다!';
				},
				onSuccess : function(request) {
					$('loadBox').style.display = 'none';
					var lists = request.responseXML.getElementsByTagName('lists')[0];
					var startDate = lists.getElementsByTagName('startDate')[0].firstChild.nodeValue;
					var endDate = lists.getElementsByTagName('endDate')[0].firstChild.nodeValue;
					var startHour = lists.getElementsByTagName('startHour')[0].firstChild.nodeValue;
					var endHour = lists.getElementsByTagName('endHour')[0].firstChild.nodeValue;
					var level = parseInt(lists.getElementsByTagName('level')[0].firstChild.nodeValue);
					var subject = lists.getElementsByTagName('subject')[0].firstChild.nodeValue;
					var content = lists.getElementsByTagName('content')[0].firstChild.nodeValue;
					$('startDate').value = startDate;
					$('endDate').value = endDate;
					$('subject').value = subject;
					$('content').value = content;
					$('modifyTarget').value = uid;
					$('startHour').options[startHour-1].selected = true;
					$('endHour').options[endHour-1].selected = true;
					$('level').options[5-level].selected = true;
					if($('addPlanBox').style.display == 'none') Planner.toggle('addPlanBox');
				},
				onFailure : function() {
					$('loadBox').style.display = '';
					$('loadBox').innerHTML = '<img src="index/images/cancel.gif" alt="" /> <span class="alert">일정을 가져오지 못했습니다.</span>';
					return false;
				}
			});
		} catch(e) { alert(e); }
	},
	memoModify : function(uid) {
		try {
			var request = new Ajax.Request('index/planner.get.modify.memorial.php', {
				parameters : 'getNo='+uid,
				onLoading : function() {
					$('loadBox').style.display = '';
					$('loadBox').innerHTML = '<img src="index/images/wait.gif" alt="" /> 기념일을 불러들이는 중입니다...';
				},
				onComplete : function() {
					$('loadBox').style.display = '';
					$('loadBox').innerHTML = '<img src="index/images/accept.gif" alt="" /> 수정/삭제할 기념일을 가져왔습니다!';
				},
				onSuccess : function(request) {
					$('loadBox').style.display = 'none';
					var lists = request.responseXML.getElementsByTagName('lists')[0];
					var setDate = lists.getElementsByTagName('setDate')[0].firstChild.nodeValue;
					var setHour = lists.getElementsByTagName('setHour')[0].firstChild.nodeValue;
					var subject = lists.getElementsByTagName('subject')[0].firstChild.nodeValue;
					var content = lists.getElementsByTagName('content')[0].firstChild.nodeValue;
					var full = lists.getElementsByTagName('fullList')[0].firstChild.nodeValue;
					$('setDate').value = setDate;
					$('setSubject').value = subject;
					$('setContent').value = content;
					$('setTarget').value = uid;
					$('setHour').options[setHour-1].selected = true;
					$('memorialList').innerHTML = full;
					if($('setMemorial').style.display == 'none') Planner.toggle('setMemorial');
				},
				onFailure : function() {
					$('loadBox').style.display = '';
					$('loadBox').innerHTML = '<img src="index/images/cancel.gif" alt="" /> <span class="alert">기념일을 가져오지 못했습니다.</span>';
					return false;
				}
			});
		} catch(e) { alert(e); }
	},
	getDetail : function(year, month, day) {
		try {
			var request = new Ajax.Request('index/planner.get.detail.php', {
				parameters : 'y='+year+'&m='+month+'&d='+day,
				onLoading : function() {
					$('loadBox').style.display = '';
					$('loadBox').innerHTML = '<img src="index/images/wait.gif" alt="" /> 세부일정을 불러들이는 중입니다...';
				},
				onComplete : function() {
					$('loadBox').style.display = '';
					$('loadBox').innerHTML = '<img src="index/images/accept.gif" alt="" /> 세부일정을 가져왔습니다!';
				},
				onSuccess : function(request) {
					$('loadBox').style.display = 'none';
					var lists = request.responseXML.getElementsByTagName('lists')[0];
					var subject = lists.getElementsByTagName('subject')[0].firstChild.nodeValue;
					var content = lists.getElementsByTagName('content')[0].firstChild.nodeValue;
					$('detailTitle').innerHTML = subject;
					$('detailList').innerHTML = content;
					Planner.toggle('viewDetail');
				},
				onFailure : function() {
					$('loadBox').style.display = '';
					$('loadBox').innerHTML = '<img src="index/images/cancel.gif" alt="" /> <span class="alert">일정을 가져오지 못했습니다.</span>';
					return false;
				}
			});
		} catch(e) { alert(e); }
	},
	getMemorial : function() {
		try {
			var request = new Ajax.Request('index/planner.get.memorial.php', {
				parameters : 'x=y',
				onLoading : function() {
					$('loadBox').style.display = '';
					$('loadBox').innerHTML = '<img src="index/images/wait.gif" alt="" /> 기념일을 불러들이는 중입니다...';
				},
				onComplete : function() {
					$('loadBox').style.display = '';
					$('loadBox').innerHTML = '<img src="index/images/accept.gif" alt="" /> 기념일들을 가져왔습니다!';
				},
				onSuccess : function(request) {
					$('loadBox').style.display = 'none';
					$('setDate').value = '';
					$('setSubject').value = '';
					$('setContent').value = '';
					$('setTarget').value = '';
					var lists = request.responseXML.getElementsByTagName('lists')[0].firstChild.nodeValue;
					$('memorialList').innerHTML = lists;
					if($('setMemorial').style.display == 'none') Planner.toggle('setMemorial');
				},
				onFailure : function() {
					$('loadBox').style.display = '';
					$('loadBox').innerHTML = '<img src="index/images/cancel.gif" alt="" /> <span class="alert">기념일을 가져오지 못했습니다.</span>';
					return false;
				}
			});
		} catch(e) { alert(e); }
	},
	replace : function(str1, str2, str3) {
		var r = new RegExp(str1, 'g');
		return str3.replace(r, str2);
	},
	filter : function(str) {
		if(!str) return '';
		str = this.replace('&', '@amp;', str);
		str = this.replace('\\+', '@plus;', str);
		str = this.replace('%', '@percent;', str);
		str = this.replace('#', '@sharp;', str);
		str = this.replace('\\?', '@question;', str);
		return str;
	},
	toggle : function(id) {
		if($(id).style.display == '') Effect.Fade(id);
		else {
			$(id).style.left = parseInt((parseInt(document.body.clientWidth) / 2) - 250)+'px';
			Effect.Appear(id);
		}
	},
	directAdd : function(year, month, day) {
		$('startDate').value = year+'-'+month+'-'+day;
		$('endDate').value = year+'-'+month+'-'+day;
		$('subject').value = '';
		$('content').value = '';
		$('modifyTarget').value = '';
		if($('addPlanBox').style.display == 'none') this.toggle('addPlanBox');
	},
	addPlan : function() {
		$('startDate').value = '';
		$('endDate').value = '';
		$('subject').value = '';
		$('content').value = '';
		$('modifyTarget').value = '';
		if($('addPlanBox').style.display == 'none') this.toggle('addPlanBox');
	}
};