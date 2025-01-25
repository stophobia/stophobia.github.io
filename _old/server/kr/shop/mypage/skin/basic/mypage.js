jQuery(function(){
	jQuery(".infoBox").toggle("infoBox");
});

var Mypage = {
	noInput : function () {
		window.open('../find.address.php', 'findAddress', 'width=600,height=550,menubar=no,scrollbars=yes');
	},
	checkInput : function () {
		var f = document.forms['purchase'];
		if(!f.elements['address1'].value) {
			alert('먼저 우편번호/주소 찾기로 위의 항목을 입력하신 후 작성하실 수 있습니다.');
		}
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
	}
}