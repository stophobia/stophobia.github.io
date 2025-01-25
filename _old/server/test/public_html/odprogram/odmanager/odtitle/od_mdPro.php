<?
	include "../../odcommon/od_config.inc.php";
	include "../../odcommon/od_lib.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";

	## 세부권한 체크
	if($row_admin[memberLevel] < 3) {
		error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
	}

	switch($subMode) {
		case "ins" :
			$mdName			= $_POST[mdName];
			$mdID				= $_POST[mdID];
			$mdNick			= $_POST[mdNick];
			$mdUnique		= $_POST[mdUnique];
			$mdAim			= $_POST[mdAim];

			# 파일 업로드
			$dir = "/odprograml/upfiles/odmd";
			$mdImg			= $mdImg[name]			? file_upload($_FILES[mdImg],$dir)		: NULL;

			$res = mysql_query("insert into odtMD set
													mdName		= '".$mdName."',
													mdID			= '".$mdID."',
													mdNick		= '".$mdNick."',
													mdUnique	= '".$mdUnique."',
													mdAim			= '".$mdAim."',
													mdImg			=	'".$mdImg."'");

			if(!$res) {
				error_msgall('오류가 발생하였습니다.');
				echo mysql_error();
				exit;
			}
			break;

		case "edt" :
			$mdNo				= $_POST[no];
			$mdName			= $_POST[mdName];
			$mdID				= $_POST[mdID];
			$mdNick			= $_POST[mdNick];
			$mdUnique		= $_POST[mdUnique];
			$mdAim			= $_POST[mdAim];

			# 파일 삭제
			$mdImg_org			= $mdImg_del			== "Y" || $main_img[mdImg]			? file_delete($_SERVER[DOCUMENT_ROOT].$mdImg_org)			: $mdImg_org;

			# 파일 업로드
			$dir = "/odprograml/upfiles/odmd";
			$mdImg			= $mdImg[name]			? file_upload($_FILES[mdImg],$dir)		: $mdImg_org;

			$res = mysql_query("update odtMD set
													mdName		= '".$mdName."',
													mdID			= '".$mdID."',
													mdNick		= '".$mdNick."',
													mdUnique	= '".$mdUnique."',
													mdAim			= '".$mdAim."',
													mdImg			=	'".$mdImg."'
													where
													mdNo			=	'".$mdNo."'");

			if(!$res) {
				error_msgall('오류가 발생하였습니다.');
				echo mysql_error();
				exit;
			}
			break;

		case "del" :
			$noArray				= $_POST[noArray];
			
			for($i=0;$i<count($noArray);$i++) {
				$res = mysql_query("delete from odtMD where mdNo = '".$noArray[$i]."'");
			}

			if(!$res) {
				error_msgall('오류가 발생하였습니다.');
				echo mysql_error();
				exit;
			}

			break;
	}
?>
<script>
parent.location.reload();
</script>