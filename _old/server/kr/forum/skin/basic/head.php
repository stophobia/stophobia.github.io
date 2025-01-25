<?php if(!defined('__GRFORUM__')) exit(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="GR Forum" />
<meta name="Nationality" content="Republic of Korean" />
<title><?php echo $setting['forum_title']; ?></title>
<link rel="stylesheet" href="<?php echo $skin; ?>/skin.css" type="text/css" title="style" />
<script type="text/javascript" src="<?php echo $grcore; ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $skin; ?>/skin.js"></script>
<?php echo $addHead; ?>
</head>
<body>

<div id="GRFORUM"><div id="layout">

	<div id="logo">
		<div class="img center"><a href="<?php echo ($dir) ? $dir : '.'; ?>/"><img src="<?php echo $setting['logo_pos']; ?>" alt="logo image" /></a></div>
		<div class="txt right">
			<h4><?php echo $setting['forum_desc']; ?></h4>
		</div>
	</div>

	<div id="forumMain">