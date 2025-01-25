<?php
	if(isset($deleteTarget))
	{
		@mysql_query("delete from ".$dbFIX."reply_catch where uid = '$deleteTarget'");
		move('admin.php?admin=19');
	}
	if(isset($deleteTargets))
	{
		$targetNum = count($deleteTargets);
		for($i=0; $i<$targetNum; $i++)
		{
			@mysql_query("delete from ".$dbFIX."reply_catch where uid = '".$deleteTargets[$i]."'");
		}
		move('admin.php?admin=19');
	}
?>