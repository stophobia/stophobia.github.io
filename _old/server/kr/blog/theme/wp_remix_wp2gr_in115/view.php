<!-- ## 글 보기 시작 ## -->
<h3 class="h1"><a href="./?p=<?php echo $gb['uid']; ?>" rel="bookmark" title="클릭하시면 포스트를 보러 갑니다."><?php echo $gb['subject']; ?></a></h3>
		
<div class="post-meta-top">
<div class="auth"><span>Posted by <strong><?php echo stripslashes($config['name']); ?></strong></span></div>
<div class="date"><span> at <strong><?php echo date('r', $gb['signdate']); ?></strong></span></div>
</div>

<div class="clearboth"></div>

<div class="contentBody">
<?php 
// 본문 폭보다 큰 이미지 크기 조절 후 본문 출력
$gb['content'] = str_replace(array('<img src="', '" alt="upload image"'), 
	array('<img src="phpThumb/phpThumb.php?src=', '&amp;w=500&amp;q=100&amp;fltr[]=usm|99|0.5|3" alt="upload image"'), 	$gb['content']);
echo $gb['content']; 
?>
</div>
	
<div class="post-bottom">
<strong>Tags: </strong><?php echo $tagList; ?><br />
<strong>Trackback: </strong><a href="#" onclick="clickToCopy('<?php echo trackbackURL($gb['uid']); ?>');" title="클릭하시면 이 글의 트랙백(엮인글) 주소를 복사하실 수 있습니다."><?php echo trackbackURL($gb['uid']); ?></a>
<div class="clearfix"></div>
</div>

<!-- ## 댓글 시작 ## -->
<div id="comments-wrap">
<h6 class="comments"><em><?php echo $gb['trackback_count']+$gb['comment_count']; ?> responses</em></h6>
<div id="commentlist">