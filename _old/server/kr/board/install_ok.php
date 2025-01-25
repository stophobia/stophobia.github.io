<?php
// 기본 클래스를 부른다
include 'class/common.php';
$GR = new COMMON;

// 넘어온 값들을 처리한다.
if(array_key_exists('hostName', $_POST)) $hostName = $_POST['hostName'];
if(array_key_exists('userId', $_POST)) $userId = $_POST['userId'];
if(array_key_exists('password', $_POST)) $password = $_POST['password'];
if(array_key_exists('dbName', $_POST)) $dbName = $_POST['dbName'];
if(array_key_exists('dbFIX', $_POST)) $dbFIX = $_POST['dbFIX'];

// 받은 DB 정보가 올바른지 테스트한다.
@mysql_connect($hostName, $userId, $password) or 
	$GR->error('입력하신 DB 정보가 올바르지 않습니다.<br />다시 한번 확인하신 후 입력해 주세요.'.
	'<br />만약 자신의 DB 접속정보가 기억나지 않을 경우 서버관리자분에게'.
	'<br />접속정보를 알려 달라고 요청해 보세요.', 0, 'install.php');

// root 권한시 없는 DB명이 입력되면 DB를 아예 만들어줌
$isDBName = @mysql_select_db($dbName);
if(!$isDBName) {
	if($userId == 'root') {
		@mysql_query('create database '.$dbName);
	} else {
		$GR->error('입력하신 DB이름은 올바른 이름이 아닙니다.<br />DB 이름을 다시 입력해 주세요.', 0, 'install.php');
	}
}

// 올바르다면 계속 진행한다. db_info.php 파일을 생성한다.
$saveDbInfo  = '<?php'."\n";
$saveDbInfo .= '$hostName = \''.$hostName.'\';'."\n";
$saveDbInfo .= '$userId = \''.$userId.'\';'."\n";
$saveDbInfo .= '$password = \''.$password.'\';'."\n";
$saveDbInfo .= '$dbName = \''.$dbName.'\';'."\n";
$saveDbInfo .= '$dbFIX = \''.$dbFIX.'\';'."\n";
$saveDbInfo .= '$timeDiff = 0;'."\n";
$saveDbInfo .= '@mysql_connect($hostName, $userId, $password);'."\n";
$saveDbInfo .= '@mysql_select_db($dbName);'."\n";
$saveDbInfo .= '#@mysql_query(\'set names utf8\'); // 한글이 깨져보일 경우 이 줄 맨 앞에 # 을 제거'."\n";
$saveDbInfo .= '?>'."\n";
$fileCreate = @fopen('db_info.php', 'w') or 
	$GR->error('파일 쓰기 권한이 없습니다. 설치 디렉토리의 퍼미션(권한)을 확인하세요.<br />'.
	'설치폴더의 퍼미션은 707 혹은 777 을 권장합니다.', 0, 'install.php');
@fwrite($fileCreate, $saveDbInfo);
@fclose($fileCreate);
@chmod('db_info.php', 0404);

// 멤버등록 옵션 정보 파일을 생성한다.
$config = '<?php'."\n";
$config.= '$enableJoin = 1;'."\n";
$config.= '$enableNameTag = 1;'."\n";
$config.= '$enablePhoto = 1;'."\n";
$config.= '$enableJumin = 0;'."\n";
$config.= '$enableIcon = 1;'."\n";
$config.= '?>';
$fp = @fopen('config_member.php', 'w');
@fwrite($fp, $config);
@fclose($fp);
@chmod('config_member.php', 0707);

// session, data, passwd 저장폴더를 생성한다.
if(!is_dir('session')) {
	@mkdir('session', 0705);
	@chmod('session', 0707);
}
if(!is_dir('data')) {
	@mkdir('data', 0705);
	@chmod('data', 0707);
}
if(!is_dir('passwd')) {
	@mkdir('passwd', 0705);
	@chmod('passwd', 0707);
}
if(!is_dir('icon')) {
	@mkdir('icon', 0705);
	@chmod('icon', 0707);
}
if(!is_dir('member')) {
	@mkdir('member', 0705);
	@chmod('member', 0707);
}

$grboard = str_replace('/install_ok.php', '', $_SERVER['PHP_SELF']);
$str = <<<REWRITE
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase {GRBOARD_PATH}
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.+)$ mod_rewrite.php/$1 [QSA]
RewriteRule ^$ - [L]
</IfModule>
REWRITE;
$fp = @fopen('no.use.htaccess', 'w');
@fwrite($fp, str_replace('{GRBOARD_PATH}', $grboard, $str));
@fclose($fp);
@chmod('no.use.htaccess', 0707);

// 작성된 DB 접속정보를 통해 DB에 접속하고 필요한 테이블을 생성한다.
$GR->dbConn();
include 'db_make_query.php';
$cntQue = @count($que);
for($q=0; $q<$cntQue; $q++) @mysql_query($que[$q]);

// 문서설정
$title = 'GR Board Install Check';
$encoding = 'utf-8';
include 'html_head.php';
?>
<body>

<script type="text/javascript">//<![CDATA[
alert('축하합니다. GR Board 의 설치를 모두 마쳤습니다.\n\n관리자를 등록하러 갑니다.');
location.href='join.php';
//]]></script>

<p><strong>※ 자동으로 페이지를 이동하지 못했습니다.</strong>
자바스크립트를 사용할 수 없는 환경인 것 같습니다.</p>

<p>직접 이동하실 수 있습니다. <a href="join.php" title="여기를 클릭하세요!">[여기를 눌러 관리자를 등록하세요!]</a></p>

</body>
</html>