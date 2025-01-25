<?php
	if(isset($_GET['deleteBlog']) && $_GET['deleteBlog'] == 'yes')
	{
		@mysql_query('drop table '.$dbFIX.'category');
		@mysql_query('drop table '.$dbFIX.'comment');
		@mysql_query('drop table '.$dbFIX.'config');
		@mysql_query('drop table '.$dbFIX.'link');
		@mysql_query('drop table '.$dbFIX.'post');
		@mysql_query('drop table '.$dbFIX.'tag');
		@mysql_query('drop table '.$dbFIX.'trackback');
		@mysql_query('drop table '.$dbFIX.'photo');
		@mysql_query('drop table '.$dbFIX.'photo_comment');
		@mysql_query('drop table '.$dbFIX.'photo_category');
		@mysql_query('drop table '.$dbFIX.'user');
		@mysql_query('drop table '.$dbFIX.'rss');
		@mysql_query('drop table '.$dbFIX.'memo_comment');
		@mysql_query('drop table '.$dbFIX.'memo_config');
		@mysql_query('drop table '.$dbFIX.'memo_post');
		@mysql_query('drop table '.$dbFIX.'image');
		@mysql_query('drop table '.$dbFIX.'reply_catch');
		@chmod('db_info.php', 0707);
		@unlink('db_info.php');
		$_SESSION = array();
		@session_destroy();
		$openSessionDir = @opendir('session');
		while($osd = @readdir($openSessionDir))
		{
			if($osd == '.' or $osd == '..') continue;
			@unlink('session/'.$osd);
		}
		$openPhotoDir = @opendir('data/photo');
		while($opd = @readdir($openPhotoDir))
		{
			if($opd == '.' or $opd == '..') continue;
			@unlink('data/photo/'.$opd);
		}
		$openAttachDir = @opendir('data');
		while($oad = @readdir($openAttachDir))
		{
			if($oad == '.' or $oad == '..') continue;
			@unlink('data/'.$oad);
		}
		$openCacheDir = @opendir('cache');
		while($ocd = @readdir($openCacheDir))
		{
			if($ocd == '.' or $ocd == '..') continue;
			@unlink('cache/'.$oad);
		}
		@unlink('data/photo');
		@unlink('data');
		@unlink('session');
		@chmod('.htaccess', 0707);
		@unlink('.htaccess');
		error('모든 자료를 삭제하고 블로그를 초기화 했습니다.', 'location.href=\'./\';');
	}
?>