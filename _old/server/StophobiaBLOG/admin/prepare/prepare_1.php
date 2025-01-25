<?php
	if(array_key_exists('filterText', $_POST) && $_POST['filterText'])
	{
		$ft = str_replace(' ', '', htmlspecialchars($_POST['filterText']));
		$fpt = @fopen('filter.txt', 'w');
		@fwrite($fpt, $ft);
		@fclose($fpt);
	}
	if(array_key_exists('filterIp', $_POST) && $_POST['filterIp'])
	{
		$fi = str_replace(' ', '', $_POST['filterIp']);
		$fpi = @fopen('out_ip.txt', 'w');
		@fwrite($fpi, $fi);
		@fclose($fpi);
	}
	if(array_key_exists('delete_cache', $_POST) && $_POST['delete_cache'])
	{
		$od = @opendir('cache/');
		while($rd = @readdir($od)) {
			if($rd == '.' || $rd == '..') continue;
			@unlink('cache/'.$rd);
		}
	}
	if(array_key_exists('target', $_POST) && $_POST['target'])
		saveConfig();
?>