<?php if(!defined('__GRNOTE__')) exit(); ?>

<span class="b">멤버 목록보기</span><br />
<br />
아래 GR노트에 등록된 멤버들의 목록을 보고 해당 멤버의 정보를 수정하고자 하실 경우에<br />
해당 멤버의 아이디/닉네임 을 클릭하시면 됩니다.<br />
<br />
<?php			
@extract($_POST);
@extract($_GET);
if(isset($sortList) && $sortList == 'desc') $sortBy = 'asc';
else $sortBy = 'desc';
if(!$page) $page = 1;
if(!$viewRows) $viewRows = 15;
$fromRecord = ($page - 1) * $viewRows;
if($selectMember) $member = @mysql_fetch_array(mysql_query('select * from '.$admin->divide.'users where uid = '.$selectMember));

// 검색할 멤버이름이 있다면
$que = "select uid, id, nickname, make_time, level, point from {$admin->divide}users";
if(isset($searchText) && !isset($sortList))	{
	if(!$searchOption) $searchOption = 'id';
	$que .= " where {$searchOption} like '%{$searchText}%' order by uid desc limit {$fromRecord}, {$viewRows}";
	$forPageQue = "select uid from {$admin->divide}users where {$searchOption} like '%{$searchText}%'";
}

// 정렬옵션이 있다면
elseif($_GET['sortList']) {
	if($pointSort) $sortTarget = 'point'; else $sortTarget = 'id';
	$que .= " order by {$sortTarget} {$sortBy} limit {$fromRecord}, {$viewRows}";
	$forPageQue = "select id from {$admin->divide}users";
}

// 아무것도 없다면 기본 부름
else {
	$que .= " order by uid desc limit {$fromRecord}, {$viewRows}";
	$forPageQue = 'select id from '.$admin->divide.'users';
}
$resultQue = @mysql_query($que) or $admin->alert('멤버 목록을 가져오는데 실패했습니다.');
			
// 페이징 처리를 위해 결과셋별로 총 목록 수 저장
$totalResult = @mysql_fetch_array(mysql_query('select count(id) as id from '.$admin->divide.'users'));
$totalCount = $totalResult['id'];
?>
<form id="searchMember" method="post" action="./?m=member&amp;key=<?php echo $_GET['key']; ?>">
<div id="memberTable">
<table rules="none" summary="GR Note Member List" cellpadding="0" cellspacing="0" border="0">
<caption></caption>
<thead>
<tr>
	<th>번호</th>
	<th>아이디 / 닉네임</th>
	<th>홈페이지</th>
	<th>레벨(포인트)</th>
	<th>생성일</th>
	<th>삭제</th>
</tr>
</thead>
<tbody>
<?php
$totalMember = ceil($totalCount - (($page -1) * $viewRows));
while($data = mysql_fetch_array($resultQue)) { ?>
<tr onmouseover="this.style.backgroundColor='#f7f7f7'" onmouseout="this.style.backgroundColor=''">
	<td><?php echo $totalMember; ?></td>
	<td><a href="#" onclick="Admin.modifyMemberWindow(<?php echo $data['uid']; ?>, <?php echo (($selectMember)?'1':'0'); ?>, event);" title="클릭하시면 멤버정보를 수정 할 수 있습니다."><?php echo $data['id'].' / '.$data['nickname']; ?></a></td>
	<td><?php echo $data['homepage']; ?></td>
	<td><?php echo $data['level'].' ('.$data['point'].')'; ?></td>
	<td><?php echo date('Y.m.d H:i', $data['make_time']); ?></td>
	<td><a href="#" onclick="Admin.deleteMember(<?php echo $data['uid']; ?>, '<?php echo $data['id']; ?>');" title="선택한 멤버를 삭제합니다."><img src="images/member.delete.gif" alt="멤버 삭제" /> 삭제하기</a></td>
</tr>
	<?php
		$totalMember--;
} # while
$addPageQue = '';
if($sortList) $addPageQue = '&amp;sortList='.$sortList;
if($pointSort) $addPageQue .= '&amp;pointSort='.$pointSort;
$addPageQue .= '&amp;page=';
$totalPage = ceil($totalCount / $viewRows);
$printPage = $admin->getPaging($viewRows, $page, $totalPage, './?m=member&amp;key='.$_GET['key'].$addPageQue);
if($printPage) { ?>
<tr>
	<td colspan="6" class="paging"><?php echo $printPage; ?></td>
</tr>
<?php } # 페이징 표시 ?>
<tr style="height: 50px">
	<td colspan="6">
	<a href="./?m=member&amp;key=<?php echo $_GET['key']; ?>&amp;sortList=<?php echo $sortBy; ?>&amp;pointSort=1" title="멤버 포인트를 기준으로 순차/역순 정렬합니다"><img src="images/member.sort.gif" alt="" /> 포인트순 정렬</a>&nbsp;&nbsp;
	<a href="./?m=member&amp;key=<?php echo $_GET['key']; ?>&amp;sortList=<?php echo $sortBy; ?>" title="멤버 ID 를 알파벳대로 순차/역순 정렬합니다"><img src="images/member.sort.gif" alt="" /> 알파벳순 정렬</a>&nbsp;&nbsp;
	<img src="images/member.find.gif" alt="" /> 멤버 검색 
	<select name="searchOption">
	<option value="">검색조건</option>
	<option value="id">아이디</option>
	<option value="nickname">닉네임</option>
	<option value="realname">실명</option>
	<option value="email">이메일</option>
	<option value="homepage">홈페이지</option>
	<option value="level">레벨</option>
	</select>
	<input type="text" name="searchText" class="input" title="검색조건에 맞는 값을 입력하세요" value="<?php if(isset($searchText)) echo $searchText; ?>" />
	을 <input type="text" name="viewRows" class="input" title="검색결과를 몇개씩 보실 것인지 입력하세요" value="<?php echo $viewRows; ?>" size="3" maxlength="3" /> 명씩
	<input type="image" src="images/member.search.gif" title="검색 합니다" />
	</td>
</tr>
</tbody>
</table>
</div>
</form>
<?php if($selectMember) { ?>
<!-- 멤버 수정창 -->
<div id="memberModify" style="top: <?php echo $_GET['y']; ?>px; left: <?php echo $_GET['x']; ?>px">
<form id="modifyMember" method="post" action="./?m=member&amp;key=<?php echo $_GET['key']; ?>" onsubmit="return Admin.modifyingMember(<?php echo $_GET['x']; ?>, <?php echo $_GET['y']; ?>);">
<div><input type="hidden" name="modifyUid" value="<?php echo $selectMember; ?>" /></div>
<span class="b">멤버수정</span><br /><br />
<table rules="none" summary="GR Note Modify Member" cellpadding="0" cellspacing="0" border="0">
<caption></caption>
<colgroup>
<col style="width: 120px" />
<col />
</colgroup>
<thead>
<tr>
	<th class="list">항목</th>
	<th class="list">값</th>
</tr>
</thead>
<tbody>
<tr>
	<td>아이디</td>
	<td class="list"><input type="text" name="id" value="<?php echo $member['id']; ?>" readonly="readonly" /> ※ 아이디는 수정되지 않습니다.</td>
</tr>
<tr>
	<td>비밀번호</td>
	<td class="list"><input type="password" name="password" /> ※ 입력시 수정됩니다. (비울시 그대로 유지)</td>
</tr>
<tr>
	<td>이름</td>
	<td class="list"><input type="text" name="nickname" value="<?php echo $member['nickname']; ?>" /></td>
</tr>
<tr>
	<td>이메일</td>
	<td class="list"><input type="text" name="email" value="<?php echo $member['email']; ?>" /></td>
</tr>
<tr>
	<td>홈페이지</td>
	<td class="list"><input type="text" name="homepage" value="<?php echo $member['homepage']; ?>" /></td>
</tr>
<tr>
	<td>레벨</td>
	<td class="list">
	<select name="level">
	<?php for($i=1; $i<100; $i++) { ?>
	<option value="<?php echo $i; ?>"<?php echo (($member['level']==$i)?' selected="selected"':''); ?>><?php echo $i; ?></option>
	<?php } ?>
	</select>
	</td>
</tr>
<tr>
	<td>포인트</td>
	<td class="list"><input type="text" name="point" value="<?php echo $member['point']; ?>" /></td>
</tr>
<tr style="height: 70px">
	<td>자기소개</td>
	<td class="list"><textarea name="selfInfo" rows="2" cols="45"><?php echo $member['self_info']; ?></textarea></td>
</tr>
<tr style="height: 50px">
	<td colspan="2">
	<input type="image" src="images/member.modify.submit.gif" title="<?php echo $member['id']; ?>님의 정보를 수정합니다." />
	</td>
</tr>
</tbody>
</table>
</form>
<div id="closeWindow"><a href="#" onclick="Admin.closeWindow();"><img src="images/button.close.window.gif" alt="닫기" /></a></div>
</div>
<script type="text/javascript">//<![CDATA[
new Draggable('memberModify', {revert:false});
//></script>
<?php } ?>
<div id="loadBox" style="display: none"></div>