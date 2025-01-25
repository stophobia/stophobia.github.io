<form id="writeComment<?php echo $memo['uid']; ?>" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div><input type="hidden" name="writeComment" value="1" /><input type="hidden" name="post_num" value="<?php echo $memo['uid']; ?>" /></div>
<div class="replyBox">
	<?php if(!$_SESSION['no'] && !$_SESSION['user_no'] && $mono['use_openid']) { ?><input type="text" name="openid" class="i" value="<?php echo $_SESSION['openID']; ?>" /><?php } ?>
	<textarea name="content" rows="2" cols="50"></textarea><input type="submit" value="댓글 달기" accesskey="s" title="댓글을 답니다" class="s" />
</div>
</form>