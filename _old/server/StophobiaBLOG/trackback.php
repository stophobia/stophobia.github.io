<?php
// id 와 no, grkey 값 처리
if(isset($_GET['p'])) $no = $_GET['p']; else $no = $_POST['p'];
if(isset($_GET['grkey'])) $grkey = $_GET['grkey']; else $grkey = $_POST['grkey'];

// DB 에 접속
include 'lib/common.php';
dbConn();

// mod_rewrite 동작으로 no 값이 제대로 인식되지 않을 때
if(!$no) {
	$rewriteArr = @explode('/', $_SERVER['PATH_INFO']);
	$no = $rewriteArr[1];
	$grkey = $rewriteArr[2];
}

// 모든 변수의 유무를 검사
if(!$no or !$_POST['url'] or !$_POST['title'] or !$_POST['blog_name'] or !$_POST['excerpt'])
{
	$path = str_replace('/trackback.php', '', $_SERVER['SCRIPT_NAME']);
	$route = $_SERVER['HTTP_HOST'].$grblog.'?p='.$no.'&error=unavailable_trackback_access';
	die('<script type="text/javascript"> location.href=\'http://'.$route.'\'; </script>');
}

// XML헤더 전송
@header('Content-Type: text/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?><response>';

// 스팸차단 (사용자 키 값에 의한 매칭 확인)
$key = @mysql_fetch_array(mysql_query('select user_key from '.$dbFIX.'config'));
$fullkey = substr(md5('grblog'.date('YmdH').$no.$key[0]), -6);
if($grkey != $fullkey) 
	die('<error>1</error><message>키 값이 맞지 않습니다. 1시간 이전에 생성된 트랙백 주소 입니다.</message></response>');

// 접근차단 IP 조회
$getKillIPList = @file_get_contents('out_ip.txt');
$tArrIP = explode(',', $getKillIPList);
$numKillIP = count($tArrIP);
if($getKillIPList)
	for($tki=0; $tki<$numKillIP; $tki++) 
		if($tArrIP[$tki] == $_SERVER['REMOTE_ADDR'])
			die('<error>1</error><message>차단된 IP 입니다.</message></response>');

// 필터링
$filterText = @file_get_contents('filter.txt');
if($filterText)
{
	$filterArray = explode(',', $filterText);
	$filterNum = count($filterArray);
	for($tf=0; $tf<$filterNum; $tf++)
	{
		if(eregi($filterArray[$tf], $_POST['excerpt']))
			die('<error>1</error><message>금지단어가 포함되어 트랙백이 거부되었습니다: '.$filterArray[$tf].'</message></response>');
	}
}

// 동일한 주소에서 온 트랙백이라면 (즉 이미 받았다면) 반려함
$isExist = @mysql_fetch_array(mysql_query('select uid from '.$dbFIX.'trackback where url = \''.$_POST['url'].'\' limit 1'));
if($isExist['uid']) die('<error>1</error><message>이미 트랙백을 받았습니다.</message></response>');

// 트랙백을 넣을 게시물이 존재하는지 검사하고 삽입
$check = @mysql_fetch_array(mysql_query('select uid from '.$dbFIX.'post where uid = '.$no));
if(!$check[0]) die('<error>1</error><message>해당 게시물이 없거나 삭제되었습니다.</message></response>');

// 이 게시물이 트랙백을 받는지 확인
$getConfig = @mysql_fetch_array(mysql_query('select use_trackback from '.$dbFIX.'config where uid = 1'));
$getUseTB = @mysql_fetch_array(mysql_query('select comment_condition from '.$dbFIX.'post where uid = '.$no));
if(!$getConfig[0] or !$getUseTB[0]) die('<error>1</error><message>'.
	'해당 게시물에 트랙백을 남길 수 없습니다.</message></response>');

// 받은 트랙백이 UTF-8 인코딩이 아니라면 EUC-KR 로 간주하여 UTF-8 로 인코딩
if(function_exists('iconv'))
{
	if(iconv('utf-8', 'utf-8', $_POST['blog_name']) != $_POST['blog_name']) $_POST['blog_name'] = iconv('euc-kr', 'utf-8', $_POST['blog_name']);
	if(iconv('utf-8', 'utf-8', $_POST['title']) != $_POST['title']) $_POST['title'] = iconv('euc-kr', 'utf-8', $_POST['title']);
	if(iconv('utf-8', 'utf-8', $_POST['excerpt']) != $_POST['excerpt']) $_POST['excerpt'] = iconv('euc-kr', 'utf-8', $_POST['excerpt']);
}

// 트랙백이 온 내용 DB 삽입
$thisTime = time();
$ip = $_SERVER['REMOTE_ADDR'];
$name = addslashes(htmlspecialchars(trim($_POST['blog_name'])));
$subject = addslashes(htmlspecialchars(trim($_POST['title'])));
$content = addslashes(htmlspecialchars(trim(cutString($_POST['excerpt'], 250))));
$subject = str_replace('&amp;amp;','&', $subject);
$content = str_replace('&amp;amp;', '&', $content);
$insertSql = "insert into ".$dbFIX."trackback set uid = '', post_uid = '$no', url = '".$_POST['url']."', ".
	"subject = '$subject', summary = '$content', name = '$name', ip = '$ip', signdate = '$thisTime'";
@mysql_query($insertSql);

// 패밀리 넘버, 코멘트 수 업데이트
@mysql_query("update ".$dbFIX."post set trackback_count = trackback_count + 1 where uid = '$no'");
	
//최종 리턴
echo '<error>0</error></response>';
?>