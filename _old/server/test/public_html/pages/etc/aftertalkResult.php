<?php
// 필요한 설정파일 불러오기
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_config.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_function.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_lib.inc.php";

if(!$row_member[id]) {
	error_msgall('회원만 참여할 수 있습니다.');
	exit;
}

# 자신의 글인지 체크
$que = "select afterID,afterLog from odtAfterTalk where afterNo ='".$_GET[afterNo]."'";
$res = mysql_query($que);
$row = mysql_fetch_array($res);
if($row[afterID] == $row_member[id]) {
	error_msgall('자신의 글은 추천 할 수 없습니다.');
	exit;
}
if(@array_search($row_member[id],explode("|",$row['afterLog']))) {
	error_msgall('이미 참여하셨습니다.');
	exit;
}
#

if($_GET[mode] == "good") {
	$que = "	update odtAfterTalk set 
						afterGood = afterGood + 1,
						afterLog	=	concat(afterLog,'|".$row_member[id]."') 
						where 
						afterNo = '".$_GET[afterNo]."'";
} else if ($_GET[mode] == "bad") {
	$que = "	update odtAfterTalk set 
						afterBad = afterBad + 1,
						afterLog	=	concat(afterLog,'|".$row_member[id]."') 
						where 
						afterNo = '".$_GET[afterNo]."'";
}
$res  = mysql_query($que);

if($res) {
	echo "<script>
					alert('".($_GET[mode] == "good" ? "추천" : "비추천")." 하셨습니다.');
					obj = parent.document.getElementById('after".$_GET[mode]."_".$_GET[afterNo]."');
					obj.innerHTML = obj.innerHTML * 1 + 1;
				</script>";
	exit;
} else {
	echo mysql_error();
	echo "<script>alert('에러');</script>";
	exit;
}
?>