/* Rolling */
var _PID_ = 0;
var _IDX_ = 1;
var _NAME_ = 2;
var _FUNC_ = 3;
var _INTERVAL_ = 4;
var _DATA_ = 5;

/* ROLLING */
function doBtnClickNext(idx,move,rolling) {
	if(rolling == 1) {
		pauseRolling(idx);
		showBlock(idx,move);
		continueRolling(idx);
	} else {
		showBlock(idx,move);
	}
}

function showBlock(idx, move) {
	if ( move == 1 ) {
		if ( D2233[idx][_IDX_]++ >= D2233[idx][_DATA_].length )
			D2233[idx][_IDX_] = 1;
	}
	else
	{
		if ( D2233[idx][_IDX_]-- <= 1)
			D2233[idx][_IDX_] = D2233[idx][_DATA_].length;
	}

	for(var j=1; j <= D2233[idx][_DATA_].length; j++)
	{
		document.getElementById(D2233[idx][_NAME_] + j).style.display = "none";
	}

	if ( idx == 1 || idx == 2 )		document.getElementById(D2233[idx][_NAME_]+ ( D2233[idx][_IDX_] % (D2233[idx][_DATA_].length + 1))).style.display = "inline";
	else					document.getElementById(D2233[idx][_NAME_]+ ( D2233[idx][_IDX_] % (D2233[idx][_DATA_].length + 1))).style.display = "block";
}

function getIndexByName(name)
{
	for(var i = 0; i < D2233.length; i++ )
	{
		if ( D2233[i][_NAME_] == name)
			return i;
	}
}

/* swap pop tab */
function swapPop(no)
{
	var idx = getIndexByName(  no == 1 ? "tiList_" : "blgList_" );
	D2233[idx][_IDX_] = 0;
	showBlock(idx, 1);

	document.getElementById( no == 1 ? "tiTit" : "blgTit").className = "imbg on";
	document.getElementById( no == 1 ? "tiList" : "blgList" ).style.display = "block";
	document.getElementById( no == 1 ? "blgTit" : "tiTit" ).className = "imbg";
	document.getElementById( no == 1 ? "blgList" : "tiList" ).style.display = "none";
}

function pauseRolling(idx)
{
	clearInterval(D2233[idx][_PID_]);
	D2233[idx][_PID_] = 0;
}

function continueRolling(idx)
{
	D2233[idx][_PID_] = setInterval(D2233[idx][_FUNC_] + "(" + idx + ", 1)", D2233[idx][_INTERVAL_]);
}

function stopRolling(idx)
{
	pauseRolling(idx);
	D2233[idx][_IDX_] = 0;
}

function startRolling(idx)
{
	if (D2233[idx][_PID_] >= 0)
	{
		stopRolling(idx);
	}
	D2233[idx][_PID_] = setInterval( D2233[idx][_FUNC_]  + "(" + idx + ", 1)", D2233[idx][_INTERVAL_]);
}

function rollingStart() {
	startRolling(0);
	startRolling(1);
	startRolling(2);
	startRolling(3);
}

/* Search */
function searchsubmit() {
	var f = document.search;

	try{
		var chkVal = f.w.value;
	}catch(e){
		var chkVal = "tot";
	}

	if(chkVal == "tot"){
		try{
			include_script('text/javascript', true, 'http://img.search.daum-img.net/jumpkeyword/API/tot_api.js');
			for(var i=0; i<obj.length; i++){
				if(obj[i]["K"] == f.q.value){
					f.rtupcoll.value = obj[i]["P"].substring("9");
				}
			}
		}catch(e){}

		f.action = "http://m.search.daum.net/mobile/search";
		f.submit();
	}else{
		f.w.value = chkVal;
		f.action = "http://m.search.daum.net/mobile/search";
		f.submit();
	}

	return false;
}

function include_script(type, defer, src){
	var script = document.createElement("script");
	script.type = type, script.defer = defer;
	script.src = src;
	script.charset = 'euc-kr';
	document.getElementsByTagName('head')[0].appendChild(script);
	return script;
}

/* Check Box Click By Text */
function onClickCheck(cBox) {
	box = eval(cBox);
	box.checked = !box.checked;
	box.click();
}

// Scroll Button _ FB
function setNav() {
	if(!document.getElementById)	return false;
	if(!document.getElementById('scrollNav'))	return false;

	var nav = document.getElementById('scrollNav');

	if (hasScroll())		{ showScroll(nav); }
	else					{	hideScroll(nav); }
}

function moveNav(dir, amount) {
	if (amount == undefined) amount = 250;

	switch (dir)
	{
		case 'top':
			window.scrollTo(0,0);
			break;
		case 'up':
			window.scrollTo(0, document.documentElement.scrollTop - amount);
			break;
		case 'down':
			window.scrollTo(0, document.documentElement.scrollTop + amount);
			break;
		defalut:
			break;
	}
}

function hasScroll(){
	var screenHeight = document.documentElement.scrollHeight;
	var clientHeight = document.documentElement.clientHeight;
	return clientHeight < screenHeight ? true : false;
}

function showScroll(nav){
	var offset = 238;

	nav.style.display = "";
	nav.style.top = (document.documentElement.scrollTop + offset) + 'px';
}

function hideScroll(nav){
	nav.style.display = "none";
}

function getElementsByClassName(_element, className){
	var elem = typeof _element == "string" ? document.getElementById(_element) : _element;

	var _all = elem.getElementsByTagName("*");
	var element = [];
	for(var i=0,len=_all.length; i<len; i++) {
		if(_all[i].className == className) element.push(_all[i]);
	}
	return (element.length > 0) ? element : null;
}

if (window.attachEvent)	window.attachEvent("onscroll", setNav);
else	window.addEventListener("scroll", setNav, false);

function  changeClass() {
	var width = document.documentElement.clientWidth;
	var height = document.documentElement.clientHeight;

	if(!document.getElementById)	return false;
	if(!document.getElementById("ctListVP"))	return false;
	if(!document.getElementById("ctListVL"))	return false;
	if(!document.getElementById("tiList"))	return false;
	if(!document.getElementById("blgList"))	return false;

	if (width > height) {
		document.getElementById("ctListVL").style.display = "block";
		document.getElementById("ctListVP").style.display = "none";
		document.getElementById("tiList").className = "cnt_list"
		document.getElementById("blgList").className = "cnt_list"

	} else {
		document.getElementById("ctListVP").style.display = "block";
		document.getElementById("ctListVL").style.display = "none";
		document.getElementById("tiList").className = "cnt_list ti_vp"
		document.getElementById("blgList").className = "cnt_list blg_vp"
	}
}

function intervalStart() {
	setNav();
	changeClass();
}

setInterval(intervalStart, 100);