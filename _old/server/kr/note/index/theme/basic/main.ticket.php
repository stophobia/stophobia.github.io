<div id="goalTop">프로젝트: <select name="chooseProject" onchange="location.href='./?m=ticket&amp;p='+this.value;">
<option value="">선택하세요</option>
<?php
$getProjects = @mysql_query('select uid, name from '.$ticket->divide.'projects order by uid asc');
while($lists = @mysql_fetch_array($getProjects)) { ?>
<option value="<?php echo $lists['uid']; ?>"<?php echo (($lists['uid'] == $_GET['p'])?' selected="selected"':''); ?>><?php echo $lists['name']; ?></option>
<?php } ?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;
목표: <select name="chooseGoal" onchange="location.href='./?m=ticket&amp;p=<?php echo $_GET['p']; ?>&amp;g='+this.value;">
<option value="">선택하세요</option>
<?php
$getGoals = @mysql_query('select uid, codename, version from '.$ticket->divide.'goals where project_id = '.$_GET['p'].' order by uid desc');
while($goal = @mysql_fetch_array($getGoals)) { ?>
<option value="<?php echo $goal['uid']; ?>"<?php echo (($goal['uid'] == $_GET['g'])?' selected="selected"':''); ?>><?php echo $goal['codename']; ?> (<?php echo $goal['version']; ?>)</option>
<?php } ?>
</select></div>
<?php 
// 프로젝트와 목표 선택시
if($_GET['g']) { ?>
<br /><span class="b">티켓 발행하기</span><br />
<br />
선택하신 프로젝트의 특정 목표에 대한 세부적인 할 일을 작성합니다.<br />
GR노트에서 발행된 티켓은 상단 메뉴중 "티켓보기" 를 통해서 확인 할 수 있습니다.<br />
티켓(할 일)을 발행할 대상이 '누구나' 일 경우 (즉, 특정 대상자가 없고 모두 해당될 경우)<br />
받는이 아이디를 적는 부분을 비워 두시면 됩니다.<br />
<br />
<form id="create" method="post" action="./?m=ticket" onsubmit="return Ticket.create();">
<div><input type="hidden" name="modifyNo" value="<?php echo $_GET['modifyNo']; ?>" />
<input type="hidden" name="projectID" value="<?php echo $_GET['p']; ?>" />
<input type="hidden" name="goalID" value="<?php echo $_GET['g']; ?>" /></div>
<ol>
	<li><input type="text" name="target" /> : 받는이 아이디 (없을시 공백)</li>
	<li><input type="text" name="memo" style="width: 500px" maxlength="250" /> : 할 일</li>
</ol>
<div id="submitForm"><input type="image" src="<?php echo $path; ?>/images/ticket.send.ok.gif" /></div>
</form>
<?php
// 프로젝트와 목표 미선택시
} else { ?>
<div style="text-align: center; padding: 100px">선택된 프로젝트/목표 가 없습니다.</div>
<?php } ?>