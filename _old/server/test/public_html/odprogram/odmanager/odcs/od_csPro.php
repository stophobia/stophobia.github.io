<?
	include "../../odcommon/od_config.inc.php";
	include "../../odcommon/od_lib.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";


	switch($_POST[subMode]) {
	case "del" :
		$no = $_POST[no];

		for($i=0;$i<count($no);$i++) {
			mysql_query("delete from odtProposal where proNo='".$no[$i]."'");
		}

		break;


}

error_msgall('처리되었습니다.');
echo "<script>parent.location.reload();</script>";
exit;


?>