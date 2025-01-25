<?php
if($_GET['selectID']) $id = $_GET['selectID']; else $id = $GS->getDefaultID();
if($_GET['selectYear']) $selectYear = $_GET['selectYear']; else $selectYear = $GG->year;
$monthLimit = ($selectYear == $GG->year)?intval($GG->month):12;
$startYear = $GS->getFirstYear($id);
$getMaxUniq = $GS->getMaxVisitMonth($id, $selectYear, 'uniq');
$getMaxPage = $GS->getMaxVisitMonth($id, $selectYear, 'page');
?>
<!-- 전체 설정 -->
<div id="all">

	<div id="setting">
	<div class="msg">
	월별로 접속자수 통계를 볼 수 있습니다.<br />
	아래에 연도 선택하는 부분을 클릭하여 보고자 하는 연도를 클릭하면<br />
	해당 연도의 월별 고유 접속자수, 페이지뷰를 보실 수 있습니다.<br />
	해당 연도에서 가장 많은 고유 접속자수를 기록한 달은 굵은색 글씨로 표기됩니다.<br />
	</div>
	<form id="addID" method="post" onsubmit="return GC.checkAddId();" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<div><input type="hidden" name="addId" value="1" /></div>
	<table rules="none" summary="GR Counter month status" cellpadding="0" cellspacing="0" border="0">
	<caption></caption>
	<colgroup>
	<col style="width: 120px" />
	<col />
	</colgroup>
	<thead>
	<tr>
		<th>
		<select name="choiceYear" onchange="GC.selectDate('<?php echo $id; ?>', 4, this.value, false, false);">
		<?php for($i=$GG->year; $i>=$startYear; $i--) { ?>
		<option value="<?php echo $i; ?>"<?php echo ($selectYear == $i)?' selected="selected"':''; ?>><?php echo $i; ?>년</option>
		<?php } ?>
		</select>
		</th>
		<th>		
		<select name="choiceID" onchange="GC.changeID(this, 4, <?php echo $selectYear; ?>, false, false);">
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
	for($i=$monthLimit; $i>=1; $i--) { 
		$visitNum = $GS->getVisitNum($id, $selectYear, $i);
		$ratio = floor(($visitNum['uniqView'] / $getMaxUniq) * 100);
		?>
	<tr>
		<td class="l"><?php echo ($ratio == 100)?'<strong>'.$i.'월</strong>':$i.'월'; ?></td>
		<td class="r"><div style="width: <?php echo ($ratio-15>0)?$ratio:$ratio+10; ?>%;" class="bar"><strong><?php echo $visitNum['uniqView']; ?></strong> / <?php echo $visitNum['pageView']; ?> (<?php echo $ratio; ?>%)</div></td>
	</tr>
	<?php } ?>
	</tbody>
	</table>
	</form>
	</div>

</div>
<!--# 전체 설정 -->