<?php
$prefix = '../../';
include $prefix.'lib/common.php';
dbConn($prefix);
@mysql_query("create table {$dbFIX}memo_config ( uid int(11) not null auto_increment, opt varchar(50) not null default '', value varchar(255) not null default '', primary key(uid), key(opt))");
@mysql_query("create table {$dbFIX}memo_comment ( uid int(11) not null auto_increment, post_num int(11) not null default '0', member_key int(11) not null default '0', name varchar(100) not null default '', content varchar(255) not null default '', ip varchar(20) not null default '', signdate int(11) not null default '0', primary key(uid), key(post_num), key(member_key), key(signdate))");
@mysql_query("create table {$dbFIX}memo_post ( uid int(11) not null auto_increment, member_key int(11) not null default '0', name varchar(100) not null default '', content varchar(255) not null default '', signdate int(11) not null default '0', primary key(uid), key(member_key), key(signdate))");
@mysql_query("insert into {$dbFIX}memo_config set uid = 1, opt = 'theme', value = 'basic'");
@mysql_query("insert into {$dbFIX}memo_config set uid = 2, opt = 'write_level', value = '1'");
@mysql_query("insert into {$dbFIX}memo_config set uid = 3, opt = 'reply_level', value = '1'");
@mysql_query("insert into {$dbFIX}memo_config set uid = 4, opt = 'term_day', value = '3'");
@mysql_query("insert into {$dbFIX}memo_config set uid = 5, opt = 'mono_title', value = 'monolog'");
@mysql_query("insert into {$dbFIX}memo_config set uid = 6, opt = 'use_rss', value = '1'");
@mysql_query("insert into {$dbFIX}memo_config set uid = 7, opt = 'use_openid', value = '1'");
error('모노로그 설치가 완료되었습니다. 설정화면으로 갑니다.', 'location.href=\''.$prefix.'admin.php?admin=18\';');
?>