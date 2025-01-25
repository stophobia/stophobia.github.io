<!-- 리퍼러 통계 -->
<div id="all">

	<div id="setting">
	<div class="msg">
	접속 경로(리퍼러)를 분석해서 분석 대상 페이지에 자주 접속하는 상위 5개 웹사이트를 확인하고,<br />
	접속빈도가 높은 상위 20개 웹사이트 목록을 확인합니다.<br />
	도메인 중에서 도박, 성인 관련 영단어로 조합된 사이트는 광고 목적으로 접속한 봇(bot)들 이므로<br />
	사용중이신 컴퓨터의 안전을 위해 접속하지 마시길 바랍니다.<br />
	</div>
	<div id="statusReferer">
	<?php
	$getID = @mysql_query('select * from gc_id');
	while($ids = mysql_fetch_array($getID)) { 
		$top5URL = $GA->getTop5ReferDomain($ids['name']);
		$top5Ratio = $GA->getTop5DomainRatio($ids['name']);
	?>
		<div class="normalTitle">「 <?php echo $ids['name']; ?> 」리퍼러 통계</div>
		<div id="<?php echo $ids['name']; ?>" class="graph">
			<div class="i"><img src="../image/icon_stat_pie.gif" alt="" /> 「 <?php echo $ids['name']; ?> 」 Top 5 리퍼러 도메인</div>
			<div><canvas id="canvas_pie_<?php echo $ids['name']; ?>" height="300" width="765"></canvas></div>
		</div>
		<ol class="urlList">
		<?php
		$getTop20List = @mysql_query('select url, count from gc_reference_domain where id = \''.$ids['name'].'\' order by count desc limit 20');
		while($top20 = @mysql_fetch_array($getTop20List)) { ?>
			<li><a href="http://<?php echo $top20['url']; ?>" onclick="window.open(this.href, '_blank'); return false" title="클릭하시면 이 사이트를 열어 봅니다."><?php echo $top20['url']; ?></a> (<?php echo number_format($top20['count']); ?>)</li>
		<?php } ?>
		</ol>
		<script type="text/javascript">//<![CDATA[
		var pieset_<?php echo $ids['name']; ?> = {'<?php echo $top5URL[0]; ?>': [[0, <?php echo $top5Ratio[0]; ?>]],'<?php echo $top5URL[1]; ?>': [[1, <?php echo $top5Ratio[1]; ?>]],'<?php echo $top5URL[2]; ?>': [[2, <?php echo $top5Ratio[2]; ?>]],'<?php echo $top5URL[3]; ?>': [[3, <?php echo $top5Ratio[3]; ?>]],'<?php echo $top5URL[4]; ?>': [[4, <?php echo $top5Ratio[4]; ?>]]}
		var top5_<?php echo $ids['name']; ?> = ['<?php echo $top5URL[0]; ?>', '<?php echo $top5URL[1]; ?>', '<?php echo $top5URL[2]; ?>', '<?php echo $top5URL[3]; ?>', '<?php echo $top5URL[4]; ?>'];
		Draw.pieGraph('<?php echo $ids['name']; ?>', pieset_<?php echo $ids['name']; ?>, top5_<?php echo $ids['name']; ?>);
		//]]></script>
	<?php } ?>
	</div>

</div>
<!--# 리퍼러 통계 -->