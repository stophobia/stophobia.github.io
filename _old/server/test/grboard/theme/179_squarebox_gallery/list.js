// 작성자 이름 클릭시 멤버 정보보기
function memberInfoView(key)
{
	if(!key) return;
	window.open('member_info.php?memberKey='+key, 'memberInfoOpen', 'width=650,height=600,menubar=no,scrollbars=yes');
}

// 선택한 게시물들을 관리
function adjustArticle()
{
	var i, isChecked=0;
	for(i=0; i<document.forms["list"].length; i++)
	{
		if(document.forms["list"][i].type=='checkbox')
			if(document.forms["list"][i].checked) isChecked++;
	}
	if(!isChecked)
		alert('管理する記事を1つ以上選択してください。');
	else
		document.forms["list"].submit();
}

// 전체선택버튼
function selectAll()
{
	var j;
	for(j=0; j<document.forms["list"].length; j++)
	{
		if(document.forms["list"][j].type=='checkbox')
		{
			document.forms["list"][j].checked = !document.forms["list"][j].checked;
		}
	}
}

// 검색폼이 비어있지는 않은지 체크
function searchValueCheck()
{
	if(!document.forms["search"].elements["searchText"].value)
	{
		alert('検索後を入力してください。');
		return false;
	}
	return true;
}

// highslide JS
try {
	hs.graphicsDir = 'image/graphics/';
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

	// 스타일을 동적으로 할당
	var hi = document.createElement('link');
	hi.setAttribute('rel', 'stylesheet');
	hi.setAttribute('href', 'highslide.css');
	hi.setAttribute('type', 'text/css');
	hi.setAttribute('title', 'style');
	document.documentElement.getElementsByTagName("HEAD")[0].appendChild(hi);
} catch(e) {}