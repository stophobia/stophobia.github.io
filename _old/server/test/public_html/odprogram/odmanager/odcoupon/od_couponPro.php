<?
	include "../../odcommon/od_config.inc.php";
	include "../../odcommon/od_lib.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";

chk_authfree();

	switch($_POST[subMode]) {
		case "ins" :
			
		
			$coType			=	$_POST[coType];
			$coName			=	$_POST[coName];
			$coPrice		=	$_POST[coPrice];
			$coLimit		=	$_POST[coLimit];
			$coIDArray	=	explode(",",$_POST[coIDArray]);

			
			for($i=0;$i<count($coIDArray);$i++) {

				$que = "insert into odtCoupon set
								coType	=	'".$coType."',
								coName	=	'".$coName."',
								coPrice	=	'".$coPrice."',
								coLimit	=	'".$coLimit."',
								coID		=	'".$coIDArray[$i]."',
								coUse		=	'N',
								coRegidate	=	now()";

				$res = mysql_query($que);
				if(!$res) {
					error_msgall('등록중 오류가 발생하였습니다.');
					exit;
				}

			}

			break;

		case "del" :

			$no = $_POST[memSerialnum];
			for($i=0;$i<count($no);$i++) {
				mysql_query("delete from odtCoupon where coNo = '".$no[$i]."'");
			}
			break;
}
error_msgall('처리되었습니다.');
echo "<script>parent.location.reload();</script>";
exit;


?>