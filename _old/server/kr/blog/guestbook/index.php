<?php
$prefix = '../';
include $prefix.'lib/common.php';
include $prefix.'php_head.php';
include $prefix.'theme_config.php';

dbConn($prefix);
@extract($_POST);
@extract($_GET);
$path = 'http://'.$_SERVER['HTTP_HOST'].$grblog.'guestbook/';

// 스팸방지용 새 코드
if(!$_SESSION['no'] && !$guestbookSubmit && $conf_antiSpam)
	$_SESSION['antiSpam'] = substr(md5('grblogAntiSpam'.time()), -8);

// 글 삭제
if($deleteTarget && $_SESSION['no']) {
	@mysql_query('delete from '.$dbFIX.'guestbook where uid = '.$deleteTarget.' limit 1');
	@mysql_query('delete from '.$dbFIX.'guestbook where is_reply = '.$deleteTarget);
	error('글을 삭제하였습니다.', 'location.href=\''.$path.'\'');
}

// 방명록 작성완료
if($guestbookSubmit) {
	if(!$_SESSION['no'] && $conf_antiSpam && ($_SESSION['antiSpam'] != $antispam)) error('자동등록방지코드 8자리를 올바르게 입력해 주세요');
	if($conf_koreanOnly && !preg_match("/[가-힣]/uism", $content)) error('한글이 포함되어 있지 않아 타 언어 스팸으로 간주되었습니다.');
	$name = htmlspecialchars(addslashes(trim($name)));
	$password = trim($password);
	$content = htmlspecialchars(addslashes(trim($content)));
	$homepage = htmlspecialchars(trim($homepage));
	$email = htmlspecialchars(trim($email));
	if(!$name) error('이름을 입력해 주세요');
	if(!$_SESSION['no'] && !$password) error('비밀번호를 입력해 주세요');
	if(!$content) error('내용을 입력해 주세요');
	if($homepage == 'http://') $homepage = '';
	if($modifyTarget) {
		$oldPass = @mysql_fetch_array(mysql_query('select password from '.$dbFIX.'guestbook where uid = '.$modifyTarget));
		if(($oldPass['password'] != md5($password)) && !$_SESSION['no']) error('비밀번호가 맞지 않습니다');
		$msg = '수정';
		$sql = "update {$dbFIX}guestbook set name = '$name', homepage = '$homepage', content = '$content', is_secret = '$isSecret', email = '$email' where uid = '$modifyTarget' limit 1";
	} else {
		$msg = '작성';
		$sql = "insert into {$dbFIX}guestbook set uid = '', name = '$name', password = '".md5($password)."', homepage = '$homepage', ".
			"content = '$content', is_secret = '$isSecret', is_reply = '$replyTarget', signdate = '".time()."', email = '$email'";
	}
	@mysql_query($sql);
	error('방명록에 글을 '.$msg.'하였습니다', 'location.href=\''.$path.'?page='.$page.'\';');
}

// 설정 가져오기
$config = @mysql_fetch_array(mysql_query('select * from '.$dbFIX.'config where uid = \'1\''));
$theme = 'theme/'.$config['theme'];
$blogInfo = stripslashes($config['blog_info']);

// 글수정 or 답글 달 때 내용 가져오기
if($modifyTarget || $replyTarget) {
	$modify = @mysql_fetch_array(mysql_query('select * from '.$dbFIX.'guestbook where uid = '.(($modifyTarget)?$modifyTarget:$replyTarget)));
	if($modify['is_secret']) $modify = array();
	$modify['content'] = ':'.str_replace("\n", "\n:", $modify['content']);
	if($_SESSION['no'] && $replyTarget) {
		$modify['name'] = $config['name'];
		$modify['homepage'] = $config['homepage'];
		$modify['email'] = $config['email'];
	}
}

// 테마 상단
$absPath = 'http://'.$_SERVER['HTTP_HOST'].$grblog;
$blogTitle = stripslashes($config['blog_title']);
$getLatestPost = @mysql_fetch_array(mysql_query('select subject from '.$dbFIX.'post where post_condition = 1 order by uid desc limit 1'));
$browserTitle = $blogTitle.' - '.stripslashes($getLatestPost[0]);
include $prefix.$theme.'/head.php';
include $prefix.$theme.'/guestbook_list_head.php';

// 페이징 처리
if(!$page) $page = 1;
$fromRecord = ($page - 1) * $config['num_per_page'];
$getTotalNum = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'guestbook where is_reply = 0'));
$totalCount = $getTotalNum[0];
$getMaxUid = @mysql_fetch_array(mysql_query('select max(uid) from '.$dbFIX.'guestbook where is_reply = 0'));
$maxNo = $getMaxUid[0];
$arrange = 100;

// 범주의 크기를 구분해서 처리
if($totalCount > $arrange)
{
	if(!$division) { $division = ceil($totalCount / $arrange); $originDivision = $division; }
	$moreThanMe = ($division - 1) * $arrange;
	$lessThanMe = $division * $arrange;
	if(($originDivision == $division) && ($maxNo > $lessThanMe)) $lessThanMe = $maxNo;
	$getRealMax = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'guestbook where uid > '.$moreThanMe.' and uid <= '.$lessThanMe.' and is_reply = 0'));
	$totalPage = ceil($getRealMax[0] / $config['num_per_page']);
	$rangeQue = ' where uid >= '.$moreThanMe.' and uid <= '.$lessThanMe.' and is_reply = 0';
}
else
{
	if(!$division) { $division = 0; $originDivision = 0; }
	$totalPage = ceil($totalCount / $config['num_per_page']);
	$rangeQue = ' where is_reply = 0';
}

// 목록 뿌리기
$getGuest = mysql_query('select * from '.$dbFIX.'guestbook'.$rangeQue.' order by uid desc limit '.$fromRecord.', '.$config['num_per_page']);
while($guest = mysql_fetch_array($getGuest)) {
	$name = stripslashes($guest['name']);
	if($guest['homepage']) $name = '<a href="'.$guest['homepage'].'" onclick="window.open(this.href, \'_blank\'); return false">'.$name.'</a>';
	$date = date('m/d H:i', $guest['signdate']);
	$content = nl2br(stripslashes($guest['content']));
	if($guest['is_secret'] && !$_SESSION['no']) {
		$name = '?';
		$content = '<span style="color: red">비밀 댓글 입니다</span>';
	}

	// 방명록 글 스킨 include
	include $prefix.$theme.'/guestbook_list.php';

	// 이 글에 대한 답글 뿌리기
	$getReplyGuest = @mysql_query('select * from '.$dbFIX.'guestbook where is_reply = '.$guest['uid'].' order by uid asc');
	while($reply = mysql_fetch_array($getReplyGuest)) {
		$name = stripslashes($reply['name']);
		$date = date('m/d H:i', $reply['signdate']);
		$content = nl2br(stripslashes($reply['content']));
		if($reply['is_secret'] && !$_SESSION['no']) {
			$name = '?';
			$content = '<span style="color: red">비밀 답글 입니다</span>';
		}
		
		// 방명록 답글 스킨 include
		include $prefix.$theme.'/guestbook_list_reply.php';

	} #while reply
} #while

$paging = getPaging($config['num_per_page'], $page, $totalPage, $path.'?page=', $division, $originDivision);

echo '</div>'; # end div "guestbook"

// 테마 사이드, 하단
include $prefix.$theme.'/sidebar.php';
include $prefix.$theme.'/foot.php';
?>