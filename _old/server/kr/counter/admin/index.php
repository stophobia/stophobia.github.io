<?php
include '../class/Common.php';
include '../class/GRCounter.php';
include '../class/Status.php';
include '../class/StatusForAdmin.php';
$GC = new Common;
$GG = new GRCounter;
$GS = new Status;
$GA = new StatusForAdmin;

// 관리자로 로긴 하지 않았다면 사용 불가
if($_GET['admin']) $admin = $_GET['admin'];
if(!$GC->isAdmin()) $GC->error('관리자 화면은 로그인 후 접근이 가능 합니다.', 'location.href=\'../login/\';');

// 각 관리자 페이지별 작업들
include 'process.php';

// 메뉴 버튼 상태
function btn($n, $btn)
{
	if($n == $btn) return 'm';
	else return 'n';
}

// DB백업시
if($admin == 9) {
	include '../class/Database.php';
	$DB = new Database;
	include '../db_info.php';
	@set_time_limit(0);
	$saveDay = date('Ymd', time());
	$DB->dbHeader('grcounter_'.$saveDay.'.sql');
	$DB->allDown($dbName);
	exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="GR Counter" />
<link rel="stylesheet" href="../style.css" type="text/css" title="style" />
<script src="../plotr/lib/prototype/prototype.js" type="text/javascript"></script>
<script src="../plotr/lib/excanvas/excanvas.js" type="text/javascript"></script>
<script src="../plotr/plotr.js" type="text/javascript"></script>
<script type="text/javascript" src="admin.js"></script>
<style type="text/css">
/*<![CDATA[*/
@import url(admin.css);
/*]]>*/
</style>
<title>GR Counter - v1.3 - 관리자 화면</title>
</head>
<body>
<div id="adminTop">
	<a href="./">GR Counter</a>
</div>

<!-- 가운데정렬 -->
<div id="center">

<!-- 관리화면 메뉴 -->
<div id="adminMenu">
	<div class="boxTitle">관리메뉴</div>
	<div class="<?php echo btn($admin, 100); ?>"><a href="./?admin=100"><img src="../image/icon_mode_setup.gif" alt="" /> 동작 설정</a></div>
	<div class="<?php echo btn($admin, 1); ?>"><a href="./?admin=1"><img src="../image/icon_total_setup.gif" alt="" /> 전체 통계</a></div>
	<div class="<?php echo btn($admin, 2); ?>"><a href="./?admin=2"><img src="../image/icon_new_id.gif" alt="" /> ID 추가</a></div>
	<div class="<?php echo btn($admin, 3); ?>"><a href="./?admin=3"><img src="../image/icon_stat_calendar.gif" alt="" /> 연간 통계</a></div>
	<div class="<?php echo btn($admin, 4); ?>"><a href="./?admin=4"><img src="../image/icon_stat_month.gif" alt="" /> 월간 통계</a></div>
	<div class="<?php echo btn($admin, 5); ?>"><a href="./?admin=5"><img src="../image/icon_stat_day.gif" alt="" /> 일일 통계</a></div>
	<div class="<?php echo btn($admin, 6); ?>"><a href="./?admin=6"><img src="../image/icon_stat_hour.gif" alt="" /> 시간 통계</a></div>
	<div class="<?php echo btn($admin, 7); ?>"><a href="./?admin=7"><img src="../image/icon_referer_log.gif" alt="" /> 리퍼러 기록</a></div>
	<div class="<?php echo btn($admin, 10); ?>"><a href="./?admin=10"><img src="../image/icon_stat_pie.gif" alt="" /> 리퍼러 통계</a></div>
	<div class="<?php echo btn($admin, 8); ?>"><a href="./?admin=8"><img src="../image/icon_ip_log.gif" alt="" /> IP 로그</a></div>
	<div class="<?php echo btn($admin, 9); ?>"><a href="#" onclick="GC.deleteCounter();"><img src="../image/icon_delete.gif" alt="" /> 카운터 삭제</a></div>
	<div class="n"><a href="http://sirini.net" onclick="window.open(this.href, '_blank'); return false" title="개발자 사이트를 열어 봅니다"><img src="../image/icon_sirini_net.gif" alt="" /> 개발자 사이트</a></div>
	<div class="n"><a href="./?admin=9" title="GR Counter DB를 백업 합니다."><img src="../image/icon_db_save.gif" alt="" /> DB 백업</a></div>
	<div class="clr"></div>
</div>
<!--# 관리화면 메뉴 -->

<!-- 항목 별 제어화면 -->
<div id="adminControl">
	<div id="setTop">통 계</div>
<?php
switch($admin)
{
	case 1: include 'admin_all.php'; break;
	case 2: include 'admin_add.php'; break;
	case 3: include 'admin_year.php'; break;
	case 4: include 'admin_month.php'; break;
	case 5: include 'admin_day.php'; break;
	case 6: include 'admin_hour.php'; break;
	case 7: include 'admin_referer_log.php'; break;
	case 8: include 'admin_ip_log.php'; break;
	case 10: include 'admin_referer_status.php'; break;
	case 100: include 'admin_mode_setup.php'; break;
	default: include 'admin_all.php'; break;
}
?>
</div>
<!--# 항목 별 제어화면 -->

<div class="clr"></div>

</div><!--# 가운데 정렬 -->

</body>
</html>