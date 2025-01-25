<?php
/**
 * @update 2009-02-06
 * @comment 관리화면 열람 (기본 : 전체설정)
 */
if($_GET['m']) $m = $_GET['m']; else $m = 'all';
if($m == 'backup') include 'admin.backup.php';
include '../grnote.config.php';
$grNote['title'] = 'GR Note Administrator Page';
include $grNote['path'].'/common/head.header.php';
include $grNote['path'].'/library/admin.lib.php';
include $grNote['path'].'/common/head.admin.html.php';
$admin = new Admin('../');
if($_GET['uninstall'] == 'yes') $admin->uninstall();
?>
<body>
<div id="adminBack">
	<div id="adminTop">
		<a href="../"><img src="images/grnote.logo.gif" alt="GR Note" /></a>
	</div>
	<div id="menuBar">
		<a href="./?m=all"><img src="images/menu.top.all<?php echo (($m=='all')?'.over':''); ?>.gif" alt="전체설정" /></a><a href="./?m=wiki"><img src="images/menu.top.wiki<?php echo (($m=='wiki')?'.over':''); ?>.gif" alt="위키설정" /></a><a href="./?m=goal"><img src="images/menu.top.goal<?php echo (($m=='goal')?'.over':''); ?>.gif" alt="목표설정" /></a><a href="./?m=ticket"><img src="images/menu.top.ticket<?php echo (($m=='ticket')?'.over':''); ?>.gif" alt="티켓설정" /></a><a href="./?m=member"><img src="images/menu.top.member<?php echo (($m=='member')?'.over':''); ?>.gif" alt="멤버관리" /></a><a href="./?m=backup"><img src="images/menu.top.backup.gif" alt="백업받기" /></a><a href="./?m=logout"><img src="images/menu.top.logout.gif" alt="로그아웃" /></a><a href="./?m=uninstall"><img src="images/menu.top.uninstall<?php echo (($m=='uninstall')?'.over':''); ?>.gif" alt="삭제하기" /></a>
	</div>
	<div id="control">
	<?php
	switch($m)
	{
		case 'wiki': include 'admin.wiki.php'; break;
		case 'goal': include 'admin.goal.php'; break;
		case 'ticket': include 'admin.ticket.php'; break;
		case 'member': include 'admin.member.php'; break;
		case 'uninstall': include 'admin.uninstall.php'; break;
		case 'logout': $admin->logout(); break;
		default: include 'admin.all.php'; break;
	}
	?>
	</div>
</div>
<div id="copyright">
Powered by <a href="http://sirini.net/">GR Note</a>
</div>
<?php
include $grNote['path'].'/common/foot.admin.html.php';
?>