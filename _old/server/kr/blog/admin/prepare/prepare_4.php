<?php
	if(isset($deleteTarget))
	{
		$tags = @mysql_fetch_array(mysql_query('select tag from '.$dbFIX.'post where uid = '.$deleteTarget));
		$arrTag = explode(',', $tags[0]);
		$arrSize = count($arrTag);
		for($i=0; $i<$arrSize; $i++)
		{
			$isTE = @mysql_fetch_array(mysql_query("select * from ".$dbFIX."tag where tag = '".$arrTag[$i]."'"));
			if($isTE[0])
			{
				if($isTE['count']) @mysql_query("update ".$dbFIX."tag set count = count - 1 where uid = '$isTE[0]'");
				else @mysql_query("delete from ".$dbFIX."tag where uid = '$isTE[0]'");
			}
		}
		@mysql_query("delete from ".$dbFIX."post where uid = '$deleteTarget'");
		@mysql_query("delete from ".$dbFIX."comment where post_uid = '$deleteTarget'");
		@mysql_query("delete from ".$dbFIX."trackback where post_uid = '$deleteTarget'");
		move('admin.php?admin=4');
	}
	if(isset($deleteTargets))
	{
		$targetNum = count($deleteTargets);
		for($i=0; $i<$targetNum; $i++)
		{
			@mysql_query("delete from ".$dbFIX."post where uid = '".$deleteTargets[$i]."'");
		}
		move('admin.php?admin=4');
	}
?>