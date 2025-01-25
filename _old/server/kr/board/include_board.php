<?php
// 보안처리
$_GET['grboard'] = $_POST['grboard'] = $_REQUEST['grboard'] = false;
if(!$grboard) exit();

// 아웃로긴 함수 정의
function outlogin($theme) {
	global $grboard, $dbFIX;
	$path = 'outlogin/'.$theme;
	if(!is_dir($path)) die('GR Board 내의 outlogin 폴더 안에 지정한 '.$theme.' 스킨이 존재하지 않습니다.');
	if($_SESSION['no']) 	{
		$sessionNo = $_SESSION['no'];
		$getInfo = @mysql_query('select id, nickname, make_time, level, point from '.$dbFIX.'member_list where no = '.$sessionNo) || die('GR Board 가 귀하의 멤버정보를 가져오지 못했습니다.');
		$login = @mysql_fetch_array($getInfo);
		include $path.'/logged.php';
	} else {
		$sessionNo = 0;
		if($_GET['boardID']) $_GET['id'] = $_GET['boardID'];
		include $path.'/login.php';
	}
}

// 문자열 자르기
function cutString($str, $size=0) {
	if($size<=0) return $str;
	if(function_exists('mb_strcut')) return mb_strcut($str, 0, $size, 'utf-8');
	$result = substr($str, 0, $size);
	preg_match('/^([\\x00-\\x7e]|.{3})*/', $result, $string);
	return $string[0];
}

// 최근게시물 함수 정의
function latest($theme, $id, $listNum=5, $cutSize=0, $getContent=0, $cutContentSize=0, $dateFormat='Y.m.d', $latestTitle='최근게시물', $orderBy='no', $desc='desc') {
	global $dbFIX;
	$path = 'latest/'.$theme;
	if(!is_dir($path)) { echo 'GR Board 내의 latest 폴더 안에 지정한 '.$theme.' 테마가 존재하지 않습니다.'; return; }
	if($getContent) $addQue = ', content';	else $addQue = '';
	$getData = @mysql_query('select no, name, signdate, comment_count, category, subject'.$addQue.' from '.$dbFIX.'bbs_'.$id.' order by '.$orderBy.' '.$desc.' limit '.$listNum);
	include $path.'/list.php';
}

// 통합 최근게시물 함수 정의
function total_article_latest($theme, $listNum=5, $cutSize=0, $dateFormat='Y.m.d', $latestTitle='통합 최근게시물', $isSecret=false, $orderBy='no', $desc='desc', $boardList='') {
	global $dbFIX;
	$path = 'latest/'.$theme;
	if(!is_dir($path)) { echo 'GR Board 내의 latest 폴더 안에 지정한 '.$theme.' 테마가 존재하지 않습니다.'; return; }
	if(!$isSecret) $addQ = 'where is_secret != 1 '; else $addQ = 'where is_secret != 99 ';
	if($boardList) $addQ .= "and id = '".str_replace('|', "' or id = '", $boardList)."' ";
	$getData = @mysql_query('select * from '.$dbFIX.'total_article '.$addQ.'order by '.$orderBy.' '.$desc.' limit '.$listNum);
	include $path.'/list.php';
}

// 통합 최근코멘트 함수 정의
function total_comment_latest($theme, $listNum=5, $cutSize=0, $dateFormat='Y.m.d', $latestTitle='통합 최근코멘트', $isSecret=false, $orderBy='no', $desc='desc', $boardList='') {
	global $dbFIX;
	$path = 'latest/'.$theme;
	if(!is_dir($path)) { echo 'GR Board 내의 latest 폴더 안에 지정한 '.$theme.' 테마가 존재하지 않습니다.'; return; }
	if(!$isSecret) $addQ = 'where is_secret != 1 '; else $addQ = 'where is_secret != 99 ';
	if($boardList) $addQ .= "and id = '".str_replace('|', "' or id = '", $boardList)."' ";
	$getData = @mysql_query('select * from '.$dbFIX.'total_comment '.$addQ.'order by '.$orderBy.' '.$desc.' limit '.$listNum);
	include $path.'/list.php';
}

// 설문조사 함수 정의
function poll($theme) {
	global $grboard, $dbFIX;
	$path = $grboard.'/latest/'.$theme;
	if(!is_dir($path)) die('GR Board 내의 latest 폴더 안에 지정한 '.$theme.' 테마가 존재하지 않습니다.');
	$getSubject = @mysql_fetch_array(mysql_query('select no, subject from '.$dbFIX.'poll_subject where id = \'\' order by no desc limit 1'));
	$subject = stripslashes($getSubject['subject']);
	$pollNo = $getSubject['no'];
	$getOptions = @mysql_query('select no, title from '.$dbFIX.'poll_option where poll_no = '.$pollNo.' order by no asc');
	include $path.'/poll.php';
}

// 통합검색폼 함수 정의
function total_search($theme, $listNum=10) {
	global $grboard, $dbFIX;
	$path = $grboard.'/latest/'.$theme;
	if(!is_dir($path)) { echo 'GR Board 내의 latest 폴더 안에 지정한 '.$theme.' 테마가 존재하지 않습니다.'; return; }
	include $path.'/list.php';
}

// 통합 태그 구름 함수 정의
function total_tag_latest($theme, $listNum=5, $latestTitle='태그 구름', $orderBy='no', $desc='desc', $boardList='') {
	global $grboard, $dbFIX;
	$path = $grboard.'/latest/'.$theme;
	if(!is_dir($path)) { echo 'GR Board 내의 latest 폴더 안에 지정한 '.$theme.' 테마가 존재하지 않습니다.'; return; }
	if($boardList) $addQ = "where id = '".str_replace('|', "' or id = '", $boardList)."' ";
	$getData = @mysql_query('select * from '.$dbFIX.'tag_list '.$addQ.'order by '.$orderBy.' '.$desc.' limit '.$listNum);
	include $path.'/list.php';
}

// 현재 접속자 목록 함수 정의
function now_connect_list($theme, $listNum=20, $latestTitle='현재 접속자', $orderBy='lastlogin', $desc='desc') {
	global $grboard, $dbFIX, $timeDiff;
	$path = $grboard.'/latest/'.$theme;
	$_time = time()+$timeDiff;
	if(!is_dir($path)) { echo 'GR Board 내의 latest 폴더 안에 지정한 '.$theme.' 테마가 존재하지 않습니다.'; return; }
	if($_SESSION['no']) @mysql_query('update '.$dbFIX.'member_list set lastlogin = \''.$_time.'\' where no = '.$_SESSION['no']);
	$getData = @mysql_query('select no, id, nickname, nametag, icon from '.$dbFIX.'member_list where lastlogin > '.($_time-600).' order by '.$orderBy.' '.$desc.' limit '.$listNum);
	include $path.'/list.php';
}

// 게시판 이름 가져오기 정의
function get_bbs_name($id) {
	global $grboard, $dbFIX;
	$result = @mysql_fetch_array(mysql_query('select name from '.$dbFIX.'board_list where id = \''.$id.'\''));
	return $result['name'];
}
?>