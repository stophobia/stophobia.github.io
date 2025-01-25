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
<link rel="stylesheet" href="<?php echo $absPath.$theme; ?>/style-black.css" type="text/css" title="style" />
<link rel="stylesheet" href="<?php echo $absPath.$theme; ?>/style.css" type="text/css" title="style" />
<link rel="alternate" type="application/rss+xml" title="GR Blog RSS 2.0 Feed" href="<?php echo $absPath; ?>rss" />
<script src="<?php echo $absPath; ?>js/prototype.js" type="text/javascript"></script>
<script src="<?php echo $absPath; ?>js/effects.js" type="text/javascript"></script>
<script src="<?php echo $absPath; ?>js/dragdrop.js" type="text/javascript"></script>
<script src="<?php echo $absPath; ?>js/highslide-full.packed.js" type="text/javascript"></script>
<script type="text/javascript">//<![CDATA[
var GRBLOG = '<?php echo $grblog; ?>';
var THEME_PATH = '<?php echo $absPath.$theme; ?>/';
<?php if($conf_twitter_id) { ?>
var TWITTER_RSS = '<?php echo $conf_twitter_rss; ?>';
var TWITTER_COUNT = '<?php echo $conf_twitter_count; ?>';
<?php } ?>
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
<?php } 
// 현재 위치지정
$nowPos = str_replace(array($grblog, '.php'), '', $_SERVER['SCRIPT_NAME']);
?>

</head>

<body>
<div id="header">
 	<div id="header-in">
    <p class="title"><a href="<?php echo $grblog; ?>" title="처음 화면으로"><?php echo $blogTitle; ?></a></p>
    <p class="description"><?php echo $blogInfo; ?></p>

	<div id="nav">
	<ul>
		<li<?php echo ($nowPos == 'index')?' class="current_page_item"':''; ?>><a href="<?php echo $grblog; ?>" title="처음 화면으로">Home</a></li>
		<li><a href="<?php echo $grblog; ?>photo/" title="포토로그를 엽니다. (단축키: p)" accesskey="p">Photolog</a></li>
		<li><a href="<?php echo $grblog; ?>mono/" title="모노로그를 엽니다. (단축키: m)" accesskey="m">Monolog</a></li>
		<?php 
		// 관리자로 로그인 시
		if($_SESSION['no']) { ?><li><a href="<?php echo $grblog; ?>admin.php?admin=20&inView=adminBox" title="관리자 화면으로 갑니다 (단축키: a)" accesskey="a">Admin</a></li><?php 
		// 로그인 하지 않았을 때
		} else { ?><li><a href="<?php echo $grblog; ?>login.php" title="관리자로 로그인 하러 갑니다 (단축키: i)" accesskey="i">Login</a></li><?php }
		// 모두 보기
		?>
		<li<?php echo ($nowPos == 'article_list')?' class="current_page_item"':''; ?>><a href="<?php echo $grblog; ?>article_list.php" title="포스트 목록들을 봅니다. (단축키: t)" accesskey="t">List</a></li>
		<li<?php echo ($nowPos == 'tag')?' class="current_page_item"':''; ?>><a href="<?php echo $grblog; ?>tag.php" title="태그 구름을 봅니다. (단축키: c)" accesskey="c">Tag clouds</a></li>
		<li<?php echo ($nowPos == 'guestbook/index')?' class="current_page_item"':''; ?>><a href="<?php echo $grblog; ?>guestbook/" title="방명록을 펼쳐 봅니다. (단축키: g)" accesskey="g">Guestbook</a></li>
	</ul>
	</div>
	
	<div class="subscribe">
	 	<span class="rss"><a href="<?php echo $absPath; ?>rss" title="RSS 로 블로그의 글을 구독하실 수 있습니다~!"><img src="<?php echo $grblog.$theme; ?>/img/rss.gif" alt="RSS" /></a></span> 
		 
		<div class="subscribeform">
		<form id="searchBlog" method="post" action="<?php echo $grblog; ?>">
		  <p>Search! 
			<select name="so">
				<option value="subject" <?php echo (($so == 'subject')?'selected="selected"':'');?>>제목</option>
				<option value="content" <?php echo (($st == 'content')?'selected="selected"':'');?>>내용</option>
				<option value="tag" <?php echo (($st == 'tag')?'selected="selected"':'');?>>태그</option>
				<option value="writer" <?php echo (($st == 'writer')?'selected="selected"':'');?>>ID</option>
			</select>
		</p>
		<div><input type="text" value="<?php echo $st; ?>" name="st" class="input" /><input type="submit" value="Search" class="sbutton" /></div>
		</form>
 		</div>

	</div>
 
	</div>

</div>

<div class="container-top"></div>
<div id="container">

<!-- 최근 포스팅들 -->
<div id="content">