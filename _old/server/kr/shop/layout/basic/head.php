<?php
/**
 * 레이아웃 스킨 상단부분 (게시판 이외의 페이지에서 불려짐)
 * 주의: head.grboard.php 와 비슷해 보이지만 세부적으로 경로라던지 하는 게 다르므로 차이점 숙지 필요.
 * 참고: 이 파일은 레이아웃 상단 부분에 공통으로 들어가는 부분을 요약한 것임.
 *         기본적으로 GR Board 의 최근게시물이나 외부로그인 API 를 사용하지만, (grboard/include.php 호출하였음)
 *         만약 PHP & MySQL 활용에 능숙하다면 무시하고 독자적인 코드를 통해서
 *         완전히 다른 형태의 레이아웃으로 만들 수도 있음. (즉 스킨 안에서 커스터마이즈를 통해 특정 쇼핑몰 스타일에 맞게 구성 가능함)
 *         GR Shop 의 레이아웃 스킨은 기본적으로 GR Board 의 최근게시물 API 를 활용하므로,
 *         GR Board 관리화면 → 코드 생성 페이지를 보고 숙달이 필요함.
 *         (GR Board 를 이미 잘 활용했다면 GR Shop 레이아웃 제작은 정말 쉽게 가능함)
 * 제작: sirini (http://sirini.net)
 **/
if(!defined('__GRSHOP__')) exit();

// 사용할 변수 세팅 (스킨에서 불필요하면 삭제)
$design['title'] = $shop->get('shop_title');
$design['outlogin'] = $shop->get('outlogin_skin');
$design['latest_product'] = $shop->get('latest_product_skin');
$design['latest_post'] = $shop->get('latest_post_skin');
$design['latest_total'] = $shop->get('latest_total_skin');
$banner = $shop->banner();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="GR Shop" />
<link rel="stylesheet" href="<?php echo $layout; ?>/style.css" type="text/css" title="style" />
<link rel="stylesheet" href="<?php echo $grboard; ?>/outlogin/<?php echo $design['outlogin']; ?>/style.css" type="text/css" title="style" />
<link rel="stylesheet" href="<?php echo $grboard; ?>/latest/<?php echo $design['latest_product']; ?>/style.css" type="text/css" title="style" />
<link rel="stylesheet" href="<?php echo $grboard; ?>/latest/<?php echo $design['latest_post']; ?>/style.css" type="text/css" title="style" />
<link rel="stylesheet" href="<?php echo $grboard; ?>/latest/<?php echo $design['latest_total']; ?>/style.css" type="text/css" title="style" />
<link type="text/css" href="<?php echo $grcore; ?>/jquery_ui/ui.all.css" rel="Stylesheet" />
<script type="text/javascript" src="<?php echo $grcore; ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $grcore; ?>/js/jquery.ui.core.js"></script>
<script type="text/javascript" src="<?php echo $grcore; ?>/js/jquery.ui.accordion.js"></script>
<script type="text/javascript" src="<?php echo $layout; ?>/skin.js"></script>
<?php if($config['use_rss']) { ?><link rel="alternate" type="application/rss+xml" title="<?php echo $design['title']; ?> RSS" href="<?php echo $grboard; ?>/rss.php" /><?php } ?>
<title><?php echo $design['title']; ?></title>
<?php echo $design['head']; ?>
</head>
<body>

<div id="main">

	<div id="top">
		<div id="logo"><a href="../<?php echo $grshop; ?>" title="처음 화면으로 돌아갑니다."><img src="<?php echo $dir.'/'.$shop->get('shop_logo', ''); ?>" alt="LOGO" /></a></div>
		<div id="banner1"><?php if($banner[1]) { ?><a href="<?php echo $banner[1]['url']; ?>"><img src="<?php echo $dir; ?>/banner/<?php echo $banner[1]['file_route']; ?>" alt="배너1" /></a><?php } ?></div>
	</div><!-- #top -->

	<div id="topMenu">
		<ul>
			<li><a href="../<?php echo $grshop; ?>" title="처음 화면으로 돌아갑니다."><?php echo $config['btn_home']; ?></a></li>
			<li><a href="<?php echo $grboard; ?>/board.php?id=<?php echo $config['bbs_notice']; ?>" title="각종 이벤트/행사 소식을 전해 드립니다."><?php echo $config['btn_notice']; ?></a></li>
			<?php if(!$shop->isLogin()) { /* 로그인 하기 전 */ ?>
				<li><a href="<?php echo $dir; ?>/login/?go=../" title="로그인을 합니다."><?php echo $config['btn_login']; ?></a></li>
				<li><a href="<?php echo $grboard; ?>/join.php?joinInBoard=1&amp;boardId=<?php echo ($id)?$id:'notice'; ?>&amp;fromPage=<?php echo $grshop; ?>" title="아직 가입하지 않으셨나요? 지금 회원으로 가입해 보세요!"><?php echo $config['btn_join']; ?></a></li>
			<?php } else { /* 로그인 한 이후 */ ?>
				<li><a href="<?php echo $dir; ?>/login/?logout=1&amp;go=../" title="로그아웃 합니다."><?php echo $config['btn_logout']; ?></a></li>
				<li><a href="<?php echo $grboard; ?>/info.php?boardId=<?php echo ($id)?$id:'notice'; ?>" title="나의 기본 회원정보를 수정합니다."><?php echo $config['btn_myinfo']; ?></a></li>
			<?php } ?>
			<li><a href="<?php echo $dir; ?>/order/" title="고객님께서 주문하신 물품을 조회하고, 현재 어떤 상태인지 확인합니다."><?php echo $config['btn_order']; ?></a></li>
			<li><a href="<?php echo $dir; ?>/cart/" title="고객님께서 찜하신 물품 목록들을 확인합니다."><?php echo $config['btn_cart']; ?></a></li>
			<li><a href="<?php echo $dir; ?>/mypage/" title="고객님의 적립금이 얼마인지 확인하고, 생일, 결혼여부 등의 부가정보들을 관리합니다."><?php echo $config['btn_mypage']; ?></a></li>
			<li><a href="<?php echo $grboard; ?>/board.php?id=<?php echo $config['bbs_qna']; ?>" title="이 곳에서 상품구매/배송/환불 관련 문의를 하실 수 있습니다."><?php echo $config['btn_qna']; ?></a></li>
			<li><a href="<?php echo $grboard; ?>/board.php?id=<?php echo $config['bbs_freeboard']; ?>" title="상품평이나 쇼핑 관련 주제를 자유로이 남겨주세요."><?php echo $config['btn_freeboard']; ?></a></li>
		</ul>
	</div><!-- #topMenu -->

	<div id="leftSide">

		<?php outlogin($design['outlogin']); ?>

		<div class="sideMenu"><?php echo $config['side_category']; ?></div>
		<div id="category">
		<?php
		// 대분류 출력
		$category1 = $shop->category(1);
		for($c1=1; $c1<$category1[0]; $c1++) { ?>
			<div>
				<h3><a href="#"><?php echo $category1[$c1]['name']; ?></a></h3>
				<div class="subCategory">
				<?php
				// 대분류에 속한 게시판 목록 출력
				$category2 = $shop->category(2, $category1[$c1]['uid']);
				for($c2=1; $c2<$category2[0]; $c2++) { ?>
					<p><a href="<?php echo $grboard; ?>/board.php?id=<?php echo $category2[$c2]['id']; ?>" title="상품이 진열된 곳으로 이동합니다."><?php echo $category2[$c2]['title']; ?></a></p>
				<?php } ?>
				</div>
			</div>
		<?php } ?>
		</div>

		<?php 
		// 2번 배너부터 n번 배너까지 출력
		$totalBanner = @count($banner);
		for($b=2; $b<$totalBanner; $b++) { ?>
		<?php if($b==2) { ?><div class="sideMenu"><?php echo $config['side_banner']; ?></div><?php } ?>
			<div class="sideList"><a href="<?php echo $banner[$b]['url']; ?>"><img src="<?php echo $dir; ?>/banner/<?php echo $banner[$b]['file_route']; ?>" alt="배너<?php echo $b; ?>" /></a></div>
		<?php } ?>

	</div><!-- #leftSide -->

	<div id="mainCONTENT">