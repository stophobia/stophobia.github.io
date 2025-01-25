<?php
	if($addLink) {
		if(!eregi('http:\/\/', $url)) $url = 'http://'.$url;
		$name = addslashes($name);
		if($mt) @mysql_query('update '.$dbFIX."rss set url = '$url', name = '$name' where uid = $mt");
		else @mysql_query('insert into '.$dbFIX."rss set uid = '', url = '$url', name = '$name'");
		error('RSS 주소를 작성하였습니다.', 'location.href=\'admin.php?admin=17\';');
	}
	if($modifyTarget) {
		$modify = @mysql_fetch_array(mysql_query("select * from ".$dbFIX."rss where uid = $modifyTarget"));
	}
	if($deleteTarget) {
		@mysql_query('delete from '.$dbFIX.'rss where uid = '.$deleteTarget);
		error('RSS 주소를 구독목록에서 삭제하였습니다.', 'location.href=\'admin.php?admin=17\';');
	}
?>