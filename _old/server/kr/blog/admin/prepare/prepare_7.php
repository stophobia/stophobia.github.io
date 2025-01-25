<?php
	if(!$_SESSION['no'] && !$_SESSION['user_no']) error('로그인 상태가 아닙니다');
	$_SESSION = array();
	@session_destroy();
	move('./');
?>