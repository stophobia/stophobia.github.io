<?
	include "../../odcommon/od_config.inc.php";
	include "../odcommon/od_function.inc.php";		
	include "../odcommon/od_adminAuthority.inc.php";

	## 세부권한 체크
	if($row_admin[productLevel] < 3) {
		error_msgloc("../","접근권한이 없습니다.   ");
	}


	mysql_query("update odtDesign2 set sd_left = '".$_POST[left_source]."'");

	error_msgall('수정되었습니다.');

?>
<script>
if(confirm('수정된 페이지를 확인하시겠습니까?')) {
	window.open('/');
}
</script>