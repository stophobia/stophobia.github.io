<?php
/*
	GR Paper 세션 정리
	작성자: 박희근 (http://sirini.net)
	수정일: 2008-11-30
	내  용: 불필요하게 쌓인 태그 정리
	주  의: 세션 정리 후 관리자는 다시 로그인을 해야 한다.
*/

include '../library/common.php';
$c = new GRCOMMON('../', 'text/xml');
if(!$c->isAdmin()) die('<?xml version="1.0" encoding="utf-8"?><grpaper><result>false</result></grpaper>');

$op = opendir('../session');
while($r = readdir($op)) @unlink('../session/'.$r);
closedir($op);

echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<grpaper>
	<result>true</result>
</grpaper>
