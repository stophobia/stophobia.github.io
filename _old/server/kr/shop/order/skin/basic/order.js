jQuery(function(){
	jQuery(".infoBox").toggle("infoBox");
});

var Order = {
	cancel : function (n, p) {
		if(confirm('정말로 구매를 취소하시겠습니까?\n\n'+
			'이미 입금하신 금액과 관련해서는 문의게시판 등을 통해\n\n'+
			'궁금하신 점들을 언제든지 물어주세요.\n\n'+
			'사용했던 적립금은 다시 회수됩니다.\n\n'+
			'계속 진행하시겠습니까?')) {
			location.href='./?cancelTarget='+n+'&page='+p;
		}
	},
	remove : function (n, p) {
		if(confirm('정말로 구매취소 하신 이 상품을 목록에서 삭제하시겠습니까?\n\n'+
			'이미 거래가 취소된 상품이므로 주문조회 목록에서 삭제하셔도 됩니다.\n\n'+
			'계속 진행하시겠습니까?')) {
			location.href='./?deleteTarget='+n+'&page='+p;
		}
	},
	complete : function (n, p) {
		if(confirm('상품을 배송 받으셨습니까?')) {
			location.href='./?completeTarget='+n+'&page='+p;
		}
	}
}