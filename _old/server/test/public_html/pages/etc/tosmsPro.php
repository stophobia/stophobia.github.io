<?php
// 필요한 설정파일 불러오기
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_config.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_lib.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_function.inc.php";


$_POST[textarea] = $_POST[fromName]."님의추천:".$_POST[textarea]." ".$_SERVER[HTTP_HOST];

$que = "insert into sendSMS set
				ss_code			=	'".$_POST[code]."',
				ss_id				=	'".$_POST[id]."',
				ss_name			=	'".$_POST[fromName]."',
				ss_to				=	'".$_POST[toHp1]."-".$_POST[toHp2]."-".$_POST[toHp3]."',
				ss_from			=	'".$_POST[fromHp1]."-".$_POST[fromHp2]."-".$_POST[fromHp3]."',
				ss_text			=	'".$_POST[textarea]."',
				ss_regidate	=	now()";

$res = mysql_query($que);



$_POST[textarea] = iconv("utf-8","euckr",trim($_POST[textarea]));
$text_array = cut_str($_POST[textarea],80,100);
				
for($i=1;$i<count($text_array);$i++) {
				
	$smsQue = "insert into em_tran set tran_phone = '".$_POST[toHp1]."-".$_POST[toHp2]."-".$_POST[toHp3]."', tran_callback = '".$_POST[fromHp1]."-".$_POST[fromHp2]."-".$_POST[fromHp3]."', tran_msg= '".trim(iconv("euckr","utf-8",$text_array[$i]))."', tran_status = 1, tran_date = now()";

	$res2 = mysql_query($smsQue);

}

if($res2) {
	error_msgall('친구에게 추천문자를 발송하였습니다.','close');
}

/*
create table sendSMS (
ss_idx int auto_increment primary key,
ss_code varchar(100) not null default '',
ss_id varchar(100) not null default '',
ss_name varchar(100) not null default '',
ss_to varchar(100) not null default '',
ss_from varchar(100) not null default '',
ss_text varchar(255) not null default '',
ss_regidate datetime not null);
*/

?>