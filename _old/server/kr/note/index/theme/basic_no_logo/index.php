<?php
/**
 * @update 2008-11-21
 * @comment GR노트 첫화면 처리 (기본: 위키)
 */
$prefix = '.';
if($_GET['m']) $m = $_GET['m']; else $m = 'wiki';
if($_GET['a']) $a = $_GET['a']; else $a = 'view';
include 'common/head.header.php';
include 'library/'.$m.'.lib.php';
$path = 'index/theme/'.$grNote['theme'];
if($m == 'logout') {
	$_SESSION = array();
	@session_destroy();
} elseif($m == 'project') $project = new Project;
elseif($m == 'goal') $goal = new Goal;
elseif($m == 'ticket') $ticket = new Ticket;
elseif($m == 'view') $view = new View;
elseif($m == 'planner') $planner = new Planner;
else $wiki = new Wiki;
$_SESSION['writeKey'] = $wiki->writeKey1 + $wiki->writeKey2;
include 'index/theme/'.$grNote['theme'].'/head.html.php';
?>
<body>
<div id="indexBack">
	<div id="menuBar">
		<a href="./?m=wiki"><img src="<?php echo $path; ?>/images/menu.top.grwiki.gif" alt="GR위키" /></a><a href="./?m=planner"><img src="<?php echo $path; ?>/images/menu.top.planner.gif" alt="e플래너" /></a><a href="./?m=project"><img src="<?php echo $path; ?>/images/menu.top.project.gif" alt="프로젝트" /></a><a href="./?m=goal"><img src="<?php echo $path; ?>/images/menu.top.goal.gif" alt="목표관리" /></a><a href="./?m=ticket"><img src="<?php echo $path; ?>/images/menu.top.ticket.gif" alt="티켓발행" /></a><a href="./?m=view"><img src="<?php echo $path; ?>/images/menu.top.ticket.view.gif" alt="티켓보기" /></a><?php if(!$_SESSION['userNo']) { ?><a href="./login/"><img src="<?php echo $path; ?>/images/menu.top.login.gif" alt="로그인" /></a><?php } else { ?><a href="./?m=logout"><img src="<?php echo $path; ?>/images/menu.top.logout.gif" alt="로그아웃" /></a><?php } if($_SESSION['userNo']==1) { ?><a href="./admin/"><img src="<?php echo $path; ?>/images/menu.top.admin.gif" alt="관리화면" /></a><?php } ?>&nbsp;&nbsp;
	</div>
	<div id="main"><?php @include 'main.'.$m.'.php'; ?></div>
	<div id="loadBox" style="display: none"></div>
	<div id="copyright">Powered by <a href="http://sirini.net/">GR Note</a></div>
</div>
<?php include 'index/theme/'.$grNote['theme'].'/foot.html.php'; ?>