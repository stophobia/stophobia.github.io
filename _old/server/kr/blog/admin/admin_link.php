<?php if(!defined('__GRBLOG__')) exit(); ?>

<!-- 링크 설정 -->
<div id="all">
	<div class="normalTitle">링크추가</div>
	<div id="addNewLink">
		<form id="link" method="post" onsubmit="return link_add();" action="<?php echo $_SERVER['PHP_SELF']; ?>?admin=3">
		<div><input type="hidden" name="mt" value="<?php echo $modifyTarget; ?>" />
		<input type="hidden" name="addLink" value="1" /></div>
		<div class="option">링크주소(URL):</div>
		<div class="value"><input type="text" name="url" value="<?php echo $modify['url']; ?>" /></div>
		<div class="option">링크이름:</div>
		<div class="value"><input type="text" name="name" value="<?php echo $modify['name']; ?>" /></div>
		<div class="option">링크설명:</div>
		<div class="value"><input type="text" name="info" value="<?php echo $modify['info']; ?>" /></div>
		<div class="btn"><input type="image" src="image/darkgray/button.check.gif" title="링크 설정 추가/수정 하기" /></div>
		</form>
	</div>

	<?php
	// ie 뻗는 문제 패치 by 위쯔님 (http://blog.miniwini.com)
	$getLink = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'link'));
	if ($getLink[0]):
	?>
	<div id="linkList">
	<form id="sorting">
	<table rules="none" summary="GR Blog Link List" cellpadding="0" cellspacing="0" border="0">
	<caption></caption>
	<colgroup>
	<col style="width: 30px" />
	<col />
	<col style="width: 70px" />
	<col style="width: 70px" />
	</colgroup>
	<tbody>
	<?php
	$getLink = @mysql_query('select * from '.$dbFIX.'link order by uid asc');
	while($link = mysql_fetch_array($getLink)) { ?>
	<tr>
		<td><input type="checkbox" name="resort[]" value="<?php echo $link['uid']; ?>" onclick="resort();" title="순서 변경하기" /></td>
		<td><a href="<?php echo $link['url']; ?>" onclick="window.open(this.href, '_blank'); return false;"><?php echo $link['name']; ?></a> <span>(<?php echo $link['info']; ?>)</span></td>
		<td><a href="admin.php?admin=3&amp;modifyTarget=<?php echo $link['uid']; ?>">수정하기</a></td>
		<td><a href="#" onclick="delLink(<?php echo $link['uid']; ?>);">삭제하기</a></td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="4" class="tip"><strong>팁:</strong> 링크 목록 왼편의 체크박스들을 2개 선택하면 그 두개의 순서가 서로 바뀝니다.</td>
	</tr>
	</tbody>
	</table>
	</form>
	</div>
	<?php endif; ?>
</div>
<!--# 링크 설정 -->