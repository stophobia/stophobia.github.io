<?php
// 기본 클래스를 불러온다.
include 'class/common.php';
$GR = new COMMON;

// DB 에 연결한다.
$GR->dbConn();

// 스팸등록이면 알짤없이 튕겨버린다.
if(!$_POST['antiSpam'] || ($_POST['antiSpam'] != substr(md5('grboardAntiSpamJoin'.$_POST['time']), -4)))
	$GR->error('자동등록방지용 4자리 코드가 올바르지 않습니다. 다시 입력해 주세요.', 0, 'HISTORY_BACK');

// 주민등록번호 검사 (by PHP스쿨 곤님)
function resnoCheck($resno) 
{
	// 형태 검사: 총 13자리의 숫자, 7번째는 1..4의 값을 가짐
	if (!ereg('^[[:digit:]]{6}[1-4][[:digit:]]{6}$', $resno)) return false;

	// 날짜 유효성 검사
	$birthYear = ('2' >= $resno[6]) ? '19' : '20';
	$birthYear += substr($resno, 0, 2);
	$birthMonth = substr($resno, 2, 2);
	$birthDate = substr($resno, 4, 2);
	if (!checkdate($birthMonth, $birthDate, $birthYear)) return false;

	// Checksum 코드의 유효성 검사
	for ($i = 0; $i < 13; $i++) $buf[$i] = (int) $resno[$i];
	$multipliers = array(2,3,4,5,6,7,8,9,2,3,4,5);
	for ($i = $sum = 0; $i < 12; $i++) $sum += ($buf[$i] *= $multipliers[$i]);
	if ((11 - ($sum % 11)) % 10 != $buf[12]) return false;

	return true;
}

// 주민등록번호 검사
if(array_key_exists('jumin', $_POST) && $_POST['jumin'] && !resnoCheck($_POST['jumin'])) {
	$GR->error('주민등록번호가 유효하지 않습니다. 다시 입력해 주세요.', 0, 'HISTORY_BACK');
}

// 넘어온 값을 처리한다. (보안패치 by KISA.or.kr)
if(array_key_exists('joinInBoard', $_POST) && $_POST['joinInBoard']) $joinInBoard = trim($_POST['joinInBoard']);
if(array_key_exists('boardId', $_POST) && $_POST['boardId']) $boardId = trim($_POST['boardId']);
if(array_key_exists('fromPage', $_POST) && $_POST['fromPage'])	$fromPage = trim($_POST['fromPage']);
if(array_key_exists('id', $_POST) && $_POST['id']) {
	$id = str_replace(' ', '', trim($_POST['id']));
	$id = str_replace('<',' ', trim($_POST['id']));
}
if(array_key_exists('password', $_POST) && $_POST['password']) $password = str_replace(' ', '', trim($_POST['password']));
if(array_key_exists('jumin', $_POST) && $_POST['jumin']) $jumin = md5(trim($_POST['jumin']));
else $jumin = '';
if(array_key_exists('nickname', $_POST) && $_POST['nickname']) $nickname = str_replace('  ', '', strip_tags(trim($_POST['nickname'])));
if(array_key_exists('realname', $_POST) && $_POST['realname']) $realname = str_replace('  ', '', strip_tags(trim($_POST['realname'])));
if(array_key_exists('email', $_POST) && $_POST['email']) $email = str_replace('  ', '', strip_tags(trim($_POST['email'])));
else $email = '';
if(array_key_exists('homepage', $_POST) && $_POST['homepage']) $homepage = str_replace('  ', '', strip_tags(trim($_POST['homepage'])));
else $homepage = '';
if(array_key_exists('self_info', $_POST) && $_POST['self_info']) $self_info = str_replace('  ', '', addslashes(strip_tags(trim($_POST['self_info']))));
else $self_info = '';

// 이메일은 중복되면 안된다!
$getExistEmail = @mysql_fetch_array(mysql_query('select no from '.$dbFIX.'member_list where email = \''.$email.'\''));
if($getExistEmail['no']) $GR->error('이메일 주소가 이미 등록되어 있습니다.', 0, 'HISTORY_BACK');

// 닉네임은 중복되면 안된다!
$getExistNick = @mysql_fetch_array(mysql_query('select no from '.$dbFIX.'member_list where nickname = \''.$nickname.'\''));
if($getExistNick['no']) $GR->error('닉네임이 중복됩니다.', 0, 'HISTORY_BACK');

// 넘겨진 id 값이 유효한 형태인지 확인한다.
$alreadyId = @mysql_fetch_array(mysql_query("select id from {$dbFIX}member_list where id = '$id'"));
if(!isset($id) || ($alreadyId['id'] != '')) {
	$GR->error('ID 값이 유효하지 못합니다.<br />ID 는 공백없이, 영어로 3자 이상 45자 이하여야 하며'.
		'<br />이미 등록된 ID 가 아니어야 합니다.<br /><br />'.(($alreadyId['id'])?'[!] 아이디가 중복 되었습니다!':''), 0, 'HISTORY_BACK');
}

// 여기까지 왔다면 DB 에 등록한다.
$registerTime = $GR->grTime();
$sqlInsertNewMember = "insert into {$dbFIX}member_list
	set no = '',
	id = '$id',
	password = password('$password'),
	nickname = '$nickname',
	realname = '$realname',
	email = '$email',
	homepage = '$homepage',
	make_time = '$registerTime',
	level = '2',
	point = '0',
	self_info = '$self_info',
	photo = '$saveFile1',
	nametag = '$saveFile2',
	jumin = '$jumin',
	group_no = '1',
	icon = '$saveFile3',
	lastlogin = '0'";
@mysql_query($sqlInsertNewMember);
$insertMemberNo = @mysql_insert_id();

// 사진 업로드 처리
if(isset($_FILES['photo'])) {
	$filename1 = $_FILES['photo']['name'];
	$filetype1 = $_FILES['photo']['type'];
	$filesize1 = $_FILES['photo']['size'];
	$filetmpname1 = $_FILES['photo']['tmp_name'];

	if($filesize1 > 0) {
		$filename1 = strtolower($filename1);
		if(!preg_match('\.(png|jpg|gif|bmp)$', $filename1)) {
			$GR->error('사진이 아닙니다. 지원 확장자 : .png, .jpg, .gif, .bmp', 0, 'HISTORY_BACK');
		}

		$checkSize1 = @getimagesize($filetmpname1);
		if(!$checkSize1 || ($checkSize1[2] > 3)) $GR->error('그림이 아니거나 올릴 수 없는 형식 입니다.', 0, 'HISTORY_BACK');

		if($checkSize1[0] > 200 || $checkSize1[1] > 200) $GR->error('사진이 200 x 200 이상입니다. 줄여서 업로드 해 주세요.', 0, 'HISTORY_BACK');

		if(!is_dir('member')) { 
			@mkdir("member", 0705); 
			@chmod('member', 0707); 
		}			
		if(!is_uploaded_file($filetmpname1)) $GR->error('정상적으로 파일을 업로드 해 주세요.', 0, 'HISTORY_BACK');

		$filetmpname1 = str_replace('\\\\', '\\', $filetmpname1);
		$filename1 = 'grboard_'.$insertMemberNo.'_photo_'.substr(md5(time()), -5).$filename1;

		if(file_exists('member/'.$filename1)) $GR->error('이미 파일이 올려져 있습니다. 다른 파일이라면 파일명을 변경하신 후 업로드 하세요.', 0, 'HISTORY_BACK');

		$saveFile1 = 'member/'.$filename1;
		if(!move_uploaded_file($filetmpname1, $saveFile1)) $GR->error('파일을 업로드 하지 못했습니다. 파일용량이 너무 크지는 않은지 확인해 보세요.', 0, 'HISTORY_BACK');
	} else $saveFile1 = '';
}

// 네임택 업로드 처리
if(isset($_FILES['nametag'])) {
	$filename2 = $_FILES['nametag']['name'];
	$filetype2 = $_FILES['nametag']['type'];
	$filesize2 = $_FILES['nametag']['size'];
	$filetmpname2 = $_FILES['nametag']['tmp_name'];

	if($filesize2 > 0) {
		$filename2 = strtolower($filename2);
		if(!preg_match('\.(png|jpg|gif|bmp)$', $filename2)) {
			$GR->error('그림이 아닙니다. 지원 확장자 : .png, .jpg, .gif, .bmp', 0, 'HISTORY_BACK');
		}
		$checkSize2 = @getimagesize($filetmpname2);
		if(!$checkSize2 || ($checkSize2[2] > 3)) $GR->error('그림이 아니거나 올릴 수 없는 형식 입니다.', 0, 'HISTORY_BACK');

		if($checkSize2[0] > 80 || $checkSize2[1] > 20) $GR->error('그림이 80 x 20 이상입니다. 줄여서 업로드 해 주세요.', 0, 'HISTORY_BACK');
		if(!is_dir('member')) { 
			@mkdir('member', 0705);
			@chmod('member', 0707); 
		}			
		if(!is_uploaded_file($filetmpname2)) $GR->error('정상적으로 파일을 업로드 해 주세요.', 0, 'HISTORY_BACK');
		$filetmpname2 = str_replace('\\\\', '\\', $filetmpname2);
		$filename2 = 'grboard_'.$insertMemberNo.'_nametag_'.substr(md5(time()), -5).$filename2;
		if(file_exists('member/'.$filename2)) {
			$GR->error('이미 파일이 올려져 있습니다. 다른 파일이라면 파일명을 변경하신 후 업로드 하세요.', 0, 'HISTORY_BACK');
		}
		$saveFile2 = 'member/'.$filename2;
		if(!move_uploaded_file($filetmpname2, $saveFile2)) 
			$GR->error('파일을 업로드 하지 못했습니다. 파일용량이 너무 크지는 않은지 확인해 보세요.', 0, 'HISTORY_BACK');
	} else $saveFile2 = '';
}

// 아이콘 업로드 처리
if(isset($_FILES['icon'])) {
	$filename3 = $_FILES['icon']['name'];
	$filetype3 = $_FILES['icon']['type'];
	$filesize3 = $_FILES['icon']['size'];
	$filetmpname3 = $_FILES['icon']['tmp_name'];

	if($filesize3 > 0) {
		$filename3 = strtolower($filename3);
		if(!preg_match('\.(png|jpg|gif|bmp)$', $filename3)) {
			$GR->error('그림이 아닙니다. 지원 확장자 : .png, .jpg, .gif', 0, 'HISTORY_BACK');
		}
		$checkSize3 = @getimagesize($filetmpname3);
		if(!$checkSize3 || ($checkSize3[2] > 3)) $GR->error('그림이 아니거나 올릴 수 없는 형식 입니다.', 0, 'HISTORY_BACK');

		if($checkSize3[0] > 16 || $checkSize3[1] > 16) {
			$GR->error('그림이 16 x 16 이상입니다. 줄여서 업로드 해 주세요.', 0, 'HISTORY_BACK');
		}
		if(!is_dir('icon')) { 
			@mkdir('icon', 0705);
			@chmod('icon', 0707); 
		}			
		if(!is_uploaded_file($filetmpname3)) $GR->error('정상적으로 파일을 업로드 해 주세요.', 0, 'HISTORY_BACK');
		$filetmpname3 = str_replace('\\\\', '\\', $filetmpname3);
		$filename3 = 'grboard_'.$insertMemberNo.'_icon_'.substr(md5(time()), -5).$filename3;
		if(file_exists('icon/'.$filename3)) @unlink('icon/'.$filename3);
		$saveFile3 = 'icon/'.$filename3;
		if(!move_uploaded_file($filetmpname3, $saveFile3)) $GR->error('파일을 업로드 하지 못했습니다. 파일용량이 너무 크지는 않은지 확인해 보세요.', 0, 'HISTORY_BACK');
	} else $saveFile3 = '';
}

// 회원가입 확장필드용 불러오기 (확장필드가 필요한 스킨의 경우)
$getJoinus = @mysql_fetch_array(mysql_query('select var from '.$dbFIX.'layout_config where opt = \'join_skin\' limit 1'));
@include 'admin/theme/join/'.$getJoinus['var'].'/theme_join_ok.php';

// 문서설정
$title = 'GR Board Join Complete Page';
$encoding = 'utf-8';
include 'html_head.php';
?>
<body>

<!-- 여기까지 왔다면 등록을 완료했다는 뜻이다. -->
<script type="text/javascript">//<![CDATA[
<?php if($joinInBoard) { ?>
alert('등록을 완료했습니다. 게시판 상단 로그인 버튼을 클릭하세요.\n\n이 창은 닫아집니다.');
location.href='board.php?id=<?php echo $boardId; ?>';
<?php } else { 
	if($fromPage == "outlogin") { ?>
		alert('등록을 완료했습니다. 메인화면에서 로그인 해 주세요. 이 창은 닫힙니다.');
		self.close();
	<?php } else { ?>
		alert('등록을 완료했습니다. 관리자 화면으로 갑니다.');
		location.href='admin.php';
	<?php } 
} ?>
//]]></script>

</body>
</html>
