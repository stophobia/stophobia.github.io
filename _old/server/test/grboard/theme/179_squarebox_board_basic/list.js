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
		alert('검색어를 입력하세요');
		return false;
	}
	return true;
}

// 셀렉트박스에서 카테고리 선택시 이동처리
function setCategory(t)
{
	if(!t) return;
	var bbsID = document.forms["list"].elements["id"].value;
	location.href='board.php?id='+bbsID+'&clickCategory='+t;
}