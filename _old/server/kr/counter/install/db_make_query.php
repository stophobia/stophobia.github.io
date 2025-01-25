<?php
if(!$_id) $_id = 'index';
if(!$_year) $_year = date('Y');
$gcQue[] = "drop table if exists gc_visit_{$_id}";
$gcQue[] = "create table gc_visit_{$_id} ( uid int(11) not null auto_increment, year int(4) not null default '0', ".
	"month tinyint(2) not null default '0', day tinyint(2) not null default '0', hour tinyint(2) not null default '0', ".
	"uniq_view int(11) not null default '0', page_view int(11) not null default '0', primary key(uid), ".
	"key(year), key(month), key(day), key(hour))";
$gcQue[] = "drop table if exists gc_reference_{$_id}";
$gcQue[] = "create table gc_reference_{$_id} ( uid int(11) not null auto_increment, url varchar(255) not null default '', ".
	"count int(11) not null default '0', primary key(uid))";
$gcQue[] = "drop table if exists gc_ip_{$_id}";
$gcQue[] = "create table gc_ip_{$_id} ( uid int(11) not null auto_increment, ip char(15) not null default '', ".
	"count int(11) not null default '0', signdate int(11) not null default '0', primary key(uid))";
$gcQue[] = "drop table if exists gc_id";
$gcQue[] = "create table gc_id ( uid int(11) not null auto_increment, name varchar(50) not null default '', ".
	"total_uniq_view int(11) not null default '0', total_page_view int(11) not null default '0', primary key(uid))";
$gcQue[] = "insert into gc_id set uid = '', name = '$_id', total_uniq_view = 0, total_page_view = 0";
$gcQue[] = "drop table if exists gc_admin";
$gcQue[] = "create table gc_admin ( uid int(11) not null auto_increment, id varchar(50) not null default '', ".
	"password char(32) not null default '', primary key(uid))";
$gcQue[] = "drop table if exists gc_year";
$gcQue[] = "create table gc_year ( id varchar(50) not null default '', year int(4) not null default '0', ".
	"total_uniq_year int(11) not null default '0', total_page_year int(11) not null default '0', key(total_uniq_year), key(total_page_year))";
$gcQue[] = "insert into gc_year set id = '$_id', year = '$_year', total_uniq_year = 0, total_page_year = 0";
$gcQue[] = "drop table if exists gc_reference_domain";
$gcQue[] = "create table `gc_reference_domain` ( uid int(11) not null auto_increment,".
		"id varchar(50) not null default '', url varchar(255) not null default '', count int(11) not null default '0',".
		"primary key(uid), key(id), key(count))";
?>