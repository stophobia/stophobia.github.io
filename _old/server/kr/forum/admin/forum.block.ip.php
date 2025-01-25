<?php 
if(!defined('__GRFORUM__')) exit();

// 차단 해제시
if($_GET['limitOpen']) {
	$core->query('delete from ' . $dbFIX . 'block_ip where uid = ' . $_GET['ipOpen']);
	$core->alert('차단을 해제하였습니다.', './?m=' . $m);
}

// 차단 아이피 등록
if($_POST['ip']) {
	$bip = $_POST['ip'];
	$isExist = $core->getData('select uid from ' . $dbFIX . 'block_ip where ip = \'' . $bip . '\' limit 1');
	if($isExist['uid']) $core->alert('이미 등록된 아이피 주소 입니다.');
	else {
		$core->query('insert into ' . $dbFIX . 'block_ip set uid = \'\', ip = \'' . $bip . '\'');
		$core->alert('아이피 주소를 등록하였습니다.');
	}
}
?>

<h3>포럼에서 차단할 아이피 주소(IP Address)를 추가해 주세요.</h3>
과도한 트래픽을 유발하는 IP 주소 혹은 스팸 목적의 IP 주소를 이 곳에 등록해 주세요.<br />
차단된 IP 주소가 포럼에 접근하면 원천적으로 접근을 제한하게 됩니다.<br />
※ 차단 IP 목록이 많아질수록 GR Forum 동작속도가 더 느려지게 됩니다.<br />

<form name="block_ip" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div><input type="hidden" name="m" value="<?php echo $m; ?>" /></div>

<div class="help">
	<p class="list"><input class="i" type="text" name="ip" /> ← 이 곳에 아이피 주소(예: 123.231.251.125) 를 입력해 주세요.</p>
	<p>&nbsp;</p>
	<p><input class="s" type="submit" value="위에 지정한 IP 주소를 차단하기" /></p>
</div>
</form>

<h3>현재 차단된 아이피 주소 목록입니다.</h3>
<ol>
<?php
$blist = $core->query('select * from ' . $dbFIX . 'block_ip order by uid asc');
while($bip = $core->fetch($blist)) { ?>
	<li><?php echo $bip['ip']; ?> <a href="#" onclick="Forum.limitOpen(<?php echo $m . ', ' . $bip['uid']; ?>);" class="green">[차단해제]</a>
	</li>
<?php } # while ?>
</ol>