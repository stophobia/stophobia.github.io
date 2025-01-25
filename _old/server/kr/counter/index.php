<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GR Counter 관리자 화면으로 이동 합니다.</title>
<script type="text/javascript">//<![CDATA[
<?php if(!file_exists('db_info.php')) { ?>
alert('GR Counter 가 설치되어 있지 않습니다. 설치페이지로 이동합니다.');
location.href='./install/';
//]]></script></head><body></body></html>
<?php exit(); } ?>
location.href='./admin/';
//]]></script>
</head>
<body>
<a href="./admin/">[자동으로 이동되지 않을 경우 클릭해 주세요]</a>
</body>
</html>