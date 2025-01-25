<?
	include "../odcommon/od_config.inc.php";
	include "../odcommon/od_function.inc.php";
	include "od_board.inc.php";
	
	if(!strcmp($Form,"boardAllDelete")) {
		$deleteSerialnum_Division = explode("/",$deleteSerialnum);
		$deleteSerialnum_Total = count($deleteSerialnum_Division);
		$deleteSerialnum_Total = $deleteSerialnum_Total - 1;
		
		for($j = 0; $j < $deleteSerialnum_Total; $j++) {
			if($deleteSerialnum_Division[$j]){
				$result = mysql_query("SELECT familyid,depth FROM odtBoard WHERE serialnum='$deleteSerialnum_Division[$j]'");
				$row = mysql_fetch_array($result);
				$familyid = $row[0];
				$depth = $row[1];
				$depthLength = strlen($depth);
				$result = mysql_query("SELECT file1,file2,file3,file4,file5 FROM odtBoard WHERE familyid=$familyid AND depth like '$depth%'");
				while($row = mysql_fetch_array($result)) {
					for($i=1;$i<=5;$i++) {
						if($row["file$i"] != "none" && $row["file$i"] != "") {
							$fileC = file_exists("$boardUploadImgDIR/".$row["file$i"]);
							if($fileC) unlink("$boardUploadImgDIR/".$row["file$i"]);
						}
					}
				}
				$notice_result = mysql_query("SELECT serialnum FROM odtBoard WHERE familyid='$familyid' AND LEFT(depth,$depthLength) = '$depth'");
				while($notice_row = mysql_fetch_array($notice_result)) {
					## 부모글 및 그에 속한 댓글을 삭제 ######################################
					mysql_query("DELETE FROM odtBoard WHERE serialnum='$notice_row[0]'");
					mysql_query("DELETE FROM odtBoardNotice WHERE boardserialnum='$notice_row[0]'");
				}
			}
		}

		echo "
			<script name=javascript>
				window.alert('삭제 되었습니다.   ');
			</script>";

		echo "<meta http-equiv='Refresh' content='0; URL=$boardmoveTemp?board=$board'>";
	}
	else {
		for ($i=0;$i<sizeof($checkSerialnum);$i++) {
			$deleteSerialnum .= $checkSerialnum[$i]."/";
		}
		
		echo "
			<script language=\"javascript\">
				if(confirm(\"삭제하려고 하는 글에 속한 답글 및 댓글도 모두 삭제됩니다.   \\n\\n선택하신 글들을 삭제 하시겠습니까?   \"))
					self.location.replace('?Form=boardAllDelete&deleteSerialnum=$deleteSerialnum&board=$board')
				else
					self.location.replace('$boardmoveTemp?board=$board')
			</script>";

		exit;
	}
?>