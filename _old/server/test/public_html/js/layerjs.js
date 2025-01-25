<!-- 오른쪽 스크롤 시작 -->
var isDOM = (document.getElementById ? true : false); 
var isIE4 = ((document.all && !isDOM) ? true : false);
var isNS4 = (document.layers ? true : false);
var isNS = navigator.appName == "Netscape";

function getRef(id) {
	if (isDOM) return document.getElementById(id);
	if (isIE4) return document.all[id];
	if (isNS4) return document.layers[id];
}

function getSty(id) {
	x = getRef(id);
	return (isNS4 ? getRef(id) : getRef(id).style);
}

var scrollerHeight = 88;
var puaseBetweenImages = 6000;
var imageIdx = 0;

function moveRightEdge() {
	var yMenuFrom, yMenuTo, yOffset, timeoutNextCheck;

	if (isNS4) {
		yMenuFrom   = divMenu.top;
		yMenuTo     = windows.pageYOffset;   // 위쪽 위치
	} else if (isDOM) {
		yMenuFrom   = parseInt (divMenu.style.top, 10);
		yMenuTo     = (isNS ? window.pageYOffset : document.body.scrollTop); // 위쪽 위치
	}
	timeoutNextCheck = 500;

	if (yMenuFrom != yMenuTo) {
		yOffset = Math.ceil(Math.abs(yMenuTo - yMenuFrom) / 20);
		if (yMenuTo < yMenuFrom)
			yOffset = -yOffset;
		if (isNS4)
			divMenu.top += yOffset;
		else if (isDOM)
			divMenu.style.top = parseInt (divMenu.style.top, 10) + yOffset;
		if(parseInt (divMenu.style.top, 10) >  6000) {
			divMenu.style.top = "6000px"
		}	
			timeoutNextCheck = 10;
	}
	setTimeout ("moveRightEdge()", timeoutNextCheck);
}
<!-- 오른쪽 스크롤 끝 -->

<!-- 텍스트 타이핑효과 시작 -->
var max=0;function textlist()
{max=textlist.arguments.length;for(i=0;i<max;i++)
this[i]=textlist.arguments[i];}
tl=new textlist
(
'11월에도 쇼핑왕과',
'새내기 환영행사는 계속됩니다!',
'치열한 경합! 순위보러가자~');
var x=0;pos=0;
var l=tl[0].length;
function textticker()
{document.tickform.tickfield.value=tl[x].substring(0,pos)+'_';
if(pos++==l){pos=0;setTimeout('textticker()',1000); x++;
if(x==max) x=0;l=tl[x].length;}
else setTimeout('textticker()',100);
}
<!-- 텍스트 타이핑효과 끝 -->

<!-- swapimage script 시작 -->
function MM_swapImgRestore() { 
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc; 
} 

function MM_preloadImages() { 
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array(); 
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++) 
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}} 
} 

function MM_findObj(n, d) { 
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) { 
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);} 
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n]; 
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document); 
  if(!x && document.getElementById) x=document.getElementById(n); return x; 
} 

function MM_swapImage() { 
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3) 
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];} 
}
<!-- swapimage script 끝 -->

<!-- 마우스오버 텍스트 진열-->
im4 = (document.layers)?true:false
ie4 = (document.all)?true:false
var hideTimeout
function mouseOver(e){
 hideTimeout = window.setTimeout("showLayers()", 5000);
 return true
}
function showObject(obj) {
	if (im4) obj.visibility = "show"
	else if (ie4) obj.style.visibility = "visible"
	return obj
}
function hideObject(obj) {
	if(hideTimeout != null) window.clearTimeout(hideTimeout);
	if (im4) obj.visibility = "hide"
	else if (ie4) obj.style.visibility = "hidden"
}
var swapObj = new Array();
function showLayers() {
 var tobj
 for(i=0;i<swapObj.length;i++) {hideObject(swapObj[i]) }
 args = showLayers.arguments
 for(i=0;i<args.length;i++){
   if (im4) tobj = eval("document.layers['"+args[i]+"']")
	  else if (ie4) tobj = eval("document.all['"+args[i]+"']")
   swapObj[i] = showObject(tobj);
 }
}
function hideLayers() {
 for(i=0;i<swapObj.length;i++) {hideObject(swapObj[i]) }
 args = showLayers.arguments
}
<!-- 마우스오버 텍스트 진열-->
