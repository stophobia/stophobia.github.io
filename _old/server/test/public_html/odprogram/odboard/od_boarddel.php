<?
	include "../odcommon/od_config.inc.php";
	include "../odcommon/od_function.inc.php";
	include "od_board.inc.php";

	// 체험판 사용제한
	chk_authfree();	

	authorityTest("Write");
	
	if($Mode == "deleteAnswer") {
		$result = mysql_query("SELECT * FROM odtBoard WHERE serialnum=$serialnum");
		
		if(!$result) { error_msgback_user("db 접속에러 입니다.{데이타호출}.   "); }
		
		$row = mysql_fetch_array($result);
		
		if($Cooki_Member_Level != 9 && $row_member[id] != $row[writerid]) {
			$passwordDB = $row[password];		
			
			if(crypt($password,$passwordDB) != $passwordDB) { error_msgback_user("비밀번호가 정확하지 않습니다.   "); }
		}
?>

		<form method='post' action='<?=$PHP_SELF?>' name="deleteForm">
			<input type='hidden' name='Mode' value='deletePro'>
			<input type='hidden' name='board' value='<?=$board?>'>
			<input type='hidden' name='serialnum' value='<?=$serialnum?>'>
			<input type='hidden' name='page' value='<?=$page?>'>
			<input type='hidden' name='field' value='<?=$field?>'>
			<input type='hidden' name='value' value='<?=$value?>'>
		</form>

		<script>
		<!--
			if(confirm("삭제하려고 하는 글에 속한 답글 및 댓글도 모두 삭제됩니다.   \n\n선택하신 글들을 삭제 하시겠습니까?   ")) {
				document.deleteForm.submit();
			}
			else {
				history.back();
			}
		//-->
		</script>
<?
	}
	else if($Mode == "deletePro") {
		if(!$board || !$serialnum) { 
			error_msgback_user("해당 게시판이 없습니다.   "); 
		}

		$result = mysql_query("SELECT familyid,depth FROM odtBoard WHERE serialnum=$serialnum");
		
		if(!$result) { error_msgback_user("db 접속에러 입니다.{select}.   "); }
		
		$row = mysql_fetch_array($result);
		
		$familyid = $row[0];
		$depth = $row[1];
		
		$result = mysql_query("SELECT file1,file2,file3,file4,file5 FROM odtBoard WHERE familyid=$familyid and depth like '$depth%'");
		
		if(!$result) { error_msgback_user("db 접속에러 입니다.{select}.   "); }
		
		while($row = mysql_fetch_array($result)) {
			for($i=1;$i<=5;$i++) {
				if($row["file$i"] != "none" && $row["file$i"] != "") {
					$fileC = file_exists("$folderpath_board_upload/".$row["file$i"]);
					
					if($fileC) unlink("$folderpath_board_upload/".$row["file$i"]);
				}
			}
		}

		$notice_result = mysql_query("SELECT serialnum FROM odtBoard WHERE familyid='$familyid' AND depth like '$depth%'");
		
		while($notice_row = mysql_fetch_array($notice_result)) {
			mysql_query("DELETE FROM odtBoard WHERE serialnum='$notice_row[0]'");
			mysql_query("DELETE FROM odtBoardNotice WHERE boardserialnum='$notice_row[0]'");
		}

		error_msgloc("$boardmoveTemp?board=$board&page=$page","글이 삭제되었습니다.   ");
		
		exit;
	}
?>
