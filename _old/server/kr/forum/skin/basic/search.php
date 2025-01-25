<?php
if(!defined('__GRFORUM__')) exit();

$dir = '..';
$addHead = '<script type="text/javascript" src="../' . $grcore . '/js/jquery.js"></script>';
$addHead .= '<script type="text/javascript" src="search.js"></script>';
$addHead .= '<link rel="stylesheet" href="' . $skin . '/skin.css" type="text/css" title="style" />';
include $skin . '/head.php';

$bbsList = $forum->getBBSList();
?>
<div id="searchPage">

	<div class="navi">
		<div class="info">혹시 회원등록을 하시지 않으셨나요? 회원등록 버튼을 클릭하여 등록해 주세요!</div>
		<div class="menu right">
		<ul>
			<li><a href="<?php echo $dir; ?>/login/">로그인</a></li>
			<li><a href="<?php echo $dir; ?>/register/">회원등록</a></li>
			<li><a href="<?php echo $dir; ?>/search/">통합검색</a></li>
		</ul>
		</div>
	</div>

	<h3>검색어를 입력해 주세요!</h3>
	
	<p>이 곳에서는 "제목" 만을 대상으로 전체 포럼에 대해 검색합니다.<br />
	만약 글 "내용" 등의 상세한 검색을 원하시면 찾으시는 글이 있을 것 같은 게시판으로 이동하셔서<br />
	해당 게시판 하단의 검색 폼을 이용해 주세요.</p>

	<form name="search" method="post" onsubmit="return Search.check(this)" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<div><input type="hidden" name="grboard" value="<?php echo $grboard; ?>" /></div>
	<div class="search center">
		<div><select name="type" class="is">
			<option value="article">글타래 제목을</option>
			<option value="comment">댓글 제목을</option>
		</select>
		<select name="count" class="is">
		<?php for($i=50; $i<501; $i+=50) { ?>
			<option value="<?php echo $i; ?>"><?php echo $i; ?>개씩 검색</option>
		<?php } ?>
		</select>
		<input class="i is" type="text" name="keyword" onkeydown="Search.findIt()" /> <input class="s" type="submit" value="검색" onclick="Search.findIt()" /></div>

		<ul class="selectBBS">
			<li>검색할 게시판 ID 지정: </li>
		<?php
		while($bbs = $core->fetch($bbsList)) { ?>
			<li><input type="checkbox" name="selectBBS[]" id="<?php echo $bbs['id']; ?>" value="<?php echo $bbs['id']; ?>" checked="checked" /> <label for="<?php echo $bbs['id']; ?>" ondblclick="Search.move('<?php echo $bbs['id']; ?>');" title="더블클릭 하시면 이 게시판을 새 창(탭)으로 엽니다."><?php echo $bbs['id']; ?></label></li>
		<?php } ?>
			<li><span onclick="Search.selectAll()">[모두선택]</span></li>
			<li><span onclick="Search.clearAll()">[선택해제]</span></li>
		</ul>
		
	</div>

	<div id="resultSearchList"></div>

	</form>

</div>

<?php include $skin . '/foot.php'; ?>