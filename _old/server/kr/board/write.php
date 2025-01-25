<?php
// 기본 클래스를 부른다
include 'class/common.php';
$GR = new COMMON;

// 접근차단 IP 조회
$getKillIPList = @file_get_contents('out_ip.txt');
$tArrIP = explode(',', $getKillIPList);
$numKillIP = count($tArrIP);
if($getKillIPList) for($tki=0; $tki<$numKillIP; $tki++) if($tArrIP[$tki] == $_SERVER['REMOTE_ADDR']) $GR->error('차단된 IP 입니다.');

// 변수 처리
if(isset($_GET['id']) && $_GET['id']) $id = $_GET['id'];
if(isset($_GET['articleNo']) && $_GET['articleNo']) $articleNo = $_GET['articleNo'];
if(isset($_GET['page']) && $_GET['page']) $page = $_GET['page'];
if(isset($_GET['mode']) && $_GET['mode']) $mode = $_GET['mode'];
if(isset($_GET['alreadyEnterPassword']) && $_GET['alreadyEnterPassword']) $alreadyEnterPassword = $_GET['alreadyEnterPassword'];
if(isset($_GET['isReported'])) $isReported = $_GET['isReported'];
if(isset($_GET['clickCategory']) && $_GET['clickCategory']) $clickCategory = $_GET['clickCategory']; // 카테고리 선택 후, 글쓰기 할때 자동선택 설정 | 2010-02-07 Coder PicoZ , Editor 이동규
$grboard = str_replace('/'.end(explode('/', $_SERVER['REQUEST_URI'])), '', $_SERVER['REQUEST_URI']);

// DB 에 연결한다.
$GR->dbConn();

// 글쓴이 권한값 가져오기
if($_SESSION['no']) {
	$tmpFetch = @mysql_fetch_array(mysql_query('select id, level from '.$dbFIX.'member_list where no = '.$_SESSION['no']));
	$writerLevel = $tmpFetch['level'];
	if($_SESSION['no'] == 1) $isAdmin = 1; else $isAdmin = 0;
	$isMember = 1;

	// 게시판 마스터들은 관리자와 동등한 권한 유지
	$getMasters = @mysql_fetch_array(mysql_query('select master from '.$dbFIX.'board_list where id = \''.$id.'\''));
	if($getMasters[0]) {
		$masterArr = @explode('|', $getMasters[0]);
		$masterNum = @count($masterArr)+1;
		for($m=0; $m<$masterNum; $m++) {
			if($_SESSION['mId'] && ($_SESSION['mId'] == $masterArr[$m])) {
				$isAdmin = 1;
				break;
			}
		}
	}

// 비회원일 경우 처리
} else {
	$writerLevel = 1;
	$isAdmin = 0;
	$isMember = 0;
	$isMaster = 0;

	// 스팸방지용 질문코드 (산수)
	if(!$_SESSION['no']) {
		$antiSpam0 = mt_rand(1, 9);
		$antiSpam1 = mt_rand(1, 9);
		$antiSpam2 = mt_rand(0, 1);
		if($antiSpam2) {
			$_SESSION['antiSpam'] = $antiSpam0 + $antiSpam1;
			$antiSpam3 = '+';
		}
		else {
			$_SESSION['antiSpam'] = $antiSpam0 * $antiSpam1;
			$antiSpam3 = 'x';
		}
	}
}

// 현재 게시판의 접근권한을 확인한다.
$isWriteOk = @mysql_fetch_array(mysql_query("select write_level from {$dbFIX}board_list where id = '$id'"));
if(!$isAdmin && !$isMaster && ($writerLevel < $isWriteOk['write_level'])) $GR->error('글쓰기 권한이 없습니다.', 0, $grboard.'/board.php?id='.$id);

// 게시판 설정 가져오기
$tmpFetchBoard = @mysql_fetch_array(mysql_query("select * from {$dbFIX}board_list where id = '$id'"));

// 만약 수정글일 경우 처리
if($mode && $articleNo) {
	$getContents = @mysql_query("select * from {$dbFIX}bbs_{$id} where no = '$articleNo'");
	$modify = @mysql_fetch_array($getContents);
	if(!$modify['no']) $GR->error('삭제된 게시물은 수정할 수 없습니다.', 0, $grboard.'/board.php?id='.$id);
	$getArticleOption = @mysql_fetch_array(mysql_query("select no, reply_open, reply_notify from {$dbFIX}article_option where id = '$id' and article_num = '$articleNo'"));
	$modify['option_reply_open'] = ($getArticleOption['no'])?$getArticleOption['reply_open']:1;
	$modify['option_reply_notify'] = ($getArticleOption['no'])?$getArticleOption['reply_notify']:1;

	// 회원이 작성한 글은 해당 회원(+관리자)만 수정가능
	if(!$isAdmin && !$isMaster && $modify['member_key'] && ($modify['member_key'] != $_SESSION['no'])) {
		$GR->error('본인이 작성한 글만 수정할 수 있습니다.', 1, $grboard.'/board.php?id='.$id.'&amp;articleNo='.$articleNo);
	}
	
	// 카테고리가 있을 시 셀렉트 박스 만들기
	if($tmpFetchBoard['category']) {
		$isCategory = 1;
		$tempCategoryArray = explode('|', $tmpFetchBoard['category']);
		$countTempArray = count($tempCategoryArray);
		$category = '<select name="category">';
		for($ti=0; $ti<$countTempArray; $ti++) {
			if($tempCategoryArray[$ti] == $modify['category']) $category .= '<option value="'.$tempCategoryArray[$ti].'" selected>'.$tempCategoryArray[$ti].'</option>';
			else $category .= '<option value="'.$tempCategoryArray[$ti].'">'.$tempCategoryArray[$ti].'</option>';
		}
		$category .= '</select>';
	}
	else $isCategory = 0;

	// 비밀글일 경우
	if(!$isAdmin && $modify['is_secret']) {
		if($alreadyEnterPassword) {
			$getOldPass = @mysql_query("select password from {$dbFIX}bbs_{$id} where no = '$articleNo'"); // 2010-01-28 Coder 좋아, Editor 이동규
			$tFetchPass = @mysql_fetch_array($getOldPass);
			if($alreadyEnterPassword != sha1($tFetchPass['password'])) $GR->error('입력하셨던 패스워드로 게시물에 접근하지 못했습니다.', 0, $grboard.'/board.php?id='.$id.'&amp;page='.$page);
		}
		else $GR->move('enter_password.php?id='.$id.'&amp;articleNo='.$articleNo.'&amp;readyWork=write');
	}

	// 업로드한 파일 가져오기
	$getFiles = @mysql_query("select file_route1, file_route2, file_route3, file_route4, file_route5, file_route6,".
		"file_route7, file_route8, file_route9, file_route10 from {$dbFIX}pds_save where id = '$id' and article_num = '$articleNo'");
	$oldFile = @mysql_fetch_array($getFiles);	
	$subject = stripslashes(htmlspecialchars($modify['subject']));
	$content = nl2br(stripslashes($modify['content']));
	$content = str_replace('&amp;nbsp;', ' ', $content);

// 신규 글일 경우 카테고리 처리
} else {

	// 카테고리가 있을 시 셀렉트 박스 만들기
	if($tmpFetchBoard['category']) {
		$isCategory = 1;
		$tempCategoryArray = explode('|', $tmpFetchBoard['category']);
		$countTempArray = count($tempCategoryArray);
		$category = '<select name="category">';
		for($ti=0; $ti<$countTempArray; $ti++) 
		  // 카테고리 선택 후, 글쓰기 할때 자동선택 설정 | 2010-01-30 Coder 컴센스 , Editor 이동규
		  $category .= '<option value="'.$tempCategoryArray[$ti].'"'.(($tempCategoryArray[$ti] == $clickCategory)?' selected="selected"':'').'>'.$tempCategoryArray[$ti].'</option>';
			// $category .= '<option value="'.$tempCategoryArray[$ti].'">'.$tempCategoryArray[$ti].'</option>'; // 기존 코드
		$category .= '</select>';
	}
	else $isCategory = 0;
}

// 테마에 사용될 기본변수 정리
$theme = 'theme/'.$tmpFetchBoard['theme'];
$totalFiles = $tmpFetchBoard['num_file'];
if($tmpFetchBoard['category']) $isCategory = 1; else $isCategory = 0;

// 상단에 불러올 파일과 내용을 처리한다.
if(file_exists($tmpFetchBoard['head_file'])) include $tmpFetchBoard['head_file'];
echo str_replace('[theme]', $grboard.'/theme/'.$tmpFetchBoard['theme'], stripslashes($tmpFetchBoard['head_form']));

// 테마 불러오기
include $theme.'/write.php';

// 하단에 불러올 파일과 내용을 처리한다.
echo stripslashes($tmpFetchBoard['foot_form']);
if(file_exists($tmpFetchBoard['foot_file'])) include $tmpFetchBoard['foot_file'];
?>