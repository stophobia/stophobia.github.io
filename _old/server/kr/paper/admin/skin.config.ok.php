<?php
/*
	GR Paper 스킨 설정값 저장 처리
	작성자: 박희근 (http://sirini.net)
	수정일: 2008-08-23
	내  용: Ajax 로 넘어온 값들을 확인하여 스킨 설정을 변경한다.
	주  의: 관리자만 스킨 수정 작업을 할 수 있다.
*/

include '../library/common.php';
$c = new GRCOMMON('../', 'text/xml');
if(!$c->isAdmin()) die('<?xml version="1.0" encoding="utf-8"?><grpaper><result>false</result></grpaper>');

@extract($_POST);
$original = array('@amp;', '@plus;', '@percent;', '@rslash;', '@sharp;');
$change = array('&amp;', '+', '%', '￦', '#');
$value = str_replace($original, $change, $value);
$c->set($id, $value);
echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<grpaper>
	<result>true</result>
</grpaper>
