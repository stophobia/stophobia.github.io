<!-- 전체 설정 -->
<div id="all">

	<div id="setting">
	<div class="msg">
	GR Counter 에서는 <u title="즉, 통계자료들이 ID값에 따라 별도로 관리되어 저장 됩니다.">각각의 ID별로 통계자료를 가지고 있습니다</u>.<br />
	설치시 기본으로 생성되는 index 아이디 뿐만 아니라 좌측 메뉴에서 <strong>ID추가</strong> 를 통해<br />
	다양한 페이지 <span style="color: #999">(혹은 다양한 사이트)</span> 에서 통계자료 수집이 가능 합니다.<br />
	아래의 페이지에서 각각의 아이디별로 통계 수집 이후 총 고유 접속량<span style="color: #999">(uniq visit)</span>,<br />
	총 페이지뷰<span style="color: #999">(page view)</span> 정보를 보실 수 있으며 좌측 메뉴들을 활용하셔서 세부 통계 등을 보실 수 있습니다.
	</div>
	<table rules="none" summary="GR Counter total status" cellpadding="0" cellspacing="0" border="0">
	<caption></caption>
	<colgroup>
	<col style="width: 20%" />
	<col style="width: 35%" />
	<col style="width: 35%" />
	<col style="width: 10%" />
	</colgroup>
	<thead>
	<tr>
		<th>통계 ID</th>
		<th>총 고유접속</th>
		<th>총 페이지뷰</th>
		<th>삭제</th>
	</tr>
	</thead>
	<tbody>
	<?php
	$xDate = $GA->getXTickDate();
	$x2WeekDate = $GA->getXTick2WeekDate();
	$getID = @mysql_query('select * from gc_id');
	while($ids = mysql_fetch_array($getID)) { 
		$uniqView = $GA->getLastWeekCount($ids['name'], 'uniq');
		$pageView = $GA->getLastWeekCount($ids['name'], 'page');
		$top5URL = $GA->getTop5ReferURL($ids['name']);
		$top5Ratio = $GA->getTop5ReferRatio($ids['name']);
		$uniq2WeekView = $GA->getLast2WeekCount($ids['name'], 'uniq');
		$page2WeekView = $GA->getLast2WeekCount($ids['name'], 'page');
	?>
	<tr onmouseover="this.style.backgroundColor='#f5f5f5'" onmouseout="this.style.backgroundColor=''" style="cursor: pointer" onclick="GC.viewDailyStat('<?php echo $ids['name']; ?>');">
		<td class="l"><span class="s"><?php echo $ids['name']; ?></span></td>
		<td class="l"><?php echo number_format($ids['total_uniq_view']); ?></td>
		<td class="l"><?php echo number_format($ids['total_page_view']); ?></td>
		<td class="l"><a href="#" onclick="GC.deleteID(<?php echo $ids['uid']; ?>);"><img src="../image/icon_delete.gif" alt="삭제" /></a></td>
	</tr>
	<tr>
		<td colspan="4" style="height: 0px"><div id="<?php echo $ids['name']; ?>" style="display: none" class="graph">
			<div class="i"><img src="../image/icon_stat_all_line.gif" alt="" /> 최근 일주일간의 고유방문/페이지뷰</div>
			<div><canvas id="canvas_<?php echo $ids['name']; ?>" height="300" width="765"></canvas></div>
			<div class="i"><img src="../image/icon_stat_pie.gif" alt="" /> 리퍼러 URL Top 5</div>
			<div><canvas id="canvas_pie_<?php echo $ids['name']; ?>" height="400" width="765"></canvas></div>
			<div class="i"><img src="../image/icon_stat_all_bar.gif" alt="" /> 지난 2주간 고유방문/페이지뷰 변동</div>
			<div><canvas id="canvas_bar_<?php echo $ids['name']; ?>" height="300" width="765"></canvas></div>
		</div>
		<script type="text/javascript">//<![CDATA[
		var dataset_<?php echo $ids['name']; ?> = {'고유방문자수': [[0,<?php echo $uniqView[6]; ?>], [1,<?php echo $uniqView[5]; ?>], [2,<?php echo $uniqView[4]; ?>], [3,<?php echo $uniqView[3]; ?>], [4,<?php echo $uniqView[2]; ?>], [5,<?php echo $uniqView[1]; ?>], [6,<?php echo $uniqView[0]; ?>]],	'페이지뷰': [[0,<?php echo $pageView[6]; ?>], [1,<?php echo $pageView[5]; ?>], [2,<?php echo $pageView[4]; ?>], [3,<?php echo $pageView[3]; ?>],	[4,<?php echo $pageView[2]; ?>], [5,<?php echo $pageView[1]; ?>], [6,<?php echo $pageView[0]; ?>]]}
		var weeks_<?php echo $ids['name']; ?> = ['<?php echo $xDate[6]; ?>','<?php echo $xDate[5]; ?>','<?php echo $xDate[4]; ?>','<?php echo $xDate[3]; ?>','<?php echo $xDate[2]; ?>','<?php echo $xDate[1]; ?>','<?php echo $xDate[0]; ?>'];
		Draw.lineGraph('<?php echo $ids['name']; ?>', dataset_<?php echo $ids['name']; ?>, weeks_<?php echo $ids['name']; ?>);
		var pieset_<?php echo $ids['name']; ?> = {'<?php echo $top5URL[0]; ?>': [[0, <?php echo $top5Ratio[0]; ?>]],'<?php echo $top5URL[1]; ?>': [[1, <?php echo $top5Ratio[1]; ?>]],'<?php echo $top5URL[2]; ?>': [[2, <?php echo $top5Ratio[2]; ?>]],'<?php echo $top5URL[3]; ?>': [[3, <?php echo $top5Ratio[3]; ?>]],'<?php echo $top5URL[4]; ?>': [[4, <?php echo $top5Ratio[4]; ?>]]}
		var top5_<?php echo $ids['name']; ?> = ['<?php echo $top5URL[0]; ?>', '<?php echo $top5URL[1]; ?>', '<?php echo $top5URL[2]; ?>', '<?php echo $top5URL[3]; ?>', '<?php echo $top5URL[4]; ?>'];
		Draw.pieGraph('<?php echo $ids['name']; ?>', pieset_<?php echo $ids['name']; ?>, top5_<?php echo $ids['name']; ?>);
		var dayset_<?php echo $ids['name']; ?> = {'고유방문자수': [[0,<?php echo $uniq2WeekView[13]; ?>], [1,<?php echo $uniq2WeekView[12]; ?>], [2,<?php echo $uniq2WeekView[11]; ?>], [3,<?php echo $uniq2WeekView[10]; ?>], [4,<?php echo $uniq2WeekView[9]; ?>], [5,<?php echo $uniq2WeekView[8]; ?>], [6,<?php echo $uniq2WeekView[7]; ?>], [7,<?php echo $uniq2WeekView[6]; ?>], [8,<?php echo $uniq2WeekView[5]; ?>], [9,<?php echo $uniq2WeekView[4]; ?>], [10,<?php echo $uniq2WeekView[3]; ?>], [11,<?php echo $uniq2WeekView[2]; ?>], [12,<?php echo $uniq2WeekView[1]; ?>], [13,<?php echo $uniq2WeekView[0]; ?>]],	'페이지뷰': [[0,<?php echo $page2WeekView[13]; ?>], [1,<?php echo $page2WeekView[12]; ?>], [2,<?php echo $page2WeekView[11]; ?>], [3,<?php echo $page2WeekView[10]; ?>],	[4,<?php echo $page2WeekView[9]; ?>], [5,<?php echo $page2WeekView[8]; ?>], [6,<?php echo $page2WeekView[7]; ?>], [7,<?php echo $page2WeekView[6]; ?>], [8,<?php echo $page2WeekView[5]; ?>], [9,<?php echo $page2WeekView[4]; ?>], [10,<?php echo $page2WeekView[3]; ?>], [11,<?php echo $page2WeekView[2]; ?>], [12,<?php echo $page2WeekView[1]; ?>], [13,<?php echo $page2WeekView[0]; ?>]]}
		var days_<?php echo $ids['name']; ?> = ['<?php echo $x2WeekDate[13]; ?>','<?php echo $x2WeekDate[12]; ?>','<?php echo $x2WeekDate[11]; ?>','<?php echo $x2WeekDate[10]; ?>','<?php echo $x2WeekDate[9]; ?>','<?php echo $x2WeekDate[8]; ?>','<?php echo $x2WeekDate[7]; ?>','<?php echo $x2WeekDate[6]; ?>','<?php echo $x2WeekDate[5]; ?>','<?php echo $x2WeekDate[4]; ?>','<?php echo $x2WeekDate[3]; ?>','<?php echo $x2WeekDate[2]; ?>','<?php echo $x2WeekDate[1]; ?>','<?php echo $x2WeekDate[0]; ?>'];
		Draw.barGraph('<?php echo $ids['name']; ?>', dayset_<?php echo $ids['name']; ?>, days_<?php echo $ids['name']; ?>);
		//]]></script>
		</td>
	</tr>
	<?php } ?>
	</tbody>
	</table>
	</div>

</div>
<!--# 전체 설정 -->