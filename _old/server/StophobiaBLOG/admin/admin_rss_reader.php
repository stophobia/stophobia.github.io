<?php if(!defined('__GRBLOG__')) exit(); ?>

<!-- 링크 설정 -->
<div id="all">
	<div class="normalTitle">RSS 보기</div>

	<div id="addNewRSS">
		<form id="link" method="post" onsubmit="return rss_add();" action="<?php echo $_SERVER['PHP_SELF']; ?>?admin=17">
		<div><input type="hidden" name="mt" value="<?php echo $modifyTarget; ?>" />
		<input type="hidden" name="addLink" value="1" /></div>
		<div class="option">RSS주소(URL):</div>
		<div class="value"><input type="text" name="url" class="i" value="<?php echo $modify['url']; ?>" /></div>
		<div class="option">블로그 이름:</div>
		<div class="value"><input type="text" name="name" class="i" value="<?php echo stripslashes($modify['name']); ?>" /></div>
		<div class="btn"><input type="submit" class="s" value="추가(수정) 하기" /> <input type="button" class="s" value="삭제하기" onclick="rss_delete();" /></div>
		</form>
	</div>

	<div id="selectRSS">
		<ol>
			<?php
			$getRSS = @mysql_query('select * from '.$dbFIX.'rss');
			while($rss = @mysql_fetch_array($getRSS)) { ?>
			<li onclick="getRSS('<?php echo $rss['url']; ?>', <?php echo $rss['uid']; ?>, '<?php echo $rss['name']; ?>');"><?php echo $rss['name']; ?></li>
			<?php } ?>
		</ol>
	</div>

	<div class="clr"></div>

	<div id="rssList"></div>

	<div id="loadBox" style="display: none"></div>
</div>
<!--# 링크 설정 -->