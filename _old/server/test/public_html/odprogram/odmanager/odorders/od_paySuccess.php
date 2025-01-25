<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "../../odcommon/od_lib.inc.php";
	include "$folderpath_manager_common/od_adminAuthority.inc.php";

	if( sizeof($OrderNum) > 0 ) {

		$app_order_num = implode("','" , $OrderNum);

		$que = "update odtOrder set paystatus2='Y' where paystatus='Y' and paystatus2='N' and ordernum in ('${app_order_num}') ";


		$res = mysql_query($que);
		if($res) {
			echo "<script>alert('결제가 승인처리 되었습니다');top.location.reload();</script>";
		}

	}
	exit;
?>