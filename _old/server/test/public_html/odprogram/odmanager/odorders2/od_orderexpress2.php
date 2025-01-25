<?

## 쿠폰재발행

	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_comAuthority.inc.php";
	
	chk_authfree();

	for($i=0;$i<count($OrderNumValue);$i++) {

		if($OrderNumValue[$i]) {
			$row = mysql_fetch_array(mysql_query("select * from odtOrder where ordernum = '".$OrderNumValue[$i]."'"));

			if(!$expressnum[$i] || array_search($OrderNumValue[$i],$OrderNum) === false) continue;



			// 쿠폰 이미지가 등록되어있는지 체크
			$row_product_tmp2 = mysql_fetch_array(mysql_query("select * from odtProduct where code = '".reset(explode("|",$row[pLog]))."'"));
			if(!$row_product_tmp2[cpDp_img]) {
				error_msgall('해당 상품의 쿠폰 이미지가 등록되어있지 않습니다. \\n\\n쿠폰이미지 등록후 다시 진행해주시기 바랍니다.','back');
				exit;
			}
			if(!$row_product_tmp2[comment3]) {
				error_msgall('해당 상품의 쿠폰사용 주의사항이 등록되어있지 않습니다. \\n\\n쿠폰사용 주의사항 등록후 다시 진행해주시기 바랍니다.','back');
				exit;
			}

			mysql_query("update odtOrder set 
										delivstatus			=	'yes',
										expressnum			= '".$expressnum[$i]."',
										expressdate			=	'".date('Y-m-d')."'
										where ordernum	= '".$OrderNumValue[$i]."'");


//			if($row[delivstatus] == "no") {

				if($row[viewDel] == "1") {
					## 문자발송
					$orderhtel1Tmp			= $row[rechtel1];
					$orderhtel2Tmp			= $row[rechtel2];
					$orderhtel3Tmp			= $row[rechtel3];

					$row[orderemail]=	$row[recemail];
				} else {
					## 문자발송
					$orderhtel1Tmp			= $row[orderhtel1];
					$orderhtel2Tmp			= $row[orderhtel2];
					$orderhtel3Tmp			= $row[orderhtel3];

					$row[orderemail]=	$row[orderemail];
				}

				$expressnumTmp	= $expressnum[$i];

				$ordernum = $OrderNumValue[$i];
				include "od_sms_delivery.inc.php";

				## 메일발송
				$mail_row = $row;
				if($row[orderemail]) include "od_SendEmail_02.inc.php"; 

//			}

		
		}
	}

	mysql_query("delete from odtExpressTmpTable where partnerCode = '".$com[id]."'");
?>
<script>
parent.location.reload();
</script>