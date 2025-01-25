<?php 
// 프로젝트 생성하기
if($a == 'create' && ($project->getLevel($_SESSION['userNo']) >= $grNote['project']['makeLevel'] || $_SESSION['userNo'] == 1)) { ?>
<span class="b">신규 프로젝트 생성하기</span><br />
<br />
프로젝트를 새로 생성합니다.<br />
아래 간단한 항목들을 입력하신 후, "시작하기" 를 누르시면 됩니다.<br />
프로젝트를 시작한 이후 "<strong>목표관리</strong>" 에서 신규 프로젝트에 대한<br />
목표를 새로 생성하시고, 그 목표에 맞는 세부적인 할 일(티켓)을 <br />
"<strong>티켓발행</strong>"을 통해 특정 멤버에게 발행해 보세요.<br />
<br />
<form id="create" method="post" action="./?m=project" onsubmit="return Project.create();">
<div><input type="hidden" name="modifyNo" value="" /></div>
프로젝트 이름: <input type="text" name="name" style="width: 300px" /><br />
<br />
프로젝트 소개:<br />
<textarea name="summary" rows="20"></textarea><br />
<br />
<div id="submitForm"><input type="image" src="<?php echo $path; ?>/images/project.start.icon.gif" /></div>
</form>
<?php
// 프로젝트 수정하기
} elseif($a == 'modify' && ($project->getLevel($_SESSION['userNo']) >= $grNote['project']['makeLevel'] || $_SESSION['userNo'] == 1)) { 
	$modify = @mysql_fetch_array(mysql_query('select * from '.$project->divide.'projects where uid = '.$_GET['modifyNo']));
?>
<span class="b"><?php echo htmlspecialchars(stripslashes($modify['name'])); ?> 프로젝트 수정하기</span><br />
<br />
프로젝트를 수정합니다.<br />
프로젝트 이름과 요약된 소개를 수정하실 수 있습니다.<br />
<br />
<form id="create" method="post" action="./?m=project" onsubmit="return Project.create();">
<div><input type="hidden" name="modifyNo" value="<?php echo $_GET['modifyNo']; ?>" /></div>
프로젝트 이름: <input type="text" name="name" style="width: 300px" value="<?php echo $modify['name']; ?>" /><br />
<br />
프로젝트 소개:<br />
<textarea name="summary" rows="20"><?php echo stripslashes($modify['summary']); ?></textarea><br />
<br />
<div id="submitForm"><input type="image" src="<?php echo $path; ?>/images/project.modify.ok.gif" /></div>
</form>
<?php 
// 프로젝트 목록보기
} else { ?>
<span class="b">현재 진행중인 프로젝트 목록</span><br />
<br />
<ul>
	<?php
	$getProjects = @mysql_query('select * from '.$project->divide.'projects order by uid asc');
	while($lists = @mysql_fetch_array($getProjects)) { 
		$memberInfo = $project->getInfo($lists['leader']);
		$progress = $project->getPercent($lists['uid']);
	?>
	<li class="a" onclick="Project.choose(<?php echo $lists['uid']; ?>);"><strong>
	<?php echo htmlspecialchars(stripslashes($lists['name'])).'</strong> ('.$progress.'% 진행중)'; ?>
	<div id="projectInfo<?php echo $lists['uid']; ?>" class="info" style="display: none">
	<div class="progressBar" style="width: <?php echo $progress; ?>%">&nbsp;</div>
	<strong>프로젝트 출범자:</strong> <?php echo stripslashes($memberInfo['nickname']).' ('.$memberInfo['id'].')'; ?><br />
	<strong>프로젝트명:</strong> <?php echo htmlspecialchars(stripslashes($lists['name'])); ?><br />
	<strong>시 작 일 자:</strong> <?php echo date('Y년 m월 d일 H시 i분 s초', $lists['make_time']); ?><br />
	<strong>최근작업일:</strong> <?php echo date('Y년 m월 d일 H시 i분 s초', $lists['update_time']); ?><br />
	<strong>미완된 티켓수:</strong> <?php echo number_format($lists['ticket_yet']); ?>개<br />
	<strong>완료된 티켓수:</strong> <?php echo number_format($lists['ticket_done']); ?>개<br />
	<strong>프로젝트 소개:</strong><br /><?php echo stripslashes($lists['summary']); ?>
	<div style="text-align: right">
		<a href="./?m=project&amp;a=modify&amp;modifyNo=<?php echo $lists['uid']; ?>" title="진행중인 이 프로젝트를 수정합니다."><img src="<?php echo $path; ?>/images/project.modify.mini.gif" alt="" /> 프로젝트 수정하기</a>&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="#" onclick="Project.remove(<?php echo $lists['uid']; ?>);" title="진행중인 이 프로젝트를 삭제합니다."><img src="<?php echo $path; ?>/images/project.delete.mini.gif" alt="" /> 프로젝트 삭제하기</a>
	</div>
	</div>
	</li>
	<?php } ?>
</ul>
<?php } ?>

<div id="projectButton">
<?php if(($project->getLevel($_SESSION['userNo']) >= $grNote['project']['makeLevel'] || $_SESSION['userNo'] == 1) && $a != 'create') { ?>
<a href="./?m=project&amp;a=create"><img src="<?php echo $path; ?>/images/project.create.icon.gif" alt="생성하기" /></a>
<?php } ?>
</div>