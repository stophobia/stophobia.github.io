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

	$fileTmp  = $_FILES[fileTmp];
	$fileTmp_box1  = $_FILES[fileTmp_box1];
	$fileTmp_box2  = $_FILES[fileTmp_box2];
	$fileTmp_box3  = $_FILES[fileTmp_box3];


	$dir = "/odprogram/upfiles/design";
	$uploadFolder=$_SERVER[DOCUMENT_ROOT].$dir;


if($fileTmp[name]) {
	/* 확장자체크 -----------------------------------------*/
	if(strtoupper(end(explode(".",$fileTmp[name]))) != "JPG") {
		echo "<script>alert('JPG만 업로드 할수 있습니다. 확장자를 바꿔주세요.');</script>";
		exit;
	}
	@copy($fileTmp[tmp_name],$uploadFolder."/".$mode.".jpg");
	@unlink($fileTmp[tmp_name]);
}


if($fileTmp_box1[name]) {
	/* 확장자체크 -----------------------------------------*/
	if(strtoupper(end(explode(".",$fileTmp_box1[name]))) != "JPG") {
		echo "<script>alert('JPG만 업로드 할수 있습니다. 확장자를 바꿔주세요.');</script>";
		exit;
	}
	@copy($fileTmp_box1[tmp_name],$uploadFolder."/".$mode."_box1.jpg");
	@unlink($fileTmp_box1[tmp_name]);
}


if($fileTmp_box2[name]) {
	/* 확장자체크 -----------------------------------------*/
	if(strtoupper(end(explode(".",$fileTmp_box2[name]))) != "JPG") {
		echo "<script>alert('JPG만 업로드 할수 있습니다. 확장자를 바꿔주세요.');</script>";
		exit;
	}
	@copy($fileTmp_box2[tmp_name],$uploadFolder."/".$mode."_box2.jpg");
	@unlink($fileTmp_box2[tmp_name]);
}


if($fileTmp_box3[name]) {
	/* 확장자체크 -----------------------------------------*/
	if(strtoupper(end(explode(".",$fileTmp_box3[name]))) != "JPG") {
		echo "<script>alert('JPG만 업로드 할수 있습니다. 확장자를 바꿔주세요.');</script>";
		exit;
	}
	@copy($fileTmp_box3[tmp_name],$uploadFolder."/".$mode."_box3.jpg");
	@unlink($fileTmp_box3[tmp_name]);
}









	error_msgall('수정되었습니다.','reload');

?>