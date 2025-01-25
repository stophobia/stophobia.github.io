<?php
// 비밀글일 때 처리
if($co['is_secret'] && !$_SESSION['no']) $co['content'] = '<span style="color: red">비밀 댓글 입니다.</span>';

// 포스트 보기 화면이 아니고 목록화면일 때
if(!$p) {
	$co['reply'] = ($co['is_reply']) ? '_reply' : '';
	$co['content'] = nl2br(stripslashes($co['content']));
	$name = stripslashes($co['name']);
	if($co['homepage']) $headLink = '<a href="'.$co['homepage'].'" title="'.$name.' 님의 웹사이트(블로그)를 방문 합니다">';
	elseif($co['email']) $headLink = '<a href="mailto:'.$co['email'].'" title="'.$name.' 님에게 메일을 보냅니다">';
	else $headLink = '<a href="#">';
}
?>
<div class="list">
	<div id="viewComment<?php echo $co['uid']; ?>" class="co_content<?php echo $co['reply']; ?>">
	<img src="http://www.gravatar.com/avatar.php?gravatar_id=<?php echo md5($co['email']).'&default=http://'.urlencode($_SERVER['HTTP_HOST'].$grblog.'image/no_gravatar.gif'); ?>&size=50" alt="gravatar" class="gravatar" align="left" />
	<?php echo $co['content']; ?>
	</div>
	<div class="view_bottom<?php echo $co['reply']; ?>">
	<?php echo $headLink.'<img src="'.$grblog.$theme.'/icon.trackback.gif" alt="트랙백(엮인글) 출처" /> <span class="replyDelete" title="'.date('Y.m.d H:i:s', $co['signdate']).(($_SESSION['no'] == 1)?' / '.$co['ip']:'').'">'.$name.'</span></a> &nbsp;&nbsp;';
	if(!$_SESSION['no']) { ?><span onclick="checkCoPass('<?php echo $co['uid']; ?>');" class="replyDelete" style="<?php echo ($deleteCoUid==$co['uid'])?'font-weight: bold;':''; ?>" title="자신이 작성한 댓글을 삭제합니다."><img src="<?php echo $grblog.$theme; ?>/comment.delete.gif" alt="댓글삭제" /></span> 
	<?php } 	if(!$co['is_reply']) { ?>
	<a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$grblog.$theme; ?>/reply_new_window.php?p=<?php echo $gb['uid']; ?>&amp;replyTo=<?php echo $co['uid']; ?>&amp;writer=<?php echo urlencode($co['name']); ?>&amp;page=<?php echo $page; ?>" onclick="window.open(this.href, '_blank', 'width=700,height=450,menubar=no,scrollbars=no'); return false" title="이 댓글에 댓글을 답니다."><img src="<?php echo $grblog.$theme; ?>/comment.reply.gif" alt="댓글에 댓글달기" /></a> <?php } if($_SESSION['no'] == 1) { ?><a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$grblog; ?>admin.php?admin=5" title="댓글 수정 패널로 갑니다"><img src="<?php echo $grblog.$theme; ?>/comment.modify.gif" alt="댓글관리 (관리자)" /></a><?php } ?>
	</div>

	<!-- 댓글 삭제시 비밀번호 받는 부분 -->
	<form id="enterCoPass<?php echo $co['uid']; ?>" method="post" onsubmit="return isValidPass(this);" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<div><input type="hidden" name="deleteCoUid" value="<?php echo $co['uid']; ?>" /><input type="hidden" name="p" value="<?php echo $gb['uid']; ?>" /></div>
	<div id="enterPass<?php echo $co['uid']; ?>" class="enterPass" style="display: none">
		<div>비밀번호: <input type="password" class="i" name="coPass" /><input type="submit" value="확인" class="s" /></div>
	</div>
	</form>
</div>