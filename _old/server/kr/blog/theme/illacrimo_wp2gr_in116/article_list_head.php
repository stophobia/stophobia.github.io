<div id="articleListPage">
<!-- 목록보기 상단 부분 -->
<div>
	<div class="articleHead">
		정렬:
		<a href="./article_list.php?orderBy=signdate&amp;desc=<?php echo (($desc == 'desc')?'asc':'desc'); ?>&amp;cat=<?php echo $cat; ?>">작성날짜</a> /
		<a href="./article_list.php?orderBy=subject&amp;desc=<?php echo (($desc == 'desc')?'asc':'desc'); ?>&amp;cat=<?php echo $cat; ?>">제목</a> /
		<a href="./article_list.php?orderBy=comment_count&amp;desc=<?php echo (($desc == 'desc')?'asc':'desc'); ?>&amp;cat=<?php echo $cat; ?>">댓글수</a> /
		<a href="./article_list.php?orderBy=trackback_count&amp;desc=<?php echo (($desc == 'desc')?'asc':'desc'); ?>&amp;cat=<?php echo $cat; ?>">엮인글수</a>
	</div>
</div>
<ul>