<?php
/**
 * @update 2008-11-21
 * @comment GR 노트 업데이트 페이지
 * 이 페이지를 열람한다는 것은, 업데이트를 실행했다는 것과 같다.
 */
@header('Content-Type: text/html; charset=utf-8');
include '../db.info.php';
@mysql_connect($hostName, $userId, $password) or die('DB 접속 정보에 오류가 있거나 접속정보를 가져올 수 없습니다.');
@mysql_select_db($dbName) or die('DB 이름이 잘못되었거나 DB를 선택할 수 없습니다');
@mkdir('../data/', 0705);
@chmod('../data', 0707);
@mysql_query("create table ".$divide."files ( uid int(11) not null auto_increment, file_route varchar(255) not null default '', 
file_name varchar(255) not null default '', writer int(11) not null default '0', hit int(11) not null default '0', primary key(uid), key(hit)) TYPE=MyISAM CHARSET=utf8;");
@mysql_query("create table ".$divide."planners ( uid int(11) not null auto_increment, start_work int(11) not null default '0', end_work int(11) not null default '0', level tinyint(2) not null default '3', subject varchar(255) not null default '', content text, member_key int(11) not null default '1', primary key(uid), key(start_work), key(end_work), key(level), key(member_key)) TYPE=MyISAM CHARSET=utf8;");
@mysql_query("create table ".$divide."memorials ( uid int(11) not null auto_increment, day int(11) not null default '0', subject varchar(100) not null default '', content varchar(255), member_key int(11) not null default '0', primary key(uid), key(day), key(member_key)) TYPE=MyISAM CHARSET=utf8;");
@mysql_query("alter table {$divide}wikis change 'keyword_md5' 'keyword_md5' char(32) not null default ''");

// 0.94b
$connString = '<?php'."\n"
		.'$hostName=\''.$hostName.'\';'."\n"
		.'$userId=\''.$userId.'\';'."\n"
		.'$password=\''.$password.'\';'."\n"
		.'$dbName=\''.$dbName.'\';'."\n"
		.'$divide=\''.$divide.'\';'."\n"
		.'@mysql_connect($hostName, $userId, $password);'."\n"
		.'@mysql_select_db($dbName);'."\n"
		.'//@mysql_query(\'set names utf8\');'." # 한글이 깨져나올 때 앞의 // 제거 후 저장 → 서버에 덮어씌우기\n"
		.'@session_save_path($prefix.\'session/\');'."\n"
		.'@session_start();'."\n"
		.'?>';
@chmod('../db.info.php', 0707);
@unlink('../db.info.php');
$mkConn = @fopen('../db.info.php', 'w');
@fwrite($mkConn, $connString);
@fclose($mkConn);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GR Note Update : v0.9alpha ▶▶▶ v0.94beta "잠자리"</title>
</head><body>

<h2>GR Note v0.94beta "잠자리" 업데이트가 완료되었습니다.</h2>

<strong>DB Table 업데이트 내역</strong>
<ul>
	<li>e플래너용 테이블 추가 (planners, memorial)</li>
	<li>파일 첨부 시 첨부된 파일 경로 등을 저장하는 테이블 추가</li>
</ul>

</body></html>