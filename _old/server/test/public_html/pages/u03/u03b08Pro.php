<?php
// 필요한 설정파일 불러오기
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_config.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_function.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_lib.inc.php";

if(!$row_member[id]) {
	error_msgall('회원전용 페이지 입니다.');
	exit;
}

if($row_member[id] != $_POST[id]) {
	exit;
}

if ( !$row_member[kcb_virtualno] ) {    //일반가입사용자
    $que = "select * from odtMember where id='".$_POST[id]."' and passwd = password('".$_POST[passwd]."') and resinum = '".md5($_POST[jumin1].$_POST[jumin2])."'";
} else {    //IPIN 사용자일때는 주민번호검사를 하지않음
    $que = "select * from odtMember where id='".$_POST[id]."' and passwd = password('".$_POST[passwd]."')";
}
$res = mysql_query($que);
if(!mysql_num_rows($res)) {
	error_msgall('정보가 일치하지 않습니다.');
	exit;
}

//$res = mysql_query("delete from odtMember where id='".$_POST[id]."' and passwd = password('".$_POST[passwd]."') and resinum = '".md5($_POST[jumin1].$_POST[jumin2])."'");
$res = mysql_query("update odtMember set 
										name='탈퇴한회원',
										email='',
										zip1 = '',
										zip2 = '',
										address = '',
										address1 = '',
										tel1 = '',
										tel2 = '',
										tel3 = '',
										htel1 = '',
										htel2 = '',
										htel3 = '',
										birthy='',
										birthm='',
										birthd='',
										passwd='deluser', 
										resinum = 'deluser' ,
										deldate = now(),
										kcb_encPsnlInfo = '',
										kcb_virtualno = '',
										kcb_realname = '',
										kcb_age = '',
										kcb_sex = '',
										kcb_birthdate = ''
										where id='".$_POST[id]."' and passwd = password('".$_POST[passwd]."')");
if($res) {
	error_msgall('정상적으로 탈퇴되었습니다.');
	echo "<script>parent.location.href='/odprogram/odlogon/od_logout.php'</script>";
	exit;
}
?>