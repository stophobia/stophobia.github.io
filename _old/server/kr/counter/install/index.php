<?php
@header('Content-Type: text/html; charset=utf-8');
include '../class/Common.php';
$GC = new Common;
if(array_key_exists('step', $_GET) && $_GET['step']) $step = $_GET['step'];
@extract($_POST);
if(!isset($step))
{
	$step = 1;
	if(file_exists('../db_info.php')) $GC->error('이미 설치되어 있습니다');
}
if(array_key_exists('step', $_POST) && $_POST['step'] == 3)
{
	if(!@mysql_connect($hostName, $userId, $password)) $GC->error('입력하신 DB정보(호스트네임, DB아이디, DB비밀번호)가 올바르지 않습니다');
	if(!@mysql_select_db($dbName)) {
		if($userId == 'root') {
			@mysql_query('create database '.$dbName);
			@mysql_select_db($dbName);
		}
		else $GC->error('입력하신 DB정보(DB이름)가 올바르지 않습니다');
	}
	$dbInfo = '<?php'."\n";
	$dbInfo .= '$hostName = \''.$hostName.'\';'."\n";
	$dbInfo .= '$userId = \''.$userId.'\';'."\n";
	$dbInfo .= '$password = \''.$password.'\';'."\n";
	$dbInfo .= '$dbName = \''.$dbName.'\';'."\n";
	$dbInfo .= '$_conn = @mysql_connect($hostName, $userId, $password);'."\n";
	$dbInfo .= '$useExtremeMode = 0;'."\n";
	$dbInfo .= '@mysql_select_db($dbName);'."\n";
	$dbInfo .= '#@mysql_query(\'set names utf8\'); // 한글이 깨져나올 시 맨 앞 # 을 제거'."\n?>";
	$fp = @fopen('../db_info.php', 'w');
	@fwrite($fp, $dbInfo);
	@fclose($fp);
	@chmod('../db_info.php', 0707);
	include 'db_make_query.php';
	for($i=0; $i<count($gcQue); $i++) 
		@mysql_query($gcQue[$i]) or $GC->error('DB Table 생성 실패: '.addslashes(mysql_error()));
	@mkdir('../session', 0705);
	@chmod('../session', 0707);
	@mkdir('../cache', 0705);
	@chmod('../cache', 0707);
	$GC->move('./?step=4');
}
if(array_key_exists('step', $_POST) && $_POST['step'] == 5)
{
	$password = trim($password);
	if(!trim($password)) error('비밀번호를 입력해 주세요');
	@mysql_query("insert into gc_admin set uid = '', id = '$id', password = '".md5($password)."'");
	$GC->move('../login/index.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="GR Counter" />
<link rel="stylesheet" href="../style.css" type="text/css" title="style" />
<title>GR Counter 설치화면</title>
<script type="text/javascript" src="install.js"></script>
</head>
<body>

<!-- 설치 대화 상자 -->
<div id="center">
	<div style="height: 100px"></div>
	<div class="top">
	GR Counter 설치 대화상자: <?php echo $step; ?>단계
	</div>
	<div class="body">
	<div style="padding: 10px">
<?php if($step == 1) { ?>
	GR Counter 설치 화면에 오신 것을 환영합니다!<br />
	GR Counter 는 <a href="http://sirini.net" onclick="window.open(this.href, '_blank'); return false">시리니</a>가 
	만든 간편하게 설치하고 쉽게 사용할 수 있는<br />
	로그분석 카운터 프로그램 입니다.<br />
	사용을 위해 서버에 PHP와 MySQL이 설치되어 있어야 합니다.<br />
	설치를 원하시면 지금 바로 설치를 시작해 주세요!<br />
	<br />
	<span style="color: #999">※ GR Counter 에 사용된 아이콘 중 일부는 famfamfam.com 에서,<br />
	그 밖에 GR Counter 에서 사용된 각종 라이브러리들과 프로그램들은<br />
	(plotr, phpwhois, prototype, ...)<br />
	각각 고유의 라이센스를 가지고 있으며, GR Counter 와 상관 없을 수 있음을 밝힙니다.<br />
	GR Counter 자체는 오픈소스 프로그램 입니다. (자유롭게 쓰세요~)</span><br />
	<br />
	<?php if($GC->checkPerm('../') != 707) { ?><strong>※ GR Counter 디렉토리(폴더)의 퍼미션(권한)을 707 로 변경해 주세요!</strong><br /><?php } ?>
	<strong>※ GR Counter 재설치시 기존의 GR Counter TABLE들은 삭제됩니다!</strong><br />
	<br />
	<p><input type="button" class="btn" value="설치 시작!" onclick="location.href='./?step=2'" /></p>
<?php } elseif($step == 2) { ?>
	<form id="install" method="post" onsubmit="return dbInfo();" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<div><input type="hidden" name="step" value="3" /></div>
	GR Counter 는 PHP 와 MySQL 이 설치된 서버에서 사용하실 수 있습니다.<br />
	MySQL 접속 정보 <span>(호스트네임, DB아이디, DB비밀번호, DB이름)</span> 를 작성해 주세요.<br />
	<br />
	<div><input type="text" name="hostName" class="enter" value="localhost" />
	<input type="text" name="userId" class="enter" value="DB아이디" />
	<input type="password" name="password" class="enter" value="pass" />
	<input type="text" name="dbName" class="enter" value="DB이름" />
	<input type="submit" value="입력완료" class="ok" /></div>
	<br />
	<br />
	<strong>만약 위의 정보에 대해 잘 모르신다면</strong><br />
	이용하고 계시는 호스팅 업체에게 문의해 보시거나 계정을 제공한 분에게 물어보세요.<br />
	대게 호스트네임은 localhost 로 되어 있으며, DB아이디와 DB비밀번호는<br />
	FTP 접속시 사용하시는 계정아이디, 계정비밀번호와 각각 동일합니다.<br />
	또한 DB이름 역시 DB아이디(혹은 계정아이디)와 동일합니다.<br />
	<br />
	<span style="color: #000">※ 만약 GR Counter 를 재설치 하시는 것이라면, 기존 DB 를 백업 받으신 후
	진행하시는 것을 권장합니다. GR Counter 는 설치 전 기존에 GR Counter 데이터들만 골라서 모두 삭제한 후 깨끗한 상태로 설치될 것입니다!</span><br />
	</form>
<?php } elseif($step == 4) { ?>
	<strong>GR Counter 설치가 완료되었습니다!</strong><br />
	<br />
	아래의 간단한 설정을 마치신 후 관리자 화면에 접속 하시면 됩니다!<br />
	<form id="set" method="post" onsubmit="return setting();" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<div><input type="hidden" name="step" value="5" /></div>
	<div id="setting">
	<table rules="none" summary="GR Counter Setup" cellpadding="0" cellspacing="0" border="0">
	<caption></caption>
	<colgroup>
	<col style="width: 150px" />
	<col />
	</colgroup>
	<tbody>
	<tr>
		<td class="l">아이디</td>
		<td class="r"><input type="text" class="t" name="id" /></td>
	</tr>
	<tr>
		<td class="l">비밀번호</td>
		<td class="r"><input type="password" class="t" name="password" /></td>
	</tr>
	<tr>
		<td colspan="2" class="b">
			<input type="submit" value="완 료" />
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