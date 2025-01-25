<?php
// 기본 클래스를 부른다
include 'class/common.php';
$GR = new COMMON;

// 변수 처리
if(is_array($_GET))
{
	if(array_key_exists('id', $_GET) && $_GET['id']) $id = $_GET['id'];
	if(array_key_exists('articleNo', $_GET) && $_GET['articleNo']) $articleNo = $_GET['articleNo'];
	if(array_key_exists('commentNo', $_GET) && $_GET['commentNo']) $commentNo = $_GET['commentNo'];
	if(array_key_exists('page', $_GET) && $_GET['page']) $page = $_GET['page'];
	if(array_key_exists('alreadyEnterPassword', $_GET) && $_GET['alreadyEnterPassword']) $alreadyEnterPassword = $_GET['alreadyEnterPassword'];
	if(array_key_exists('targetTable', $_GET) && $_GET['targetTable']) $targetTable = $_GET['targetTable'];
	if(array_key_exists('readyWork', $_GET) && $_GET['readyWork']) $readyWork = $_GET['readyWork'];
	if(array_key_exists('isReported', $_GET) && $_GET['isReported']) $isReported = 1;
	if(array_key_exists('clickCategory', $_POST) && $_POST['clickCategory']) $clickCategory = $_POST['clickCategory'];
}
if($_SESSION['no']) $sessionNo = $_SESSION['no']; else $sessionNo = 0;
if($readyWork == 'c_delete') $addAction = '&articleNo='.$articleNo; else $addAction = '';

// DB 에 연결한다.
$GR->dbConn();

// 원 게시물을 조회한다.
if($targetTable == 'bbs') $valueNum = $articleNo; else $valueNum = $commentNo;
$getTargetArticle = @mysql_query("select * from {$dbFIX}{$targetTable}_{$id} where no = '$valueNum'") or
	$GR->error('삭제할 게시물의 정보를 가져오지 못했습니다.', 0, ((!$isReported)?'board.php?id='.$id.'&amp;articleNo='.$articleNo.'&amp;page='.$page:'CLOSE'));
$data = @mysql_fetch_array($getTargetArticle);

// 이 게시판 마스터일 경우
$isMaster = 0;
$getMasters = @mysql_fetch_array(mysql_query('select master, fix_time from '.$dbFIX.'board_list where id = \''.$id.'\''));
if($getMasters[0])
{
	$masterArr = explode('|', $getMasters[0]);
	$masterNum = count($masterArr);
	for($m=0; $m<$masterNum; $m++)
	{
		if($_SESSION['mId'] && $_SESSION['mId'] == $masterArr[$m])
		{
			$isMaster = 1;
			break;
		}
	}
}

// 삭제를 실행한 주체가 관리자나 마스터라면 삭제시킨다.
if(($_SESSION['no'] == 1) || $isMaster)
{
	if($targetTable == 'bbs')
	{
		@mysql_query("delete from {$dbFIX}bbs_{$id} where no = '$articleNo'") or 
			$GR->error('게시물을 삭제하지 못했습니다.', 0, 'board.php?id='.$id.'&page='.$page.'&articleNo='.$articleNo);
		@mysql_query("delete from {$dbFIX}comment_{$id} where board_no = '$articleNo'");
		$files = @mysql_fetch_array(mysql_query("select * from {$dbFIX}pds_save where id = '$id' and article_num = '$articleNo'"));
		if($files['no'])
		{
			for($f=1; $f<11; $f++) {
				$fileRoute = 'file_route'.$f;
				if($files[$fileRoute]) @unlink($files[$fileRoute]); 
			}
		}
		@mysql_query('delete from '.$dbFIX.'pds_list where type = 0 and uid = '.$files['no']);
		@mysql_query("delete from {$dbFIX}pds_save where id = '$id' and article_num = '$articleNo'");
		@mysql_query("delete from {$dbFIX}total_article where id = '$id' and article_num = '$articleNo'");
		@mysql_query("delete from {$dbFIX}total_comment where id = '$id' and article_num = '$articleNo'");

		$getExtendFiles = @mysql_query('select no, file_route from '.$dbFIX.'pds_extend where id = \''.$id.'\' and article_num = '.$articleNo);
		while($extFiles = @mysql_fetch_array($getExtendFiles)) {
			@unlink($extFiles['file_route']);
			@mysql_query('delete from '.$dbFIX.'pds_list where type = 1 and uid = '.$extFiles['no']);
		}
		@mysql_query("delete from {$dbFIX}pds_extend where id = '$id' and article_num = '$articleNo'");
	}
	else
	{
		@mysql_query("delete from {$dbFIX}comment_{$id} where no = '$commentNo'") or 
			$GR->error('댓글을 삭제하지 못했습니다.', 0, 'board.php?id='.$id.'&amp;page='.$page.$addAction);
		@mysql_query("update {$dbFIX}bbs_{$id} set comment_count = comment_count - 1 where no = '$articleNo'");
		@mysql_query("delete from {$dbFIX}total_comment where id = '$id' and comment_num = '$commentNo'");
	}
	if($isReported) {
		@mysql_query("update {$dbFIX}report set status = 2 where no = ".$isReported);
		$GR->error('신고된 게시물을 정상적으로 삭제하였습니다.', 0, 'CLOSE');
	}
	@mysql_query("delete from {$dbFIX}article_option where id = '$id' and article_num = '$articleNo'");
	$GR->error('글이 정상적으로 삭제되었습니다', 0, 'board.php?id='.$id.'&amp;page='.$page.$addAction);
}
// 멤버나 손님이 남긴 글일 때
else
{
	if($getMasters['fix_time']) {
		$possibleTime = $data['signdate'] + (3600 * $getMasters['fix_time']);
		if($possibleTime < time()) $GR->error($getMasters['fix_time'].'시간 이상 지난 게시물은 삭제할 수 없습니다.', 0, 'board.php?id='.$id.'&amp;articleNo='.$articleNo.'&amp;page='.$page);
	}
	if($data['member_key'])
	{
		if($data['member_key'] == $sessionNo)
		{
			if($targetTable == 'bbs')
			{
				@mysql_query("delete from {$dbFIX}bbs_{$id} where no = '$articleNo'") or 
					$GR->error('게시물을 삭제하지 못했습니다.', 1, 'board.php?id='.$id.'&amp;page='.$page);
				@mysql_query("delete from {$dbFIX}comment_{$id} where board_no = '$articleNo'");
				$files = @mysql_fetch_array(mysql_query("select * from {$dbFIX}pds_save where id = '$id' and article_num = '$articleNo'"));
				if($files['no'])
				{
					for($f=1; $f<11; $f++) {
						$fileRoute = 'file_route'.$f;
						if($files[$fileRoute]) @unlink($files[$fileRoute]); 
					}
				}
				@mysql_query('delete from '.$dbFIX.'pds_list where type = 0 and uid = '.$files['no']);
				@mysql_query("delete from {$dbFIX}pds_save where id = '$id' and article_num = '$articleNo'");
				@mysql_query("delete from {$dbFIX}total_article where id = '$id' and article_num = '$articleNo'");
				@mysql_query("delete from {$dbFIX}total_comment where id = '$id' and article_num = '$articleNo'");

				$getExtendFiles = @mysql_query('select no, file_route from '.$dbFIX.'pds_extend where id = \''.$id.'\' and article_num = '.$articleNo);
				while($extFiles = @mysql_fetch_array($getExtendFiles)) {
					@unlink($extFiles['file_route']);
					@mysql_query('delete from '.$dbFIX.'pds_list where type = 1 and uid = '.$extFiles['no']);
				}
				@mysql_query("delete from {$dbFIX}pds_extend where id = '$id' and article_num = '$articleNo'");
			}
			else
			{
				@mysql_query("delete from {$dbFIX}comment_{$id} where no = '$commentNo'") or 
					$GR->error('댓글을 삭제하지 못했습니다.', 1, 'board.php?id='.$id.'&amp;page='.$page.$addAction);
				@mysql_query("update {$dbFIX}bbs_{$id} set comment_count = comment_count - 1 where no = '$articleNo'") or 
					$GR->error('총 코멘트 수를 줄이지 못했습니다.');
				@mysql_query("delete from {$dbFIX}total_comment where id = '$id' and comment_num = '$commentNo'");
			}
			@mysql_query("delete from {$dbFIX}article_option where id = '$id' and article_num = '$articleNo'");
			$GR->error('게시물이 정상적으로 삭제되었습니다', 0, 'board.php?id='.$id.'&amp;page='.$page);
		}
		else $GR->error('자신이 남긴 글이 아닐경우 삭제할 수 없습니다.', 0, 'board.php?id='.$id.'&amp;page='.$page.'&amp;articleNo='.$articleNo);
	}
	else
	{
		if($alreadyEnterPassword)
		{
			if($targetTable == 'bbs') $valueNo = $articleNo; else $valueNo = $commentNo;
			$getOldPass = @mysql_query("select password from {$dbFIX}{$targetTable}_{$id} where no = '$valueNo'") or 
				$GR->error('이전 패스워드 값을 가져오지 못했습니다.');
			$tFetchPass = @mysql_fetch_array($getOldPass) or 
				$GR->error('이전 패스워드값을 가공하지 못했습니다. DB 에러 같습니다.');
			if($alreadyEnterPassword == sha1($tFetchPass['password']))
			{
				if($targetTable == 'bbs')
				{
					@mysql_query("delete from {$dbFIX}bbs_{$id} where no = '$articleNo'") or 
						$GR->error('게시물을 삭제하지 못했습니다.', 1, 'board.php?id='.$id.'&amp;page='.$page.'&amp;articleNo='.$articleNo);
					@mysql_query("delete from {$dbFIX}comment_{$id} where board_no = '$articleNo'");
					$files = @mysql_fetch_array(mysql_query("select * from {$dbFIX}pds_save where id = '$id' and article_num = '$articleNo'"));
					if($files['no'])
					{
						for($f=1; $f<11; $f++) {
							$fileRoute = 'file_route'.$f;
							if($files[$fileRoute]) @unlink($files[$fileRoute]); 
						}
					}
					@mysql_query('delete from '.$dbFIX.'pds_list where type = 0 and uid = '.$files['no']);
					@mysql_query("delete from {$dbFIX}pds_save where id = '$id' and article_num = '$articleNo'");
					@mysql_query("delete from {$dbFIX}total_article where id = '$id' and article_num = '$articleNo'");
					@mysql_query("delete from {$dbFIX}total_comment where id = '$id' and article_num = '$articleNo'");

					$getExtendFiles = @mysql_query('select no, file_route from '.$dbFIX.'pds_extend where id = \''.$id.'\' and article_num = '.$articleNo);
					while($extFiles = @mysql_fetch_array($getExtendFiles)) {
						@unlink($extFiles['file_route']);
						@mysql_query('delete from '.$dbFIX.'pds_list where type = 1 and uid = '.$extFiles['no']);
					}
					@mysql_query("delete from {$dbFIX}pds_extend where id = '$id' and article_num = '$articleNo'");
				}
				else
				{
					@mysql_query("delete from {$dbFIX}comment_{$id} where no = '$commentNo'") or 
						$GR->error('게시물을 삭제하지 못했습니다.', 1, 'board.php?id='.$id.'&amp;page='.$page.$addAction);
					@mysql_query("update {$dbFIX}bbs_{$id} set comment_count = comment_count - 1 where no = '$articleNo'") or 
						$GR->error('총 코멘트 수를 줄이지 못했습니다.', 0, 'board.php?id='.$id.'&amp;page='.$page);
					@mysql_query("delete from {$dbFIX}total_comment where id = '$id' and comment_num = '$commentNo'");
				}
				@mysql_query("delete from {$dbFIX}article_option where id = '$id' and article_num = '$articleNo'");
				$GR->error('글이 정상적으로 삭제되었습니다.', 0, 'board.php?id='.$id.'&amp;page='.$page.$addAction);
			}
			else $GR->error('입력하셨던 패스워드로 게시물에 접근하지 못했습니다.', 0, 'board.php?id='.$id.'&amp;page='.$page);
		}
		else $GR->move('enter_password.php?id='.$id.'&amp;articleNo='.$articleNo.'&amp;commentNo='.$commentNo.'&amp;readyWork='.$readyWork.'&amp;targetTable='.$targetTable.'&amp;page='.$page.'&amp;clickCategory='.$clickCategory);
	}
}
?>