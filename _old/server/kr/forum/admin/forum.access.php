<?php 
if(!defined('__GRFORUM__')) exit();

// 접근 허용 해제
if($_GET['limitOpen']) {
	$core->query('delete from ' . $dbFIX . 'access where uid = ' . $_GET['limitOpen']);
	$core->alert('접근허용을 취소하였습니다.', './?m=' . $m);
}

// 접근 허용 처리
if($_POST['cat'] && $_POST['group']) {
	$cat = $_POST['cat'];
	$grp = $_POST['group'];
	$isExist = $core->getData('select uid from ' . $dbFIX . 'access where cat_uid = ' . $cat . ' and mem_group = ' . $grp . ' limit 1');
	if($isExist['uid']) $core->alert('이미 접근이 허용되어 있습니다.');
	else {
		$core->query('insert into ' . $dbFIX . 'access set uid = \'\', cat_uid = ' . $cat . ', mem_group = ' . $grp);
		$core->query('update ' . $dbFIX . 'category set is_public = 0 where parent = ' . $cat);
		$core->alert('비공개 분류에 대한 그룹 접근 허용 처리가 완료되었습니다.', './?m=' . $m);
	}
}
?>

<h3>포럼 내 비공개 분류에 접근 할 수 있는 멤버그룹을 지정합니다.</h3>
"분류 관리" 에서 분류를 만드실 때 "비공개" 로 만드신 분류는 포럼 목록에서 보여지지 않습니다.<br />
비공개된 목록을 볼 수 있는 사람은 포럼 관리자와, 바로 이 곳에서 지정하는 멤버 그룹에 속한<br />
사용자들 뿐입니다.<br />
<br />
여기서 말하는 "멤버 그룹" 은 GR Board 관리화면에서 볼 수 있는 그 "멤버 그룹" 과 같습니다.<br />
GR Forum 은 GR Board 와 연동되어 동작하며 회원 데이터 역시 마찬가지입니다.<br />
따라서 만약 멤버 그룹을 하나도 생성하지 않으셨거나, 혹은 비공개 분류에 접근 가능한<br />
사용자들의 멤버 그룹 설정을 하지 않으셨다면 아래 작업 전에 미리 해 두셔야 합니다.<br />
(또한 포럼 내 비공개 분류가 없을 경우, 이 곳 설정은 무효화 됩니다.)

<form name="access" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div><input type="hidden" name="m" value="<?php echo $m; ?>" /></div>

<div class="help">
	<p class="list">
		<select name="cat">
			<option value="">아래 비공개 분류 중 하나를 선택해 주세요</option>
			<?php
			$plist = $core->query('select uid, name, depth from ' . $dbFIX . 'category where is_public = 0 order by depth asc');
			while($pa = $core->fetch($plist)) { ?>
				<option value="<?php echo $pa['uid']; ?>"><?php echo str_repeat('&nbsp;', $pa['depth'] * 4) . stripslashes($pa['name']); ?></option>
			<?php } # while ?>
		</select> ← 비공개 분류 선택
	</p>
	<p class="list">
		<select name="group">
			<option value="">아래 GR Board 멤버 그룹 중 하나를 선택해 주세요</option>
			<?php
			$glist = $core->query('select no, name from ' . $bbsFIX . 'member_group');
			while($grp = $core->fetch($glist)) { ?>
				<option value="<?php echo $grp['no']; ?>"><?php echo stripslashes($grp['name']); ?></option>
			<?php } # while ?>
		</select> ← 위 분류에 접근이 가능한 멤버 그룹 선택
	</p>
	<p>&nbsp;</p>
	<p><input class="s" type="submit" value="위의 설정을 저장합니다." /></p>
</div>
</form>

<h3>비공개 분류에 접근이 허용된 멤버 그룹 목록</h3>
<ul>
<?php
$perm = $core->query('select * from ' . $dbFIX . 'access');
while($acc = $core->fetch($perm)) { 
	$cat = $core->getData('select name from ' . $dbFIX . 'category where uid = ' . $acc['cat_uid'] . ' limit 1');
	$mem = $core->getData('select name from ' . $bbsFIX . 'member_group where no = ' . $acc['mem_group'] . ' limit 1');
?>
	<li><strong><?php echo stripslashes($cat['name']); ?></strong> 분류에 현재 
		「<span class="green"><?php echo stripslashes($mem['name']); ?></span>」 멤버 그룹에 속한 사용자들만 접근 할 수 있습니다.
		<a href="#" onclick="Forum.limitOpen(<?php echo $m . ', ' . $acc['uid']; ?>);" class="red">[허용해제]</a></li>
<?php } ?>
</ul>