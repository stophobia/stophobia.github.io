<?php
	$config = getConfig();
	if($fileName) {
		$modifyThemeFile = @fopen($fileName, 'w');
		@fwrite($modifyThemeFile, stripslashes($content));
		@fclose($modifyThemeFile);
		error('테마를 수정하였습니다.', 'location.href=\'admin.php?admin=16&mfile='.$fileName.'\';');
	}
?>