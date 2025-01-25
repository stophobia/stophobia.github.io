<?
	# 2011-01-21 오전 10:50 박종익 수정중
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";

	## 세부권한 체크
	if($row_admin[gongguLevel]==7 || $row_admin[gongguLevel]==9 || $row_admin[superLevel]==9) {
	}
	else {
		error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
	}
	
	if(!strcmp($Form,"boardDelete")) {
		## 관련이미지 삭제
		if(file_exists("$folderpath_upload_root/boards/titleimg/title$serialnum.jpg"))
			unlink("$folderpath_upload_root/boards/titleimg/title$serialnum.jpg");
		if(file_exists("$folderpath_upload_root/odboards/odicons/newicon$serialnum.jpg"))
			unlink("$folderpath_upload_root/odboards/odicons/newicon$serialnum.gif");
		if(file_exists("$folderpath_upload_root/odboards/odicons/listicon$serialnum.jpg"))
			unlink("$folderpath_upload_root/odboards/odicons/listicon$serialnum.gif");
		if(file_exists("$folderpath_upload_root/odboards/odicons/writeicon$serialnum.jpg"))
			unlink("$folderpath_upload_root/odboards/odicons/writeicon$serialnum.gif");
		if(file_exists("$folderpath_upload_root/odboards/odicons/modifyicon$serialnum.jpg"))
			unlink("$folderpath_upload_root/odboards/odicons/modifyicon$serialnum.gif");
		if(file_exists("$folderpath_upload_root/odboards/odicons/replyicon$serialnum.jpg"))
			unlink("$folderpath_upload_root/odboards/odicons/replyicon$serialnum.gif");
		if(file_exists("$folderpath_upload_root/odboards/odicons/deleteicon$serialnum.jpg"))
			unlink("$folderpath_upload_root/odboards/odicons/deleteicon$serialnum.gif");
		if(file_exists("$folderpath_upload_root/odboards/odicons/okicon$serialnum.jpg"))
			unlink("$folderpath_upload_root/odboards/odicons/okicon$serialnum.gif");
		if(file_exists("$folderpath_upload_root/odboards/odicons/cancelicon$serialnum.jpg"))
			unlink("$folderpath_upload_root/odboards/odicons/cancelicon$serialnum.gif");
		
		$result = mysql_query("select file1,file2,file3,file4,file5 FROM odtBoard WHERE boardkind=$serialnum");
		
		while($row = mysql_fetch_array($result)) {
			for($i=0;$i<5;$i++) {
				if($row[$i] != "" && file_exists("$folderpath_upload_root/boards/upload/".$row[$i])) 
					unlink("$folderpath_upload_root/boards/upload/".$row[$i]);
			}
		}

		## 관련된 댓글 삭제
		$reply_result = mysql_query("SELECT serialnum,familyid FROM odtBoard WHERE boardkind=$serialnum");
		
		while($reply_row = mysql_fetch_array($reply_result)) {
			mysql_query("DELETE FROM odtBoardNotice WHERE boardserialnum='$reply_row[0]' OR boardserialnum='$reply_row[1]'");
		}

		mysql_query("DELETE FROM odtBoard WHERE boardkind=$serialnum");
		mysql_query("DELETE FROM odtBoardConfig WHERE serialnum=$serialnum");
		
		## 정렬순위값 조정
		mysql_query("UPDATE odtBoardConfig SET lineUp=lineUp-1 WHERE lineUp>'$pLineUp'");
		
		echo "
			<script name=javascript>
				window.alert('삭제되었습니다.   ');
			</script>";

		echo "<meta http-equiv='Refresh' content='0; URL=od_boardkindlist.php'>";
		exit;
	}
	else {
		echo "
			<script language=\"javascript\">
				if(confirm('게시판을 삭제하시면 해당글은 물론     \\n\\n댓글까지 모두 삭제 됩니다.\\n\\n정말 삭제하세겠습니까?   \\n'))
					self.location.replace('?Form=boardDelete&serialnum=$serialnum&pLineUp=$pLineUp')
				else
					self.location.replace('od_boardkindlist.php')
			</script>";

		exit;
	}
?>