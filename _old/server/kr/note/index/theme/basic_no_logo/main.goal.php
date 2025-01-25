<div id="goalTop">프로젝트: <select name="chooseProject" onchange="location.href='./?m=goal&amp;p='+this.value;">
<option value="">선택하세요</option>
<?php
$getProjects = @mysql_query('select uid, name from '.$goal->divide.'projects order by uid asc');
while($lists = @mysql_fetch_array($getProjects)) { ?>
<option value="<?php echo $lists['uid']; ?>"<?php echo (($lists['uid'] == $_GET['p'])?' selected="selected"':''); ?>><?php echo $lists['name']; ?></option>
<?php } ?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;
보여줄 개수: <select name="chooseNumber" onchange="location.href='./?m=goal&amp;p=<?php echo $_GET['p']; ?>&amp;c='+this.value;">
<option value="5"<?php echo (($_GET['c']==5)?' selected="selected"':''); ?>>최근 5개의 목표</option>
<option value="10"<?php echo (($_GET['c']==10)?' selected="selected"':''); ?>>최근 10개의 목표</option>
<option value="15"<?php echo (($_GET['c']==15)?' selected="selected"':''); ?>>최근 15개의 목표</option>
<option value="20"<?php echo (($_GET['c']==20)?' selected="selected"':''); ?>>최근 20개의 목표</option>
<option value="30"<?php echo (($_GET['c']==30)?' selected="selected"':''); ?>>최근 30개의 목표</option>
<option value="50"<?php echo (($_GET['c']==50)?' selected="selected"':''); ?>>최근 50개의 목표</option>
<option value="100"<?php echo (($_GET['c']==100)?' selected="selected"':''); ?>>최근 100개의 목표</option>
<option value="10000"<?php echo (($_GET['c']==10000)?' selected="selected"':''); ?>>모두보기</option></select></div>
<?php 
// 프로젝트를 아직 선택하지 않았다면
if(!$_GET['p'] && !$_GET['a']) { ?>
<div style="text-align: center; padding: 100px">선택된 프로젝트가 없습니다.</div>
<?php 
// 프로젝트를 선택했다면
} elseif($_GET['a'] != 'create' && !$_GET['modifyNo']) {
	echo '<ol>';
	if($_GET['c'] < 1000 && $_GET['c'] > 0) $addQ = ' order by uid asc limit '.$_GET['c']; 
	elseif($_GET['c'] == 10000) $addQ = '';
	else $addQ = ' order by uid desc limit 5';
	$getGoal = @mysql_query('select * from '.$goal->divide.'goals where project_id = '.$_GET['p'].$addQ);
	while($goals = @mysql_fetch_array($getGoal)) { 
		$progress = $goal->getPercent($goals['uid']);	
	?>
	<li class="g"><div class="progressBar" style="width: <?php echo $progress; ?>%"></div>
	<strong>코드네임:</strong> <?php echo htmlspecialchars(stripslashes($goals['codename'])); ?><br />
	<strong>버젼:</strong> <?php echo $goals['version']; ?><br />
	<strong>미완된 티켓:</strong> <?php echo $goals['ticket_yet']; ?>개<br />
	<strong>완료된 티켓:</strong> <?php echo $goals['ticket_done']; ?>개<br />
	<strong>목표 설명:</strong><br /><?php echo stripslashes($goals['goal']); ?>
	<div style="text-align: right">
	<a href="./?m=goal&amp;a=modify&amp;modifyNo=<?php echo $goals['uid']; ?>&amp;p=<?php echo $_GET['p']; ?>" title="진행중인 이 목표를 수정합니다."><img src="<?php echo $path; ?>/images/project.modify.mini.gif" alt="" /> 목표수정</a>&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="#" onclick="Goal.remove(<?php echo $goals['uid']; ?>, <?php echo $_GET['p']; ?>);" title="진행중인 이 목표를 삭제합니다."><img src="<?php echo $path; ?>/images/project.delete.mini.gif" alt="" /> 목표삭제</a>
	</div>
	</li>
<?php 
	} 
	echo '</ol>';
// 새로운 목표를 추가한다면
} elseif($_GET['a'] == 'create' && $_GET['p']) { ?>
<br /><span class="b">목표 추가하기</span><br />
<br />
선택하신 프로젝트에 새로운 목표점을 추가합니다.<br />
이전 목표들보다 갱신된 버젼과 중복되지 않는 코드네임을 부여해 주세요.<br />
(예: 코드네임: 수달, 버 젼: v1.7.3)<br />
<br />
<form id="create" method="post" action="./?m=goal" onsubmit="return Goal.create();">
<div><input type="hidden" name="modifyNo" value="" /><input type="hidden" name="projectID" value="<?php echo $_GET['p']; ?>" /></div>
코드네임 / 버 젼: &nbsp;&nbsp; <input type="text" name="codename" /> / <input type="text" name="version" /><br />
<br />
목표설명:<br />
<textarea name="goal" rows="20"></textarea><br />
<br />
<div id="submitForm"><input type="image" src="<?php echo $path; ?>/images/project.start.icon.gif" /></div>
</form>
<?php 
// 기존 목표를 수정한다면
} elseif($_GET['a'] == 'modify' && $_GET['modifyNo']) { 
	$modify = @mysql_fetch_array(mysql_query('select * from '.$goal->divide.'goals where uid = '.$_GET['modifyNo']));
?>
<br /><span class="b">목표 수정하기</span><br />
<br />
기존의 목표를 수정합니다.<br />
<br />
<form id="create" method="post" action="./?m=goal" onsubmit="return Goal.create();">
<div><input type="hidden" name="modifyNo" value="<?php echo $_GET['modifyNo']; ?>" /><input type="hidden" name="projectID" value="<?php echo $_GET['p']; ?>" /></div>
코드네임 / 버 젼: &nbsp;&nbsp; <input type="text" name="codename" value="<?php echo $modify['codename']; ?>" /> / <input type="text" name="version" value="<?php echo $modify['version']; ?>" /><br />
<br />
목표설명:<br />
<textarea name="goal" rows="20"><?php echo stripslashes($modify['goal']); ?></textarea><br />
<br />
<div id="submitForm"><input type="image" src="<?php echo $path; ?>/images/project.modify.ok.gif" /></div>
</form>
<?php } ?>

<div id="projectButton">
<?php if(($goal->getLevel($_SESSION['userNo']) >= $grNote['goal']['makeLevel'] || $_SESSION['userNo'] == 1) && $a != 'create') { ?>
<a href="#" onclick="Goal.nonProject('<?php echo $_GET['p']; ?>');"><img src="<?php echo $path; ?>/images/project.create.icon.gif" alt="생성하기" /></a>
<?php } ?>
</div>