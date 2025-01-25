<?php
/**
 * GR Core Install Page
 * 작성자: sirini ( http://sirini.net , sirini@gmail.com )
 * 작성일: 2009-03-29
 * 내   용: Core 설치 페이지
 **/

// 헤더 설정
@header('Content-Type: text/html; charset=utf-8');
@error_reporting(0);

// 주요변수 설정
$step = $_GET['step'];
if(!$step) $step = 1;

// 이미 설치되어 있는지 확인
if(($step < 3) && file_exists('../db.info.php')) die('이미 설치되어 있습니다.');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="GR Core" />
<meta name="Author" content="박희근 Hee Geun Park" />
<meta name="Nationality" content="Republic of Korean" />
<title>GR Core Install</title>
<link rel="stylesheet" href="style.css" type="text/css" title="style" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="install.js"></script>
</head>
<body>

	<div id="main">

		<div id="logo"><img src="img/logo.gif" alt="GR Core" /></div>
		
		<?php if($step == 1) { ?>

			<div id="license" style="display: none">
			<strong>GR Core 설치 화면에 오신 것을 환영합니다.</strong><br />
			GR Core 는 GR Tools 의 차세대 공통 엔진으로서, GR Board 부터 GR Shop 까지<br />
			다양한 웹 도구들에 활용되는 공통적인 라이브러리나 기능들을 지원하는 역할을 합니다.<br />
			<br />
			GR Core 기반 도구들은 모두 아래와 같은 서버 환경이 필요합니다.
			<ul>
				<li>OS: Linux Kernel 2.4 이상 / Windows Server 2000 이상</li>
				<li>PHP: 5.0 이상 (권장: 5.2 이상)</li>
				<li>PHP 확장: CURL, GD, MySQLi, SimpleXML, mbstring, 등...</li>
				<li>MySQL: 5.0 이상</li>
				<?php if(!function_exists('mysqli_connect_errno')) { ?>
				<li><span style="color: yellow">※ 경고: MySQLi 확장이 서버에서 막혀 있습니다. PHP MySQLi 확장이 지원되지 않으면 설치가 안됩니다.</span></li>
				<?php } ?>
			</ul>
			또한 GR Core 기반 도구들을 브라우저에서 활용하기 위해서는 아래와 같은 환경이 필요합니다.
			<ul>
				<li>Microsoft Internet Explorer 7.0 이상 (권장: Internet Explorer 8.0 이상)</li>
				<li>Opera 9.0 이상 (권장: Opera 9.5 이상)</li>
				<li>Mozilla Firefox 1.5 이상 (권장: Mozilla Firefox 3.0 이상)</li>
				<li>Google Chrome</li>
				<li>Apple Safari</li>
				<li>기타 자바스크립트가 동작 가능한 최신 버젼의 브라우저</li>
			</ul>
			GR Core 는 GPL v2 라이센스를 따릅니다. 소스코드는 자유로이 활용하실 수 있으며,<br />
			재배포 등의 경우 반드시 Core 에서 사용된 모든 코드는 다시 GPL v2 라이센스로<br />
			공개해 주시기 바랍니다.<br />
			<br />
			아래 버튼을 클릭하여 MySQL 접속정보를 입력합니다.
			<?php if(!is_writable('../')) echo '<br /><br /><span style="color: yellow">※ GR Core 디렉토리의 퍼미션(접근권한)을 707로 변경해 주세요!</span>'; ?>
			</div>
			<div id="next"><input type="button" value="다음 단계로 이동 ▶" onclick="location.href='./?step=2'" /></div>
		
		<?php } elseif($step == 2) { ?>

			<form id="getDBInfo" method="post" onsubmit="return checkInfo(this);" action="<?php echo $_SERVER['PHP_SELF']; ?>?step=3">
			<div id="license" style="display: none">
			<strong>MySQL DB 접속정보를 입력해 주세요.</strong>
			<ol>
				<li><input type="text" name="hostName" value="localhost" class="i" /> : 호스트네임</li>
				<li><input type="text" name="userId" class="i" /> : DB접속 아이디</li>
				<li><input type="password" name="password" class="i" /> : DB접속 비밀번호</li>
				<li><input type="text" name="dbName" class="i" /> : 접속대상 DB명</li>
				<li><input type="checkbox" name="setUTF8" value="true" /> 사용중인 MySQL DB 는 "set names utf8" 쿼리가 필요합니다.</li>
			</ol>
			<strong>아래에는 GR Board/Blog/Counter/Note/Paper/Shop 의 디렉토리명을 적어주세요.</strong><br />
			경로는 GR Core 설치 디렉토리 기준이며, 아래와 같이 동등한 레벨로 FTP 상에 보여진다면 그대로 두셔도 됩니다.<br />
			설치하지 않으신 GR Tools 는 빈 칸으로 비워주시면 됩니다.<br />
			<img src="img/example-ftp.gif" alt="Example" /><br />
			위의 예제화면은 FTP 프로그램상에서 본 모습입니다. /public_html/ 아래에 grcore, grboard, grcounter 등이<br />
			나란히 보여지고 있습니다. 위의 경우엔 아래 작성된 폼을 그대로 유지하셔도 됩니다.<br />
			(아래 경로 작성하실 때, 경로 끝에 '/' 슬래시는 적지 마세요.)
			<ol>
				<li><input type="text" name="grboard" value="../grboard" class="i" /> : GR Board 상대경로</li>
				<li><input type="text" name="grblog" value="../grblog" class="i" /> : GR Blog 상대경로</li>
				<li><input type="text" name="grcounter" value="../grcounter" class="i" /> : GR Counter 상대경로</li>
				<li><input type="text" name="grnote" value="../grnote" class="i" /> : GR Note 상대경로</li>
				<li><input type="text" name="grpaper" value="../grpaper" class="i" /> : GR Paper 상대경로</li>
				<li><input type="text" name="grshop" value="../grshop" class="i" /> : GR Shop 상대경로</li>
				<li><input type="text" name="grforum" value="../grforum" class="i" /> : GR Forum 상대경로</li>
			</ol>
			Core 설정변경시 사용할 비밀번호 설정: <input type="text" name="corePass" class="i" /><br />
			<br />
			아래 버튼을 클릭하여 설치를 마무리 합니다.
			</div>
			<div id="next"><input type="submit" value="다음 단계로 이동 ▶" /></div>
			</form>

		<?php } elseif($step == 3) {

		if(!function_exists('mysqli_connect_errno')) {
			die('<li><span style="color: yellow">※ 경고: MySQLi 확장이 서버에서 막혀 있습니다. PHP MySQLi 확장이 지원되지 않으면 설치가 안됩니다.</span></li>');
		}

		@extract($_POST);
		$db = new mysqli($hostName, $userId, $password, $dbName);
		if(mysqli_connect_errno()) {
			die('<script type="text/javascript">alert(\'DB접속이 되지 않습니다. 다시 입력해 주세요.\'); location.href=\'./?step=2\';</script>');
		}

		$connInfo = '<?php'."\n".'$dbinfo[\'hostname\'] = \''.$_POST['hostName'].'\';'."\n".'$dbinfo[\'userid\'] = \''.$_POST['userId'].'\';'."\n"
			.'$dbinfo[\'password\'] = \''.$_POST['password'].'\';'."\n".'$dbinfo[\'dbname\'] = \''.$_POST['dbName'].'\';'."\n"
			.'$dbinfo[\'setUTF8\'] = '.(($_POST['setUTF8'])?'true':'false').';'."\n"
			.'$coreConfig[\'grboard\'] = \''.$_POST['grboard'].'\';'."\n".'$coreConfig[\'grblog\'] = \''.$_POST['grblog'].'\';'."\n"
			.'$coreConfig[\'grcounter\'] = \''.$_POST['grcounter'].'\';'."\n".'$coreConfig[\'grnote\'] = \''.$_POST['grnote'].'\';'."\n"
			.'$coreConfig[\'grpaper\'] = \''.$_POST['grpaper'].'\';'."\n".'$coreConfig[\'grshop\'] = \''.$_POST['grshop'].'\';'
			.'$coreConfig[\'grforum\'] = \''.$_POST['grforum'].'\';'."\n?>";

		$finfo = fopen('../db.info.php', 'w');
		fwrite($finfo, $connInfo);
		fclose($finfo);
		
		include '../class/common.php';
		$core = new Common();
		$grcore = '..'.str_replace('/'.end(explode('/', $_SERVER['REQUEST_URI'])), '', $_SERVER['REQUEST_URI']);
		$grcore = str_replace('/install', '', $grcore);
		$core->fileWrite('../passwd.php', '<?php $coreAdminPasswd = \''.md5($_POST['corePass']).'\'; ?>');
		if($core->config['grboard']) {
			@include '../'.$core->config['grboard'].'/db_info.php';
			$core->fileWrite('../'.$core->config['grboard'].'/core.php', '<?php $grcore = \''.$grcore.'\'; $dbFIX = \''.$dbFIX.'\'; $timeDiff = \''.$timeDiff.'\'; ?>');
		}
		if($core->config['grblog']) {
			@include '../'.$core->config['grblog'].'/db_info.php';
			$core->fileWrite('../'.$core->config['grblog'].'/core.php', '<?php $grcore = \''.$grcore.'\'; $dbFIX = \''.$dbFIX.'\'; $GLOBALS[\'grblog\'] = \''.$GLOBALS['grblog'].'\'; ?>');
		}
		if($core->config['grcounter']) $core->fileWrite('../'.$core->config['grcounter'].'/core.php', '<?php $grcore = \''.$grcore.'\'; $dbFIX = \'gc_\'; ?>');
		if($core->config['grnote']) {
			@include '../'.$core->config['grnote'].'/db.info.php';
			$core->fileWrite('../'.$core->config['grnote'].'/core.php', '<?php $grcore = \''.$grcore.'\'; $dbFIX = $divide = \''.$divide.'\'; ?>');
		}
		if($core->config['grpaper']) {
			@include '../'.$core->config['grpaper'].'/db.info.php';
			$core->fileWrite('../'.$core->config['grpaper'].'/core.php', '<?php $grcore = \''.$grcore.'\'; $dbFIX = $dbinfo[\'prefix\'] = \''.$dbinfo['prefix'].'\'; $config[\'dirName\'] = \''.$config['dirName'].'\'; ?>');
		}
		?>
	
			<div id="license" style="display: none">
			<strong>설치가 모두 마무리 되었습니다.</strong>
		
			<br />
			GR Core 설치가 모두 마무리되었습니다. 이제 GR Core 기반으로 동작하는<br />
			각종 웹 도구들을 설치하셔서 사용하실 수 있습니다.<br />
			<br />
			(만약 아래에 에러메시지 <strong>Warning</strong>: Unknown: open(session/ ... 가 보이신다면, 무시하셔도 되는 에러메시지이므로 안심하셔도 됩니다.) 
			</div>
	
		<?php } ?>
	</div>

</body>
</html>