<div id="guest<?php echo $guest['uid']; ?>" class="guestBox">
	<div class="top"><?php echo $name; ?> &nbsp; <span><?php echo $date; ?></span> &nbsp; 
	<a href="http://<?php echo $_SERVER['HTTP_HOST'].$grblog.$theme; ?>/reply_guestbook_window.php?replyTarget=<?php echo $guest['uid']; ?>&amp;page=<?php echo $page; ?>" onclick="window.open(this.href, 'guestbook', 'menubar=no,scrollbars=no,width=500,height=455'); return false">답글</a> <span>|</span>
	<a href="<?php echo $path; ?>?modifyTarget=<?php echo $guest['uid']; ?>&amp;page=<?php echo $page; ?>">수정</a>
	<?php if($guest['homepage']) { ?><span>|</span> <a href="<?php echo $guest['homepage']; ?>" onclick="window.open(this.href, '_blank'); return false">홈페이지</a> 
	<?php } if($_SESSION['no']) { ?><span>|</span> <a href="<?php echo $path; ?>?deleteTarget=<?php echo $guest['uid']; ?>" onclick="isGuestbookDelete(<?php echo $guest['uid'].', \''.$path; ?>', '<?php echo $_SESSION['no']; ?>'); return false">삭제</a><?php } ?></div>
	<div class="content">
	<?php if($guest['email'] && !$guest['is_secret']) { ?><img src="http://www.gravatar.com/avatar.php?gravatar_id=<?php echo md5($guest['email']).'&default=http://'.urlencode($_SERVER['HTTP_HOST'].$grblog.'image/no_gravatar.gif'); ?>&size=50" alt="gravatar" class="gravatar" align="left" /><?php } echo $content; ?></div>
</div>