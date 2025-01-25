<?php
if($_GET['step']) $step = $_GET['step']; else $step = 1;
include '../grnote.config.php';
$grNote['title'] = 'GR Note Install Page';
$grNote['js'] = 'javascript/install.lib.js';
include $grNote['path'].'/library/install.lib.php';
include $grNote['path'].'/common/head.header.php';
include $grNote['path'].'/common/head.install.html.php';
$install = new Install('../');
if($step < 4) $install->isAlreadyInstalled();
?>
<body>
<div id="installBox">

<?php 
// GR Note 설치 1단계: 설치 시작 알림
if($step == 1) { ?>
<br /><br /><br /><br /><br /><br /><br /><br /><br />
<span>GR Note Install</span><br /><br />
<a href="./?step=2">설치를 계속 하시길 원하시면 여기를 클릭해 주세요...</a>

<?php 
// GR Note 설치 2단계: 라이센스 안내
} elseif($step == 2) { ?>
<br /><br /><br /><br /><br />
<span>GR Note License</span><br /><br />
<form id="licenseCheck" method="post" action="./">
<textarea id="license" rows="20" readonly="readonly"><?php echo $install->readLicense(); ?></textarea>
<input type="checkbox" id="agree" value="1" /> <label for="agree">위 라이센스에 동의 합니다.</label>
<br />
<p style="color: yellow">※ 리눅스/유닉스 서버에 설치하시는 분들은 GR노트 디렉토리 퍼미션(권한)을 707로 맞추어 주세요!</p>
<br />
<a href="#" onclick="Install.isAgree();">{계속 설치합니다}</a>
</form>

<?php 
// GR Note 설치 3단계: DB정보 입력
} elseif($step == 3 && $_GET['isLicenseAgree'] == 'yes') { ?>
<br /><br /><br /><br /><br />
<span>GR Note MySQL</span><br /><br />
<form name="dbInfo" method="post" action="./" onsubmit="return Install.createDBInfo();">
MySQL 데이터베이스에 접속하기 위해서는 아래의 빈칸에 각각<br />
1. 호스트이름, 2. 접속아이디, 3. 비밀번호, 4. DB이름, 5. GR Note 구분자를 입력해야 합니다.<br />
5번 구분자의 경우 복수의 GR Note 설치시 서로 구분짓기 위해 필요한 영문 문자열이며<br />
대부분의 경우 처음 설치할 시 기본값을 그대로 두시면 됩니다.<br />
<div style="color: yellow">(※ 동일한 구분자로 중복해서 설치할 경우, 
<u title="GR Note 가 사용하는 DB내 테이블들을 말합니다">기존 DB가 삭제</u> 되므로 주의해 주십시오!)</div>
<br />
<ol id="inputBox">
	<li><input type="text" name="hostName" value="localhost" /> 호스트이름</li>
	<li><input type="text" name="userId" /> 접속아이디</li>
	<li><input type="password" name="password" /> 비밀번호</li>
	<li><input type="text" name="dbName" /> DB이름</li>
	<li><input type="text" name="divide" value="gn_" /> 구분자</li>
</ol>
<br />
<input type="submit" value="확 인" class="submit" />
</div>
</form>

<?php
// GR Note 설치 4단계: 관리자 등록
} elseif($step == 4) { ?>
<br /><br /><br /><br /><br />
<span>GR Note Administrator</span><br /><br />
<form name="regAdmin" method="post" action="./" onsubmit="return Install.regAdmin();">
GR Note 의 관리자 정보를 입력합니다.<br />
관리자는 GR Note 내 전반적인 옵션들을 설정할 수 있는 권한을 가집니다.<br />
등록 후 아이디를 제외한 항목들은 언제든지 수정 가능합니다.<br />
(<strong>굵은 글씨</strong>로 된 항목은 필수 입력 항목 입니다.)
<br />
<ol id="inputBox">
	<li><input type="text" name="id" value="admin" /> <strong>아이디</strong></li>
	<li><input type="password" name="password" /> <strong>비밀번호</strong></li>
	<li><input type="text" name="nickname" value="관리자" /> <strong>이름</strong></li>
	<li><input type="text" name="email" /> 이메일</li>
	<li><input type="text" name="homepage" /> 홈페이지</li>
	<li><textarea name="selfInfo" rows="5" cols="70"></textarea><br />자기소개</li>
</ol>
<br />
<input type="submit" value="등 록" class="submit" />
</div>
</form>

<?php
// GR Note 설치 5단계: 관리자로 로그인하러 가기
} elseif($step == 5) { ?>
<br /><br /><br /><br /><br />
<span>GR Note Install Complete</span><br /><br />
모든 설치과정을 무사히 완료하였습니다.<br />
<a href="../login/">{여기를 눌러 관리자로 로그인 하십시오}</a>

<?php } ?>
<div id="loadBox" style="display: none"></div>

</div>
<?php
include $grNote['path'].'/common/foot.html.php';
?>