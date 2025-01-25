<?php
$gblQue = array();
$gblQue[] = 'create table '.$dbFIX.'post ('.
	'uid int(11) not null auto_increment,'.
	'category tinyint(4) not null default \'0\','.
	'signdate int(10) not null default \'0\','.
	'subject varchar(255) not null default \'\','.
	'content text,'.
	'post_condition tinyint(4) not null default \'0\','.
	'comment_condition tinyint(4) not null default \'0\','.
	'trackback varchar(255) not null default \'\','.
	'open_rss tinyint(4) not null default \'0\','.
	'comment_count tinyint(4) not null default \'0\','.
	'trackback_count int(11) not null default \'0\','.
	'tag varchar(255) not null default \'\','.
	'writer varchar(50) not null default \'\','.
	'make_html tinyint(1) not null default \'1\','.
	'primary key(uid),'.
	'key(category),'.
	'key(signdate),'.
	'key(open_rss))';
$gblQue[] = 'create table '.$dbFIX.'comment ('.
	'uid int(11) not null auto_increment,'.
	'family_uid int(11) not null default \'0\','.
	'post_uid int(11) not null default \'0\','.
	'is_secret tinyint(4) not null default \'0\','.
	'is_reply tinyint(4) not null default \'0\','.
	'name varchar(100) not null default \'\','.
	'email varchar(255) not null default \'\','.
	'homepage varchar(255) not null default \'\','.
	'ip varchar(20) not null default \'\','.
	'signdate int(10) not null default \'0\','.
	'content text,'.
	'password char(32) not null default \'\','.
	'writer varchar(50) not null default \'\','.
	'primary key(uid),'.
	'key(family_uid),'.
	'key(post_uid))';
$gblQue[] = 'create table '.$dbFIX.'trackback ('.
	'uid int(11) not null auto_increment,'.
	'post_uid int(11) not null default \'0\','.
	'url varchar(255) not null default \'\','.
	'subject varchar(255) not null default \'\','.
	'summary varchar(255) not null default \'\','.
	'ip varchar(20) not null default \'\','.
	'name varchar(100) not null default \'\','.
	'signdate int(10) not null default \'0\','.
	'primary key(uid),'.
	'key(post_uid))';
$gblQue[] = 'create table '.$dbFIX.'link ('.
	'uid int(11) not null auto_increment,'.
	'url varchar(255) not null default \'\','.
	'name varchar(100) not null default \'\','.
	'info varchar(255) not null default \'\','.
	'primary key(uid))';
$gblQue[] = 'create table '.$dbFIX.'category ('.
	'uid int(11) not null auto_increment,'.
	'id int(11) not null default \'0\','.
	'name varchar(100) not null default \'\','.
	'depth int(11) not null default \'0\','.
	'primary key(uid), key(id))';
$gblQue[] = 'create table '.$dbFIX.'config ('.
	'uid int(11) not null auto_increment,'.
	'id varchar(50) not null default \'\','.
	'password char(32) not null default \'\','.
	'name varchar(100) not null default \'\','.
	'homepage varchar(255) not null default \'\','.
	'email varchar(255) not null default \'\','.
	'blog_title varchar(255) not null default \'\','.
	'blog_info varchar(255) not null default \'\','.
	'theme varchar(255) not null default \'\','.
	'num_view_post tinyint(4) not null default \'5\','.
	'num_per_page tinyint(4) not null default \'10\','.
	'num_rss_post tinyint(4) not null default \'10\','.
	'num_rss_content int(5) not null default \'0\','.
	'use_trackback tinyint(1) not null default \'0\','.
	'use_comment tinyint(1) not null default \'0\','.
	'use_rss tinyint(1) not null default \'0\','.
	'user_key varchar(200) not null default \'kill spam\','.
	'use_openid tinyint(1) not null default \'1\','.
	'cache_time int(11) not null default \'600\','.
	'use_cache tinyint(1) not null default \'0\','.
	'primary key(uid))';
$gblQue[] = 'create table '.$dbFIX.'tag ('.
	'uid int(11) not null auto_increment,'.
	'tag varchar(50) not null default \'\','.
	'count int(7) not null default \'0\','.
	'primary key(uid))';
$gblQue[] = 'create table '.$dbFIX.'photo ('.
	'uid int(11) not null auto_increment,'.
	'file_route varchar(250) not null default \'\','.
	'signdate int(11) not null default \'0\','.
	'title varchar(250) not null default \'\','.
	'content text,'.
	'comment int(11) not null default \'0\','.
	'category tinyint(2) not null default \'1\','.
	'primary key(uid))';
$gblQue[] = 'create table '.$dbFIX.'photo_comment ('.
	'uid int(11) not null auto_increment, '.
	'photo_uid int(11) not null default \'0\', '.
	'name varchar(30) not null default \'\', '.
	'email varchar(255) not null default \'\', '.
	'password char(32) not null default \'\', '.
	'homepage varchar(255) not null default \'\', '.
	'comment text, '.
	'ip varchar(16) not null default \'\', '.
	'signdate int(11) not null default \'0\', '.
	'primary key(uid))';
$gblQue[] = 'create table '.$dbFIX.'photo_category ('.
	'uid int(11) not null auto_increment, '.
	'name varchar(255) not null default \'\', '.
	'primary key(uid))';
$gblQue[] = 'insert into '.$dbFIX.'photo_category set uid = \'\', name = \'normal\'';
$gblQue[] = 'create table '.$dbFIX.'user ( uid int(11) not null auto_increment, '.
	'user_id varchar(20) not null default \'\', '.
	'password char(32) not null default \'\', '.
	'homepage varchar(255) not null default \'\', '.
	'email varchar(255) not null default \'\', '.
	'perm tinyint(2) not null default \'0\', '.
	'signdate int(11) not null default \'0\', '.
	'nickname varchar(50) not null default \'\', '.
	'self_info varchar(255) not null default \'\', '.
	'primary key(uid), key(user_id), key(perm))';
$gblQue[] = 'create table '.$dbFIX.'rss ( uid int(11) not null auto_increment, '.
	'url varchar(255) not null default \'\', name varchar(100) not null default \'\', '.
	'primary key(uid), key(name))';

/* after v1.1.2 R2 */
$gblQue[] = "CREATE TABLE IF NOT EXISTS `{$dbFIX}memo_comment` (
  `uid` int(11) NOT NULL auto_increment,
  `post_num` int(11) NOT NULL default '0',
  `member_key` int(11) NOT NULL default '0',
  `name` varchar(100) NOT NULL default '',
  `content` varchar(255) NOT NULL default '',
  `ip` varchar(20) NOT NULL default '',
  `signdate` int(11) NOT NULL default '0',
  PRIMARY KEY  (`uid`),
  KEY `post_num` (`post_num`),
  KEY `member_key` (`member_key`),
  KEY `signdate` (`signdate`)
)";
$gblQue[] = "CREATE TABLE IF NOT EXISTS `{$dbFIX}memo_config` (
  `uid` int(11) NOT NULL auto_increment,
  `opt` varchar(50) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`uid`),
  KEY `opt` (`opt`)
)";
$gblQue[] = "CREATE TABLE IF NOT EXISTS `{$dbFIX}memo_post` (
  `uid` int(11) NOT NULL auto_increment,
  `member_key` int(11) NOT NULL default '0',
  `name` varchar(100) NOT NULL default '',
  `content` varchar(255) NOT NULL default '',
  `signdate` int(11) NOT NULL default '0',
  PRIMARY KEY  (`uid`),
  KEY `member_key` (`member_key`),
  KEY `signdate` (`signdate`)
)";
$gblQue[] = "create table ".$dbFIX."image ( 
uid int(11) not null auto_increment, 
file_route varchar(255) not null default '', 
signdate int(11) not null default '0', 
primary key(uid))";
$gblQue[] = "CREATE TABLE IF NOT EXISTS `".$dbFIX."reply_catch` (
  `uid` int(11) NOT NULL auto_increment,
  `blog_title` varchar(255) NOT NULL default '',
  `blog_url` varchar(255) NOT NULL default '',
  `post_title` varchar(255) NOT NULL default '',
  `post_uid` int(11) NOT NULL default '0',
  `r1_url` varchar(255) NOT NULL default '',
  `r1_body` text,
  `r2_url` varchar(255) NOT NULL default '',
  `r2_body` text,
  `signdate` int(11) NOT NULL default '0',
  PRIMARY KEY  (`uid`),
  KEY `blog_url` (`blog_url`),
  KEY `post_uid` (`post_uid`)
)";
$gblQue[] = "CREATE TABLE IF NOT EXISTS `".$dbFIX."guestbook` (
  `uid` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `password` char(32) NOT NULL default '',
  `homepage` varchar(255) NOT NULL default '',
  `content` text,
  `is_secret` tinyint(2) NOT NULL default '0',
  `is_reply` tinyint(2) NOT NULL default '0',
  `signdate` int(11) NOT NULL default '0',
  `email` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`uid`),
  KEY `is_reply` (`is_reply`)
)";

/* for monolog install */
$gblQue[] = "insert into {$dbFIX}memo_config set uid = 1, opt = 'theme', value = 'basic'";
$gblQue[] = "insert into {$dbFIX}memo_config set uid = 2, opt = 'write_level', value = '1'";
$gblQue[] = "insert into {$dbFIX}memo_config set uid = 3, opt = 'reply_level', value = '1'";
$gblQue[] = "insert into {$dbFIX}memo_config set uid = 4, opt = 'term_day', value = '3'";
$gblQue[] = "insert into {$dbFIX}memo_config set uid = 5, opt = 'mono_title', value = 'monolog'";
$gblQue[] = "insert into {$dbFIX}memo_config set uid = 6, opt = 'use_rss', value = '1'";
$gblQue[] = "insert into {$dbFIX}memo_config set uid = 7, opt = 'use_openid', value = '1'";
?>
