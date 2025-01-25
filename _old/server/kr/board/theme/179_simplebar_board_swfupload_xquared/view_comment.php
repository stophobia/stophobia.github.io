<?php
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
	else $homepage = "";
	
	// 이메일
	if($comment['email']) $email = '<a href="mailto:'.$email.'" class="commentBtn" title="'.$name.' 님에게 메일을 보냅니다.">[E]</a>';
	else $email = "";

	// 이름 대신 닉콘
	if($comment['member_key'])
	{
		$listtag = @mysql_fetch_array(mysql_query("select nametag, icon from {$dbFIX}member_list where no = '".$comment['member_key']."'"));
		if($listtag['nametag']) $name = '<img src="'.$grboard.'/'.$listtag['nametag'].'" alt="'.$comment['name'].'" title="" /> ';
		if($listtag['icon']) $name = '<img src="'.$grboard.'/'.$listtag['icon'].'" alt="" /> '.$name;
	}

	// 비밀 코멘트 시 처리
	if($comment['is_secret'])
	{
		if(($comment['member_key'] != $_SESSION['no']) && ($view['member_key'] != $_SESSION['no']) && ($_SESSION['no'] != 1))
		{
			$subject = '비밀 댓글 입니다.';			
			$content = '<span class="secretComment">비밀 댓글 입니다.</span>';
		}
	}
?>
<!-- 댓글 출력하기 -->
<table rules="none" summary="GR Board View Comment" cellpadding="0" cellspacing="0" border="0" style="width:100%;">
<caption></caption>
<tbody>
<tr>
	<?php if($comment['thread']) { ?>
	<td><?php for($tc=0; $tc<$comment['thread']; $tc++) echo '&nbsp;&nbsp;&nbsp;'; ?></td>
	<?php } ?>
	<td class="commentRight">
		<div id="read<?php echo $comment['no']; ?>" class="commentTitle">
		<?php echo $subject; ?> 
		... by <span class="name" onclick="getMember(<?php echo (($comment['member_key'])?$comment['member_key']:0).','.(($_SESSION['no'])?$_SESSION['no']:0); ?>, event);"><?php echo $name; ?></span> <?php echo $homepage.$email; ?>
		<a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $articleNo; ?>&amp;replyTarget=<?php echo $comment['no']; ?>&amp;commentPage=<?php echo $_GET['commentPage']; ?>&amp;page=<?php echo $page; ?>#read<?php echo $comment['no']; ?>" onclick="setPos(event);"><img src="<?php echo $grboard.'/'.$theme; ?>/image/comment_reply.gif" alt="답변" title="이 코멘트에 답변을 답니다" /></a> 
		<a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $articleNo; ?>&amp;modifyTarget=<?php echo $comment['no']; ?>&amp;commentPage=<?php echo $_GET['commentPage']; ?>&amp;page=<?php echo $page; ?>#read<?php echo $comment['no']; ?>" onclick="setPos(event);"><img src="<?php echo $grboard.'/'.$theme; ?>/image/comment_modify.gif" alt="수정" title="이 코멘트를 수정합니다" /></a> 
		<a href="#" onclick="commentDeleteOk(<?php echo "'".$id."', ".$articleNo.", ".$comment['no'].", ".$page; ?>);"><img src="<?php echo $grboard.'/'.$theme; ?>/image/comment_delete.gif" alt="삭제" title="이 코멘트를 삭제합니다" /></a>
		</div>
		<div class="commentContent"><?php echo $content; ?></div>
		<div style="text-align:right;">
		<span class="smallEng"><?php echo $date; ?> <?php if($isAdmin or $isMaster) echo '/ '.$comment['ip']; ?> / Good : <?php echo $comment['good']; ?></span>
		<a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $articleNo; ?>&amp;voteCommentNo=<?php echo $comment['no']; ?>&amp;good=1#read<?php echo $comment['no']; ?>" class="small" style="color:#386D9F;" title="이 코멘트가 좋습니다.">+ Good</a>
		<?php if($isAdmin && ($comment['bad'] > -1000)) { ?>
		<a href="#" onclick="blindArticleOk('<?php echo $id.'\', '.$articleNo; ?>, 'comment_', '<?php echo $comment['no']; ?>');" class="small" style="color: #f3828a" title="이 댓글을 블라인드 처리 합니다. (삭제하지는 않고, 댓글 내용만 확인이 안됩니다.)">+ Blind ON</a>
		<?php } if($isAdmin && ($comment['bad'] < -1000)) { ?>
		<a href="#" onclick="blindArticleNo('<?php echo $id.'\', '.$articleNo; ?>, 'comment_', '<?php echo $comment['no']; ?>');" class="small" style="color: #7390d4" title="이 댓글의 블라인드 처리를 해제합니다. (가려졌던 댓글 내용이 다시 보입니다.)">+ Blind OFF</a>
		<?php } ?>
		</div>
	</td>
</tr>
</tbody>
</table>
	<?php
} # while
?>
