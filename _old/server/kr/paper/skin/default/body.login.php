<?php
/*
	GR Paper 기본스킨 로그인 페이지
	작성자: 박희근 (http://sirini.net)
	수정일: 2008-08-22
	내  용: 기본스킨의 로그인 부분임. head.php 와 foot.php 사이 중간에 불려짐
*/
?>
<form id="loginNow" onsubmit="return Login.check();" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<div><input type="hidden" id="dirName" value="<?php echo $c->dirName; ?>" /></div>
<div id="login">
<strong>로그인</strong>
<ul>
	<li><input type="text" id="id" title="이 곳에 아이디를 입력해 주세요" /> 아이디</li>
	<li><input type="password" id="password" title="이 곳에 비밀번호를 입력해 주세요" /> 비밀번호</li>
</ul>
<div><input type="submit" value="로그인 하기" title="아이디와 비밀번호를 다 입력하셨으면 이 곳을 클릭해 주세요" /></div>
</div>
</form>

<div style="height: 100px"><!-- 아래 공백 --></div>
