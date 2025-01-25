if(navigator.userAgent.indexOf('iPhone') > 0 ||
	navigator.userAgent.indexOf('iPod') > 0 ||
	navigator.userAgent.indexOf('android') > 0) { // iPhone 용 페이지로 이동할 것인지 묻기
	if(confirm('모바일 버젼으로 보시겠습니까?')) {
		location.href='./m';
	}
}

var Skin = {
	getMember : function(tNo, myNo, grboard, id, e) {		
		var evt = e || window.event;
		var d = document.documentElement;
		var bd = document.body;
		MOUSE_X_POS = evt.pageX || (evt.clientX + (bd.scrollLeft || d.scrollLeft) - (d.clientLeft || 0));
		MOUSE_Y_POS = evt.pageY || (evt.clientY + (bd.scrollTop || d.scrollTop) - (d.clientTop || 0));
		showBox = document.getElementById('viewMemberInfo');
		showBox.style.display = 'none';
		showBox.style.left = MOUSE_X_POS+'px';
		showBox.style.top = MOUSE_Y_POS+'px';
		$('#viewMemberInfo').show("slow");
		if(tNo == '0') {
			showBox.innerHTML = '<div>비회원임</div>';
			return;
		}
		if(myNo == '') {
			showBox.innerHTML = '<div>로그인 하세요!</div>';
			return;
		}

		$.ajax({
			url: grboard + "/get_member_info.php",
			global: false,
			type: "POST",
			data: "no="+tNo,
			dataType: "xml",
			success: function(rqt) {
				var lists = rqt.getElementsByTagName('lists')[0];
				var items = lists.getElementsByTagName('item');
				var result = '';
				for(i=0; i<items.length; i++) {
					var no = items[i].getAttribute('no');
					var email = items[i].getElementsByTagName('email')[0].firstChild.nodeValue;
					var homepage = items[i].getElementsByTagName('homepage')[0].firstChild.nodeValue;
					if(id) {
						result += '<div><a href="'+grboard+'board.php?id='+id+'&searchOption=member_key&searchText='+no+'" title="이 멤버가 쓴 글만 따로 정렬합니다."><img src="'+grboard+'/image/icon/sort_this_member.gif" alt="" /> 다른글 보기</a></div>';
					}
					result += '<div><a href="#" onclick="window.open(\''+grboard+'/send_memo.php?target='+no+'\', \'sendMemo\', \'width=650,height=600,menubar=no,scrollbars=yes\');"><img src="'+grboard+'/image/icon/send_memo_icon.gif" alt="" /> 쪽지 보내기</a></div><div><a href="mailto:'+email+'"><img src="'+grboard+'/image/icon/send_email_icon.gif" alt="" /> 메일 보내기</a></div>';
					if(myNo == '1') {
						result += '<div><a href="#" onclick="window.open(\''+grboard+'/get_member_article.php?user='+no+'\', \'getMemberArticle\', \'menubar=no,scrollbars=yes,resizable=yes,width=965,height=600\');"><img src="'+grboard+'/image/icon/article_trace_icon.gif" alt="" /> 게시글 추적</a></div>';
					}
					if(homepage != '0') result += '<div><a href="'+homepage+'" onclick="window.open(this.href, \'_blank\'); return false"><img src="'+grboard+'/image/icon/visit_homepage_icon.gif" alt="" /> 홈 페 이 지</a></div>';
					result += '<div><a href="#" onclick="window.open(\''+grboard+'/member_info.php?memberKey='+no+'\', \'viewMemberInfo\', \'width=650,height=600,menubar=no,scrollbars=yes\');"><img src="'+grboard+'/image/icon/view_more_icon.gif" alt="" /> 회 원 정 보</a></div>';
				}
				showBox.innerHTML = result;
			}
		});
	},

	showOff : function() {
		setTimeout(function(){$('#viewMemberInfo').hide("slow");}, 7000);
	}
}