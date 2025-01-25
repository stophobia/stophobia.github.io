<?php
/*
	GR Paper DB쿼리
	작성자: 박희근 (http://sirini.net)
	수정일: 2008-08-22
	내  용: 초기 설치시 사용되는 파일. DB에 Table 들을 생성함.
*/
$que = array();

// 사용자 정보 저장
$que[] = "create table ".$dbinfo['prefix']."user (
	uid int(11) not null auto_increment,
	id varchar(50) not null default '',
	password char(32) not null default '',
	name varchar(50) not null default '',
	email varchar(100) not null default '',
	primary key(uid)) TYPE=MyISAM CHARSET=utf8";

// 수집할 피드 주소 저장
$que[] = "create table ".$dbinfo['prefix']."feed_list (
	uid int(11) not null auto_increment,
	group_uid int(11) not null default '0',
	xml varchar(255) not null default '',
	url varchar(255) not null default '',
	img varchar(255) not null default '',
	name varchar(255) not null default '',
	info varchar(255) not null default '',
	is_open tinyint(1) not null default '1',
	last_update int(11) not null default '0',
	total int(11) not null default '0',
	primary key(uid), key(group_uid), key(xml), key(is_open), key(last_update)) TYPE=MyISAM CHARSET=utf8";

// 피드 그룹 저장
$que[] = "create table ".$dbinfo['prefix']."feed_group (
	uid int(11) not null auto_increment,
	name varchar(255) not null default 'default',
	info varchar(255) not null default 'my default feeds',
	count int(11) not null default '0',
	is_open tinyint(1) not null default '1',
	primary key(uid), key(is_open)) TYPE=MyISAM CHARSET=utf8";

// 태그 따로 모으기
$que[] = "create table ".$dbinfo['prefix']."tag (
	uid int(11) not null auto_increment,
	tag varchar(255) not null default '',
	count int(11) not null default '0',
	primary key(uid)) TYPE=MyISAM CHARSET=utf8";

// 실제 피드수집 결과 저장
$que[] = "create table ".$dbinfo['prefix']."feed (
	uid int(11) not null auto_increment,
	blog_uid int(11) not null default '0',
	link varchar(255) not null default '',
	subject varchar(255) not null default '',
	content text,
	author varchar(50) not null default '',
	signdate int(11) not null default '0',
	hit int(11) not null default '0',
	tag varchar(255) not null default '',
	primary key(uid), key(blog_uid), key(signdate), key(hit), key(tag)) TYPE=MyISAM CHARSET=utf8";

// 스킨(테마) 설정 저장
$que[] = "create table ".$dbinfo['prefix']."skin (
	uid int(11) not null auto_increment,
	opt varchar(50) not null default '',
	var varchar(255) not null default '',
	primary key(uid), key(opt)) TYPE=MyISAM CHARSET=utf8";

// 그림 따로 저장
$que[] = "create table ".$dbinfo['prefix']."image (
	uid int(11) not null auto_increment,
	feed_uid int(11) not null default '0',
	url varchar(255) not null default '',
	primary key(uid), key(feed_uid)) TYPE=MyISAM CHARSET=utf8";

// 로그 기록 저장
$que[] = "create table ".$dbinfo['prefix']."log (
	uid int(11) not null auto_increment,
	log text,
	signdate int(11) not null default '0',
	primary key(uid)) TYPE=MyISAM CHARSET=utf8";
	
// 초기 설정 입력
$que[] = "insert into ".$dbinfo['prefix']."skin set opt = 'theme', var = 'default'";
$que[] = "insert into ".$dbinfo['prefix']."skin set opt = 'browserTitle', var = 'Welcome to GR Paper !!'";
$que[] = "insert into ".$dbinfo['prefix']."skin set opt = 'hotPostNumber', var = '10'";
$que[] = "insert into ".$dbinfo['prefix']."skin set opt = 'postNumber', var = '10'";
$que[] = "insert into ".$dbinfo['prefix']."skin set opt = 'pageNumber', var = '10'";
$que[] = "insert into ".$dbinfo['prefix']."skin set opt = 'charNumber', var = '300'";
$que[] = "insert into ".$dbinfo['prefix']."skin set opt = 'thumbWidth', var = '100'";
$que[] = "insert into ".$dbinfo['prefix']."skin set opt = 'thumbHeight', var = '85'";
$que[] = "insert into ".$dbinfo['prefix']."skin set opt = 'blogNumber', var = '10'";
$que[] = "insert into ".$dbinfo['prefix']."skin set opt = 'tagNumber', var = '20'";
$que[] = "insert into ".$dbinfo['prefix']."skin set opt = 'botTerm', var = '60'";
$que[] = "insert into ".$dbinfo['prefix']."skin set opt = 'thumbNumber', var = '30'";
$que[] = "insert into ".$dbinfo['prefix']."skin set opt = 'hotPostTerm', var = '12'";
$que[] = "insert into ".$dbinfo['prefix']."skin set opt = 'blogListNumber', var = '25'";
$que[] = "insert into ".$dbinfo['prefix']."feed_group set uid = '', name = 'favorite', info = 'my favorite blogs...', count = 0, is_open = 1";
?>
