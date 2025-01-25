<?php
// 댓글 처리
if($co['is_secret'] && !$_SESSION['no']) $co['content'] = '<span style="color: red">비밀 댓글 입니다.</span>';
if($co['homepage']) $name = '<a href="'.$co['homepage'].'" title="'.$name.' 님의 웹사이트(블로그)를 방문 합니다">'.$name.'</a>';

// 포스트 보기 화면이 아니고 목록화면일 때
if(!$p) {
	$co['content'] = nl2br(stripslashes($co['content']));
	$name = stripslashes($co['name']);
}

// 처음 댓글일 때 처리
if(!$_loopReply) {
	$_loopReply = 1;
	echo '<ol class="commentlist">';
}
$co['reply'] = ($co['is_reply']) ? '_reply' : '';
?>

<li class="clearfix alt">
	<div id="viewComment<?php echo $co['uid']; ?>" class="comment-author<?php echo $co['reply']; ?>">
		<img src="http://www.gravatar.com/avatar.php?gravatar_id=<?php echo md5($co['email']).'&default=http://'.urlencode($_SERVER['HTTP_HOST'].$grblog.'image/no_gravatar.gif'); ?>&size=50" alt="gravatar" class="avatar avatar-56" align="left" />
	</div>
	<div class="comment-text<?php echo $co['reply']; ?>">		
	<span class="medium"><?php if($co['reply']) echo '<span class="small pink">[답글]</span> '; echo $co['content']; ?></span>
	<p>	
		Name: <?php echo $name; ?> / Date: <?php echo date('Y-m-d H:i', $co['signdate']); ?>
		/ <span class="small bn" onclick="checkCoPass('<?php echo $co['uid']; ?>');">delete</span>
		<?php if(!$co['is_reply']) { ?>
		/ <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$grblog.$theme; ?>/reply_new_window.php?p=<?php echo $gb['uid']; ?>&amp;replyTo=<?php echo $co['uid']; ?>&amp;writer=<?php echo urlencode($co['name']); ?>&amp;page=<?php echo $page; ?>" onclick="window.open(this.href, '_blank', 'width=700,height=450,menubar=no,scrollbars=no'); return false" title="이 댓글에 댓글을 답니다." class="small pink">+답글달기</a>
		<?php } ?>
	</p>
	</div>

	<!-- 댓글 삭제시 비밀번호 받는 부분 -->
	<form id="enterCoPass<?php echo $co['uid']; ?>" method="post" onsubmit="return isValidPass(this);" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<div><input type="hidden" name="deleteCoUid" value="<?php echo $co['uid']; ?>" /><input type="hidden" name="p" value="<?php echo $gb['uid']; ?>" /></div>
	<div id="enterPass<?php echo $co['uid']; ?>" class="enterPass" style="display: none">
		<div>비밀번호: <input type="password" class="i" name="coPass" /><input type="submit" value="확인" class="s" /></div>
	</div>
	</form>
</li>

<?php 
if($_loopReply == $gb['comment_count']) {
	echo '</ol>';
	unset($_loopReply);
} else $_loopReply++;
?>