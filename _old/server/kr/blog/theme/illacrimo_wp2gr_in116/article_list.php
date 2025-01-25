<li class="articleList">
	<a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$grblog.'?p='.$gb['uid']; ?>">
		<?php echo stripslashes($gb['subject']); ?></a>
	<span>(T: <?php echo $gb['trackback_count'].' / C: '.$gb['comment_count'].' / D: '.date('m.d', $gb['signdate']); ?>)</span>
</li>