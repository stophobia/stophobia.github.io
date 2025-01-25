<?php
/**
 * GR Forum DB Structure ( for MySQL 5 )
 * @author sirini
 * @update 2009-07-30
 * @comment GR포럼 설치 때 DB에 생성할 테이블들
 * @warning 재설치시 기존에 생성된 테이블은 삭제한다
 */

$que = array();
$que[] = "drop table if exists {$dbFIX}category";
$que[] = "create table {$dbFIX}category ( 
	uid int(11) not null auto_increment,
	name varchar(255) not null default '',
	depth tinyint(4) not null default '0',
	parent int(11) not null default '0',
	bbs_id varchar(255) not null default '',
	align tinyint(4) not null default '0',
	description varchar(255) not null default '',
	is_public tinyint(1) not null default '1',
	out_link varchar(255) not null default '',
	primary key(uid),
	key(depth),
	key(parent),
	key(align),
	key(is_public)) TYPE=MyISAM CHARSET=utf8;";
$que[] = "drop table if exists {$dbFIX}status";
$que[] = "create table {$dbFIX}status ( 
	uid int(11) not null auto_increment,
	cat_uid int(11) not null default '0',
	post_count int(11) not null default '0',
	reply_count int(11) not null default '0',
	latest_id varchar(50) not null default '',
	latest_no int(11) not null default '0',
	primary key(uid),
	key(cat_uid)) TYPE=MyISAM CHARSET=utf8;";
$que[] = "drop table if exists {$dbFIX}option";
$que[] = "create table {$dbFIX}option (
	uid int(11) not null auto_increment,
	opt varchar(255) not null default '',
	var varchar(255) not null default '',
	primary key(uid),
	key(opt)) TYPE=MyISAM CHARSET=utf8;";
$que[] = "drop table if exists {$dbFIX}view";
$que[] = "create table {$dbFIX}view (
	uid int(11) not null auto_increment,
	opt varchar(255) not null default '',
	var varchar(255) not null default '',
	primary key(uid),
	key(opt)) TYPE=MyISAM CHARSET=utf8;";
$que[] = "insert into {$dbFIX}view set uid = '', opt = 'logo_pos', var = 'forum.logo.gif'";
$que[] = "insert into {$dbFIX}view set uid = '', opt = 'forum_title', var = 'forum title'";
$que[] = "insert into {$dbFIX}view set uid = '', opt = 'forum_desc', var = 'forum description'";
$que[] = "insert into {$dbFIX}view set uid = '', opt = 'layout_skin', var = 'basic'";
$que[] = "drop table if exists {$dbFIX}block_id";
$que[] = "create table {$dbFIX}block_id (
	uid int(11) not null auto_increment,
	mem_id varchar(255) not null default '',
	mem_no int(11) not null default '0',
	delay int(11) not null default '0',
	is_view tinyint(1) not null default '0',
	reason varchar(255) not null default '',
	primary key(uid),
	key(mem_id),
	key(mem_no)) TYPE=MyISAM CHARSET=utf8;";
$que[] = "drop table if exists {$dbFIX}block_ip";
$que[] = "create table {$dbFIX}block_ip (
	uid int(11) not null auto_increment,
	ip varchar(20) not null default '',
	primary key(uid),
	key(ip)) TYPE=MyISAM CHARSET=utf8;";
$que[] = "drop table if exists {$dbFIX}access";
$que[] = "create table {$dbFIX}access (
	uid int(11) not null auto_increment,
	cat_uid int(11) not null default '0',
	mem_group int(11) not null default '0',
	primary key(uid),
	key(cat_uid)) TYPE=MyISAM CHARSET=utf8;";

	
?>