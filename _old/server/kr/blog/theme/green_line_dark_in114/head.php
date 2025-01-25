<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="GR BLog" />
<meta name="Author" content="박희근 Hee Geun Park" />
<meta name="Nationality" content="Republic of Korean" />
<meta name="copyright" content="Copyright ⓒ 2007 Hee Geun Park" />
<title><?php echo $browserTitle; ?></title>
<link rel="commentalimi" href="/index.php" />
<link rel="stylesheet" href="<?php echo $absPath.$theme; ?>/style.css" type="text/css" title="style" />
<link rel="alternate" type="application/rss+xml" title="GR Blog RSS 2.0 Feed" href="<?php echo $absPath; ?>rss" />
<script src="<?php echo $absPath; ?>js/prototype.js" type="text/javascript"></script>
<script src="<?php echo $absPath; ?>js/effects.js" type="text/javascript"></script>
<script src="<?php echo $absPath; ?>js/dragdrop.js" type="text/javascript"></script>
<script src="<?php echo $absPath; ?>js/highslide-full.packed.js" type="text/javascript"></script>
<script type="text/javascript">//<![CDATA[
var GRBLOG = '<?php echo $grblog; ?>';
//]]></script>

<?php 
// 글쓰기 모드일 때
if($wMode) { ?>
	<script type="text/javascript" src="<?php echo $absPath; ?>tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript">//<![CDATA[
	var WRITE = 'write_';
	//]]></script>
	<script type="text/javascript" src="<?php echo $absPath; ?>js/write.js"></script>
	<style type="text/css">/*<![CDATA[*/
	@import url(<?php echo $grblog.$theme; ?>/write.css);
	/*]]>*/</style>

<?php 
// 글쓰기가 아닐 때
} else { ?>
	<link rel="stylesheet" href="<?php echo $absPath.$theme; ?>/highslide.css" type="text/css" title="style" />
	<link rel="stylesheet" href="<?php echo $absPath.$theme; ?>/guestbook.css" type="text/css" title="style" />
	<script type="text/javascript" src="<?php echo $absPath.$theme; ?>/theme.js"></script>
<?php } ?>

</head>
<body>
<div id="mainFrame">
<div id="main">

<div id="topBack">
	<div id="viewTitle"><a href="<?php echo $grblog; ?>" title="블로그 첫화면으로 갑니다."><?php echo $blogTitle; ?></a></div>
	<div id="viewTitleBack"><?php echo $blogTitle; ?></div>
	<span id="viewInfo"><?php echo $blogInfo; ?></span>
	<span id="viewInfoBack"><?php echo $blogInfo; ?></span>
</div>

<!-- 최근 포스팅들 -->
<div id="content">