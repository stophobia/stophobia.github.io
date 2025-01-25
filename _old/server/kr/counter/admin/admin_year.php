<?php
if($_GET['selectID']) $id = $_GET['selectID']; else $id = $GS->getDefaultID();
$startYear = $GS->getFirstYear($id);
$getMaxUniq = $GS->getMaxVisitYear($id, $startYear, 'uniq');
$getMaxPage = $GS->getMaxVisitYear($id, $startYear, 'page');
?>
<!-- 전체 설정 -->
<div id="all">

	<div id="setting">
	<div class="msg">
	연도별로 고유 방문자수와 페이지뷰를 집계해 보여주는 곳입니다.<br />
	그래프는 고유 방문자수를 기준으로 집계된 자료중 가장 많은 방문이 기록된 연도의 값을 100%로 잡은 후<br />
	나머지 연도들의 고유 방문자수를 상대적으로 비교해 퍼센티지를 준 모습 입니다.<br />
	가장 많은 방문을 기록한 연도는 아래 그래프에서 연도가 굵은 글씨로 표기되어 있습니다.
	</div>
	<form id="addID" method="post" onsubmit="return GC.checkAddId();" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<div><input type="hidden" name="addId" value="1" /></div>
	<table rules="none" summary="GR Counter year status" cellpadding="0" cellspacing="0" border="0">
	<caption></caption>
	<colgroup>
	<col style="width: 90px" />
	<col />
	</colgroup>
	<thead>
	<tr>
		<th>연도</th>
		<th>
		<select name="choiceID" onchange="GC.changeID(this, 3, false, false, false);">
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
	for($i=$GG->year; $i>=$startYear; $i--) { 
		$visitNum = $GS->getVisitNum($id, $i);
		$ratio = floor(($visitNum['uniqView'] / $getMaxUniq) * 100);
		?>
	<tr>
		<td class="l"><?php echo ($ratio == 100)?'<strong>'.$i.'년</strong>':$i.'년'; ?></td>
		<td class="r"><div style="width: <?php echo ($ratio-20>0)?$ratio:$ratio+10; ?>%;" class="bar"><?php echo $visitNum['uniqView']; ?> / <?php echo $visitNum['pageView']; ?> (<?php echo $ratio; ?>%)</div></td>
	</tr>
	<?php } ?>
	</tbody>
	</table>
	</form>
	</div>

</div>
<!--# 전체 설정 -->