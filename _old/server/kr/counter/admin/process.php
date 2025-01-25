<?php
// 아이디 삭제시
if($_GET['deleteID']) {
	$getID = @mysql_fetch_array(mysql_query('select name from gc_id where uid = '.$_GET['deleteID']));
	@mysql_query('drop table gc_visit_'.$getID['name']);
	@mysql_query('drop table gc_ip_'.$getID['name']);
	@mysql_query('drop table gc_reference_'.$getID['name']);
	@mysql_query('delete from gc_id where uid = '.$_GET['deleteID']);
	@mysql_query('delete from gc_year where id = \''.$getID['name'].'\'');
	$GC->error($getID['name'].' 를 삭제하였습니다.', 'location.href=\'./\';');
}
// 아이디 추가시
if($_POST['addId']) {
	$_id = $_POST['id'];
	$_year = date('Y');
	include '../install/db_make_query.php';
	$getExistID = @mysql_fetch_array(mysql_query('select uid from gc_id where name = \''.$_id.'\''));
	if($getExistID['uid']) $GC->error($_id.' 는 이미 존재하는 아이디 입니다.');
	@mysql_query($gcQue[0]);
	@mysql_query($gcQue[1]);
	@mysql_query($gcQue[2]);
	@mysql_query($gcQue[5]);
	@mysql_query($gcQue[8]);
	$GC->error($_id.' 를 추가하였습니다.', 'location.href=\'./\';');
}
// 카운터 삭제시
if($_GET['deleteCounter']) {
	$getID = @mysql_query('select * from gc_id');
	while($id = mysql_fetch_array($getID)) {
		@mysql_query('drop table gc_ip_'.$id['name']);
		@mysql_query('drop table gc_reference_'.$id['name']);
		@mysql_query('drop table gc_visit_'.$id['name']);
	}
	@mysql_query('drop table gc_admin');
	@mysql_query('drop table gc_id');
	@mysql_query('drop table gc_year');
	$sess = @opendir('../session');
	while($ss = @readdir($sess)) {
		@unlink($ss);
	}
	@rmdir('../session');
	@chmod('../db_info.php', 0707);
	@unlink('../db_info.php');
	$GC->error('설치되어있던 GR 카운터를 모두 초기화 하였습니다. \\n\\n설치 페이지로 이동 합니다.', 'location.href=\'../install/\';');
}
// 동작 모드 설정시
if($_POST['setMode']) {
	$dbInfo = '<?php'."\n";
	$dbInfo .= '$hostName = \''.$GC->_hostName.'\';'."\n";
	$dbInfo .= '$userId = \''.$GC->_userId.'\';'."\n";
	$dbInfo .= '$password = \''.$GC->_password.'\';'."\n";
	$dbInfo .= '$dbName = \''.$GC->_dbName.'\';'."\n";
	$dbInfo .= '$_conn = @mysql_connect($hostName, $userId, $password);'."\n";
	$dbInfo .= '$useExtremeMode = '.$_POST['mode'].';'."\n";
	$dbInfo .= '@mysql_select_db($dbName);'."\n";
	$dbInfo .= '#@mysql_query(\'set names utf8\'); // 한글이 깨져나올 시 맨 앞 # 을 제거'."\n?>";
	@chmod('../db_info.php', 0707);
	$fp = @fopen('../db_info.php', 'w');
	@fwrite($fp, $dbInfo);
	@fclose($fp);
	$GC->error('동작 모드를 '.(($_POST['mode'])?'Extreme Mode(속도 우선)':'Save Mode(효율 우선)').' 으로 설정했습니다.', 'location.href=\'./\';');
}
?>