<form id="writeMemo" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div><input type="hidden" name="writeMemo" value="1" /></div>
<div id="writeBox">
	<textarea name="content" rows="2" cols="50"></textarea><input type="submit" value="메모 남기기" accesskey="s" title="한줄 메모를 남깁니다!" />
</div>
</form>