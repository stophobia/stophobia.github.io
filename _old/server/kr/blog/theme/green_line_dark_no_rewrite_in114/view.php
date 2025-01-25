<div class="list">
	<div class="title">
		<div class="titleBox">··· <a href="#"><?php echo $gb['subject']; ?></a><span><?php echo date('Y/n/j', $gb['signdate']); 
			if($_SESSION['no'] == 1) { ?>, &nbsp; <a href="<?php echo $grblog; ?>admin.php?admin=2&amp;modifyTarget=<?php echo $gb['uid']; ?>" title="이 글을 수정합니다">modify</a><?php } ?></span>
		</div>
	</div>
	<div class="content">
	<?php echo $gb['content']; ?>
		<div class="tag">tag …  <?php echo $tagList; ?></div>
	</div>
</div>

<!-- 트랙백 주소 보여주기 -->
<div class="trackbackURL"><a href="#write<?php echo $gb['uid']; ?>" title="댓글 쓰기폼으로 이동"><?php echo $gb['trackback_count']+$gb['comment_count']; ?> responses</a>, trackback address: <a href="#" onclick="clickToCopy('<?php echo trackbackURL($gb['uid']); ?>');" style="font-size: 11px; color: #bbb; font-weight: normal; font-family: tahoma, sans-serif;" title="클릭하시면 이 글의 트랙백(엮인글) 주소를 복사하실 수 있습니다."><?php echo trackbackURL($gb['uid']); ?></a></div>

<!-- <rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:trackback="http://madskills.com/public/xml/rss/module/trackback/">
<rdf:Description rdf:about="<?php echo $absPath.$gb['uid']; ?>" dc:identifier="<?php echo $absPath.$gb['uid']; ?>" dc:title="<?php echo $gb['subject']; ?>" trackback:ping="<?php echo trackbackURL($gb['uid']); ?>" /></rdf:RDF> -->