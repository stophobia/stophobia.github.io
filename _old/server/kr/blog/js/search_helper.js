// xmlHttpRequest 객체 할당
function getXHR()
{
	var rq = false;
	if (window.XMLHttpRequest) {
		rq = new XMLHttpRequest();
	} else if (window.ActiveXObject) {
		try {
			rq = new ActiveXObject('Msxml2.XMLHTTP');
		} catch (e1) {
			try {
				rq = new ActiveXObject('Microsoft.XMLHTTP');
			} catch (e2) {
				return false;
			}
		}
	}
	return rq;
}

// 출력을 위한 콜백
function callBackMe()
{
	if(req.readyState == 1) {
		showLoading();
	} else if(req.readyState == 4) {
		if(req.status == 200) {
			showResult();
		} else {
			alert('문제가 발생했습니다 : '+req.statusText);
		}
	}
}

// 검색어 입력이 시작될 때 호출
function startSearch()
{
	f = document.forms['searchBox'];
	searchText = f.elements['st'].value;
	searchOption = f.elements['so'].value;
	if(searchText) {
		req = getXHR();
		req.onreadystatechange = callBackMe;
		req.open('POST', 'search_helper.php', true);
		req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		req.send('st='+searchText+'&so='+searchOption);
	}
}

// 검색 결과를 보여주기
function showResult()
{
	var lists = req.responseXML.getElementsByTagName('lists')[0];
	var showBox = document.getElementById('searchIndex');
	var result = '';
	showBox.style.display = '';
	showBox.style.position = 'absolute';
	showBox.style.zIndex = 50;
	showBox.innerHTML = '';

	var items = lists.getElementsByTagName('item');

	for(i=0; i<items.length; i++) {
		var no = items[i].getAttribute('no');
		var title = items[i].getElementsByTagName('title')[0].firstChild.nodeValue;
		title = htmlspecialchars(title);
		result += '<div class="list"><a href="./?p='+no+'" title="보러가기">';
		result += title+'</a></div>';
	}
	result += '<div class="list" style="text-align: right"><a href="#" title="검색 도우미를 닫습니다." onclick="clearBox();">[닫기]</a></div>';
	showBox.innerHTML = result;
}

// 로딩 시 보여주기
function showLoading()
{
	var showBox = document.getElementById('searchIndex');
	var result = '';
	showBox.style.display = '';
	showBox.innerHTML = '<img src="image/wait.gif" alt="loading" style="vertical-align: middle" /> 찾고 있습니다...';
}

// 문자열 치환
function str_replace(str1, str2, str3)
{
	var r = new RegExp(str1, 'g');
	return str3.replace(r, str2);
}

// 검색 결과값 처리
function htmlspecialchars(str)
{
	result = str_replace('<', '&lt;', str);
	result = str_replace('>', '&gt;', result);
	return result;
}

// 검색 박스 클리어
function clearBox()
{
	Effect.BlindUp('searchIndex');
}