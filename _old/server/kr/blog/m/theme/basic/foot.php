<?php
if(!defined('__GRBLOG__')) exit();
?>
<div class="paging">
	<a href="./?page=<?php echo $page; ?>" class="menu">LIST</a>
	<?php if($page > 1) { ?><a href="./?page=<?php echo $page-1; ?>">◀ PREV</a>
	<?php } if($page < $totalPage) { ?><a href="./?page=<?php echo $page+1; ?>">NEXT ▶</a><?php } ?>
	<a href="#"><?php echo $page.'/'.$totalPage; ?></a>
</div>

<div class="search">
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return searchOk(this);" method="post">
		<div><select name="so">
			<option value="subject" <?php echo (($so == 'subject')?'selected="selected"':'');?>>제목</option>
			<option value="content" <?php echo (($st == 'content')?'selected="selected"':'');?>>내용</option>
			<option value="tag" <?php echo (($st == 'tag')?'selected="selected"':'');?>>태그</option>
			<option value="writer" <?php echo (($st == 'writer')?'selected="selected"':'');?>>ID</option>
		</select>
		<input type="text" name="st" class="f" />
		<input type="submit" value="검색" class="s" /></div>
	</form>
</div>
</body>
</html>