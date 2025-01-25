<?php
	if(isset($_POST['photo_num']) && $_POST['photo_num']) {
		$addMsg = '';
		if($photo_del_cache) {
			function rmdirtree($dirname='phpThumb/cache/') {
				if (is_dir($dirname)) {
					$result = array();
					if (substr($dirname, -1) != '/') $dirname .= '/';
					$handle = opendir($dirname);
					while (false !== ($file = @readdir($handle))) {
						if ($file == 'source' || $file == 'index.php') continue;
						if ($file != '.' && $file != '..') {
							$path = $dirname.$file;
							if (is_dir($path)) {
								$result = array_merge($result, rmdirtree($path));
							} else {
								@unlink($path);
							}
						}
					}
					@closedir($handle);
					@rmdir($dirname);
				}
			}
			rmdirtree();
			$addMsg = '하고, 캐쉬로 저장된 썸네일을 삭제';
		}
		$config = '<?php'."\n";
		$config .= '$photo[\'num\'] = '.$photo_num.';'."\n";
		$config .= '$photo[\'width\'] = '.$photo_width.';'."\n";
		$config .= '$photo[\'height\'] = '.$photo_height.';'."\n";
		$config .= '$photo[\'original_max_width\'] = '.$photo_max_width.';'."\n";
		$config .= '$photo[\'photoTitle\'] = \''.addslashes($photo_title).'\';'."\n";
		$config .= '$photo[\'quality\'] = '.$photo_quality.';'."\n";
		$config .= '$photo[\'use_comment\'] = '.$use_comment.';'."\n";
		$config .= '$photo[\'main_num\'] = '.$main_num.';'."\n";
		$config .= '$photo[\'main_width\'] = '.$main_width.';'."\n";
		$config .= '$photo[\'main_height\'] = '.$main_height.';'."\n";
		$config .= '$photo[\'photo_list_width\'] = '.$photo_list_width.';'."\n";
		$config .= '$photo[\'photo_list_height\'] = '.$photo_list_height.';'."\n";
		$config .= '$photo[\'photo_list_num\'] = '.$photo_list_num.';'."\n";
		$config .= '?>';
		$fp = @fopen('photo_config.php', 'w');
		@fwrite($fp, $config);
		@fclose($fp);
		error('사진첩 설정을 수정'.$addMsg.'했습니다.', 'location.href=\'admin.php?admin=9\';');
	}
?>