<?
	include "../odcommon/od_config.inc.php";
	include "../odcommon/od_function.inc.php";
	include "od_board.inc.php";
	
	authorityTest("Read");

	## Par 정리 ##########################################################################
	$parTemp = "?board=$board";
	if($page) $parTemp .= "&page=$page";
	if($field) $parTemp .= "&field=$field";
	if($value) $parTemp .= "&value=$value";
	if($serialnum) $parTemp .= "&serialnum=$serialnum";
	if($pTemp) $parTemp .="&pTemp=$pTemp";
	
	if(!$board || !$serialnum) {
		echo "
			<script>
				window.alert(\"해당 게시판이 없습니다.!\");
				history.go(-1);
			</script>";

		exit;
	}

	if(!$writer) {
		echo "
			<script>
				window.alert(\"이름을 입력해 주세요!\");
				history.go(-1);
			</script>";

		exit;
	}

	if(!$password) {
		echo "
			<script>
				window.alert(\"비밀번호를 입력해 주세요!\");
				history.go(-1);
			</script>";

		exit;
	}

	if(!$comment) {
		echo "
			<script>
				window.alert(\"내용을 입력해 주세요!\");
				history.go(-1);
			</script>";

		exit;
	}

	$writer = addslashes($writer);
	$email = addslashes($email);
	$comment = DisableHTML($comment);
	$comment = nl2br($comment);
	$comment = addslashes($comment);
	
	if($password) $password = crypt($password);
	if(!$row_member[id]) $row_member[id] = "guest";
	
	## serialnum 구하기 ######
	$result = mysql_query("SELECT IFNULL(max(serialnum),0)+1 FROM odtBoardNotice WHERE boardserialnum=$serialnum");
	$row = mysql_fetch_array($result);
	
	$noticeserialnum = $row[0];

	$INresult = mysql_query("INSERT INTO odtBoardNotice (boardserialnum,serialnum,writer,writerid,email,password,comment,wdate,ip) VALUES ($serialnum,$noticeserialnum,'$writer','$row_member[id]','$email','$password','$comment',now(),'$ip')");
	
	if($INresult) {
		echo "
			<script>
				window.alert('글이 등록되었습니다. ');
			</script>";

		echo "<meta http-equiv='refresh' content='0; URL=od_boardread.php$parTemp&Mode=readForm'>";
		exit;
	}
	else {
		echo "
			<script>
				window.alert(\"DB 접속 에러입니다!\");
				history.go(-1);
			</script>";

		exit;
	}
?>