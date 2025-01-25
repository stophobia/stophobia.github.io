var MORE_COUNT = 1;

// 퀵태그 넣기
function quickTag(start, end)
{
	target = document.forms['source'].elements['htmlSource'];
	if(document.selection)
	{
		target.focus();
		ms = document.selection.createRange();

		if(ms.text.length > 0)
			ms.text = start + ms.text + end; 
		target.focus();
	}
	else 
	{
		target.value = target.value.substring(0, target.selectionStart)
			+ start + target.value.substring(target.selectionStart, target.selectionEnd)
			+ end + target.value.substring(target.selectionEnd, target.value.length);
		target.focus();
	}
}

// 링크 넣기
function t_addLink()
{
	t = document.forms['source'].elements['htmlSource'];
	p = prompt('링크 주소를 입력하세요', 'http://');
	if(p) {
		if(confirm('이 링크를 클릭했을 때 새창으로 뜨게 하시겠습니까?')) {
			t.value += '<a href="'+p+'" onclick="window.open(this.href, \'_blank\'); return false;">링크</a>';
		} else {
			t.value += '<a href="'+p+'">링크</a>';
		}
	}
}

// 색상 넣기
function t_color()
{
	target = document.forms['source'].elements['htmlSource'];
	p = prompt('색깔값을 입력해 주세요 (예: blue, #999, red)', '');
	if(!p) return;
	if(document.selection)
	{
		target.focus();
		ms = document.selection.createRange();

		if(ms.text.length > 0)
			ms.text = '<span style="color: '+p+'">' + ms.text + '</span>'; 
		target.focus();
	}
	else 
	{
		target.value = target.value.substring(0, target.selectionStart)
			+ '<span style="color: '+p+'">' + target.value.substring(target.selectionStart, target.selectionEnd)
			+ '</span>' + target.value.substring(target.selectionEnd, target.value.length);
		target.focus();
	}
}

// 글자 크기 조절
function t_fontsize()
{
	target = document.forms['source'].elements['htmlSource'];
	p = prompt('크기를 입력해 주세요 (예: 12, 24 ...) 픽셀단위(px) 입니다.', '12');
	if(!p) p = 12;
	if(document.selection)
	{
		target.focus();
		ms = document.selection.createRange();

		if(ms.text.length > 0)
			ms.text = '<span style="font-size: '+p+'px">' + ms.text + '</span>'; 
		target.focus();
	}
	else 
	{
		target.value = target.value.substring(0, target.selectionStart)
			+ '<span style="font-size: '+p+'px">' + target.value.substring(target.selectionStart, target.selectionEnd)
			+ '</span>' + target.value.substring(target.selectionEnd, target.value.length);
		target.focus();
	}
}

// 그림 넣기
function t_addImg()
{
	t = document.forms['source'].elements['htmlSource'];
	p = prompt('넣을 그림의 파일명(혹은 주소)을 입력해 주세요', '');
	if(p) {
		a = prompt('그림의 간단 설명을 입력해 주세요 (그림이 출력되지 않을 시 나옵니다)', '그림');
		t.value += '<p><a href="'+p+'" onclick="return hs.expand(this)"><img src="'+p+'" alt="'+a+'" /></a></p>';
	}
}

// 문단 토글화
function setMore()
{
	target = document.forms['source'].elements['htmlSource'];
	if(document.selection)
	{
		target.focus();
		ms = document.selection.createRange();

		if(ms.text.length > 0) {
			ms.text = "\n"+'<span class="more" onclick="more(\'more'+MORE_COUNT+'\');">' 
			+ '더보기...</span>'+"\n"+'<div id="more'+MORE_COUNT+'" style="display: none">'+"\n"
			+ ms.text + '</div>';
		}
		target.focus();
	}
	else 
	{
		target.value = target.value.substring(0, target.selectionStart)
			+ '<span class="more" onclick="more(\'more'+MORE_COUNT+'\');">' 
			+ '더 보기...</span>'+"\n"+'<div id="more'+MORE_COUNT+'" style="display: none">'+"\n"
			+ target.value.substring(target.selectionStart, target.selectionEnd)
			+ '</div>' + target.value.substring(target.selectionEnd, target.value.length);
		target.focus();
	}
}

// 문자열 치환
function str_replace(str1, str2, str3)
{
	var r = new RegExp(str1, 'g');
	return str3.replace(r, str2);
}

// pure code print
function code2html(s)
{
	var s = s.replace(/&amp;/gi,'&');
	s = s.replace(/&/gi,'&amp;');
	s = s.replace(/</gi,'&lt;');
	return s.replace(/>/gi,'&gt;');
}

// code 로 감싸기
function setCode()
{
	target = document.forms['source'].elements['htmlSource'];
	if(document.selection)
	{
		target.focus();
		ms = document.selection.createRange();

		if(ms.text.length > 0)
			ms.text = '<code>' + code2html(ms.text) + '</code>'; 
		target.focus();
	}
	else 
	{
		target.value = target.value.substring(0, target.selectionStart)
			+ '<code>' + code2html(target.value.substring(target.selectionStart, target.selectionEnd))
			+ '</code>' + target.value.substring(target.selectionEnd, target.value.length);
		target.focus();
	}
}

// Syntax Highlighter 로 감싸기
function setSyntax()
{
	target = document.forms['source'].elements['htmlSource'];
	if(document.selection)
	{
		target.focus();
		ms = document.selection.createRange();

		if(ms.text.length > 0)
			ms.text = '<pre class="brush: c;">' + code2html(ms.text) + '</pre><p>&nbsp;</p>'; 
		target.focus();
	}
	else 
	{
		target.value = target.value.substring(0, target.selectionStart)
			+ '<pre class="brush: c;">' + code2html(target.value.substring(target.selectionStart, target.selectionEnd))
			+ '</pre><p>&nbsp;</p>' + target.value.substring(target.selectionEnd, target.value.length);
		target.focus();
	}
}