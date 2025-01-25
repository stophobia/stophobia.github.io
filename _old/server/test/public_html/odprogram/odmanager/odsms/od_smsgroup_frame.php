<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_common/od_class.sms.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";
	
	$send_list_serial_tmp = explode("/",$send_list_serial);
	
	if(sizeof($send_list_serial_tmp) < 10) $send_count_id_str="0".sizeof($send_list_serial_tmp);
	else $send_count_id_str=sizeof($send_list_serial_tmp);
	
	$send_list_id_str="<select name='send_list' size=7 style='width:80%' multiple>";
	
	for($s=0;$s<sizeof($send_list_serial_tmp);$s++){
		$qry = "SELECT htel1,htel2,htel3 FROM odtMember where serialnum='$send_list_serial_tmp[$s]'";
		$res = mysql_query($qry);
		$row = mysql_fetch_array($res);
		
		$s_htel = $row[htel1]."-".$row[htel2]."-".$row[htel3];
		$send_list_id_str.="<option value='$s_htel'>$s_htel</option>";
	}

	$send_list_id_str.="</select>";
?>
		<script>
			parent.send_count_id.innerHTML="<?=$send_count_id_str;?>";
			parent.send_list_id.innerHTML="<?=$send_list_id_str;?>";
		</script>