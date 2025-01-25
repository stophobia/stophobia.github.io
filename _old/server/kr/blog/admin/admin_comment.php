<?php if(!defined('__GRBLOG__')) exit(); ?>

<!-- 댓글관리 -->
<div id="all">
	<div class="normalTitle">댓글관리</div>
	<div id="searchBox">
		<div class="option">댓글검색:</div>
		<div style="padding-left: 5px">
		<form id="post" method="post" onsubmit="return post();" action="<?php echo $_SERVER['PHP_SELF']; ?>?admin=5">
		<select name="searchOption">
		<option value="content" <?php echo (($searchOption == 'content')?'selected="selected"':''); ?>>내 용</option>
		<option value="name" <?php echo (($searchOption == 'name')?'selected="selected"':''); ?>>이 름</option>
		<option value="email" <?php echo (($searchOption == 'email')?'selected="selected"':''); ?>>이메일</option>
		<option value="homepage" <?php echo (($searchOption == 'homepage')?'selected="selected"':''); ?>>홈페이지</option>
		</select>
		<input type="text" class="i" name="searchText" value="<?php echo $searchText; ?>" /><input type="submit" class="s" value="검색하기" />
		</div>
		</form>
	</div>

	<form id="list" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?admin=5">
	<div id="postList">
	<table rules="none" summary="GR Blog Comment List" cellpadding="0" cellspacing="0" border="0">
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
		<th>내용</th>
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
	$addCountOption = '';
	$pageNum = 10;
	$fromRecord = ($page - 1) * $pageNum;	
	if($searchOption && $searchText) $addCountOption = ' where '.$searchOption.' like \'%'.$searchText.'%\'';
	$getTotalNum = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'comment'.$addCountOption));
	$totalCount = $getTotalNum[0];
	$getMaxNo = @mysql_fetch_array(mysql_query('select max(uid) from '.$dbFIX.'comment'.$addCountOption));
	$maxNo = $getMaxNo[0];
	$arrange = 500;

	// 범주의 크기를 구분해서 처리
	if($maxNo > $arrange)
	{
		if(!$division) { $division = ceil($totalCount / $arrange); $originDivision = $division; }
		$moreThanMe = ($division - 1) * $arrange;
		$lessThanMe = $division * $arrange;
		if(($originDivision == $division) && ($maxNo > $lessThanMe)) $lessThanMe = $maxNo;
		$getRealMax = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'comment where uid > '.$moreThanMe.' and uid <= '.$lessThanMe));
		$totalPage = ceil($getRealMax[0] / $pageNum);
		if(!$addCountOption) $addCountOption = ' where uid >= '.$moreThanMe.' and uid <= '.$lessThanMe;
	}
	else
	{
		if(!$division) { $division = 0; $originDivision = 0; }
		$totalPage = ceil($totalCount / $pageNum);
	}
	$getComment = @mysql_query('select * from '.$dbFIX.'comment'.$addCountOption.' order by uid desc limit '.$fromRecord.', '.$pageNum);
	while($co = mysql_fetch_array($getComment)) { ?>
	<tr>
		<td><input type="checkbox" name="deleteTargets[]" value="<?php echo $co['uid']; ?>" />
		<input type="hidden" name="postUids[]" value="<?php echo $co['post_uid']; ?>" /></td>
		<td title="댓글 작성자의 이름입니다."><?php echo stripslashes($co['name']); ?></td>
		<td class="s">
		<a href="./?p=<?php echo $co['post_uid']; ?>#comment" title="이 댓글이 달린 포스트를 보러 가기"><?php echo strip_tags(stripslashes($co['content'])); ?></a>
		<div><span>(<?php echo (($co['is_secret'])?'비밀댓글':'공개댓글').' / '.date('Y년 m월 d일 H시 i분', $co['signdate']).' / '.$co['ip']; ?>)</span></div>
		</td>
		<td><a href="#" onclick="modifyComment(<?php echo $co['uid']; ?>);" title="댓글을 수정하고자 하는 경우 이 곳을 눌러주세요."><img src="image/icon_modify_article.gif" alt="수정" /></a></td>
		<td><a href="#" onclick="delComment(<?php echo $co['uid'].', '.$co['post_uid']; ?>);" title="댓글을 완전히 삭제하고 싶다면 이 곳을 눌러주세요."><img src="image/icon_delete_article.gif" alt="삭제" /></a></td>
	</tr>
	<?php } 
	$paging = getPaging(10, $page, $totalPage, 'admin.php?admin=5&amp;page=', $division, $originDivision, $searchOption, $searchText);
	?>
	<tr>
		<td colspan="5" class="bottomBtn">총 댓글수: <?php echo $totalCount.', &nbsp;&nbsp;'.$paging; ?></td>
	</tr>
	<tr>
		<td colspan="5" style="padding: 10px">
		<a href="#" onclick="selectAll();" title="화면에 보이는 모든 글들을 선택합니다."><img src="image/darkgray/button.select.all.gif" alt="전부선택" /></a> 
		<a href="#" onclick="document.forms['list'].submit();" title="선택한 글을 삭제합니다."><img src="image/darkgray/button.select.delete.gif" alt="선택된 글 삭제" /></a> 
		<a href="admin.php?admin=5" title="글 목록을 봅니다."><img src="image/darkgray/button.view.list.gif" alt="목록보기" /></a>
		</td>
	</tr>
	</tbody>
	</table>
	</div>
	</form>
</div>
<!--# 링크 설정 -->