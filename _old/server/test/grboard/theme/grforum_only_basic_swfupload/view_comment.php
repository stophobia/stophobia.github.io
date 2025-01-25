<?php
if(!defined('__GRBOARD__') || !defined('__GRFORUM__')) exit();

// 코멘트 불러오기
while($comment = mysql_fetch_array($getComment))
{
	// 댓글이 블라인드 상태일 때
	if($comment['bad'] < -1000) {
		$blindMsg = '<div class="smallEng" title="댓글은 삭제되지 않았으나, 블라인드 해제가 되지 않으면 댓글 내용을 볼 수 없습니다.">'.
			'<strong>[!]</strong> 댓글이 관리자에 의해 블라인드 처리 되었습니다.'.(($isAdmin)?' (관리자는 댓글 내용이 보입니다.)':'').'</div>';
		if($isAdmin) $comment['content'] = $blindMsg.$comment['content'];
		else $comment['content'] = $blindMsg;
		$comment['subject'] = '── 관리자에 의해 블라인드 되었습니다 ──';
	}

	// 변수 처리
	$name = stripslashes($comment['name']);
	$subject = stripslashes($comment['subject']);
	$content = stripslashes(nl2br($comment['content']));
	$date = date("Y.m.d H:i:s", $comment['signdate']);
	$homepage = htmlspecialchars($comment['homepage']);
	$email = htmlspecialchars($comment['email']);
	
	// 홈페이지
	if($comment['homepage']) $homepage = '<a href="'.$homepage.'" class="commentBtn" title="'.$name.' 님의 홈으로 갑니다." onclick="window.open(this.href, \'_blank\'); return false;">[H]</a>';
	else $homepage = '';
	
	// 이메일
	if($comment['email']) $email = '<a href="mailto:'.$email.'" class="commentBtn" title="'.$name.' 님에게 메일을 보냅니다.">[E]</a>';
	else $email = '';

	// 비밀 코멘트 시 처리
	if($comment['is_secret'])
	{
		if(($comment['member_key'] != $_SESSION['no']) && ($view['member_key'] != $_SESSION['no']) && ($_SESSION['no'] != 1))
		{
			$subject = '비밀 댓글 입니다.';			
			$content = '<span class="secretComment">비밀 댓글 입니다.</span>';
		}
	}

	// 글쓴이 정보 처리
	$writerInfo = @mysql_fetch_array(mysql_query('select * from '.$dbFIX.'member_list where no = '.$comment['member_key']));
	$writerStatus = getWriterStatus($comment['member_key']);
	$isOnline = ($writerInfo['lastlogin']+600 > time())?'<span>현재 접속중입니다</span>':'오프라인 상태입니다';
	$coMemKey = $comment['member_key']?$comment['member_key']:0;
	$seMemKey = $_SESSION['no']?$_SESSION['no']:0;
?>

<div id="read<?php echo $comment['no']; ?>" class="viewMain">
	<div class="side">
		<div class="title center"><h3 onclick="getMember(<?php echo $coMemKey.','.$seMemKey; ?>, event);"><?php echo $comment['name']; ?></h3></div>
		<ul>
			<?php if($writerInfo['photo']) { ?><li><img src="<?php echo $grboard; ?>/phpThumb/phpThumb.php?src=<?php echo $grboard.'/'.$writerInfo['photo']; ?>&amp;w=80&amp;h=80&amp;q=100&amp;fltr[]=usm|99|0.5|3" alt="my photo" /></li><?php } ?>
			<li>작성시각: <?php echo date('Y.m.d H:i:s', $comment['signdate']); ?></li>
			<li>총 작성한 글타래: <?php echo $writerStatus['post']; ?> 개</li>
			<li>총 작성한 댓글수: <?php echo $writerStatus['reply']; ?> 개</li>
			<li>가입일: <?php echo date('Y/m/d', $writerInfo['make_time']); ?></li>
			<li>포인트: <?php echo $writerInfo['point']; ?></li>
			<li>레벨: <?php echo $writerInfo['level']; ?></li>
			<?php if($comment['member_key']) { ?><li><?php echo $isOnline; ?></li><?php } ?>
		</ul>
	</div>

	<div class="text">
		<div class="title"> 
			<strong>글 제목:</strong> <?php echo $subject; ?>
			<div class="btn"><a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $articleNo; ?>&amp;replyTarget=<?php echo $comment['no']; ?>&amp;commentPage=<?php echo $_GET['commentPage']; ?>&amp;page=<?php echo $page; ?>#read<?php echo $comment['no']; ?>" onclick="setPos(event);"><img src="<?php echo $grboard.'/'.$theme; ?>/image/comment_reply.gif" alt="답변" title="이 코멘트에 답변을 답니다" /></a> 
			<a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $articleNo; ?>&amp;modifyTarget=<?php echo $comment['no']; ?>&amp;commentPage=<?php echo $_GET['commentPage']; ?>&amp;page=<?php echo $page; ?>#read<?php echo $comment['no']; ?>" onclick="setPos(event);"><img src="<?php echo $grboard.'/'.$theme; ?>/image/comment_modify.gif" alt="수정" title="이 코멘트를 수정합니다" /></a> 
			<a href="#" onclick="commentDeleteOk(<?php echo "'".$id."', ".$articleNo.", ".$comment['no'].", ".$page; ?>);"><img src="<?php echo $grboard.'/'.$theme; ?>/image/comment_delete.gif" alt="삭제" title="이 코멘트를 삭제합니다" /></a></div>
		</div>
		<div class="viewContent">
			<!-- 게시물 내용 출력 -->
			<?php 
			$content = setBBCode($content, true); # ← 댓글 내용에 BBCode 가 있을 때 true 상태면 처리해주고 false 면 무시
			echo $content;
			?>

			<!-- 하단 싱크걸기, 추천, 비추, 담기 버튼 출력 -->
			<div class="right">
				<span class="smallEng"><?php echo $date; ?> <?php if($isAdmin or $isMaster) echo '/ '.$comment['ip']; ?> / Good : <?php echo $comment['good']; ?></span>
				<a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $articleNo; ?>&amp;voteCommentNo=<?php echo $comment['no']; ?>&amp;good=1#read<?php echo $comment['no']; ?>" class="small" style="color:#386D9F;" title="이 코멘트가 좋습니다.">+ Good</a>
				<?php if($isAdmin && ($comment['bad'] > -1000)) { ?>
				<a href="#" onclick="blindArticleOk('<?php echo $id.'\', '.$articleNo; ?>, 'comment_', '<?php echo $comment['no']; ?>');" class="small" style="color: #f3828a" title="이 댓글을 블라인드 처리 합니다. (삭제하지는 않고, 댓글 내용만 확인이 안됩니다.)">+ Blind ON</a>
				<?php } if($isAdmin && ($comment['bad'] < -1000)) { ?>
				<a href="#" onclick="blindArticleNo('<?php echo $id.'\', '.$articleNo; ?>, 'comment_', '<?php echo $comment['no']; ?>');" class="small" style="color: #7390d4" title="이 댓글의 블라인드 처리를 해제합니다. (가려졌던 댓글 내용이 다시 보입니다.)">+ Blind OFF</a>
				<?php } ?>
			</div>
		</div>

	</div>
</div>


	<?php
} # while
?>
