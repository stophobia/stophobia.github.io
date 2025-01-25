<?php 
if(!defined('__GRBOARD__')) exit();

// 댓글 페이징 출력
if($printPage) { ?><div class="comment_paging"><?php echo $printPage; ?></div><?php } ?>
<!-- 글보기 화면 하단 버튼들 출력 -->
<div class="menuBox">
	<a href="<?php echo $grboard; ?>/write.php?id=<?php echo $id; ?>&amp;clickCategory=<?php echo $clickCategory; ?>" title="글을 작성합니다">새글작성</a>
	<a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;page=<?php echo $page; ?>&amp;searchOption=<?php echo $searchOption; ?>&amp;searchText=<?php echo urlencode($searchText); ?>&amp;clickCategory=<?php echo $clickCategory; ?>" title="목록을 봅니다">목록보기</a>
	<a href="<?php echo $grboard; ?>/write.php?id=<?php echo $id; ?>&amp;mode=modify&amp;articleNo=<?php echo $articleNo; ?>&amp;page=<?php echo $page; ?>&amp;clickCategory=<?php echo $clickCategory; ?>" title="글을 수정합니다">수정하기</a>
	<a href="#" onclick="deleteArticleOk('<?php echo $id.'\', '.$articleNo; ?>);" title="이 게시물을 삭제합니다.">삭제하기</a>
	<?php 
	// 관리자 전용 기능 - 블라인드 설정
	if($isAdmin && ($view['bad'] > -1000)) { ?>
	<a href="#" onclick="blindArticleOk('<?php echo $id.'\', '.$articleNo; ?>, 'bbs_', <?php echo $articleNo; ?>);" title="이 게시물을 블라인드 처리 합니다. (삭제하지는 않고, 게시물 내용만 확인이 안됩니다.)">블라인드 하기</a>
	<?php } 
	// 관리자 전용 기능 - 블라인드 해제
	if($isAdmin && ($view['bad'] < -1000)) { ?>
	<a href="#" onclick="blindArticleNo('<?php echo $id.'\', '.$articleNo; ?>, 'bbs_', <?php echo $articleNo; ?>);" title="이 게시물의 블라인드 처리를 해제합니다. (가려졌던 게시물 내용이 다시 보입니다.)">블라인드 해제</a>
	<?php } ?>
</div>
</div>

<!-- 장바구니에 담기 클릭시 안내문구 -->
<div id="addCartMsg" title="장바구니에 추가하였습니다!">
	<p>
		이 상품을 고객님의 장바구니에 담아두었습니다.<br />
		<strong>Ok</strong> 를 누르시면 계속 쇼핑을 하실 수 있습니다.<br />
	</p>
<?php 
	// 글 보기시 아래 목록을 펼치지 않을 때
	if(!$isViewList) { ?>
	</div>

	<!-- 회원정보를 레이어 팝업으로 보기 -->
	<form id="list" action="/" method="post"><input type="hidden" id="id" value="<?php echo $id; ?>" /></form>
	<div id="viewMemberInfo" style="display: none" onmouseout="showOff();"></div>
<?php } ?>

<script type="text/javascript">//<![CDATA[
var GRBOARD = '<?php echo $grboard; ?>/';
var USE_CO_EDITOR = <?php if($tmpFetchBoard['is_comment_editor']) { ?>true<?php } else { ?>false<?php } ?>;
//]]></script>
<script src="<?php echo $grboard; ?>/js/prototype.js" type="text/javascript"></script>
<script src="<?php echo $grboard; ?>/js/highslide-full.packed.js" type="text/javascript"></script>
<script src="<?php echo $grboard; ?>/js/swfobject.js" type="text/javascript"></script>
<script src="<?php echo $grboard.'/'.$theme; ?>/view.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $grboard; ?>/js/member_info.js"></script>