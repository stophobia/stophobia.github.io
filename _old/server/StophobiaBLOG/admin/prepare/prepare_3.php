<?php
	if(isset($modifyTarget))
		$modify = @mysql_fetch_array(mysql_query('select * from '.$dbFIX.'link where uid = '.$modifyTarget));
	if(isset($deleteTarget))
	{
		@mysql_query('delete from '.$dbFIX.'link where uid = '.$deleteTarget);
		move('admin.php?admin=3');
	}
	if(array_key_exists('addLink', $_POST) && $_POST['addLink'])
		addLink();
	if(array_key_exists('change', $_GET) && $_GET['change'])
		resort($_GET['change']);
?>