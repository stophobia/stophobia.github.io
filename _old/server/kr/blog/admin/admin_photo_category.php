<?php if(!defined('__GRBLOG__')) exit(); ?>

<!-- 사진 분류 -->
<div id="all">
	<div class="normalTitle">사진 분류</div>

	<div id="postList">
	<table rules="none" summary="GR Blog Photo Category" cellpadding="0" cellspacing="0" border="0">
	<caption></caption>
	<colgroup>
	<col style="width: 75px" />
	<col />
	<col style="width: 95px" />
	<col style="width: 45px" />
	<col style="width: 45px" />
	</colgroup>
	<thead>
	<tr>
		<th>분류번호</th>
		<th>분류명</th>
		<th>보유량</th>
		<th>수정</th>
		<th>삭제</th>
	</tr>
	</thead>
	<tbody>
	<form id="addCategory" method="post" onsubmit="return chkName();" action="<?php echo $_SERVER['PHP_SELF']; ?>?admin=14">
	<tr>
		<td class="categoryAdd">추가</td>
		<td class="categoryAdd"><input type="text" class="i" name="addName" /></td>
		<td class="categoryAdd" colspan="3"><input type="submit" class="s" value="확인" /></td>
	</tr>
	</form>
	<tr><td colspan="5">&nbsp;</td></tr>
	<?php
	$getCategorys = @mysql_query('select * from '.$dbFIX.'photo_category');
	$loop = 1;
	while($ca = @mysql_fetch_array($getCategorys)) {
		$getCaNum = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'photo where category = '.$ca['uid']));
	?>
	<form id="photoCategory<?php echo $loop; ?>" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?admin=14">
	<div><input type="hidden" name="modifyTarget" value="<?php echo $ca['uid']; ?>" /></div>
	<tr>
		<td><?php echo $ca['uid']; ?></td>
		<td class="s"><input type="text" name="name" value="<?php echo $ca['name']; ?>" /></td>
		<td><?php echo $getCaNum[0]; ?></td>
		<td><a href="#" onclick="forms['photoCategory<?php echo $loop; ?>'].submit();">수정</a></td>
		<td><a href="admin.php?admin=14&amp;deleteTarget=<?php echo $ca['uid']; ?>">삭제</a></td>
	</tr>
	</form>
	<?php $loop++; } ?>
	</tbody>
	</table>
	</div>
</div>
<!--# 링크 설정 -->