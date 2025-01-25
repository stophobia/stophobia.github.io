<?php
	$mono = array(array());
	$getMemoConfig = @mysql_query('select * from '.$dbFIX.'memo_config');
	while($conf = @mysql_fetch_array($getMemoConfig, MYSQL_ASSOC)) {
		$mono[$conf['opt']] = $conf['value'];
	}
	if($term_day) {
		@mysql_query("update {$dbFIX}memo_config set value = '$theme' where opt = 'theme' limit 1");
		@mysql_query("update {$dbFIX}memo_config set value = '$write_level' where opt = 'write_level' limit 1");
		@mysql_query("update {$dbFIX}memo_config set value = '$reply_level' where opt = 'reply_level' limit 1");
		@mysql_query("update {$dbFIX}memo_config set value = '$term_day' where opt = 'term_day' limit 1");
		@mysql_query("update {$dbFIX}memo_config set value = '".addslashes($mono_title)."' where opt = 'mono_title' limit 1");
		@mysql_query("update {$dbFIX}memo_config set value = '$use_rss' where opt = 'use_rss' limit 1");
		@mysql_query("update {$dbFIX}memo_config set value = '$use_openid' where opt = 'use_openid' limit 1");
		error('모노로그 설정을 업데이트 했습니다.', 'location.href=\'admin.php?admin=18\';');
	}
?>