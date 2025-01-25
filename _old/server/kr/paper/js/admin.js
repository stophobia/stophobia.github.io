/*
	GR Paper 관리자 화면 스크립트 처리
	작성자: 박희근 (http://sirini.net)
	수정일: 2008-12-7
	내  용: 관리자 화면에 사용되는 각종 스크립트 효과, Ajax 등 처리
	참  고: 이 스크립트는 prototype + script.aculo.us 가 먼저 선언되어야 함.
*/
var Admin = {
	toggle : function(view) {
		var panels = ["welcome", "feedManage", "skinManage", "botManage", "grSeriesManage", "logList"];
		for(i=0; i<panels.length; i++) {
			if(panels[i] != view) $(panels[i]).hide();
			else $(panels[i]).show();
		}
	},
	
	strReplace : function(str1, str2, str3)
	{
		var r = new RegExp(str1, 'g');
		return str3.replace(r, str2);
	},
	
	htmlencode : function(str)
	{
		str = this.strReplace('&', "@amp;", str);
		str = this.strReplace("\\+", "@plus;", str);
		str = this.strReplace("\\\\", "@rslash;", str);
		str = this.strReplace('%', "@percent;", str);
		str = this.strReplace('#', "@sharp;", str);
		return str;
	},
	
	addFeed : function() {
		var url = $F("feedUrl");
		if(!url) {
			alert("추가할 RSS 피드 주소를 입력해 주세요.");
			return false;
		}
		url = this.strReplace("http://", "", url); 
		var isOpen = $F("isOpen");
		var groupUid = $F("groupUid");
		if(!isOpen) isOpen = 0;
		var request = new Ajax.Request("add.feed.ok.php", {
			parameters: "url="+url+"&isOpen="+isOpen+"&groupUid="+groupUid,
			onSuccess : function(request) {
				var answer = request.responseXML.getElementsByTagName("grpaper")[0].getElementsByTagName("result")[0].firstChild.nodeValue;
				if(answer != "false") {
					var addLi = document.createElement("li");
					addLi.innerHTML = answer;
					$("feedList").appendChild(addLi);
					alert("RSS 피드를 추가하였습니다. 곧 수집을 시작합니다.");
				} else {
					alert("피드 추가를 하지 못했습니다. 이미 추가했거나, 유효하지 않은 피드 주소입니다.\n\n혹은 로그인이 풀렸을 수 있습니다. (이 때엔 새로고침을 해보세요)");
					return false;
				}
			}
		});		
	},

	getForm : function(form, element) {
		return document.forms[form].elements[element].value;
	},

	addFeedPopup : function() {
		var url = this.getForm("panelForm", "feedUrl");
		if(!url) {
			alert("추가할 RSS 피드 주소를 입력해 주세요.");
			return false;
		}
		url = this.strReplace("http://", "", url); 
		var isOpen = this.getForm("panelForm", "isOpen");
		var groupUid = this.getForm("panelForm", "groupUid");
		if(!isOpen) isOpen = 0;
		var request = new Ajax.Request("../admin/add.feed.ok.php", {
			parameters: "url="+url+"&isOpen="+isOpen+"&groupUid="+groupUid+"&isGuestAdd=true",
			onSuccess : function(request) {
				var answer = request.responseXML.getElementsByTagName("grpaper")[0].getElementsByTagName("result")[0].firstChild.nodeValue;
				if(answer != "false") {
					alert("RSS 피드를 추가하였습니다. 곧 수집을 시작합니다.");
				} else {
					alert("피드 추가를 하지 못했습니다. 이미 추가했거나, 유효하지 않은 피드 주소입니다.");
					return false;
				}
			}
		});		
	},
	
	deleteFeed : function(uid) {
		if(confirm("정말로 이 RSS피드를 삭제하시겠습니까?")) {
			var deleteAll = 0;
			if(confirm("그 동안 이 RSS피드에서 수집된 데이터들도 모두 삭제하시겠습니까?\n\n"+
				"추후 이 RSS피드를 다시 추가하시는 경우라면, '아니오(No/Cancel)'를 눌러주세요.\n\n"+
				"'예(Yes/OK)' 를 누르실 경우 이 RSS피드에서 수집된 데이터들도 모두 삭제합니다.")) {
				deleteAll = 1;
			}
			var request = new Ajax.Request("delete.feed.ok.php", {
				parameters: "uid="+uid+"&deleteAll="+deleteAll,
				onSuccess : function(request) {
					var answer = request.responseXML.getElementsByTagName("grpaper")[0].getElementsByTagName("result")[0].firstChild.nodeValue;
					if(answer != "false") {
						$("rss"+uid).style.display = "none";
						alert("선택하신 RSS피드를 삭제하였습니다.");
					} else {
						alert("삭제 작업을 완료하지 못했습니다. 이미 삭제되었을 수 있습니다.\n\n혹은 로그인이 풀렸을 수 있습니다. (이 때엔 새로고침을 해보세요)");
					}
				}
			});
		}
	},
	
	modifyGroup : function(uid, name, info) {
		$("modifyUid").value = uid;
		$("groupName").value = name;
		$("groupInfo").value = info;
		$("btnGroup").value = "수정하기";
	},
	
	addGroup : function() {
		var modifyUid = $F("modifyUid");
		var groupName = this.htmlencode($F("groupName"));
		var groupInfo = this.htmlencode($F("groupInfo"));
		if(modifyUid) var msg = "수정";
		else var msg = "추가";
		if(!groupName) {
			alert(msg+"할 그룹명을 적어주세요.");
			return false;
		}
		if(!groupInfo) {
			alert(msg+"할 그룹정보(설명)를 적어주세요.");
			return false;
		}
		var request = new Ajax.Request("add.group.ok.php", {
			parameters: "modifyUid="+modifyUid+"&groupName="+groupName+"&groupInfo="+groupInfo,
			onSuccess : function(request) {
				var answer = request.responseXML.getElementsByTagName("grpaper")[0].getElementsByTagName("result")[0].firstChild.nodeValue;
				if(answer != "false") {
					if(modifyUid) alert("그룹정보를 수정하였습니다.");
					else alert("새로운 그룹을 추가하였습니다.");
					location.href="./?work2";
				} else {
					alert("삭제 작업을 완료하지 못했습니다. 이미 삭제되었을 수 있습니다.\n\n혹은 로그인이 풀렸을 수 있습니다. (이 때엔 새로고침을 해보세요)");
				}
			}
		});
	},
	
	deleteGroup : function(uid) {
		if(confirm("정말로 이 그룹을 삭제하시겠습니까?\n\n그룹에 속한 피드들은 삭제되지 않으며, 모두 기본그룹으로 변경됩니다.")) {
			if(uid == 1) {
				alert("기본 그룹은 삭제하실 수 없습니다. 수정만 가능합니다.");
				return false;
			}
			var request = new Ajax.Request("delete.group.ok.php", {
				parameters: "uid="+uid,
				onSuccess : function(request) {
					var answer = request.responseXML.getElementsByTagName("grpaper")[0].getElementsByTagName("result")[0].firstChild.nodeValue;
					if(answer != "false") {
						$("group"+uid).style.display = "none";
						alert("선택하신 그룹을 삭제하였습니다.");
						location.href="./?work2";
					} else {
						alert("삭제 작업을 완료하지 못했습니다. 이미 삭제되었을 수 있습니다.\n\n혹은 로그인이 풀렸을 수 있습니다. (이 때엔 새로고침을 해보세요)");
					}
				}
			});
		}
	},
	
	skinConfig : function(id, type) {
		if(type == "check") {
			var originalVar = (document.forms['panelForm'].elements[id].checked)?1:0;
			var value = originalVar;
		} else {
			var originalVar = $F(id);
			var value = this.htmlencode(originalVar);
		}
		if(type == "number") {
			if(!parseInt(originalVar) && (originalVar != "0")) {
				alert("숫자만 입력 가능합니다.");
				return false;
			}
			value = parseInt(originalVar);
		}
		var request = new Ajax.Request("skin.config.ok.php", {
			parameters: "id="+id+"&value="+value,
			onSuccess : function(request) {
				var answer = request.responseXML.getElementsByTagName("grpaper")[0].getElementsByTagName("result")[0].firstChild.nodeValue;
				if(answer != "false") {
					$(id+"Result").innerHTML = "변경완료. ("+originalVar+")";
					if(type == "text") $(id).value = originalVar;
				} else {
					alert("스킨 설정을 수정하지 못했습니다. DB 작업에 에러가 발생했습니다.\n\n혹은 로그인이 풀렸을 수 있습니다. (이 때엔 새로고침을 해보세요)");
				}
			}
		});
	},

	cacheReload : function() {
		var request = new Ajax.Request("cache.reload.ok.php", {
			parameters: "x=1",
			onSuccess : function(request) {
				var answer = request.responseXML.getElementsByTagName("grpaper")[0].getElementsByTagName("result")[0].firstChild.nodeValue;
				if(answer == "true") {
					$("cacheReloadResult").innerHTML = "현재의 HTML 캐쉬를 모두 비웠습니다.";
				}
			}
		});
	},

	runAggregator : function() {
		var request = new Ajax.Request("../aggregator.php", {
			parameters: "x=1&just=1",
			onSuccess: function(request) {}
		});
		$('runAggregatorResult').innerHTML = '수집기가 RSS수집을 시작했습니다.';
	},

	feedValid : function() {
		if(!confirm("수집되지 않는 피드들을 찾아서 수집대상에서 삭제합니다.\n\n일시적으로 접속이 안되는 경우에도 삭제대상에 포함됩니다.\n\n수집이 안되는 피드를 지금 정리할까요?")) {
			return false;
		} else $("feedValidResult").innerHTML = "수집 안되는 RSS 정리를 시작합니다.";
		var request = new Ajax.Request("feed.valid.ok.php", {
			parameters: "x=1",
			onSuccess: function(request) {
				var answer = request.responseXML.getElementsByTagName("grpaper")[0].getElementsByTagName("result")[0].firstChild.nodeValue;
				if(answer == "true") {
					$("feedValidResult").innerHTML = "수집 안되는 RSS를 정리했습니다.";
				}
			}
		});
	},
	
	feedReload : function() {
		var request = new Ajax.Request("feed.reload.ok.php", {
			parameters: "x=1",
			onSuccess: function(request) {
				var answer = request.responseXML.getElementsByTagName("grpaper")[0].getElementsByTagName("result")[0].firstChild.nodeValue;
				if(answer == "true") {
					$("feedReloadResult").innerHTML = "글들을 모두 정리했습니다.";
				}	
			}
		});
	},

	newPassword : function() {
		var request = new Ajax.Request("new.password.ok.php", {
			parameters: "password="+$F('newPassword'),
			onSuccess: function(request) {
				var answer = request.responseXML.getElementsByTagName("grpaper")[0].getElementsByTagName("result")[0].firstChild.nodeValue;
				if(answer == "true") {
					$("newPasswordResult").innerHTML = "비밀번호를 변경했습니다.";
				}	
			}
		});
	},
	
	deleteThumbnail : function() {
		if(confirm("정말로 별도 보관중인 그림들을 모두 삭제하시겠습니까?")) {
			var request = new Ajax.Request("delete.thumbnail.ok.php", {
				parameters: "x=1",
				onSuccess: function(request) {
					var answer = request.responseXML.getElementsByTagName("grpaper")[0].getElementsByTagName("result")[0].firstChild.nodeValue;
					if(answer == "true") {
						$("deleteThumbnailResult").innerHTML = "그림들을 모두 정리했습니다.";
					}	
				}
			});
		}
	},

	deleteTag : function() {
		if(confirm("정말로 별도 보관중인 태그들을 모두 삭제하시겠습니까?")) {
			var request = new Ajax.Request("delete.tag.ok.php", {
				parameters: "x=1",
				onSuccess: function(request) {
					var answer = request.responseXML.getElementsByTagName("grpaper")[0].getElementsByTagName("result")[0].firstChild.nodeValue;
					if(answer == "true") {
						$("deleteTagResult").innerHTML = "태그들을 모두 정리했습니다.";
					}	
				}
			});
		}
	},

	sessClean : function() {
		var request = new Ajax.Request("delete.session.ok.php", {
			parameters: "x=1",
			onSuccess: function(request) {
				var answer = request.responseXML.getElementsByTagName("grpaper")[0].getElementsByTagName("result")[0].firstChild.nodeValue;
				if(answer == "true") {
					$("sessCleanResult").innerHTML = "세션을 모두 정리했습니다.";
				}	
			}
		});
	},

	deletePost : function() {
		if(confirm("정말로 그 간 수집했던 포스트들을 모두 삭제하시겠습니까?\n\n별도 수집된 태그와 그림은 따로 삭제하셔야 합니다.\n\n삭제를 진행하시겠습니까?")) {
			var request = new Ajax.Request("delete.post.ok.php", {
				parameters: "x=1",
				onSuccess: function(request) {
					var answer = request.responseXML.getElementsByTagName("grpaper")[0].getElementsByTagName("result")[0].firstChild.nodeValue;
					if(answer == "true") {
						$("deletePostResult").innerHTML = "포스트를 모두 삭제했습니다.";
					}	
				}
			});
		}
	},

	addOPML : function() {
		if(!$F('opml')) {
			alert('OPML 문서를 첨부해주세요.');
			return false;
		}
		else return true;
	},

	deleteLog : function() {
		var request = new Ajax.Request("delete.log.ok.php", {
			parameters: "x=1",
			onSuccess: function(request) {
				var answer = request.responseXML.getElementsByTagName("grpaper")[0].getElementsByTagName("result")[0].firstChild.nodeValue;
				if(answer == "true") {
					$("deleteLogResult").innerHTML = "수집 기록을 모두 삭제했습니다.";
				}	
			}
		});
	}
}
