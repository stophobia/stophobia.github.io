<?php
if($_GET['selectID']) $id = $_GET['selectID']; else $id = $GS->getDefaultID();
if($_GET['p']) $p = $_GET['p']; else $p = 1;
if($_GET['writePage']) $writePage = $_GET['writePage']; else $writePage = 20;
if($_GET['division']) $division = $_GET['division'];
if($_GET['originDivision']) $originDivision = $_GET['originDivision'];
if($_GET['sort']) { $sort = $_GET['sort']; $sortBy = $_GET['sortBy']; } else { $sort = 'desc'; $sortBy = 'uid'; }
if($_POST['findURL']) $findURL = $_POST['findURL']; elseif($_GET['findURL']) $findURL = $_GET['findURL']; else $findURL = '';
$getDirectRef = @mysql_fetch_array(mysql_query('select count from gc_reference_'.$id.' where url = \'\''));
if($findURL) {
	$addQ = ' and url like \'%'.$findURL.'%\'';
	$addCQ = ' where url like \'%'.$findURL.'%\'';
} else { $addQ = ''; $addCQ = ''; }
$fromRecord = ($p - 1) * $writePage;
$totalCount = @mysql_fetch_array(mysql_query('select count(*) from gc_reference_'.$id.$addCQ));
$getMaxNo = @mysql_fetch_array(mysql_query('select max(uid) from gc_reference_'.$id.$addCQ));
$maxNo = $getMaxNo[0];
$arrange = 5000;

// %u 유니코드 디코딩 (phpschool.com illusionist님 팁 참조)
function tostring($text) {
	return iconv('UTF-16LE', 'UHC', chr(hexdec(substr($text[1], 2, 2))).chr(hexdec(substr($text[1], 0, 2))));
}
function urlutfchr($text) {
	return iconv('UHC', 'utf-8', urldecode(preg_replace_callback('/%u([[:alnum:]]{4})/', 'tostring', $text)));
}
?>
<!-- 전체 설정 -->
<div id="all">

	<div id="setting">
	<div class="msg">
	접속자들이 어떤 곳을 경유해서 이 곳에 접속하였는지 알 수 있습니다. <span style="color: #999">(현재 <?php echo ($findURL)?'"<strong>'.$findURL.'</strong>" 검색어로 ':''; ?><strong><?php echo number_format($totalCount[0]); ?></strong>개의 URL이 확인 되었습니다.)</span><br />
	중복 수치가 높은 URL의 경우 검색엔진 주소이거나, 통계를 내고 있는 페이지를 링크건 페이지 주소일 수 있습니다.<br />
	<strong>중복</strong> 을 클릭하시면 중복 수치가 높은 URL 순서로 정렬해서 보여줍니다.<br />

	<?php if($GG->isExtremeMode) { ?>
	<span style="color: #999; cursor: help" title="중복 여부를 검사하지 않으므로 수집속도가 더 빨라지지만, 대신 DB 저장공간을 조금 더 쓰게 됩니다.">※ GR Counter 가 Extreme Mode 로 동작중이므로 중복 여부를 검사하지 않습니다.</span>
	<?php } ?>
	</div>
	<table rules="none" summary="GR Counter referer log list" cellpadding="0" cellspacing="0" border="0" style="table-layout: fixed">
	<caption></caption>
	<colgroup>
	<col style="width: 12%" />
	<col style="width: 30%" />
	<col />
	<?php if(!$GG->isExtremeMode) { ?><col style="width: 13%" /><?php } ?>
	</colgroup>
	<thead>
	<form id="find" method="post" onsubmit="return GC.checkURL(this);" action="<?php echo $_SERVER['PHP_SELF']; ?>?admin=7&amp;selectID=<?php echo $id; ?>">
	<tr>
		<th>
		<select name="choiceID" onchange="GC.changeID(this, 7, false, false, false);">
		<?php
		$getIDs = @mysql_query('select name from gc_id');
		while($ids = mysql_fetch_array($getIDs)) { ?>
		<option value="<?php echo $ids['name']; ?>"<?php echo ($id == $ids['name'])?' selected="selected"':''; ?>><?php echo $ids['name']; ?></option>
		<?php } ?>
		</select>
		</th>
			<th colspan="2">리퍼러 URL <input type="text" name="findURL" class="t" /><input type="submit" value="검색" class="btnS" /></th>
			<?php if(!$GG->isExtremeMode) { ?><th><a href="./?admin=7&amp;selectID=<?php echo $id; ?>&amp;sort=<?php echo ($sort=='asc')?'desc':'asc'; ?>&amp;sortBy=count">중복</a></th><?php } ?>
	</tr>
	</form>
	</thead>
	<tbody>
	<?php if(!$GG->isExtremeMode) { ?>
	<tr>
		<td class="l"><?php echo $id; ?></td>
		<td class="l" colspan="2">직접 방문 혹은 즐겨찾기를 통한 방문</td>
		<td class="l"><?php echo $getDirectRef['count']; ?></td>
	</tr>
	<?php
	}

	// 범주의 크기를 구분해서 처리
	if($totalCount[0] > $arrange)
	{
		if(!$division) { $division = ceil($totalCount[0] / $arrange); $originDivision = $division; }
		if(($originDivision == $division) && ($maxNo > $lessThanMe)) $lessThanMe = $maxNo;
		$moreThanMe = ($division - 1) * $arrange;
		$lessThanMe = $division * $arrange;
		$getRealMax = @mysql_fetch_array(mysql_query('select count(*) from gc_reference_'.$id.' where uid > '.$moreThanMe.' and uid <= '.$lessThanMe));
		$totalPage = ceil($getRealMax[0] / $writePage);
		$rangeQue = 'where uid >= '.$moreThanMe.' and uid <= '.$lessThanMe;
	}
	else
	{
		if(!$division) { $division = 0; $originDivision = 0; }
		$totalPage = ceil($totalCount[0] / $writePage);
		$rangeQue = '';
	}
	$getPaging = $GC->getPaging(10, $p, $totalPage, './?admin=7&amp;selectID='.$id.'&amp;findURL='.$findURL.'&amp;sort='.$sort.'&sortBy='.$sortBy.'&amp;writePage='.$writePage.'&amp;originDivision='.$originDivision.'&amp;p=', $division, $originDivision);
	$getReference = @mysql_query('select * from gc_reference_'.$id.' '.$rangeQue.' '.(($rangeQue)?'and':'where').' url != \'\''.$addQ.' order by '.$sortBy.' '.$sort.' limit '.$fromRecord.', '.$writePage);
	while($ref = mysql_fetch_array($getReference)) { 
		$seo = @parse_url($ref['url']);
		@parse_str($seo['query'], $output);
		if(preg_match('|search.naver.com|i', $seo['host'])) {
			$seoQuery = '<span class="naver" title="네이버 검색을 통해 리퍼러가 유입되었습니다.">';
			if($output['ie'] == 'utf8') $seoQuery .= urldecode($output['query']);
			elseif($output['sm'] == 'tab_jum') $seoQuery .= urlutfchr($output['query']);
			else $seoQuery .= iconv('euc-kr', 'utf-8', urldecode($output['query']));
			$seoQuery .= '</span>';
		}
		elseif(preg_match('|search.daum.net|i', $seo['host'])) {
			$seoQuery = '<span class="daum" title="다음(DAUM) 검색을 통해 리퍼러가 유입되었습니다.">';
			$seoQuery .= iconv('euc-kr', 'utf-8', urldecode($output['q']));
			$seoQuery .= '</span>';
		}
		elseif(preg_match('|paran.com|i', $seo['host'])) {
			$seoQuery = '<span class="paran" title="파란 검색을 통해 리퍼러가 유입되었습니다.">';
			if($output['keyWord']) $seoQuery .= iconv('euc-kr', 'utf-8', urldecode($output['KeyWord']));
			elseif($output['Query']) $seoQuery .= iconv('euc-kr', 'utf-8', urldecode($output['Query']));
			$seoQuery .= '</span>';
		}
		elseif(preg_match('|yahoo.com|i', $seo['host'])) {
			$seoQuery = '<span class="yahoo" title="야후! 검색을 통해 리퍼러가 유입되었습니다.">';
			$decode = urldecode($output['p']);
			if(preg_match('/[a-힣]/usim', $decode)) $seoQuery .= $decode;
			else $seoQuery .= iconv('euc-kr', 'utf-8', $decode);
			$seoQuery .= '</span>';
		}
		elseif(preg_match('|www.google.|i', $seo['host']) && !$output['imgurl']) {
			$seoQuery = '<span class="google" title="구글 검색을 통해 리퍼러가 유입되었습니다.">';
			$seoQuery .= urldecode($output['q']);
			$seoQuery .= '</span>';
		}
		elseif(preg_match('|empas.com|i', $seo['host'])) {
			$seoQuery = '<span class="empas" title="엠파스 검색을 통해 리퍼러가 유입되었습니다.">';
			$seoQuery .= iconv('euc-kr', 'utf-8', urldecode($output['q']));
			$seoQuery .= '</span>';
		}
		elseif(preg_match('|altavista.com|i', $seo['host'])) {
			$seoQuery = '<span class="altavista" title="알타비스타 검색을 통해 리퍼러가 유입되었습니다.">';
			$seoQuery .= urldecode($output['q']);
			$seoQuery .= '</span>';
		}
		elseif(preg_match('|live.com|i', $seo['host']) || preg_match('|livesearch.msn|i', $seo['host'])) {
			$seoQuery = '<span class="live" title="윈도우즈 라이브 검색을 통해 리퍼러가 유입되었습니다.">';
			$seoQuery .= urldecode($output['q']);
			$seoQuery .= '</span>';
		}
		else $seoQuery = '<span class="unknown">검색어 확인불가</span>';
	?>
	<tr class="hover">
		<td class="l" title="Uid: <?php echo $ref['uid']; ?>"><?php echo $id; ?></td>
		<td class="l"><?php echo $seoQuery; ?></td>
		<td class="l"><a href="<?php echo $ref['url']; ?>" onclick="window.open(this.href, '_blank'); return false" title="클릭하시면 URL을 방문해 봅니다."><?php echo $ref['url']; ?></a></td>
		<?php if(!$GG->isExtremeMode) { ?><td class="l"><?php echo number_format($ref['count']); ?></td><?php } ?>
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