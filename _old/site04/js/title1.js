// =======================================
// Set the following variables
// =======================================

// Set slideShowSpeed (milliseconds):
var slideShowSpeed = 3000

// Duration of crossfade (seconds) for IE:
var crossFadeDuration = 3

// Set the positioning variables, below:
// Negative numbers are relative to right (whereX) or bottom (whereY)
// Positive numbers are relative to left (whereX) or (whereY) top
// Experiment with values to get positioning exact, and allow
// for the dimensions of the image in the positioning

var whereX = 0;
var whereY = 0;

// Specify the image files:
var Pic = new Array() // don't touch this!
// to add more images, just continue
// the pattern, adding to the array below

Pic[0] = 'images/gennaro.jpg'
Pic[1] = 'images/gjeans.jpg'
Pic[2] = 'images/buzz.jpg'
Pic[3] = 'images/cluise.jpg'
Pic[4] = 'images/slangy.jpg'
Pic[5] = 'images/syrix.jpg'
Pic[6] = 'images/epoisses.jpg'
// =======================================
// Do not edit *anything* below this line!
// =======================================

var nn=(navigator.appName.indexOf("Netscape")!=-1);
var t;var j=0;var p=Pic.length;var preLoad=new Array();
for (i=0;i<p;i++){preLoad[i]=new Image();preLoad[i].src = Pic[i];}
function runSlideShow(){
if (document.all){
document.images.SlideShow.style.filter="blendTrans(duration=2)";
document.images.SlideShow.style.filter="blendTrans(duration=crossFadeDuration)";
document.images.SlideShow.filters.blendTrans.Apply();}
if (document.all || document.getElementById){document.images.SlideShow.src = preLoad[j].src;}else{
document.FloatSlideShow.document.images["SlideShow"].src = preLoad[j].src;}
if (document.all){document.images.SlideShow.filters.blendTrans.Play();}
j=j+1;if (j>(p-1))j=0;t=setTimeout('runSlideShow()', slideShowSpeed);}
var dD=document,dH=dD.html,dB=dD.body,px=dD.layers?'':'px';
function floatSS(iX,iY,id){
var L=dD.getElementById?dD.getElementById(id):dD.all?dD.all[id]:dD.layers[id];  
this[id+'O']=L;if(dD.layers){L.style=L;L.nX=L.iX=iX;L.nY=L.iY=iY;}
L.P=function(x,y){this.style.left=x+px;this.style.top=y+px;};L.Fss=function(){var pX, pY; 
pX=(this.iX >=0)?0:nn?innerWidth:nn&&dH.clientWidth?dH.clientWidth:dB.clientWidth; 
pY=nn?pageYOffset:nn&&dH.scrollTop?dH.scrollTop:dB.scrollTop; 
if(this.iY<0)pY+=nn?innerHeight:nn&&dH.clientHeight?dH.clientHeight:dB.clientHeight; 
this.nX+=.1*(pX+this.iX-this.nX);this.nY+=.1*(pY+this.iY-this.nY);this.P(this.nX,this.nY);
setTimeout(this.id+'O.Fss()',33);};return L;}
floatSS(whereX,whereY,'FloatSlideShow').Fss();