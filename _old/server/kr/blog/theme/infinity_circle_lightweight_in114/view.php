<div id="page-title">
	<div class="page-title-content">
		<h3 class="page-title"><?php echo $gb['subject']; ?></h3>
		 <div class="post-meta-single">
		 Posted on <?php echo date('r', $gb['signdate']); ?> by <?php echo $config['name']; ?>
		</div>
	</div>
</div>

<div class="left-content">
	<div class="post">

		<?php 
		// 본문 폭보다 큰 이미지 크기 조절 후 본문 출력
		$gb['content'] = str_replace(array('<img src="', '" alt="upload image"'), 
		array('<img src="phpThumb/phpThumb.php?src=', '&amp;w=650&amp;q=100&amp;fltr[]=usm|99|0.5|3" alt="upload image"'), 
		$gb['content']);
		echo $gb['content']; 
		?>
		<div class="tags">tag …  <?php echo $tagList; ?></div>

		<!-- 트랙백 주소 보여주기 -->
		<div class="trackbackURL"><a href="#write<?php echo $gb['uid']; ?>" title="댓글 쓰기폼으로 이동"><?php echo $gb['trackback_count']+$gb['comment_count']; ?> responses</a>, trackback address: <a href="#" onclick="clickToCopy('<?php echo trackbackURL($gb['uid']); ?>');" style="font-size: 11px; color: #bbb; font-weight: normal; font-family: tahoma, sans-serif;" title="클릭하시면 이 글의 트랙백(엮인글) 주소를 복사하실 수 있습니다."><?php echo trackbackURL($gb['uid']); ?></a></div>
