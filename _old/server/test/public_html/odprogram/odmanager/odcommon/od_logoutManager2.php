<?
	include "../../odcommon/od_config.inc.php";
	
	$URL_Check = "/www/i";
	
	if(preg_match($URL_Check, $path_home)) $app_url = substr($path_home,10);
	else $app_url = substr($path_home,6);
	/*
	SetCookie("auth_pass_log","",0,"/","$app_url");
	SetCookie("auth_pass_log","",0,"/");
	SetCookie("auth_adminidmidi","",0,"/","$app_url");
	SetCookie("auth_adminid_sess","",0,"/","$app_url");
	SetCookie("auth_adminid","",0,"/");
	SetCookie("auth_adminid_sess","",0,"/");
*/

	SetCookie("auth_pass_log","",0,"/","$app_url");
	SetCookie("auth_pass_log","",0,"/");
	SetCookie("auth_comidmidi","",0,"/","$app_url");
	SetCookie("auth_comid_sess","",0,"/","$app_url");
	SetCookie("auth_comid","",0,"/");
	SetCookie("auth_comid_sess","",0,"/");

	echo "
		<script>
			window.alert('로그아웃 되었습니다. ');
		</script>";

	echo "<meta http-equiv='Refresh' content='0; URL=$path_home/odmanager/od_main.php?mode=sub'>";

?>