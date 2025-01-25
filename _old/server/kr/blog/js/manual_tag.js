// 퀵태그 넣기
function quickTag(start, end)
{
	target = document.forms['new_post'].elements['content'];
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
function addLink()
{
	t = document.forms['new_post'].elements['content'];
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
function color()
{
	target = document.forms['new_post'].elements['content'];
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
function fontsize()
{
	target = document.forms['new_post'].elements['content'];
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
function addImg()
{
	t = document.forms['new_post'].elements['content'];
	p = prompt('넣을 그림의 파일명(혹은 주소)을 입력해 주세요', '');
	if(p) {
		a = prompt('그림의 간단 설명을 입력해 주세요 (그림이 출력되지 않을 시 나옵니다)', '그림');
		t.value += '<a href="'+p+'" rel="lightbox" class="grUpImage"><img src="'+p+'" alt="'+a+'" /></a>';
	}
}

// 글작성 취소
function post_cancel(src)
{
	if(confirm('정말로 작성을 중단하고 블로그로 가시겠습니까?')) {
		location.href=src;
	}
}

// 미리보기
function post_preview()
{
	t = document.getElementById('previewBox');
	content = document.forms['new_post'].elements['content'].value;
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

// 문단 토글화
function setMore()
{
	target = document.forms['new_post'].elements['content'];
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
			+ '더보기...</span>'+"\n"+'<div id="more'+MORE_COUNT+'" style="display: none">'+"\n"
			+ target.value.substring(target.selectionStart, target.selectionEnd)
			+ '</div>' + target.value.substring(target.selectionEnd, target.value.length);
		target.focus();
	}
}
function setCode()
{
	target = document.forms['new_post'].elements['content'];
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