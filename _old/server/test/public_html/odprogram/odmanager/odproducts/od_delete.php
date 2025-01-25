<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";

	## 접근권한 설정(대분류등록)
	if($row_admin[productLevel] == 7 || $row_admin[productLevel] == 9 || $row_admin[superLevel]==9) {
	}
	else {
		error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
	}

	// 체험판 사용제한
	chk_authfree();

	if(!strcmp($Form,"productDelete")) {
		$proCodeDivision = explode("/",$proCode);
		$proCodeTotal = count($proCodeDivision)-1;
		
		for($i=0;$i<$proCodeTotal;$i++) {
			if($proCodeDivision[$i]){
				$prow = mysql_fetch_array(mysql_query("SELECT cateCode, customerCode FROM odtProduct WHERE code='$proCodeDivision[$i]'"));

				if($prow[customerCode] == "onedaynet" && $prow[cateCode] == "01") {
					error_msgall('원데이넷 상품서포트로 등록된 상품은 \n좌측메뉴 > 상품서포트 > 상품관리 에서 삭제가 가능합니다.');
					continue;
				}

				## 이미지 삭제
				if(file_exists("$folderpath_upload_root/odproducts/${proCodeDivision[$i]}pn.jpg"))
					unlink("$folderpath_upload_root/odproducts/${proCodeDivision[$i]}pn.jpg");
				if(file_exists("$folderpath_upload_root/odproducts/${proCodeDivision[$i]}dt1.jpg"))
					unlink("$folderpath_upload_root/odproducts/${proCodeDivision[$i]}dt1.jpg");
				if(file_exists("$folderpath_upload_root/odproducts/${proCodeDivision[$i]}dt2.jpg"))
					unlink("$folderpath_upload_root/odproducts/${proCodeDivision[$i]}dt2.jpg");
				if(file_exists("$folderpath_upload_root/odproducts/${proCodeDivision[$i]}dt3.jpg"))
					unlink("$folderpath_upload_root/odproducts/${proCodeDivision[$i]}dt3.jpg");
				if(file_exists("$folderpath_upload_root/odproducts/${proCodeDivision[$i]}s.jpg"))
					unlink("$folderpath_upload_root/odproducts/${proCodeDivision[$i]}s.jpg");
				if(file_exists("$folderpath_upload_root/odproducts/${proCodeDivision[$i]}m1.jpg"))
					unlink("$folderpath_upload_root/odproducts/${proCodeDivision[$i]}m1.jpg");
				if(file_exists("$folderpath_upload_root/odproducts/${proCodeDivision[$i]}b1.jpg"))
					unlink("$folderpath_upload_root/odproducts/${proCodeDivision[$i]}b1.jpg");
				if(file_exists("$folderpath_upload_root/odproducts/${proCodeDivision[$i]}m2.jpg"))
					unlink("$folderpath_upload_root/odproducts/${proCodeDivision[$i]}m2.jpg");
				if(file_exists("$folderpath_upload_root/odproducts/${proCodeDivision[$i]}b2.jpg"))
					unlink("$folderpath_upload_root/odproducts/${proCodeDivision[$i]}b2.jpg");
				if(file_exists("$folderpath_upload_root/odproducts/${proCodeDivision[$i]}m3.jpg"))
					unlink("$folderpath_upload_root/odproducts/${proCodeDivision[$i]}m3.jpg");
				if(file_exists("$folderpath_upload_root/odproducts/${proCodeDivision[$i]}b3.jpg"))
					unlink("$folderpath_upload_root/odproducts/${proCodeDivision[$i]}b3.jpg");
				
				for($d_num=1;$d_num<=11;$d_num++) {
					if(file_exists("$folderpath_upload_root/odproducts/${proCodeDivision[$i]}e${d_num}.jpg"))
						unlink("$folderpath_upload_root/odproducts/${proCodeDivision[$i]}e${d_num}.jpg");
				}
				
				// 주문된 상품은 삭제할수 없음.
				$isOrder = mysql_result(mysql_query("select count(*) from odtOrder where pLog like '%".$proCodeDivision[$i]."%'"),0);

				if($isOrder) {
					error_msgall('주문이 이루어진 상품은 삭제할수 없습니다.');
					continue;
				}

				## 상품정보 삭제
				mysql_query("DELETE FROM odtProduct WHERE code='$proCodeDivision[$i]'");
				
				// 해당상품의 문의글 및 댓글 삭제
				if($proCodeDivision[$i] AND strlen($proCodeDivision[$i]) > 2) {
					$bdrow = mysql_fetch_array(mysql_query("SELECT familyid FROM odtBoard WHERE procode='$proCodeDivision[$i]'"));
					
					mysql_query("DELETE FROM odtBoardNotice WHERE boardserialnum='$bdrow[familyid]'");
					mysql_query("DELETE FROM odtBoard WHERE procode='$proCodeDivision[$i]' AND procode<>''");
				}

				## 관심상품 삭제
				mysql_query("DELETE FROM odtInterestProd WHERE procode='$proCodeDivision[$i]'");
			}
		}

		include "od_parpage.inc.php";
		
		echo "
			<script name=javascript>
				window.alert('삭제가 잘 되었습니다.   ');
			</script>";

		echo "<meta http-equiv='Refresh' content='0; URL=od_list.php?page=$page$par_page'>";
		exit;
	}
	else {
		for ($i=0;$i<sizeof($code);$i++) { 
			$deleteProcode .= $code[$i]."/"; 
		}
		
		echo "
			<script language=\"javascript\">
				if(confirm(\"선택하신 상품을 정말로 삭제 하시겠습니까?   \"))
					self.location.replace('?Form=productDelete&proCode=$deleteProcode&page=$page$par_page')
				else
					self.location.replace('od_list.php?page=$page$par_page')
			</script>";

		exit;
	}
?>