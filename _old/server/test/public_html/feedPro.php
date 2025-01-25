<?
// 필요한 설정파일 불러오기
include "./odprogram/odcommon/od_config.inc.php";
include "./odprogram/odcommon/od_function.inc.php";
include "./odprogram/odcommon/od_lib.inc.php";

if($_POST[emailCheck]) {
	$ft_email = $_POST[feedEmail];
}

if($_POST[smsCheck]) {
	$ft_sms = $_POST[feedSms];
}



$que = "insert into feedTable set ft_email = '".$ft_email."', ft_sms='".$ft_sms."',ft_regidate=now()";
$res = mysql_query($que);
if($res) {
	error_msgall('구독신청이 완료되었습니다.');
	exit;
}

/* 
create table feedTable (
ft_idx int auto_increment primary key,
ft_email varchar(100) not null default '',
ft_sms varchar(100) not null default '',
ft_regidate datetime not null);
*/
?>