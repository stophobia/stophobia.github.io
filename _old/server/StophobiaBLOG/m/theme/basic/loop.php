<?php
// 본문 내 그림 썸네일 만들기
preg_match('|<img src="(.+?)" alt="upload image"|i', $gb['content'], $preview);
if($preview[1]) $gb['thumb'] = '../phpThumb/phpThumb.php?src='.str_replace($absPath, $grblog, $preview[1]).'&amp;w=45&amp;h=45&amp;q=100&amp;fltr[]=usm|99|0.5|3';
else $gb['thumb'] = $theme.'/no_img.gif';
?>
<div class="list">
	<div class="thumb"><img src="<?php echo $gb['thumb']; ?>" alt="" /></div>
	<div class="title"><a href="index.php?p=<?php echo $gb['uid']; ?>&amp;page=<?php echo $page; ?>"><?php echo $gb['subject']; ?></a></div>
	<div class="date"><?php echo date('Y.m.d H:i', $gb['signdate']); ?>, Responses(<?php echo $gb['comment_count']+$gb['trackback_count']; ?>)</div>
</div>