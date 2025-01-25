<?
	include "../../odcommon/od_config.inc.php";
	include "../odcommon/od_function.inc.php";		
	include "../odcommon/od_adminAuthority.inc.php";
	include "../odcommon/od_head.inc.php";
	include "../odcommon/od_body.inc.php";

	## 세부권한 체크
	if($row_admin[productLevel] < 3) {
		error_msgloc("../","접근권한이 없습니다.   ");
	}

	$fileTmp_off  = $_FILES[fileTmp_off];
	if($fileTmp_off[name]) {

		$dir = "/odprogram/upfiles/design";
		$uploadFolder=$_SERVER[DOCUMENT_ROOT].$dir;

		/* 확장자체크 -----------------------------------------*/
		if(strtoupper(end(explode(".",$fileTmp_off[name]))) != "JPG") {
			echo "<script>alert('JPG만 업로드 할수 있습니다. 확장자를 바꿔주세요.');</script>";
			exit;
		}

		@copy($fileTmp_off[tmp_name],$uploadFolder."/".$mode."_off_.jpg");
		@unlink($fileTmp_off[tmp_name]);
	}


	$fileTmp_over  = $_FILES[fileTmp_over];
	if($fileTmp_over[name]) {

		$dir = "/odprogram/upfiles/design";
		$uploadFolder=$_SERVER[DOCUMENT_ROOT].$dir;

		/* 확장자체크 -----------------------------------------*/
		if(strtoupper(end(explode(".",$fileTmp_over[name]))) != "JPG") {
			echo "<script>alert('JPG만 업로드 할수 있습니다. 확장자를 바꿔주세요.');</script>";
			exit;
		}

		@copy($fileTmp_over[tmp_name],$uploadFolder."/".$mode."_on_.jpg");
		@unlink($fileTmp_over[tmp_name]);
	}



	error_msgall('수정되었습니다.','reload');

?>