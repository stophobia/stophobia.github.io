<?php
if($_GET['selectID']) $id = $_GET['selectID']; else $id = $GS->getDefaultID();
if($_GET['p']) $p = $_GET['p']; else $p = 1;
if($_GET['writePage']) $writePage = $_GET['writePage']; else $writePage = 20;
if($_GET['division']) $division = $_GET['division'];
if($_GET['originDivision']) $originDivision = $_GET['originDivision'];
if($_GET['sort']) { $sort = $_GET['sort']; $sortBy = $_GET['sortBy']; } else { $sort = 'desc'; $sortBy = 'uid'; }
if($_POST['findIP']) $findIP = $_POST['findIP']; elseif($_GET['findIP']) $findIP = $_GET['findIP']; else $findIP = '';
if($findIP) {
	$addQ = ' and ip like \'%'.$findIP.'%\'';
	$addCQ = ' where ip like \'%'.$findIP.'%\'';
} else { $addQ = ''; $addCQ = ''; }
$fromRecord = ($p - 1) * $writePage;
$totalCount = @mysql_fetch_array(mysql_query('select count(*) from gc_ip_'.$id.$addCQ));
$getMaxNo = @mysql_fetch_array(mysql_query('select max(uid) from gc_ip_'.$id.$addCQ));
$maxNo = $getMaxNo[0];
$arrange = 5000;
?>
<!-- 전체 설정 -->
<div id="all">

	<div id="setting">
	<div class="msg">
	접속자들의 IP정보를 볼 수 있습니다. <span style="color: #999">(현재 <?php echo ($findIP)?'"<strong>'.$findIP.'</strong>" 아이피로 ':''; ?><strong><?php echo number_format($totalCount[0]); ?></strong> 개의 IP 가 확인되었음)</span><br />
	중복 수치가 매우 높은 값들은 로봇(robot)일 가능성이 큽니다. (네이버나 야후 등의 검색엔진 로봇들...)<br />
	<strong>중복, 접속시각</strong> 을 각각 클릭하시면 중복 수치가 높은 순서나 최근에 접속한 시간 순으로 정렬해서 보여줍니다.<br />

	<?php if($GG->isExtremeMode) { ?>
	<span style="color: #999; cursor: help" title="중복 여부를 검사하지 않으므로 수집속도가 더 빨라지지만, 대신 DB 저장공간을 조금 더 쓰게 됩니다.">* GR Counter 가 Extreme Mode 로 동작할 경우 중복 여부를 검사하지 않습니다.</span>
	<?php } ?>
	</div>
	<table rules="none" summary="GR Counter ip log list" cellpadding="0" cellspacing="0" border="0">
	<caption></caption>
	<colgroup>
	<col style="width: 15%" />
	<col style="width: 30%" />
	<col />
	<?php if(!$GG->isExtremeMode) { ?><col style="width: 15%" /><?php } ?>
	</colgroup>
	<thead>
	<form id="find" method="post" onsubmit="return GC.checkIP(this);" action="<?php echo $_SERVER['PHP_SELF']; ?>?admin=8">
	<tr>
		<th>
		<select name="choiceID" onchange="GC.changeID(this, 8, false, false, false);">
		<?php
		$getIDs = @mysql_query('select name from gc_id');
		while($ids = mysql_fetch_array($getIDs)) { ?>
		<option value="<?php echo $ids['name']; ?>"<?php echo ($id == $ids['name'])?' selected="selected"':''; ?>><?php echo $ids['name']; ?></option>
		<?php } ?>
		</select>
		</th>
		<th><a href="./?admin=8&amp;selectID=<?php echo $id; ?>&amp;sort=<?php echo ($sort=='asc')?'desc':'asc'; ?>&amp;sortBy=signdate">접속시각</a></th>
		<th>I P <input type="text" name="findIP" class="t" /><input type="submit" value="검색" class="btnS" /></th>
		<?php if(!$GG->isExtremeMode) { ?><th><a href="./?admin=8&amp;selectID=<?php echo $id; ?>&amp;sort=<?php echo ($sort=='asc')?'desc':'asc'; ?>&amp;sortBy=count">중복</a></th><?php } ?>
	</tr>
	</form>
	</thead>
	<tbody>
	<?php
	// 범주의 크기를 구분해서 처리
	if($maxNo > $arrange)
	{
		if(!$division) { $division = ceil($maxNo / $arrange); $originDivision = $division; }
		$moreThanMe = ($division - 1) * $arrange;
		$lessThanMe = $division * $arrange;
		$totalPage = ceil($arrange / $writePage);
	}
	else
	{
		if(!$division) { $division = 0; $originDivision = 0; }
		$moreThanMe = 0;
		$lessThanMe = $arrange;
		if($writePage) $totalPage = ceil($totalCount[0] / $writePage);
		else $totalPage = 0;
	}
	$getPaging = $GC->getPaging(10, $p, (($findIP)?$totalCount[0]:$totalPage), './?admin=8&amp;selectID='.$id.'&amp;findIP='.$findIP.'&amp;sort='.$sort.'&sortBy='.$sortBy.'&amp;writePage='.$writePage.'&amp;originDivision='.$originDivision.'&amp;p=', $division, $originDivision);
	$getIp = @mysql_query('select * from gc_ip_'.$id.' where uid >= '.$moreThanMe.' and uid <= '.$lessThanMe.$addQ.' order by '.$sortBy.' '.$sort.' limit '.$fromRecord.', '.$writePage);
	while($ips = mysql_fetch_array($getIp)) { ?>
	<tr class="hover">
		<td class="l" title="Uid: <?php echo $ips['uid']; ?>"><?php echo $id; ?></td>
		<td class="l" style="font-size: 11px"><?php echo date('Y.m.d H:i:s', $ips['signdate']); ?></td>
		<td class="l"><a href="admin_whois.php?ip=<?php echo $ips['ip']; ?>" onclick="window.open(this.href, 'whois', 'width=600,height=500,menubar=no,scrollbars=yes'); return false" title="후이즈(Whois) 정보를 조회합니다."><?php echo $ips['ip']; ?></a></td>
		<?php if(!$GG->isExtremeMode) { ?><td class="l"><?php echo number_format($ips['count']); ?></td><?php } ?>
	</tr>
	<?php } if($getPaging) { ?>
	<tr>
		<td colspan="<?php echo ($GG->isExtremeMode)?'3':'4'; ?>" class="l"><?php echo $getPaging; ?></td>
	</tr>
	<?php } ?>
	</tbody>
	</table>
	</div>

</div>
<!--# 전체 설정 -->