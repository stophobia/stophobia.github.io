<?php 
if(!defined('__GRFORUM__')) exit();

// 차단 해제시
if($_GET['limitOpen']) {
	$core->query('delete from ' . $dbFIX . 'block_id where uid = ' . $_GET['limitOpen']);
	$core->alert('차단을 해제하였습니다.', './?m=' . $m);
}

// 차단 아이디 등록
if($_POST['blockID']) {
	$bid = $_POST['blockID'];
	if($_POST['delay'] > 7300) $_POST['delay'] = 7300;
	elseif($_POST['delay'] < 1) $core->alert('차단일 값은 1(일) 이상이어야 합니다');

	$delay = time() + ($_POST['delay'] * 86400);
	$isView = $_POST['isView'];
	$reason = addslashes($_POST['reason']);
	
	$isExist = $core->getData('select no from ' . $bbsFIX . 'member_list where id = \'' . $bid . '\' limit 1');
	if(!$isExist['no']) $core->alert('입력하신 아이디는 없는 아이디입니다.');
	else {
		$isDuplex = $core->getData('select uid from ' . $dbFIX . 'block_id where mem_no = ' . $isExist['no'] . ' limit 1');
		if($isDuplex['uid']) $core->alert('이미 차단중인 아이디입니다. 차단된 아이디 목록을 확인해 보세요!');

		$core->query('insert into ' . $dbFIX . 'block_id set uid = \'\', mem_id = \'' . $bid . '\', mem_no = ' . $isExist['no'] .
			', delay = ' . $delay . ', is_view = ' . $isView . ', reason = \'' . $reason . '\'');
		$core->alert($bid . ' 아이디를 포럼에서 차단했습니다.', './?m=' . $m);
	}
}
?>

<h3>포럼에서 차단할 아이디를 추가해 주세요.</h3>
불필요한 언쟁을 즐기는 사용자, 혹은 광고성 글을 수시로 남겨 포럼을 난장판으로 만드는 사용자들은<br />
이 곳에서 아이디를 차단하실 수 있습니다. 차단 시 유예기간을 설정할 수 있으므로 가령 자숙이 필요한<br />
사용자에게는 일주일 동안만 접근을 차단한다거나 혹은 반 영구적으로(=20년) 차단할 수도 있습니다.<br />

<form name="block_id" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div><input type="hidden" name="m" value="<?php echo $m; ?>" /></div>

<div class="help">
	<p class="list"><input class="i" type="text" name="blockID" onkeydown="Forum.suggest(this);" /> <span id="enter">← 이 곳에 아이디를 입력해 주세요!</span></p>
	<div id="autoSuggest" style="display: none"></div>
	<p class="list"><input class="i" type="text" name="delay" value="7300" /> 일 동안 포럼 접근을 제한합니다. (기본: 7300일=20년)</p>
	<p class="list">
		<input type="radio" name="isView" id="yes" value="1" checked="checked" /> <label for="yes">글 읽는 것은 허용합니다. (글쓰기 안됨)</label> 
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="radio" name="isView" id="no" value="0" /> <label for="no">아예 접근할 수 없습니다. (접근 금지)</label>
	</p>
	<p class="list"><input class="i" type="text" name="reason" value="포럼 규칙 위반" /> ← 차단된 사용자에게 보여줄 한줄 메시지를 적어주세요.</p>
	<p>&nbsp;</p>
	<p><input class="s" type="submit" value="위에 지정한 사용자 아이디를 차단하기" /></p>
</div>
</form>

<h3>현재 차단된 아이디 목록입니다.</h3>
<ol>
<?php
$blist = $core->query('select * from ' . $dbFIX . 'block_id order by uid asc');
while($bid = $core->fetch($blist)) { ?>
	<li><strong><?php echo $bid['mem_id']; ?></strong> (<?php echo date('Y년 m월 d일', $bid['delay']); ?>까지 제한, 
		글읽기 <?php echo ($bid['is_view']) ? '가능' : '<span class="red">불가</span>'; ?>,
		「<?php echo stripslashes($bid['reason']); ?>」) <a href="#" onclick="Forum.limitOpen(<?php echo $m . ', ' . $bid['uid']; ?>);" class="green">[제한해제]</a>
	</li>
<?php } # while ?>
</ol>