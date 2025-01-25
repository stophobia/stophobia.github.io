<div id="viewTrackback<?php echo $tb['uid']; ?>" class="list">
	<div class="t_title"><?php echo '<a href="'.$tb['url'].'" title="클릭하시면 이 엮인글을 보러 이동합니다.">'.stripslashes($tb['subject']); ?></a></div>
	<div class="t_content">
	<?php echo stripslashes($tb['summary']); ?>
	</div>
	<div class="t_bottom">
	<?php if($_SESSION['no'] == 1) { ?>
	<a href="admin.php?admin=6&amp;modifyTarget=<?php echo $tb['uid']; ?>" title="이 글을 수정합니다"><img src="<?php echo $theme; ?>/modify.gif" alt="수정하기" /></a> 
	<?php } 
	echo '<span title="'.date('Y.m.d H:i:s', $tb['signdate']).(($_SESSION['no'] == 1)?' / '.$tb['ip']:'').'">'.stripslashes($tb['name']).'</span>'; ?>
	</div>
</div>