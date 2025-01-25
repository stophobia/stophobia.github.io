<?php
/*
	GR Paper 기본 스킨 상단
	작성자: 박희근 (http://sirini.net)
	수정일: 2008-1-12
	내  용: 기본 Paper 디자인 상단 부분
	주  의: 이 파일은 Paper 첫화면부터 로그인 화면까지 상단 부분에 고정 출연임.
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="<?php echo $config['version']; ?>" />
<meta name="Author" content="<?php echo $config['author']; ?>" />
<meta name="Nationality" content="Republic of Korean" />
<title><?php echo $browserTitle; ?></title>
<link rel="stylesheet" href="<?php echo $themePath; ?>/style.css" type="text/css" title="style" />
<link rel="stylesheet" href="<?php echo $themePath; ?>/highslide.css" type="text/css" title="style" />
<script type="text/javascript" src="<?php echo $config['absPath']; ?>/js/prototype.js"></script>
<script type="text/javascript" src="<?php echo $config['absPath']; ?>/js/effects.js"></script>
<script type="text/javascript" src="<?php echo $config['absPath']; ?>/js/dragdrop.js"></script>
<script type="text/javascript" src="<?php echo $config['absPath']; ?>/js/login.js"></script>
<script type="text/javascript" src="<?php echo $config['absPath']; ?>/js/highslide-full.packed.js"></script>
<script type="text/javascript" src="<?php echo $themePath; ?>/skin.js"></script>
</head>
<body>
<div id="layout">

	<div id="viewTitle"><a href="<?php echo $config['absPath']; ?>"><?php echo $browserTitle; ?></a></div>
	<div id="viewTitleBack"><?php echo $browserTitle; ?></div>
	
	<ul id="topMenu">
		<li><a href="<?php echo $config['absPath']; ?>" title="처음 화면으로 돌아갑니다.">처음으로</a></li>
		<li><a href="<?php echo $config['absPath']; ?>/list/" title="등록된 블로그 목록을 봅니다.">구독목록</a></li>
		<li><a href="<?php echo $config['absPath']; ?>/tag/" title="자주 사용되는 상위 2,000 개의 태그를 봅니다.">태그구름</a></li>
		<li><a href="<?php echo $config['absPath']; ?>/thumbnail/" title="추출된 썸네일 이미지로 글들을 봅니다.">그림보기</a></li>
		<?php if(!$c->isLogin()) { ?><li><a href="<?php echo $config['absPath']; ?>/login/" title="로그인 합니다.">로그인</a></li>
		<?php } else { ?><li><a href="<?php echo $config['absPath']; ?>/login/logout.ok.php" title="로그아웃 합니다.">로그아웃</a></li><?php } ?>
		<?php if($isEnableAdd) { ?><li><a href="<?php echo $config['absPath']; ?>/add/" onclick="window.open(this.href, '_blank', 'width=550,height=250,menubar=no,resizable=no'); return false" title="다른 사람과 함께 공유하고픈 RSS 주소를 알고 계시면, 이곳에서 등록해 주세요!">피드추가</a></li><?php } ?>
		<?php if($c->isAdmin()) { ?><li><a href="<?php echo $config['absPath']; ?>/admin/" title="관리자 페이지로 이동합니다.">관리자</a></li><?php } ?>
	</ul>
	<div class="clear"></div>
	
	<div id="layoutBody">
	
