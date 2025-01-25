function loginConfirm(perURL) {
	if(confirm('로그인 후 사용하실 수 있습니다.\n\n로그인 하시겠습니까?')) 
		location.href='/odprogram/odlogon/od_login.php?path='+perURL;
}
