<?php
// 미설치시 설치화면으로
if(!file_exists('db.info.php')) die('<script type="text/javascript"> location.href=\'./install/\'; </script>');

// 초기설정
include 'class/common.php';
$core = new Common('.');

// 설정변경
if($_POST['isUpdate']) {
	include 'passwd.php';
	if($coreAdminPasswd != md5($_POST['corePass'])) $core->alert('비밀번호가 맞지 않습니다.', './');
	$connInfo = '<?php'."\n".'$dbinfo[\'hostname\'] = \''.$core->dbinfo['hostname'].'\';'."\n".'$dbinfo[\'userid\'] = \''.$core->dbinfo['userid'].'\';'."\n"
		.'$dbinfo[\'password\'] = \''.$core->dbinfo['password'].'\';'."\n".'$dbinfo[\'dbname\'] = \''.$core->dbinfo['dbname'].'\';'."\n"
		.'$dbinfo[\'setUTF8\'] = '.(($_POST['setUTF8'])?'true':'false').';'."\n"
		.'$coreConfig[\'grcore\'] = \''.$_POST['grcore'].'\';'."\n"
		.'$coreConfig[\'grboard\'] = \''.$_POST['grboard'].'\';'."\n".'$coreConfig[\'grblog\'] = \''.$_POST['grblog'].'\';'."\n"
		.'$coreConfig[\'grcounter\'] = \''.$_POST['grcounter'].'\';'."\n".'$coreConfig[\'grnote\'] = \''.$_POST['grnote'].'\';'."\n"
		.'$coreConfig[\'grpaper\'] = \''.$_POST['grpaper'].'\';'."\n".'$coreConfig[\'grshop\'] = \''.$_POST['grshop'].'\';'."\n?>";
	$core->fileWrite('db.info.php', $connInfo);

	if($_POST['grboard']) {
		@include $_POST['grboard'].'/db_info.php';
		@unlink($_POST['grboard'].'/core.php');
		$core->fileWrite($_POST['grboard'].'/core.php', '<?php $grcore = \''.$_POST['grcore'].'\'; $dbFIX = \''.$dbFIX.'\'; $timeDiff = \''.$timeDiff.'\'; ?>');
	}
	if($_POST['grblog']) {
		@include $_POST['grblog'].'/db_info.php';
		@unlink($_POST['grblog'].'/core.php');
		$core->fileWrite($_POST['grblog'].'/core.php', '<?php $grcore = \''.$_POST['grcore'].'\'; $dbFIX = \''.$dbFIX.'\'; $GLOBALS[\'grblog\'] = \''.$GLOBALS['grblog'].'\'; ?>');
	}
	if($_POST['grcounter']) {
		@unlink($_POST['grcounter'].'/core.php');
		$core->fileWrite($_POST['grcounter'].'/core.php', '<?php $grcore = \''.$_POST['grcore'].'\'; $dbFIX = \'gc_\'; ?>');
	}
	if($_POST['grnote']) {
		@include $_POST['grnote'].'/db.info.php';
		@unlink($_POST['grnote'].'/core.php');
		$core->fileWrite($_POST['grnote'].'/core.php', '<?php $grcore = \''.$_POST['grcore'].'\'; $dbFIX = $divide = \''.$divide.'\'; ?>');
	}
	if($_POST['grpaper']) {
		@include $_POST['grpaper'].'/db.info.php';
		@unlink($_POST['grpaper'].'/core.php');
		$core->fileWrite($_POST['grpaper'].'/core.php', '<?php $grcore = \''.$_POST['grcore'].'\'; $dbFIX = $dbinfo[\'prefix\'] = \''.$dbinfo['prefix'].'\'; $config[\'dirName\'] = \''.$config['dirName'].'\'; ?>');
	}

	$core->alert('설정을 변경하였습니다.', './');
}

// 경로 확인용으로 인클루드
include 'db.info.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="GR Core" />
<meta name="Author" content="박희근 Hee Geun Park" />
<meta name="Nationality" content="Republic of Korean" />
<link rel="stylesheet" href="install/style.css" type="text/css" title="style" />
<title>GR Core <?php echo $core->version; ?> - 연동설정</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="index.js"></script>
</head>
<body>

	<div id="main">

		<div id="logo"><img src="install/img/logo.gif" alt="GR Core" /></div>

		<form id="setDirName" method="post" onsubmit="return checkPass(this);" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<div><input type="hidden" name="isUpdate" value="1" /></div>
		<div id="license" style="display: none">
		GR Core 와 연동할 GR시리즈 도구들 각각의 상대경로를 재지정합니다. (없을 시 빈 칸으로 표기)	<br />
		<?php if(!is_writable('db.info.php')) { ?>
			<span style="color: yellow">GR Core 디렉토리 안에 있는 db.info.php 파일의 퍼미션을 707로 변경해주세요!</span>
		<?php } ?>
		<span id="help" class="cursor">[도움말 보기]</span><br />
		<div id="example" style="display: none">
			<img src="install/img/example-ftp.gif" alt="Example" /><br />
			위의 예제화면은 FTP 프로그램상에서 본 모습입니다. /public_html/ 아래에 grcore, grboard, grcounter 등이<br />
			나란히 보여지고 있습니다. 위의 경우엔 아래 작성된 폼을 그대로 유지하셔도 됩니다.<br />
			(아래 경로 작성하실 때, 경로 끝에 '/' 슬래시는 적지 마세요.)<br />
			<br />
			<strong>※ 설치 경로 팁</strong><br />
			설치경로는 되도록이면 위 스크린샷처럼 grcore 부터 grshop 까지 한 번에 모두 보이도록<br />
			동일한 폴더 아래 (권장: /public_html/ 혹은 /www/ 아래에) 업로드 하시는 게 좋습니다.<br />
			폴더명이나 업로드 된 경로가 예제와 같을 경우, 이 곳에서 별도로 수정하실 것들은 없습니다.<br />
		</div>
			<ol>
				<li><input type="text" name="grcore" value="<?php echo $coreConfig['grcore']; ?>" class="i" /> : GR Core 상대경로 (아래 GR시리즈들이 참고할 경로)</li>
				<li><input type="text" name="grboard" value="<?php echo $coreConfig['grboard']; ?>" class="i" /> : GR Board 상대경로</li>
				<li><input type="text" name="grblog" value="<?php echo $coreConfig['grblog']; ?>" class="i" /> : GR Blog 상대경로</li>
				<li><input type="text" name="grcounter" value="<?php echo $coreConfig['grcounter']; ?>" class="i" /> : GR Counter 상대경로</li>
				<li><input type="text" name="grnote" value="<?php echo $coreConfig['grnote']; ?>" class="i" /> : GR Note 상대경로</li>
				<li><input type="text" name="grpaper" value="<?php echo $coreConfig['grpaper']; ?>" class="i" /> : GR Paper 상대경로</li>
				<li><input type="text" name="grshop" value="<?php echo $coreConfig['grshop']; ?>" class="i" /> : GR Shop 상대경로</li>
			</ol>
			<ul id="options">
				<li><input type="checkbox" name="setUTF8" value="true"<?php echo ($dbinfo['setUTF8'])?' checked="checked"':''; ?> /> 한글이 깨져 보이면 이 곳을 선택하세요! (set names utf8)</li>
				<li>Core 관리자 비밀번호 입력: <input type="password" name="corePass" class="i" /> (비밀번호가 맞지 않으면 변경되지 않습니다.)</li>
			</ul>
			아래 버튼을 클릭하여 상대경로 지정을 마무리 합니다.
			</div>
			<div id="next"><input type="submit" value="설정 저장" /></div>
		</div>
		</form>

	</div>
	
</body>
</html>