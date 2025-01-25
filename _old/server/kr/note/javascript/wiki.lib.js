var Wiki = {
	formValue : function(name) {
		return document.forms['wikiWrite'].elements[name].value;
	},
	search : function() {
		if($('searchBox').style.display == 'none') Effect.Appear('searchBox');
		else Effect.Fade('searchBox');
	},
	searching : function() {
		if(!document.forms['search'].elements['searchText'].value) {
			alert('검색할 단어를 입력하세요.');
			document.forms['search'].elements['searchText'].style.backgroundColor='#f9e8e8';
			document.forms['search'].elements['searchText'].focus();
			return false;
		}
		try {
			var request = new Ajax.Request('index/wiki.search.php', {
				parameters : 'searchOption='+document.forms['search'].elements['searchOption'].value+'&searchText='+document.forms['search'].elements['searchText'].value,
				onLoading : function() {
					if(nowStatus) {
						$('loadBox').style.display = '';
						$('loadBox').innerHTML = '<img src="index/images/wait.gif" alt="" /> 위키 문서를 검색중입니다...';
					}
				},
				onComplete : function() {
					if(nowStatus) {
						$('loadBox').style.display = '';
						$('loadBox').innerHTML = '<img src="index/images/accept.gif" alt="" /> DB서버로부터 응답을 받았습니다!';
					}
				},
				onSuccess : function(request) {
					var lists = request.responseXML.getElementsByTagName('lists')[0];
					var content = lists.getElementsByTagName('content')[0].firstChild.nodeValue;
					$('loadBox').style.display = 'none';
					if($('wikiHistory').style.display == 'none') Effect.Appear('wikiHistory');
					$('wikiHistory').innerHTML = content+'<div id="closeWindow"><a href="#" onclick="Effect.Fade(\'wikiHistory\');"><img src="index/images/close.gif" alt="닫기" /></a></div>';
					nowStatus = true;
					return false;
				},
				onFailure : function() {
					nowStatus = false;
					$('loadBox').style.display = '';
					$('loadBox').innerHTML = '<img src="index/images/cancel.gif" alt="" /> <span class="alert">이전 문서를 조회하지 못했습니다.</span>';
					return false;
				}
			});
		} catch(e) { alert(e);	}
		return false;
	},
	docHistory : function(uid) {
		var nowStatus = true;
		try {
			var request = new Ajax.Request('index/wiki.history.php', {
				parameters : 'uid='+uid,
				onLoading : function() {
					if(nowStatus) {
						$('loadBox').style.display = '';
						$('loadBox').innerHTML = '<img src="index/images/wait.gif" alt="" /> 이 문서의 이전 버젼을 찾습니다...';
					}
				},
				onComplete : function() {
					if(nowStatus) {
						$('loadBox').style.display = '';
						$('loadBox').innerHTML = '<img src="index/images/accept.gif" alt="" /> 이전 문서를 찾았습니다!';
					}
				},
				onSuccess : function(request) {
					var lists = request.responseXML.getElementsByTagName('lists')[0];
					var error = parseInt(lists.getElementsByTagName('error')[0].firstChild.nodeValue);
					var content = lists.getElementsByTagName('content')[0].firstChild.nodeValue;
					var signdate = lists.getElementsByTagName('signdate')[0].firstChild.nodeValue;
					var master_doc = lists.getElementsByTagName('master_doc')[0].firstChild.nodeValue;
					var keyword = lists.getElementsByTagName('keyword')[0].firstChild.nodeValue;
					if(error) {
						alert('이 문서의 이전 버젼이 없습니다.');
						nowStatus = false;
						$('loadBox').style.display = 'none';
						return false;
					}
					if($('wikiHistory').style.display == 'none') Effect.Appear('wikiHistory');
					$('wikiHistory').innerHTML = '<span class="b">`'+keyword+'` 문서의 이전버젼</span><br /><br />'+
						content+'<div id="historyBottom"><a href="#" onclick="Wiki.docHistory('+master_doc+');"><img src="index/images/backward.gif" alt="뒤로" />'+
						' 이전문서 계속검색</a> &nbsp;&nbsp; 작성일자: '+signdate+' &nbsp;&nbsp; <a href="./?m=wiki&amp;a=write&amp;k='+keyword+'&amp;modifyDocNo='+master_doc+'" title="이 문서를 수정하여 최신문서로 바꿉니다.">[이 문서를 최신문서로 수정하기]</a></div>'+
						'<div id="closeWindow"><a href="#" onclick="Effect.Fade(\'wikiHistory\');"><img src="index/images/close.gif" alt="닫기" /></a></div>';
					nowStatus = true;
				},
				onFailure : function() {
					nowStatus = false;
					$('loadBox').style.display = '';
					$('loadBox').innerHTML = '<img src="index/images/cancel.gif" alt="" /> <span class="alert">이전 문서를 조회하지 못했습니다.</span>';
					return false;
				}
			});
		} catch(e) { alert(e);	}
	},
	write : function() {
		tinyMCE.triggerSave();
		var nowStatus = true;
		if(!this.formValue('writer') && !this.formValue('antispam')) { 
			alert('자동등록방지용 산수 계산값을 입력해 주세요.');
			document.forms['wikiWrite'].elements['antispam'].style.backgroundColor='#f9e8e8';
			document.forms['wikiWrite'].elements['antispam'].focus();
			return false; 
		}
		try {
			var content = this.filter(this.formValue('content'));
			var keyword = this.filter(this.formValue('keyword'));
			var request = new Ajax.Request('index/wiki.insert.php', {
				parameters : 'writer='+this.formValue('writer')+'&modifyDocNo='+this.formValue('modifyDocNo')+'&antispam='+this.formValue('antispam')+'&keyword='+keyword+'&content='+content,
				onLoading : function() {
					if(nowStatus) {
						$('loadBox').style.display = '';
						$('loadBox').innerHTML = '<img src="index/images/wait.gif" alt="" /> DB에 기록중입니다...';
					}
				},
				onComplete : function() {
					if(nowStatus) {
						$('loadBox').style.display = '';
						$('loadBox').innerHTML = '<img src="index/images/accept.gif" alt="" /> 기록이 완료되었습니다!';
					}
				},
				onSuccess : function(request) {
					var lists = request.responseXML.getElementsByTagName('lists')[0];
					var error = parseInt(lists.getElementsByTagName('error')[0].firstChild.nodeValue);
					var p = lists.getElementsByTagName('p')[0].firstChild.nodeValue;
					if(error == 1) {
						alert('자동등록방지코드가 올바르지 않습니다. 다시 입력해 주세요.');
						nowStatus = false;
						$('loadBox').style.display = 'none';
						return false;
					} else if(error == 2) {
						alert('수정권한이 없습니다.');
						nowStatus = false;
						$('loadBox').style.display = 'none';
						return false;
					}
					location.href = './?m=wiki&a=view&p='+p;
					nowStatus = true;
				},
				onFailure : function() {
					nowStatus = false;
					$('loadBox').style.display = '';
					$('loadBox').innerHTML = '<img src="index/images/cancel.gif" alt="" /> <span class="alert">DB에 문서를 저장하지 못했습니다.</span>';
					return false;
				}
			});
		} catch(e) { alert(e);	}
		return false;
	},
	remove : function(uid) {
		if(confirm('정말로 이 문서를 삭제하시겠습니까?')) {
			try {
				var request = new Ajax.Request('index/wiki.delete.php', {
					parameters : 'docNo='+uid,
					onLoading : function() {
						if(nowStatus) {
							$('loadBox').style.display = '';
							$('loadBox').innerHTML = '<img src="index/images/wait.gif" alt="" /> 문서를 삭제중입니다...';
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
						location.href = './?m=wiki';
						nowStatus = true;
					},
					onFailure : function() {
						nowStatus = false;
						$('loadBox').style.display = '';
						$('loadBox').innerHTML = '<img src="index/images/cancel.gif" alt="" /> <span class="alert">문서를 지우지 못했습니다.</span>';
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
	wordToggle : function() {
		$('wikiLatestWord').style.right = '20px';
		$('wikiLatestWord').style.top = '50px';
		if($('wordList').style.display == '') {
			Effect.Fade('wordList');
			Effect.Appear('wordTitle');
			$('ctrlIcon').src = this.replace('less', 'more', $('ctrlIcon').src);
		} else {
			Effect.Appear('wordList');
			Effect.Fade('wordTitle');
			$('ctrlIcon').src = this.replace('more', 'less', $('ctrlIcon').src);
		}
	},
	upload : function(theme) {
		window.open('index/theme/'+theme+'/main.wiki.upload.form.php', 'upload', 'width=450,height=500,menubar=no,scrollbars=no');
	}
};