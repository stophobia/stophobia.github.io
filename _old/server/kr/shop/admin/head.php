<?php
if(!defined('__GRSHOP__')) exit();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="GR Shop" />
<meta name="Author" content="박희근 Hee Geun Park" />
<meta name="copyright" content="Copyright ⓒ 2007 Hee Geun Park" />
<title>GR Shop <?php echo $shop->version; ?> 관리자 페이지 - <?php $admin['title']; ?></title>
<link rel="stylesheet" href="style.css" type="text/css" title="style" />
<link rel="stylesheet" href="<?php echo $grcore; ?>/jquery_ui/ui.all.css" type="text/css" title="style" />
<script type="text/javascript" src="<?php echo $grcore; ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $grcore; ?>/js/jquery.ui.core.js"></script>
<script type="text/javascript" src="<?php echo $grcore; ?>/js/jquery.ui.draggable.js"></script>
<script type="text/javascript" src="<?php echo $grcore; ?>/js/jquery.ui.resizable.js"></script>
<script type="text/javascript" src="<?php echo $grcore; ?>/js/jquery.ui.dialog.js"></script>
<script type="text/javascript" src="admin.js"></script>
</head>
<body>

<div id="main">

	<div id="logo"><a href="./?menu=0"><img src="../img/admin/grshop.logo.gif" alt="GR Shop" /></a></div>

	<div id="topMenu"><a href="./?menu=1" title="상품분류 3단계중 첫단계, 大분류를 지정합니다. (예: 디지털카메라)"><img src="../img/admin/top_01.gif" alt="상품분류" class="topMenu" 
	/></a><a href="./?menu=2" title="中분류를 지정(=게시판 등록)합니다. (예: GR보드 게시판 아이디가 canon 인 게시판을 [캐논] 이라는 이름으로 등록)"><img src="../img/admin/top_02.gif" alt="게시판등록" class="topMenu" 
	/></a><a href="./?menu=3" title="고객님들이 주문한 목록을 확인하고, 입금확인 처리 등을 합니다."><img src="../img/admin/top_03.gif" alt="주문관리" class="topMenu" 
	/></a><a href="./?menu=4" title="GR Shop 레이아웃 스킨은 무엇을 쓸지, 대표이사 이름은 어떻게 할지 등을 정합니다."><img src="../img/admin/top_04.gif" alt="매장관리" class="topMenu" 
	/></a><a href="./?menu=5" title="쇼핑몰의 필수! 각종 이미지 배너들을 쉽게 올리고 관리합니다."><img src="../img/admin/top_05.gif" alt="배너관리" class="topMenu" 
	/></a><a href="<?php echo $grboard; ?>/admin.php" onclick="window.open(this.href, '_blank'); return false" title="GR보드 관리화면으로 갑니다. 이 곳에서 게시판과 회원 관리를 하실 수 있습니다."><img src="../img/admin/top_06.gif" alt="GR보드관리" class="topMenu" 
	/></a></div>