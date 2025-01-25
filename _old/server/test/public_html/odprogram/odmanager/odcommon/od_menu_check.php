<?
	include "../../odcommon/od_config.inc.php";
	include "../odcommon/od_function.inc.php";
	
	SetCookie("sub_menu",$sub_menu2,0,"/");

	if($sub_menu2 == 1) $menu_url = "$folderpath_manager/odmall/od_basic.php";
	else if($sub_menu2 == 2) $menu_url = "$folderpath_manager/odmall/od_imagefocus.php";
	else if($sub_menu2 == 3) $menu_url = "$folderpath_manager/oddesign/od_mail.php";
	else if($sub_menu2 == 4) $menu_url = "$folderpath_manager/odmembers/od_list.php";
	else if($sub_menu2 == 5) $menu_url = "$folderpath_manager/odproducts/od_calList.php";
	else if($sub_menu2 == 6) $menu_url = "$folderpath_manager/odorders/od_orderslist.php";
	else if($sub_menu2 == 7) $menu_url = "$folderpath_manager/odstatistics/od_cal.php";
	else if($sub_menu2 == 8) $menu_url = "$folderpath_manager/odgonggus/od_gonggulist.php";
	else if($sub_menu2 == 9) $menu_url = "$folderpath_manager/odauction/od_auctionlist.php";
	else if($sub_menu2 == 10) $menu_url = "$folderpath_manager/odboard/od_boardkindlist.php";
	else if($sub_menu2 == 11) $menu_url = "$folderpath_manager/odpoll/od_poll.php";
	else if($sub_menu2 == 12) $menu_url = "$folderpath_manager/odsms/od_smseach.php";
	else if($sub_menu2 == 13) $menu_url = "$folderpath_manager/odmall/od_nameauthen.php";
	else if($sub_menu2 == 14) $menu_url = "$folderpath_manager/odcounter/od_day.php";
	else if($sub_menu2 == 15) $menu_url = "$folderpath_manager/odcustomer/od_list.php";
	
	else if($sub_menu2 == 16) $menu_url = "$folderpath_manager/odorders2/od_orderslist.php?search_value_=true&delivstatus=no";
	else if($sub_menu2 == 29) $menu_url = "$folderpath_manager/odorders2/od_dlv_orderslist.php?search_value_=true&delivstatus=no";

	else if($sub_menu2 == 17) $menu_url = "$folderpath_manager/odmall/od_pg_basic.php";
	else if($sub_menu2 == 18) $menu_url = "$folderpath_manager/odmall/od_skin_form.php";
	else if($sub_menu2 == 19) $menu_url = "$folderpath_manager/odevent/od_report.php";
	else if($sub_menu2 == 20) $menu_url = "$folderpath_manager/odtitle/od_mdList.php";
	else if($sub_menu2 == 21) $menu_url = "$folderpath_manager/odcs/od_cs2List.php";
	else if($sub_menu2 == 22) $menu_url = "$folderpath_manager/odevent/od_eventlist.php";
	else if($sub_menu2 == 23) $menu_url = "$folderpath_manager/odaccount/od_accountInsert.php";
	else if($sub_menu2 == 25) $menu_url = "$folderpath_manager/odsupport/od_proInsert.php";
	else if($sub_menu2 == 26) $menu_url = "$folderpath_manager/oddesign/od_designmain.php";
	else if($sub_menu2 == 27) $menu_url = "$folderpath_manager/odetc/od_popupList.php";
	else if($sub_menu2 == 28) $menu_url = "$folderpath_manager/odsupport/od_proInsert2.php";

	echo "
		<script>
			location.href = '$menu_url';
		</script>";

	exit;
?>