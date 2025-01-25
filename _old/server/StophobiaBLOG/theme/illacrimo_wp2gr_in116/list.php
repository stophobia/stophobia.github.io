<?php
// 미리보기 기능 사용시
if($conf_preview) {
	if($preview[1]) $gb['content'] = '<a href="'.$preview[1].'" onclick="return hs.expand(this)" title="클릭하시면 본래 크기의 이미지를 봅니다."><img src="'.$grblog.'phpThumb/phpThumb.php?src='.str_replace($absPath, $grblog, $preview[1]).'&amp;w=80&amp;h=50&amp;q=100&amp;fltr[]=usm|99|0.5|3" alt="preview" class="preview" /></a> '.str_replace(array("\n", '  '), '', $gb['content']);
}
?>
<div class="Post" id="post-<?php echo $gb['uid']; ?>" style="padding-bottom: 30px">
<div class="PostHead">
	<h1><a href="./?p=<?php echo $gb['uid']; ?>"><?php echo $gb['subject']; ?></a></h1>
	<p class="PostDate">
		<small class="day"><?php echo date('j', $gb['signdate']); ?></small>
		<small class="month"><?php echo date('M', $gb['signdate']); ?></small>
	</p>
</div>

<div class="PostContent regular"><?php echo $gb['content']; ?></div>
<ul class="PostDet">
	<li class="PostCom"><strong><?php echo ($gb['comment_count']+$gb['trackback_count']); ?></strong> Response</li>
	<li class="PostCateg"><?php echo $tagList; ?></li>
</ul>
</div>

<div class="clearer"></div>