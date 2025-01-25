// 문서 로딩 완료후 동작
$(function() {
	$(".topMenu").hover(
		function() { this.src = str_replace('top_', 'top.over_', this.src); },
		function() { this.src = str_replace('top.over_', 'top_', this.src); }
	);

	$(".infoBox").toggle(".infoBox");
	$("#browserInfo").html(navigator.userAgent);
});

// 문자열 치환
function str_replace(str1, str2, str3)
{
	var r = new RegExp(str1, 'g');
	return str3.replace(r, str2);
}

// 상품분류
var Category = {
	remove : function (n) {
		if(confirm('정말로 이 분류를 삭제하시겠습니까?\n\n이 곳에 속했던 게시판들의 분류를 재지정 하셔야 합니다.')) {
			location.href='./?menu=1&deleteTarget='+n;
		}
	},
	submit : function (t) {
		if(!t.elements['name'].value) {
			alert('추가할 대분류 이름을 적어주세요. (예: 컴퓨터/주변기기)');
			t.elements['name'].focus();
			return false;
		}
		return true;
	}
}

// 게시판등록
var BBS = {
	remove : function (n) {
		if(confirm('정말로 등록한 이 게시판을 삭제하시겠습니까?\n\n이 곳에서 삭제하더라도 실제로 게시판이 삭제되지는 않습니다.\n\n실제 게시판까지 모두 지우려면 GR보드 관리화면에서도 삭제하세요')) {
			location.href='./?menu=2&deleteTarget='+n;
		}
	},
	submit : function (t) {
		if(!t.elements['title'].value) {
			alert('게시판의 제목을 입력해 주세요. (예: 디카 매장)');
			t.elements['title'].focus();
			return false;
		}
		if(!t.elements['sub_title'].value) {
			alert('게시판의 부제목을 입력해 주세요. (예: 포터블에서 DSLR까지)');
			t.elements['sub_title'].focus();
			return false;
		}
		if(!t.elements['info'].value) {
			alert('게시판의 안내/설명을 입력해 주세요. (예: 이 곳에서 취급하는 모든 디카는 정품입니다.)');
			t.elements['info'].focus();
			return false;
		}
		return true;
	}
}

// 주문관리
var Order = {
	remove : function (n, returnMoney) {
		returnMoney = parseInt(returnMoney);
		if(confirm('정말로 고객이 남긴 이 주문신청을 삭제하시겠습니까?\n\n완료 전 거래는 취소되며, 입금 받으신 금액은 환불하셔야 합니다.\n\n삭제를 계속 진행하시겠습니까?')) {
			location.href='./?menu=3&deleteTarget='+n+'&returnMoney='+returnMoney;
		}
	},
	cancel : function (p_uid, returnMoney, key, num) {
		returnMoney = parseInt(returnMoney);
		if(confirm('입금확인 상태를 아직 하지 않은 것으로 되돌리시겠습니까?\n\n이 상품에 대한 적립금(이미 지급된)은 다시 회수됩니다.\n\n계속 진행하시겠습니까?')) {
			location.href='./?menu=3&confirm='+p_uid+'&action=0&returnMoney='+returnMoney+'&key='+key+'&num='+num;
		}
	},
	ok : function (p_uid, giveMoney, key, receiveCost, num) {
		giveMoney = parseInt(giveMoney);
		if(confirm('입금 내역을 모두 확인하셨습니까?\n\n고객이 입금한 금액이 정확하고, 상품배송 준비가 되었다면\n\n확인(예) 버튼을 눌러 입금확인을 완료한 것으로 변경하세요.\n\n이 상품의 적립금이 고객에게 지급됩니다.')) {
			location.href='./?menu=3&confirm='+p_uid+'&action=1&giveMoney='+giveMoney+'&key='+key+'&receiveCost='+receiveCost+'&num='+num;
		}
	},
	cardOK : function (n, receiveCost) {
		if(confirm('[올더게이트]를 통해서 카드 결제된 것을 확인하셨습니까?')) {
			location.href='./?menu=3&cardOKTarget='+n+'&receiveCost='+receiveCost;
		}
	},
	cardCancel : function (n) {
		if(confirm('물품을 배송하기 이전 상태로 되돌리시겠습니까?')) {
			location.href='./?menu=3&cardCancelTarget='+n;
		}
	},
	cardView : function (n) {
		$.ajax({
			type: 'POST',
			url : './get.card.info.php',
			data: 'uid='+n,
			cache : false,
			success : function (html) {
				$(function() {
					$("#cardInfo").html(html);
				});
			}
		});
		$(function() {
			$("#cardInfo").dialog();
		});
	}
}

// 배너관리
var Banner = {
	remove : function (n) {
		if(confirm('정말로 이 배너를 삭제하시겠습니까?')) {
			location.href='./?menu=5&deleteTarget='+n;
		}
	},
	submit : function (t) {
		if(!t.elements['url'].value) {
			alert('등록할 배너를 클릭하면 어디로 이동하게 할지 지정해주세요.\n\n만약 이동할 곳이 없다면 # 을 입력해 주세요.');
			t.elements['url'].focus();
			return false;
		}
		return true;
	}
}

// 상세 매출 통계
var Status = {
	setYear : function (t, m) {
		location.href='./?menu=6&_year='+t.value+'&_month='+m;
	},
	setMonth : function (t, y) {
		location.href='./?menu=6&_year='+y+'&_month='+t.value;
	}
}