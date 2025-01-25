<?php 
if(!defined('__GRFORUM__')) exit();

// 경로 처리
function catPath($parent=0, $core, $dbFIX, $result, $count=0) {
	$get = $core->getData('select name, parent from ' . $dbFIX . 'category where uid = ' . $parent);
	if(!$get['parent']) {
		arsort($result);
		return $result;
	}
	$result[$count][$parent] = stripslashes($get['name']);
	return catPath($get['parent'], $core, $dbFIX, $result, ++$count);
}

// 부모 분류의 글과 글타래 카운팅 업데이트 처리
function setParentCount($parent, $diffPost, $diffReply, $childPost, $childReply, $bbsID, $bbsNo, $core, $dbFIX) {
	$isExist = $core->getData('select uid, parent from ' . $dbFIX . 'category where uid = ' . $parent . ' limit 1');
	if(!$isExist['uid']) return;
	else {
		$parentStatus = $core->getData('select uid from ' . $dbFIX . 'status where cat_uid = ' . $parent . ' limit 1');
		if($parentStatus['uid']) {
			$core->query('update ' . $dbFIX . 'status set post_count = post_count + ' . $diffPost . ', reply_count = reply_count + ' . $diffReply . ', latest_id = \'' . $bbsID . '\', latest_no = ' . $bbsNo . ' where uid = ' . $parentStatus['uid']);
		} else {
			$core->query('insert into ' . $dbFIX . 'status set uid = \'\', cat_uid = \'' . $parent . '\', post_count = ' . $childPost . ', reply_count = ' . $childReply . ', latest_id = \'' . $bbsID . '\', latest_no = ' . $bbsNo);
		}
		return setParentCount($isExist['parent'], $diffPost, $diffReply, $childPost, $childReply, $bbsID, $bbsNo, $core, $dbFIX);
	}
}

// 현재 분류의 글과 글타래 카운팅 처리
function setCount($statusUid, $diffPost, $diffReply, $myPost, $myReply, $catUid, $parent, $setBBS, $core, $dbFIX, $bbsFIX) {
	$latest = $core->getData('select no from ' . $bbsFIX . 'bbs_' . $setBBS . ' order by no desc limit 1');
	if($statusUid) {
		$core->query('update ' . $dbFIX . 'status set post_count = ' . $myPost . ', reply_count = ' . $myReply . ' where uid = ' . $statusUid);
	} else {
		$core->query('insert into ' . $dbFIX . 'status set uid = \'\', cat_uid = \'' . $catUid . '\', post_count = ' . $myPost . ', reply_count = ' . $myReply . ', latest_id = \'' . $setBBS . '\', latest_no = ' . $latest['no']);
	}
	setParentCount($parent, $diffPost, $diffReply, $myPost, $myReply, $setBBS, $latest['no'], $core, $dbFIX);
}

// 분류 삭제
if($_GET['deleteTarget']) {
	$target = $_GET['deleteTarget'];
	$isBBS = $core->getData('select parent, bbs_id from ' . $dbFIX . 'category where uid = ' . $target);
	if($isBBS['bbs_id']) {
		$status = $core->getData('select * from ' . $dbFIX . 'status where cat_uid = ' . $target . ' limit 1');
		$getOld = $core->getData('select uid, post_count, reply_count from ' . $dbFIX . 'status where cat_uid = ' . $target . ' limit 1');
		$diffPostCount = 0 - $getOld['post_count'];
		$diffReplyCount = 0 - $getOld['reply_count'];
		setCount($getOld['uid'], $diffPostCount, $diffReplyCount, 0, 0, $target, $isBBS['parent'], $isBBS['bbs_id'], $core, $dbFIX, $bbsFIX);
	}
	$core->query('delete from ' . $dbFIX . 'category where uid = ' . $target . ' or parent = ' . $target);
	$core->query('delete from ' . $dbFIX . 'status where cat_uid ' . $target . ' limit 1');
	$core->alert('선택하신 분류를 하위 분류들까지 포함해서 모두 삭제하였습니다.', './?m=' . $m);
}

// 분류 추가 or 수정
if($_POST['name']) {
	$name = addslashes($_POST['name']);
	$description = addslashes($_POST['description']);
	$target = $_POST['modifyTarget'];
	$setParent = $_POST['setParent'];
	$setBBS = $_POST['setBBS'];
	$setPublic = $_POST['setPublic'];
	$setOutlink = (!$setBBS) ? $_POST['setOutlink'] : '';
	$setDepth = 0;

	// 부모 분류를 가질 경우
	if($setParent) {
		$getParent = $core->getData('select depth from ' . $dbFIX . 'category where uid = ' . $setParent);
		$setDepth = $getParent['depth'] + 1;
		$core->query('update ' . $dbFIX . 'category set depth = ' . $setDepth . ' where parent = ' . $setParent);
	}
	
	// 수정
	if($target) {
		
		// 기존에 bbs_id 가 있다가 이번에 없앤 경우 count 처리
		$old = $core->getData('select bbs_id from ' . $dbFIX . 'category where uid = ' . $target . ' limit 1');
		if($old['bbs_id'] && !$setBBS) {
			$getOld = $core->getData('select uid, post_count, reply_count from ' . $dbFIX . 'status where cat_uid = ' . $target . ' limit 1');
			$diffPostCount = 0 - $getOld['post_count'];
			$diffReplyCount = 0 - $getOld['reply_count'];
			setCount($getOld['uid'], $diffPostCount, $diffReplyCount, 0, 0, $target, $setParent, $setBBS, $core, $dbFIX, $bbsFIX);
		}

		// 이 분류가 게시판일 경우 글/글타래 통계관련 선처리
		if($setBBS) {
			$prev = $core->getData('select uid, post_count, reply_count from ' . $dbFIX . 'status where cat_uid = ' . $target);
			if(!$prev['uid']) {
				$prev['post_count'] = 0;
				$prev['reply_count'] = 0;
			}
			$nowPostCount = $core->getData('select count(*) from ' . $bbsFIX . 'bbs_' . $setBBS);
			$nowReplyCount = $core->getData('select count(*) from ' . $bbsFIX . 'comment_' . $setBBS);
			$diffPost = $nowPostCount[0] - $prev['post_count'];
			$diffReply = $nowReplyCount[0] - $prev['reply_count'];
			setCount($prev['uid'], $diffPost, $diffReply, $nowPostCount[0], $nowReplyCount[0], $target, $setParent, $setBBS, $core, $dbFIX, $bbsFIX);
		}

		// 일반 수정 처리
		$core->query('update ' . $dbFIX . 'category set name = \'' . $name . '\', depth = ' . $setDepth . ', parent = ' . $setParent . ', bbs_id = \'' . $setBBS . '\', description = \'' . $description . '\', is_public = ' . $setPublic . ', out_link = \'' . $setOutlink . '\' where uid = ' . $target);
		if(!$setPublic) $core->query('update ' . $dbFIX . 'category set is_public = 0 where parent = ' . $target); 
		$msg = '수정';

	// 추가
	} else {

		// 일반 추가 처리
		$core->query('insert into ' . $dbFIX . 'category set uid = \'\', name = \'' . $name . '\', depth = ' . $setDepth . ', parent = ' . $setParent .
			', bbs_id = \'' . $setBBS . '\', align = 0, description = \'' . $description . '\', is_public = ' . $setPublic . ', out_link = \'' . $setOutlink . '\'');
		$nextSeq = $core->insertId();
		$core->query('update ' . $dbFIX . 'category set align = ' . $nextSeq . ' where uid = ' . $nextSeq);
		$msg = '추가';

		// 이 분류가 게시판일 경우 글/글타래 통계관련 선처리 & 게시판 상/하단 수정
		if($setBBS) {
			$postCount = $core->getData('select count(*) from ' . $bbsFIX . 'bbs_' . $setBBS);
			$replyCount = $core->getData('select count(*) from ' . $bbsFIX . 'comment_' . $setBBS);
			setCount(0, $postCount[0], $replyCount[0], $postCount[0], $replyCount[0], $nextSeq, $setParent, $setBBS, $core, $dbFIX, $bbsFIX);

			$layoutSkin = $core->getData('select var from ' . $dbFIX . 'view where opt = \'layout_skin\' limit 1');
			$grforum = str_replace('admin', '', str_replace('/'.end(explode('/', $_SERVER['REQUEST_URI'])), '', $_SERVER['REQUEST_URI']));
			$layoutPath = '..' . $grforum . 'skin/' . $layoutSkin['var'];
			
			$core->query('update ' . $bbsFIX . 'board_list set head_file = \'' . $layoutPath . '/head.board.php\', foot_file = \'' . $layoutPath . '/foot.board.php\', head_form = \'\', foot_form = \'\' where id = \'' . $setBBS . '\'');
		}
	}

	$core->alert('분류를 ' . $msg . ' 하였습니다.', './?m=' . $m);
}

// 위로 올리기 클릭시
if($_GET['align']) {
	$target = $_GET['target'];
	$align = $_GET['align'];
	$myAlign = $_GET['myAlign'];
	$myParent = $_GET['myParent'];
	if($align == 'u') {
		$prevCat = $core->getData('select uid, align from ' . $dbFIX . 'category where parent = ' . $myParent . ' and align < ' . $myAlign . ' order by align desc limit 1');
		if($prevCat['align']) {
			$core->query('update ' . $dbFIX . 'category set align = ' . $prevCat['align'] . ' where uid = ' . $target);
			$core->query('update ' . $dbFIX . 'category set align = ' . $myAlign . ' where uid = ' . $prevCat['uid']);
		}
	} else {
		$nextCat = $core->getData('select uid, align from ' . $dbFIX . 'category where parent = ' . $myParent . ' and align > ' . $myAlign . ' order by uid asc limit 1');
		if($nextCat['align']) {
			$core->query('update ' . $dbFIX . 'category set align = ' . $nextCat['align'] . ' where uid = ' . $target);
			$core->query('update ' . $dbFIX . 'category set align = ' . $myAlign . ' where uid = ' . $nextCat['uid']);
		}
	}

	$core->move('./?m=' . $m . '&parent=' . $myParent);
}

// 분류 수정 클릭시
$msg = '추가';
if($_GET['modify']) {
	$mod = $core->getData('select * from ' . $dbFIX . 'category where uid = ' . $_GET['modify']);
	$msg = '수정';
}

$v = $_GET['v'];
$parent = ($_GET['parent']) ? $_GET['parent'] : $_POST['parent'];
if(!$v) $v = 1;
if(!$depth) $depth = 0;
if(!$parent) $parent = 0;

// 도움말 보기	
if($v == 2) { ?>
<h3>GR Forum 분류관리를 시작합니다!</h3>
분류는 포럼형 사이트에서 가장 중요하다고 할 수 있는 작업입니다.<br />
주제별로 분류를 정하고, 해당 분류 속에 다시 어떤 분류 (혹은 게시판) 가 속할지 잘 정하는 것만으로도<br />
구조적이고 체계적인 포럼을 만들 수 있습니다.<br />
<br />

<h3>일반적인 분류는 어떤 구조를 가지나요?</h3>
포럼 마다 조금씩 상이하지만 대체적으로는 아래와 같은 구조를 가집니다.<br />
<p><img src="images/category_info_1.gif" alt="분류 설명 1" /></p>
위 그림에서도 알 수 있지만 포럼에서 "분류" 라는 개념은 곧 주제별로 폴더를 만들고<br />
또 정리하는 것과 비슷하다고 할 수 있습니다.<br />
<br />
GR Forum 에서는 이 처럼 다단 분류를 지원하며, 어떤 분류를 클릭했을 때 다시 그 분류의<br />
하위 분류들 목록이 나타나게 하실 수도 있고, 혹은 어떤 분류명을 클릭했을 때 바로<br />
게시판으로 이동하도록 할 수 도 있습니다.<br />
<br />
처음에는 적응이 조금 힘드실 수 도 있습니다. 그러나 천천히, 곳곳에 배치된 설명들을 보시면서<br />
하나씩 해 보시면 금방 근사한 포럼을 제작하실 수 있으실 겁니다.<br />
<br />

<h3>미리 준비해야 할 것은 무엇인가요?</h3>
GR Forum 에서 사용할 게시판들을 미리 GR Board 관리화면에서 생성해 주셔야 합니다.<br />
또한 게시판을 만드실 때 해당 게시판 스킨이 GR Forum 용으로 제작된 것인지, 그리고 지금 사용하시는<br />
GR Forum 레이아웃 스킨과 어울리는 스킨인지 꼭 확인해 보시고 지정하시길 바랍니다.<br />
<br />
분류를 만드시다가 "이 분류명을 클릭하면 abc 라는 게시판으로 이동시켜야 겠다." 고 마음 먹으셨다면<br />
그 전에 GR Board 관리화면에서 ID 가 abc 인 게시판을 미리 생성해 주세요~.<br />
<br />

<div class="help">
	<input class="s green" type="button" value="도움이 되었습니다. 분류 설정을 해볼께요." onclick="location.href='./?m=<?php echo $m; ?>&amp;v=1';" />
	&nbsp;&nbsp;&nbsp;&nbsp;
	<input class="s" type="button" value="아직도 잘 모르겠어요. 문의글을 남겨볼래요." onclick="location.href='http://sirini.net/grboard/board.php?id=qna';" />
</div>
<?php } // 도움말 보기 끝

// 분류 설정화면
else { ?>

<h3>분류 목록 보기</h3>

<div class="path"> <a href="./?m=<?php echo $m; ?>&amp;parent=0" title="처음 대분류 목록으로 갑니다">처음목록</a> 
<?php
$path = catPath($parent, $core, $dbFIX, array(array()));
for($i=count($path)-1; $i>=0; $i--) {
	list($p, $n) = each($path[$i]);
	echo ' 》<a href="./?m=' . $m . '&amp;parent=' . $p . '">' . $n . '</a> ';
}
?>
</div>
	
<?php
$list = $core->query('select * from ' . $dbFIX . 'category where parent = \'' . $parent . '\' order by align asc');
while($cat = $core->fetch($list)) { 
	$cat['name'] = stripslashes($cat['name']);
	$cat['description'] = stripslashes($cat['description']);
	if($cat['bbs_id']) $cat['name'] = '<a href="' . $grboard . '/board.php?id=' . $cat['bbs_id'] . '" title="클릭 시 게시판으로 이동합니다">' . $cat['name'] . '</a>';
	elseif($cat['out_link']) $cat['name'] = '<a href="' . $cat['out_link'] . '">' . $cat['name'] . '</a>';
	else $cat['name'] = '<a href="./?m=' . $m . '&amp;parent=' . $cat['uid'] . '">' . $cat['name'] . '</a>';
?>

<div class="forum">
	<div class="category"><?php echo $cat['name']; ?> (공개: <?php echo ($cat['is_public']) ? 'O' : '<span class="red">X</span>'; ?>)</div>
	<div class="description"><?php echo $cat['description']; ?></div>
	<div class="align center">
		<a href="./?m=<?php echo $m; ?>&amp;parent=<?php echo $parent; ?>&amp;target=<?php echo $cat['uid']; ?>&amp;align=u&amp;myAlign=<?php echo $cat['align']; ?>&amp;myParent=<?php echo $cat['parent']; ?>">올리기</a> / 
		<a href="./?m=<?php echo $m; ?>&amp;parent=<?php echo $parent; ?>&amp;target=<?php echo $cat['uid']; ?>&amp;align=d&amp;myAlign=<?php echo $cat['align']; ?>&amp;myParent=<?php echo $cat['parent']; ?>">내리기</a> /
		<a href="./?m=<?php echo $m; ?>&amp;parent=<?php echo $parent; ?>&amp;modify=<?php echo $cat['uid']; ?>">수정</a> /
		<a href="#" onclick="Forum.remove(<?php echo $m . ', ' . $parent . ', ' . $cat['uid']; ?>);">삭제</a>
	</div>
</div>
	
	<?php
	// 현재 depth=0 일 경우 이 분류를 부모로 둔 하위 depth=1 분류들 호출
	if(!$cat['depth']) {
		$child = $core->query('select * from ' . $dbFIX . 'category where parent = ' . $cat['uid'] . ' order by align asc');
		while($ch = $core->fetch($child)) { 
			$ch['name'] = stripslashes($ch['name']);
			$ch['description'] = stripslashes($ch['description']);
			if($ch['bbs_id']) $ch['name'] = '<a href="' . $grboard . '/board.php?id=' . $ch['bbs_id'] . '" title="클릭 시 게시판으로 이동합니다">' . $ch['name'] . '</a>';
			elseif($ch['out_link']) $ch['name'] = '<a href="' . $ch['out_link'] . '">' . $ch['name'] . '</a>';
			else $ch['name'] = '<a href="./?m=' . $m . '&amp;parent=' . $ch['uid'] . '">' . $ch['name'] . '</a>';
		?>
		
		<div class="forum sub">
			<div class="category"><?php echo $ch['name']; ?> (공개: <?php echo ($ch['is_public']) ? 'O' : '<span class="red">X</span>'; echo ($ch['out_link']) ? ', <span class="green">외부링크↗</span>' : ''; ?>)</div>
			<div class="description"><?php echo $ch['description']; ?></div>
			<div class="align center">
				<a href="./?m=<?php echo $m; ?>&amp;parent=<?php echo $parent; ?>&amp;target=<?php echo $ch['uid']; ?>&amp;align=u&amp;myAlign=<?php echo $ch['align']; ?>&amp;myParent=<?php echo $ch['parent']; ?>">올리기</a> / 
				<a href="./?m=<?php echo $m; ?>&amp;parent=<?php echo $parent; ?>&amp;target=<?php echo $ch['uid']; ?>&amp;align=d&amp;myAlign=<?php echo $ch['align']; ?>&amp;myParent=<?php echo $ch['parent']; ?>">내리기</a> /
				<a href="./?m=<?php echo $m; ?>&amp;parent=<?php echo $parent; ?>&amp;modify=<?php echo $ch['uid']; ?>">수정</a> /
				<a href="#" onclick="Forum.remove(<?php echo $m . ', ' . $parent . ', ' . $ch['uid']; ?>);">삭제</a>
			</div>
		</div>

	<?php $isSubLoop = true; } # while
		if($isSubLoop) echo '<div style="height: 45px"></div>';
	}
	$isSubLoop = false;
	?>

<div style="height: 5px"></div>
<?php
	$loopOpen = true;
} # while 
	
	if(!$loopOpen) echo '<ul><li>현재 등록된 분류가 없습니다.</li></ul>';
?>
<p>&nbsp;</p>

<form name="cat" method="post" onsubmit="return Forum.check(this);" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div><input type="hidden" name="m" value="<?php echo $m; ?>" />
<input type="hidden" name="depth" value="<?php echo $depth; ?>" />
<input type="hidden" name="parent" value="<?php echo $parent; ?>" />
<input type="hidden" name="modifyTarget" value="<?php echo $mod['uid']; ?>" /></div>
<h3>분류 <?php echo $msg; ?></h3>
<p class="list">부모 분류 지정: <select name="setParent">
	<option value="0"<?php echo (!$mod['parent']) ? ' selected="selected"' : ''; ?>>지금 <?php echo $msg; ?>하는 분류를 최상단으로 설정합니다.</option>
	<?php
	$plist = $core->query('select uid, name, depth from ' . $dbFIX . 'category where bbs_id = \'\' order by depth asc');
	while($pa = $core->fetch($plist)) { ?>
		<option value="<?php echo $pa['uid']; ?>"<?php echo ($pa['uid']==$mod['parent'] || $pa['uid']==$parent) ? ' selected="selected"' : ''; ?>><?php echo str_repeat('&nbsp;', $pa['depth'] * 4) . stripslashes($pa['name']); ?></option>
	<?php } # while ?>
</select></p>
<p class="list">분류명: <input class="i" type="text" name="name" value="<?php echo stripslashes($mod['name']); ?>" /></p>
<p class="list">분류설명: <input class="i" type="text" name="description" value="<?php echo stripslashes($mod['description']); ?>" /></p>
<p class="list">분류 동작 지정: <select name="setBBS" onchange="Forum.action(this)">
	<option value=""<?php echo (!$mod['bbs_id']) ? ' selected="selected"' : ''; ?>>이 분류를 클릭시 하위 분류를 펼치며, 게시판으로 연결되지는 않습니다.</option>
	<?php
	$blist = $core->query('select id from ' . $bbsFIX . 'board_list order by id asc');
	while($bbs = $core->fetch($blist)) { ?>
		<option value="<?php echo $bbs['id']; ?>"<?php echo ($bbs['id']==$mod['bbs_id']) ? ' selected="selected"' : ''; ?>>이 분류명을 클릭하게 되면 「<?php echo $bbs['id']; ?>」 게시판으로 이동합니다. (하위분류없음)</option>
	<?php } # while ?>
</select></p>
<p class="list">분류 공개: 
	<input type="radio" name="setPublic" id="yes" value="1"<?php echo (($mod['uid'] && $mod['is_public']) || !$mod['uid']) ? ' checked="checked"' : ''; ?> /> <label for="yes">예, 누구에게나 이 분류명을 보여줍니다.</label> 
	&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="radio" name="setPublic" id="no" value="0"<?php echo ($mod['uid'] && !$mod['is_public']) ? ' checked="checked"' : ''; ?> /> <label for="no">아니오, "접근 허용/배제" 에서 지정한 멤버 그룹에만 보여줍니다.</label>
</p>
<p id="outlink" class="list">외부링크: <input class="i" type="text" name="setOutlink" value="<?php echo $mod['out_link']; ?>" /> 이 분류를 클릭하면 여기서 지정한 외부 URL 로 이동합니다. ("http://" 도 적어주세요)</p>
<p>&nbsp;</p>
<p><input class="s" type="submit" value="위 설정으로 <?php echo $msg; ?>작업을 완료합니다." /></p>
<p>&nbsp;</p>
</form>

<div class="help right">
	<input class="s" type="button" value="분류 설정에 어려움을 겪으셨습니까? 도움말이 준비되어 있습니다." onclick="location.href='./?m=<?php echo $m; ?>&amp;v=2';" />
</div>

<?php } // 분류 설정 끝 ?>