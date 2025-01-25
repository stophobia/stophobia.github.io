<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";

	## 세부권한 체크
	if($row_admin[memberLevel]==7 || $row_admin[memberLevel]==9 || $row_admin[superLevel]==9) {
	}
	else {
		error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
	}

	// 체험판 사용제한
	chk_authfree();

	if( $_GET["Form"] == "memberDelete" ) {

		if( sizeof( $memSerialnum ) > 0 ) {
			foreach($memSerialnum  as $k=>$v){
				$row = mysql_fetch_array(mysql_query("SELECT id FROM odtMember WHERE serialnum='$v'"));
				mysql_query("DELETE FROM odtInterestProd WHERE Memid='$row[id]'");
				mysql_query("DELETE FROM odtCouponHistory WHERE id='$row[id]'");
				mysql_query("DELETE FROM odtMember WHERE serialnum='$v' and Mlevel !='9'");
			}
		}

		error_msgloc("od_list.php","강제탈퇴(삭제) 처리가 잘 되었습니다.");
		exit;

	}
	else {

		error_msgloc("od_list.php","정상적으로 처리되지 않았습니다.");
		exit;

	}

?>