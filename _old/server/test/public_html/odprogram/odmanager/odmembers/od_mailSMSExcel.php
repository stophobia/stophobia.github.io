<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";

	$toDay = date("YmdHis");
	$fileName = "feedList";

	## Exel 파일로 변환 #############################################
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$fileName-$toDay.csv");
	
	##############################################################
	unset($where_);
	if($_GET[word]) {
		$where_ = "and (ft_email like '%".$_GET[word]."%' or ft_sms like '%".$_GET[word]."%') ";
	}
	$que = "select * from feedTable where (ft_email != '' or ft_sms != '') ".$where_." group by ft_email, ft_sms order by ft_regidate desc";
	$res = mysql_query($que);
	$num = mysql_num_rows($res);
	echo iconv("utf-8","euckr","번호,메일주소,휴대폰번호,신청시간
	");
	
	while($row = mysql_fetch_array($res)) {

			$row[ft_email]	= str_replace(",",".",$row[ft_email]);
			$row[ft_sms]		= str_replace(",",".",$row[ft_sms]);

			echo iconv("utf-8","euckr","$num,$row[ft_email],$row[ft_sms],$row[ft_regidate]
			");
			$num--;
		
	}
?>