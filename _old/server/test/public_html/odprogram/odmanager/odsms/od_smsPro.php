<?
	include "../../odcommon/od_config.inc.php";
	include "../../odcommon/od_lib.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";


	## 세부권한 체크
	if($row_admin[smsLevel]==3 || $row_admin[superLevel]==9) {
	}
	else {
		error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
	}

	if(!strcmp($form,"sendform")) {

		$tran_callback			= $send_from_num1 ."-". $send_from_num2 ."-". $send_from_num3;
		$tran_msg						=	$message;
		$arr = explode("/",$send_list_serial);
		for($i=0;$i<count($arr);$i++) {
			$tran_phone	= $arr[$i];
			$smsQue = "insert into em_tran set tran_phone = '".$tran_phone."', tran_callback = '".$tran_callback."', tran_msg= '".$tran_msg."', tran_status = 1, tran_date = now()";
			$res = mysql_query($smsQue);
			if(!$res) {
				error_msgall('메세지 발송중 오류가 발생하였습니다.');exit;
			}
		}

		error_msgall(count($arr)."개의 메세지가 발송되었습니다.");
	}
?>
<script>
parent.location.reload();
</script>