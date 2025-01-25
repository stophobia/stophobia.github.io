<?php
// 기본 클래스를 부른다
include 'class/common.php';
$GR = new COMMON;

// 로그인 상태가 아니면 에러
if(!$_SESSION['no']) {
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'.
	'<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">'.
	'<head><title>에러페이지</title><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'.
	'<script type="text/javascript"> alert(\'멤버만이 멤버에게 쪽지를 보낼 수 있습니다. 로그인 해 주세요.\');'.
	'self.close(); </script></body></html>';
	exit();
}

// DB 에 연결한다.
$GR->dbConn();

// 변수처리
if($_SESSION['no']) $sessionNo = $_SESSION['no']; else $sessionNo = 0;

// 쪽지가 보내졌다면 처리
if($_POST['sendOk']) {
	$targetKey = $_POST['targetKey'];
	$subject = addslashes(htmlspecialchars(trim($_POST['subject'])));
	$content = addslashes(htmlspecialchars(trim($_POST['content'])));
	$thisTime = $GR->grTime();
	@mysql_query("insert into {$dbFIX}memo_save set no = '', member_key = '$targetKey', sender_key = '$sessionNo', ".
		"subject = '$subject', content = '$content', signdate = '$thisTime', is_view = '0'");
	$GR->error($_POST['targetName'].' 님에게 쪽지를 보냈습니다.', 0, 'CLOSE');
}

// 쪽지 받을 대상
$target = $_GET['target'];
$targetInfo = @mysql_fetch_array(mysql_query("select nickname, realname from {$dbFIX}member_list where no = '$target'"));

// 회원의 정보를 가져온다.
$member = @mysql_fetch_array(mysql_query('select * from '.$dbFIX.'member_list where no = '.$sessionNo));

// 문서설정
$title = 'GR Board Send Memo Page';
$encoding = 'utf-8';
include 'html_head.php';
?>
<body>
<!-- 가운데 정렬 -->
<div id="installBox">

	<!-- 폭 설정 (기본값 사용) -->
	<div style="padding:5px;">

		<!-- 타이틀 -->
		<div class="bigTitle">Send memo</div>

		<!-- 쪽지 보내기 박스 -->
		<fieldset>
			<legend class="legend"><?php echo $targetInfo['nickname']; ?>님에게 쪽지 보내기</legend>

			<div class="vSpace"></div>

			<form name="sendMemo" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<input type="hidden" name="sendOk" value="1" />
			<input type="hidden" name="targetKey" value="<?php echo $_GET['target']; ?>" />
			<input type="hidden" name="targetName" value="<?php echo $targetInfo['nickname']; ?>" />
			<div class="tableListLine">
				<div class="divLeft">제목</div>
				<div class="divRight"><input type="text" name="subject" class="boxInput" /></div>
				<div style="clear:both;"></div>
			</div>
			<div class="tableListLine">
				<div class="divLeft">내용</div>
				<div class="divRight">
					<textarea name="content" class="textarea" cols="90" rows="25"></textarea>
				</div>
				<div style="clear: both"></div>
			</div>
			<div style="text-align: center"><input type="image" src="image/admin/memo_ok.gif" value="쪽지를 보냅니다." onmouseover="btnOver(this);" onmouseout="btnOut(this);" /></div>
			</form>

		</fieldset><!--# 쪽지 보내기 박스 -->

		<!-- 위아래 공백 -->
		<div style="height:10px;"></div>

	</div><!--# 폭 설정 -->

</div><!--# 가운데 정렬 -->

<script type="text/javascript" src="js/memo_check.js"></script>

</body>
</html>