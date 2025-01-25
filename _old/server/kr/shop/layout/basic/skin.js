jQuery.noConflict();

// 웹페이지 로딩 완료 후 아래 코드 동작
jQuery(function(){

	// 상품분류 아코디언 효과
	jQuery("#category").accordion({
		header: "h3"
	});

});