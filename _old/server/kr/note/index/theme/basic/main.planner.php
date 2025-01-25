<?php
/**
 * @update 2008-11-21
 * @comment 플래너 첫화면
 * $grNote['planner']['open'] = 1 이면 전체 공개용, 2 면 각자 개인용
 */
if(!$_GET['year']) $year = date('Y'); else $year = $_GET['year'];
if(!$_GET['month']) $month = date('m'); else $month = $_GET['month'];
$calendar = $planner->getCalendar(mktime(0, 0, 0, $month, 1, $year));
$prevMonth = ($month < 2) ? 12 : $month - 1;
$nextMonth = ($month > 11) ? 1 : $month + 1;
$prevYear = $year - 1;
$nextYear = $year + 1;
?>
<div id="calendarMenu">
<?php if(!$_SESSION['userNo'] && $grNote['planner']['open'] == 2) { ?><span class="notLogin">! 아직 로그인하지 않으셨습니다.</span>&nbsp;&nbsp;<?php } else { ?>
<a href="#" title="예정된 일정을 추가합니다. (예: 휴가, 워크숍)" onclick="Planner.addPlan();"><img src="<?php echo $path; ?>/images/planner.top.add.gif" alt="일정입력" /></a>
<a href="#" title="기념일을 추가합니다. (예: 결혼기념일, 제사)" onclick="Planner.getMemorial();"><img src="<?php echo $path; ?>/images/planner.top.add.memorial.gif" alt="기념일 입력" /></a> &nbsp;&nbsp;&nbsp;&nbsp;
<?php } ?>
<strong><?php echo $year; ?>년 </strong><a href="./?m=planner&amp;year=<?php echo $prevYear; ?>&amp;month=<?php echo $month; ?>" title="<?php echo $prevYear; ?>년 <?php echo $month; ?>월 달력 보기"><img src="index/images/down.gif" alt="이전 년도" /></a> <a href="./?m=planner&amp;year=<?php echo $nextYear; ?>&amp;month=<?php echo $month; ?>" title="<?php echo $nextYear; ?>년 <?php echo $month; ?>월 달력 보기"><img src="index/images/up.gif" alt="이후 년도" /></a> &nbsp;&nbsp; 
<strong><?php echo $month; ?>월 </strong><a href="./?m=planner&amp;year=<?php echo $year; ?>&amp;month=<?php echo $prevMonth; ?>" title="<?php echo $year; ?>년 <?php echo $prevMonth; ?>월 달력 보기"><img src="index/images/down.gif" alt="앞 달" /></a> <a href="./?m=planner&amp;year=<?php echo $year; ?>&amp;month=<?php echo $nextMonth; ?>" title="<?php echo $year; ?>년 <?php echo $nextMonth; ?>월 달력 보기"><img src="index/images/up.gif" alt="뒤 달" /></a>
</div>

<div id="calendarBox">
<?php echo $calendar; ?>
</div>

<form id="addPlan" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return Planner.add();">
<div id="setModifyTarget"><input type="hidden" id="modifyTarget" value="" /><input type="hidden" name="y" value="<?php echo $planner->y; ?>" /><input type="hidden" name="m" value="<?php echo $planner->m; ?>" /></div>
<div id="addPlanBox" style="display: none">
	<div id="planTitle" class="layerTitle">일정관리</div>
	<div><strong>기간:</strong> 
	<input type="text" id="startDate" name="startDate" class="i" /> <select id="startHour"><?php for($sh=1; $sh<25; $sh++) echo '<option value="'.$sh.'"'.(($sh==date('H'))?' selected="selected"':'').'>'.$sh.'시</option>'; ?></select>부터 
	<input type="text" id="endDate" name="endDate" class="i" /> <select id="endHour"><?php for($eh=1; $eh<25; $eh++) echo '<option value="'.$eh.'"'.(($eh==date('H'))?' selected="selected"':'').'>'.$eh.'시</option>'; ?></select>까지 
	&nbsp;&nbsp;<strong>중요도:</strong>
	<select id="level"><option value="5">최우선</option><option value="4">중요</option><option value="3" selected="selected">보통</option><option value="2">낮음</option><option value="1">없음</option></select></div>
	<div><strong>요약:</strong> <input type="text" id="subject" name="subject" class="i sum" /> <input type="image" src="<?php echo $path; ?>/images/planner.add.plan.gif" /> <a href="#" onclick="Planner.remove($('modifyTarget').value);"><img src="<?php echo $path; ?>/images/planner.delete.plan.gif" alt="일정삭제" /></a></div>
	<div id="contentPlan"><strong>내용:</strong> <textarea id="content" rows="5"></textarea></div>
	<div class="close"><img src="index/images/close.gif" alt="닫기" title="일정입력창을 닫습니다." onclick="Effect.Fade('addPlanBox'); $('loadBox').style.display='none';" /></div>
</div>
</form>

<div id="viewDetail" class="layerBox" style="display: none">
	<div id="detailTitle" class="layerTitle"></div>
	<div id="detailList"></div>
	<div class="close"><img src="index/images/close.gif" alt="닫기" title="일정 확인창을 닫습니다." onclick="Effect.Fade('viewDetail'); $('loadBox').style.display='none';" /></div>
</div>

<form id="addMemorial" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return Planner.addMemorial();">
<div><input type="hidden" id="setTarget" value="" /></div>
<div id="setMemorial" class="layerBox" style="display: none">
	<div id="setMemoTitle" class="layerTitle">기념일 관리</div>
	<div id="setMemorial">
		<div><input type="text" id="setDate" name="setDate" class="i" /> <select id="setHour"><?php for($sh=1; $sh<25; $sh++) echo '<option value="'.$sh.'"'.(($sh==date('H'))?' selected="selected"':'').'>'.$sh.'시</option>'; ?></select></div>
		<div><input type="text" id="setSubject" name="setSubject" class="i sum" /> <input type="image" src="<?php echo $path; ?>/images/planner.add.memorial.gif" /> <a href="#" onclick="Planner.deleteMemorial($('setTarget').value);"><img src="<?php echo $path; ?>/images/planner.delete.memorial.gif" alt="기념일 삭제" /></a></div>
		<div><textarea id="setContent" rows="3"></textarea></div>
	</div>
	<div id="memorialList"></div>
	<div class="close"><img src="index/images/close.gif" alt="닫기" title="기념일 관리창을 닫습니다." onclick="Effect.Fade('setMemorial'); $('loadBox').style.display='none';" /></div>
</div>
</form>