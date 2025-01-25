<?php 
if(!defined('__GRFORUM__')) exit();

// GR Forum 삭제 처리
if($_POST['agree']) {
	$core->query('drop table ' . $dbFIX . 'category');
	$core->query('drop table ' . $dbFIX . 'status');
	$core->query('drop table ' . $dbFIX . 'option');
	$core->query('drop table ' . $dbFIX . 'view');
	$core->query('drop table ' . $dbFIX . 'block_id');
	$core->query('drop table ' . $dbFIX . 'block_ip');
	$core->query('drop table ' . $dbFIX . 'access');
	unlink('../core.php');
	$core->alert('GR Forum 을 삭제하였습니다.', '../install/');
}
?>

<h3>GR Forum 을 정말로 삭제하시겠습니까?</h3>
삭제하시게 되면 기존에 GR Forum 이 사용하고 있던 DB Table 들은 모두 삭제되며<br />
자동으로 설치화면으로 이동하게 됩니다.<br />
완전한 삭제를 위해서는 FTP 프로그램으로 접속하신 후, GR Forum 폴더를 삭제하시면 됩니다.<br />
(GR Forum 을 삭제한다고 해서 GR Core 나 GR Board 까지 함께 삭제되지는 않습니다.)<br />
<br />
계속 진행하실 것이라면 아래의 버튼을 클릭해 주세요!<br />
<br />

<form name="uninstall" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div><input type="hidden" name="m" value="<?php echo $m; ?>" /><input type="hidden" name="agree" value="1" /></div>
<div class="help">
<input class="s red" type="submit" value="예, GR Forum 을 지금 삭제합니다." />
&nbsp;&nbsp;&nbsp;&nbsp;
<input class="s green" type="button" value="아니오, GR Forum 을 삭제하지 않겠습니다." onclick="location.href='./?m=1';" />
</div>
</form>
