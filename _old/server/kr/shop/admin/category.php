<?php
if(!defined('__GRSHOP__')) exit();

// 상품분류 삭제시
if($_GET['deleteTarget']) {
	$core->query('delete from '.$shop->prefix.'categories where uid = '.$_GET['deleteTarget']);
	$core->alert('분류를 삭제하였습니다.', './?menu=1');
}

// 상품분류 수정시
if($_GET['modifyTarget']) {
	$modify = $core->getData('select * from '.$shop->prefix.'categories where uid = '.$_GET['modifyTarget']);
}

// 상품분류 등록시
if($_POST['name']) {
	if($_POST['modifyUid']) $core->query('update '.$shop->prefix."categories set name = '".addslashes($_POST['name'])."', list_order = '".$_POST['list_order']."' where uid = ".$_POST['modifyUid']);
	else $core->query('insert into '.$shop->prefix."categories set uid = '', name = '".addslashes($_POST['name'])."', list_order = '".$_POST['list_order']."'");
	$core->alert('분류명을 등록하였습니다.', './?menu=1');
}
?>

<div id="categoryInfo" class="infoBox">
<strong>GR Shop 상품분류 관리화면입니다.</strong><br />
이 곳에서 GR Shop 의 상품 대분류를 생성하거나 혹은 삭제할 수 있습니다.<br />
판매할 상품을 몇 개의 큰 범주로 분할한다고 했을때 여기서 생성한 대분류가<br />
각각의 범주별 대표 분류가 됩니다.<br />
<br />
예를 들어, 이 곳에서 "컴퓨터/주변기기", "디지털카메라", "전자사전", "MP3/PMP" 이렇게 4가지의 대분류를 생성했다면<br />
각각의 대분류가 하나의 상품군을 대표하게 됩니다.<br />
이 곳에서 생성한 분류는 "게시판등록" 페이지에서 사용할 게시판을 지정할 때 다시 사용됩니다.<br />
판매할 상품의 대분류 등록을 시작합니다.
</div>

<div id="categoryHelp" class="main">

<h2>등록된 대분류 목록</h2>

<table rules="none" summary="GR Shop Big Category List" cellpadding="0" cellspacing="0" border="0">
<caption></caption>
<thead> 
<tr>
	<th style="width: 100px">순위</th>
	<th>분류명</th>	
	<th style="width: 100px">수정</th>
	<th style="width: 100px">삭제</th>
</tr>
</thead>
<tbody>
<?php
$categoryList = $core->query('select * from '.$shop->prefix.'categories');
while($cat = $core->fetch($categoryList)) {
?>
<tr>
	<td><?php echo $cat['list_order']; ?></td>
	<td><?php echo stripslashes($cat['name']); ?></td>
	<td><a href="./?menu=1&amp;modifyTarget=<?php echo $cat['uid']; ?>">수정</a></td>
	<td><a href="#" onclick="Category.remove(<?php echo $cat['uid']; ?>); return false">삭제</a></td>
</tr>
<?php } ?>
</tbody>
</table>

<h2 class="line">대분류 <?php echo (($modify['uid'])?'수정':'생성'); ?>하기</h2>
<form id="addCategory" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?menu=1" onsubmit="return Category.submit(this);">
<div><input type="hidden" name="modifyUid" value="<?php echo $modify['uid']; ?>" /></div>
<ul class="noneStyle">
	<li><select name="list_order">
	<?php for($i=1; $i<100; $i++) { ?><option value="<?php echo $i; ?>"<?php echo ($i==$modify['list_order'])?' selected="selected"':''; ?>><?php echo $i; ?></option><?php } ?>
	</select> : 순위지정. 숫자가 작을수록 먼저 호출됩니다.</li>
	<li><input class="i" type="text" name="name" value="<?php echo stripslashes($modify['name']); ?>" /> : 분류명 지정. (예: 컴퓨터/주변기기, MP3/PMP, 전자사전/노트북, ...)</li>
</ul>
<input class="s" type="submit" value="등록하기" />
</form>

</div>