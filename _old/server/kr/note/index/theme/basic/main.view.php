<div id="goalTop">프로젝트: <select name="chooseProject" onchange="location.href='./?m=view&amp;p='+this.value;">
<option value="">선택하세요</option>
<?php
$getProjects = @mysql_query('select uid, name from '.$view->divide.'projects');
while($lists = @mysql_fetch_array($getProjects)) { ?>
<option value="<?php echo $lists['uid']; ?>"<?php echo (($lists['uid'] == $_GET['p'])?' selected="selected"':''); ?>><?php echo $lists['name']; ?></option>
<?php } ?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;
목표: <select name="chooseGoal" onchange="location.href='./?m=view&amp;p=<?php echo $_GET['p']; ?>&amp;g='+this.value;">
<option value="">선택하세요</option>
<?php
$getGoals = @mysql_query('select uid, codename, version from '.$view->divide.'goals where project_id = '.$_GET['p'].' order by uid desc');
while($goal = @mysql_fetch_array($getGoals)) { ?>
<option value="<?php echo $goal['uid']; ?>"<?php echo (($goal['uid'] == $_GET['g'])?' selected="selected"':''); ?>><?php echo $goal['codename']; ?> (<?php echo $goal['version']; ?>)</option>
<?php } ?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;
열람대상: <select name="chooseType" onchange="location.href='./?m=view&amp;p=<?php echo $_GET['p']; ?>&amp;g=<?php echo $_GET['g']; ?>&amp;t='+this.value;">
<option value=""<?php echo ((!isset($_GET['t']))?' selected="selected"':''); ?>>선택하세요</option>
<option value="6"<?php echo (($_GET['t']==6)?' selected="selected"':''); ?>>모든 티켓들 보기</option>
<option value="5"<?php echo (($_GET['t']==5)?' selected="selected"':''); ?>>내 티켓들 모두보기</option>
<option value="0"<?php echo ((isset($_GET['t']) && $_GET['t']==0)?' selected="selected"':''); ?>>미확인 티켓</option>
<option value="1"<?php echo (($_GET['t']==1)?' selected="selected"':''); ?>>확인된 티켓</option>
<option value="2"<?php echo (($_GET['t']==2)?' selected="selected"':''); ?>>진행중인 티켓</option>
<option value="3"<?php echo (($_GET['t']==3)?' selected="selected"':''); ?>>완료된 티켓</option>
<option value="4"<?php echo (($_GET['t']==4)?' selected="selected"':''); ?>>취소/포기된 티켓</option>
</select></div>
<?php 
// 프로젝트, 목표, 열람대상 선택시
if(isset($_GET['t'])) { ?>
<br /><span class="b">티켓 확인하기</span><br />
<br />
선택하신 프로젝트의 특정 목표에 대한 티켓들을 확인 하실 수 있습니다.<br />
티켓들 중 "미확인 티켓" 들은 "<strong>확인하기</strong>" 을 클릭할 경우 "확인된 티켓" 으로 상태가 변경되며<br />
그 이후 단계들 (진행, 완료, 취소) 은 확인한 사용자만 변경이 가능합니다.<br />
(단, 미확인 티켓중 수신자가 `없음` 일 경우에만 해당됩니다. 수신자가 지정된 경우 해당 대상자만 변경 가능합니다.)<br />
<br />
<?php
@extract($_POST);
@extract($_GET);
if(isset($sortList) && $sortList == 'desc') $sortBy = 'asc';
else $sortBy = 'desc';
if(!$page) $page = 1;
if(!$viewRows) $viewRows = $grNote['ticket']['viewNumTicket'];
$fromRecord = ($page - 1) * $viewRows;

// 검색할 티켓이 있다면
$que = 'select * from '.$view->divide.'ticket'.$p.' where project_uid = '.$p.' and goal_uid = '.$g;
if($_SESSION['userNo'] && $t == 5) $addTCQ .= ' and target = '.$_SESSION['userNo']; 
elseif($t == 6) $addTCQ .= '';
else $addTCQ .= ' and conditions = '.$t;
$que .= $addTCQ;
if(isset($searchText) && !isset($sortList))	{
	if(!$searchOption) $searchOption = 'memo';
	$que .= " and {$searchOption} like '%{$searchText}%' order by uid desc limit {$fromRecord}, {$viewRows}";
	$forPageQue = "select uid from {$view->divide}ticket".$p." where {$searchOption} like '%{$searchText}%'";
}

// 정렬옵션이 있다면
elseif($_GET['sortList']) {
	if($pointSort) $sortTarget = 'writer'; else $sortTarget = 'target';
	$que .= " order by {$sortTarget} {$sortBy} limit {$fromRecord}, {$viewRows}";
	$forPageQue = 'select id from '.$view->divide.'users';
}

// 아무것도 없다면 기본 부름
else {
	$que .= " order by uid desc limit {$fromRecord}, {$viewRows}";
	$forPageQue = 'select id from '.$view->divide.'users';
}
$resultQue = @mysql_query($que);

// 페이징 처리를 위해 결과셋별로 총 목록 수 저장
$totalResult = @mysql_fetch_array(mysql_query('select count(*) from '.$view->divide.'ticket'.$p.' where goal_uid = '.$g.$addTCQ));
$totalCount = $totalResult[0];
?>
<form id="ticketForm" method="post" action="./?m=view" onsubmit="return false">
<div id="ticketTable">
<table rules="none" summary="GR Note Ticket List" cellpadding="0" cellspacing="0" border="0">
<caption></caption>
<colgroup>
<col style="width: 50px" />
<col style="width: 120px" />
<col style="width: 120px" />
<col style="width: 50px" />
<col />
<col style="width: 80px" />
<col style="width: 50px" />
</colgroup>
<thead>
<tr>
	<th>번호</th>
	<th>발행인</th>
	<th>수신자</th>
	<th>상태</th>
	<th>할 일</th>
	<th>상태변경</th>
	<th>삭제</th>
</tr>
</thead>
<tbody>
<?php
$totalTicket = ceil($totalCount - (($page -1) * $viewRows));
while($data = mysql_fetch_array($resultQue)) { ?>
<tr onmouseover="this.style.backgroundColor='#f7f7f7'" onmouseout="this.style.backgroundColor=''">
	<td><?php echo $totalTicket; ?></td>
	<td><?php echo $view->getInfo($data['writer']); ?></td>
	<td><?php echo $view->getInfo($data['target']); ?></td>
	<td><?php echo $view->getCondition($data['conditions']); ?></td>
	<td><?php echo stripslashes($data['memo']); ?></td>
	<td>
	<?php if($_SESSION['userNo'] && ($_SESSION['userNo'] == 1 || $_SESSION['userNo'] == $data['target'] || !$data['target'])) {
		if(!$data['conditions']) { ?><a href="#" onclick="View.changeCondition(1, <?php echo $data['uid']; ?>, <?php echo $p; ?>, <?php echo $g; ?>, <?php echo $t; ?>);" title="선택한 티켓을 자신의 것으로 확인 합니다."><img src="<?php echo $path; ?>/images/view.confirm.gif" alt="확인" /></a>
		<?php } elseif($data['conditions'] > 0) { ?>
		<select name="chooseCondition" onchange="View.changeCondition(this.value, <?php echo $data['uid']; ?>, <?php echo $p; ?>, <?php echo $g; ?>, <?php echo $t; ?>);">
			<option value="1"<?php echo (($data['conditions'] == 1)?' selected="selected"':''); ?>>확인함</option>
			<option value="2"<?php echo (($data['conditions'] == 2)?' selected="selected"':''); ?>>진행중</option>
			<option value="3"<?php echo (($data['conditions'] == 3)?' selected="selected"':''); ?>>완료됨</option>
			<option value="4"<?php echo (($data['conditions'] == 4)?' selected="selected"':''); ?>>취소함</option>
		</select>
		<?php } 
		} else echo '<span style="color: #999">권한없음</span>'; ?>
	</td>
	<td><a href="#" onclick="View.deleteTicket(<?php echo $data['uid']; ?>, <?php echo $p; ?>, <?php echo $g; ?>, <?php echo $t; ?>);" title="선택한 티켓을 삭제합니다."><img src="<?php echo $path; ?>/images/cancel.gif" alt="" /></a></td>
</tr>
	<?php
		$totalTicket--;
} # while
$addPageQue = '';
if($sortList) $addPageQue = '&amp;sortList='.$sortList;
if($pointSort) $addPageQue .= '&amp;pointSort='.$pointSort;
$addPageQue .= '&amp;page=';
$totalPage = ceil($totalCount / $viewRows);
$printPage = $view->getPaging(10, $page, $totalPage, './?m=view&amp;p='.$p.'&amp;g='.$g.'&amp;t='.$t.'&amp;key='.$key.$addPageQue);
if($printPage) { ?>
<tr>
	<td colspan="6" class="paging"><?php echo $printPage; ?></td>
</tr>
<?php } # 페이징 표시 ?>
</tbody>
</table>
</div>
</form>
<?php
// 프로젝트와 목표 미선택시
} else { ?>
<div style="text-align: center; padding: 100px">선택된 프로젝트/목표/열람대상이 없습니다.</div>
<?php } ?>