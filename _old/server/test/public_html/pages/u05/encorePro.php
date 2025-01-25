<?php
// 필요한 설정파일 불러오기
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_config.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_function.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_lib.inc.php";

if(!$row_member[id]) {
	error_msgall("회원전용 페이지 입니다.");
	exit;
}

$que = "select enLog from odtEncore where enCode = '".$_GET[code]."'";
$res = mysql_query($que);
if(!mysql_num_rows($res)) {
	mysql_query("insert into odtEncore set enCode = '".$_GET[code]."', enLog = ',".$row_member[id]."', enCnt = 1");
	error_msgall('앵콜 투표에 참여하셨습니다.');
	echo "<script>
		obj = parent.document.getElementById('encoreHTML_".$_GET[code]."');
		obj.innerHTML = obj.innerHTML * 1 + 1;
		</script>";
	exit;
} else {
	$log = mysql_result($res,0);
	if(strstr($log,",".$row_member[id])) {
		error_msgall('이미 앵콜 투표에 참여하셨습니다.');
		exit;
	} else {
		$res = mysql_query("update odtEncore set enLog = concat(enLog,',".$row_member[id]."') , enCnt = enCnt + 1 where enCode = '".$_GET[code]."'");
		if($res) {
			error_msgall('앵콜 투표에 참여하셨습니다.');
			echo "<script>
				obj = parent.document.getElementById('encoreHTML_".$_GET[code]."');
				obj.innerHTML = obj.innerHTML * 1 + 1;
				</script>";
			exit;
		} else {
			error_msgall('오류가 발생하였습니다.');
			exit;
		}
	}
}

?>