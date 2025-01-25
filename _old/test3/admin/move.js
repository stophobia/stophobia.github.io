// 필요한 외부 변수 : tc, tb
// 내부 변수
flag = false;
x = 0;
y = 0;
tS = 10;
lS = 50;
isOpera = navigator.userAgent.indexOf("Opera")>=0;

// 움직이기 - IE, FF, Opera 테스트
function moving(e)
{
	if(!isOpera && window.event) {
		e = window.event;
		e.target = event.srcElement;
	}
	if(flag) {
		pa = e.target.parentNode.style;
		pa.left = (e.clientX - lS) + 'px';
		pa.top = (e.clientY - tS) + 'px';
	}
}

// 클릭 되는 순간
function setFlag(e)
{
	if(!isOpera && window.event) {
		e = window.event;
		e.target = event.srcElement;
	}
	if(e.target.className == tc) {
		ch = e.target.style;	
		ch.zIndex = 100;
		ch.opacity = 0.7;
		ch.filter = "alpha(opacity=70)";		
		flag = true;
		
		if(e.target.parentNode.className == tb) {
			pa = e.target.parentNode.style;
			pa.position = 'absolute';
			pa.zIndex = 100;
			pa.left = (e.clientX - lS) + 'px';
			pa.top = (e.clientY - tS) + 'px';
			pa.opacity = 0.7;
			pa.opacity = "alpha(opacity=70)";
		}
	}
}

// 클릭 후
function dSet(e)
{
	if(!isOpera && window.event) {
		e = window.event;
		e.target = event.srcElement;
	}
	if(e.target.parentNode.className == tb) {
		pa = e.target.parentNode.style;
		pa.opacity = 1.0;
		pa.filter = "alpha(opacity=100)";
		pa.zIndex = 1;
	}
	ch = e.target.style;
	ch.opacity = 1.0;
	ch.filter = "alpha(opacity=100)";
	ch.zIndex = 1;
	flag = false;
}

// 문서내 전범위에서 이벤트 추적
document.onmousemove = moving;
document.onmousedown = setFlag;
document.onmouseup = dSet;