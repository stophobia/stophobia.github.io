<?php
include '../db_info.php';
@mysql_connect($hostName, $userId, $password);
@mysql_select_db($dbName);

// for v1.0.1
if(!file_exists('../cache/')) {
	@mkdir('../cache/');
	@chmod('../cache/', 0707);
}

$getRefererDomain = @mysql_fetch_array(mysql_query('select uid from gc_reference_domain limit 1'));
if(!$getRefererDomain[0]) {
	mysql_query("create table `gc_reference_domain` ( uid int(11) not null auto_increment,
		id varchar(50) not null default '', url varchar(255) not null default '', count int(11) not null default '0',
		primary key(uid), key(id), key(count))");
	$getID = @mysql_query('select name from gc_id');
	while($ids = @mysql_fetch_array($getID)) {
		$getURL = @mysql_query('select url from gc_reference_'.$ids['name']);
		while($urls = @mysql_fetch_array($getURL)) {
			$tmpArr = explode('/', str_replace('www.', '', $urls['url']));
			$getExist = @mysql_fetch_array(mysql_query("select uid from gc_reference_domain where url = '$tmpArr[2]' and id = '".$ids['name']."'"));
			if($getExist['uid']) mysql_query("update gc_reference_domain set count = count + 1 where url = '$tmpArr[2]'");
			else mysql_query("insert into gc_reference_domain set uid = '', id = '".$ids['name']."', url = '".$tmpArr[2]."', count = 1");
		}
	}
}

// for v1.2
if(!$_conn) {
	@chmod('../db_info.php', 0707);
	$dbInfo = "<?php\n";
	$dbInfo .= '$hostName = \''.$hostName.'\';'."\n";
	$dbInfo .= '$userId = \''.$userId.'\';'."\n";
	$dbInfo .= '$password = \''.$password.'\';'."\n";
	$dbInfo .= '$dbName = \''.$dbName.'\';'."\n";
	$dbInfo .= '$_conn = @mysql_connect($hostName, $userId, $password);'."\n";
	$dbInfo .= '@mysql_select_db($dbName);'."\n";
	$dbInfo .= '#@mysql_query(\'set names utf8\'); // 한글이 깨져나올 시 맨 앞 # 을 제거'."\n?>";
	$fpc = fopen('../db_info.php', 'w');
	fwrite($fpc, $dbInfo);
	fclose($fpc);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GR Counter Upgrade: v1.0 pl1 ▶▶▶ v1.2</title>
</head><body>

<h2>GR Counter 업데이트가 완료되었습니다!</h2>

<strong>DB Table 업데이트 내역</strong>
<ul>
	<li>db_info.php 파일 내에 MySQL 접속 부분 추가</li>
	<li>리퍼러 로그 중 도메인만 따로 모아서 통계자료로 보여줌</li>
</ul>
<strong>※ 업데이트 해주셔서 감사합니다!</strong>

</body></html>