<?php 
if(!defined('__GRBLOG__')) exit(); 

// 변수 처리
if(!$_GET['page']) $page = 1; else $page = $_GET['page'];
if($_GET['division']) $division = $_GET['division'];
if($_GET['originDivision']) $originDivision = $_GET['originDivision'];
if(!$_GET['pageNum']) $pageNum = 10; else $pageNum = $_GET['pageNum'];
?>

<!-- 사진 관리 -->
<div id="all">
	<div class="normalTitle">사진관리</div>
	<div id="searchBox">
		<div class="option">사진검색:</div>
		<div style="padding-left: 5px">
		<form id="post" method="post" onsubmit="return post();" action="<?php echo $_SERVER['PHP_SELF']; ?>?admin=13">
		<select name="chooseCategory" onchange="location.href='admin.php?admin=13&category='+this.value;">
		<?php
		$getCategory = @mysql_query('select * from '.$dbFIX.'photo_category');
		while($selectCa = @mysql_fetch_array($getCategory)) { ?>
		<option value="<?php echo $selectCa['uid']; ?>"<?php echo (($selectCa['uid']==$category)?' selected="selected"':''); ?>><?php echo stripslashes($selectCa['name']); ?></option>
		<?php } ?>
		</select>

		<select name="searchOption">
		<option value="title" <?php echo (($searchOption == 'title')?'selected="selected"':''); ?>>제 목</option>
		<option value="content" <?php echo (($searchOption == 'content')?'selected="selected"':''); ?>>내 용</option>
		</select>

		<select name="pageNumOption" onchange="location.href='admin.php?admin=13&pageNum='+this.value;">
		<?php
		for($pn=10; $pn<100; $pn+=10) { ?>
		<option value="<?php echo $pn; ?>" <?php echo (($pageNum == $pn)?'selected="selected"':''); ?>><?php echo $pn; ?> 개씩 펼침</option>
		<?php } ?>
		</select>

		<input type="text" class="i" name="searchText" value="<?php echo $searchText; ?>" /><input type="submit" class="s" value="검색하기" />
		</div>
		</form>
	</div>

	<form id="list" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?admin=13">
	<div id="postList">
	<div><input type="hidden" name="isChangeCategory" value="0" />
	<input type="hidden" name="nowPage" value="<?php echo $page; ?>" />
	<input type="hidden" name="nowOriginDivision" value="<?php echo $originDivision; ?>" />
	<input type="hidden" name="nowDivision" value="<?php echo $division; ?>" />
	</div>
	<table rules="none" summary="GR Blog Post List" cellpadding="0" cellspacing="0" border="0">
	<caption></caption>
	<colgroup>
	<col style="width: 50px" />
	<col style="width: 90px" />
	<col />
	<col style="width: 50px" />
	<col style="width: 80px" />
	<col style="width: 45px" />
	</colgroup>
	<thead>
	<tr>
		<th><a href="#" onclick="selectAll();" title="모두 선택/선택해제 를 원하시면 클릭해 주세요">선택</a></th>
		<th>사진</th>
		<th>제목</th>
		<th>코멘트</th>
		<th>작성날짜</th>
		<th>수정</th>
	</tr>
	</thead>
	<tbody>
	<?php
	// 게시물 페이징
	$addCountOption = '';	
	$fromRecord = ($page - 1) * $pageNum;	
	if($searchOption && $searchText) {
		$addCountOption = ' where '.$searchOption.' like \'%'.$searchText.'%\'';
	} elseif($category) {
		$addCountOption = ' where category = '.$category;
	}
	$getTotalNum = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'photo'.$addCountOption));
	$totalCount = $getTotalNum[0];
	$getMaxNo = @mysql_fetch_array(mysql_query('select max(uid) from '.$dbFIX.'photo'.$addCountOption));
	$maxNo = $getMaxNo[0];
	$arrange = 500;

	// 범주의 크기를 구분해서 처리
	if($maxNo > $arrange)
	{
		if(!$division) { $division = ceil($totalCount / $arrange); $originDivision = $division; }
		$moreThanMe = ($division - 1) * $arrange;
		$lessThanMe = $division * $arrange;
		if(($originDivision == $division) && ($maxNo > $lessThanMe)) $lessThanMe = $maxNo;
		$getRealMax = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'photo where uid > '.$moreThanMe.' and uid <= '.$lessThanMe));
		$totalPage = ceil($getRealMax[0] / $pageNum);
		if(!$addCountOption) $addCountOption = ' where uid >= '.$moreThanMe.' and uid <= '.$lessThanMe;
	}
	else
	{
		if(!$division) { $division = 0; $originDivision = 0; }
		$totalPage = ceil($totalCount / $pageNum);
	}
	$getPost = @mysql_query('select * from '.$dbFIX.'photo'.$addCountOption.' order by uid desc limit '.$fromRecord.', '.$pageNum);
	while($post = mysql_fetch_array($getPost)) { 
		$ca = @mysql_fetch_array(mysql_query('select name from '.$dbFIX.'photo_category where uid = '.$post['category']));
	?>
	<tr>
		<td><input type="checkbox" name="deleteTargets[]" value="<?php echo $post['uid']; ?>" /></td>
		<td><a href="<?php echo getHome().'/photo/?photoNo='.
			$post['uid']; ?>" onclick="window.open(this.href, '_blank', 'menubar=no,resizable=yes,toolbar=no,scrollbars=yes'); return false">
			<img src="phpThumb/phpThumb.php?src=../<?php echo $post['file_route']; ?>&amp;w=80&amp;h=50&amp;q=100&amp;fltr[]=usm|99|0.5|3" alt="preview" /></a></td>
		<td class="s"><a href="admin.php?admin=13&amp;category=<?php echo $post['category']; ?>" style="color: #999">[<?php echo $ca['name']; ?>]</a>
			<a href="<?php echo getHome().'/photo/?photoNo='.
			$post['uid']; ?>" onclick="window.open(this.href, '_blank', 'menubar=no,resizable=yes,toolbar=no,scrollbars=yes'); return false">
			<?php echo stripslashes($post['title']); ?></a>
		</td>
		<td><?php echo $post['comment']; ?></td>
		<td><span title="<?php echo date('Y년 m월 d일 H시 i분', $post['signdate']); ?>"><?php echo date('Y.m.d', $post['signdate']); ?></span></td>
		<td><a href="admin.php?admin=10&amp;modifyTarget=<?php echo $post['uid']; ?>"><img src="image/icon_modify_photo.gif" alt="수정" /></a></td>
	</tr>
	<?php 
		$number--; 
	} 
	$paging = getPaging($pageNum, $page, $totalPage, 'admin.php?admin=13&amp;category='.$category.'&amp;page=', $division, $originDivision, $searchOption, $searchText);
	?>
	<tr>
		<td colspan="6" class="bottomBtn">총 사진수: <?php echo $totalCount.', &nbsp;&nbsp;'.$paging; ?></td>
	</tr>
	<tr>
		<td colspan="6" style="padding: 10px">
		<a href="#" onclick="selectAll();" title="화면에 보이는 모든 사진들을 선택합니다."><img src="image/darkgray/button.select.all.gif" alt="전부선택" /></a> 
		<a href="#" onclick="deletePhoto();" title="선택한 사진들을 삭제합니다."><img src="image/darkgray/button.select.delete.gif" alt="선택된 글 삭제" /></a> 
		<a href="admin.php?admin=13" title="글 목록을 봅니다."><img src="image/darkgray/button.view.list.gif" alt="목록보기" /></a>
		</td>
	</tr>
	</tbody>
	</table>

	<div id="changeCategory">
		<div><strong>일괄 분류 변경:</strong>
			선택한 사진들의 분류를 
			<select name="changeCategory">
			<?php
			$getChCat = @mysql_query('select * from '.$dbFIX.'photo_category');
			while($selCat = @mysql_fetch_array($getChCat)) { ?>
			<option value="<?php echo $selCat['uid']; ?>"><?php echo stripslashes($selCat['name']); ?></option>
			<?php } ?>
			</select>
			로 <a href="#" onclick="changePhotoCategory();" title="선택한 사진들의 분류를 변경합니다.">변경하기!</a>
		</div>
	</div>

	</div>
	</form>
</div>
<!--# 링크 설정 -->