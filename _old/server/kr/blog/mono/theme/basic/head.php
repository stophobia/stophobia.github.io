<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="GR BLog" />
<meta name="Author" content="박희근 Hee Geun Park" />
<meta name="Nationality" content="Republic of Korean" />
<meta name="copyright" content="Copyright © 2007 Hee Geun Park" />
<link rel="stylesheet" href="<?php echo $path; ?>/style.css" type="text/css" title="style" />
<link rel="alternate" type="application/rss+xml" title="GR Blog RSS 2.0 Feed" href="rss.php" />
<title><?php
// 브라우저 상단 제목표시줄 표기
$monologTitle = stripslashes($mono['mono_title']);
echo $monologTitle;
?></title>
<script src="<?php echo $prefix; ?>/js/prototype.js" type="text/javascript"></script>
<script src="<?php echo $prefix; ?>/js/effects.js" type="text/javascript"></script>
</head>
<body>
<div id="topBack">
	<div id="head">
 		<div id="viewTitle"><a href="./" title="모노로그 첫화면으로 갑니다."><?php echo stripslashes($monologTitle); ?></a></div>
		<div id="viewBtns">
		<ul>
			<li><a href="./">Home</a></li>
			<li><a href="../">Back to the blog</a></li>
			<li><a href="./rss/"><img src="<?php echo $path; ?>/image/rss.gif" alt="RSS 2.0" /></a></li>
		</ul>
		</div>
	</div>
</div>
<div id="mainFrame">
<div id="content">