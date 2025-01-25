<?php
// 필요한 설정파일 불러오기
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_config.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_function.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_lib.inc.php";

if(!$row_member[Mlevel] > 8) {
	error_msgall('관리자페이지입니다.');
	exit;
}

$_POST[subMode] = $_GET[subMode] == "del" ? "del" : $_POST[subMode];

switch($_POST[subMode]) {
	case "ins" :

		$que = "insert into odtIlji set
						iljiTitle			= '".$_POST[iljiTitle]."',
						iljiContent		=	'".addslashes($_POST[iljiContent])."',
						iljiRegidate	= '".$_POST[iljiDate]."'";
		$res = mysql_query($que);

		break;
	case "edt" :

		$que = "update odtIlji set
						iljiTitle			= '".$_POST[iljiTitle]."',
						iljiContent		=	'".addslashes($_POST[iljiContent])."'
						where
						iljiNo				=	'".$_POST[iljiNo]."'";
		$res = mysql_query($que);

		break;
	case "del" :

		$que = "delete from odtIlji where iljiNo =	'".$_GET[iljiNo]."'";
		$res = mysql_query($que);

		break;
}

if($res) {
	echo "<script>parent.location.reload();</script>";
	exit;
} else {
	echo mysql_error();
	echo "<script>alert('에러');</script>";
	exit;
}

?>