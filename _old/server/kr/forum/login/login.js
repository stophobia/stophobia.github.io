/**
 * GR Forum JavaScript for Login Page
 * @author sirini
 * @update 2009-07-30
 * @comment 로그인 입력폼 유효성 검사 등을 처리
 */

var Login = {

	$ : function(id) {
		return document.getElementById(id);
	},

	f : function(form, element) {
		return document.forms[form].elements[element];
	},

	get : function(ptr, element) {
		return ptr.elements[element].value;
	},

	check : function(ptr) {
		if( !this.get(ptr, 'id') ) {
			alert('아이디를 입력해 주세요.');
			this.f('login', 'id').focus();
			return false;
		}

		if( !this.get(ptr, 'password') ) {
			alert('비밀번호를 입력해 주세요.');
			this.f('login', 'password').focus();
			return false;
		}

		return true;
	}
}