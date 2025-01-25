<?php
/**
 * GR Forum Install Page
 * @author sirini
 * @update 2009-08-04
 * @comment GR포럼 설치화면
 */

@header('Content-Type: text/html; charset=utf-8');

$step = ($_GET['step']) ? $_GET['step'] : $_POST['step'];
if(!$step) $step = 1;

// 이미 설치된 상태라면 중지
if($step == 1 && file_exists('../core.php')) die('이미 설치되어 있습니다');

// DB 세팅, 설정 파일 생성
if($step == 2) {
	$grcore = $_POST['grcore'];
	$grid = $_POST['id'];

	if(!$grcore) {
		die('<script type="text/javascript"> alert(\'GR Core 가 설치된 상대경로를 입력해 주세요!\'); '.
			'location.href=\'./?step=1\'; </script>');
	}

	include '../'. $grcore . '/class/common.php';
	$core = new Common('../' . $grcore);
	include '../' . $core->config['grboard'] . '/db_info.php'; # $dbFIX 는 현재 GR Board 의 값을 가짐

	$forumFIX = 'gf_'; # GR Forum 의 기본 table prefix
	$grforum = str_replace('/install', '', str_replace('/'.end(explode('/', $_SERVER['REQUEST_URI'])), '', $_SERVER['REQUEST_URI']));
	$core->fileWrite('../core.php', '<?php $grcore = \'' . $grcore . '\'; $dbFIX = \'' . $forumFIX . '\'; $bbsFIX = \'' . $dbFIX . '\'; $grid = \'' . $grid . '\'; ?>');
	$core->fileWrite('../' . $core->config['grboard'] . '/core.grforum.php', '<?php $grforum = \'..' . $grforum . '\'; $forumFIX = \'' . $forumFIX . '\'; ?>');
	
	$dbFIX = $forumFIX; # $dbFIX 는 이제 GR Forum 의 값을 가짐
	include 'db.make.query.php';
	for($i=0; $i<count($que); $i++) {
		$core->query($que[$i]);
	}
	$core->move('./?step=3');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="GR Forum" />
<meta name="Author" content="박희근 Hee Geun Park" />
<meta name="Nationality" content="Republic of Korean" />
<meta name="copyright" content="Copyright ⓒ 2009 Hee Geun Park" />
<title>GR Forum Install Page</title>
<link rel="stylesheet" href="install.css" type="text/css" title="style" />
</head>
<body>

<div id="logo">GR Forum Install Page</div>

<div id="layout">
	
	<div id="info">

	<?php 
		// 설치 1단계
		if($step == 1) { ?>

	<form name="first" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<div><input type="hidden" name="step" value="2" /></div>
	
		<h3>GR Forum 설치화면에 오신 것을 환영합니다!</h3>
		<strong>GR Forum</strong> 은 <strong>GR Core</strong> 와 <strong>GR Board</strong> 를 기반으로하는 설치형 포럼입니다.<br />
		해외에서 주로 볼 수 있는 포럼형 사이트를 GR Forum 을 사용하면 쉽고 편하게 만드실 수 있습니다.<br />
		라이센스는 GPL v2 를 따릅니다. 코드는 공유하고, 즐거움은 함께 합니다. :)

		<h3>설치 전 준비되어야 할 사항은?</h3>
		▶ 서버에서 지원되어야 할 부분은 아래와 같습니다.
		<ul>
			<li>PHP 5 이상 (현재: <?php echo PHP_VERSION; ?>)</li>
			<li>PHP GD 2 확장 지원</li>
			<li>PHP MySQLi 확장 지원</li>
			<li>MySQL 5 이상</li>
			<li>Linux/UNIX 혹은 Microsoft Windows Server (현재: <?php echo PHP_OS; ?>)</li>
			<li>Apache2 웹서버 혹은 fastCGI in IIS</li>
		</ul>
		▶ 사용하시는 호스팅(서버) 계정에 미리 설치되어야 하는 웹 프로그램들은 아래와 같습니다.
		<ul>
			<li>GR Core (v0.9.2 이상)</li>
			<li>GR Board UTF-8 Edition (v1.8.3 이상)</li>
			<li>GR Counter (v1.3 이상, 선택사양)</li>
		</ul>
		<?php if(!is_writable('../')) { ?><span style="color: red; font-weight: bold">※ GR Forum 디렉토리의 퍼미션을 707 로 변경해주세요!</span><?php } ?>

		<h3>모든 준비가 끝나셨습니까?</h3>
		아래에 GR Core 의 상대경로를 지정해 주세요. 이 과정은 GR Shop 설치 때와 마찬가지로<br />
		아래의 그림을 보시면 상대경로를 어떻게 지정하는지 쉽게 이해하실 수 있습니다.<br />
		<img src="images/example-ftp.gif" alt="예제" /><br />
		만약 위 그림처럼 GR Core 와 GR Forum 폴더가 FTP 프로그램 내 목록화면에서 동시에 보이시고,<br />
		폴더 이름까지 위 그림처럼 "grcore" 라면 아래 입력칸을 수정할 필요 없습니다.<br />
		<br />
		<input class="i" type="text" name="grcore" value="../grcore" /> <input class="s" type="submit" value="바로 설치하기!" /><br />
		<br />
		또한 선택사양으로, GR Counter 와 연동하여 접속 통계를 확인해 보실 수 도 있습니다.<br />
		계정에 GR Counter 를 이미 설치하셨고, GR Forum 에서 사용할 수 있도록 ID 를 추가해 두셨다면<br />
		(가령 "grforum" 등...) 아래에 ID 를 입력해 주세요. (없을 시 그대로 비워두시면 됩니다.)<br />
		<br />
		<input class="i" type="text" name="id" value="" /> <input class="s" type="submit" value="연동 후 설치하기!" /><br />
		<br />
		설치가 완료되면 관리화면으로 넘어가기 위해 로그인 과정을 거치게 됩니다.<br />
		로그인 시 입력하실 아이디와 비밀번호는, GR Board 에서 관리자로 접속하실 때 입력하셨던 것과<br />
		동일합니다! GR Forum 은 이처럼 GR Board 와 유기적으로 연동되어 있으므로 만약 GR Board 가<br />
		아직 익숙치 않으신 분들은 GR Board 에서 게시판을 만들고, 스킨을 변경하는 것 등의 작업을<br />
		미리 해 보시길 바랍니다.

	</form>

	<?php } // 설치 1단계

	// 설치 2단계
	if($step == 2) { ?>

	... DB 작업중입니다 ...

	<?php } // 설치 2단계 
	
	// 설치 3단계
	if($step == 3) { ?>

	<h3>수고하셨습니다!</h3>
	설치가 모두 완료되었습니다. <a href="../login/">여기를 눌러 로그인을 해주세요!</a>

	<?php } ?>

	</div>
	
</div>


</body>
</html>