<?php
if(!defined('__GRSHOP__')) exit();

// GR보드 설정 가져오기
$_grcore = $grcore;
include $grboard.'/core.php';
$grcore = $_grcore;

// 매출 결산
if($_GET['_year']) $_year = $_GET['_year']; else $_year = date('Y');
if($_GET['_month']) $_month = $_GET['_month']; else $_month = date('n');
$statusList = $core->query('select * from '.$shop->prefix."accounts where year = '{$_year}' and month = '{$_month}' order by uid asc");
?>

<div id="statusInfo" class="infoBox">
<strong>GR Shop 상세 매출 결산 화면입니다.</strong><br />
이 곳에서 선택하신 년도 / 월을 기준으로 한 달간의 매출 통계를 보실 수 있습니다.<br />
통계는 일자별로 나타나며, 만약 하루에 10 건의 거래가 있었다면 해당 거래내역이 합산되지 않고<br />
각각 따로 출력됩니다.<br />
<br />
이 곳의 매출 통계는 고객이 실제 입금한 금액을 기준으로 합니다.<br />
그러나 카드 결제시 발생되는 수수료 차익이나 기타 재무통계시 필요한 고려사항들은<br />
반영되지 않으므로 매출 추이를 확인하는 참고용으로만 활용하시기 바랍니다.<br />
(수수료, 세금, 원가 등을 제외한 순이익 등의 데이터는 이 곳에서 확인하실 수 없습니다.)<br />
</div>

<div id="statusHelp" class="main">

<h2>매출 통계보기 
	<span class="addition">
		<select name="chooseYear" onchange="Status.setYear(this, '<?php echo $_month; ?>');">
			<option value="2009"<?php echo ($_year==2009)?' selected="selected"':''; ?>>2009년</option>
			<option value="2010"<?php echo ($_year==2010)?' selected="selected"':''; ?>>2010년</option>
		</select>
		<select name="chooseMonth" onchange="Status.setMonth(this, '<?php echo $_year; ?>');">
		<?php for($m=1; $m<13; $m++) { ?>
			<option value="<?php echo $m; ?>"<?php echo ($m==$_month)?' selected="selected"':''; ?>><?php echo $m; ?>월</option>
		<?php } #for ?>
		</select>  
		<a href="./?menu=3" title="클릭하시면 주문관리 페이지로 다시 돌아갑니다">[주문관리로 돌아가기]</a>
	</span>
</h2>

<table rules="none" summary="GR Shop Status List" cellpadding="0" cellspacing="0" border="0">
<caption></caption>
<thead> 
<tr>
	<th style="width: 100px">년도</th>
	<th style="width: 80px">월</th>
	<th style="width: 80px">주차</th>
	<th style="width: 80px">일</th>
	<th>매출액</th>
</tr>
</thead>
<tbody>
<?php
$loop = 1;
$totalCost = 0;
while($status = $core->fetch($statusList)) {
	$bg = ($loop % 2 == 0) ? ' class="bg"':'';
?>
<tr>
	<td<?php echo $bg; ?>><?php echo $status['year']; ?></td>
	<td<?php echo $bg; ?>><?php echo $status['month']; ?></td>
	<td<?php echo $bg; ?>><?php echo $status['week']; ?></td>
	<td<?php echo $bg; ?>><?php echo $status['day']; ?></td>
	<td<?php echo $bg; ?>><?php echo number_format($status['cost']); ?>원</td>
</tr>
<?php 
	$totalCost += $status['cost'];
	$loop++;
} #while ?>
<tr>
	<td colspan="5" class="paging"><?php echo $_year; ?>년 <?php echo $_month; ?>월 총 매출액: <strong><?php echo number_format($totalCost); ?></strong>원</td>
</tr>
</tbody>
</table>

</div>