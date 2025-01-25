<?php
// 캐쉬 사용가능하면 캐쉬 파일 부르기
$isCache = $wiki->isAvailableCache();
if($isCache && $a != 'write') include 'cache/'.$isCache.'.html';
else {
	// 초기 진행 (캐쉬 생성 시작)
	if($wiki->isFirstRun()) echo '위키에 아직 문서가 없습니다. <a href="./?m=wiki&amp;a=write&amp;k=welcome">☞ 여기를 눌러 첫페이지를 작성해 보세요!</a>';
	else {
		if($_GET['p']) $showPage = $wiki->getPage('', $grNote['theme'], $_GET['p']);
		elseif($_GET['k']) $showPage = $wiki->getPage($_GET['k'], $grNote['theme'], md5($_GET['k']));
		else $showPage = $wiki->getPage('welcome', $grNote['theme'], '40be4e59b9a2a2b5dffb918c0e86b3d7');
	}

	// 선택된 페이지가 있을 경우
	if($a == 'view' && $showPage['uid']) {
		$showPage['content'] = $wiki->contentFix($showPage['content']);
		@ob_start();
		?>
		<div id="wikiContent">
			<?php echo $showPage['content']; ?>
			<div id="wikiButton">
			<a href="#" onclick="Wiki.docHistory(<?php echo $showPage['uid']; ?>);" title="현재 보고 계시는 문서의 이전 버젼들을 봅니다."><img src="<?php echo $path; ?>/images/wiki.history.icon.gif" alt="과거문서" /></a>
			<a href="#" onclick="Wiki.search();" title="위키 문서를 검색합니다."><img src="<?php echo $path; ?>/images/wiki.search.icon.gif" alt="위키검색" /></a>
			<a href="./?m=wiki&amp;a=write&amp;k=<?php echo urlencode($showPage['keyword']); ?>&amp;modifyDocNo=<?php echo $showPage['uid']; ?>"><img src="<?php echo $path; ?>/images/wiki.modify.icon.gif" alt="수정하기" /></a>
			<a href="#" onclick="Wiki.remove(<?php echo $showPage['uid']; ?>);"><img src="<?php echo $path; ?>/images/wiki.delete.icon.gif" alt="삭제하기" /></a>
			</div>
			<div id="showTime">조회: <?php echo $showPage['view']; ?>, 최근수정자: <?php echo $wiki->getInfo($showPage['writer']); ?>, 최근수정일: <?php echo date('Y-m-d H:i:s', $showPage['signdate']); ?></div>
			<div id="searchBox" style="display: none">
			<form name="search" method="post" action="./?m=wiki" onsubmit="return Wiki.searching();">
			<select name="searchOption"><option value="keyword">제목</option><option value="content">내용</option></select>
			<input type="text" name="searchText" /> <input type="image" src="<?php echo $path; ?>/images/wiki.search.ok.gif" title="검색합니다." />
			</form>
			</div>
			<div id="wikiLatestWord">
				<div id="wordTitle"><strong>&nbsp;&nbsp;&middot;&nbsp;주목할 만한 문서들 펼쳐보기</strong></div>
				<div id="wordList" style="display: none">
				&nbsp;&nbsp;&middot;&nbsp;<strong>최근 추가/수정된 문서</strong>
				<?php $wiki->showLatestWord(10); ?>
				&nbsp;&nbsp;&middot;&nbsp;<strong>많이 보는 문서</strong>
				<?php $wiki->showStarWord(10); ?>
				</div>
				<div id="wikiCtrl"><a href="#" onclick="Wiki.wordToggle();"><img id="ctrlIcon" src="<?php echo $path; ?>/images/more.view.gif" alt="토글" /></a></div>
			</div>
		</div>
		<div id="wikiHistory" style="display: none"></div>
		<?php
		$viewPage = @ob_get_contents();
		@ob_clean();
		$wiki->makeCachePage($showPage['keyword'], $viewPage);
	}

	// 최종 출력 제어
	switch($a) {
		case 'write': $wiki->writePage(urlencode($_GET['k']), $grNote['theme'], $_GET['modifyDocNo']);
		default: echo $viewPage;
	}
}
?>