<?
	include "../odcommon/od_config.inc.php";
	include "../odcommon/od_function.inc.php";
	include "od_board.inc.php";
	
	## 글읽기 권한체크
	if($configReadLevel > $Cooki_Member_Level) historyBack();

	## Par 정리 ##########################################################################
	$parTemp = "?board=$board";
	if($page) $parTemp .= "&page=$page";
	if($field) $parTemp .= "&field=$field";
	if($value) $parTemp .= "&value=$value";
	if($serialnum) $parTemp .= "&serialnum=$serialnum";
	if($pTemp) $parTemp .="&pTemp=$pTemp";

	$result = mysql_query("SELECT * FROM odtBoardNotice WHERE serialnum = $noticeserialnum and boardserialnum=$serialnum");
	
	if(!$result) {
		echo "
			<script>
				window.alert(\"DB 접속 에러입니다!\");
				history.go(-1);
			</script>";

		exit;
	}

	$row = mysql_fetch_array($result);
	
	if($Cooki_Member_Level != 9 && $row_member[id] != $row[writerid]) {
		$passwordDB = $row[password];		
		
		if(crypt($password,$passwordDB) != $passwordDB) {
			echo "
				<script>
					window.alert(\"비밀번호가 정확하지 않습니다.   \");
					history.go(-1);
				</script>";

			exit;
		}
	}

	if(!$noticeserialnum) {
		echo "
			<script>
				window.alert(\"해당 게시판이 없습니다.!\");
				history.go(-1);
			</script>";

		exit;
	}

	if(!$serialnum) {
		echo "
			<script>
				window.alert(\"해당 게시판이 없습니다.!\");
				history.go(-1);
			</script>";

		exit;
	}

	$Delresult = mysql_query("DELETE FROM odtBoardNotice WHERE serialnum=$noticeserialnum and boardserialnum=$serialnum");
	
	if($Delresult) {
		echo "
			<script>
				window.alert(\"글이 삭제되었습니다.   \");
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