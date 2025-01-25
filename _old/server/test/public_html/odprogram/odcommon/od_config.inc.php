<?
header("Content-Type: text/html; charset=utf-8"); 
$arr_deny_ip = array("118.219.234.241" , "118.219.234.108" , "112.158.235.11");
if( in_array($_SERVER[REMOTE_ADDR] , $arr_deny_ip )) { exit; }
include "od_db_conf.php";


## 쇼핑몰 절대경로 설정 (서버상의 경로를 지정 합니다.)
$path_root = $_SERVER[DOCUMENT_ROOT]."/odprogram";

## 쇼핑몰 도메인 설정 (도메인까지만 설정 합니다.)
$path_domain = "http://".$_SERVER[HTTP_HOST];

## 쇼핑몰 설치경로(URL) 설정 (URL: 쇼핑몰 프로그램이 설치된 경로를 지정 합니다.)
$path_home = "http://".$_SERVER[HTTP_HOST]."/odprogram";

## 아래 부분은 변경하지 않으셔도 되는 부분입니다.
$folderpath_common = $path_root."/odcommon";	// modify ../
$folderpath_manager = $path_home."/odmanager";
$folderpath_manager_root = $path_root."/odmanager";
$folderpath_manager_common = $path_root."/odmanager/odcommon";
$folderpath_image = $path_home."/odimages";
$folderpath_manger_image = $path_home."/odmanager/odimages";
$folderpath_upload = $path_home."/upfiles";
$folderpath_upload_root = $path_root."/upfiles";
$folderpath_product_image = $folderpath_upload."/odproducts";
$folderpath_board_upload = "../upfiles/odboard/odupload";
$urlpath_board_titleimg = $folderpath_upload."/odboard/odtitleimg";
$urlpath_board_upload = $folderpath_upload."/odboard/odupload";
$folderpath_upfiles	=	"/odprogram/upfiles";
$chk_hide = true;

error_reporting(E_ALL ^ E_NOTICE);
extract($_GET); 
extract($_COOKIE); 
extract($_POST); 
extract($_SERVER); 
extract($HTTP_ENV_VARS);
extract($_FILES);

session_start();

// 관리자 페이지 특정메뉴 on/off
$switch_manager_page = "none";

/* 파일값 처리 ㅠㅠ */
foreach($_FILES as $key => $var) {
	${$key}					= $var[tmp_name];
	${$key."_name"} = $var[name];
}

// 특정 페이지 외에는 비회원 세션을 삭제
$array_allowurl = array(
									'/odprogram/ododlogon/od_loginForm2.php',
									'/odprogram/odproducts/od_order.php',
									'/odprogram/odproducts/od_orderresult.php',
									'/odprogram/odproducts/od_ordercomplete.php',
									'/odprogram/odproducts/od_ordersearchresult.php',
									'/odprogram/odpostcode/od_postsearch.php',
									'/odprogram/odpostcode/od_postsearchresult.php',
									'/odprogram/odproducts/od_delAddrSearch.php',
									);
if($_SESSION[Gid] && $_GET[Pid] != "u03b06" && array_search($_SERVER[PHP_SELF],$array_allowurl) == false) {
//	$_SESSION[Gid] = "";
}

$chk_help = false;

// 판매레포트를 위한 아이피 저장.
if(!$_SESSION[remoteIP]) {
	$_SESSION[remoteIP] = "1";

	// 로그에 기록되어있는지 체크
	$chk_fistvisit = mysql_result(mysql_query("select count(*) from odtBuyTime where ip='".$_SERVER[REMOTE_ADDR]."' and date like '".date('Y-m-d')."%'"),0);

	// 없으면 기록.
	if(!$chk_fistvisit) {
		mysql_query("insert into odtBuyTime set ip='".$_SERVER[REMOTE_ADDR]."', date = now()");
	}

}

$array_delivery = array('우체국택배','현대택배','한진택배','KGB택배','대한통운','로젠택배','삼성택배','옐로우택배','CJ택배','하나로택배','동부익스프레스','화물배송');




// MD 아이디
$array_adminid = array(
											'admin'=>'md_s3.gif',
											);

$array_cate_asc = array("01"=>"today","02"=>"week","03"=>"live","04"=>"three","05"=>"five");
$array_cate_desc = array("today"=>"01","week"=>"02","live"=>"03","three"=>"04","five"=>"05");

$array_week = array("일","월","화","수","목","금","토");
?>