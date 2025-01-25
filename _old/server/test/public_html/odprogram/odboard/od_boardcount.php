<?
	include "../odcommon/od_config.inc.php";
	include "../odcommon/od_function.inc.php";
	include "od_board.inc.php";


	if($configReadLevel > $Cooki_Member_Level) historyBack();

	//authorityTest("Read");

	## 비밀글 비밀번호 비교 ##############################################################
	if($Mode == "readForm") {
		$privacy_result = mysql_query("SELECT password FROM odtBoard WHERE serialnum = $serialnum");
		$privacy_row = mysql_fetch_array($privacy_result);
		
		if($Cooki_Member_Level != 9) {
			$passwordDB = $privacy_row[password];		
			
			if(crypt($password,$passwordDB) != $passwordDB) { 
				error_msgback_user("비밀번호가 정확하지 않습니다.   "); 
			}
		}
	}

	## 비밀번호 암호화 ##########################################################################
	$passWord = "passWord=".$password;
	$pTemp = var_encode($passWord);
	$parTemp = "?board=$board";
	
	if($Mode) $parTemp .= "&Mode=$Mode";
	if($page) $parTemp .= "&page=$page";
	if($serialnum) $parTemp .= "&serialnum=$serialnum";
	if($field) $parTemp .= "&field=$field";
	if($value) $parTemp .= "&value=$value";
	if($passWord) $parTemp .= "&pTemp=$pTemp";
	
	$result = mysql_query("UPDATE odtBoard SET readcount = readcount+1 WHERE serialnum=$serialnum");
	
	if($result) {
		echo "<meta http-equiv='refresh' content='0; URL=od_boardread.php$parTemp'>";
		exit;
	}
	else {
		error_msgback_user("db 접속에러 입니다.{조회수증가}.   ");
	}
?>