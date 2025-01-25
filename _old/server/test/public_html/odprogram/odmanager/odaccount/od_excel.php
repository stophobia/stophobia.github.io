<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_comAuthority.inc.php";
	
	$toDay = date("YmdHis");
	$fileName = "saleDetail";

	## Exel 파일로 변환 #############################################
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$fileName-$toDay.csv");


	$sDate = $_GET[sDate] ? $_GET[sDate] : date('Y-m-d');
	$eDate = $_GET[eDate] ? $_GET[eDate] : date('Y-m-d');


	$cateTmp = mysql_query("select * from odtCategory where catecode > '06'");
	while($cateRow = mysql_fetch_array($cateTmp)) {
		$cRowTmp[catename][$cateRow[catecode]*1] = $cateRow[catename];
	}

	echo iconv("utf-8","euckr","분류,판매일,상품명,판매수량,판매가,수수료,입점업체총결제비,마진");

	## 전체 주문현황
	$que = "select * from odtOrder where paydate >= '".$sDate." 00:00:00' and paydate <= '".$eDate." 23:59:59' and paystatus='Y' and canceled='N' ".$where_." order by orderdate asc";
	$res = mysql_query($que);
	$total = mysql_num_rows($res);


	## 변수정의
	$resSaleDate;			//판매일
	$resMainName;			//상품명
	$resSaleCnt;			//판매수량
	$rescommission;		//수수료
	$resComPrice;			//입점업체결제
	$resPrice;				//판매가
	$resMajin;				//마진

	while($row= mysql_fetch_array($res)) {

		## 상품정보
		$parent_code	= mysql_result(mysql_query("select parent_code from odtProduct where code ='".reset(explode("|",$row[pLog]))."'"),0);
						=	mysql_fetch_array(mysql_query("select * from odtProduct where code = '".$parent_code."'"));

		## 분류별 필터
		if($_GET[cate] && ([cateCode] != $_GET[cate])) continue;

		##### 판매수량 추출
		$cntTmp=0;
		$sumPurPrice=0;
		$tmp = explode("^",$row[pLog]);
		for($i=0;$i<count($tmp);$i++) {
			$tmp2					= explode("|",$tmp[$i]);
			$cntTmp				+= $tmp2[1];
			$sumPurPrice	+= mysql_result(mysql_query("select purPrice from odtProduct where code ='".$tmp2[0]."'"),0) * $tmp2[1];
		}
		##############################

		##### 카드사수수료 추출		B:무통장, C:카드, L:실시간계좌이체, E:에스크로
		unset($commission);
		switch($row[paymethod]) {
			case "C" :
				$commission = $row[tPrice]*0.033;
				break;
			case "L" :
				$commission = $row[tPrice] <= 10700 ? 200 : $row[tPrice]*0.02;
				break;
			case "E" :
				$commission = $row[tPrice] *0.003;
				$commission = $commission < 300 ? 300 : $commission;
				break;
			case "H" :
				$commission = $row[tPrice]*0.07;
				break;
		}
		# 부가세 포함
		//$commission += $commission*0.1;

		###############################

		##### 입점업체 결제금 추출
		if([comSaleType] == "공급가") {

			$sumPurPrice=0;
			$tmp = explode("^",$row[pLog]);
			for($i=0;$i<count($tmp);$i++) {
				$tmp2					= explode("|",$tmp[$i]);
				$tmpRow				=	mysql_fetch_array(mysql_query("select purPrice,optionName,optionPurPrice from odtProduct where code ='".$tmp2[0]."'"));
				
				$purPriceTmp = $tmpRow[purPrice];
				## 옵션별 공급가 처리
				unset($oArray,$optionArray,$optionArray2);
				$optionArray = explode("|",$tmpRow[optionName]);
				$optionArray2 = explode("|",$tmpRow[optionPurPrice]);

				for($z=0;$z<count($optionArray);$z++) {
					$oArray[$optionArray[$z]] = $optionArray2[$z];

				}

				$oTmp = explode("^",$row[oLog]);
				for($y=0;$y<count($oTmp);$y++) {
					$oTmp2 = explode("|",$oTmp[$y]);
					if($oTmp2[0] == $tmp2[0]) {
						$purPriceTmp += $oArray[$oTmp2[1]];
					}
				}

				$sumPurPrice	+= $purPriceTmp * $tmp2[1];

			}

			$comPrice = $sumPurPrice + [del_price_com];

		}
		if([comSaleType] == "수수료") {

			$sumPrice=0;
			$tmp = explode("^",$row[pLog]);
			for($i=0;$i<count($tmp);$i++) {
				$tmp2					= explode("|",$tmp[$i]);
				$price1 = mysql_result(mysql_query("select price from odtProduct where code ='".$tmp2[0]."'"),0);

				$oTmp = explode("^",$row[oLog]);
				for($y=0;$y<count($oTmp);$y++) {
					$oTmp2 = explode("|",$oTmp[$y]);
					if($oTmp2[0] == $tmp2[0]) {
						$price1 += $oTmp2[2];
					}
				}

				$sumPrice	+= $price1 * $tmp2[1];
			}
			
			
			$comPrice = ($sumPrice - $sumPrice*[commission]/100) + [del_price_com];

		}
		###############################

		##### 마진
		$majin	=	$row[tPrice] - $commission - $comPrice;
		###############################

		$resParentCode[[cateCode]*1][]		= $parent_code;						//부모코드
		$resSaleDate[[cateCode]*1][]			= [cateCode] != "06" ? [sale_date] : "-";			//판매일
		$resMainName[[cateCode]*1][]			=	[mainName] ? [mainName] : [name];				//상품명
		$resSaleCnt[[cateCode]*1][]				=	$cntTmp;								//판매수량
		$rescommission[[cateCode]*1][]		=	$commission;						//수수료
		$resComPrice[[cateCode]*1][]			=	$comPrice;							//입점업체결제
		$resMajin[[cateCode]*1][]					=	$majin;									//마진
		$resPrice[[cateCode]*1][]					=	$row[tPrice];						//판매가
	}

	#######################
	## 상품별로 합산
	#######################
	for($z=1;$z<100;$z++) {
		for($i=0;$i<count($resSaleDate[$z]);$i++) {
			if(@array_search($resParentCode[$z][$i],$codeList) === false) $codeList[] = $resParentCode[$z][$i];
			$pp[$resParentCode[$z][$i]][cateCode]		= $z;
			$pp[$resParentCode[$z][$i]][saleDate]		= $resSaleDate[$z][$i];
			$pp[$resParentCode[$z][$i]][mainName]		= $resMainName[$z][$i];
			$pp[$resParentCode[$z][$i]][saleCnt]		+= $resSaleCnt[$z][$i];
			$pp[$resParentCode[$z][$i]][commission] += $rescommission[$z][$i];
			$pp[$resParentCode[$z][$i]][comPrice]		+= $resComPrice[$z][$i];
			$pp[$resParentCode[$z][$i]][majin]			+= $resMajin[$z][$i];
			$pp[$resParentCode[$z][$i]][price]			+= $resPrice[$z][$i];
		}
	}

	for($i=0;$i<count($codeList);$i++) {

			// --- 2010-10-12 - 같은 주문상품의 경우 금액 수정
			echo "
";
			echo iconv("utf-8","euckr", $cRowTmp[catename][$pp[$codeList[$i]][cateCode]].
				","
				.($pp[$codeList[$i]][saleDate]).
				","
				.($pp[$codeList[$i]][mainName]).
				","
				.$pp[$codeList[$i]][saleCnt].
				","
				.$pp[$codeList[$i]][price].
				","
				.floor($pp[$codeList[$i]][commission]).
				","
				.$pp[$codeList[$i]][comPrice].
				","
				.ceil($pp[$codeList[$i]][majin])
			);

		$totalSaleCnt				+= $pp[$codeList[$i]][saleCnt];
		$totalPrice					+= $pp[$codeList[$i]][price];
		$totalCommission		+= $pp[$codeList[$i]][commission];
		$totalComPrice			+= $pp[$codeList[$i]][comPrice];
		$totalMajin					+= $pp[$codeList[$i]][majin];
	}
	
	echo "
";
	echo iconv("utf-8","euckr","합계,-,-,".$totalSaleCnt.",".$totalPrice.",".$totalCommission.",".$totalComPrice.",".$totalMajin);	

?>