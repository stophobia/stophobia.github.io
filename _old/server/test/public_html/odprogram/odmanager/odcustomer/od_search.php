<?
	include "../../odcommon/od_config.inc.php";
	include "../../odcommon/od_lib.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";

	$isID = @mysql_result(mysql_query("select count(*) from odtMember where id='".$_GET[id]."'"),0);
	if($isID) {
?>
	<script>
	obj = parent.document.getElementById('searchinnerHTML');
	obj.innerHTML = "<span style='color:red'>사용불가ID</span>";
	</script>
<?
	}	else {
?>
	<script>
	obj = parent.document.getElementById('searchinnerHTML');
	obj.innerHTML = "<span style='color:5AAC5A'>사용가능ID</span>";
	</script>
<?
	}
?>