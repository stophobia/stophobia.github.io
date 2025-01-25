<!--
////////////////////////////////////////////////////////////////////////////
//
//   Flash External MouseWheel Event v1.0
//   Work on Mac (Safari, FireFox, Opera)
//   Work on Windows (InternetExplorer, FireFox, Safari, Opera)
//
////////////////////////////////////////////////////////////////////////////

// MAC
var isMac=false;

// PC
var isPC=false;

// FIREFOX or SAFARI
var isFF=false;

// INTERNET EXPLORER
var isIE=false;

// MAC or PC
if(navigator.appVersion.toLowerCase().indexOf("mac")!=-1){
	isMac=true;
}else{
	isPC=true;
}

// IE or FF
if(navigator.appName.indexOf("Microsoft") != -1){
	isIE=true;
}else{
	isFF=true;
}

// MouseOver
var isOverFlash="none";

// Flash Write
function flashWrite(url,id,bg,vars,win,w,h,base,isWheel){
	var flashStr=
	"<div id='"+id+"_layer' style='width:"+w+";height:"+h+";'>"+
	"<object classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' codebase='http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,124,0' width='"+w+"' height='"+h+"' id='"+id+"' align='middle'>"+
	"<param name='allowScriptAccess' value='always' />"+
	"<param name='movie' value='"+url+"' />"+
	"<param name='"+base+"' value='' />"+
	"<param name='FlashVars' value='"+vars+"' />"+
	"<param name='wmode' value='"+win+"' />"+
	"<param name='quality' value='high' />"+
	"<param name='bgcolor' value='"+bg+"' />"+
	"<embed src='"+url+"' base='"+base+"' FlashVars='"+vars+"' wmode='"+win+"' quality='high' bgcolor='"+bg+"' width='"+w+"' height='"+h+"' name='"+id+"' align='middle' allowScriptAccess='always' type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/go/getflashplayer' />"+
	"</object></div>";
	document.write(flashStr);
	if(isWheel){
		document.all[id+"_layer"].onmouseover=function(){
			isOverFlash=id;
		}
		document.all[id+"_layer"].onmouseout=function(){
			isOverFlash="none";
		}
	}
}

// Find Flash Target
function flashThisMovie(movieName){
	if(navigator.appName.indexOf("Microsoft") != -1){
		return window[movieName];
	}else{
		return document[movieName];
	}
}

// Mouse Wheel Init
function externalWheelEventInit(){
	if(window.addEventListener){
		window.addEventListener('DOMMouseScroll',externalWheelEvent,false);
	}else{
		window.onmousewheel=externalWheelEvent;
	}
	document.onmousewheel=externalWheelEvent;
}

// Mouse Wheel Event
function externalWheelEvent(event){
	if(isOverFlash!="none"){
		var e;
		if(isMac){
			e=event;
		}else{
			if(isFF){
				e=event;
			}else{
				e=window.event;
			}
		}
		var delta=0;
		if(e.wheelDelta){
			delta=e.wheelDelta/120;
		}else if(e.detail){
			delta=-e.detail/3;
		}
		if(/AppleWebKit/.test(navigator.userAgent))delta/=3;
		if(delta){
			flashThisMovie(isOverFlash).externalMouseEvent(delta);
		}
		if(e.preventDefault)e.preventDefault();
		e.returnValue=false;
	}
}

// Start
externalWheelEventInit();

// Photo Gallery Functions
function getLocalVars(){
	var uri=location.href;
	var vars=uri.split("#")[1];
	return vars;
}
function refreshGallery(){
	location.reload();
}
-->