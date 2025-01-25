<?php if(!defined('__GRBOARD__')) exit(); ?>

<form id="search" method="post" onsubmit="return searchValueCheck();" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div><input type="hidden" name="searchStart" value="1" />
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<input type="hidden" name="division" value="<?php echo $division; ?>" />
<input type="hidden" name="originDivision" value="<?php echo $originDivision; ?>" /></div>
<?php if($printPage) { ?><div class="bottomPaging"><?php echo $printPage; ?></div><?php } ?>
<div class="menuBox">
	<?php
	if($isMember) { ?>
	<a href="<?php echo $grboard; ?>/logout.php?id=<?php echo $id; ?>">ログアウト</a>　
	<?php } 
	else { ?><a class="aid btn-login" href="<?php echo $grboard; ?>/login.php?boardID=<?php echo $id; ?>">ログイン</a>　<?php }
	if($isAdmin) { ?>
	<a href="<?php echo $grboard; ?>/write.php?id=<?php echo $id; ?>&amp;clickCategory=<?php echo $clickCategory; ?>">記事作成</a>　
	<a href="#" onclick="adjustArticle();">記事管理</a>　
	<?php } 
	if($isRSS) { ?>
	<a href="<?php echo $grboard; ?>/rss.php?id=<?php echo $id; ?>" onclick="window.open(this.href, 'viewRss', 'width=700, height=600, menubar=no, scrollbars=yes'); return false;" style="color: #f89b72">フィード</a><?php } ?>
</div>
</form>

<script type="text/javascript">//<![CDATA[
var GRBOARD = '<?php echo $grboard; ?>/';
//]]></script>
<script type="text/javascript" src="<?php echo $grboard; ?>/js/highslide-full.packed.js"></script>
<script type="text/javascript" src="<?php echo $grboard.'/'.$theme; ?>/list.js"></script>
<script type="text/javascript" src="<?php echo $grboard; ?>/js/member_info.js"></script>
<script type="text/javascript" src="<?php echo $grboard; ?>/js/search_helper.js"></script>

</div><!--# 게시판 끝 -->