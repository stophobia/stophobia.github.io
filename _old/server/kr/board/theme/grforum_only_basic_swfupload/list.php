<?php
if(!defined('__GRBOARD__') || !defined('__GRFORUM__')) exit();
if($articleNo) echo '<div style="height: 30px"></div>'; 

// 카테고리가 있다면 아래 출력
if($isCategory) { ?>
	<select name="chooseCategory" onchange="setCategory(this.value)">
	<option value="">보고 싶은 분류를 선택해 보세요.</option>
	<?php
	// 셀렉트박스형 카테고리 선택
	$categories = @mysql_fetch_array(mysql_query('select category from '.$dbFIX.'board_list where id = \''.$id.'\''));
	$categoryArray = @explode('|', $categories['category']);
	$countCategory = @count($categoryArray);
	for($ca=0; $ca<$countCategory; $ca++) {
		echo '<option value="'.urlencode($categoryArray[$ca]).'"'.(($categoryArray[$ca] == $clickCategory)?' selected="selected"':'').'>'.stripslashes($categoryArray[$ca]).'</option>';
	}
	?></select>
<?php } ?>

<form id="list" method="post" action="<?php echo $grboard; ?>/list_adjust.php">
<div><input type="hidden" name="id" value="<?php echo $id; ?>" />
<input type="hidden" name="articleNo" value="<?php echo $articleNo; ?>" /></div>

<div class="boardTitle"><?php echo $forumTitle; ?></div>

<div class="column center">
	<div class="col"><a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;sortList=subject&amp;sortBy=<?php echo ($sortBy=='desc')?'asc':'desc'; ?>&amp;page=<?php echo $page; ?>">포럼</a></div>
	<div class="data">
		<div class="article"><a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;sortList=hit&amp;sortBy=<?php echo ($sortBy=='desc')?'asc':'desc'; ?>&amp;page=<?php echo $page; ?>">읽음</a></div>
		<div class="reply"><a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;sortList=comment_count&amp;sortBy=<?php echo ($sortBy=='desc')?'asc':'desc'; ?>&amp;page=<?php echo $page; ?>">댓글</a></div>
		<div class="latest">최근 댓글</div>
		<div class="clear"></div>
	</div>
</div>

<?php
// 공지 게시물 목록 출력하기
while($notice = @mysql_fetch_array($getNotice))
{
	// 값 처리
	$noticeSubject = $GR->cutString(stripslashes($notice['subject']), $cutingSubject);
	$noticeWriter = stripslashes($notice['name']);
	$noticeRead = number_format($notice['hit']);
	$noticeReply = number_format($notice['comment_count']);
	$noticeLatest = @mysql_fetch_array(mysql_query('select no, member_key, name, signdate, subject from '.$dbFIX.'comment_'.$id.' where board_no = '.$notice['no'].' order by no desc'));
	$dbMemKey = ($noticeLatest['member_key']) ? $noticeLatest['member_key'] : 0;
	$seMemKey = ($_SESSION['no']) ? $_SESSION['no'] : 0;
	if(!$noticeLatest['no']) {
		$noticeLatest['subject'] = '댓글이 없습니다.';
		$noticeLatest['signdate'] = $notice['signdate'];
		$noticeLatest['name'] = '';
		
	}
	?>
		<div class="forum">
			<div class="mark center"><img src="<?php echo $skin; ?>/images/box.gif" alt="" /></div>
			<div class="col">
				<a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $notice['no']; ?>"><?php echo $noticeSubject; ?></a>
				<p>by <?php echo $noticeWriter; ?></p>
			</div>
			<div class="data center">
				<div class="article"><?php echo $noticeRead; ?></div>
				<div class="reply"><?php echo $noticeReply; ?></div>
				<div class="latest">
					<p><a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $notice['no']; ?>#read<?php echo $noticeLatest['no']; ?>" title="작성시각: <?php echo date('Y-m-d H:i:s', $noticeLatest['signdate']); ?>"><?php echo stripslashes($noticeLatest['subject']); ?></a></p>
					<p><span onclick="getMember(<?php echo $dbMemKey.','.$seMemKey; ?>, event);">by <?php echo stripslashes($noticeLatest['name']); ?></span></p>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	<?php
} # while

// 일반 게시물 목록 출력하기
while($list = mysql_fetch_array($getList))
{
	// 블라인드 게시물이면 처리
	if($list['bad'] < -1000) $list['subject'] = $list['content'] = '── 관리자에 의해 블라인드 되었습니다 ──';

	// 검색어가 있다면 하이라이트
	if($searchText) $listSubject = str_replace($searchText, '<span class="findMe">'.$searchText.'</span>', $listSubject);

	// 값 처리
	if($isAdmin) $mark = '<input type="checkbox" name="box[]" value="'.$list['no'].'" />';
	else {
		if($list['is_secret']) $mark = '<img src="'.$grboard.'/'.$theme.'/images/sec.gif" alt="비밀" />';
		elseif(time() < $list['signdate']+86400) $mark = '<img src="'.$grboard.'/'.$theme.'/images/new.gif" alt="새글" />';
		else $mark = '<img src="'.$grboard.'/'.$theme.'/images/bbs.gif" alt="'.$list['no'].'" />';
	}
	$listSubject = $GR->cutString(stripslashes($list['subject']), $cutingSubject);
	$listLink = $grboard.'/board.php?id='.$id.'&amp;articleNo='.(($list['board_no'])?$list['board_no']:$list['no']).'&amp;page='.$page.'&amp;searchText='.urlencode($searchText).'&amp;clickCategory='.$clickCategory;
	$dbMemKey = ($list['member_key'])?$list['member_key']:0;
	$seMemKey = ($_SESSION['no'])?$_SESSION['no']:0;
	$listRead = number_format($list['hit']);
	$listReply = number_format($list['comment_count']);
	$listLatest = @mysql_fetch_array(mysql_query('select no, member_key, name, signdate, subject from '.$dbFIX.'comment_'.$id.' where board_no = '.$list['no'].' order by no desc'));
	$reDbMemKey = ($listLatest['member_key']) ? $listLatest['member_key'] : 0;
	if(!$listLatest['no']) {
		$listLatest['subject'] = '댓글이 없습니다.';
		$listLatest['signdate'] = $list['signdate'];
		$listLatest['name'] = '';
	}
	?>
	<div class="forum">
		<div class="mark center"><?php echo $mark; ?></div>
		<div class="col">
			<a href="<?php echo $listLink; ?>"><?php echo $listSubject; ?></a>
			<p>by <span onclick="getMember(<?php echo $dbMemKey.','.$seMemKey; ?>, event);"><?php echo $list['name']; ?></span></p>
		</div>
		<div class="data center">
			<div class="article"><?php echo $listRead; ?></div>
			<div class="reply"><?php echo $listReply; ?></div>
			<div class="latest">
				<p><a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $list['no']; ?>#read<?php echo $listLatest['no']; ?>" title="작성시각: <?php echo date('Y-m-d H:i:s', $listLatest['signdate']); ?>"><?php echo stripslashes($listLatest['subject']); ?></a></p>
				<p><span onclick="getMember(<?php echo $reDbMemKey.','.$seMemKey; ?>, event);">by <?php echo stripslashes($listLatest['name']); ?></span></p>
			</div>
			<div class="clear"></div>
		</div>
	</div>

<?php } #while ?>

</form>