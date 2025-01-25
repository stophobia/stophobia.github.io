/* @ cc_on _d = document; eval(Åevar document = _dÅf) @*/
$(document).ready(function() {
	$("#index .nav a").click(showmenu);
	$("#index .close").click(hidemenu);
	$("#index .nav .policy").hover(showpolicy,hidepolicy);
	$("#index .inner .policy").hover(showpolicy,hidepolicy);
	$("#index .nav .about").hover(showabout,hideabout);
	$("#index .inner .about").hover(showabout,hideabout);
	$("#index .nav .clan").hover(showclan,hideclan);
	$("#index .inner .clan").hover(showclan,hideclan);
	$("#index .nav .faq").hover(showfaq,hidefaq);
	$("#index .inner .faq").hover(showfaq,hidefaq);
	$("#index .nav .download").hover(showdownload,hidedownload);
	$("#index .inner .download").hover(showdownload,hidedownload);
	$("#index .nav .guide").hover(showguide,hideguide);
	$("#index .inner .guide").hover(showguide,hideguide);
//	$("#index .contents .common .log .login").click(closeid);
});
$(window).load(function() {
	$("#index .logged .welcome").animate({opacity: 1.0}, 200);
	$("#index .contents .common .log .id").animate({left: "0px"}, 600 );
	$("#index .contents .common .log .pw").animate({left: "0px"}, 800 );
	$("#index .logged .welcome").animate({left: "0px"}, 500, "swing" );
});
function closeid() {
	$("#index .contents .common .log .id").animate({left: "125px"}, 200 );
	$("#index .contents .common .log .pw").animate({left: "125px"}, 400 );
	$("#index .contents .common .log .progress").css("display", "block");
}
function showmenu() {
	$("#index .inner").animate({top: "55px"}, 250 );
}
function hidemenu() {
	$("#index .inner").animate({top: "-170px"}, 250 );
}
function showpolicy() {
	$("#index .inner .policy").fadeTo("fast", 1);
	$("#index .nav .policy").css("background-image", "url('../images/altpng.png')");
	$("#index .nav .policy").css("width", "118px");
	$("#index .nav .policy").css("height", "49px");
}
function hidepolicy() {
	$("#index .inner .policy").fadeTo("fast", 0.5);
	$("#index .nav .policy").css("background-image", "url('../images/bg_nav.png')");
	$("#index .nav .policy").css("background-position", "-100px -73px");
}
function showabout() {
	$("#index .inner .about").fadeTo("fast", 1);
	$("#index .nav .about").css("background-image", "url('../images/altpng.png')");
}
function hideabout() {
	$("#index .inner .about").fadeTo("fast", 0.5);
	$("#index .nav .about").css("background-image", "url('../images/bg_nav.png')");
	$("#index .nav .about").css("background-position", "-218px -73px");
}
function showclan() {
	$("#index .inner .clan").fadeTo("fast", 1);
	$("#index .nav .clan").css("background-image", "url('../images/altpng.png')");
}
function hideclan() {
	$("#index .inner .clan").fadeTo("fast", 0.5);
	$("#index .nav .clan").css("background-image", "url('../images/bg_nav.png')");
	$("#index .nav .clan").css("background-position", "-313px -73px");
}
function showfaq() {
	$("#index .inner ul.faq").fadeTo("fast", 1);
	$("#index .nav .faq").css("background-image", "url('../images/altpng.png')");
}
function hidefaq() {
	$("#index .inner ul.faq").fadeTo("fast", 0.5);
	$("#index .nav .faq").css("background-image", "url('../images/bg_nav.png')");
	$("#index .nav .faq").css("background-position", "-878px -73px");
}
function showdownload() {
	$("#index .inner ul.download").fadeTo("fast", 1);
	$("#index .nav .download").css("background-image", "url('../images/altpng.png')");
}
function hidedownload() {
	$("#index .inner ul.download").fadeTo("fast", 0.5);
	$("#index .nav .download").css("background-image", "url('../images/bg_nav.png')");
	$("#index .nav .download").css("background-position", "-783px -73px");
}
function showguide() {
	$("#index .inner ul.guide").fadeTo("fast", 1);
	$("#index .nav .guide").css("background-image", "url('../images/altpng.png')");
}
function hideguide() {
	$("#index .inner ul.guide").fadeTo("fast", 0.5);
	$("#index .nav .guide").css("background-image", "url('../images/bg_nav.png')");
	$("#index .nav .guide").css("background-position", "-651px -73px");
}