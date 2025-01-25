<?php 
if(!defined('__GRBOARD__')) exit();

// 댓글 페이징 출력
if($printPage) { ?><div class="comment_paging"><?php echo $printPage; ?></div><?php } ?>
<div class="menuBox">
	<?php
	if($isMember) { ?>
	<a href="<?php echo $grboard; ?>/logout.php?id=<?php echo $id; ?>">ログアウト</a>
	<?php } 
	else { ?><a class="aid btn-login" href="<?php echo $grboard; ?>/login.php?boardID=<?php echo $id; ?>">ログイン</a><?php }
	if($isAdmin) { ?>
	<a href="<?php echo $grboard; ?>/write.php?id=<?php echo $id; ?>&amp;clickCategory=<?php echo $clickCategory; ?>">記事作成</a>
	<a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;page=<?php echo $page; ?>&amp;searchOption=<?php echo $searchOption; ?>&amp;searchText=<?php echo urlencode($searchText); ?>&amp;clickCategory=<?php echo $clickCategory; ?>">リストへ</a>
	<a href="<?php echo $grboard; ?>/write.php?id=<?php echo $id; ?>&amp;mode=modify&amp;articleNo=<?php echo $articleNo; ?>&amp;page=<?php echo $page; ?>&amp;clickCategory=<?php echo $clickCategory; ?>">修正</a>
	<a href="#" onclick="deleteArticleOk('<?php echo $id.'\', '.$articleNo; ?>);">削除</a>
	<?php } 
	if($isRSS) { ?>
	<a href="<?php echo $grboard; ?>/rss.php?id=<?php echo $id; ?>" onclick="window.open(this.href, 'viewRss', 'width=700, height=600, menubar=no, scrollbars=yes'); return false;" style="color: #f89b72">フィード</a><?php } ?>
	
	
</div>
<?php 
	if(!$isViewList) { ?>
	</div>

<?php } ?>

<script type="text/javascript">//<![CDATA[
var GRBOARD = '<?php echo $grboard; ?>/';
var USE_CO_EDITOR = <?php if($tmpFetchBoard['is_comment_editor']) { ?>true<?php } else { ?>false<?php } ?>;
//]]></script>
<script src="<?php echo $grboard; ?>/js/highslide-full.packed.js" type="text/javascript"></script>
<script src="<?php echo $grboard; ?>/js/prototype.js" type="text/javascript"></script>
<script src="<?php echo $grboard; ?>/js/effects.js" type="text/javascript"></script>
<script src="<?php echo $grboard; ?>/js/dragdrop.js" type="text/javascript"></script>
<script src="<?php echo $grboard; ?>/js/swfobject.js" type="text/javascript"></script>
<script src="<?php echo $grboard.'/'.$theme; ?>/view.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $grboard; ?>/js/member_info.js"></script>