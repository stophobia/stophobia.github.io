<?php
/**
 * GR Forum Administrator Page
 * @author sirini
 * @update 2009-07-30
 * @comment GR Forum 관리화면
 * @warning 게시판 설정, 회원 관리 등 GR Board 기능은 GR Board 관리화면에서 한다.
 *          GR Shop 처럼 메인 버튼으로 GR Board 관리화면으로 가는 버튼을 배치해둔다.
 */

// 코어 / 보드 연동
include '../core.php';
include '../' . $grcore . '/class/common.php';
$core = new Common('../' . $grcore);
$grboard = '../' . $core->config['grboard'];
$core->session($grboard . '/session');
define('__GRFORUM__', true);

// 관리자인가?
if($_SESSION['no'] != 1) $core->alert('관리자만 접속할 수 있습니다.', '../login/');

// 볼 패널
$m = ($_GET['m']) ? $_GET['m'] : $_POST['m'];
if(!$m) $m = 1;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="GR Forum" />
<meta name="Author" content="박희근 Hee Geun Park" />
<meta name="Nationality" content="Republic of Korean" />
<meta name="copyright" content="Copyright ⓒ 2009 Hee Geun Park" />
<title>GR Forum Administrator Page</title>
<link rel="stylesheet" href="admin.css" type="text/css" title="style" />
<script type="text/javascript" src="../<?php echo $grcore; ?>/js/jquery.js"></script>
<script type="text/javascript" src="admin.js"></script>
</head>
<body>

<div id="top">

	<div id="logo"><a href="./"><img src="images/logo.gif" alt="GR Forum" /></a></div>
	<div id="topBtn">
		<a href="../logout/" title="클릭하시면 로그아웃 후 처음화면으로 이동합니다">로그아웃</a> &nbsp;|&nbsp; 
		<a href="../" title="클릭하시면 로그인 된 상태로 처음화면으로 이동합니다">처음화면</a> &nbsp;|&nbsp; 
		<a href="<?php echo $grboard; ?>/admin.php" title="클릭하시면 게시판, 회원 등을 관리할 수 있는 GR Board 관리화면으로 이동합니다">GR Board 관리화면</a>  &nbsp;|&nbsp; 
		<a href="http://sirini.net" title="클릭하시면 GR Forum 배포 사이트인 시리니넷으로 이동합니다">시리니넷</a>
	</div>

</div>

<div id="side">
	<div class="title">일반 설정</div>
	<ul>
		<li><a href="./?m=2">로고 설정</a></li>
		<li><a href="./?m=3">포럼 명칭/설명</a></li>
		<li><a href="./?m=4">스킨 선택</a></li>
		<li><a href="./?m=5">업데이트</a></li>
		<li><a href="./?m=6">GR Forum 삭제</a></li>
	</ul>

	<div class="title">포럼 관리</div>
	<ul>
		<li><a href="./?m=20">분류 관리</a></li>
		<li><a href="./?m=21">차단할 아이디</a></li>
		<li><a href="./?m=22">차단할 아이피</a></li>
		<li><a href="./?m=23">접근 허용/배제</a></li>
	</ul>

	<div class="title">연동 도구</div>
	<ul>
		<li><a href="<?php echo $grboard; ?>/admin.php">GR Board 관리화면</a></li>
		<?php if($grid) { ?><li><a href="../<?php echo $core->config['grcounter']; ?>">GR Counter 관리화면</a></li><?php } ?>
	</ul>
</div>

<div id="config">
<?php
switch($m) {
	case 1: include 'admin.index.php'; break;
	case 2: include 'admin.logo.php'; break;
	case 3: include 'admin.title.php'; break;
	case 4: include 'admin.skin.php'; break;
	case 5: include 'admin.update.php'; break;
	case 6: include 'admin.uninstall.php'; break;
	
	case 20: include 'forum.category.php'; break;
	case 21: include 'forum.block.id.php'; break;
	case 22: include 'forum.block.ip.php'; break;
	case 23: include 'forum.access.php'; break;
}
?>
</div>

</body>
</html>