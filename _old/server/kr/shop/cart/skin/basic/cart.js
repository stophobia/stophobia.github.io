jQuery(function(){
	jQuery(".infoBox").toggle("infoBox");
});

var Cart = {
	remove : function (n, p) {
		if(confirm('정말로 선택하신 상품을 장바구니에서 삭제 하시겠습니까?')) {
			location.href='./?deleteTarget='+n+'&page='+p;
		}
	}
}