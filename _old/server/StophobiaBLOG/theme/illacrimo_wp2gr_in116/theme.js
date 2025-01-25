// 코멘트 작성 체크
function comment(uid, n)
{
	tinyMCE.triggerSave();
	t = document.forms['writeComment'+uid];
	s = $('normalAuth'+uid);
	if(!n && !t.elements['antispam'].value && t.elements['chooseAuth'].value == 0) {
		alert('자동등록방지 수식 결과값을 입력해 주십시오. (예: 2+3=? 에서 5)');
		if(s.style.display == 'none') {
			t.elements['chooseAuth'][0].checked = true;
			more('normalAuth'+uid);
		}
		return false;
	}
	if(!n && !t.elements['name'].value && t.elements['chooseAuth'].value == 0) {
		alert('이름(혹은 닉네임)을 입력해 주십시오.');
		return false;
	}
	if(!n && !t.elements['password'].value && t.elements['chooseAuth'].value == 0) {
		alert('비밀번호를 입력해 주세요! 자신의 댓글을 삭제하실 수 있습니다.');
		return false;
	}
	if(!t.elements['content'].value) {
		alert('남기고 싶으신 말씀을 입력해 주십시오.');
		return false;
	}
	if(!n && !t.elements['openid_url'].value && t.elements['chooseAuth'].value == 1) {
		alert('손님의 오픈아이디(예: myopenid.myid.net) 를 입력해 주세요');
		return false;
	}
	return true;
}

// 토글
function more(id)
{
	t = $(id);
	if(t.style.display == '') {
		t.style.display = 'none';
	} else {
		t.style.display = '';
	}
}

// 토글 for 댓글달기
function choose(id, hideID)
{
	t = $(id);
	h = $(hideID);
	if(t.style.display == '') {
		t.style.display = 'none';
	} else {
		t.style.display = '';
	}
	if(h.style.display == '') h.style.display = 'none';
}

// 댓글 비번 확인
function checkCoPass(n)
{
	if(confirm('정말로 댓글을 삭제하시겠습니까?')) {
		more('enterPass'+n);
	}
}

// 트랙백 주소 복사
function clickToCopy(str) 
{
	prompt("이 글의 고유주소입니다. Ctrl+C를 눌러 복사하세요.", str);
}

// 비번 입력 여부
function isValidPass(t)
{
	if(!t.elements['coPass'].value) {
		alert('비밀번호를 입력해 주세요.');
		t.elements['coPass'].focus();
		return false;
	}
}

// 방명록 작성 체크
function chkGuest(flag, isAdmin)
{
	t = document.forms['guest'];
	if(!t.elements['name'].value) {
		alert('이름을 입력해 주세요');
		t.elements['name'].focus();
		return false;
	}
	if(!t.elements['password'].value) {
		alert('비밀번호를 입력해 주세요');
		t.elements['password'].focus();
		return false;
	}
	if(!isAdmin && !t.elements['content'].value) {
		alert('내용을 입력해 주세요');
		t.elements['content'].focus();
		return false;
	}
	if(flag && !t.elements['antispam'].value) {
		alert('자동등록방지용 8자리 코드를 입력해 주세요');
		t.elements['antispam'].focus();
		return false;
	}
	return true;
}

// 방명록 삭제
function isGuestbookDelete(n, path)
{
	if(confirm('정말로 선택하신 글을 삭제하시겠습니까?\n\n연관된 답글까지 모두 삭제됩니다.')) {
		location.href = path+'?deleteTarget='+n;
	}
}

// 방명록 댓글 삭제
function isGuestbookReplyDelete(n, path)
{
	if(confirm('정말로 선택하신 답글을 삭제하시겠습니까?')) {
		location.href = path+'?deleteTarget='+n;
	}
}

// 자동등록방지코드 클릭 입력
function pasteCode(n, code)
{
	document.forms['writeComment'+n].elements['antispam'].value = code;
}

// 자동등록방지코드 클릭 입력 (방명록)
function pasteCodeGuest(code)
{
	document.forms['guest'].elements['antispam'].value = code;
}

// 문자열 치환
function str_replace(str1, str2, str3)
{
	var r = new RegExp(str1, 'g');
	return str3.replace(r, str2);
}

// Twitter 연동
if(TWITTER_RSS){
	var result = '<ul>';
	var request = new Ajax.Request(NOW_PATH+'admin/admin_get_twitter.php', {
		parameters : 'url='+TWITTER_RSS,				
		onSuccess : function(request) {
			var ch = request.responseXML.getElementsByTagName('rss')[0].getElementsByTagName('channel')[0];
			var lists = ch.getElementsByTagName('item');
			if(lists.length > TWITTER_COUNT) var limit = TWITTER_COUNT;
			else var limit = lists.length;
			for(i=0; i<limit; i++) {
				var title = str_replace(TWITTER_ID+':', '', lists[i].getElementsByTagName('title')[0].firstChild.nodeValue);
				var url = lists[i].getElementsByTagName('link')[0].firstChild.nodeValue;
				var date = lists[i].getElementsByTagName('pubDate')[0].firstChild.nodeValue;
				result += '<li><a href="'+url+'" onclick="window.open(this.href, \'_blank\'); return false" title="작성시간: '+date+'">'+title+'</a></li>';
			}
			result += '</ul>';
			$('myTwitter').innerHTML = result;
		}
	});
}

// highslide JS
try {
	hs.graphicsDir = GRBLOG+'image/graphics/';
	hs.creditsText = '';
	hs.align = 'center';
	hs.transitions = ['expand', 'crossfade'];
	hs.outlineType = 'rounded-white';
	hs.fadeInOut = true;
	hs.numberPosition = 'caption';
	hs.dimmingOpacity = 0.75;
		
	// Add the controlbar
	if (hs.addSlideshow) hs.addSlideshow({
		interval: 5000,
		repeat: false,
		useControls: true,
		fixedControls: true,
		overlayOptions: {
			opacity: .75,
			position: 'top center',
			hideOnMouseOut: true
		}
	});
} catch(e) {}

// hover event
sfHover = function() {
	var sfEls = document.getElementById("nav").getElementsByTagName("LI");
	for (var i=0; i<sfEls.length; i++) {
		sfEls[i].onmouseover=function() {
			this.className+=" hover";
		}
		sfEls[i].onmouseout=function() {
			this.className=this.className.replace(new RegExp(" hover\\b"), "");
		}
	}
}
if (window.attachEvent) window.attachEvent("onload", sfHover);