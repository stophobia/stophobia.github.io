<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";

	## 세부권한 체크
	if($row_admin[memberLevel] < 3) {
		error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
	}

    if(!$_GET[pwID]) exit;

	$que = "select * from odtMember where id='".$_GET[pwID]."'";
	$res = mysql_query($que);
	if(!mysql_num_rows($res)) {msg('해당 아이디가 없습니다');exit;}
	$row = mysql_fetch_array($res);
	if(!$row[htel1] || !$row[htel2] || !$row[htel3]) {msg('핸드폰번호가 존재하지 않는 회원입니다.');exit;}

	$tran_phone			= $row[htel1] ."-". $row[htel2] ."-". $row[htel3];
	$tran_callback	= $_companySetup[tel];
	$tran_msg				=	"고객님의 아이디는 ".$_GET[pwID]." 이며 비밀번호는 ".$row[repasswd]."입니다.";
	$smsQue = "insert into em_tran set tran_phone = '".$tran_phone."', tran_callback = '".$tran_callback."', tran_msg= '".$tran_msg."', tran_status = 1, tran_date = now()";
	$res = mysql_query($smsQue);	

	if($res) {
		msg($_GET[pwID]."님의 비밀번호가 ".$tran_phone."로 발송되었습니다.");
		exit;
	}
?>