<!-- 게시판 하단 시작 -->
<?php if(!defined('__GRBOARD__')) exit(); ?>

<form id="search" method="post" onsubmit="return searchValueCheck();" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div><input type="hidden" name="searchStart" value="1" />
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<input type="hidden" name="division" value="<?php echo $division; ?>" />
<input type="hidden" name="originDivision" value="<?php echo $originDivision; ?>" /></div>
<?php if($printPage) { ?><div class="bottomPaging"><?php echo $printPage; ?></div><?php } ?>
<!-- 글쓰기 , 목록보기 등의 버튼 -->
<div class="menuBox">
	<a href="<?php echo $grboard; ?>/write.php?id=<?php echo $id; ?>&amp;clickCategory=<?php echo $clickCategory; ?>" title="글을 작성합니다.">새글쓰기</a>
	<a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;page=<?php echo $page; ?>&amp;searchOption=<?php echo $searchOption; ?>&amp;searchText=<?php echo urlencode($searchText); ?>" title="글 목록을 봅니다.">목록보기</a>
	<?php
	// 여기서부터는 로그인 후 출력
	if($isMember) { ?><a href="<?php echo $grboard; ?>/info.php?boardId=<?php echo $id; ?>" title="내 정보를 봅니다.">내 정보확인</a>
	<a href="<?php echo $grboard; ?>/logout.php?id=<?php echo $id; ?>" title="로그아웃 합니다.">로그아웃</a>
	<a href="<?php echo $grboard; ?>/view_memo.php" onclick="window.open(this.href, 'memoView', 'width=650, height=600, menubar=no, scrollbars=yes'); return false;" title="내 쪽지함을 열어 봅니다.">쪽지함</a>
	<a href="<?php echo $grboard; ?>/view_scrap.php" onclick="window.open(this.href, 'scrapView', 'width=650, height=600, menubar=no, scrollbars=yes'); return false;" title="내 스크랩북을 열어 봅니다.">스크랩북</a>
	<?php } 
	// 여기서부터는 로그인 안한 상태일 때 출력
	else { ?><a href="<?php echo $grboard; ?>/login.php?boardID=<?php echo $id; ?>" title="로그인 합니다.">로그인</a>
	<a href="<?php echo $grboard; ?>/join.php?joinInBoard=1&amp;boardId=<?php echo $id; ?>" title="멤버로 등록 합니다.">멤버등록</a><?php }
	// 관리자만 쓸 수 있는 기능버튼
	if($isAdmin) { ?>
	<a href="#" onclick="adjustArticle();" title="선택한 글들을 복사/이동/삭제 합니다.">글 관리</a>
	<a href="<?php echo $grboard; ?>/admin_board.php?boardID=<?php echo $id; ?>" title="관리자 화면으로 가서 이 게시판 설정을 변경 합니다.">관리화면</a>
	<?php } 
	// RSS 버튼 출력 (가용할 때만)
	if($isRSS) { ?>
	<a href="<?php echo $grboard; ?>/rss.php?id=<?php echo $id; ?>" onclick="window.open(this.href, 'viewRss', 'width=700, height=600, menubar=no, scrollbars=yes'); return false;" style="color: #f89b72" title="RSS 2.0 피드를 열어 봅니다.">피드</a><?php } ?>
</div>
<!-- 검색 폼 -->
<div class="searchBox">
	<div><select name="searchOption" id="searchOption">
	<option value="subject"<?php echo (($searchOption=='subject')?' selected="selected"':''); ?>>글제목</option>
	<option value="name"<?php echo (($searchOption=='name')?' selected="selected"':''); ?>>글작성자</option>
	<option value="content"<?php echo (($searchOption=='content')?' selected="selected"':''); ?>>글내용</option>
	<option value="link1"<?php echo (($searchOption=='link1')?' selected="selected"':''); ?>>링크1</option>
	<option value="link2"<?php echo (($searchOption=='link2')?' selected="selected"':''); ?>>링크2</option>
	<option value="tag"<?php echo (($searchOption=='tag')?' selected="selected"':''); ?>>태그</option>
	<option value="co_subject"<?php echo (($searchOption=='co_subject')?' selected="selected"':''); ?>>댓글제목</option>
	<option value="co_name"<?php echo (($searchOption=='co_name')?' selected="selected"':''); ?>>댓글작성자</option>
	<option value="co_content"<?php echo (($searchOption=='co_content')?' selected="selected"':''); ?>>댓글내용</option>
	</select><input type="text" name="searchText" id="searchText" onkeydown="startSearch('<?php echo $id; ?>');" class="searchInput" value="<?php echo $searchText; ?>" /><input type="image" class="searchSubmit" src="<?php echo $grboard.'/'.$theme; ?>/image/search_now.gif" alt="검색시작" title="검색을 시작합니다." /></div>
	<div id="searchIndex" style="display: none"></div>
</div>
</form>
<!-- 회원정보 썸네일 박스 -->
<div id="viewMemberInfo" style="display: none" onmouseout="showOff();"></div>

<script type="text/javascript">//<![CDATA[
var GRBOARD = '<?php echo $grboard; ?>/';
//]]></script>
<script type="text/javascript" src="<?php echo $grboard; ?>/js/highslide-full.packed.js"></script>
<script type="text/javascript" src="<?php echo $grboard.'/'.$theme; ?>/list.js"></script>
<script type="text/javascript" src="<?php echo $grboard; ?>/js/member_info.js"></script>
<script type="text/javascript" src="<?php echo $grboard; ?>/js/search_helper.js"></script>

</div><!--# 게시판 끝 -->