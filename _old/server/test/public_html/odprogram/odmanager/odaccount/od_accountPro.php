<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";

	switch($subMode) {
		case "ins" :
			if($_POST[payMode] == "input") {
					$type			=	$_POST[payMode];
					$date			=	$_POST[payDate];
					$title		=	$_POST[payTitle];
					$price		=	$_POST[payPrice];
					$memo			=	$_POST[payMemo];
					$bank			=	$_POST[bank];
			} else {
					$type			=	$_POST[payMode];
					$date			=	$_POST[payDate2];
					$title		=	$_POST[payTitle2];
					$price		=	"-".$_POST[payPrice2];
					$memo			=	$_POST[payMemo2];
					$bank			=	$_POST[bank2];
			}

			$que = "insert into odtAccount set 
							type			=	'".$type."',
							date			=	'".$date."',
							title			=	'".$title."',
							price			=	'".$price."',
							memo			=	'".$memo."',
							bank			=	'".$bank."',
							regidate = now()";

			$res = mysql_query($que);

			if($res) {
				echo "<script>parent.location.reload();</script>";
			} else {
				error_msgall('에러발생');
				echo mysql_error();
				exit;
			}


		break;

		case "edt" :

			$no				=	$_POST[payNo];
			$type			=	$_POST['type'];
			$date			=	$_POST[payDate];
			$title		=	$_POST[payTitle];
			$price		=	$_POST[payPrice];
			$memo			=	$_POST[payMemo];
			$bank			=	$_POST[bank];

			$que = "update odtAccount set 
							type			=	'".$type."',
							date			=	'".$date."',
							title			=	'".$title."',
							price			=	'".$price."',
							memo			=	'".$memo."',
							bank			=	'".$bank."'
							where
							no				=	'".$no."'";

			$res = mysql_query($que);

			if($res) {
				echo "<script>parent.location.reload();</script>";
			} else {
				error_msgall('에러발생');
				echo mysql_error();
				exit;
			}

		break;

		
		case "del" :

			$no = $_POST[payNo];

			$res = mysql_query("delete from odtAccount where no='".$no."'");

			if($res) {
				echo "<script>parent.location.reload();</script>";
			} else {
				error_msgall('에러발생');
				echo mysql_error();
				exit;
			}

		break;
	}
?>
