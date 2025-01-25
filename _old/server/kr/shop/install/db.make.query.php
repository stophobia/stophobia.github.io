<?php
// 초기 DB Table 설치시 사용할 쿼리들
$que = array();
$que[] = "create table {$prefix}members (
	uid int(11) not null auto_increment,
	member_key int(11) not null default '0',
	save_money int(11) not null default '0',
	mail_code varchar(20) not null default '',
	address1 varchar(255) not null default '',
	address2 varchar(255) not null default '',
	home_phone varchar(50) not null default '',
	mobile_phone varchar(50) not null default '',
	birthday_year int(4) not null default '2000',
	birthday_month tinyint(2) not null default '1',
	birthday_day tinyint(2) not null default '1',
	is_married tinyint(1) not null default '0',
	primary key(uid),
	key(member_key)) TYPE=MyISAM CHARSET=utf8;";
$que[] = "create table {$prefix}carts (
	uid int(11) not null auto_increment,
	member_key int(11) not null default '0',
	bbs_id varchar(100) not null default '',
	bbs_no int(11) not null default '0',
	primary key(uid),
	key(member_key)) TYPE=MyISAM CHARSET=utf8;";
$que[] = "create table {$prefix}orders (
	uid int(11) not null auto_increment,
	member_key int(11) not null default '0',
	bbs_id varchar(100) not null default '',
	bbs_no int(11) not null default '0',
	get_number tinyint(2) not null default '0',
	is_payment tinyint(1) not null default '0',
	use_save_money int(11) not null default '0',
	primary key(uid),
	key(member_key)) TYPE=MyISAM CHARSET=utf8;";
$que[] = "create table {$prefix}settings (
	uid int(11) not null auto_increment,
	opt varchar(255) not null default '',
	var varchar(255) not null default '',
	primary key(uid),
	key(opt)) TYPE=MyISAM CHARSET=utf8;";
$que[] = "create table {$prefix}banners (
	uid int(11) not null auto_increment,
	file_route varchar(255) not null default '',
	url varchar(255) not null default '',
	list_order tinyint(2) not null default '0',
	primary key(uid),
	key(list_order)) TYPE=MyISAM CHARSET=utf8;";
$que[] = "create table {$prefix}bbs (
	uid int(11) not null auto_increment,
	category_uid int(11) not null default '0',
	id varchar(50) not null default '',
	title varchar(50) not null default '',
	sub_title varchar(100) not null default '',
	info varchar(255) not null default '',
	primary key(uid),
	key(category_uid),
	key(id)) TYPE=MyISAM CHARSET=utf8;";
$que[] = "create table {$prefix}categories (
	uid int(11) not null auto_increment,
	name varchar(100) not null default '',
	list_order tinyint(2) not null default '0',
	primary key(uid),
	key(list_order)) TYPE=MyISAM CHARSET=utf8;";
$que[] = "create table {$prefix}accounts (
	uid int(11) not null auto_increment,
	order_uid int(11) not null default '0',
	cost int(11) not null default '0',
	year int(4) not null default '0',
	month tinyint(2) not null default '0',
	day tinyint(2) not null default '0',
	week char(2) not null default '0',
	primary key(uid),
	key(order_uid),
	key(year),
	key(month),
	key(day)) TYPE=MyISAM CHARSET=utf8;";
$que[] = "create table {$prefix}cards (
	uid int(11) not null auto_increment,
	member_key int(11) not null default '0',
	order_key int(11) not null default '0',
	rBusiCd char(4) not null default '',
	rOrdNo varchar(40) not null default '',
	rProdNm varchar(100) not null default '',
	rApprNo char(8) not null default '',
	rAmt int(11) not null default '0',
	rApprTm char(14) not null default '',
	rCardNm varchar(20) not null default '',
	rCardCd char(4) not null default '',
	rMembNo varchar(15) not null default '',
	rAquiCd char(4) not null default '',
	rAquiNm varchar(20) not null default '',
	rBillNo char(6) not null default '',
	primary key(uid),
	key(member_key),
	key(order_key),
	key(rBusiCd),
	key(rOrdNo),
	key(rCardCd),
	key(rBillNo)) TYPE=MyISAM CHARSET=utf8;";
?>