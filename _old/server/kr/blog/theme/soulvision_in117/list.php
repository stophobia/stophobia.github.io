<?php
// 미리보기 기능 사용시
if($conf_preview) {
	if($preview[1]) $gb['content'] = '<a href="'.$preview[1].'" onclick="return hs.expand(this)" title="클릭하시면 본래 크기의 이미지를 봅니다."><img src="'.$grblog.'phpThumb/phpThumb.php?src='.str_replace($absPath, $grblog, $preview[1]).'&amp;w=80&amp;h=50&amp;q=100&amp;fltr[]=usm|99|0.5|3" alt="preview" class="preview" /></a> '.str_replace(array("\n", '  '), '', $gb['content']);
}

if($firstrun) {
	echo '<div class="postwrap">';
	$firstrun = false;
}
?>
    <div class="post" id="post-<?php echo $gb['uid']; ?>" style="padding-bottom: 40px;">
      
	  <div class="posthead">
        <h1><a href="./?p=<?php echo $gb['uid']; ?>"><?php echo $gb['subject']; ?></a></h1>
        <small class="postauthor">Posted by <?php echo $config['name']; ?></small>
        <p class="postdate"> 
			<small class="month"><?php echo date('M', $gb['signdate']); ?></small> 
			<small class="day"><?php echo date('j', $gb['signdate']); ?></small> 
		</p>
      </div>

      <div class="postcontent"><?php echo $gb['content']; ?></div>
      <div class="postinfo">
        <li class="postcomments"><?php echo ($gb['comment_count']+$gb['trackback_count']); ?></strong> Response</li>
        <li class="postcat">tags: <?php echo $tagList; ?></li>
		<div class="clearer"></div>
      </div>

    </div>

    <div class="clearer"></div>