<?php
include 'core.grforum.php';
include $grforum . '/grboard.head.php';
include 'core.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="GR Forum" />
<meta name="Nationality" content="Republic of Korean" />
<title><?php echo $setting['forum_title']; ?></title>
<link rel="stylesheet" href="<?php echo $skin; ?>/skin.css" type="text/css" title="style" />
<?php if($articleNo) { /* 글 보기시 code highlight 준비 */ ?>
<script type="text/javascript" src="<?php echo $grcore; ?>/syntaxhighlighter/scripts/shCore.js"></script>
<script type="text/javascript" src="<?php echo $grcore; ?>/syntaxhighlighter/scripts/shBrushBash.js"></script>
<script type="text/javascript" src="<?php echo $grcore; ?>/syntaxhighlighter/scripts/shBrushCpp.js"></script>
<script type="text/javascript" src="<?php echo $grcore; ?>/syntaxhighlighter/scripts/shBrushCSharp.js"></script>
<script type="text/javascript" src="<?php echo $grcore; ?>/syntaxhighlighter/scripts/shBrushCss.js"></script>
<script type="text/javascript" src="<?php echo $grcore; ?>/syntaxhighlighter/scripts/shBrushDelphi.js"></script>
<script type="text/javascript" src="<?php echo $grcore; ?>/syntaxhighlighter/scripts/shBrushDiff.js"></script>
<script type="text/javascript" src="<?php echo $grcore; ?>/syntaxhighlighter/scripts/shBrushGroovy.js"></script>
<script type="text/javascript" src="<?php echo $grcore; ?>/syntaxhighlighter/scripts/shBrushJava.js"></script>
<script type="text/javascript" src="<?php echo $grcore; ?>/syntaxhighlighter/scripts/shBrushJScript.js"></script>
<script type="text/javascript" src="<?php echo $grcore; ?>/syntaxhighlighter/scripts/shBrushPhp.js"></script>
<script type="text/javascript" src="<?php echo $grcore; ?>/syntaxhighlighter/scripts/shBrushPlain.js"></script>
<script type="text/javascript" src="<?php echo $grcore; ?>/syntaxhighlighter/scripts/shBrushPython.js"></script>
<script type="text/javascript" src="<?php echo $grcore; ?>/syntaxhighlighter/scripts/shBrushRuby.js"></script>
<script type="text/javascript" src="<?php echo $grcore; ?>/syntaxhighlighter/scripts/shBrushScala.js"></script>
<script type="text/javascript" src="<?php echo $grcore; ?>/syntaxhighlighter/scripts/shBrushSql.js"></script>
<script type="text/javascript" src="<?php echo $grcore; ?>/syntaxhighlighter/scripts/shBrushVb.js"></script>
<script type="text/javascript" src="<?php echo $grcore; ?>/syntaxhighlighter/scripts/shBrushXml.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo $grcore; ?>/syntaxhighlighter/styles/shCore.css"/>
<link type="text/css" rel="stylesheet" href="<?php echo $grcore; ?>/syntaxhighlighter/styles/shThemeDefault.css"/>
<script type="text/javascript">//<![CDATA[
	SyntaxHighlighter.config.clipboardSwf = '<?php echo $grcore; ?>/syntaxhighlighter/scripts/clipboard.swf';
	SyntaxHighlighter.all();
//]]></script>
<?php } /* 준비 완료 */
echo $addHead; ?>
</head>
<body>

<div id="GRFORUM"><div id="layout">

	<div id="logo">
		<div class="img center"><a href="<?php echo $grforum; ?>"><img src="<?php echo $setting['logo_pos']; ?>" alt="logo image" /></a></div>
		<div class="txt right">
			<h4><?php echo $setting['forum_desc']; ?></h4>
		</div>
	</div>

	<div id="forumMain">

	<div class="navi">
		<div class="info">
			<?php echo $path; ?>
		</div>
		<div class="menu right">
		<ul>
			<?php if(!$isMember) { ?>
			<li><a href="<?php echo $grforum; ?>/login/">로그인</a></li>
			<li><a href="<?php echo $grforum; ?>/register/">회원등록</a></li>
			
			<?php } /* ← 로그인 전 */ else { /* 로그인 후 ↓ */ ?>
			<li><a href="./view_memo.php" onclick="window.open(this.href, 'viewMemo', 'width=550,height=600,menubar=no,scrollbar=yes'); return false">쪽지함</a></li>
			<li><a href="<?php echo $grforum; ?>/myinfo/">정보수정</a></li>
			<li><a href="<?php echo $grforum; ?>/logout/">로그아웃</a></li>
			<?php } /* ← 로그인 후 */
			
			// 관리자일 경우
			if($isAdmin) { ?>
			<li><a href="<?php echo $grforum; ?>/admin/">관리화면</a></li>
			<?php } ?>

			<li><a href="<?php echo $grforum; ?>/search/">통합검색</a></li>
		</ul>
		</div>
	</div>