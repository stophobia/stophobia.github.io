<?php
/*
	GR Paper OPML 불러오기 처리
	작성자: 박희근 (http://sirini.net)
	수정일: 2009-1-15
	내  용: 첨부된 .opml 파일을 분석해서 블로그를 몽땅 등록한다.
	참  고: RSS 2.0 포맷만 지원한다. / Ajax 방식이 아닌 POST & 페이지 리로드 방식이다. 따라서 출력은 html
	주  의: 관리자만 추가 작업을 할 수 있다.
*/

include '../library/common.php';
$c = new GRCOMMON('../', 'text/html');
if(!$c->isAdmin()) $c->alert('관리자만 작업 할 수 있습니다.');

// 업로드 처리
list($fKey, $fValue) = each($_FILES);
$filename = $fValue['name'];
$filetype = $fValue['type'];
$filesize = $fValue['size'];
$filetmpname = $fValue['tmp_name'];

// 파일 읽기
if($filesize > 0)
{
	$filetmpname = str_replace('\\\\', '\\', $filetmpname);
	$filename = str_replace(' ', '_', $filename);
	$savePos = '../cache/'.$filename;

	if(!is_uploaded_file($filetmpname)) $c->alert('정상적으로 업로드 해 주세요.');
	if(end(explode('.', $filename)) != 'opml') $c->alert('.opml 문서파일을 업로드 해 주세요.');
	if(file_exists('../cache/'.$filename)) @unlink('../cache/'.$filename);
	if(!move_uploaded_file($filetmpname, $savePos)) $c->alert('업로드를 하지 못했습니다.');
	
	$opml = @file_get_contents('../cache/'.$filename);
	$opml = @preg_replace('|<opml .+?>|sim', '<opml>', $opml);
} else $c->alert('.opml 문서파일을 업로드 해 주세요');

// DOM 파싱 처리 시도
@extract($_POST);
$p = simplexml_load_string($opml);
if(!$p) $c->alert('.opml 문서가 xml 형태가 아닙니다.');

$cntRoot = @count($p->body->outline);
for($i=0; $i<$cntRoot; $i++) {

	$cnt = count($p->body->outline[$i]);
	if($cnt) {
		for($j=0; $j<$cnt; $j++) {

			// 이미 있다면 추가하지 않음
			$url = str_replace('http://', '', $p->body->outline[$i]->outline[$j]['xmlUrl']);
			$blogURL = str_replace('http://', '', $p->body->outline[$i]->outline[$j]['htmlUrl']);
			$getExist = $c->db->query('select uid from '.$c->prefix.'feed_list where url = \''.$blogURL.'\' limit 1');
			$checkExist = $getExist->fetch_array();
			if($checkExist['uid'] || (!$url && !$blogURL)) continue;

			// 추가 처리하기
			$name = htmlspecialchars(addslashes(str_replace(array('<![CDATA[', ']]>'), '', $p->body->outline[$i]->outline[$j]['title'])));
			$info = htmlspecialchars(addslashes(str_replace(array('<![CDATA[', ']]>'), '', $p->body->outline[$i]->outline[$j]['description'])));
			$img = $p->body->outline[$i]->outline[$j]['img']; // gr paper only
			$c->db->query('insert into '.$c->prefix."feed_list set uid = '', group_uid = '$opmlGroupUid', xml = '$url', url = '$blogURL', ".
				"img = '$img', name = '$name', info = '$info', is_open = '1', last_update = 0, total = 0");
			$insertID = $c->db->insert_id;
			$c->db->query('update '.$c->prefix.'feed_group set count = count + 1 where uid = '.$opmlGroupUid.' limit 1');
		}
	} else {
		// 이미 있다면 추가하지 않음
		$url = str_replace('http://', '', $p->body->outline[$i]['xmlUrl']);
		$blogURL = str_replace('http://', '', $p->body->outline[$i]['htmlUrl']);
		$getExist = $c->db->query('select uid from '.$c->prefix.'feed_list where url = \''.$blogURL.'\' limit 1');
		$checkExist = $getExist->fetch_array();
		if($checkExist['uid'] || (!$url && !$blogURL)) continue;

		// 추가 처리하기
		$name = htmlspecialchars(addslashes(str_replace(array('<![CDATA[', ']]>'), '', $p->body->outline[$i]['title'])));
		$info = htmlspecialchars(addslashes(str_replace(array('<![CDATA[', ']]>'), '', $p->body->outline[$i]['description'])));
		$img = $p->body->outline[$i]['img']; // gr paper only
		$c->db->query('insert into '.$c->prefix."feed_list set uid = '', group_uid = '$opmlGroupUid', xml = '$url', url = '$blogURL', ".
			"img = '$img', name = '$name', info = '$info', is_open = '1', last_update = 0, total = 0");
		$insertID = $c->db->insert_id;
		$c->db->query('update '.$c->prefix.'feed_group set count = count + 1 where uid = '.$opmlGroupUid.' limit 1');
	}
}
	
// 처리 완료
$c->alert('불러온 OPML 을 구독목록에 추가했습니다.', './');
?>