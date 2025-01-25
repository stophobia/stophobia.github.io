<?php
/*
	GR Paper RSS피드 수집기
	작성자: 박희근 (http://sirini.net)
	수정일: 2009-1-12
	내  용: 등록된 RSS피드들을 일정 간격으로 수집함. (페이지 리로드시)
	참  고: 수집된 기록은 <prefix>log 테이블에 기록됨 (수집 성공/실패, 업데이트 여부등 기록됨)
	          이 수집기는 Ajax 요청을 받으면 실행되지만 어떠한 리턴도 하지 않음. (XML출력도 하지 않음)
			  HTTP Request 는 텍스트큐브 니들웍스의 라이브러리를 사용함
	주  의: 등록된 RSS피드수가 많아질 경우 이 수집기의 동작으로 서버에 부하가 걸리게 됨.
*/

// 라이브러리 호출
include 'library/external/Needlworks.PHP.HTTPRequest.php';
$tc = new HTTPRequest();

// 수집간격 확인
if(!$_POST['x']) die('정상적으로 수집기를 실행해 주세요.');
include 'db.info.php';
$time = time();
$lastRun = @$db->query('select signdate from '.$dbinfo['prefix'].'log where log !=\'\' order by uid desc limit 1')->fetch_array();
$botTerm = @$db->query('select var from '.$dbinfo['prefix'].'skin where opt = \'botTerm\' limit 1')->fetch_array();
$botTerm['var'] *= 60;
if(!$_POST['just'] && ($lastRun['signdate']+$botTerm['var']) > $time) die('아직 수집하기엔 지정한 수집간격보다 빠릅니다.');

// 수집중에 다시 요청이 올 경우를 대비함
@$db->query('insert into '.$dbinfo['prefix']."log set uid = '', log = '', signdate = '$time'");
$tmpUid = $db->insert_id;

// HTML 캐쉬 정리
$cd = dir('./cache');
while($oldCache = $cd->read()) {
	if($oldCache == '.' || $oldCache == '..') continue;
	@unlink('./cache/'.$oldCache);
}
$cd->close();

// 수집 시작
@set_time_limit(0);
$log = date('Y년 m월 d일 H시 i분 s초').' 부터 GR Paper RSS피드 수집기 실행'."\n";
$rssList = @$db->query('select uid, xml, last_update from '.$dbinfo['prefix'].'feed_list');
$maxTagUid = @$db->query('select uid from '.$dbinfo['prefix'].'tag order by uid desc limit 1')->fetch_array();

// 피드 주소 순회 시작 (1 depth)
while($r = $rssList->fetch_array()) {
	if(($r['last_update']+$botTerm['var']) > $time) {
		$log .= $r['xml'].' 은 조금 전 수집했음으로 제외'."\n";
		@$db->query('update '.$dbinfo['prefix']."log set log = '$log', signdate = '".time()."' where uid = ".$tmpUid);
		continue;
	}
	$tc->url = 'http://'.$r['xml'];
	if(!$tc->send()) {
		$log .= '<span class="lost">'.$r['xml'].' 은 현재 접속불가함으로 제외</span>'."\n";
		continue;
	}
	$p = @simplexml_load_string($tc->responseText);
	if(!$p->channel[0]->link) {
		$log .= '<span class="lost">'.$r['xml'].' 은 RSS 로 해석되지 않아서 제외</span>'."\n";
		continue;
	}
	$testLink = str_replace('http://', '', $p->channel[0]->item[0]->link);
	$blogUid = @$db->query('select uid from '.$dbinfo['prefix'].'feed_list where url = \''.str_replace('http://', '', $p->channel[0]->link).'\' limit 1')->fetch_array();
	if(!$blogUid['uid']) {
		$log .= '<span class="lost">'.$r['xml'].' 은 도메인 변경등의 이유로 블로그 주소가 맞지 않아 제외</span>'."\n";
		continue;
	}
	$getExist = @$db->query('select uid from '.$dbinfo['prefix'].'feed where blog_uid = \''.$blogUid['uid'].'\' and link = \''.$testLink.'\' order by uid desc limit 1')->fetch_array();
	if($getExist['uid']) {
		$log .= $r['xml'].' 은 이미 최근글까지 업데이트 되었음으로 제외'."\n";
		continue;
	}
	
	// 이 RSS의 파싱, 저장 순회 시작 (2 depth)
	$rssTotalNum = count($p->channel[0]->item);
	for($i=0; $i<$rssTotalNum; $i++) {
		$link = str_replace('http://', '', $p->channel[0]->item[$i]->link);
		$getExistLink = @$db->query('select uid from '.$dbinfo['prefix'].'feed where blog_uid = '.$blogUid['uid'].' and link = \''.$link.'\' limit 1');
		if($getExistLink) {
			$linkExist = $getExistLink->fetch_array();
			if($linkExist['uid']) break;
		}
		$subject = addslashes($p->channel[0]->item[$i]->title);
		$content = addslashes(strip_tags(addslashes($p->channel[0]->item[$i]->description)));
		$author = addslashes($p->channel[0]->item[$i]->author);
		$cntTag = count($p->channel[0]->item[$i]->category);
		
		// 태그 처리 순회 시작 (3 depth)
		$tag = '';
		for($t=0; $t<$cntTag; $t++) {
			$tagName = addslashes(strip_tags(strtolower($p->channel[0]->item[$i]->category[$t])));
			$getTag = @$db->query('select uid from '.$dbinfo['prefix'].'tag where tag = \''.$tagName.'\' order by count desc limit 1')->fetch_array();
			if($getTag['uid']) @$db->query('update '.$dbinfo['prefix'].'tag set count = count + 1 where uid = '.$getTag['uid']);
			else @$db->query('insert into '.$dbinfo['prefix']."tag set uid = '', tag = '".$tagName."', count = 0");
			$tag .= $tagName.',';
		} # for
		
		$tag = substr($tag, 0, -1);
		$signdate = strtotime($p->channel[0]->item[$i]->pubDate);
		@$db->query('insert into '.$dbinfo['prefix']."feed set uid = '', blog_uid = '".$blogUid['uid']."', link = '$link', subject = '$subject', content = '$content', author = '$author', signdate = '$signdate', hit = 0, tag = '$tag'");
		
		// 그림 한개 뽑아서 저장
		preg_match('|<img(.+?)src="(.+?)" (.+?) />|i', $p->channel[0]->item[$i]->description, $previewImg);
		if($previewImg[2]) {
			$imgSrc = strip_tags(str_replace('http://', '', $previewImg[2]));
			$isImgSaved = @$db->query('select uid from '.$dbinfo['prefix'].'image where url = \''.$imgSrc.'\' limit 1')->fetch_array();
			if(!$isImgSaved['uid']) @$db->query('insert into '.$dbinfo['prefix']."image set uid = '', feed_uid = '".$db->insert_id."', url = '$imgSrc'");
		}
		usleep(100000);
	} # for
	
	@$db->query('update '.$dbinfo['prefix']."feed_list set last_update = '".time()."', total = total + $i where uid = ".$blogUid['uid']);
	$log .= $r['xml'].' 총 '.$i.'개의 새 글 업데이트함'."\n";

	// 로그 기록 (하나씩 완료할 때마다 업데이트)
	@$db->query('update '.$dbinfo['prefix']."log set log = '$log', signdate = '".time()."' where uid = ".$tmpUid);
	
} # while

// 로그 기록
$_time = time();
$log .= date('Y년 m월 d일 H시 i분 s초').' 에 RSS 수집기 실행완료함';
@$db->query('update '.$dbinfo['prefix']."log set log = '$log', signdate = '$_time' where uid = ".$tmpUid);
?>