<?php
/*
	GR Paper 기본 스킨 하단
	작성자: 박희근 (http://sirini.net)
	수정일: 2009-07-9
	내  용: 기본 Paper 디자인 하단(+사이드바) 부분.
	주  의: 이 파일은 Paper 첫화면부터 로그인 화면까지 하단 부분에 고정 출연임.
*/
?>
				</div>
			</div>

			<div class="right" id="sidebar_wrapper">
				<div id="sidebar">

				<?php 
				// 공지사항 출력 (GR보드 연동시)
				if($grboardPath) { ?>
					<div class="box">
						<div class="box_title">공지사항</div>

						<div class="box_content">
							<ul>
							<?php while($note = $getNotice->fetch_array()) {
								echo '<li><a href="'.$noteLink.$note['no'].'">'.stripslashes($note['subject']).'</a> <span>'.date('m.d', $note['signdate']).'</span></li>';
							} ?>
							</ul>
						</div>
					</div>


				<?php
				// 최근 인기글 출력
				} if($hotPostNumber) { ?>
					<div class="box">
						<div class="box_title">오늘의 인기글</div>

						<div class="box_content">
							<ul>
							<?php while($hot = $getHotPost->fetch_array()) {
								echo '<li><a href="'.$config['absPath'].'/read/?u='.$hot['uid'].'&amp;r=http://'.$hot['link'].'">'.stripslashes($hot['subject']).'</a></li>';
							} ?>
							</ul>
						</div>
					</div>

				<?php
				// 통계 출력
				} ?>

					<div class="box">
						<div class="box_title">검색</div>

						<div class="box_content">
							<form method="get" id="searchform" action="<?php echo $config['absPath']; ?>">
							<div>
								<select name="so">
									<option value="subject"<?php echo (($so == 'subject')?' selected="selected"':'');?>>제목</option>
									<option value="content"<?php echo (($st == 'content')?' selected="selected"':'');?>>내용</option>
									<option value="tag"<?php echo (($st == 'tag')?' selected="selected"':'');?>>태그</option>
									<option value="author"<?php echo (($st == 'author')?' selected="selected"':'');?>>블로거</option>
									<option value="link"<?php echo (($st == 'link')?' selected="selected"':'');?>>주소</option>
								</select>
								<input type="text" value="<?php echo $st; ?>" name="st" id="st" size="10" class="text" /> 
								<input type="submit" class="button" value="Submit" />
							</div>
							</form>
						</div>
					</div>

				</div>
			</div>

			<!-- #실제 하단 부분# -->
			<div class="clearer">&nbsp;</div>

		</div>
	</div>

	<div id="dashboard_wrapper">
		<div id="dashboard">

			<div class="col3 left">
				<div class="col3_content">

					<div class="col_title">페이퍼 통계</div>
					<ul>
						<li class="stat">구독중인 RSS수: <?php echo $c->totalRowNum('feed_list'); ?> 개</li>
						<li class="stat">수집된 포스트수: <?php echo $c->totalRowNum('feed'); ?> 개</li>
						<li class="stat">수집된 태그 수: <?php echo $c->totalRowNum('tag'); ?> 개</li>
						<li class="stat">수집된 그림 수: <?php echo $c->totalRowNum('image'); ?> 개</li>
						<li class="stat">자동 수집 간격: <?php echo $c->get('botTerm'); ?> 분</li>
					</ul>

				</div>
			</div>

			<div class="col3mid left">
				<div class="col3_content">

					<div class="col_title">많이 쓰인 꼬리표들</div>
					<p><?php while($tag = $getHotTag->fetch_array()) {
					$tagName = stripslashes($tag['tag']);
					if($tag['count'] > 5 && $tag['count'] < 20) $style = '12';
					elseif($tag['count'] > 19 && $tag['count'] < 50) $style = '16';
					elseif($tag['count'] > 49 && $tag['count'] < 100) $style = '22';
					elseif($tag['count'] > 99) $style = '26';
					else $style = '11';
					echo '<a href="'.$config['absPath'].'/?so=tag&amp;st='.urlencode($tagName).'" style="font-size: '.$class.'pt">'.$tagName.'</a> ';
				} ?></p>

				</div>
			</div>

			<div class="col3 right">
				<div class="col3_content">

					<div class="col_title">최근 등록된 블로그</div>
					<ul>
						<?php 
						// 블로그 목록 페이지에서 최근 등록된 블로그 불러오기시 충돌방지
						if(__GRPATH__ == 'list') {
							while($blog = $getLatestBlogList->fetch_array()) {
								echo '<li><a href="http://'.$blog['url'].'" title="'.stripslashes($blog['info']).'">'.stripslashes($blog['name']).'</a></li>';
							} 
						} else {
							while($blog = $getBlogList->fetch_array()) {
								echo '<li><a href="http://'.$blog['url'].'" title="'.stripslashes($blog['info']).'">'.stripslashes($blog['name']).'</a></li>';
							} 
						}
						?>
					</ul>

				</div>
			</div>

			<div class="clearer">&nbsp;</div>

		</div>
	</div>

	<div id="footer">

		<div class="left">
			&copy; <?php echo date('Y'); ?> <?php echo $browserTitle; ?>
		</div>
		<div class="right">
			Powered by <a href="http://sirini.net/">GR Paper</a>,
			<a href="http://templates.arcsin.se/">Theme</a> by <a href="http://arcsin.se/">Arcsin</a>,
			Converted by <a href="http://sirini.net/">sirini</a>
		</div>
		
		<div class="clearer">&nbsp;</div>

	</div>

</div>
</div>
</div>
</div>

<div id="getDirName" class="hidden"><?php echo $c->dirName; ?></div>
<div id="getBotTerm" class="hidden"><?php echo $botTerm; ?></div>

</body>
</html>