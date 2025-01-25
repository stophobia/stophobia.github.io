<?php
@header('Content-Type: text/html; charset=utf-8');
include '../db_info.php';
@mysql_connect($hostName, $userId, $password) or die('DB 접속 정보에 오류가 있거나 접속정보를 가져올 수 없습니다.');
@mysql_select_db($dbName) or die('DB 이름이 잘못되었거나 DB를 선택할 수 없습니다');
if(!$dbFIX) {
	@chmod('../db_info.php', 0707);
	@unlink('../db_info.php');
	$dbInfo = '<?php'."\n";
	$dbInfo .= '$hostName = \''.$hostName.'\';'."\n";
	$dbInfo .= '$userId = \''.$userId.'\';'."\n";
	$dbInfo .= '$password = \''.$password.'\';'."\n";
	$dbInfo .= '$dbName = \''.$dbName.'\';'."\n";
	$dbInfo .= '$dbFIX = \'gbl_\';'."\n";
	$dbInfo .= '?>';
	$fp = @fopen('../db_info.php', 'w');
	@fwrite($fp, $dbInfo);
	@fclose($fp);
	@chmod('../db_info.php', 0404);
}
@mysql_query("create table ".$dbFIX."user ( uid int(11) not null auto_increment, user_id varchar(20) not null default '', password char(32) not null default '', nickname varchar(50) not null default '', ".
"homepage varchar(255) not null default '', email varchar(255) not null default '', perm tinyint(2) not null default '0', self_info varchar(255) not null default '', primary key(uid), key(user_id), key(perm))");
$adminID = @mysql_fetch_array(mysql_query("select id from ".$dbFIX."config where uid = 1"));
@mysql_query("alter table ".$dbFIX."post add writer varchar(50) not null default '".$adminID['id']."'");
@mysql_query("alter table ".$dbFIX."comment add writer varchar(50) not null default ''");
@mysql_query("alter table ".$dbFIX."post add make_html tinyint(1) not null default '1'");
@mysql_query("alter table ".$dbFIX."config add cache_time int(11) not null default '600'");
@mysql_query("alter table ".$dbFIX."config add use_cache tinyint(1) not null default '0'");
@mysql_query("create table ".$dbFIX."rss ( uid int(11) not null auto_increment, url varchar(255) not null default '', name varchar(100) not null default '', primary key(uid), key(name))");
@mkdir('../cache/', 0705);
@chmod('../cache/', 0707);
@chmod('../theme/', 0707);

@mysql_query("alter table {$dbFIX}user add nickname varchar(50) not null default ''");
@mysql_query("alter table {$dbFIX}user add self_info varchar(255) not null default ''");
@mysql_query("alter table {$dbFIX}user add signdate int(11) not null default '0'");
@mysql_query("CREATE TABLE IF NOT EXISTS `{$dbFIX}memo_comment` (
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
)");
@mysql_query("CREATE TABLE IF NOT EXISTS `{$dbFIX}memo_config` (
  `uid` int(11) NOT NULL auto_increment,
  `opt` varchar(50) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`uid`),
  KEY `opt` (`opt`)
)");
@mysql_query("
CREATE TABLE IF NOT EXISTS `gbl_memo_post` (
  `uid` int(11) NOT NULL auto_increment,
  `member_key` int(11) NOT NULL default '0',
  `name` varchar(100) NOT NULL default '',
  `content` varchar(255) NOT NULL default '',
  `signdate` int(11) NOT NULL default '0',
  PRIMARY KEY  (`uid`),
  KEY `member_key` (`member_key`),
  KEY `signdate` (`signdate`)
)");
$is112 = @mysql_query("create table ".$dbFIX."image ( uid int(11) not null auto_increment, file_route varchar(255) not null default '', signdate int(11) not null default '0', primary key(uid))");
$checkImgTbl = @mysql_fetch_array(mysql_query("select signdate from {$dbFIX}image where uid = 1"));
if(!$checkImgTbl[0]) {
	// 종달새 이전 포스트들에서 첨부된 그림파일들 DB에 등록
	$imgOpen = @opendir('../data/');
	while($readImg = @readdir($imgOpen)) {
		if($readImg == '.' || $readImg == '..' || $readImg == 'file' || $readImg == 'photo') continue;
		@mysql_query("insert into {$dbFIX}image set uid = '', file_route = 'data/{$readImg}', signdate = '".filectime('../data/'.$readImg)."'");
	}

	// 종달새 이전 포스트들의 \n to <br /> 변경
	$getList = @mysql_query('select uid, content from '.$dbFIX.'post');
	while($br = @mysql_fetch_array($getList)) {
		$content = addslashes(str_replace('<br /><br />', '<br />', $br['content']));
		@mysql_query("update {$dbFIX}post set content = '$content' where uid = ".$br['uid']);
	}
}

@mysql_query("ALTER TABLE `{$dbFIX}category` add `depth` INT(11) NOT NULL DEFAULT '0'");

// 전역변수 $grblog 를 db_info.php 에 저장, .htaccess 파일 생성
if(!$grblog) {
	$grblog = str_replace('/update/index.php', '', $_SERVER['SCRIPT_NAME']);
	@chmod('../db_info.php', 0707);
	@unlink('../db_info.php');
	$dbInfo = '<?php'."\n";
	$dbInfo .= '$hostName = \''.$hostName.'\';'."\n";
	$dbInfo .= '$userId = \''.$userId.'\';'."\n";
	$dbInfo .= '$password = \''.$password.'\';'."\n";
	$dbInfo .= '$dbName = \''.$dbName.'\';'."\n";
	$dbInfo .= '$dbFIX = \''.$dbFIX.'\';'."\n";
	$dbInfo .= '$GLOBALS[\'grblog\'] = \''.$grblog.'/\';'."\n";
	$dbInfo .= '?>';
	$fp = @fopen('../db_info.php', 'w');
	@fwrite($fp, $dbInfo);
	@fclose($fp);
	@chmod('../db_info.php', 0404);
	$fpHtaccess = @fopen('../.htaccess', 'w');
	$hta = '<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase '.$grblog.'
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.+)$ mod_rewrite.php/$1 [QSA]
RewriteRule ^$ - [L]
</IfModule>';
	@fwrite($fpHtaccess, $hta);
	@fclose($fpHtaccess);
	@chmod('../.htaccess', 0707);
}

// <dbFIX>reply_catch 테이블 생성
@mysql_query("create table `{$dbFIX}reply_catch` ( uid int(11) not null auto_increment, blog_title varchar(255) not null default '', blog_url varchar(255) not null default '', ".
	"post_title varchar(255) not null default '', post_uid int(11) not null default '0', r1_url varchar(255) not null default '', r1_body text, ".
	"r2_url varchar(255) not null default '', r2_body text, signdate int(11) not null default '0', primary key(uid), key(blog_url), key(post_uid))");

// 방명록 테이블 생성
@mysql_query("create table `{$dbFIX}guestbook` ( uid int(11) not null auto_increment, name varchar(50) not null default '', password char(32) not null default '', ".
	"homepage varchar(255) not null default '', content text, is_secret tinyint(2) not null default '0', is_reply tinyint(2) not null default '0', ".
	"signdate int(11) not null default '0', email varchar(100) not null default '', primary key(uid), key(is_reply))");

// 포스트별 댓글 수 수정 (이전 버전에서의 버그로 인해 생긴 숫자틀림 수정)
$bugfixMsg = '';
$getPost = @mysql_query('select uid, comment_count from '.$dbFIX.'post');
while($po = @mysql_fetch_array($getPost)) {
	$getCoNum = @mysql_fetch_array(mysql_query('select count(*) from '.$dbFIX.'comment where post_uid = '.$po['uid']));
	if($po['comment_count'] != $getCoNum[0]) {
		@mysql_query("update ".$dbFIX."post set comment_count = '".$getCoNum[0]."' where uid = '".$po['uid']."'");
		$bugfixMsg .= $po['uid'].'번 게시물의 댓글 수가 실제와 달라 바로잡았습니다.<br />';
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GR Blog Upgrade: v1.0.9 Beta #2.5 ▶▶▶ v1.1.4 "황조롱이"</title>
</head><body>

<h2>GR Blog 업데이트가 완료되었습니다!</h2>

<strong>업데이트 내역</strong>
<ul>
	<li>방명록 용도로 사용할 테이블 추가</li>
	<li>Apache 웹서버의 mod_rewrite 기능을 활용하기 위한 $grblog 전역변수 db_info.php 에 추가</li>
	<li>다중 카테고리 지원을 위한 카테고리 테이블 수정 (depth 컬럼 추가)</li>
	<li>GR Blog 멤버 정보를 담는 테이블에 nickname, self_info 필드가 누락되어 등록되지 않던 문제 수정</li>
	<li>종달새 업그레이드 이전에 줄바꿈이 \n 로 되어 있던 것을 &lt;br /&gt; 태그로 변경해서 DB에 넣음 (기본 테마 사용 강력추천!!!)</li>
	<li>페이지 캐쉬 저장시간을 설정하기 위해 cache_time 컬럼을 추가하고, /theme/ 디렉토리 퍼미션(권한)을 707로 변경합니다.</li>
	<li>멀티블로깅을 위한 사용자 목록 테이블을 생성 하였습니다.</li>
	<li>멀티블로깅 시 사용자 ID를 저장하기 위해 글/코멘트 테이블을 수정 하였습니다.</li>
	<li>페이지별 포스트를 캐쉬로 저장하여 추후 글읽기시 해당 게시물을 클릭하면 해당 페이지가<br />
	HTML로 대체출력하도록 할 것인지 정할 수 있는 make_html 이란 컬럼을 추가하고, /cache/ 디렉토리를 생성했습니다.</li>
	<li>하나의 DB에 다중 GR블로그 설치를 지원하기 위한 멀티 테이블을 지원합니다. (db_info.php 파일의 $dbFIX 참조)</li>
	<li>이전 버전 버그로 인해 생긴 코멘트 댓글 수 수정합니다.
	<?php if($bugfixMsg) { ?><ul><li>(<?php echo $bugfixMsg; ?>)</li></ul><?php } ?></li>
	<br />
	</li>
</ul>
<strong>※ 업데이트 해주셔서 감사합니다!</strong>

</body></html>