<?php
@header('Content-Type: text/html; charset=utf-8');
$step = $_GET['step'];
if(!$step) $step = 1;

// 경로 입력 후 처리
if($step == 3) {
	@extract($_POST);
	if(!$grcore) die('<script type="text/javascript"> alert(\'GR Core 가 설치된 상대경로를 입력해 주세요. (예: ../grcore)\'); location.href=\'./?step=2\'; </script>');
	if(!file_exists('../'.$grcore.'/db.info.php')) die('<script type="text/javascript"> alert(\'GR Core 가 설치되어 있지 않거나, 상대경로가 잘못되었습니다. 다시 입력해 주세요.\'); location.href=\'./?step=2\'; </script>');
	
	include '../'.$grcore.'/class/common.php';
	$core = new Common('../'.$grcore);
	$grboard = $core->config['grboard'];
	if(!file_exists('../'.$grboard.'/db_info.php')) $core->alert('GR 보드가 설치되어 있지 않거나, Core 에 저장된 상대경로가 잘못되었습니다.', './?step=2');

	include 'db.make.query.php';
	$cntQue = count($que);
	for($q=0; $q<$cntQue; $q++) $core->query($que[$q]);
	$core->fileWrite('../core.php', '<?php $grcore = \''.$grcore.'\'; $dbFIX = \''.$prefix.'\'; $grid = \''.$grid.'\'; ?>');
	$core->alert('GR Shop 초기설치가 모두 마무리 되었습니다.', './?step=4');
}

// 마무리 시점에서
if($step == 4) {
	include '../core.php';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Generator" content="GR Core" />
<meta name="Author" content="박희근 Hee Geun Park" />
<meta name="Nationality" content="Republic of Korean" />
<link rel="stylesheet" href="style.css" type="text/css" title="style" />
<?php if($step == 4) { ?>
<script type="text/javascript" src="../<?php echo $grcore; ?>/js/jquery.js"></script>
<script type="text/javascript">//<![CDATA[
$(function() {
	$("#license", this).toggle("license");
});
//]]></script>
<?php } ?>
<title>GR Shop 설치화면</title>
</head>
<body>

	<div id="main">

		<div id="logo"><img src="../img/logo.gif" alt="GR Shop" /></div>
		
		<?php if($step == 1) { ?>

			<div id="license">
			<strong>GR Shop 설치 화면에 오신 것을 환영합니다.</strong><br />
			GR Shop 은 작고 가벼운 오픈소스 쇼핑몰 프로그램입니다.<br />
			GR Core, GR Board 와 함께 연동하여 동작하며 레이아웃 등이 스킨 시스템으로<br />
			구성되어 있어 디자인 / 기능 변경과 업그레이드가 용이합니다.<br />
			<br />
			GR Shop 설치를 위해서는 아래의 사항에 동의하셔야 합니다.
			<ol>
				<li>GR Shop 을 구성하는 기본 소스는 수정/배포의 자유가 있으나, 조건없이 코드를 공개해야 합니다.</li>
				<li>GR Shop 사용시 발생하는 모든 문제에 대해 제작자는 어떠한 책임도 지지 않습니다.</li>
				<li>GR Shop 과 연동되는 GR Board 특수스킨, 혹은 레이아웃 스킨의 라이센스는 GR Shop 과 완전히 별개입니다.</li>
			</ol>
			위의 조건에 동의하신다면 아래 버튼을 클릭하여 설치를 진행합니다.
			<?php if(!is_writable('../')) echo '<br /><br /><span style="color: yellow">※ GR Shop 디렉토리의 퍼미션(접근권한)을 707로 변경해 주세요!</span>'; ?>
			</div>
			<div id="next"><input type="button" value="다음 단계로 이동 ▶" onclick="location.href='./?step=2'" /></div>

		<?php } elseif($step == 2) { ?>

			<form id="setInfo" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?step=3">
			<div id="license">
			<strong>GR Core 의 설치경로를 입력해 주세요.</strong><br />
			GR Shop 은 기본적으로 GR Board 를 기반으로 동작하며, Core 의 기능을 통해 관리기능 일부를 제공하고 있습니다.<br />
			또한 선택적으로, GR Counter 를 설치하신 분들에 한해서 쇼핑몰 접속자 통계 기능을 연동할 수 있습니다.<br />
			위의 설치경로는 모두 GR Core 에서 저장된 설정정보들을 참조합니다.<br />
			<br />
			만약 GR Core 가 FTP 상에서 아래와 같이 보여진다면, 미리 입력된 값을 그대로 쓰실 수 있습니다.<br />
			<img src="../img/example-ftp.gif" alt="예제" /><br />
			위에서 grcore 디렉토리와 함께 grshop 디렉토리가 보이신다면<br />
			서로 동등한 위치를 가지고 있으므로 상대경로가 아래 미리 작성된 형태로 될 것입니다.<br />
			GR Counter 는 미리 설치되어 있고, 아래에 grid 값 (카운터용 ID) 을 입력하시면 연동이 됩니다.<br />
			(아래 경로 작성하실 때, 경로 끝에 '/' 슬래시는 적지 마세요.)
			<ol>
				<li><input type="text" name="grcore" value="../grcore" class="i" /> : GR Core 상대경로</li>
				<li><input type="text" name="prefix" value="grshop_" class="i" /> : GR Shop 테이블 이름 접두어 (초기설치시 기본값으로)</li>
				<li><input type="text" name="grid" value="" class="i" /> : GR Counter 의 grid 값 (없을 시 빈칸으로)</li>
			</ol>
			모두 입력하셨다면 아래 버튼을 클릭하여 설정을 저장하고 DB설정을 완료합니다.
			</div>
			<div id="next"><input type="submit" value="다음 단계로 이동 ▶" /></div>
			</form>

		<?php } elseif($step == 4) { ?>

			<div id="license" style="display: none">
			<strong>설치가 모두 마무리 되었습니다. 아래 안내글을 확인해 보세요.</strong><br />
			GR Shop 에서 사용하는 대부분의 기능들은 GR Board 의 기능을 이용하는 것입니다.<br />
			회원 부분 역시 마찬가지이며, 관리자로 로그인 하기 위해서는 GR Board 의 관리자 아이디/비밀번호 정보로<br />
			로그인을 하시면 됩니다. 관리자로 로그인 하시게 되면 몇가지 메뉴들이 보이게 되고<br />
			그 메뉴들을 통해서 쇼핑몰을 운영/관리하실 수 있습니다.<br />
			<br />
			쇼핑몰 처음 접속시 보여지는 레이아웃은 /grshop/layout/basic/ 위치의 스킨입니다.<br />
			GR Shop 에서는 상품 진열, 공지사항 배치, 상품 분류 메뉴 등의 디자인이 모두<br />
			스킨 시스템을 통해서 보여지게 되며, 이 스킨들은 저마다 필요로 하는 게시판 id 가 있습니다.<br />
			가령 basic 스킨의 경우 이벤트/소식을 우측 상단에 보여주게 되는데 초기에는 이 곳이<br />
			빈 상태로 나타납니다. 아직 GR Board 의 게시판들중 어느 게시판을 연동할 것인지<br />
			정하지 않았기 때문이지요.<br />
			<br />
			추천 상품 부분이나 최근 등록된 상품 부분도 모두 마찬가지입니다.<br />
			GR Board 에 등록된 게시판들 중 어떤 게시판이 어디서 쓰일지 아직 지정하기 이전이라<br />
			모두 공백으로 보이게 됩니다. 이를 해결하기 위해서 처음 GR Shop 을 사용하시는 분들은<br />
			우선 아래의 단계를 거쳐 주세요. (이미 숙달되신 분들은 지금 바로 관리자 로그인하러 가시면 됩니다.)<br />
			<ol>
				<li>우선 관리자 로그인 화면으로 갑니다.</li>
				<li>로그인 후 관리화면에 가서 상단 메뉴 중 "상품 분류" 부분에 들어갑니다.</li>
				<li>1단계 大분류들을 만듭니다.  (예: 컴퓨터/주변기기, 가전제품, 생활용품 ...)</li>
				<li>큰 분류들을 다 만들었으면 상단 메뉴 중 "게시판 등록" 부분에 들어갑니다.</li>
				<li>거기서 GR Shop 에서 사용할 게시판들을 하나씩 등록합니다.</li>
				<li>등록 할 때, GR Shop 의 상품 분류를 꼭 지정해 줍니다. 이게 2단계 中분류입니다.</li>
				<li>등록한 게시판들은 GR Board 관리화면에서 카테고리 생성으로 다시 3단계 小분류를 할 수 있습니다.</li>
				<li>사용할 게시판들을 일단 등록했으면, 이제 로그인 된 상태 그대로 GR Shop 첫화면으로 갑니다.</li>
				<li>해당 레이아웃 스킨에서 사용할 게시판 아이디들을 입력할 수 있도록 화면이 준비됩니다.</li>
				<li>항목에 맞게 입력해주시고, 저장하시면 그 후 부터 해당 GR Board 게시판 id 의 글들을 가져옵니다.</li>
				<li>설정은 관리자로 로그인 한 이후 화면 내에 배치된 "레이아웃 설정" 버튼으로 쉽게 변경할 수 있습니다.</li>
				<li>게시판 본래의 설정은 GR Board 관리화면에서, 그 밖에 설정은 GR Shop 에서 하실 수 있습니다.</li>
				<li>GR Board 활용에 능숙해질수록 GR Shop 역시 능숙하게 관리하실 수 있습니다.</li>
				<li>GR Shop 곳곳에 배치된 도움말을 통해서 익숙치 않은 기능/설정을 어떻게 하면 되는지 확인해 보세요.</li>
			</ol>
			GR Shop 에는 쇼핑몰 운영을 위한 여러 가지의 도움말이 구석 구석 배치되어 있습니다.<br />
			어렵게 생각하지 마시고 차근 차근 익혀 보시면서 나만의 쇼핑몰을 만들어 보세요.<br />
			이 밖에 궁금하신 점들은 시리니넷 (http://sirini.net) 의 묻고답하기 게시판을 통해서<br />
			해결하실 수 있습니다.<br />
			<br />
			다 확인하셨다면 아래 버튼을 클릭하여 관리자로 로그인하러 갑니다.
			</div>
			<div id="next"><input type="button" value="로그인하러 가기 ▶" onclick="location.href='../login/?go=../admin/'" /></div>

		<?php } ?>

	</div>

</body>
</html>