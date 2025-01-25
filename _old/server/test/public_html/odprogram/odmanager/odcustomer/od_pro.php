<?
	include "../../odcommon/od_config.inc.php";
	include "../../odcommon/od_lib.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";

	switch($_POST[subMode]) {
		case "ins" :
			
			$id				=	$_POST[id];
			$passwd		=	$_POST[passwd];
			$bannder	=	$_POST[bannder];
			$cName		=	$_POST[cName];
			$cNumber	=	$_POST[cNumber];
			$name			=	$_POST[name];
			$ceoName	=	$_POST[ceoName];
			$address	=	$_POST[address];
			$cItem1		=	$_POST[cItem1];
			$cItem2		=	$_POST[cItem2];
			$tel1			=	$_POST[tel1];
			$tel2			=	$_POST[tel2];
			$tel3			=	$_POST[tel3];
			$ofax1		=	$_POST[ofax1];
			$ofax2		=	$_POST[ofax2];
			$ofax3		=	$_POST[ofax3];
			$htel1		=	$_POST[htel1];
			$htel2		=	$_POST[htel2];
			$htel3		=	$_POST[htel3];
			$email		=	$_POST[email];
			$homepage	=	$_POST[homepage];

			# 파일 업로드
			$dir = "/obprogram/upfiles/odcustomer";
			$pic			= $pic[name]			? file_upload($_FILES[pic],$dir)		: NULL;

			$que = "insert into odtMember set
								id				=	'".$id."',
								passwd		=	password('".$passwd."'),
								cName			=	'".$cName."',
								bannder		=	'".$bannder."',
								cNumber		=	'".$cNumber."',
								name			=	'".$name."',
								ceoName		=	'".$ceoName."',
								address		=	'".$address."',
								cItem1		=	'".$cItem1."',
								cItem2		=	'".$cItem2."',
								tel1			=	'".$tel1."',
								tel2			=	'".$tel2."',
								tel3			=	'".$tel3."',
								ofax1			=	'".$ofax1."',
								ofax2			=	'".$ofax2."',
								ofax3			=	'".$ofax3."',
								htel1			=	'".$htel1."',
								htel2			=	'".$htel2."',
								htel3			=	'".$htel3."',
								email			=	'".$email."',
								homepage	=	'".$homepage."',
								pic				=	'".$pic."',
								signdate	=	'".time()."',
								userType	= 'C'";

			$res = mysql_query($que);

			if(!$res) {
				error_msgall('등록중 오류가 발생하였습니다.');
				echo mysql_error();
				exit;
			}

			break;
		case "edt" :

			$id				=	$_POST[id];
			$passwd		=	$_POST[passwd];
			$bannder	=	$_POST[bannder];
			$cName		=	$_POST[cName];
			$cNumber	=	$_POST[cNumber];
			$ceoName	=	$_POST[ceoName];
			$name			=	$_POST[name];
			$address	=	$_POST[address];
			$cItem1		=	$_POST[cItem1];
			$cItem2		=	$_POST[cItem2];
			$tel1			=	$_POST[tel1];
			$tel2			=	$_POST[tel2];
			$tel3			=	$_POST[tel3];
			$ofax1		=	$_POST[ofax1];
			$ofax2		=	$_POST[ofax2];
			$ofax3		=	$_POST[ofax3];
			$htel1		=	$_POST[htel1];
			$htel2		=	$_POST[htel2];
			$htel3		=	$_POST[htel3];
			$email		=	$_POST[email];
			$homepage	=	$_POST[homepage];

			# 파일 삭제
			$pic_org			= $pic_del			== "Y" || $pic[name]			? file_delete($_SERVER[DOCUMENT_ROOT].$pic_org)			: $pic_org;

			# 파일 업로드
			$dir = "/obprogram/upfiles/odcustomer";
			$pic			= $pic[name]			? file_upload($_FILES[pic],$dir)		: $pic_org;

			if($passwd) {
				mysql_query("update odtMember set passwd		=	password('".$passwd."') where id='".$id."'");
			}

			$que = "update odtMember set
								cName			=	'".$cName."',
								bannder		=	'".$bannder."',
								cNumber		=	'".$cNumber."',
								name			=	'".$name."',
								ceoName		=	'".$ceoName."',
								address		=	'".$address."',
								cItem1		=	'".$cItem1."',
								cItem2		=	'".$cItem2."',
								tel1			=	'".$tel1."',
								tel2			=	'".$tel2."',
								tel3			=	'".$tel3."',
								ofax1			=	'".$ofax1."',
								ofax2			=	'".$ofax2."',
								ofax3			=	'".$ofax3."',
								htel1			=	'".$htel1."',
								htel2			=	'".$htel2."',
								htel3			=	'".$htel3."',
								homepage	=	'".$homepage."',
								pic				=	'".$pic."',
								email			=	'".$email."'
								where
								id				=	'".$id."'";

			$res = mysql_query($que);

			if(!$res) {
				error_msgall('수정중 오류가 발생하였습니다.');
				echo mysql_error();
				exit;
			}


			break;
		case "del" :


			break;
}

echo "<script>parent.location.reload();</script>";
exit;
?>