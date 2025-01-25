<?
	## view icon
	if($row[inputDate] <= time() AND time() <= $row[inputDate]+($row_setup[iconNew]*86400)) 
		$newTemp = " <img src='".$folderpath_upload."/odicons/new.gif' align='absmiddle' border='0'>";
	else $newTemp = "";
	
	## cool icon
	if($row_setup[iconEnum1] == "s") $iconEnum1 = "saleNum";
	else $iconEnum1 = "clickNum";
	
	if($row[$iconEnum1] >= $row_setup[iconNum1]) 
		$coolTemp = " <img src='".$folderpath_upload."/odicons/cool.gif' align='absmiddle' border='0'>";
	else $coolTemp = "";
	
	## hit icon
	if($row_setup[iconEnum2] == "s") $iconEnum2 = "saleNum";
	else $iconEnum2 = "clickNum";
	
	if($row[$iconEnum2] >= $row_setup[iconNum2]) 
		$hitTemp = " <img src='".$folderpath_upload."/odicons/hit.gif' align='absmiddle' border='0'>";
	else $hitTemp = "";
	
	## hot icon
	if($row_setup[iconEnum3] == "s") $iconEnum3 = "saleNum";
	else $iconEnum3 = "clickNum";
	
	if($row[$iconEnum3] >= $row_setup[iconNum3]) 
		$hotTemp = " <img src='".$folderpath_upload."/odicons/hot.gif' align='absmiddle' border='0'>";
	else $hotTemp = "";
	
	## 무료배송 아이콘
	if($row[exDelivery] == "yes") $exDeliveryTemp = " <img src='".$folderpath_upload."/odicons/delivery.gif' align='absmiddle' border='0'>";
	else $exDeliveryTemp = "";

	## 할인상품 아이콘
	if($row[discountChuchun] == "yes") 
		$discountChuchunTemp = " <img src='".$folderpath_upload."/odicons/discount.gif' align='absmiddle' border='0'>";
	else $discountChuchunTemp = "";

	## 베스트상품 아이콘
	if($row[bestChuchun] == "yes") $bestChuchunTemp = " <img src='".$folderpath_upload."/odicons/best.gif' align='absmiddle' border='0'>";
	else $bestChuchunTemp = "";	

	## 추천상품 아이콘
	if($row[mdChuchun] == "yes") $mdChuchunTemp = " <img src='".$folderpath_upload."/odicons/md.gif' align='absmiddle' border='0'>";
	else $mdChuchunTemp = "";
	
	## 후불제상품 아이콘
	if($row[credit] == "yes") $creditTemp = " <img src='".$folderpath_upload."/odicons/card.gif' align='absmiddle' border='0'>";
	else $creditTemp = "";
	
	## 예약상품 아이콘
	if($row[preeCheck] == "yes") $preeCheckTemp = " <img src='".$folderpath_upload."/odicons/pree.gif' align='absmiddle' border='0'>";
	else $preeCheckTemp = "";
	
	## 즉석쿠폰 아이콘
	if($row[coupon] == "yes") $couponTemp = " <img src='".$folderpath_upload."/odicons/coupon.gif' align='absmiddle' border='0'>";
	else $couponTemp = "";
	
	## 제공쿠폰 아이콘
	if($row[couponnumber]) $couponnumberTemp = " <img src='".$folderpath_upload."/odicons/pcoupon.gif' align='absmiddle' border='0'>";
	else $couponnumberTemp = "";
	
	## 일시품절 아이콘
	if($row[optionTag3] == "yes") {
		$stockTemp1 = "";
	}
	else {
		if($row[stock] == 0 AND $row[stockTag] <> "yes") 
			$stockTemp1 = " <img src='".$folderpath_upload."/odicons/none.gif' align='absmiddle' border='0'>";
		else $stockTemp1 = "";
	}
?>