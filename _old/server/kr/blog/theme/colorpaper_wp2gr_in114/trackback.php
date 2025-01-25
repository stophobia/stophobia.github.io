<?php
if(!$_loopTrb) {
	$_loopTrb = 1;
	echo '<ol class="commentlist">';
}
?>
<li class="clearfix alt"><div id="viewTrackback<?php echo $tb['uid']; ?>" class="comment-author">
	<span class="pink weight-bold verdana block large"><?php echo stripslashes($tb['name']); ?></span>
	<span class="small verdana light">on <?php echo date('F jS, Y', $tb['signdate']); ?></span>
	<?php if($_SESSION['no'] == 1) { ?><a href="admin.php?admin=6&amp;modifyTarget=<?php echo $tb['uid']; ?>" title="이 글을 수정합니다"><span class="small verdana">, modify</span></a><?php } ?>
	</div>

	<div class="comment-text">
		<div><strong><?php echo '<a href="'.$tb['url'].'" title="클릭하시면 이 엮인글을 보러 이동합니다.">'.stripslashes($tb['subject']); ?></a></strong></div>
		<span class="medium"><?php echo stripslashes($tb['summary']); ?></span>
	</div>
</li>
<?php 
if($_loopTrb == $gb['trackback_count']) echo '</ol>';
$_loopTrb++;
?>