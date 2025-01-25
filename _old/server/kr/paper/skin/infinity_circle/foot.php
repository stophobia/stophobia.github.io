<?php
/*
	GR Paper 기본 스킨 하단
	작성자: 박희근 (http://sirini.net)
	수정일: 2008-08-26
	내  용: 기본 Paper 디자인 하단(+사이드바) 부분.
	주  의: 이 파일은 Paper 첫화면부터 로그인 화면까지 하단 부분에 고정 출연임.
*/
?>
<div id="right-col">

	<div id="logo">
		<h1><?php echo $browserTitle; ?></h1>
	</div>

	<ul id="right-content">

		<?php 
		// 공지사항 출력 (GR보드 연동시)
		if($grboardPath) { ?>
		<li><h5>Notice</h5>
		<ul><?php while($note = $getNotice->fetch_array()) {
			echo '<li><a href="'.$noteLink.$note['no'].'">'.stripslashes($note['subject']).'</a> <span>'.date('m.d', $note['signdate']).'</span></li>';
		} ?></ul>
		</li>

		<?php
		// 최근 인기글 출력
		} if($hotPostNumber) { ?>
		<li><h5>오늘의 인기글</h5>
		<ul><?php while($hot = $getHotPost->fetch_array()) {
			echo '<li><a href="'.$config['absPath'].'/read/?u='.$hot['uid'].'&amp;r=http://'.$hot['link'].'">'.stripslashes($hot['subject']).'</a></li>';
		} ?></ul>
		</li>

		<?php
		// 최근 등록 블로그 출력
		} if($blogNumber) { ?>
		<li><h5>최근 등록된 블로그</h5>
		<ul><?php while($blog = $getBlogList->fetch_array()) {
			echo '<li><a href="http://'.$blog['url'].'" title="'.stripslashes($blog['info']).'">'.stripslashes($blog['name']).'</a></li>';
		} ?></ul>
		</li>
		
		<?php
		// 인그 태그 출력
		} if($tagNumber) { ?>
		<li><h5>많이 쓰인 태그들</h5>
		<div id="tagList">
		<?php while($tag = $getHotTag->fetch_array()) {
			$tagName = stripslashes($tag['tag']);
			if($tag['count'] > 5 && $tag['count'] < 20) $class = 1;
			elseif($tag['count'] > 19 && $tag['count'] < 50) $class = 2;
			elseif($tag['count'] > 49 && $tag['count'] < 100) $class = 3;
			elseif($tag['count'] > 99) $class = 'Max';
			else $class = 0;
			echo '<a href="'.$config['absPath'].'/?so=tag&amp;st='.urlencode($tagName).'" class="lv'.$class.'">'.$tagName.'</a> ';
		} ?>
		</div>
		</li>
		<?php } ?>

		<!-- 통계 -->
		<li><h5>페이퍼 통계</h5>
		<ul>
			<li class="stat">구독중인 RSS수: <?php echo $c->totalRowNum('feed_list'); ?> 개</li>
			<li class="stat">수집된 포스트수: <?php echo $c->totalRowNum('feed'); ?> 개</li>
			<li class="stat">수집된 태그 수: <?php echo $c->totalRowNum('tag'); ?> 개</li>
			<li class="stat">수집된 그림 수: <?php echo $c->totalRowNum('image'); ?> 개</li>
			<li class="stat">자동 수집 간격: <?php echo $c->get('botTerm'); ?> 분</li>
		</ul>
		</li>

		<li>
			<form id="search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<div id="searchForm">
			<select name="so">
				<option value="subject"<?php echo (($so == 'subject')?' selected="selected"':'');?>>제목</option>
				<option value="content"<?php echo (($st == 'content')?' selected="selected"':'');?>>내용</option>
				<option value="tag"<?php echo (($st == 'tag')?' selected="selected"':'');?>>태그</option>
				<option value="author"<?php echo (($st == 'author')?' selected="selected"':'');?>>블로거</option>
				<option value="link"<?php echo (($st == 'link')?' selected="selected"':'');?>>주소</option>
			</select>
			<div id="searchBtnBox"><input type="text" name="st" value="<?php echo $st; ?>" class="text" style="width: 100px" /><input type="submit" value="Search" class="btn submit" title="검색합니다." /></div>
			</div>
			</form>
		</li>

	</ul>

</div>


<div id="getDirName" class="hidden"><?php echo $c->dirName; ?></div>
<div id="getBotTerm" class="hidden"><?php echo $botTerm; ?></div>
</body>
</html>