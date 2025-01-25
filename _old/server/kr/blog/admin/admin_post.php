<?php if(!defined('__GRBLOG__')) exit(); ?>

<!-- 글관리 -->
<div id="all">
	<div class="normalTitle">글관리</div>
	<div id="searchBox">
		<div class="option">글검색:</div>
		<div style="padding-left: 5px">
		<form id="post" method="post" onsubmit="return post();" action="<?php echo $_SERVER['PHP_SELF']; ?>?admin=4">
		<select name="searchOption">
		<option value="subject" <?php echo (($searchOption == 'subject')?'selected="selected"':''); ?>>제 목</option>
		<option value="content" <?php echo (($searchOption == 'content')?'selected="selected"':''); ?>>내 용</option>
		<option value="tag" <?php echo (($searchOption == 'tag')?'selected="selected"':''); ?>>태 그</option>
		<option value="writer" <?php echo (($searchOption == 'writer')?'selected="selected"':''); ?>>작성자ID</option>
		</select>
		<input type="text" class="i" name="searchText" value="<?php echo $searchText; ?>" /><input type="submit" class="s" value="검색하기" />
		</div>
		</form>
	</div>

	<form id="list" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?admin=4">
	<div id="postList">
	<table rules="none" summary="GR Blog Post List" cellpadding="0" cellspacing="0" border="0">
	<caption></caption>
	<colgroup>
	<col style="width: 50px" />
	<col style="width: 50px" />
	<col style="width: 50px" />
	<col />
	<col style="width: 100px" />
	<col style="width: 50px" />
	<col style="width: 80px" />
	<col style="width: 45px" />
	<col style="width: 45px" />
	</colgroup>
	<thead>
	<tr>
		<th><a href="#" onclick="selectAll();" title="모두 선택/선택해제 를 원하시면 클릭해 주세요">선택</a></th>
		<th>번호</th>
		<th title="클릭하시면 공개글/비밀글만 따로 정렬해서 보여드립니다."><?php echo (($open)?
		'<a href="admin.php?admin=4&amp;open=0">':
		'<a href="admin.php?admin=4&amp;open=1">');?>공개</a></th>
		<th>제목</th>
		<th title="작성자가 관리자 혹은 멤버일 때 글쓴이 ID 가 나타납니다.">작성자</th>
		<th title="Comment(댓글) / Trackback(엮인글)">C/T</th>
		<th>작성날짜</th>
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
	if($searchOption && $searchText)
	{
		$addCountOption = ' where '.$searchOption.' like \'%'.$searchText.'%\'';
		if(isset($open))
		{
			if($open) $addCountOption .= ' and post_condition = \'1\''; 
			else $addCountOption .= ' and post_condition = \'0\'';
		}
	}
	else
	{
		if(isset($open))
		{
			if($open) $addCountOption .= ' where post_condition = \'1\''; 
			else $addCountOption .= ' where post_condition = \'0\'';
		}
	}
	$getTotalNum = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'post'.$addCountOption));
	$totalCount = $getTotalNum[0];
	$getMaxNo = @mysql_fetch_array(mysql_query('select max(uid) from '.$dbFIX.'post'.$addCountOption));
	$maxNo = $getMaxNo[0];
	$arrange = 500;

	// 범주의 크기를 구분해서 처리
	if($totalCount > $arrange)
	{
		if(!$division) { $division = ceil($totalCount / $arrange); $originDivision = $division; }
		$moreThanMe = ($division - 1) * $arrange;
		$lessThanMe = $division * $arrange;
		if(($originDivision == $division) && ($maxNo > $lessThanMe)) $lessThanMe = $maxNo;
		$getRealMax = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'post where uid > '.$moreThanMe.' and uid <= '.$lessThanMe.$addCountOption));
		$totalPage = ceil($getRealMax[0] / $pageNum);
		if(!$addCountOption) $addCountOption = ' where uid >= '.$moreThanMe.' and uid <= '.$lessThanMe;
	}
	else
	{
		if(!$division) { $division = 0; $originDivision = 0; }
		$totalPage = ceil($totalCount / $pageNum);
	}
	$getPost = @mysql_query('select * from '.$dbFIX.'post'.$addCountOption.' order by uid desc limit '.$fromRecord.', '.$pageNum);
	while($post = mysql_fetch_array($getPost)) { ?>
	<tr>
		<td><input type="checkbox" name="deleteTargets[]" value="<?php echo $post['uid']; ?>" />
		<input type="hidden" name="postUids[]" value="<?php echo $post['post_uid']; ?>" /></td>
		<td title="게시물 고유 번호입니다."><?php echo $post['uid']; ?></td>
		<td title="공개글인지 비공개글인지 확인합니다. 작성중에 저장하기를 누르셨을 경우, 비밀글이 됩니다."><?php 
			echo (($post['post_condition'])?
			'<a href="admin.php?admin=4&amp;open=1"><span class="o">공개</span></a>':
			'<a href="admin.php?admin=4&amp;open=0"><span class="s">비밀</span></a>'); ?></td>
		<td class="s" title="글 제목이 나타납니다. 클릭할 경우 해당 글을 봅니다."><a href="<?php echo getHome().'?p='.$post['uid']; ?>"><?php echo stripslashes($post['subject']); ?></a></td>
		<td title="글쓴이를 봅니다."><?php echo $post['writer']; ?></td>
		<td title="댓글수 / 트랙백(엮인글)수 ...와 같은 형태입니다."><?php echo $post['comment_count'].' / '.$post['trackback_count']; ?></td>
		<td><span title="<?php echo date('Y년 m월 d일 H시 i분', $post['signdate']); ?>"><?php echo date('Y.m.d', $post['signdate']); ?></span></td>
		<td><a href="admin.php?admin=2&amp;modifyTarget=<?php echo $post['uid']; ?>" title="글을 수정하고자 하는 경우 이 곳을 눌러주세요."><img src="image/icon_modify_article.gif" alt="수정" /></a></td>
		<td><a href="#" onclick="delPost(<?php echo $post['uid']; ?>);" title="글을 완전히 삭제하고 싶다면 이 곳을 눌러주세요."><img src="image/icon_delete_article.gif" alt="삭제" /></a></td>
	</tr>
	<?php 
		$number--; 
	} 
	$paging = getPaging($pageNum, $page, $totalPage, 'admin.php?admin=4&amp;open='.$open.'&amp;page=', $division, $originDivision, $searchOption, $searchText);
	?>
	<tr>
		<td colspan="9" class="bottomBtn">총 글수: <?php echo $totalCount.', &nbsp;&nbsp;'.$paging; ?></td>
	</tr>
	<tr>
		<td colspan="9" style="padding: 10px">
		<a href="#" onclick="selectAll();" title="화면에 보이는 모든 글들을 선택합니다."><img src="image/darkgray/button.select.all.gif" alt="모두선택" /></a> 
		<a href="#" onclick="document.forms['list'].submit();" title="선택한 글을 삭제합니다."><img src="image/darkgray/button.select.delete.gif" alt="선택된 글 삭제" /></a> 
		<a href="admin.php?admin=4" title="글 목록을 봅니다."><img src="image/darkgray/button.view.list.gif" alt="목록보기" /></a>
		</td>
	</tr>
	</tbody>
	</table>
	</div>
	</form>
</div>
<!--# 링크 설정 -->