<?php
// 기본 클래스를 부른다
$id = $_GET['id'];
include 'class/common.php';
$GR = new COMMON;
$GR->dbConn();

// 정상적으로 접근해서 파일을 받는건지 확인한다.
if(!eregi($_SERVER['HTTP_HOST'], $_SERVER['HTTP_REFERER'])) $GR->error('정상적으로 파일을 다운로드 받으세요.');

// 로그인 되었을 때
if($_SESSION['no'])
{
	$sessionNo = $_SESSION['no'];
	$getMemberInfo = @mysql_query('select level from '.$dbFIX.'member_list where no = \''.$sessionNo.'\'');
	$tmpFetch = @mysql_fetch_array($getMemberInfo);
	$visitorLevel = $tmpFetch['level'];
	if($_SESSION['no'] == 1) $isAdmin = 1; else $isAdmin = 0;
	$isMember = 1;
	$getMasters = @mysql_fetch_array(mysql_query('select master, group_no from '.$dbFIX.'board_list where id = \''.$id.'\''));
	
	// 게시판 관리자
	if($getMasters[0])
	{
		$masterArr = explode('|', $getMasters[0]);
		$masterNum = count($masterArr);
		for($m=0; $m<$masterNum; $m++)
		{
			if($_SESSION['mId'] && $_SESSION['mId'] == $masterArr[$m])
			{
				$isAdmin = 1;
				break;
			}
		}
	}
	
	// 그룹 관리자
	if($getMasters[1])
	{
		$getGroupMaster = @mysql_fetch_array(mysql_query('select master from '.$dbFIX.'group_list where no = '.$getMasters[1]));
		$groupMaster = explode('|', $getGroupMaster[0]);
		$cntResult = count($groupMaster);
		for($g=0; $g<$cntResult; $g++)
		{
			if($_SESSION['mId'] && $_SESSION['mId'] == $groupMaster[$g])
			{
				$isAdmin = 1;
				break;
			}
		}
	}
}
else
{ 
	$sessionNo = 0;
	$visitorLevel = 1; 
	$isAdmin = 0;
	$isMember = 0;
}

// 기본 변수를 받아온다.
if($_GET['id']) $id = $_GET['id'];
if($_GET['articleNo']) $articleNo = $_GET['articleNo'];
if($_GET['num']) $num = $_GET['num'];
$filename = 'file_route'.$num;
if($_GET['extNo']) $extNo = $_GET['extNo'];
$grboard = str_replace('/'.end(explode('/', $_SERVER['REQUEST_URI'])), '', $_SERVER['REQUEST_URI']);

// 다운로드 권한 체크
$getPostWriter = @mysql_fetch_array(mysql_query('select member_key from '.$dbFIX.'bbs_'.$id.' where no = '.$articleNo.' limit 1'));
if(!$getPostWriter['member_key']) $getPostWriter['member_key'] = -1;
$getPerm = @mysql_query('select * from '.$dbFIX.'board_list where id = \''.$id.'\'') or $GR->error($id.' 게시판이 생성되지 않았습니다.');
$tmpFetchBoard = @mysql_fetch_array($getPerm);
if(!$isAdmin && ($getPostWriter['member_key'] != $sessionNo) && ($tmpFetchBoard['view_level'] > $visitorLevel || $tmpFetchBoard['down_level'] > $visitorLevel)) {
	$grboard = str_replace('/'.end(explode('/', $_SERVER['REQUEST_URI'])), '', $_SERVER['REQUEST_URI']);
	$GR->error('다운로드 권한이 없습니다.', 0, $grboard.'/board.php?id='.$id.'&amp;articleNo='.$articleNo);
}

// 포인트 차감
if(!$isAdmin && ($getPostWriter['member_key'] != $sessionNo) && $tmpFetchBoard['down_point']) {
	if($visitorLevel < 2) $GR->error('로그인 후 받으실 수 있습니다.', 0, $grboard.'/board.php?id='.$id.'&amp;articleNo='.$articleNo);
	$getVisitorInfo = @mysql_fetch_array(mysql_query('select id, point from '.$dbFIX.'member_list where no = '.$sessionNo));
	if($getVisitorInfo['point'] < $tmpFetchBoard['down_point']) 
		$GR->error('포인트를 더 쌓으신 후에 받으실 수 있습니다.', 0, $grboard.'/board.php?id='.$id.'&amp;articleNo='.$articleNo);
	@mysql_query('update '.$dbFIX.'member_list set point = point - '.$tmpFetchBoard['down_point'].' where no = '.$sessionNo);
	@mysql_query("insert into {$dbFIX}memo_save set no = '', member_key = '$sessionNo', sender_key = 1, ".
		"subject = '[자동알림] ".$tmpFetchBoard['down_point']." 포인트를 사용 하셨습니다.', content = '<a href=\"".$grboard."/board.php?id=".$id."&articleNo=".$articleNo."\" onclick=\"window.open(this.href, \'_blank\'); return false\">이 곳</a>에서 파일 다운로드에 ".$tmpFetchBoard['down_point']." 포인트를 사용하셨습니다.', signdate = '".$GR->grTime()."', is_view = '0'");
}

// 추가 파일 다운로드 시 바로 처리
if($extNo) {
	$temp = @mysql_fetch_array(mysql_query('select file_route from '.$dbFIX.'pds_extend where no = '.$extNo));
	$fileDownload = str_replace('%2F', '/', urlencode($temp['file_route']));
	$getPdsList = @mysql_fetch_array(mysql_query('select no, name from '.$dbFIX.'pds_list where type = 1 and uid = '.$extNo));
	$realFilename = str_replace('%2F', '/', urlencode($getPdsList['name']));
	if($getPdsList['no']) {
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: public');
		header('Content-Description: File Transfer');
		header('Content-Disposition: attachment; filename='.end(explode('/', $realFilename)).';');
		header('Content-Transfer-Encoding: binary');
		header('Content-Type: application/octet-stream');
		header('Content-Length: '.filesize($fileDownload));
		ob_clean();
		flush();
		@readfile($fileDownload);
	} else {
		header('location:'.$fileDownload);
	}
}

// 일반 다운로드시 처리하고, 받은 수 올려주기
else {
	$temp = @mysql_fetch_array(mysql_query("select no, {$filename} from {$dbFIX}pds_save where id = '$id' and article_num = '$articleNo'"));
	$fileDownload = str_replace('%2F', '/', urlencode($temp[$filename]));
	$getPdsList = @mysql_fetch_array(mysql_query('select no, name from '.$dbFIX.'pds_list where type = 0 and uid = '.$temp['no'].' and idx = '.($num-1).' limit 1'));
	if($getPdsList['no']) {
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: public');
		header('Content-Description: File Transfer');
		header('Content-Disposition: attachment; filename='.end(explode('/', $getPdsList['name'])).';');
		header('Content-Transfer-Encoding: binary');
		header('Content-Type: application/octet-stream');
		header('Content-Length: '.filesize($fileDownload));
		ob_clean();
		flush();
		@readfile($fileDownload);
	} else {
		header('location:'.$fileDownload);
	}
	@mysql_query("update {$dbFIX}pds_save set hit=hit+1 where id = '$id' and article_num = '$articleNo'");
}
?>