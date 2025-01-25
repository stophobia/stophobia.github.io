<?php
/*
	GR Paper 피드 재인증
	작성자: 박희근 (http://sirini.net)
	수정일: 2009-1-15
	내  용: 더 이상 수집되지 않는 피드들을 찾아서 정리한다.
	참  고: 도메인 변경등의 이유로 블로그 고유 번호를 찾지 못하는 경우도 여기서 삭제 처리된다.
	주  의: 관리자만 이 작업을 할 수 있다.
	          텍스트큐브의 니들웍스 HTTPRequest 라이브러리는 GRCOMMON 클래스와 충돌되는 것으로 보인다.
			  따라서 두 클래스를 한 파일에서 동시에 선언하고 사용하지 않도록 한다.
*/

include '../library/external/Needlworks.PHP.HTTPRequest.php';
$tc = new HTTPRequest();
include '../db.info.php';
if(!$_POST['x'] && $_SESSION['login'] != 1) die('<?xml version="1.0" encoding="utf-8"?><grpaper><result>false</result></grpaper>');

$rssList = $db->query('select uid, xml from '.$dbinfo['prefix'].'feed_list');
while($r = $rssList->fetch_array()) {
	$tc->url = 'http://'.$r['xml'];
	if($tc->send()) {
		$p = @simplexml_load_string($tc->responseText);
		if(!$p->channel[0]->link) $db->query('delete from '.$dbinfo['prefix'].'feed_list where uid = '.$r['uid']);
		$blogUid = @$db->query('select uid from '.$dbinfo['prefix'].'feed_list where url = \''.str_replace('http://', '', $p->channel[0]->link).'\' limit 1')->fetch_array();
		if(!$blogUid['uid']) $db->query('delete from '.$dbinfo['prefix'].'feed_list where uid = '.$r['uid']);
	} else $db->query('delete from '.$dbinfo['prefix'].'feed_list where uid = '.$r['uid']);
}

@header('Content-Type: text/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<grpaper>
	<result>true</result>
</grpaper>