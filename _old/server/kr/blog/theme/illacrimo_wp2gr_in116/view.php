<div class="Post" id="post-<?php echo $gb['uid']; ?>" style="padding-bottom: 30px">
<div class="PostHead">
	<h1><a href="./?p=<?php echo $gb['uid']; ?>"><?php echo $gb['subject']; ?></a></h1>
	<small class="PostAuthor">
		<?php echo date('r', $gb['signdate']); ?> 
		<?php if($_SESSION['no']) { ?><a href="./admin.php?admin=2&modifyTarget=<?php echo $gb['uid']; ?>">[modify]</a><?php } ?>
	</small>
	<p class="PostDate">
		<small class="day"><?php echo date('j', $gb['signdate']); ?></small>
		<small class="month"><?php echo date('M', $gb['signdate']); ?></small>
	</p>
</div>

<div class="PostContent">
	<?php 
	// 본문 출력 전 전처리
	$gb['content'] = str_replace(array('<img src="', '" alt="upload image"'), 
		array('<img src="phpThumb/phpThumb.php?src=', '&amp;w=400&amp;q=100&amp;fltr[]=usm|99|0.5|3" alt="upload image"'), 	$gb['content']);
	echo $gb['content'];
	?>
</div>

<ul class="PostDet">
	<li class="PostCateg"><?php echo $tagList; ?> <br /></li>
	<li class="NoteTrackBack"><a href="#" onclick="clickToCopy('<?php echo trackbackURL($gb['uid']); ?>');"><?php echo trackbackURL($gb['uid']); ?></a></li>
</ul>
</div>

<div class="clearer"></div>


<div class="Comments">
<div class="List">
<!-- Start CommentsList-->

<h3 id="comments"><?php echo ($gb['comment_count']+$gb['trackback_count']); ?> Responses</h3> 
<ol>