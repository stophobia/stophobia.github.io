<?php
if(!defined('__GRSHOP__')) exit();

// GR보드 설정 가져오기
$_grcore = $grcore;
include $grboard.'/core.php';
$grcore = $_grcore;

// 게시판 삭제시
if($_GET['deleteTarget']) {
	$core->query('delete from '.$shop->prefix.'bbs where uid = '.$_GET['deleteTarget']);
	$core->alert('등록한 게시판을 목록에서 지웠습니다.', './?menu=2');
}

// 게시판 수정시
if($_GET['modifyTarget']) {
	$modify = $core->getData('select * from '.$shop->prefix.'bbs where uid = '.$_GET['modifyTarget']);
}

// 게시판 등록시
if($_POST['title']) {
	if($_POST['modifyUid']) {
		$core->query('update '.$shop->prefix."bbs set category_uid = '".$_POST['category_uid']."', id = '".$_POST['id']."', title = '".addslashes($_POST['title']).
			"', sub_title = '".addslashes($_POST['sub_title'])."', info = '".addslashes($_POST['info'])."' where uid = ".$_POST['modifyUid']);
		$do = '수정';
	} else {
		$core->query('insert into '.$shop->prefix."bbs set uid = '', category_uid = '".$_POST['category_uid']."', id = '".$_POST['id']."', title = '".addslashes($_POST['title']).
			"', sub_title = '".addslashes($_POST['sub_title'])."', info = '".addslashes($_POST['info'])."'");
		$do = '등록';
	}
	$layout = $core->config['grshop'].'/layout/'.$shop->get('layout_skin');
	$core->query('update '.$dbFIX."board_list set head_file = '{$layout}/head.grboard.php', head_form = '', foot_form = '', foot_file = '{$layout}/foot.grboard.php' where id = '".$_POST['id']."' limit 1");
	$core->alert('게시판을 '.$do.'하였습니다.', './?menu=2');
}

// 페이징 처리
include $grcore.'/class/paging.php';
$paging = new Paging;
?>

<div id="bbsInfo" class="infoBox">
<strong>GR Shop 게시판 등록화면 입니다.</strong><br />
이 곳에서는 먼저 설치하신 GR Board 에서 생성한 게시판들 중, 실제로 GR Shop 에서 사용할 게시판들을<br />
선택하고 몇가지 부가적인 정보들을 입력하는 곳입니다. 이 곳에 등록된 게시판들의 상/하단 디자인은<br />
모두 GR Shop 레이아웃 스킨에서 지정된 스타일로 바뀌게 됩니다.<br />
<br />
실질적인 게시판 설정은 우측 상단의 "GR보드관리" 페이지에 접속하셔서 "게시판관리" 기능을 통해<br />
각종 설정들을 하실 수 있습니다. (이 곳에서는 미리 생성된 게시판들중 어떤 것을 GR Shop 에서 사용할건지만 선택합니다.)<br />
<br />
정리하면, 이 곳은 "이미 생성되어 있는" GR Board 게시판들 중 어떤 게시판들을 사용할 것인지 "선택" 하는 곳입니다.<br />
만약 GR Board 를 설치하신 이후 생성하신 게시판이 없다면, 먼저 "GR보드관리" 를 클릭하셔서 "게시판관리" 를 클릭하신 후<br />
GR Shop 에서 사용할 게시판들부터 먼저 생성하시고 다시 이 곳에 와 주세요.
</div>

<div id="bbsHelp" class="main">

<h2>등록된 게시판 목록	<span class="addition"><a href="<?php echo $grboard; ?>/admin_board.php" onclick="window.open(this.href, '_blank'); return false" title="클릭하시면 새 탭으로 GR보드 게시판 관리화면을 펼칩니다. 이 곳에서 게시판을 생성/수정/삭제 하실 수 있습니다.">[GR보드 게시판 관리]</a></span></h2>

<table rules="none" summary="GR Shop BBS List" cellpadding="0" cellspacing="0" border="0">
<caption></caption>
<thead> 
<tr>
	<th style="width: 150px">대분류</th>
	<th style="width: 150px">게시판 아이디</th>	
	<th style="width: 150px">게시판 제목</th>
	<th style="width: 150px">게시판 부제목</th>
	<th>게시판 설명/안내</th>
	<th style="width: 50px">관리</th>
	<th style="width: 50px">수정</th>
	<th style="width: 50px">삭제</th>
</tr>
</thead>
<tbody>
<?php
$rowNum = 20;
$paging->currentPage = $_GET['page'];
$paging->move = './?menu=2&amp;page=';
if(!$paging->currentPage) $paging->currentPage = 1;
$fromRecord = ($paging->currentPage - 1) * $rowNum;
$paging->totalPage = ceil(end($core->getData('select count(*) from '.$shop->prefix.'bbs')) / $rowNum);
$bbsList = $core->query('select * from '.$shop->prefix.'bbs order by uid desc limit '.$fromRecord.', '.$rowNum);
while($bbs = $core->fetch($bbsList)) {
	$category = stripslashes(@end($core->getData('select name from '.$shop->prefix.'categories where uid = '.$bbs['category_uid'])));
?>
<tr>
	<td><?php echo ($category)?$category:'없음'; ?></td>
	<td><a href="<?php echo $grboard; ?>/board.php?id=<?php echo $bbs['id']; ?>" title="클릭하시면 게시판을 보러 갑니다."><?php echo $bbs['id']; ?></a></td>
	<td><?php echo stripslashes($bbs['title']); ?></td>
	<td><?php echo stripslashes($bbs['sub_title']); ?></td>
	<td><?php echo stripslashes($bbs['info']); ?></td>
	<td><a href="<?php echo $grboard; ?>/admin_board.php?boardID=<?php echo $bbs['id']; ?>" onclick="window.open(this.href, '_blank'); return false" title="새 탭으로 GR보드 관리화면 → 게시판관리 로 이동합니다.">관리</a></td>
	<td><a href="./?menu=2&amp;modifyTarget=<?php echo $bbs['uid']; ?>" title="GR Shop 에 등록된 이 게시판의 정보를 수정합니다. 목록 개수등의 세부적인 게시판 설정은 GR보드 게시판 관리에서 하실 수 있습니다.">수정</a></td>
	<td><a href="#" onclick="BBS.remove(<?php echo $bbs['uid']; ?>); return false" title="GR Shop 에 등록해둔 이 게시판을 목록에서 제거합니다. 실제 게시판은 삭제되지 않으며 게시판을 완전히 제거하고자 하시는 경우 GR보드 게시판 관리에서 삭제해 주시면 됩니다.">삭제</a></td>
</tr>
<?php }
	$pagingForm = $paging->getPaging();
	if($pagingForm) { ?>
<tr>
	<td colspan="8"><?php echo $pagingForm; ?></td>
</tr>
<?php } ?>
</tbody>
</table>

<h2 class="line">게시판 <?php echo (($modify['uid'])?'수정':'등록'); ?>하기</h2>
<form id="addBBS" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?menu=2" onsubmit="return BBS.submit(this);">
<div><input type="hidden" name="modifyUid" value="<?php echo $modify['uid']; ?>" /></div>
<ul class="noneStyle">
	<!-- 게시판 선택 -->
	<li><select name="id">
	<?php
	$boardList = $core->query('select id from '.$dbFIX.'board_list');
	while($board = $core->fetch($boardList)) { 
		$isRegistered = $core->getData('select uid from '.$shop->prefix.'bbs where id = \''.$board['id'].'\'');
		if(!$modify['uid'] && $isRegistered['uid']) continue;
	?>
		<option value="<?php echo $board['id']; ?>"<?php echo ($board['id']==$modify['id'])?' selected="selected"':''; ?>><?php echo $board['id']; ?></option>
	<?php } ?>
	</select> : 게시판 선택. GR Board 관리화면에서 만들어둔 게시판중 사용할 게시판 하나 선택</li>

	<!-- 대분류 지정 -->
	<li><select name="category_uid">
	<option value="">없음</option>
	<?php
	$categoryList = $core->query('select * from '.$shop->prefix.'categories');
	while($cat = $core->fetch($categoryList)) { ?>
		<option value="<?php echo $cat['uid']; ?>"<?php echo ($cat['uid']==$modify['category_uid'])?' selected="selected"':''; ?>><?php echo stripslashes($cat['name']); ?></option>
	<?php } ?>
	</select> : 대분류 지정</li>

	<li><input class="i" type="text" name="title" value="<?php echo stripslashes($modify['title']); ?>" /> : 게시판 제목 (예: 삼성 노트북, HP 프린트, 캐논 DSLR, ...)</li>
	<li><input class="i" type="text" name="sub_title" value="<?php echo stripslashes($modify['sub_title']); ?>" /> : 게시판 부제목 (예: 저렴한 가격에 믿고 구매하세요~!)</li>
	<li><input class="i" type="text" name="info" value="<?php echo stripslashes($modify['info']); ?>" /> : 게시판 설명/안내 (예: 지금 구매하시면 추가 악세사리를 무료로 제공해 드립니다.)</li>
</ul>
<input class="s" type="submit" value="등록하기" />
</form>

</div>