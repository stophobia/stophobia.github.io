<?php
$query = array();
$query[] = "drop table if exists {$divide}users";
$query[] = "create table {$divide}users (
	uid int(11) not null auto_increment,
	id varchar(50) not null default '',
	password char(32) not null default '',
	nickname varchar(20) not null default '',
	email varchar(255) not null default '',
	homepage varchar(255) not null default '',
	make_time int(11) not null default '0',
	level tinyint(2) not null default '1',
	point int(11) not null default '0',
	self_info varchar(255) not null default '',
	primary key(uid),
	key id(id)) TYPE=MyISAM CHARSET=utf8;";
$query[] = "drop table if exists {$divide}projects";
$query[] = "create table {$divide}projects (
	uid int(11) not null auto_increment,
	name varchar(255) not null default '',
	make_time int(11) not null default '0',
	update_time int(11) not null default '0',
	ticket_done int(11) not null default '0',
	ticket_yet int(11) not null default '0',
	summary text,
	leader int(11) not null default '0',
	primary key(uid),
	key name(name)) TYPE=MyISAM CHARSET=utf8;";
$query[] = "drop table if exists {$divide}goals";
$query[] = "create table {$divide}goals (
	uid int(11) not null auto_increment,
	project_id int(11) not null default '0',
	codename varchar(255) not null default '',
	version varchar(100) not null default '',
	goal text,
	ticket_done int(11) not null default '0',
	ticket_yet int(11) not null default '0',
	primary key(uid),
	key project_id(project_id)) TYPE=MyISAM CHARSET=utf8;";
$query[] = "drop table if exists {$divide}wikis";
$query[] = "create table {$divide}wikis (
	uid int(11) not null auto_increment,
	keyword varchar(255) not null default '',
	keyword_md5 char(32) not null default '',
	content text,
	writer int(11) not null default '0',
	signdate int(11) not null default '0',
	view int(11) not null default '0',
	master_doc int(11) not null default '0',
	primary key(uid),
	key keyword_md5(keyword_md5),
	key master_doc(master_doc),
	key writer(writer)) TYPE=MyISAM CHARSET=utf8;";
$query[] = "drop table if exists {$divide}planners";
$query[] = "create table {$divide}planners (
	uid int(11) not null auto_increment,
	start_work int(11) not null default '0',
	end_work int(11) not null default '0',
	level tinyint(2) not null default '3',
	subject varchar(255) not null default '',
	content text,
	member_key int(11) not null default '1',
	primary key(uid),
	key(start_work),
	key(end_work),
	key(level),
	key(member_key)) TYPE=MyISAM CHARSET=utf8;";
$query[] = "drop table if exists {$divide}memorials";
$query[] = "create table {$divide}memorials ( 
	uid int(11) not null auto_increment, 
	day int(11) not null default '0', 
	subject varchar(100) not null default '', 
	content varchar(100) not null default '', 
	member_key int(11) not null default '0', 
	primary key(uid), 
	key(day), 
	key(member_key)) TYPE=MyISAM CHARSET=utf8;";
?>