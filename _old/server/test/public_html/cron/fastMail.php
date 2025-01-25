<?PHP

	include dirname(__FILE__)."/../odprogram/odcommon/od_config.inc.php";
	include dirname(__FILE__)."/../odprogram/odcommon/od_lib.inc.php";
	include dirname(__FILE__)."/../odprogram/odcommon/od_function.inc.php";	


	//토 일은 금요일날과 같은 상품이므로 알림 차단
	if(ereg("0|6",date('w'))) {
		exit;
	}


	$mailheaders = "From: [$row_company[name]]<$row_company[email]> \n"; 
	$mailheaders .= "Content-Type: text/html; charset=euc-kr";



	$quecate = "select catecode from odtCategory where cHidden='no' ";
	$rescate = mysql_query($quecate);
	while($rowcate = mysql_fetch_array($rescate)) {


		$que = "select * from odtProduct where code = '".info_nowsale($thiscafe)."' and code = parent_code";
		$res = mysql_query($que);
		$row_product = mysql_fetch_array($res);



		// 메일링 이미지 있고 setup_subscribe가 2 or 6이면 적용 --- 
		if($row_product[mailing_img] && in_array( $row_product[setup_subscribe] , array( 2,6 ) )) {

			$subject = "[".$row_company[name]."] ".($row_product[mainName] ? $row_product[mainName] : $row_product[name]);
			$comment = htmlspecialchars_decode($row_product[mailing_img]);


			## 메일링 리스트 ######################
			$result = mysql_query("SELECT ft_email, ft_sms, ft_regidate FROM feedTable WHERE ft_email !='' group by ft_email");

			$maildate = time();

			$numT = 0;
			$numY = 0;


			$grpCnt = 50;	// 한번에 보낼 메일 갯수
			$code = time().$i;
			###########################
			## 메일 내용을 저장
			###########################
			mysql_query("insert into odtMailContent set `code` ='".$code."', `subject` = '".addslashes($subject)."', `body` ='".addslashes($comment)."', header='".$mailheaders."'");

			###################################
			## 메일 보낼 유저들을 저장
			###################################
			//오픈 시 주석제거
			unset($ft_email,$name);
			while($row = mysql_fetch_array($result)) {
				if(++$idx % $grpCnt == 0) {
					mysql_query("insert into odtMailLog set email = '".@implode(",",$ft_email)."', name = '".@implode(",",$name)."', code ='".$code."'");
					unset($ft_email,$name);
				}
				$ft_email[] = trim(str_replace(",","",$row[ft_email]));
				$name[] = "구독메일링";
			}

			mysql_query("insert into odtMailLog set email = '".@implode(",",$ft_email)."', name = '".@implode(",",$name)."', code ='".$code."'");

		}
	}
?>
