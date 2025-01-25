<?
	include "../../odcommon/od_config.inc.php";
	include "../../odcommon/od_lib.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";

	switch($_POST[subMode]) {
		case "ins" :
			
			$p_title		=	$_POST[p_title];
			$p_top			=	$_POST[p_top];
			$p_left			=	$_POST[p_left];
			$p_content	=	htmlspecialchars($_POST[p_content]);
			$p_view			=	$_POST[p_view];
			$p_startdate		=	$_POST[p_startdate];
			$p_enddate			=	$_POST[p_enddate];

			$que = "insert into odtPopup set
							p_title				=	'".$p_title."',
							p_top			    =	'".$p_top."',
							p_left				=	'".$p_left."',
							p_content			=	'".$p_content."',
							p_view				=	'".$p_view."',
							p_regidate		=		now(),
							p_startdate		=   '".$p_startdate."',
							p_enddate		=	'".$p_enddate."'";

			$res = @mysql_query($que);

			if(!$res) {
				error_msgall('등록중 오류가 발생하였습니다.');
				exit;
			}
		
			break;

		case "edt" :
			
			$p_idx			=	$_POST[p_idx];
			$p_title		=	$_POST[p_title];
			$p_top			=	$_POST[p_top];
			$p_left			=	$_POST[p_left];
			$p_content	=	htmlspecialchars($_POST[p_content]);
			$p_view			=	$_POST[p_view];
			$p_startdate		=	$_POST[p_startdate];
			$p_enddate			=	$_POST[p_enddate];

			$que = "update odtPopup set
							p_title				=	'".$p_title."',
							p_top					=	'".$p_top."',
							p_left				=	'".$p_left."',
							p_content			=	'".$p_content."',
							p_view				=	'".$p_view."',
							p_regidate		=		now(),
							p_startdate		=   '".$p_startdate."',
							p_enddate		=	'".$p_enddate."'

							where
							p_idx					=	'".$p_idx."'";

			$res = @mysql_query($que);

			if(!$res) {
				error_msgall('등록중 오류가 발생하였습니다.');
				exit;
			}
		
			break;

		
		case "del" :
		
			$no = $_POST[memSerialnum];
			for($i=0;$i<count($no);$i++) {
				mysql_query("delete from odtPopup where p_idx = '".$no[$i]."'");
			}
			break;
}

error_msgall('처리되었습니다.');
echo "<script>parent.location.reload();</script>";
exit;


?>