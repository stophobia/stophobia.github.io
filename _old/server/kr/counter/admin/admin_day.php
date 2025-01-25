<?php
if($_GET['selectID']) $id = $_GET['selectID']; else $id = $GS->getDefaultID();
if($_GET['selectYear']) $selectYear = $_GET['selectYear']; else $selectYear = $GG->year;
if($_GET['selectMonth']) $selectMonth = $_GET['selectMonth']; else $selectMonth = $GG->month;
$monthLimit = ($selectYear == $GG->year)?intval($GG->month):12;
$dayLimit = ($selectYear == $GG->year && $selectMonth == $GG->month)?$GG->day:date('t', mktime(0, 0, 0, $selectMonth, 1, $selectYear));
$startYear = $GS->getFirstYear($id);
$getMaxUniq = $GS->getMaxVisitDay($id, $selectYear, $selectMonth, 'uniq');
$getMaxPage = $GS->getMaxVisitDay($id, $selectYear, $selectMonth, 'page');
?>
<!-- 전체 설정 -->
<div id="all">

	<div id="setting">
	<div class="msg">
	일자별로 접속자수 통계를 볼 수 있습니다.<br />
	아래에 연도와 달을 선택하면 그 달의 일자별 고유 접속자수, 페이지뷰 통계를 볼 수 있습니다.<br />
	선택한 달에서 가장 방문자수가 많았던 날은 굵은 글씨로 표시 됩니다.<br />
	</div>
	<form id="addID" method="post" onsubmit="return GC.checkAddId();" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<div><input type="hidden" name="addId" value="1" /></div>
	<table rules="none" summary="GR Counter day status" cellpadding="0" cellspacing="0" border="0">
	<caption></caption>
	<colgroup>
	<col style="width: 150px" />
	<col />
	</colgroup>
	<thead>
	<tr>
		<th>
		<select name="choiceYear" onchange="GC.selectDate('<?php echo $id; ?>', 5, this.value, document.forms['addID'].elements['choiceMonth'].value, false);">
		<?php for($i=$GG->year; $i>=$startYear; $i--) { ?>
		<option value="<?php echo $i; ?>"<?php echo ($selectYear == $i)?' selected="selected"':''; ?>><?php echo $i; ?>년</option>
		<?php } ?>
		</select>
		<select name="choiceMonth" onchange="GC.selectDate('<?php echo $id; ?>', 5, document.forms['addID'].elements['choiceYear'].value, this.value, false);">
		<?php for($j=$monthLimit; $j>0; $j--) { ?>
		<option value="<?php echo $j; ?>"<?php echo ($selectMonth == $j)?' selected="selected"':''; ?>><?php echo $j; ?>월</option>
		<?php } ?>
		</select>
		</th>
		<th>
		<select name="choiceID" onchange="GC.changeID(this, 5, <?php echo $selectYear; ?>, <?php echo $selectMonth; ?>, false);">
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
	for($d=$dayLimit; $d>0; $d--) { 
		$visitNum = $GS->getVisitNum($id, $selectYear, $selectMonth, $d);
		$ratio = floor(($visitNum['uniqView'] / $getMaxUniq) * 100);
		?>
	<tr>
		<td class="l"><?php echo ($ratio == 100)?'<strong>'.$d.'일</strong>':$d.'일'; ?></td>
		<td class="r"><div style="width: <?php echo ($ratio-15>0)?$ratio:$ratio+10; ?>%;" class="bar"><strong><?php echo $visitNum['uniqView']; ?></strong> / <?php echo $visitNum['pageView']; ?> (<?php echo $ratio; ?>%)</div></td>
	</tr>
	<?php } ?>
	</tbody>
	</table>
	</form>
	</div>

</div>
<!--# 전체 설정 -->