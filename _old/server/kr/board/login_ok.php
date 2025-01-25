<?php
// 기본 클래스를 불러온다.
include 'class/common.php';
$GR = new COMMON;

// 넘겨받은 값을 처리한다.
$goAdminPage = $_POST['goAdminPage'];
$id = $_POST['id'];
$boardID = $_POST['boardID'];
$password = $_POST['password'];
if($_POST['fromPage']) $fromPage = urldecode($_POST['fromPage']);
if($_GET['fromPage']) $fromPage = urldecode($_GET['fromPage']);
$checkPage = end(explode('/', $fromPage));
if($fromPage && $checkPage == 'logout.php') $fromPage = '';
if($checkPage == 'login.php') $fromPage = 'http://'.$_SERVER['HTTP_HOST'];

// DB 에 연결한다.
$GR->dbConn();

// 아이디와 비밀번호가 맞다면 인증해준다.
if($id && $password) {

	$id = addslashes($id);
	$password = addslashes($password);
	$searchQue = @mysql_query("select no, id from {$dbFIX}member_list where id = '$id' and password = password('$password')");
	$member = @mysql_fetch_array($searchQue);
	if(!$member['no']) $GR->error('아이디 혹은 비밀번호가 올바르지 않습니다.', 0, 'login.php?boardID='.$boardID.'&amp;fromPage='.urlencode($fromPage));
	else {
		$_SESSION['no'] = $member['no'];
		$_SESSION['mId'] = $member['id'];
		$_time = $GR->grTime();
		@mysql_query("update {$dbFIX}member_list set lastlogin = '$_time' where no = '".$member['no']."' limit 1");
		@mysql_query("insert into {$dbFIX}login_log set no = '', member_key = '".$member['no']."', signdate = '$_time', ip = '".$_SERVER['REMOTE_ADDR']."', ref = '$fromPage'");
	}
}

// 자동 로그인 체크 시 처리
if($_POST['auto_login']) @setcookie('auto_login', $_SESSION['no'], $GR->grTime()+2592000);

// 문서설정
$title = 'GR Board Login check';
$encoding = 'utf-8';
include 'html_head.php';
?>
<body>
<?php
// 요청받은 페이지로 이동하거나, 관리자 페이지로 이동한다.
if($member['no'] == 1) 
{
	echo '<script type="text/javascript">';
	if($fromPage)
	{
		echo "location.href='{$fromPage}';";
	}	
	else
	{
		if($goAdminPage) echo "location.href='admin.php';";
		else
		{
			echo "if(confirm('관리자님, 접속을 환영합니다. 어디로 모실까요?\\n\\n'+".
			"'확인(OK)를 누르시면 관리화면으로 가며, 취소(Cancel)를 누르시면 게시판으로 돌아갑니다.'))".
			"{ location.href='admin.php'; } else { location.href='board.php?id={$boardID}'; }";
		}
	}
	echo '</script>';
}
else
{
	echo '<script type="text/javascript">';
	if($fromPage) echo "location.href='{$fromPage}';";
	elseif($boardID) echo "location.href='board.php?id={$boardID}';";
	else echo "location.href='admin.php';";
	echo '</script>';
}
?>
<a href="<?php echo $fromPage; ?>" title="자바스크립트가 동작하지 않을 경우, 여기를 눌러 이동 할 수 있습니다.">[Click to Move]</a>
</body>
</html>
