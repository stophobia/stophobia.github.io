<?php if(!defined('__GRBLOG__')) exit(); ?>

<!-- 트랙백 관리 -->
<div id="all">
	<div class="normalTitle">트랙백관리</div>
	<div id="searchBox">
		<div class="option">트랙백검색:</div>
		<div style="padding-left: 5px">
		<form id="post" method="post" onsubmit="return post();" action="<?php echo $_SERVER['PHP_SELF']; ?>?admin=6">
		<select name="searchOption">
		<option value="summary" <?php echo (($searchOption == 'summary')?'selected="selected"':''); ?>>내 용</option>
		<option value="name" <?php echo (($searchOption == 'name')?'selected="selected"':''); ?>>이 름</option>
		<option value="subject" <?php echo (($searchOption == 'subject')?'selected="selected"':''); ?>>제 목</option>
		<option value="url" <?php echo (($searchOption == 'url')?'selected="selected"':''); ?>>트랙백주소</option>
		</select>
		<input type="text" class="i" name="searchText" value="<?php echo $searchText; ?>" /><input type="submit" class="s" value="검색하기" />
		</div>
		</form>
	</div>

	<form id="list" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?admin=6">
	<div id="postList">
	<table rules="none" summary="GR Blog Trackback List" cellpadding="0" cellspacing="0" border="0">
	<caption></caption>
	<colgroup>
	<col style="width: 50px" />
	<col style="width: 100px" />
	<col />
	<col style="width: 40px" />
	<col style="width: 40px" />
	</colgroup>
	<thead>
	<tr>
		<th><a href="#" onclick="selectAll();" title="모두 선택/선택해제 를 원하시면 클릭해 주세요">선택</a></th>
		<th>이름</th>
		<th>제목 / 내용</th>
		<th>수정</th>
		<th>삭제</th>
	</tr>
	</thead>
	<tbody>
	<?php
	// 게시물 페이징
	if(!$_GET['page']) $page = 1; else $page = $_GET['page'];
	if($_GET['division']) $division = $_GET['division'];
	if($_GET['originDivision']) $originDivision = $_GET['originDivision'];
	$pageNum = 10;
	$fromRecord = ($page - 1) * $pageNum;	
	if($searchOption && $searchText) $addCountOption = ' where '.$searchOption.' like \'%'.$searchText.'%\'';
	$getTotalNum = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'trackback'.$addCountOption));
	$totalCount = $getTotalNum[0];
	$getMaxNo = @mysql_fetch_array(mysql_query('select max(uid) from '.$dbFIX.'trackback'.$addCountOption));
	$maxNo = $getMaxNo[0];
	$arrange = 500;

	// 범주의 크기를 구분해서 처리
	if($totalCount > $arrange)
	{
		if(!$division) { $division = ceil($totalCount / $arrange); $originDivision = $division; }
		$moreThanMe = ($division - 1) * $arrange;
		$lessThanMe = $division * $arrange;
		if(($originDivision == $division) && ($maxNo > $lessThanMe)) $lessThanMe = $maxNo;
		$getRealMax = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'trackback where uid > '.$moreThanMe.' and uid <= '.$lessThanMe));
		$totalPage = ceil($getRealMax[0] / $pageNum);
		if(!$addCountOption) $addCountOption = ' where uid >= '.$moreThanMe.' and uid <= '.$lessThanMe;
	}
	else
	{
		if(!$division) { $division = 0; $originDivision = 0; }
		$totalPage = ceil($totalCount / $pageNum);
	}
	$getTrackback = @mysql_query('select * from '.$dbFIX.'trackback'.$addCountOption.' order by uid desc limit '.$fromRecord.', '.$pageNum);
	while($tb = mysql_fetch_array($getTrackback)) { ?>
	<tr>
		<td><input type="checkbox" name="deleteTargets[]" value="<?php echo $tb['uid']; ?>" />
		<input type="hidden" name="postUids[]" value="<?php echo $tb['post_uid']; ?>" /></td>
		<td><a href="<?php echo $tb['url']; ?>" onclick="window.open(this.href, '_blank'); return false;"><?php echo stripslashes($tb['name']); ?></td>
		<td class="s">
		<div><?php echo stripslashes($tb['subject']); ?></div>
		<?php echo stripslashes($tb['summary']); ?>
		</td>
		<td><a href="#" onclick="modifyTrackback(<?php echo $tb['uid']; ?>);" title="트랙백을 수정하고자 하는 경우 이 곳을 눌러주세요."><img src="image/icon_modify_article.gif" alt="수정" /></a></td>
		<td><a href="#" onclick="delTrackback(<?php echo $tb['uid'].', '.$tb['post_uid']; ?>);" title="트랙백을 완전히 삭제하고 싶다면 이 곳을 눌러주세요."><img src="image/icon_delete_article.gif" alt="삭제" /></a></td>
	</tr>
	<?php } 
	$paging = getPaging(10, $page, $totalPage, 'admin.php?admin=6&amp;page=', $division, $originDivision, $searchOption, $searchText);
	?>
	<tr>
		<td colspan="5" class="bottomBtn">총 트랙백수: <?php echo $totalCount.', &nbsp;&nbsp;'.$paging; ?></td>
	</tr>
	<tr>
		<td colspan="5" style="padding: 10px">
		<a href="#" onclick="selectAll();" title="화면에 보이는 모든 글들을 선택합니다."><img src="image/darkgray/button.select.all.gif" alt="전부선택" /></a> 
		<a href="#" onclick="document.forms['list'].submit();" title="선택한 글을 삭제합니다."><img src="image/darkgray/button.select.delete.gif" alt="선택된 글 삭제" /></a> 
		<a href="admin.php?admin=6" title="글 목록을 봅니다."><img src="image/darkgray/button.view.list.gif" alt="목록보기" /></a>
		</td>
	</tr>
	</tbody>
	</table>
	</div>
	</form>
</div>
<!--# 링크 설정 -->