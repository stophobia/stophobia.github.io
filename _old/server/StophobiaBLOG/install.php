<?php
@header('Content-Type: text/html; charset=utf-8');
include 'lib/common.php';
if(array_key_exists('step', $_GET) && $_GET['step']) $step = $_GET['step'];
@extract($_POST);
if(!isset($step))
{
	$step = 1;
}
if(array_key_exists('step', $_POST) && $_POST['step'] == 3)
{
	if(!@mysql_connect($hostName, $userId, $password))
		error('입력하신 DB정보(호스트네임, DB아이디, DB비밀번호)가 올바르지 않습니다');
	if(!@mysql_select_db($dbName))
		error('입력하신 DB정보(DB이름)가 올바르지 않습니다');
	$dbInfo = '<?php'."\n";
	$dbInfo .= '$hostName = \''.$hostName.'\';'."\n";
	$dbInfo .= '$userId = \''.$userId.'\';'."\n";
	$dbInfo .= '$password = \''.$password.'\';'."\n";
	$dbInfo .= '$dbName = \''.$dbName.'\';'."\n";
	$dbInfo .= '$dbFIX = \''.$preFIX.'\';'."\n";
	$dbInfo .= '$GLOBALS[\'grblog\'] = \''.str_replace('/install.php', '', $_SERVER['SCRIPT_NAME']).'/\';'."\n";
	$dbInfo .= '?>';
	$fp = @fopen('db_info.php', 'w');
	@fwrite($fp, $dbInfo);
	@fclose($fp);
	@chmod('db_info.php', 0404);
	dbConn();
	include 'db_make_query.php';
	for($i=0; $i<count($gblQue); $i++) 
		@mysql_query($gblQue[$i]) or error('DB Table 생성 실패: '.addslashes(mysql_error()));
	@mkdir('session', 0705);
	@chmod('session', 0707);
	@mkdir('data', 0705);
	@chmod('data', 0707);
	@mkdir('data/photo', 0705);
	@chmod('data/photo', 0707);
	@mkdir('cache', 0705);
	@chmod('cache', 0707);
	@chmod('image', 0707);
	@file_put_contents('get_cnt_conn.php', '0');
	$fpHtaccess = @fopen('.htaccess', 'w');
	$rewriteBase = str_replace('/install.php', '', $_SERVER['SCRIPT_NAME']);
	if(!$rewriteBase) $rewriteBase = '/';
	$hta = '<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase '.$rewriteBase.'
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.+)$ mod_rewrite.php/$1 [QSA]
RewriteRule ^$ - [L]
</IfModule>';
	@fwrite($fpHtaccess, $hta);
	@fclose($fpHtaccess);
	@chmod('.htaccess', 0707);
	move('install.php?step=4');
}
if(array_key_exists('step', $_POST) && $_POST['step'] == 5)
{
	dbConn();
	if(!trim($id)) error('아이디를 입력해 주세요 (예: admin)');
	if(!trim($password)) error('비밀번호를 입력해 주세요');
	if(!trim($name)) error('이름(닉네임)을 입력해 주세요 (예: 홍길동)');
	if(!trim($email)) error('이메일 주소를 입력해 주세요');
	if(!trim($blog_title)) error('블로그 이름을 입력해 주세요 (예: 홍길동의 블로그)');
	if(!trim($blog_info)) error('한줄 블로그 소개를 입력해 주세요 (예: 홍길동의 행복한 의적활동)');
	$configQue = "insert into ".$dbFIX."config set uid = '', id = '$id', password = '".md5($password)."', ".
		"name = '$name', homepage = '$homepage', email = '$email', blog_title = '$blog_title', ".
		"blog_info = '$blog_info', theme = '$theme', num_view_post = '$num_view_post', num_per_page = '$num_per_page', ".
		"num_rss_post = '$num_rss_post', num_rss_content = '$num_rss_content', use_trackback = '$use_trackback', ".
		"use_comment = '$use_comment', use_rss = '$use_rss', use_openid = '$use_openid'";
	@mysql_query($configQue) or 
		error('정보를 입력하지 못했습니다: '.addslashes(mysql_error()));
	move('login.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="GR Blog" />
<link rel="stylesheet" href="style.css" type="text/css" title="style" />
<title>GR Blog 설치화면</title>
<script type="text/javascript" src="js/install.js"></script>
</head>
<body>

<!-- 설치 대화 상자 -->
<div id="center">
	<div><img src="image/darkgray/top.install.logo.gif" alt="GR Blog Install" /></div>
	<div class="top">
	GR Blog 설치 대화상자: <?php echo $step; ?>단계
	</div>
	<div class="body">
	<div style="padding: 10px">
<?php if($step == 1) { if(file_exists('db_info.php')) error('이미 설치되어 있습니다', 'location.href=\'./\''); ?>
	GR Blog 설치 화면에 오신 것을 환영합니다!<br />
	GR Blog 는 <a href="http://sirini.net/blog" onclick="window.open(this.href, '_blank'); return false;">시리니</a>가 만든 작고 가벼운 블로그 도구 입니다.<br />
	GR Blog 를 사용하기 위해 PHP, MySQL 이 서버에 설치되어 있어야 하며,<br />
	자바스크립트를 사용할 수 있는 브라우저가 사용자 컴퓨터에 설치되어 있어야 합니다.<br />
	설치를 원하시면 설치를 계속해 주세요!<br />
	<br />
	<span style="color: #999">※ GR Blog 에 사용된 아이콘 중 일부는 famfamfam.com 에서,<br />
	그 밖에 각종 라이브러리들(prototype, script.aculo.us, lightbox_plus, ...),<br />
	또한 각종 프로그램들(phpThumb, tinyMCE, ...)은 각기 고유의<br />
	라이센스를 가지고 있으며, GR Blog 와는 상관 없음을 밝힙니다.<br />
	GR Blog 자체는 오픈소스 블로깅툴 입니다.</span><br />
	<br />
	<?php if(!is_writable('.')) { ?><strong>※ GR Blog 디렉토리(폴더)의 퍼미션(권한)을 707 로 변경해 주세요!</strong><?php } ?>
	<br />
	<p><a href="install.php?step=2"><img src="image/darkgray/button.install.continue.gif" alt="설치계속!" /></a></p>
<?php } elseif($step == 2) { ?>
	<form id="install" method="post" onsubmit="return dbInfo();" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<div><input type="hidden" name="step" value="3" /></div>
	GR Blog 는 PHP 와 MySQL 이 설치된 서버에서 사용하실 수 있습니다.<br />
	MySQL 접속 정보 <span>(호스트네임, DB아이디, DB비밀번호, DB이름)</span> 를 작성해 주세요.<br />
	<br />
	<ol>
		<li><input type="text" name="hostName" class="enter" value="localhost" /> 호스트이름 (대게 기본값 그대로 입니다.)</li>
		<li><input type="text" name="userId" class="enter" /> DB아이디</li>
		<li><input type="password" name="password" class="enter" /> DB비밀번호</li>
		<li><input type="text" name="dbName" class="enter" /> DB이름 (대게 DB아이디와 동일합니다.)</li>
		<li><input type="text" name="preFIX" class="enter" value="gbl_" /> 테이블명 접두어 (이 구분자로 테이블을 구분합니다.)</li>
	</ol>
	<input type="image" src="image/darkgray/button.input.done.gif" alt="입력완료!" />
	<br />
	<br />
	<strong>만약 위의 정보에 대해 잘 모르신다면</strong><br />
	이용하고 계시는 호스팅 업체에게 문의해 보시거나 계정을 제공한 분에게 물어보세요.<br />
	대게 호스트네임은 localhost 로 되어 있으며, DB아이디와 DB비밀번호는<br />
	FTP 접속시 사용하시는 계정아이디, 계정비밀번호와 각각 동일합니다.<br />
	또한 DB이름 역시 DB아이디(혹은 계정아이디)와 동일합니다.
	</form>
<?php } elseif($step == 4) { ?>
	<strong>GR Blog 설치가 완료되었습니다!</strong><br />
	<br />
	아래의 간단한 설정을 마치신 후 로그인 하시면 됩니다!<br />
	<span style="color: #aaa">(※ 아래 설정은 차후 관리화면에서 언제든지 변경 가능합니다.)</span>
	<form id="set" method="post" onsubmit="return setting(0);" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<div><input type="hidden" name="step" value="5" /></div>
	<div id="install">
	<table rules="none" summary="GR Blog Setting" cellpadding="0" cellspacing="0" border="0">
	<caption></caption>
	<colgroup>
	<col style="width: 150px" />
	<col />
	</colgroup>
	<thead>
	<tr>
		<th>설정항목</th>
		<th>설정값</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td class="l">아이디</td>
		<td class="r"><input type="text" class="t" name="id" value="admin" /></td>
	</tr>
	<tr>
		<td class="l">비밀번호</td>
		<td class="r"><input type="password" class="t" name="password" /></td>
	</tr>
	<tr>
		<td class="l">이름(닉네임)</td>
		<td class="r"><input type="text" class="t" name="name" value="주인장" /></td>
	</tr>
	<tr>
		<td class="l">홈페이지</td>
		<td class="r">
		<input type="text" class="t" name="homepage" value="http://<?php echo $_SERVER['HTTP_HOST'].str_replace('/install.php', '', $_SERVER['SCRIPT_NAME']); ?>" />
		</td>
	</tr>
	<tr>
		<td class="l">이메일</td>
		<td class="r"><input type="text" class="t" name="email" /></td>
	</tr>
	<tr>
		<td class="l">블로그 이름</td>
		<td class="r"><input type="text" class="t" name="blog_title" value="행복 블로그" /></td>
	</tr>
	<tr>
		<td class="l">한줄 블로그 소개</td>
		<td class="r"><input type="text" class="t" name="blog_info" value="행복함이 함께하는 블로그" /></td>
	</tr>
	<tr>
		<td class="l">블로그 테마(스킨)</td>
		<td class="r">
			<select name="theme">
			<?php
			$themeDir = @opendir('theme');
			while($theme = @readdir($themeDir)) { 
				if($theme == '.' or $theme == '..') continue; ?>
			<option value="<?php echo $theme; ?>"><?php echo $theme; ?></option>
			<?php } ?>
			</select>
		</td>
	</tr>
	<tr>
		<td class="l">한 페이지당 글 수</td>
		<td class="r"><input type="text" class="t" name="num_view_post" value="5" /></td>
	</tr>
	<tr>
		<td class="l">하단 페이지 출력 수</td>
		<td class="r"><input type="text" class="t" name="num_per_page" value="10" /></td>
	</tr>
	<tr>
		<td class="l">RSS 로 보일 글 수</td>
		<td class="r"><input type="text" class="t" name="num_rss_post" value="10" /></td>
	</tr>
	<tr>
		<td class="l">RSS 의 글 당 글자수</td>
		<td class="r"><input type="text" class="t" name="num_rss_content" value="0" /> '0' → 전부보기</td>
	</tr>
	<tr>
		<td class="l">트랙백(엮인글) 받기</td>
		<td class="r"><input type="checkbox" name="use_trackback" value="1" checked="checked" /> 체크하시면 외부에서 온 트랙백(엮인글)을 받습니다.</td>
	</tr>
	<tr>
		<td class="l">코멘트(댓글) 받기</td>
		<td class="r"><input type="checkbox" name="use_comment" value="1" checked="checked" /> 체크하시면 방문객이 코멘트를 남길 수 있도록 합니다.</td>
	</tr>
	<tr>
		<td class="l">RSS 외부로 보내기</td>
		<td class="r"><input type="checkbox" name="use_rss" value="1" checked="checked" /> 체크하시면 외부로 RSS 피드를 발송해 줍니다.</td>
	</tr>
	<tr>
		<td class="l">오픈아이디 허용하기</td>
		<td class="r"><input type="checkbox" name="use_openid" value="1" checked="checked" /> 체크하시면 오픈아이디를 허용 합니다.</td>
	</tr>
	<tr>
		<td colspan="2" class="b">
			<input type="image" src="image/darkgray/button.input.done.gif" alt="입력완료!" />
		</td>
	</tr>
	</tbody>
	</table>
	</div>
	</form>
<?php } ?>
	</div>
	</div>
</div>
<!--# 설치 대화 상자 -->

</body>
</html>