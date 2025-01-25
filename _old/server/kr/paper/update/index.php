<?php
/*
	GR Paper 업데이터
	작성자: 박희근 (http://sirini.net)
	수정일: 2009-1-12
	내  용: 페이퍼 업데이트를 처리합니다.
	참  고: 태그 등의 테이블에 중복 제거 처리를 병행합니다. 간간히 실행하면 좋습니다.
	주  의: 서버에 약간의 부하를 유발할 수 있습니다. 수집된 DB가 많을 수록 더 많은 부하가 걸립니다.
*/

// db 연결
@set_time_limit(0);
include '../library/common.php';
$c = new GRCOMMON('../');

// v0.95b 익명 등록시 관리용으로 생성될 guest 그룹 만들기
$isGuestGroup = $c->db->query('select uid from '.$c->prefix.'feed_group where name = \'guest\' limit 1')->fetch_array();
if(!$isGuestGroup['uid']) @$c->db->query('insert into '.$c->prefix."feed_group set uid = '', name = 'guest', info = 'guest recommand rss', count = 0, is_open = 1");

// 태그 중복성 제거 (중복 수치가 0인 태그에 한해서 실행함)
$allTag = $c->db->query('select * from '.$c->prefix.'tag where count <> 0');
while($tag = $allTag->fetch_array()) {
	$cnt = @$c->db->query('select count(*) as cnt from '.$c->prefix.'tag where tag like \''.addslashes($tag['tag']).'\'')->fetch_array();
	@$c->db->query('update '.$c->prefix.'tag set count = '.$cnt['cnt'].' where uid = '.$tag['uid']);
	@$c->db->query('delete from '.$c->prefix.'tag where tag like \''.$tag['tag'].'\' and uid != '.$tag['uid']);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GR Paper Upgrade: v0.95 beta</title>
</head><body>

<h2>GR Paper v0.95 업데이트가 완료되었습니다.</h2>

<strong>DB Table 업데이트 내역</strong>
<ul>
	<li>익명 사용자가 RSS 피드를 등록할 수 있도록 허용할 때를 위해, 관리용으로 피드 그룹 guest 를 미리 생성함</li>
	<li>이전 베타버젼의 버그로 태그 중복 처리가 제대로 안된 것을 수정함 (시간이 많이 걸릴 수 있습니다.)</li>
</ul>

</body></html>