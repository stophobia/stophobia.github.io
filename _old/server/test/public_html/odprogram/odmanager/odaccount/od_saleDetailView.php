<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";

	## 세부권한 체크
	if($row_admin[memberLevel] < 3) {
		error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
	}


	$sDate = $_GET[sDate] ? $_GET[sDate] : date('Y-m-d');
	$eDate = $_GET[eDate] ? $_GET[eDate] : date('Y-m-d');


		
?>

		<iframe name="tmpFrame" src="about:blank" style="display:none"></iframe>
		<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
			<tr> 
				<td height="80" bgcolor="#FFFFFF">
					<!-- top menu start -->
<? include "$folderpath_manager_common/od_topMenu.inc.php"; ?>
					<!-- top menu end -->
				</td>
			</tr>
			<tr> 
				<td valign="top"> 
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="6"></td>
						</tr>
					</table>
					<table height="100%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="165" height="100%" valign="top"> 
								<!-- left menu start -->
<? include "$folderpath_manager_common/od_leftMenu.inc.php"; ?>
								<!-- left menu end -->
							</td>
							<td width="3">&nbsp;</td>
							<td width="782" valign="top">
								<table width="782" height="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="D6D6D6">
									<tr> 
										<td align="center" valign="top" bgcolor="#FFFFFF"> 
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 정산관리 &gt; <span class="st">매출상세현황</span></font></td>
												</tr>
												<tr> 
													<td height="2" bgcolor="D6D6D6"></td>
												</tr>
												<tr>
													<td height=5></td>
												</tr>	
												<tr>
													<td>

											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="7" bgcolor="FFFFFF"></td>
												</tr>
												<tr> 
													<td height="2" bgcolor="D2D2D2"></td>
												</tr>
											</table>
										<table width="760" border="0" cellspacing="1" cellpadding="0">
												<tr>
													<td height="7"></td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="18"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5"> 매출금액뿐 아니라 발생된 수수료, 업체 정산 금액, 순수 마진등을 상품별/기간별로 볼수있는 기능입니다. </font></td>
												</tr>
												<tr> 
													<td height="18"> <font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5"> 초기 사용시 카드 및 실시간 계좌이체 수수료를 설정이 필요합니다.</font></td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="7" bgcolor="FFFFFF"></td>
												</tr>
												<tr> 
													<td height="2" bgcolor="D2D2D2"></td>
												</tr>
											</table>			
										<table width="760" border="0" cellspacing="1" cellpadding="0">
												<tr>
													<td height="7"></td>
												</tr>
											</table>											
													<!-- ID, 이름검색 -->
														<table width="782" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td colspan="3"><img src="../odimages/odmain/search_piece1.gif" width="782" height="8"></td>
															</tr>
															<tr> 
																<td width="6" background="../odimages/odmain/search_bg1.gif">&nbsp;</td>
																<td width="770" align="center" style="padding:10px;">
																	<!-- search form start -->
																	<table width="100%" border="0" cellspacing="1" cellpadding="0">
																		<form name="view" method="get" action="<?=$_SERVER[PHP_SELF]?>">
																			<input type="hidden" name="search_value_" value="true">
																			<!--
																			<input type="hidden" name="search" value="">
																			<input type="hidden" name="key" value="">
																			-->
																		<tr> 
																			<td height="25" colspan="2">
																			<font color="DD896B"><b>*</b> 검색조건을 선택하신 후 검색 버튼을 클릭해 주시기 바랍니다.</font>
																			</td>
																		</tr>
																		<tr> 
																			<td>
																				<table border="0" cellspacing="5" cellpadding="0">
																					<tr> 
																						<td style="padding-right:20px"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">기간&nbsp;&nbsp;
																							<input type="text" size=10 name="sDate" readonly id='calInp1' value="<?=$sDate?>" style="cursor:hand" class="border">
																							<script type="text/javascript">
																							var cal4 = new jsCalendar(document.getElementById('calInp1'));
																							</script>
																							~
																							<input type="text" size=10 name="eDate" readonly id='calInp2' value="<?=$eDate?>" style="cursor:hand" class="border">
																							(결제일 기준)
																							<script type="text/javascript">
																							var cal5 = new jsCalendar(document.getElementById('calInp2'));
																							</script>
																							&nbsp;
																							<img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">분류&nbsp;
																							<select name="cate"> 
																								<option value="">전체</option>

<?
	$cateTmp = mysql_query("select * from odtCategory where catecode > '06'");
	while($cateRow = mysql_fetch_array($cateTmp)) {
		$cRowTmp[catename][$cateRow[catecode]*1] = $cateRow[catename];
?>
																								<option value="<?=$cateRow[catecode]?>" <?=$_GET[cate] == $cateRow[catecode] ? "selected" : NULL;?>><?=$cateRow[catename]?></option>
<?
	}
?>
																								
																							</select>

<script>
function changeSelectBar(obj) {
	if(obj.value == "input") {
		document.getElementById("payTitleID").style.display='';
		document.getElementById("payTitle2ID").style.display='none';
	} else if(obj.value == "output") {
		document.getElementById("payTitle2ID").style.display='';
		document.getElementById("payTitleID").style.display='none';
	}
}
</script>

																							</td>

<!--
																						<td><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">출력&nbsp;&nbsp;
																							<select name="newListCnt">
																							<option value="20"		<?=$newListCnt == 20		|| !$newListCnt ? "selected" : NULL;?>>20개</option>
																							<option value="50"		<?=$newListCnt == 50		|| !$newListCnt ? "selected" : NULL;?>>50개</option>
																							<option value="100"		<?=$newListCnt == 100		|| !$newListCnt ? "selected" : NULL;?>>100개</option>
																							<option value="9999"	<?=$newListCnt == 9999	|| !$newListCnt ? "selected" : NULL;?>>전체</option>
																							</select>
																						</td>
-->
																					</tr>
																				</table>
																			</td>
																			<td align="right"><input type="image" src="../odimages/odmain/search_btn.gif" width="68" height="64" onfocus='this.blur();'></td>
																		</tr>
																		</form>
																	</table>
																	<!-- search form end -->
																</td>
																<td width="6" background="../odimages/odmain/search_bg2.gif">&nbsp;</td>
															</tr>
															<tr> 
																<td colspan="3"><img src="../odimages/odmain/search_piece2.gif" width="782" height="8"></td>
															</tr>
														</table>
													<!-- // -->
													</td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="1" cellpadding="0">
												<tr>
													<td height="7"></td>
												</tr>
											</table>
											<table width="782" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="7" bgcolor="FFFFFF"></td>
												</tr>
												<tr> 
													<td height="2" bgcolor="D2D2D2"></td>
												</tr>
											</table>
											<table width="782" border="0" cellspacing="1" cellpadding="0">
												<tr>
													<td height="7"></td>
												</tr>
											</table>
											<table width="782" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td valign="top">
														<table width="782" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td><img src="../odimages/odmain/page_icon.gif" width="14" height="11"> 
																	<font color="3960AC">전체 <b><?=$total?></b>건 </td>
																<td align="right">
																
																	<a onclick="tmpFrame.location.href=('od_excel.php?sDate=<?=$sDate?>&eDate=<?=$eDate?>');" style='cursor:hand;' onfocus='this.blur();'><img src="../odimages/odmain/btn_excel.gif" width="77" height="24" border="0"></a> </td>
															</tr>
														</table>
														<table width="782" border="0" cellspacing="1" cellpadding="0" bgcolor="c0bebe">
															<tr align="center"> 
																<td width="70"  height=30 bgcolor="ececec" class="white">분류</td>
																<td width="70" bgcolor="ececec" class="white">판매일</td>
																<td bgcolor="ececec" class="white">상품명</td>
																<td width="70" bgcolor="ececec" class="white">판매수량</td>
																<td width="70" bgcolor="ececec" class="white">판매가</td>
																<td width="70" bgcolor="ececec" class="white">수수료</td>
																<td width="70" bgcolor="ececec" class="white">입점업체<br>총결제비</td>
																<td width="70" bgcolor="ececec" class="white">마진</td>
															</tr>
<?
## 전체 주문현황
$que = "select * from odtOrder where paydate >= '".$sDate." 00:00:00' and paydate <= '".$eDate." 23:59:59' and paystatus='Y' and canceled='N' ".$where_." order by orderdate asc";

$res = mysql_query($que);
$total = mysql_num_rows($res);
if(!$total) {
	echo	"<tr><td colspan=10 align=center height=30 bgcolor=ffffff>검색결과가 없습니다.</td></tr>";
}

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
	$row_product =	mysql_fetch_array(mysql_query("select * from odtProduct where code = '".$parent_code."'"));

	## 분류별 필터
	if($_GET[cate] && ($row_product[cateCode] != $_GET[cate])) continue;

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
	if($row_product[comSaleType] == "공급가") {

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
				if($oTmp2[0] == $tmp2[0] && $i == ($y - 1) ) {
					$purPriceTmp += $oArray[$oTmp2[1]];
				}
			}

			$sumPurPrice	+= $purPriceTmp * $tmp2[1];

		}

		$comPrice = $sumPurPrice + $row_product[del_price_com];

	}
	if($row_product[comSaleType] == "수수료") {

		$sumPrice=0;
		$tmp = explode("^",$row[pLog]);
		for($i=0;$i<count($tmp);$i++) {
			$tmp2					= explode("|",$tmp[$i]);
			$price1 = mysql_result(mysql_query("select price from odtProduct where code ='".$tmp2[0]."'"),0);

			$oTmp = explode("^",$row[oLog]);
			for($y=0;$y<count($oTmp);$y++) {
				$oTmp2 = explode("|",$oTmp[$y]);
				if($oTmp2[0] == $tmp2[0] && $i == ($y - 1) ) {
					$price1 += $oTmp2[2];
				}
			}

			$sumPrice	+= $price1 * $tmp2[1];
		}
		
		
		$comPrice = ($sumPrice - $sumPrice*$row_product[commission]/100) + $row_product[del_price_com];

	}
	###############################

	##### 마진
	$majin	=	$row[tPrice] - $commission - $comPrice;
	###############################

	$resParentCode[$row_product[cateCode]*1][]		= $parent_code;						//부모코드
	$resSaleDate[$row_product[cateCode]*1][]			= $row_product[cateCode] != "06" ? $row_product[sale_date] : "-";			//판매일
	$resMainName[$row_product[cateCode]*1][]			=	$row_product[mainName] ? $row_product[mainName] : $row_product[name];				//상품명
	$resSaleCnt[$row_product[cateCode]*1][]				=	$cntTmp;								//판매수량
	$rescommission[$row_product[cateCode]*1][]		=	$commission;						//수수료
	$resComPrice[$row_product[cateCode]*1][]			=	$comPrice;							//입점업체결제
	$resMajin[$row_product[cateCode]*1][]					=	$majin;									//마진
	$resPrice[$row_product[cateCode]*1][]					=	$row[tPrice];						//판매가
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

?>
															<tr>
																<td  align='center' bgcolor='FAFAFA' class='cate' height=30><?=$cRowTmp[catename][$pp[$codeList[$i]][cateCode]]?></td>
																<td  align='center' bgcolor='FAFAFA' class='cate' ><?=($pp[$codeList[$i]][saleDate])?></td>
																<td  align='center' bgcolor='FAFAFA' class='cate' ><?=($pp[$codeList[$i]][mainName])?></td>
																<td  align='center' bgcolor='FAFAFA' class='cate' ><?=number_format($pp[$codeList[$i]][saleCnt])?></td>
																<td  align='right' bgcolor='FAFAFA' class='cate' style="padding-right:4px"><?=number_format($pp[$codeList[$i]][price])?></td>
																<td  align='right' bgcolor='FAFAFA' class='cate' style="padding-right:4px"><?=number_format(floor($pp[$codeList[$i]][commission]))?></td>
																<td  align='right' bgcolor='FAFAFA' class='cate' style="padding-right:4px"><?=number_format($pp[$codeList[$i]][comPrice])?></td>
																<td  align='right' bgcolor='FAFAFA' class='cate' style="padding-right:4px"><?=number_format(ceil($pp[$codeList[$i]][majin]))?></td>
															</tr>

<?
	$totalSaleCnt				+= $pp[$codeList[$i]][saleCnt];
	$totalPrice					+= $pp[$codeList[$i]][price];
	$totalCommission		+= $pp[$codeList[$i]][commission];
	$totalComPrice			+= $pp[$codeList[$i]][comPrice];
	$totalMajin					+= $pp[$codeList[$i]][majin];
	}
?>
															<tr>
																<td  align='center' bgcolor='fff4dc' class='cate' height=30>합계</td>
																<td  align='center' bgcolor='fff4dc' class='cate' >-</td>
																<td  align='center' bgcolor='fff4dc' class='cate' >-</td>
																<td  align='center' bgcolor='fff4dc' class='cate' ><?=number_format($totalSaleCnt)?></td>
																<td  align='right' bgcolor='fff4dc' class='cate' style="padding-right:4px"><?=number_format($totalPrice)?></td>
																<td  align='right' bgcolor='fff4dc' class='cate' style="padding-right:4px"><?=number_format($totalCommission)?></td>
																<td  align='right' bgcolor='fff4dc' class='cate' style="padding-right:4px"><?=number_format($totalComPrice)?></td>
																<td  align='right' bgcolor='fff4dc' class='cate' style="padding-right:4px"><?=number_format($totalMajin)?></td>
															</tr>

														</table>
														<table width="760" border="0" cellspacing="1" cellpadding="0">
															<tr> 
																<td height="30">&nbsp;</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td height="5" bgcolor="#FFFFFF"></td>
									</tr>
								</table>
								<!-- main table end -->
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td height="83">
					<!-- bottom start -->
<? include "$folderpath_manager_common/od_bottom.inc.php"; ?>
					<!-- bottom end -->
				</td>
			</tr>
		</table>
	</body>
</html>