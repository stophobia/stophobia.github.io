<div class="co_list">
	<div class="co_name"><?php echo $co['name']; ?></div>
	<div class="co_memo"><?php echo stripslashes($co['content']); ?> <?php if($_SESSION['no'] || ($_SESSION['user_no'] && ($_SESSION['user_no'] == $co['member_key']))) echo '<a href="./?deleteComment='.$co['uid'].'" title="클릭하시면 댓글이 즉시 삭제됩니다."><img src="'.$path.'/image/delete.gif" alt="삭제" /></a>'; ?></div>
	<div class="clr"></div>
</div>