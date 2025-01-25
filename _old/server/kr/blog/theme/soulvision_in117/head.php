<?php 
$nowPos = str_replace(array($grblog, '.php'), '', $_SERVER['SCRIPT_NAME']); // 현재 위치지정
$haveTagSkin = true; // 태그 스킨 가지는 경우 스킨에서 출력 (스킨/tag.php)
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="GR BLog" />
<meta name="Author" content="박희근 Hee Geun Park" />
<meta name="Nationality" content="Republic of Korean" />
<meta name="copyright" content="Copyright ⓒ 2009 Hee Geun Park" />
<title><?php echo $browserTitle; ?></title>
<link rel="commentalimi" href="/index.php" />
<link rel="stylesheet" href="<?php echo $absPath.$theme; ?>/style.css" type="text/css" title="style" />
<link rel="alternate" type="application/rss+xml" title="GR Blog RSS 2.0 Feed" href="<?php echo $absPath; ?>rss" />
<link rel="stylesheet" href="<?php echo $absPath.$theme; ?>/highslide.css" type="text/css" title="style" />
<link rel="stylesheet" href="<?php echo $absPath.$theme; ?>/guestbook.css" type="text/css" title="style" />
<script src="<?php echo $absPath; ?>js/prototype.js" type="text/javascript"></script>
<script src="<?php echo $absPath; ?>js/highslide-full.packed.js" type="text/javascript"></script>
<script type="text/javascript">//<![CDATA[
if(navigator.userAgent.indexOf('iPhone') > 0) { // iPhone 용 페이지로 이동할 것인지 묻기
	if(confirm('아이폰 전용 페이지로 이동하시겠습니까?')) {
		location.href='./m';
	}
}
var GRBLOG = '<?php echo $grblog; ?>';
var THEME_PATH = '<?php echo $absPath.$theme; ?>/';
var NOW_PATH = '<?php echo ($nowPos == 'guestbook/index')?'../':''; ?>';
<?php if($conf_twitter_id) { ?>
var TWITTER_ID = '<?php echo $conf_twitter_id; ?>';
var TWITTER_RSS = '<?php echo $conf_twitter_rss; ?>';
var TWITTER_COUNT = '<?php echo $conf_twitter_count; ?>';
<?php } ?>
//]]></script>
<script type="text/javascript" src="<?php echo $absPath.$theme; ?>/theme.js"></script>
<?php if($p) { /* 글 보기시 code highlight 준비 */ ?>
<script type="text/javascript" src="syntaxhighlighter/scripts/shCore.js"></script>
<script type="text/javascript" src="syntaxhighlighter/scripts/shBrushBash.js"></script>
<script type="text/javascript" src="syntaxhighlighter/scripts/shBrushCpp.js"></script>
<script type="text/javascript" src="syntaxhighlighter/scripts/shBrushCSharp.js"></script>
<script type="text/javascript" src="syntaxhighlighter/scripts/shBrushCss.js"></script>
<script type="text/javascript" src="syntaxhighlighter/scripts/shBrushDelphi.js"></script>
<script type="text/javascript" src="syntaxhighlighter/scripts/shBrushDiff.js"></script>
<script type="text/javascript" src="syntaxhighlighter/scripts/shBrushGroovy.js"></script>
<script type="text/javascript" src="syntaxhighlighter/scripts/shBrushJava.js"></script>
<script type="text/javascript" src="syntaxhighlighter/scripts/shBrushJScript.js"></script>
<script type="text/javascript" src="syntaxhighlighter/scripts/shBrushPhp.js"></script>
<script type="text/javascript" src="syntaxhighlighter/scripts/shBrushPlain.js"></script>
<script type="text/javascript" src="syntaxhighlighter/scripts/shBrushPython.js"></script>
<script type="text/javascript" src="syntaxhighlighter/scripts/shBrushRuby.js"></script>
<script type="text/javascript" src="syntaxhighlighter/scripts/shBrushScala.js"></script>
<script type="text/javascript" src="syntaxhighlighter/scripts/shBrushSql.js"></script>
<script type="text/javascript" src="syntaxhighlighter/scripts/shBrushVb.js"></script>
<script type="text/javascript" src="syntaxhighlighter/scripts/shBrushXml.js"></script>
<link type="text/css" rel="stylesheet" href="syntaxhighlighter/styles/shCore.css"/>
<link type="text/css" rel="stylesheet" href="syntaxhighlighter/styles/shThemeDefault.css"/>
<script type="text/javascript">//<![CDATA[
	SyntaxHighlighter.config.clipboardSwf = 'syntaxhighlighter/scripts/clipboard.swf';
	SyntaxHighlighter.all();
//]]></script>
<?php } /* 준비 완료 */ $firstrun = true; ?>
</head>
<body>

<div id="headerwrap">
  <div id="headerbg">
    <div id="header">
      <h1><a href="<?php echo $grblog; ?>"><?php echo $blogTitle; ?></a></h1>
      <p class="tagline"><?php echo $blogInfo; ?></p>
      <div class="Menu">
        
        <div class="Menuright">
          <ul>
            <ul>
              <li><a href="<?php echo $grblog; ?>">Home</a></li>
              <li><a href="<?php echo $grblog; ?>photo/"><span>Photolog</span></a></li>
				<?php 
				// 관리자로 로그인 시
				if($_SESSION['no']) { ?>
				<li><a href="<?php echo $grblog; ?>admin.php?admin=20&inView=adminBox"><span>Admin</span></a></li>
				<?php 
				// 로그인 하지 않았을 때
				} else { ?>
				<li><a href="<?php echo $grblog; ?>login.php"><span>Login</span></a></li>
				<?php } // 모두 보기 ?>
				<li><a class="<?php echo ($nowPos == 'article_list')?'on':''; ?>" href="<?php echo $grblog; ?>article_list.php"><span>List</span></a></li>
				<li><a class="<?php echo ($nowPos == 'tag')?'on':''; ?>" href="<?php echo $grblog; ?>tag.php"><span>Tag clouds</span></a></li>
				<li><a class="<?php echo ($nowPos == 'guestbook/index')?'on':''; ?>" href="<?php echo $grblog; ?>guestbook/"><span>Guestbook</span></a></li>

            </ul>
          </ul>
        </div>
      </div>
      <div id="rssfeeds">
        <p><a href="<?php echo $absPath; ?>rss">Subscribe to feed</a></p>
      </div>
      <div class="search">
        <form id="searchform" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<select name="so">
		<option value="subject" <?php echo (($so == 'subject')?'selected="selected"':'');?>>제목</option>
		<option value="content" <?php echo (($st == 'content')?'selected="selected"':'');?>>내용</option>
		<option value="tag" <?php echo (($st == 'tag')?'selected="selected"':'');?>>태그</option>
		<option value="writer" <?php echo (($st == 'writer')?'selected="selected"':'');?>>ID</option>
		</select>
          <input type="text" value="enter keyword" name="st" id="st" onFocus="if (this.value == 'enter keyword') {this.value = '';}" onBlur="if (this.value == '') {this.value = 'enter keyword';}"/>
        </form>
      </div>
    </div>
  </div>
</div>
<div id="wrap">