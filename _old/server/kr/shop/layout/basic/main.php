<?php
/**
 * 레이아웃 스킨 메인부분 (첫화면)
 * 참고: 레이아웃 스킨 제작자의 GR Board 활용능력 + PHP/MySQL 에 대한 이해도에 따라
 *         쇼핑몰 전체 디자인이나 기능이 천차만별로 달라짐. 기본 레이아웃은 그저 참고용으로 보고
 *         실제 제작시에는 스킨 제작자의 기량에 따라 멋지게 꾸미면 좋음.
 * 제작: sirini (http://sirini.net)
 **/
?>

<!-- 추천상품 최근게시물 -->
<?php latest($design['latest_product'], $config['bbs_best'], $config['row_best'], '0', '0', '0', 'Y.m.d', $config['btn_best'], 'no', 'desc'); ?>

<!-- 최근 등록된 신상품 목록 (통합 최근게시물) -->
<?php total_article_latest($design['latest_total'], $config['row_total_new'], '0', 'Y.m.d', $config['btn_total_latest'], false, 'no', 'desc', ''); ?>

<?php 
// 관리자일 경우 GR Shop 관리화면, GR Board 관리화면, 레이아웃 설정 버튼 출력
if($shop->isAdmin()) { ?>
<div id="layoutSetting">
	<a href="./admin/" onclick="window.open(this.href, '_blank'); return false" title="GR Shop 관리화면으로 갑니다."><img src="<?php echo $layout; ?>/image/layout.config.icon.gif" alt="" /> GR Shop 관리</a>
	<a href="<?php echo $grboard; ?>/admin.php" onclick="window.open(this.href, '_blank'); return false" title="GR Board 관리화면으로 갑니다."><img src="<?php echo $layout; ?>/image/layout.config.icon.gif" alt="" /> GR Board 관리</a>
	<?php /* GR Counter 연동시 → */ if($grcounter && $grid) { ?><a href="<?php echo $grcounter; ?>/admin/" onclick="window.open(this.href, '_blank'); return false" title="GR Counter 관리화면으로 갑니다."><img src="<?php echo $layout; ?>/image/layout.config.icon.gif" alt="" /> GR Counter 관리</a><?php } ?>
	<a href="<?php echo $layout; ?>/layout.config.php" onclick="window.open(this.href, 'config', 'width=650,height=600,menubar=no,resizable=no,scrollbars=yes'); return false" title="사용중이신 레이아웃 스킨의 각종 버튼 글자부터 출력 개수 등의 설정을 지정합니다."><img src="<?php echo $layout; ?>/image/layout.config.icon.gif" alt="" /> 레이아웃 설정</a></div>
<?php } ?>