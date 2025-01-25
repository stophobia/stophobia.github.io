<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";

	if($_GET[idx]) mysql_query("delete from feedTable where ft_idx='".$_GET[idx]."'");

?>
<script>
alert('삭제되었습니다.');
parent.location.reload();
</script>