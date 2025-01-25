// RSS 고유번호 전역
var RSS_UID = 0;

// 링크삭제
function delLink(uid)
{
	if(confirm('정말로 이 링크를 삭제하시겠습니까?')) {
		location.href='admin.php?admin=3&deleteTarget='+uid;
	}
}
// 링크 추가/수정 검사
function link_add()
{
	t = document.forms['link'];
	if(!t.elements['url'].value) {
		alert('링크 주소를 입력해 주세요');
		t.elements['url'].focus();
		return false;
	}
	if(!t.elements['name'].value) {
		alert('해당 링크의 사이트(블로그) 이름을 입력해 주세요');
		t.elements['name'].focus();
		return false;
	}
	if(!t.elements['info'].value) {
		alert('해당 링크의 설명을 적어주세요');
		t.elements['info'].focus();
		return false;
	}
	return true;
}
// RSS 추가/수정 검사
function rss_add()
{
	t = document.forms['link'];
	if(!t.elements['url'].value) {
		alert('RSS 주소를 입력해 주세요');
		t.elements['url'].focus();
		return false;
	}
	if(!t.elements['name'].value) {
		alert('해당 링크의 사이트(블로그) 이름을 입력해 주세요');
		t.elements['name'].focus();
		return false;
	}
	return true;
}
// 선택된 RSS 주소 삭제
function rss_delete()
{
	if(!RSS_UID) {
		alert('RSS를 선택해 주세요.');
		return;
	}
	if(confirm('선택하신 RSS를 삭제하시겠습니까?')) {
		location.href = 'admin.php?admin=17&deleteTarget='+RSS_UID;
	}
}
// 재정렬
function resort()
{
	var c = 0;
	var str = '';
	t = document.forms['sorting'];
	for(i=0; i<t.length; i++) {
		if(t.elements[i].type == 'checkbox' && t.elements[i].checked == true) {
			c++;
			str += t.elements[i].value+';';
		}
	}
	if(c < 2) {
		return;
	} else if(c == 2) {
		location.href='admin.php?admin=3&change='+str;
	}
}
// RSS 가져오기
function getRSS(url, no, blogName)
{
	if(!url) return;
	RSS_UID = no;
	document.forms['link'].elements['mt'].value = no;
	document.forms['link'].elements['url'].value = url;
	document.forms['link'].elements['name'].value = blogName;
	var req = new Ajax.Request('get_rss.php', {
		parameters : 'url='+url,
		onLoading : function() {
			$('loadBox').style.display = '';
			$('loadBox').innerHTML = '<img src="image/wait.gif" alt="" /> RSS를 가져오는 중입니다...';
		},
		onComplete : function() {
			$('loadBox').innerHTML = 'RSS를 불러들였습니다.';
		},
		onSuccess : function(req) {
			$('loadBox').style.display = 'none';
			try {
				var result = '<div id="blogRSS">';
				var ch = req.responseXML.getElementsByTagName('channel')[0];
				var blogTitle = ch.getElementsByTagName('title')[0].firstChild.nodeValue;
				var blogLink = ch.getElementsByTagName('link')[0].firstChild.nodeValue;
				var blogInfo = ch.getElementsByTagName('description')[0].firstChild.nodeValue;
				var blogItem = ch.getElementsByTagName('item');
				result += '<div id="blogTitle"><a href="'+blogLink+'">'+blogTitle+'</a></div>';
				result += '<div id="blogInfo">'+blogInfo+'</div>';
				for(i=0; i<blogItem.length; i++) {
					result += '<div class="title"><a href="'+blogItem[i].getElementsByTagName('link')[0].firstChild.nodeValue+'">'+blogItem[i].getElementsByTagName('title')[0].firstChild.nodeValue+'</a></div>';
					result += '<div class="content">'+blogItem[i].getElementsByTagName('description')[0].firstChild.nodeValue+'</div>';
					result += '<div class="tag">분류(꼬리표): '+blogItem[i].getElementsByTagName('category')[0].firstChild.nodeValue+'</div>';
				}
				result += '</div>';
				$('rssList').innerHTML = result;
			} catch(e) { alert(e); }
			return false;
		},
		onFailure : function() {
			$('loadBox').style.display = '';
			$('loadBox').innerHTML = '<span style="color: red">RSS를 가져오지 못했습니다.</span>';
		}
	});
}
// 문자열 치환
function str_replace(str1, str2, str3)
{
	var r = new RegExp(str1, 'g');
	return str3.replace(r, str2);
}