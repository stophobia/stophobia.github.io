<?php
if($_GET['selectID']) $id = $_GET['selectID']; else $id = $GS->getDefaultID();
if($_GET['selectYear']) $selectYear = $_GET['selectYear']; else $selectYear = $GG->year;
if($_GET['selectMonth']) $selectMonth = $_GET['selectMonth']; else $selectMonth = $GG->month;
if($_GET['selectDay']) $selectDay = $_GET['selectDay']; else $selectDay = $GG->day;
$monthLimit = ($selectYear == $GG->year)?intval($GG->month):12;
$dayLimit = ($selectYear == $GG->year && $selectMonth == $GG->month)?$GG->day:date('t', mktime(0, 0, 0, $selectMonth, 1, $selectYear));
$hourLimit = ($selectYear == $GG->year && $selectMonth == $GG->month && $selectDay == $GG->day)?$GG->hour:24;
$startYear = $GS->getFirstYear($id);
$getMaxUniq = $GS->getMaxVisitHour($id, $selectYear, $selectMonth, $selectDay, 'uniq');
$getMaxPage = $GS->getMaxVisitHour($id, $selectYear, $selectMonth, $selectDay, 'page');
?>
<!-- 전체 설정 -->
<div id="all">

	<div id="setting">
	<div class="msg">
	시간대별로 통계를 보실 수 있습니다.<br />
	특정 일자를 선택하시면 해당 일자의 시간대별 (1~24시) 접속자수를 확인하실 수 있습니다.<br />
	시간대별 통계자료를 통해서 수집하고 있는 곳의 페이지가 주간에 접속자가 많은지 야간에 접속자가 많은지 알 수 있습니다.
	</div>
	<form id="addID" method="post" onsubmit="return GC.checkAddId();" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<div><input type="hidden" name="addId" value="1" /></div>
	<table rules="none" summary="GR Counter hour status" cellpadding="0" cellspacing="0" border="0">
	<caption></caption>
	<colgroup>
	<col style="width: 190px" />
	<col />
	</colgroup>
	<thead>
	<tr>
		<th>
		<select name="choiceYear" onchange="GC.selectDate('<?php echo $id; ?>', 6, this.value, document.forms['addID'].elements['choiceMonth'].value, document.forms['addID'].elements['choiceDay'].value);">
		<?php for($i=$GG->year; $i>=$startYear; $i--) { ?>
		<option value="<?php echo $i; ?>"<?php echo ($selectYear == $i)?' selected="selected"':''; ?>><?php echo $i; ?>년</option>
		<?php } ?>
		</select>
		<select name="choiceMonth" onchange="GC.selectDate('<?php echo $id; ?>', 6, document.forms['addID'].elements['choiceYear'].value, this.value, document.forms['addID'].elements['choiceDay'].value);">
		<?php for($j=$monthLimit; $j>0; $j--) { ?>
		<option value="<?php echo $j; ?>"<?php echo ($selectMonth == $j)?' selected="selected"':''; ?>><?php echo $j; ?>월</option>
		<?php } ?>
		</select>
		<select name="choiceDay" onchange="GC.selectDate('<?php echo $id; ?>', 6, document.forms['addID'].elements['choiceYear'].value, document.forms['addID'].elements['choiceMonth'].value, this.value);">
		<?php for($d=$dayLimit; $d>0; $d--) { ?>
		<option value="<?php echo $d; ?>"<?php echo ($selectDay == $d)?' selected="selected"':''; ?>><?php echo $d; ?>일</option>
		<?php } ?>
		</select>
		</th>
		<th>
		<select name="choiceID" onchange="GC.changeID(this, 6, <?php echo $selectYear; ?>, <?php echo $selectMonth; ?>, <?php echo $selectDay; ?>);">
		<?php
		$getIDs = @mysql_query('select name from gc_id');
		while($ids = mysql_fetch_array($getIDs)) { ?>
		<option value="<?php echo $ids['name']; ?>"<?php echo ($id == $ids['name'])?' selected="selected"':''; ?>><?php echo $ids['name']; ?></option>
		<?php } ?>
		</select>
		의 그래프 (고유접속/페이지뷰)</th>
	</tr>
	</thead>
	<tbody>
	<?php
	for($n=$hourLimit; $n>0; $n--) { 
		$visitNum = $GS->getVisitNum($id, $selectYear, $selectMonth, $selectDay, $n);
		$ratio = floor(($visitNum['uniqView'] / $getMaxUniq) * 100);
		?>
	<tr>
		<td class="l"><?php echo ($ratio == 100)?'<strong>'.$n.'시</strong>':$n.'시'; ?></td>
		<td class="r"><div style="width: <?php echo ($ratio-15>0)?$ratio:$ratio+10; ?>%;" class="bar"><strong><?php echo $visitNum['uniqView']; ?></strong> / <?php echo $visitNum['pageView']; ?> (<?php echo $ratio; ?>%)</div></td>
	</tr>
	<?php } ?>
	</tbody>
	</table>
	</form>
	</div>

</div>
<!--# 전체 설정 -->