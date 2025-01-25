<?php
	if(isset($deleteTarget))
	{
		@mysql_query("delete from ".$dbFIX."comment where uid = '$deleteTarget'");
		@mysql_query("update ".$dbFIX."post set comment_count = comment_count - 1 where uid = '$post_uid'");
		move('admin.php?admin=5');
	}
	if(isset($deleteTargets))
	{
		$targetNum = count($deleteTargets);
		for($i=0; $i<$targetNum; $i++)
		{
			@mysql_query("delete from ".$dbFIX."comment where uid = '".$deleteTargets[$i]."'");
			@mysql_query("update ".$dbFIX."post set comment_count = comment_count - 1 where uid = '".$postUids[$i]."'");
		}
		move('admin.php?admin=5');
	}
?>