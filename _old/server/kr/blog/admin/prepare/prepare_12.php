<?php
if($_POST['submitOK']) {
	@extract($_POST);
	$config = '<?php'."\n";
	$config .= '$conf_photo = '.(($conf_photo)?1:0).';'."\n";
	$config .= '$conf_calendar = '.(($conf_calendar)?1:0).';'."\n";
	$config .= '$conf_article = '.(($conf_article)?1:0).';'."\n";
	$config .= '$conf_notice = '.(($conf_notice)?1:0).';'."\n";
	$config .= '$conf_category = '.(($conf_category)?1:0).';'."\n";
	$config .= '$conf_photolog = '.(($conf_photolog)?1:0).';'."\n";
	$config .= '$conf_comment = '.(($conf_comment)?1:0).';'."\n";
	$config .= '$conf_trackback = '.(($conf_trackback)?1:0).';'."\n";
	$config .= '$conf_tag = '.(($conf_tag)?1:0).';'."\n";
	$config .= '$conf_link = '.(($conf_link)?1:0).';'."\n";
	$config .= '$conf_search = '.(($conf_search)?1:0).';'."\n";
	$config .= '$conf_monolog = '.(($conf_monolog)?1:0).';'."\n";
	$config .= '$conf_nowConnect = '.(($conf_nowConnect)?1:0).';'."\n";
	$config .= '$conf_antiSpam = '.(($conf_antiSpam)?1:0).';'."\n";
	$config .= '$conf_koreanOnly = '.(($conf_koreanOnly)?1:0).';'."\n";
	$config .= '$conf_guestbook = '.(($conf_guestbook)?1:0).';'."\n";
	$config .= '$conf_autosave_term = '.(($conf_autosave_term)?$conf_autosave_term:60).';'."\n";
	$config .= '$conf_preview = '.(($conf_preview)?1:0).';'."\n";
	if($conf_preview) $config .= '$conf_preview_count = '.$conf_preview_count.';'."\n";
	if($conf_preview) $config .= '$conf_preview_thumbnail = '.$conf_preview_thumbnail.';'."\n";
	$config .= '$conf_grcounter = '.(($conf_grcounter)?1:0).';'."\n";
	if($conf_grcounter) $config .= '$conf_grcounter_path = \''.$conf_grcounter_path.'\';'."\n";
	if($conf_grcounter) $config .= '$conf_grcounter_id = \''.$conf_grcounter_id.'\';'."\n";
	if($conf_twitter_id) $config .= '$conf_twitter_id = \''.$conf_twitter_id.'\';'."\n";
	if($conf_twitter_id) $config .= '$conf_twitter_rss = \''.$conf_twitter_rss.'\';'."\n";
	if($conf_twitter_id) $config .= '$conf_twitter_count = \''.(($conf_twitter_count)?$conf_twitter_count:10).'\';'."\n";
	$config .= '?>';
	$fp = @fopen('theme_config.php', 'w');
	@fwrite($fp, $config);
	@fclose($fp);
	error('테마/세부 설정을 수정했습니다.', 'location.href=\'admin.php?admin=12\';');
}
?>