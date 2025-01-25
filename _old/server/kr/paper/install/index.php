<?php
/*
   GR Paper 설치 파일
   작성자: 박희근 (http://sirini.net)
   수정일: 2008-08-22
   내  용: 처음 설치할 때 이 곳에서 설치를 한다.
*/

// 기본 설정 부르기
if($_GET['step']) $step = $_GET['step']; elseif($_POST['step']) $step = $_POST['step']; else $step = 1;
$isInstallOk = true;
$c->dirName = str_replace('/install/index.php', '', $_SERVER['SCRIPT_NAME']);
include '../config/base.php';

// 이미 설치되어 있다면 실행하지 않음
if($step < 3 && file_exists('../db.info.php')) die('이미 설치되어 있습니다. (GR Paper is already installed.)');

// 설치 2단계 후처리
if($step == 2 && $_POST['hostname']) {
	if($_POST['userid'] == 'root') {
		$db = new mysqli($_POST['hostname'], $_POST['userid'], $_POST['password'], $_POST['dbname']);
		if(mysqli_connect_errno()) {
			$db = new mysqli($_POST['hostname'], $_POST['userid'], $_POST['password']);
			$db->query('create database '.$_POST['dbname'].' default character set utf8 collate utf8_general_ci ');
			$db->select_db($_POST['dbname']);
		}
	} else {
		$db = new mysqli($_POST['hostname'], $_POST['userid'], $_POST['password'], $_POST['dbname']);
	}
	if(mysqli_connect_errno()) {
		die('<script type="text/javascript"> alert(\'접속정보가 올바르지 않습니다. 다시 입력해 주세요.\'); location.href=\''.$config['absPath'].'/install/?step=2\'; </script>');
	}
	
	include '../library/file.php';
	$f = new GRFILE();
	$connInfo = '<?php'."\n".'$dbinfo[\'hostname\'] = \''.$_POST['hostname'].'\';'."\n".'$dbinfo[\'userid\'] = \''.$_POST['userid'].'\';'."\n"
		.'$dbinfo[\'password\'] = \''.$_POST['password'].'\';'."\n".'$dbinfo[\'dbname\'] = \''.$_POST['dbname'].'\';'."\n"
		.'$dbinfo[\'prefix\'] = \''.$_POST['dbfix'].'\';'."\n".'$config[\'dirName\'] = \''.$c->dirName.'\';'."\n"
		.'$db = new mysqli($dbinfo[\'hostname\'], $dbinfo[\'userid\'], $dbinfo[\'password\'], $dbinfo[\'dbname\']);'."\n?>";
	$f->write('../db.info.php', $connInfo);
	
	$dbinfo['prefix'] = $_POST['dbfix'];
	include 'db.make.query.php';
	for($i=0; $i<count($que); $i++) {
		$db->query($que[$i]);
	}
	
	@mkdir('../session');
	@chmod('../session', 0707);
	@mkdir('../cache');
	@chmod('../cache', 0707);
	
	include '../library/common.php';
	$c = new GRCOMMON('../');
	$c->move($config['absPath'].'/install/?step=3');	
}

// 설치 3단계부터 전처리
if($step > 2) {
	include '../library/common.php';
	$c = new GRCOMMON('../');
}

// 설치 3단계 후처리
if($step == 3 && $_POST['id']) {
	if(!$_POST['id'] || !$_POST['password'] || !$_POST['name'] || !$_POST['email']) $c->alert('입력해야 할 항목을 모두 입력해 주세요.', $config['absPath'].'/install/?step=3');
	$id = trim($_POST['id']);
	$password = md5(trim($_POST['password']));
	$name = addslashes(trim($_POST['name']));
	$email = trim($_POST['email']);
	$c->db->query('insert into '.$c->prefix."user set uid = '', id = '$id', password = '$password', name = '$name', email = '$email'");
	$c->move($config['absPath'].'/install/?step=4');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="<?php echo $config['version']; ?>" />
<meta name="Author" content="<?php echo $config['author']; ?>" />
<meta name="Nationality" content="Republic of Korean" />
<title>GR Paper Installation</title>
<link rel="stylesheet" href="<?php echo $config['absPath']; ?>/css/install.css" type="text/css" title="style" />
</head>
<body>

	<div id="logo"><img src="<?php echo $config['absPath']; ?>/image/grpaper-install.gif" alt="GR Paper Installation" /></div>

	<div id="boxLayout">
	
	<?php
	// 설치 1단계 : 안내하기
	if($step == 1) { ?>
		<div id="welcome">
		<strong>GR Paper 설치화면에 오신 것을 환영합니다!</strong><br />
		GR Paper 는 RSS 를 수집/관리/출력해주는 설치형 메타블로그입니다.<br />
		등록한 RSS 주소를 통해 수집한 데이터를 저장하고, 스킨 디자인을 통해서<br />
		외부로 보여줄 수 있습니다.<br />
		<br />
		설치를 위해서는 서버 환경이 아래의 조건을 만족해야 합니다.<br />
		<ul>
			<li>PHP 5 이상 (GD, simpleXML 가능)</li>
			<li>MySQL 5 이상 (MySQLi 지원 가능)</li>
		</ul>
		그리고 RSS 수집과 처리를 위해서는 일반적인 환경보다 좀 더 좋은 성능의 서버 자원이 필요합니다.<br />
		일반적으로 여러명이 함께 사용하는 웹호스팅 환경에서는 서버에 부담을 줄 수 있습니다.<br />
		<span class="recommand">(* 즉 독립된 서버에 설치하여 사용하시는 것을 권장합니다.)</span><br />
		<br />
		라이센스는 GPL 입니다. 코드는 공유하고 즐거움은 함께 합니다.<br />
		<?php if(!is_writable('../')) echo '<span class="alert">※ GR Paper 디렉토리 전체의 퍼미션(접근 권한)을 707 로 변경해 주세요!</span>'; ?>
		</div>
		<strong>※  서버환경 확인</strong><br />
		<ul>
			<li>운영체제: <?php echo PHP_OS; ?></li>
			<li>PHP 버젼: <?php echo PHP_VERSION; ?> 
				(<?php if (version_compare(PHP_VERSION, '5.0.0', '<')) {
					echo '<span class="alert">설치불가</span>';
					$isInstallOk = false;
					} else echo '설치가능'; ?>)</li>
			<li>Zend 버젼: <?php echo zend_version(); ?></li>
			<li>simpleXML 확장: <?php echo ((function_exists('simplexml_load_file'))?'사용가능':'<span class="alert">사용불가</span>'); ?></li>
			<li>MySQLi 확장: <?php echo ((function_exists('mysqli_connect'))?'사용가능':'<span class="alert">사용불가</span>'); ?></li>
			<li>iconv() : <?php echo ((function_exists('iconv'))?'사용가능':'<span class="alert">사용불가</span>'); ?></li>
			<li>GD 확장: <?php $gd = gd_info(); echo $gd['GD Version']; ?></li>
			<li>mb_substr(): <?php echo ((function_exists('mb_substr'))?'사용가능':'<span class="alert">사용불가</span>'); ?></li>
			<li>GR Paper 디렉토리 퍼미션: <?php echo ((is_writable('../'))?'사용가능':'<span class="alert">사용불가</span>'); ?></li>
		</ul>
		<?php if($isInstallOk) {?>
		<div id="btn"><input type="button" class="next" value="설치를 계속합니다" onclick="location.href='<?php echo $config['absPath']; ?>/install/?step=2';" /></div>
		<?php } 
		
	// 설치 2단계 : DB접속정보 받기
	} elseif($step == 2) { ?>
		<div id="welcome">
		<strong>MySQL DB 접속정보를 입력해 주세요!</strong><br />
		MySQL DB에 접속할 수 있는 1. 호스트네임 2. 아이디 3. 비밀번호 4. 접속대상DB명을 입력해 주세요.<br />
		5. 테이블 구분자는 초기 설치시 기본값 그대로 두셔도 됩니다. (추가 설치시에는 바꿔주세요.)<br />
		MySQLi 확장이 지원되지 않으면 DB접속정보가 올바르다 하더라도 설치되지 않습니다.<br />
		웹호스팅 사용자 분들은 MySQLi 확장이 지원되지 않을 수 있으니 서버 관리자에게 문의해 보세요.<br />
		<span class="recommand">* 가급적 독립된 서버환경에서 설치하시길 바랍니다. 웹호스팅 사용시 서버에 부담이 갈 수 있습니다.</span>
		</div>
		<strong>※ DB접속정보 입력</strong></span>
		<form id="dbconn" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<div><input type="hidden" name="step" value="2" /></div>
		<ol>
			<li><input type="text" class="i" name="hostname" value="localhost" /> (호스트네임)</li>
			<li><input type="text" class="i" name="userid" /> (아이디)</li>
			<li><input type="password" class="i" name="password" /> (비밀번호)</li>
			<li><input type="text" class="i" name="dbname" /> (접속대상DB명)</li>
			<li><input type="text" class="i" name="dbfix" value="gp_" /> (테이블구분자)</li>
		</ol>
		<div id="btn"><input type="submit" class="next" value="DB접속정보 입력완료" /></div>
		</form>
	
	<?php 
	// 설치 3단계: 설치 완료 안내, 관리자 정보 입력
	} elseif($step == 3) { ?>
		<div id="welcome">
		<strong>관리자 정보를 등록해 주세요!</strong><br />
		내 손으로 만드는 메타블로그, GR Paper 의 설치가 정상적으로 완료되었습니다.<br />
		설치된 GR Paper 를 관리할 관리자 정보를 등록하기 위해 아래의 항목들을 입력해 주세요.<br />
		</div>
		<strong>※ 관리자 정보 입력</strong><br />
		<form id="adminInfo" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<div><input type="hidden" name="step" value="3" /></div>
		<ol>
			<li><input type="text" name="id" class="i" value="admin" /> (관리자 ID)</li>
			<li><input type="password" class="i" name="password" /> (비밀번호)</li>
			<li><input type="text" class="i" name="name" /> (이름)</li>
			<li><input type="text" class="i" name="email" /> (이메일)</li>			
		</ol>
		<div id="btn"><input type="submit" class="next" value="관리자 접속정보 입력완료" /></div>
		</form>
		
	<?php 
	// 설치 마지막 단계: 완료 안내
	} elseif($step == 4) { ?>
		<div id="welcome">
		<strong>수고하셨습니다!</strong><br />
		설치를 마치고 관리자 정보를 모두 등록하였습니다.<br />
		아래 "로그인 하러 가기" 버튼을 눌러 로그인 페이지로 이동하신 후,<br />
		로그인 하여 관리자 페이지로 접속하시면 됩니다.<br />
		관리자 페이지에서는 피드 주소 등록부터 디자인 관리까지 다양한 설정을 통해<br />
		나만의 메타블로그 웹사이트를 만드실 수 있습니다.<br />
		</div>
		<span class="recommand">※ 관리자로 로그인해 주세요!</span>
		<div id="btn"><input type="button" class="next" value="로그인 하러 가기" onclick="location.href='<?php echo $config['absPath']; ?>/login/';" /></div>
	<?php } ?>
	
	</div>

</body>
</html>

