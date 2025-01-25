<div id="articleListPage">
<!-- 목록보기 상단 부분 -->
<div>
	<div class="articleHead">정렬방식: &nbsp;&nbsp;
		<a href="./article_list.php?orderBy=signdate&amp;desc=<?php echo (($desc == 'desc')?'asc':'desc'); ?>&amp;cat=<?php echo $cat; ?>">작성날짜</a>&nbsp;|&nbsp;
		<a href="./article_list.php?orderBy=subject&amp;desc=<?php echo (($desc == 'desc')?'asc':'desc'); ?>&amp;cat=<?php echo $cat; ?>">제목</a>&nbsp;|&nbsp;
		<a href="./article_list.php?orderBy=comment_count&amp;desc=<?php echo (($desc == 'desc')?'asc':'desc'); ?>&amp;cat=<?php echo $cat; ?>">코멘트수</a>&nbsp;|&nbsp;
		<a href="./article_list.php?orderBy=trackback_count&amp;desc=<?php echo (($desc == 'desc')?'asc':'desc'); ?>&amp;cat=<?php echo $cat; ?>">트랙백수</a>
	</div>
</div>
<ul>