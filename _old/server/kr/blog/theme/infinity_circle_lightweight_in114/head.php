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
var THEME_PATH = '<?php echo $absPath.$theme; ?>/';
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
	<div id="footer-back"><div id="footer-bg">
		<div id="main">
			<div id="main-top">
				<div id="navigationed">
					<ul id="navigation" class="clearfix">
						<li><a href="<?php echo $grblog; ?>">Home</a></li>
						<li><a href="<?php echo $grblog; ?>photo/" title="포토로그를 엽니다. (단축키: p)" accesskey="p">Photolog</a></li>
						<li><a href="<?php echo $grblog; ?>mono/" title="모노로그를 엽니다. (단축키: m)" accesskey="m">Monolog</a></li>
						<?php 
						// 관리자로 로그인 시
						if($_SESSION['no']) { ?><li><a href="<?php echo $grblog; ?>admin.php?admin=20&inView=adminBox" title="관리자 화면으로 갑니다 (단축키: a)" accesskey="a">Admin</a></li><?php 
						// 로그인 하지 않았을 때
						} else { ?><li><a href="<?php echo $grblog; ?>login.php" title="관리자로 로그인 하러 갑니다 (단축키: i)" accesskey="i">Login</a></li><?php }
						// 모두 보기
						?>
						<li><a href="<?php echo $grblog; ?>article_list.php" title="포스트 목록들을 봅니다. (단축키: t)" accesskey="t">List</a></li>
						<li><a href="<?php echo $grblog; ?>tag.php" title="태그 구름을 봅니다. (단축키: c)" accesskey="c">Tag clouds</a></li>
						<li><a href="<?php echo $grblog; ?>guestbook/" title="방명록을 펼쳐 봅니다. (단축키: g)" accesskey="g">Guestbook</a></li>
					</ul>
				</div>
				<div id="container">
					<div id="content-back" class="clearfix"><div id="content-bottom">
						<div id="left-col">
							<div class="clearfix">

							<?php if(!$p) { ?>
								<div id="featured">
									<div class="featured-content">
											<!-- 최신 포스트 -->
											<?php
											$nPost = @mysql_fetch_array(mysql_query('select uid, signdate, subject, content, comment_count, trackback_count, tag from '.$dbFIX.'post where post_condition = 1 order by uid desc limit 1'));
											?>
											<h3><a href="<?php echo $grblog; ?>?p=<?php echo $nPost['uid']; ?>" rel="bookmark"><?php echo stripslashes($nPost['subject']); ?></a></h3>
											<?php echo cutString(strip_tags($nPost['content']), $conf_preview_count); ?>
											<div class="post-meta">
												<a href="./?p=<?php echo $nPost['uid']; ?>" rel="bookmark" class="btn">Read More</a> <span>trackbacks <?php echo $nPost['trackback_count']; ?> : comments <?php echo $nPost['comment_count']; ?></span>
											</div>
									</div>
								</div>
							</div>

							<div class="left-content">
							<?php } ?>

<!-- 최근 포스팅들 -->
<div id="content">