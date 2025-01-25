<?php if(!defined('__GRBLOG__')) exit(); ?>

<!-- 댓글알리미 -->
<div id="all">
	<div class="normalTitle">댓글알리미</div>
	<div id="searchBox">
		<div class="option">댓글검색:</div>
		<div style="padding-left: 5px">
		<form id="post" method="post" onsubmit="return post();" action="<?php echo $_SERVER['PHP_SELF']; ?>?admin=19">
		<select name="searchOption">
		<option value="post_title" <?php echo (($searchOption == 'post_title')?'selected="selected"':''); ?>>봤던글 제목</option>
		<option value="r1_body" <?php echo (($searchOption == 'r1_body')?'selected="selected"':''); ?>>내가쓴 댓글</option>
		<option value="r2_body" <?php echo (($searchOption == 'r2_body')?'selected="selected"':''); ?>>받은 댓글</option>
		<option value="blog_title" <?php echo (($searchOption == 'blog_title')?'selected="selected"':''); ?>>블로그명</option>
		</select>
		<input type="text" class="i" name="searchText" value="<?php echo $searchText; ?>" /><input type="submit" class="s" value="검색하기" />
		</div>
		</form>
	</div>

	<form id="list" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?admin=19">
	<div id="postList">
	<table rules="none" summary="GR Blog Reply Notify List" cellpadding="0" cellspacing="0" border="0">
	<caption></caption>
	<colgroup>
	<col style="width: 40px" />
	<col style="width: 140px" />
	<col style="width: 200px" />
	<col />
	<col style="width: 40px" />
	</colgroup>
	<thead>
	<tr>
		<th><a href="#" onclick="selectAll();" title="모두 선택/선택해제 를 원하시면 클릭해 주세요">선택</a></th>
		<th>봤던글 제목</th>
		<th>내가쓴 댓글</th>
		<th>받은 댓글</th>
		<th>삭제</th>
	</tr>
	</thead>
	<tbody>
	<?php
	// 게시물 페이징
	if(!$_GET['page']) $page = 1; else $page = $_GET['page'];
	if($_GET['division']) $division = $_GET['division'];
	if($_GET['originDivision']) $originDivision = $_GET['originDivision'];
	$addCountOption = '';
	$pageNum = 10;
	$fromRecord = ($page - 1) * $pageNum;	
	if($searchOption && $searchText) $addCountOption = ' where '.$searchOption.' like \'%'.$searchText.'%\'';
	$getTotalNum = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'reply_catch'.$addCountOption));
	$totalCount = $getTotalNum[0];
	$getMaxNo = @mysql_fetch_array(mysql_query('select max(uid) from '.$dbFIX.'reply_catch'.$addCountOption));
	$maxNo = $getMaxNo[0];
	$arrange = 500;

	// 범주의 크기를 구분해서 처리
	if($maxNo > $arrange)
	{
		if(!$division) { $division = ceil($totalCount / $arrange); $originDivision = $division; }
		$moreThanMe = ($division - 1) * $arrange;
		$lessThanMe = $division * $arrange;
		if(($originDivision == $division) && ($maxNo > $lessThanMe)) $lessThanMe = $maxNo;
		$getRealMax = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'reply_catch where uid > '.$moreThanMe.' and uid <= '.$lessThanMe));
		$totalPage = ceil($getRealMax[0] / $pageNum);
		if(!$addCountOption) $addCountOption = ' where uid >= '.$moreThanMe.' and uid <= '.$lessThanMe;
	}
	else
	{
		if(!$division) { $division = 0; $originDivision = 0; }
		$totalPage = ceil($totalCount / $pageNum);
	}
	$getPost = @mysql_query('select * from '.$dbFIX.'reply_catch'.$addCountOption.' order by uid desc limit '.$fromRecord.', '.$pageNum);
	while($post = mysql_fetch_array($getPost)) { ?>
	<tr>
		<td><input type="checkbox" name="deleteTargets[]" value="<?php echo $post['uid']; ?>" /></td>
		<td title="<?php echo htmlspecialchars(stripslashes($post['blog_title'])); ?>"><?php echo $post['post_title']; ?></td>
		<td><a href="<?php echo $post['r1_url']; ?>" title="내가쓴 댓글 보러가기" style="color: #999"><?php echo stripslashes($post['r1_body']); ?></a></td>
		<td><a href="<?php echo $post['r2_url']; ?>" title="내 댓글에 달린 답글 보러가기"><?php echo stripslashes($post['r2_body']); ?></a></td>
		<td><a href="#" onclick="delReply(<?php echo $post['uid']; ?>);" title="<?php echo date('Y-m-d H:i:s', $post['signdate']); ?>"><img src="image/icon_delete_article.gif" alt="삭제" /></a></td>
	</tr>
	<?php 
		$number--; 
	} 
	$paging = getPaging($pageNum, $page, $totalPage, 'admin.php?admin=19&amp;page=', $division, $originDivision, $searchOption, $searchText);
	?>
	<tr>
		<td colspan="5" class="bottomBtn">총 댓글수: <?php echo $totalCount.', &nbsp;&nbsp;'.$paging; ?></td>
	</tr>
	<tr>
		<td colspan="5" style="padding: 10px">
		<a href="#" onclick="selectAll();" title="화면에 보이는 모든 댓글들을 선택합니다."><img src="image/darkgray/button.select.all.gif" alt="모두선택" /></a> 
		<a href="#" onclick="document.forms['list'].submit();" title="선택한 댓글을 삭제합니다."><img src="image/darkgray/button.select.delete.gif" alt="선택된 글 삭제" /></a> 
		<a href="admin.php?admin=19" title="댓글알림 목록을 봅니다."><img src="image/darkgray/button.view.list.gif" alt="목록보기" /></a>
		</td>
	</tr>
	</tbody>
	</table>
	</div>
	</form>
</div>
<!--# 링크 설정 -->