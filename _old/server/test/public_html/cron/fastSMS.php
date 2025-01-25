<?PHP

	// 필요한 설정파일 불러오기
	include dirname(__FILE__)."/../odprogram/odcommon/od_config.inc.php";
	include dirname(__FILE__)."/../odprogram/odcommon/od_lib.inc.php";
	include dirname(__FILE__)."/../odprogram/odcommon/od_function.inc.php";	


	//토 일은 금요일날과 같은 상품이므로 알림 차단
	if(ereg("0|6",date('w'))) {
		exit;
	}


	$quecate = "select catecode from odtCategory where cHidden='no' ";
	$rescate = mysql_query($quecate);
	while($rowcate = mysql_fetch_array($rescate)) {

		$thiscafe = $rowcate[catecode];

		$que = "select * from odtProduct where code = '".info_nowsale($thiscafe)."' and code = parent_code";
		$res = mysql_query($que);
		$row_product = mysql_fetch_array($res);


		// 문자 내용이 있고 setup_subscribe가 4 or 6이면 적용 --- 
		if($row_product[message] && in_array( $row_product[setup_subscribe] , array( 4,6 ) )) {

			$tel = explode("-",$row_company[tel]);

			$fromHP = ($tel[count($tel)-3]) ? $tel[count($tel)-3]:"";

			if($fromHP)	$fromHP .= "-".$tel[count($tel)-2]."-".$tel[count($tel)-1];
			else	$fromHP = $tel[count($tel)-2]."-".$tel[count($tel)-1];

			## 구독 유저 sms리스트 ######################
			$result = mysql_query("SELECT ft_sms FROM feedTable WHERE ft_sms !='' group by ft_sms");
			while($row = mysql_fetch_array($result)) {
				mysql_query("insert into em_tran set tran_phone = '".$row[ft_sms]."', tran_callback = '".$fromHP."', tran_msg= '".$row_product[message]."', tran_status = 1, tran_date = now()");
			}
		}
	}

/*
create table sendSMS (
ss_idx int auto_increment primary key,
ss_code varchar(100) not null default '',
ss_id varchar(100) not null default '',
ss_name varchar(100) not null default '',
ss_to varchar(100) not null default '',
ss_from varchar(100) not null default '',
ss_text varchar(255) not null default '',
ss_regidate datetime not null);
*/

?>
