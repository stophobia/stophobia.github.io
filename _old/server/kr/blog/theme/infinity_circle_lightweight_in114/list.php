<?php
// 최상단 포스트는 중복 출력 제외
if($nPost['uid'] != $gb['uid']):

// 미리보기 기능 사용시
if($conf_preview) {
	if($preview[1]) $gb['content'] = '<a href="'.$preview[1].'" onclick="return hs.expand(this)" title="클릭하시면 본래 크기의 이미지를 봅니다."><img src="'.$grblog.'phpThumb/phpThumb.php?src='.str_replace($absPath, $grblog, $preview[1]).'&amp;w=80&amp;h=50&amp;q=100&amp;fltr[]=usm|99|0.5|3" alt="preview" class="preview" /></a> '.str_replace(array("\n", '  '), '', $gb['content']);
}
?>
<div class="post">
	<h4><a href="./?p=<?php echo $gb['uid']; ?>" rel="bookmark" title="클릭하시면 포스트를 보러 갑니다."><?php echo $gb['subject']; ?></a></h4>
	<?php echo $gb['content']; ?>
	<div class="post-meta">
	<div class="tags">tag … <?php echo $tagList; ?></div>
	<a href="./?p=<?php echo $gb['uid']; ?>" rel="bookmark" class="btn" title="클릭하시면 본문을 마저 읽습니다.">Read More</a> <span>trackbacks <?php echo $gb['trackback_count']; ?> : comments <?php echo $gb['comment_count']; ?></span>
	</div>
</div>

<?php endif; // 최상단 중복출력 제외 ?>