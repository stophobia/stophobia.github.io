<?php
// 기본 클래스를 불러온다.
require 'class/common.php';
$GR = new COMMON;

// 관리자인지 확인한다.
if($_SESSION['no']) {
	if($_SESSION['no'] != 1) $GR->error('관리자 화면은 관리자만 접근할 수 있습니다.<br />'.
		'첫화면으로 가길 원하시면 <a href=http://'.$_SERVER['HTTP_HOST'].'>이 곳을 클릭하세요!</a>', 1);
} else $GR->error('로그인을 해주세요.', 0, 'login.php?adminGo=1');

// 캐쉬 이미지들 모두 정리하기
if(array_key_exists('cacheImgDelete', $_GET) && $_GET['cacheImgDelete']) {
	function rmrf($dir, $isRootDelete=false) {
		if(!$dh = @opendir($dir)) return;
		while (false !== ($obj = @readdir($dh))) {
			if($obj == '.' || $obj == '..') continue;
			if(!@unlink($dir . '/' . $obj)) rmrf($dir.'/'.$obj, true);
		}
		@closedir($dh);	   
		if ($isRootDelete) @rmdir($dir);	   
		return;
	}
	rmrf('phpThumb/cache/');
	$GR->error('썸네일용으로 생성된 캐쉬 이미지들을 모두 정리했습니다.', 0, 'admin.php');
}

// 페이지용 변수 처리
if($_GET['page']) $page = $_GET['page']; else $page = 1;

// rewrite 모듈 사용여부 처리
if(array_key_exists('rewrite', $_GET) && $_GET['rewrite']) {
	if($_GET['rewrite'] == 'on') @rename('./no.use.htaccess', './.htaccess');
	else @rename('./.htaccess', './no.use.htaccess');
	$GR->error('주소 재작성기(mod_rewrite)를 '.$_GET['rewrite'].' 했습니다.', 0, 'admin.php');
}

// 세션을 모두 삭제한다면 처리
if(array_key_exists('sessionDelete', $_GET) && $_GET['sessionDelete']) {
	$openSessionDir = @opendir('session');
	while($deleteSession = @readdir($openSessionDir)) {
		if($deleteSession == '.' || $deleteSession == '..') continue;
		@unlink('session/'.$deleteSession);
	}
	@closedir($openSessionDir);
	$GR->error('사용중이던 모든 세션을 삭제했습니다.', 0, 'admin.php');
}

// 시간 동기화 설정
if(array_key_exists('timeSync', $_GET) && $_GET['timeSync']) {
	@chmod('db_info.php', 0707);
	include 'db_info.php';
	$timeDiff = $_GET['diff'];
	$saveDbInfo  = '<?php'."\n";
	$saveDbInfo .= '$hostName = \''.$hostName.'\';'."\n";
	$saveDbInfo .= '$userId = \''.$userId.'\';'."\n";
	$saveDbInfo .= '$password = \''.$password.'\';'."\n";
	$saveDbInfo .= '$dbName = \''.$dbName.'\';'."\n";
	$saveDbInfo .= '$dbFIX = \''.$dbFIX.'\';'."\n";
	$saveDbInfo .= '$timeDiff = '.$timeDiff.';'."\n";
	$saveDbInfo .= '@mysql_connect($hostName, $userId, $password);'."\n";
	$saveDbInfo .= '@mysql_select_db($dbName);'."\n";
	$saveDbInfo .= '#@mysql_query(\'set names utf8\'); // 한글이 깨져보일 경우 이 줄 맨 앞에 # 을 제거'."\n";
	$saveDbInfo .= '?>'."\n";
	$fileCreate = @fopen('db_info.php', 'w');
	@fwrite($fileCreate, $saveDbInfo);
	@fclose($fileCreate);
	@chmod('db_info.php', 0404);
	$GR->error('GR보드에게 새 기준시간을 알려주었습니다.', 0, 'admin.php');
}

// 필터링 단어 수정시 처리
if(array_key_exists('modifyFilter', $_POST) && $_POST['modifyFilter']) {
	$filterForm = str_replace("\n", '', trim($_POST['filterForm']));
	$openFilterFile = @fopen('filter.txt', 'w');
	@fwrite($openFilterFile, $filterForm);
	@fclose($openFilterFile);
}

// 접근금지 IP 수정시 처리
if(array_key_exists('modifyKillIP', $_POST) && $_POST['modifyKillIP']) {
	$killIPForm = str_replace("\n", '', trim($_POST['killIPForm']));
	$openKillIPFile = @fopen('out_ip.txt', 'w');
	@fwrite($openKillIPFile, $killIPForm);
	@fclose($openKillIPFile);
}

// DB 에 연결한다.
$GR->dbConn();

// 신고 목록 정리하기
if(array_key_exists('reportListDelete', $_GET) && $_GET['reportListDelete']) {
	@mysql_query('truncate table '.$dbFIX.'report');
	$GR->error('신고 목록들을 모두 초기화 했습니다.', 0, 'admin.php');
}

// 로그인 기록을 모두 정리한다면 처리
if(array_key_exists('loginLogDelete', $_GET) && $_GET['loginLogDelete']) {
	@mysql_query('truncate table '.$dbFIX.'login_log');
	$GR->error('보관중이던 로그인 시간 기록들을 모두 초기화 했습니다.', 0, 'admin.php');
}

// 서브 페이지들 테마 설정 처리
if($_POST['subPageConfirm']) {
	@mysql_query('update '.$dbFIX."layout_config set var = '".$_POST['loginTheme']."' where opt = 'outlogin_skin'");
	@mysql_query('update '.$dbFIX."layout_config set var = '".$_POST['memoTheme']."' where opt = 'memo_skin'");
	@mysql_query('update '.$dbFIX."layout_config set var = '".$_POST['joinTheme']."' where opt = 'join_skin'");
	@mysql_query('update '.$dbFIX."layout_config set var = '".$_POST['scrapTheme']."' where opt = 'scrap_view_skin'");
	@mysql_query('update '.$dbFIX."layout_config set var = '".$_POST['reportTheme']."' where opt = 'report_skin'");
	@mysql_query('update '.$dbFIX."layout_config set var = '".$_POST['notifyTheme']."' where opt = 'notify_skin'");
	@mysql_query('update '.$dbFIX."layout_config set var = '".$_POST['infoTheme']."' where opt = 'info_skin'");
	$GR->error('서브페이지들의 테마를 설정하였습니다.', 0, 'admin.php');
}

// 오류 로그를 모두 삭제한다면 처리
if(array_key_exists('errorLogDelete', $_GET) && $_GET['errorLogDelete']) {
	@mysql_query('delete from '.$dbFIX.'error_save');
	$GR->error('모든 오류 정보가 삭제되었습니다', 0, 'admin.php');
}

// 쪽지함을 정리한다면 처리
if(array_key_exists('memoDelete', $_GET) && $_GET['memoDelete']) {
	$thisTime = $GR->grTime();
	$lessThenMe = $thisTime - 604800;
	@mysql_query('delete from '.$dbFIX.'memo_save where signdate < '.$lessThenMe);
	$GR->error('오래된 쪽지들을 모두 정리했습니다.', 0, 'admin.php');
}

// 사용중인 Table 의 오류들을 수정하고 최적화 한다.
if(array_key_exists("repairDB", $_GET) && $_GET['repairDB']) {
	$getAllTable = @mysql_query('select id from '.$dbFIX.'board_list');
	while($table = mysql_fetch_array($getAllTable)) {
		$repairTarget = $table['id'];
		@mysql_query('repair table '.$dbFIX.'bbs_'.$repairTarget);
		@mysql_query('repair table '.$dbFIX.'comment_'.$repairTarget);
		@mysql_query('optimize table '.$dbFIX.'bbs_'.$repairTarget);
		@mysql_query('optimize table '.$dbFIX.'comment_'.$repairTarget);
	}
	@mysql_query('repair table '.$dbFIX.'board_list');
	@mysql_query('repair table '.$dbFIX.'member_list');
	@mysql_query('repair table '.$dbFIX.'error_save');
	@mysql_query('repair table '.$dbFIX.'pds_save');
	@mysql_query('repair table '.$dbFIX.'trackback_save');
	@mysql_query('repair table '.$dbFIX.'group_list');
	@mysql_query('repair table '.$dbFIX.'poll_option');
	@mysql_query('repair table '.$dbFIX.'poll_comment');
	@mysql_query('repair table '.$dbFIX.'poll_subject');
	@mysql_query('repair table '.$dbFIX.'time_bomb');
	@mysql_query('repair table '.$dbFIX.'total_article');
	@mysql_query('repair table '.$dbFIX.'total_comment');
	@mysql_query('repair table '.$dbFIX.'member_group');
	@mysql_query('repair table '.$dbFIX.'scrap_book');
	@mysql_query('repair table '.$dbFIX.'report');
	@mysql_query('repair table '.$dbFIX.'auto_save');
	@mysql_query('repair table '.$dbFIX.'pds_extend');
	@mysql_query('repair table '.$dbFIX.'tag_list');
	@mysql_query('repair table '.$dbFIX.'article_option');
	@mysql_query('repair table '.$dbFIX.'login_log');
	@mysql_query('optimize table '.$dbFIX.'board_list');
	@mysql_query('optimize table '.$dbFIX.'member_list');
	@mysql_query('optimize table '.$dbFIX.'error_save');
	@mysql_query('optimize table '.$dbFIX.'pds_save');
	@mysql_query('optimize table '.$dbFIX.'trackback_save');
	@mysql_query('optimize table '.$dbFIX.'group_list');
	@mysql_query('optimize table '.$dbFIX.'poll_option');
	@mysql_query('optimize table '.$dbFIX.'poll_comment');
	@mysql_query('optimize table '.$dbFIX.'poll_subject');
	@mysql_query('optimize table '.$dbFIX.'time_bomb');
	@mysql_query('optimize table '.$dbFIX.'total_article');
	@mysql_query('optimize table '.$dbFIX.'total_comment');
	@mysql_query('optimize table '.$dbFIX.'member_group');
	@mysql_query('optimize table '.$dbFIX.'scrap_book');
	@mysql_query('optimize table '.$dbFIX.'report');
	@mysql_query('optimize table '.$dbFIX.'auto_save');
	@mysql_query('optimize table '.$dbFIX.'pds_extend');
	@mysql_query('optimize table '.$dbFIX.'tag_list');
	@mysql_query('optimize table '.$dbFIX.'article_option');
	@mysql_query('optimize table '.$dbFIX.'login_log');
	$GR->error('모든 테이블의 오류를 수정하고, 최적화를 실시했습니다.', 0, 'admin.php');
}

// 따로 모아진 트랙백 중 선택된 트랙백 삭제 처리
if(array_key_exists('deleteTrackbackNo', $_GET) && $_GET['deleteTrackbackNo']) {
	@mysql_query('delete from '.$dbFIX.'trackback_save where no = '.$_GET['deleteTrackbackNo']);
	$GR->error('해당 트랙백을 삭제했습니다.', 0, 'admin.php');
}

// 트랙백을 모두 삭제 처리
if(array_key_exists('deleteTrackback', $_GET) && $_GET['deleteTrackback']) {
	@mysql_query('truncate table '.$dbFIX.'trackback_save');
	$GR->error('별도로 기록된 트랙백들을 모두 삭제했습니다.', 0, 'admin.php');
}

// 통합 최근 게시물/댓글 테이블 정리
if(array_key_exists('confirmTotalLatestNow', $_GET) && $_GET['confirmTotalLatestNow']) {
	$getLatestTotalPost = @mysql_query('select no, id, article_num from '.$dbFIX.'total_article order by no desc limit 1000');
	while($lps = @mysql_fetch_array($getLatestTotalPost)) {
		$isLinkAvailable = @mysql_fetch_array(mysql_query('select no from '.$dbFIX.'bbs_'.$lps['id'].' where no = '.$lps['article_num']));
		if(!$isLinkAvailable['no']) @mysql_query('delete from '.$dbFIX.'total_article where no = '.$lps['no']);
	}
	$getLatestTotalReply = @mysql_query('select no, id, article_num from '.$dbFIX.'total_comment order by no desc limit 1000');
	while($lcs = @mysql_fetch_array($getLatestTotalReply)) {
		$isLinkAvailable = @mysql_fetch_array(mysql_query('select no from '.$dbFIX.'comment_'.$lcs['id'].' where board_no = '.$lcs['article_num']));
		if(!$isLinkAvailable['no']) @mysql_query('delete from '.$dbFIX.'total_comment where no = '.$lcs['no']);
	}
	$GR->error('통합 최근 게시물/댓글 테이블에 기록된 정보들의 유효성을 점검했습니다.', 0, 'admin.php');
}

// 각종 레코드 수를 구한다.
$totalBoardNum = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'board_list'));
$totalMemberNum = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'member_list'));
$totalPdsNum = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'pds_save'));
$totalPdsExtendNum = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'pds_extend'));
$totalErrorNum = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'error_save'));
$totalMemoNum = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'memo_save'));
$totalTrackbackNum = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'trackback_save'));
$totalPollCommentNum = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'poll_comment'));
$totalLoginLogNum = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'login_log'));

// 사용중인 세션파일을 구한다.
$sessionDirOpen = @opendir('session');
$totalSession = 0;
$sessionSize = 0;
while($readSession = @readdir($sessionDirOpen)) {
	if($readSession == '.' || $readSession == '..') continue;
	$totalSession++;
	$sessionSize = $sessionSize + @filesize('session/'.$readSession);
}
@closedir($sessionDirOpen);

// 문서설정
$title = 'GR Board Admin Page';
$encoding = 'utf-8';
include 'html_head.php';
?>