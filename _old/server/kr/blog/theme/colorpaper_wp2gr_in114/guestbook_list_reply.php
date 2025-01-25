<div id="guest<?php echo $reply['uid']; ?>" class="replyBox">
	<div class="top"><?php echo $name; ?> &nbsp; <span><?php echo $date; ?></span> &nbsp; 
	<a href="<?php echo $path; ?>?modifyTarget=<?php echo $reply['uid']; ?>&amp;page=<?php echo $page; ?>">수정</a>
	<?php if($reply['homepage']) { ?><span>|</span> <a href="<?php echo $reply['homepage']; ?>" onclick="window.open(this.href, '_blank'); return false">홈페이지</a> 
	<?php } if($_SESSION['no']) { ?><span>|</span> <a href="<?php echo $path; ?>?deleteTarget=<?php echo $reply['uid']; ?>" onclick="isGuestbookReplyDelete(<?php echo $reply['uid'].', \''.$path; ?>', '<?php echo $_SESSION['no']; ?>'); return false">삭제</a><?php } ?></div>
	<div class="content">
	<?php if($reply['email'] && !$reply['is_secret']) { ?><img src="http://www.gravatar.com/avatar.php?gravatar_id=<?php echo md5($reply['email']).'&default=http://'.urlencode($_SERVER['HTTP_HOST'].$grblog.'image/no_gravatar.gif'); ?>&size=50" alt="gravatar" class="gravatar" align="left" /><?php } echo $content; ?></div>
</div>