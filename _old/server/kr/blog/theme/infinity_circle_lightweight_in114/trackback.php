<?php
if(!$_loopTrb) {
	$_loopTrb = 1;
	echo '<ol class="commentlist">';
}
?>
<li class="clearfix alt"><div id="viewTrackback<?php echo $tb['uid']; ?>" class="comment-author">
	<span class="pink">[엮인글]</span>
	</div>

	<div class="comment-text">
		<div><strong><?php echo '<a href="'.$tb['url'].'" title="클릭하시면 이 엮인글을 보러 이동합니다.">'.stripslashes($tb['subject']); ?></a></strong></div>
		<span class="medium"><?php echo stripslashes($tb['summary']); ?></span>
		<p><?php echo stripslashes($tb['name']); ?> on <?php echo date('Y.m.d H:i:s', $tb['signdate']); ?>
		<?php if($_SESSION['no'] == 1) { ?><a href="admin.php?admin=6&amp;modifyTarget=<?php echo $tb['uid']; ?>" title="이 글을 수정합니다">, modify</a><?php } ?></p>
	</div>
</li>
<?php 
if($_loopTrb == $gb['trackback_count']) {
	echo '</ol>';
	unset($_loopTrb);
} else $_loopTrb++;
?>