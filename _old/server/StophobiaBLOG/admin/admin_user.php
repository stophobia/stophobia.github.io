<?php if(!defined('__GRBLOG__')) exit(); ?>

<!-- 멤버 관리 -->
<div id="all">
	<div class="normalTitle">멤버 관리</div>
	<div id="searchBox">
		<div class="option">멤버검색:</div>
		<div style="padding-left: 5px">
		<form id="members" method="post" onsubmit="return user();" action="<?php echo $_SERVER['PHP_SELF']; ?>?admin=15">
		<select name="searchOption">
		<option value="user_id" <?php echo (($searchOption == 'user_id')?'selected="selected"':''); ?>>멤버 ID</option>
		<option value="nickname" <?php echo (($searchOption == 'nickname')?'selected="selected"':''); ?>>이름(닉네임)</option>
		<option value="homepage" <?php echo (($searchOption == 'homepage')?'selected="selected"':''); ?>>홈페이지</option>
		<option value="email" <?php echo (($searchOption == 'email')?'selected="selected"':''); ?>>이메일</option>
		</select>
		<input type="text" class="i" name="searchText" value="<?php echo $searchText; ?>" /><input type="submit" class="s" value="검색하기" />
		</div>
		</form>
	</div>

	<form id="list" method="post" onsubmit="return user();" action="<?php echo $_SERVER['PHP_SELF']; ?>?admin=15">
	<div id="postList">
	<table rules="none" summary="GR Blog Member List" cellpadding="0" cellspacing="0" border="0">
	<caption></caption>
	<colgroup>
	<col style="width: 50px" />
	<col style="width: 50px" />
	<col style="width: 50px" />
	<col />
	<col style="width: 50px" />
	<col style="width: 80px" />
	<col style="width: 45px" />
	<col style="width: 45px" />
	</colgroup>
	<thead>
	<tr>
		<th><a href="#" onclick="selectAll();" title="모두 선택/선택해제 를 원하시면 클릭해 주세요">선택</a></th>
		<th>번호</th>
		<th title="권한 숫자가 높을수록 관리자와 비슷한 권한을 가지게 됩니다.">권한</th>
		<th>이름(닉네임)</th>
		<th title="작성한 글(Post) / 작성한 댓글(Comment)">P/C</th>
		<th>등록날짜</th>
		<th>수정</th>
		<th>삭제</th>
	</tr>
	</thead>
	<tbody>
	<?php
	// 게시물 페이징
	if(!$page) $page = 1;
	$addCountOption = '';
	$pageNum = 20;
	$fromRecord = ($page - 1) * $pageNum;	
	if($searchOption && $searchText)
	{
		$addCountOption = ' where '.$searchOption.' like \'%'.$searchText.'%\'';
	}
	$getTotalNum = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'user'.$addCountOption));
	$totalCount = $getTotalNum[0];
	$getMaxNo = @mysql_fetch_array(mysql_query('select max(uid) from '.$dbFIX.'user'.$addCountOption));
	$maxNo = $getMaxNo[0];
	$arrange = 5000;

	// 범주의 크기를 구분해서 처리
	if($maxNo > $arrange)
	{
		if(!$division) { $division = ceil($maxNo / $arrange); $originDivision = $division; }
		$moreThanMe = ($division - 1) * $arrange;
		$lessThanMe = $division * $arrange;
		$totalPage = ceil($arrange / $pageNum);
		if(!$addCountOption) $addCountOption = ' where uid >= '.$moreThanMe.' and uid <= '.$lessThanMe;
	}
	else
	{
		if(!$division) { $division = 0; $originDivision = 0; }
		if($pageNum) $totalPage = ceil($totalCount / $pageNum);
		else $totalPage = 0;
	}
	if($division) $divisionBy = (($page - 1) * $pageNum) + ($originDivision - $division) * $arrange;
	else $divisionBy = ($page -1) * $pageNum;
	$number = ceil($totalCount - $divisionBy);
	$getUser = @mysql_query('select * from '.$dbFIX.'user'.$addCountOption.' order by uid desc limit '.$fromRecord.', '.$pageNum);
	while($users = mysql_fetch_array($getUser)) { 
		$getUserPost = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'post where writer = \''.$users['user_id'].'\''));
		$getUserComment = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'comment where writer = \''.$users['user_id'].'\''));
		if(!$getUserPost[0]) $getUserPost[0] = 0;
		if(!$getUserComment[0]) $getUserComment[0] = 0;
	?>
	<tr onmouseover="this.style.backgroundColor='#faeaea'" onmouseout="this.style.backgroundColor=''">
		<td><input type="checkbox" name="deleteTargets[]" value="<?php echo $users['uid']; ?>" /></td>
		<td><?php echo $number; ?></td>
		<td><?php echo $users['perm']; ?></td>
		<td><?php echo $users['nickname']; ?></td>
		<td><?php echo $getUserPost[0].' / '.$getUserComment[0]; ?></td>
		<td><span title="<?php echo date('Y년 m월 d일 H시 i분', $users['signdate']); ?>"><?php echo date('Y.m.d', $users['signdate']); ?></span></td>
		<td><a href="admin.php?admin=15&amp;modifyTarget=<?php echo $users['uid']; ?>"><img src="image/icon_modify_user.gif" alt="수정" /></a></td>
		<td><a onclick="delUser(<?php echo $users['uid']; ?>);"><img src="image/icon_delete_user.gif" alt="삭제" /></a></td>
	</tr>
	<?php 
		$number--; 
	} 
	$paging = getPaging($pageNum, $page, $totalPage, 'admin.php?admin=15&amp;page=', $division, $originDivision, $searchOption, $searchText);
	?>
	<tr>
		<td colspan="8" class="bottomBtn">
		<a href="#" onclick="selectAll();" title="화면에 보이는 모든 멤버들을 선택합니다."><img src="image/darkgray/button.select.all.gif" alt="전부선택" /></a> 
		<a href="#" onclick="document.forms['list'].submit();" title="선택한 멤버들을 삭제합니다."><img src="image/darkgray/button.select.delete.gif" alt="선택된 글 삭제" /></a> 
		<a href="admin.php?admin=15" title="멤버 목록을 봅니다."><img src="image/darkgray/button.view.list.gif" alt="목록보기" /></a>
		<?php echo $paging; ?>
		</td>
	</tr>
	</tbody>
	</table>
	</div>
	</form>

	<?php
	if($modifyTarget) { 
		$member = getMemberInfo($modifyTarget);
	?>
	<div id="modifyUser">
	<form id="set" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?admin=15" enctype="multipart/form-data">
	<div><input type="hidden" name="target" value="<?php echo $modifyTarget; ?>" /></div>
	<div id="setting">
	<table rules="none" summary="GR Blog Modify User" cellpadding="0" cellspacing="0" border="0">
	<caption></caption>
	<colgroup>
	<col style="width: 150px" />
	<col />
	</colgroup>
	<tbody>
	<tr>
		<th>항 목</th>
		<th>수 정 값</th>
	</tr>
	<tr>
		<td class="l">권한설정</td>
		<td class="r"><select name="perm">
			<option value="0"<?php echo (($member['perm'] == 0)?' selected="selected"':''); ?>>[권한 0] 손님과 동일한 상태로 설정</option>
			<option value="1"<?php echo (($member['perm'] == 1)?' selected="selected"':''); ?>>[권한 1] 댓글 달 때 내용만 입력하면 되도록 설정 (등록시 기본권한)</option>
			<option value="2"<?php echo (($member['perm'] == 2)?' selected="selected"':''); ?>>[권한 2] 권한1 + 블로그에 포스트(글) 작성 가능</option>
			<option value="3"<?php echo (($member['perm'] == 3)?' selected="selected"':''); ?>>[권한 3] 권한2 + 링크설정, 사진첩설정, 사진올리기 사용 가능</option>
			<option value="4"<?php echo (($member['perm'] == 4)?' selected="selected"':''); ?>>[권한 4] 권한3 + 사진관리, 코멘트관리, 트랙백관리 사용 가능</option>
			<option value="5"<?php echo (($member['perm'] == 5)?' selected="selected"':''); ?>>[권한 5] 권한4 + 전체설정, 글관리, 테마설정 사용 가능</option>
		</select></td>
	</tr>
	<tr>
		<td class="l">아이디</td>
		<td class="r"><input type="text" class="t" name="id" value="<?php echo $member['user_id']; ?>" readonly="readonly" title="아이디는 수정하실 수 없습니다" /> (아이디는 수정하실 수 없습니다)</td>
	</tr>
	<tr>
		<td class="l">비밀번호</td>
		<td class="r"><input type="password" class="t" name="password" value="" title="수정 시 덮어씌워집니다" /> (수정 시 덮어씌워집니다)</td>
	</tr>
	<tr>
		<td class="l">이름(닉네임)</td>
		<td class="r"><input type="text" class="t" name="nickname" value="<?php echo htmlspecialchars(stripslashes($member['nickname'])); ?>" /></td>
	</tr>
	<tr>
		<td class="l">홈페이지</td>
		<td class="r"><input type="text" class="t" name="homepage" value="<?php echo $member['homepage']; ?>" /></td>
	</tr>
	<tr>
		<td class="l">이메일</td>
		<td class="r"><input type="text" class="t" name="email" value="<?php echo $member['email']; ?>" /></td>
	</tr>
	<tr>
		<td class="l">자기 소개</td>
		<td class="r"><input type="text" class="t" name="self_info" value="<?php echo htmlspecialchars(stripslashes($member['self_info'])); ?>" /></td>
	</tr>
	<tr>
		<td colspan="2" class="b">
			<input type="image" src="image/darkgray/button.check.gif" title="설정 수정하기" />
		</td>
	</tr>
	</tbody>
	</table>
	</div>
	</form>	
	</div>
	<?php } ?>

</div>
<!--# 멤버 관리 -->