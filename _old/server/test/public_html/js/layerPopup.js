isIE=document.all;
isNN=!document.all&&document.getElementById;
isN4=document.layers;
isHot=false;
lyLeft=0;
lyTop=0;

function LayerPos(idx){
	var theLayer = "P_Layer" + idx;
	var rightedge = document.body.clientWidth-event.clientX;
	var bottomedge = document.body.clientHeight-event.clientY;
	if (rightedge < theLayer.offsetWidth)
	lyLeft = document.body.scrollLeft + event.clientX - theLayer.offsetWidth;
	else
	lyLeft = document.body.scrollLeft + event.clientX;
	if (bottomedge < theLayer.offsetHeight)
	lyTop = document.body.scrollTop + event.clientY - theLayer.offsetHeight;
	else
	lyTop = document.body.scrollTop + event.clientY;
	
	lyLeft = lyLeft-250;
	lyTop = lyTop-70;
}

function ddInit(idx){
  topDog=isIE ? "BODY" : "HTML";
  whichDog=isIE ? document.all["P_Layer" + idx] : document.getElementById("P_Layer" + idx);  
  hotDog=isIE ? event.srcElement : e.target;   
         	   
  while (hotDog.id!="titleBar"+idx&&hotDog.tagName!=topDog){
    hotDog=isIE ? hotDog.parentElement : hotDog.parentNode;
  }      
  if (hotDog.id=="titleBar"+idx){
    offsetx=isIE ? event.clientX : e.clientX;
    offsety=isIE ? event.clientY : e.clientY;
    nowX=parseInt(whichDog.style.left);
    nowY=parseInt(whichDog.style.top);		
	
    ddEnabled=true;
    document.onmousemove=dd;
  }
  //레이버 위치잡기
  LayerPos(idx);	  
}

function dd(e){
  if (!ddEnabled) return;
  whichDog.style.left=isIE ? nowX+event.clientX-offsetx : nowX+e.clientX-offsetx; 
  whichDog.style.top=isIE ? nowY+event.clientY-offsety : nowY+e.clientY-offsety;
  return false;  
}

function ddN4(whatDog){
  if (!isN4) return;
  N4=eval(whatDog);
  N4.captureEvents(Event.MOUSEDOWN|Event.MOUSEUP);
  N4.onmousedown=function(e){
    N4.captureEvents(Event.MOUSEMOVE);
    N4x=e.x;
    N4y=e.y;
  }
  N4.onmousemove=function(e){
    if (isHot){
      N4.moveBy(e.x-N4x,e.y-N4y);
      return false;
    }
  }
  N4.onmouseup=function(){
    N4.releaseEvents(Event.MOUSEMOVE);
  }
}

//쿠기가져오기
function getCookie( name ) 
{ 
 //alert(name);
        var nameOfCookie = name + "="; 		 
        var x = 0; 
        while ( x <= document.cookie.length ) 
        { 
                var y = (x+nameOfCookie.length); 
                if ( document.cookie.substring( x, y ) == nameOfCookie ) { 
                        if ( (endOfCookie=document.cookie.indexOf( ";", y )) == -1 ) 
                                endOfCookie = document.cookie.length; 
                        return unescape( document.cookie.substring( y, endOfCookie ) ); 
                } 
                x = document.cookie.indexOf( " ", x ) + 1; 
                if ( x == 0 ) 
                        break; 
        } 
        return ""; 
} 

//레이어 출력 여부결정
function View_Popup(idx,pWith,pHeight) {
   if ( getCookie( "Notice"+idx ) != "done" ) 
	{
		document.all["P_Layer" + idx].style.top=pWith;     // 위치 Top
		document.all["P_Layer" + idx].style.left=pHeight;     //  위치 Left 
		document.all["P_Layer" + idx].style.display="block";
	}  
}

//쿠키설정
function setCookie( name, value, expiredays ) 
{ 
  var todayDate = new Date(); 
  todayDate.setDate( todayDate.getDate() + expiredays ); 
  document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";" 
}

//레이어 감추기
function closewin(idx) 
{ 
        if ( document.all["Notice" + idx].checked ) 
                setCookie( "Notice"+idx, "done" , 1); 
        
        document.all["P_Layer" + idx].style.display="none";
} 

function hideLayer(id){
	document.all["P_Layer" + id].style.display="none";
//	menu=eval("document.all.P_Layer" +  id +".style");
//	menu.display="none";
}