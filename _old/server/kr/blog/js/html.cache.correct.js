/*
	블로그 포스트 목록보기시 html 캐쉬기능을 사용하는 경우,
	목록 화면에서 바로 댓글달 때 스팸 방지 코드가 맞지 않는 경우가 생김.
	이 스크립트는 htm 캐쉬기능 사용시 하단에 불려지며
	이 곳에서 스팽방지 코드 처리 오작동을 바로잡음.
*/

for(i=0; i<document.forms.length; i++) {
	for(j=0; j<document.forms[i].elements.length; j++) {
		if(document.forms[i].elements[j].name == 'antispam') {
			document.forms[i].elements[j].value = strKey;
			document.forms[i].elements[j].readOnly = true;
		}
	}
}