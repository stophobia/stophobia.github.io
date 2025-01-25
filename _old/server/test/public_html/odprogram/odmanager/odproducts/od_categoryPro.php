<?
	include "../../odcommon/od_config.inc.php";
	include "../../odcommon/od_lib.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";


	// 체험판 사용제한
	chk_authfree();

	switch($_POST[subMode]) {
		case "ins" :
			
			$catename			=	$_POST[catename];
			$catecode			=	$_POST[catecode];
			$cHidden			=	$_POST[cHidden];

			$que = "insert into odtCategory set
							serialnum			=	'".$catecode."',
							catename			=	'".$catename."',
							catecode			=	'".$catecode."',
							cateidx					=	'".$cateidx."',
							cHidden				=	'".$cHidden."'";

			$res = @mysql_query($que);

			if(!$res) {
				error_msgall('등록중 오류가 발생하였습니다.');
				exit;
			}
		
			break;

		case "edt" :
			

			$catename			=	$_POST[catename];
			$catecode			=	$_POST[catecode];
			$cHidden			=	$_POST[cHidden];
			$serialnum		=	$_POST[serialnum];

			$que = "update odtCategory set
							catename				=	'".$catename."',
							catecode				=	'".$catecode."',
							cateidx					=	'".$cateidx."',
							cHidden					=	'".$cHidden."'
							where
							serialnum				=	'".$serialnum."'";

			$res = @mysql_query($que);

			if(!$res) {
				error_msgall('수정중 오류가 발생하였습니다.');
				exit;
			}
		
			break;

		
		case "del" :
		
			$no = $_POST[memSerialnum];
			for($i=0;$i<count($no);$i++) {

				$catecode = mysql_result(mysql_query("select catecode from odtCategory where serialnum='".$no[$i]."'"),0);

				$isPro = mysql_result(mysql_query("select count(*) from odtProduct where cateCode = '".$catecode."'"),0);

				if($isPro) {
					error_msgall('상품이 등록되어있는 지역은 삭제할수 없습니다.\n\n상품을 먼저 삭제해주세요.');
				}
				else {
					mysql_query("delete from odtCategory where serialnum = '".$no[$i]."'");
				}
			}
			break;
}

error_msgall('처리되었습니다.');
echo "<script>parent.location.reload();</script>";
exit;


?>