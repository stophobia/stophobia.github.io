// 변수들
var MORE_COUNT = 1;
var POST_MODE = 0;
var AUTO_SAVE = 0;
if(!WRITE) var WRITE = false;

// POST_MODE 변수 변경
function set_value(n)
{
	POST_MODE = n;
	AUTO_SAVE = 0;
}

// xmlHttpRequest 객체 할당
function getXHR()
{
	var rq = false;
	if(window.XMLHttpRequest) {
		rq = new XMLHttpRequest();
	} else if(window.ActiveXObject) {
		try {
			rq = new ActiveXObject('Msxml2.XMLHTTP');
		} catch(e1) {
			try {
				rq = new ActiveXObject('Microsoft.XMLHTTP');
			} catch(e2) {
				return false;
			}
		}
	}
	return rq;
}

// 글작성시
function post_write(write)
{
	tinyMCE.triggerSave();
	var status = POST_MODE;
	var t = document.forms['new_post'];
	var subject = t.elements['subject'].value;
	var postContent = t.elements[write+'content'].value;
	if(!subject || !postContent) return false;
	var category = t.elements['category'].value;
	var writeID = t.elements['writeID'].value;
	if(t.elements['open_rss'].checked == true) var open_rss = 1; else var open_rss = 0;
	if(t.elements['comment_condition'].checked == true) var comment_condition = 1; else var comment_condition = 0;
	if(t.elements['use_sync'].checked == true && status == 1) var use_sync = 1; else var use_sync = 0;
	if(t.elements['modify_time'].checked == true) var modify_time = 1; else var modify_time = 0;
	if(t.elements['make_html'].checked == true) var make_html = 1; else var make_html = 0;
	var tag = t.elements['tag'].value;
	var modifyTarget = t.elements['modifyTarget'].value;
	var sendTrackback = t.elements['trackback'].value;
	var writer = t.elements['writer'].value;
	var encoding = t.elements['encoding'].value;
	if(!subject) {
		alert('글 제목을 입력해 주세요');
		t.elements['subject'].focus();
		return false;
	}
	if(!postContent) {
		alert('글 내용을 입력해 주세요');
		return false;
	}
	var req = getXHR();
	req.onreadystatechange = function () {
		if(req.readyState == 1) {
			showLoading(1);
		} else if(req.readyState == 4) {
			document.getElementById('writeStatus').style.display = 'none';
			if(req.status == 200) {
				var showMsg = $('writeStatus');
				var modifyDIV = $('modifyDIV');
				var openRSS = $('openRSS');
				var useSync = $('useSync');
				var commentCondition = $('commentCondition');
				var modifyTime = $('modifyTime');
				var lists = req.responseXML.getElementsByTagName('lists')[0];
				var msg = lists.getElementsByTagName('msg')[0].firstChild.nodeValue;
				var muid = lists.getElementsByTagName('msg')[0].getAttribute('muid');
				var open_rss = lists.getElementsByTagName('open_rss')[0].firstChild.nodeValue;
				var c_condition = lists.getElementsByTagName('c_condition')[0].firstChild.nodeValue;
				var use_sync = lists.getElementsByTagName('use_sync')[0].firstChild.nodeValue;
				var modify_time = lists.getElementsByTagName('modify_time')[0].firstChild.nodeValue;
				showMsg.style.display = '';
				showMsg.innerHTML = msg;
				modifyDIV.innerHTML = '<input type="hidden" name="modifyTarget" value="'+muid+'" />';
				if(open_rss == 1) openRSS.innerHTML = '<input type="checkbox" name="open_rss" value="1" checked="checked" /> RSS 에 공개';
				else openRSS.innerHTML = '<input type="checkbox" name="open_rss" value="1" /> RSS 에 공개';
				if(c_condition == 1) commentCondition.innerHTML = '<input type="checkbox" name="comment_condition" value="1" checked="checked" /> 코멘트,트랙백 허용';
				else commentCondition.innerHTML = '<input type="checkbox" name="comment_condition" value="1" /> 코멘트,트랙백 허용';
				if(use_sync == 1 && !modifyTarget) useSync.innerHTML = '<input type="checkbox" name="use_sync" value="1" checked="checked" /> 싱크넷에 출판하기';
				else useSync.innerHTML = '<input type="checkbox" name="use_sync" value="1" /> 싱크넷에 출판하기';
				if(modify_time == 1 && !modifyTarget) modifyTime.innerHTML = '<input type="checkbox" name="modify_time" value="1" checked="checked" /> 작성시간 업데이트';
				else modifyTime.innerHTML = '<input type="checkbox" name="modify_time" value="1" /> 작성시간 업데이트';
			} else {
				alert('문제가 생겼습니다: '+req.statusText);
			}
		}
	}
	req.open('POST', 'admin/admin_insert.php', true);
	req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	subject = htmlencode(subject);
	postContent = htmlencode(str_replace('<p>', '', str_replace('</p>', '<br />', str_replace('<p>&nbsp;</p>', '<br />', postContent))));
	sendTrackback = htmlencode(sendTrackback);
	tag = htmlencode(tag);
	var sendQue = 'subject='+subject+'&content='+postContent+'&category='+category+
		'&open_rss='+open_rss+'&comment_condition='+comment_condition+
		'&tag='+tag+'&trackback='+sendTrackback+'&post_condition='+status+'&postStart=1'+
		'&modifyTarget='+modifyTarget+'&name='+writer+'&use_sync='+use_sync+
		'&modifyTime='+modify_time+'&writeID='+writeID+'&makeHTML='+make_html+'&encoding='+encoding+'&is_autosave='+AUTO_SAVE;
	req.send(sendQue);
	return false;
}

// 카테고리 추가
function addCategory()
{
	var t = document.forms['new_post'].elements['addNewCategory'];
	var _c = document.forms['new_post'].elements['category'].value;
	var v = t.value;
	if(!v) {
		alert('추가할 카테고리명을 입력해 주세요');
		t.focus();
		return;
	}
	var req = getXHR();
	req.onreadystatechange = function () {
		if(req.readyState == 1) {
			showLoading(0);
		} else if(req.readyState == 4) {
			if(req.status == 200) {
				var lists = req.responseXML.getElementsByTagName('lists')[0];
				var showBox = $('viewCategory');
				var showBox2 = $('listCategory');
				showBox.innerHTML = '';
				showBox2.innerHTML = '';

				var result = '<select name="category"><option value="">선택 분류 없음</option>';
				var result2 = '';
				var items = lists.getElementsByTagName('item');
				for(i=0; i<items.length; i++) {
					var no = items[i].getAttribute('no');
					var title = items[i].getElementsByTagName('title')[0].firstChild.nodeValue;
					var fullTitle = items[i].getElementsByTagName('fullTitle')[0].firstChild.nodeValue;
					result += '<option value="'+no+'">'+fullTitle+'</option>';
				}
				result += '</select> <input type="text" name="addNewCategory" class="i" />';
				result += '<input type="button" value="추가" class="s" onclick="addCategory();" />';

				result2 += '<ol>';
				for(i=0; i<items.length; i++) {
					var no = items[i].getAttribute('no');
					var title = items[i].getElementsByTagName('title')[0].firstChild.nodeValue;
					var fullTitle = items[i].getElementsByTagName('fullTitle')[0].firstChild.nodeValue;
					result2 += '<li>'+fullTitle+' <span onclick="delCategory(\''+title+'\');" title="이 카테고리를 삭제하기">ⓧ</span></li>';
				}
				result2 += '</ol>';
				showBox.innerHTML = result;
				showBox2.innerHTML = result2;
			} else {
				alert('문제가 생겼습니다: '+req.statusText);
			}
		}
	}
	req.open('POST', 'admin/admin_category.php', true);
	req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	req.send('categoryName='+v+'&_c='+_c+'&opt=1');
}

// 카테고리 삭제
function delCategory(str)
{
	if(!str) {
		alert('삭제할 카테고리명을 입력해 주세요');
		return;
	}
	req = getXHR();
	req.onreadystatechange = function () {
		if(req.readyState == 1) {
			showLoading(0);
		} else if(req.readyState == 4) {
			if(req.status == 200) {
				var lists = req.responseXML.getElementsByTagName('lists')[0];
				var showBox = $('viewCategory');
				var showBox2 = $('listCategory');
				showBox.innerHTML = '';
				showBox2.innerHTML = '';

				var result = '<select name="category"><option value="">선택 분류 없음</option>';
				var result2 = '';
				var items = lists.getElementsByTagName('item');
				for(i=0; i<items.length; i++) {
					var no = items[i].getAttribute('no');
					var title = items[i].getElementsByTagName('title')[0].firstChild.nodeValue;
					var fullTitle = items[i].getElementsByTagName('fullTitle')[0].firstChild.nodeValue;
					result += '<option value="'+no+'">'+fullTitle+'</option>';
				}
				result += '</select> <input type="text" name="addNewCategory" class="i" />';
				result += '<input type="button" value="추가" class="s" onclick="addCategory();" />';
				result2 += '<ol>';
				for(i=0; i<items.length; i++) {
					var no = items[i].getAttribute('no');
					var fullTitle = items[i].getElementsByTagName('fullTitle')[0].firstChild.nodeValue;
					var title = items[i].getElementsByTagName('title')[0].firstChild.nodeValue;
					result2 += '<li>'+fullTitle+' <span onclick="delCategory(\''+title+'\');" title="이 카테고리를 삭제하기">ⓧ</span></li>';
				}
				result2 += '</ol>';
				showBox.innerHTML = result;
				showBox2.innerHTML = result2;
			} else {
				alert('문제가 생겼습니다: '+req.statusText);
			}
		}
	}
	req.open('POST', 'admin/admin_category.php', true);
	req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	req.send('categoryName='+str+'&opt=0');
}

// 이미지 파일 업로드
function post_upload()
{
	window.open('admin/admin_upload.php', 'upload', 'width=450,height=500,menubar=no,scrollbars=yes');
}

// 일반 파일 업로드
function file_upload()
{
	window.open('admin/admin_file_upload.php', 'upload', 'width=450,height=200,menubar=no');
}

// 로딩 메시지 출력
function showLoading(n)
{
	if(n) {
		var t = document.getElementById('writeStatus');
		t.style.display = '';
		t.innerHTML = '<img src="image/wait.gif" alt="Loading" /> 작성 완료중입니다...';
	} else {
		var t = document.getElementById('viewCategory');
		t.innerHTML = '<img src="image/wait.gif" alt="Loading" /> 작업중...';
	}
}

// 글 작성 폼 크게
function formBig()
{
	var t = document.forms['new_post'].elements['content'];
	t.rows += 2;
}

// 글 작성 폼 작게
function formSmall()
{
	var t = document.forms['new_post'].elements['content'];
	if(t.rows > 6)
		t.rows -= 2;
	else
		alert('이미 최소 크기 입니다');
}

// 글작성 취소
function post_cancel(src)
{
	if(confirm('정말로 작성을 중단하고 블로그로 가시겠습니까?')) {
		location.href=src;
	}
}

// 문자열 치환
function str_replace(str1, str2, str3)
{
	var r = new RegExp(str1, 'g');
	return str3.replace(r, str2);
}

// HTML 관련 문자 변환
function htmlencode(str)
{
	str = str_replace('&', '#amp;', str);
	str = str_replace('\\+', '#plus;', str);
	str = str_replace('\\\\', '#rslash;', str);
	str = str_replace('%', '#percent;', str);
	return str;
}

// 미리보기
function post_preview()
{
	var t = $('previewBox');
	var content = document.forms['new_post'].elements['content'].value;
	if(!content) {
		alert('글 내용을 먼저 작성해 주세요');
		document.forms['new_post'].elements['content'].focus();
		return;
	}
	if(t.style.display = 'none') {
		content = str_replace("\n", '<br />', content);
		t.style.display = '';
		t.innerHTML = content;
	}
}

// pure code print
function code2html(s)
{
	var s = s.replace(/&amp;/gi,'&');
	s = s.replace(/&/gi,'&amp;');
	s = s.replace(/</gi,'&lt;');
	return s.replace(/>/gi,'&gt;');
}

tinyMCE.init({
	// General options
	force_p_newlines : false,
	remove_linebreaks : true,
	mode : "textareas",
	theme : "advanced",
	plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

	// Theme options
	theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
	theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
	theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,

	// Example content CSS (should be your site CSS)
	content_css : GRBLOG+"css/edit.css",

	// Drop lists for link/image/media/template dialogs
	template_external_list_url : "lists/template_list.js",
	external_link_list_url : "lists/link_list.js",
	external_image_list_url : "lists/image_list.js",
	media_external_list_url : "lists/media_list.js",

	// Replace values for the template plugin
	template_replace_values : {
		username : "GR Blog",
		staffid : "991234"
	}
});

// 본문 자동 저장하기 (매 10초 마다 → 브라우저 쿠키로)
function autoSaveToDB() 
{
	AUTO_SAVE = 1;
	post_write('');
}

setInterval("autoSaveToDB()", AUTOSAVE_TERM * 1000);