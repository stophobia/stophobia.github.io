<?PHP
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";


/*
Array
(
    [all_reg] => Array
        (
            [name] => Book1.csv
            [type] => application/vnd.ms-excel
            [tmp_name] => /home/tmp2/phpKf6Hjl
            [error] => 0
            [size] => 112
        )

)
*/

	if($_FILES[all_reg][size] > 0) {

		$app_file_name = "../../upfiles/odmail/" . time() . ".csv";
		@copy($_FILES[all_reg][tmp_name] , $app_file_name );

		$data = file_get_contents($app_file_name);
		$ex1 = array_unique(array_filter(explode("\n" , $data)));
		$app_cnt  = 0;
		foreach($ex1 as $k=>$v) {
			if(trim($v)) {
				$ex2 = explode("," , $v);
				mysql_query("insert into feedTable set ft_email = '".$ex2[0]."', ft_sms='".$ex2[1]."',ft_regidate=now()");
				$app_cnt  ++;
			}
		}

		@unlink($app_file_name);

		echo "<script>alert('${app_cnt}개의 구독정보를 입력하였습니다.');location.href=('od_mailSMSList.php');</script>";

	}



	else {
		echo "<script>alert('파일을 등록해주세요');history.back();</script>";
	}

	exit;

?>