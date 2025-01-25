	<div class="comment-metadata term">
		<div><strong><?php echo '<a href="'.$tb['url'].'" title="클릭하시면 이 엮인글을 보러 이동합니다.">'.stripslashes($tb['subject']); ?></a></strong></div>
		<div class="tiny"><?php echo stripslashes($tb['summary']); ?></div>
		<p class="tiny"><?php echo stripslashes($tb['name']); ?> on <?php echo date('Y.m.d H:i:s', $tb['signdate']); ?>
		<?php if($_SESSION['no'] == 1) { ?><a href="admin.php?admin=6&amp;modifyTarget=<?php echo $tb['uid']; ?>" title="이 글을 수정합니다">, modify</a><?php } ?></p>
	</div>