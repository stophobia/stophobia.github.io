/*
	
	GR Paper 기본 스킨 스크립트
	작성자: 박희근 (http://sirini.net)

	수정일: 2008-08-26

	내  용: 기본 스킨에서 사용될 스크립트. 그리고 Ajax RSS수집기

	주  의: 수집기 관련 코드를 수정하거나 제거할 경우 RSS수집이 되지 않을 수 있음.

*/



// 쿠키 생성
function setCookie(name, value, expiredays) 
{
	var todayDate = new Date();
	todayDate.setDate( todayDate.getDate() + expiredays );
	document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";"
}

// 쿠키 가져오기
function getCookie(name) 
{
	var nameOfCookie = name + "=";
	var x = 0;
	while ( x <= document.cookie.length ){
		var y = (x+nameOfCookie.length);
		if ( document.cookie.substring( x, y ) == nameOfCookie ) {
			if ( (endOfCookie=document.cookie.indexOf( ";", y )) == -1 ) {
				endOfCookie = document.cookie.length;
			}
			return unescape(document.cookie.substring(y, endOfCookie));
		}
		x = document.cookie.indexOf(" ", x) + 1;
		if (x == 0) break;
	}
	return '';
}



// 쿠키 삭제

function delCookie(name) {
	
	var today = new Date()
;
	today.setDate(today.getDate() - 1)
;
	var value = getCookie(name)
;
	if(value != "") document.cookie = name + "=; expires=" + today.toGMTString();

}
	


// 아래 코드들은 그대로 유지할 것.

Event.observe(window, 'load', function() {
	
	

	// highslide JS
	try {
		hs.graphicsDir = $("getDirName").innerHTML+"/image/graphics/";
		hs.lang.creditsText = "";
		hs.align = "center";
		hs.transitions = ["expand", "crossfade"];
		hs.outlineType = "rounded-white";
		hs.fadeInOut = true;
		hs.numberPosition = "caption";
		hs.dimmingOpacity = 0.75;
			
		// Add the controlbar
		if (hs.addSlideshow) hs.addSlideshow({
			interval: 5000,
			repeat: false,
			useControls: true,
			fixedControls: true,
			overlayOptions: {
				opacity: .75,
				position: "top center",
				hideOnMouseOut: true
			}
		});
	} catch(e) {}

	// 쿠키 초기설정

	var now = new Date();

	var timestamp = parseInt(now.getTime());

	var botTerm = parseInt($("getBotTerm").innerHTML) * 60000;

	var reloadTime = parseInt(getCookie("reloadTime"));

	if(!reloadTime) setCookie("reloadTime", timestamp-botTerm, 1);



	// 수집요청 보내기
	
	if(reloadTime+botTerm < timestamp) {


		var request = new Ajax.Request("aggregator.php", {

			parameters: "x=1",

			onSuccess: function(request) {}
	
		});


		delCookie("reloadTime");

		setCookie("reloadTime", (new Date()).getTime(), 1);

	}



});
