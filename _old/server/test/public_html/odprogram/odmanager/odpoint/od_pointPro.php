<?
	include "../../odcommon/od_config.inc.php";
	include "../../odcommon/od_lib.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";


	switch($_POST[subMode]) {
		case "ins" :
			
			$pointPoint		=	$_POST[pointPoint];
			$pointTitle		=	$_POST[pointTitle];
			$redRegidate	=	$_POST[redRegidate];

			$pointIDArray	=	explode(",",$_POST[pointIDArray]);

			
			for($i=0;$i<count($pointIDArray);$i++) {
				if(!$pointIDArray[$i]) continue;

				# 포인트 지급;
//				@mysql_query("update odtMember set point = point + ".$pointPoint." where id='".$pointIDArray[$i]."'");
//				$pointResult = @mysql_result(mysql_query("select point from odtMember where id='".$pointIDArray[$i]."'"),0);

				$que = "insert into odtPointLog set
								pointID				=	'".$pointIDArray[$i]."',
								pointTitle		=	'".$pointTitle."',
								pointPoint		=	".$pointPoint.",
								pointStatus		=	'N',
								redRegidate		=	'".$redRegidate."',
								pointRegidate	=	now()";

				$res = @mysql_query($que);

				exec("/usr/local/bin/php ".$_SERVER[DOCUMENT_ROOT]."/cron/pointAutoUpdate.php");

				if(!$res) {
					error_msgall('등록중 오류가 발생하였습니다.');
					exit;
				}

			}

			break;
		case "del" :
		
			$no = $_POST[memSerialnum];
			for($i=0;$i<count($no);$i++) {
				mysql_query("delete from odtPointLog where pointNo = '".$no[$i]."'");
			}
			break;
}

error_msgall('처리되었습니다.');
echo "<script>parent.location.reload();</script>";
exit;


?>