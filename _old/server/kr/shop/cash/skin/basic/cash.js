jQuery(function(){
	jQuery(".checkAgain").toggle("checkAgain");
});

var Cash = {
	get : function (element) {
		return document.forms['purchase'].elements[element];
	},
	noInput : function () {
		window.open('../find.address.php', 'findAddress', 'width=600,height=550,menubar=no,scrollbars=yes');
	},
	checkInput : function () {
		var f = document.forms['purchase'];
		if(!f.elements['address1'].value) {
			alert('먼저 우편번호/주소 찾기로 위의 항목을 입력하신 후 작성하실 수 있습니다.');
		}
	},
	checkSaveMoney : function (t, money) {
		var total = parseInt(document.forms['purchase'].elements['total_save_money'].value);
		var use = parseInt(t.value);
		if(isNaN(use) || use < 0) {
			alert('사용하실 적립금에는 0 이상의 숫자만 입력해주세요!');
			t.value = 0;
			return;
		}
		if(total < use) {
			alert('전체 적립금보다 사용할 적립금이 더 많습니다. 다시 입력해주세요!');
			t.value = 0;
			return;
		} else if (total && use && (total == use)) {
			if(!confirm('전체 적립금을 이번에 전부 사용하시겠습니까?')) {
				alert('사용할 적립금을 다시 입력해주세요.');
				t.value = 0;
				return;
			}
		}
		var sendMoney = parseInt(money) - use;
		jQuery(".sendMoneyConfirm").html(sendMoney.toString().replace(/(\d)(?=(?:\d{3})+(?!\d))/g,'$1,'));
	},
	checkAll : function (t) {
		if(!t.elements['mail_code'].value || !t.elements['address1'].value) {
			alert('우편번호/주소를 선택해 주세요');
			this.noInput();
			return false;
		}
		if(!t.elements['address2'].value) {
			alert('나머지 주소를 입력해 주세요.');
			t.elements['address2'].focus();
			return false;
		}
		if(!t.elements['home_phone'].value && !t.elements['mobile_phone'].value) {
			alert('집전화 혹은 휴대폰 번호 2개 중 하나는 입력해 주셔야 합니다.');
			t.elements['mobile_phone'].focus();
			return false;
		}
		return true;
	},
	sumCost : function (t, cost, save) {
		var num = parseInt(t.value);
		var cost = parseInt(cost);
		var save = parseInt(save) * num;
		var sendMoney = num * cost;
		jQuery(".sendMoneyConfirm").html(sendMoney.toString().replace(/(\d)(?=(?:\d{3})+(?!\d))/g,'$1,'));
		jQuery("#getSaveMoney").html(save.toString().replace(/(\d)(?=(?:\d{3})+(?!\d))/g,'$1,'));
		this.get('totalCost').value = sendMoney;
		this.get('totalSaveMoney').value = save;
		this.get('getNum').value = num;
	},
	buyCard : function (id, no, prefix) {
		jQuery(".checkAgain").html(jQuery("#buyCardMsg").html());
		jQuery("#orderNow").hide();
		var totalCost = this.get('totalCost').value;
		var totalSaveMoney = this.get('totalSaveMoney').value;
		var getNum = this.get('getNum').value;
		window.open('../payment/agspay/AGS_pay.php?bbs_id='+id+'&bbs_no='+no+'&tbl_prefix='+prefix+'&totalCost='+totalCost+'&totalSaveMoney='+totalSaveMoney+'&getNum='+getNum, 'payment', 'width=530,height=550,menubar=no,scrollbars=yes');
	},
	buyCash : function () {
		jQuery(".checkAgain").html(jQuery("#buyCashMsg").html());
		jQuery("#orderNow").show();
	}
}