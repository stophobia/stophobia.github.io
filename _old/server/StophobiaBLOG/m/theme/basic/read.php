<div class="post">
	<div class="title">
		<?php echo $gb['subject']; ?>
		<div class="date"><?php echo date('Y.m.d H:i', $gb['signdate']); ?></div>
	</div>
	<div class="content">
		<?php echo $gb['content']; ?>
	</div>
</div>
<div class="prev"><?php echo $prevPost; ?></div>
<div class="next"><?php echo $nextPost; ?></div>