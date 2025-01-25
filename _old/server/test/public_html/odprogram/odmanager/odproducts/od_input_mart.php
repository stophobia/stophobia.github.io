<?
	include "../../odcommon/od_config.inc.php";
	include "../../odcommon/od_lib.inc.php";
	include "../odcommon/od_function.inc.php";	
	include "../odcommon/od_adminAuthority.inc.php";
	include "../odcommon/od_head.inc.php";
	include "../odcommon/od_body.inc.php";

	## 접근권한 설정(대분류등록)
	if($row_admin[productLevel] == 5 || $row_admin[productLevel] == 9 || $row_admin[superLevel]==9) {
	}
	else {
		error_msgloc("../","접근권한이 없습니다.   ");
	}
	
	if(!$_GET[code]) {
		
		## 코드 생성.
		$random = rand(10000,99999);
		$sumTme = (time(Y)+time(m)+time(d)+time(H)+time(i)+time(s)+19)*997;
		$sumTempLength = strlen($sumTme);
		$checkSum = substr($sumTme,$sumTempLength-2,2);
		$code = "S".$checkSum.$random;
		
		## 등록양식 설정환경
		$brow = mysql_fetch_array(mysql_query("SELECT * FROM odtFormat WHERE serialnum=1"));

	} else {

		$que = "select * from odtProduct where code = '".$_GET[code]."'";
		$res = mysql_query($que);
		$row = mysql_fetch_array($res);

	}


	$cateCode = $row[cateCode] ? $row[cateCode] : $cateCode;
	if($row[sale_date]) $sale_date = $row[sale_date];
	else if($calDate) $sale_date = $calDate;
	else $sale_date = date('Y-m-d');

?>

		<script language="javascript">
			function valueCheck(form) {

//				d=myEditor.document.body.createTextRange();
//				form.description2.value=d.htmlText;

				if(!form.code.value) {
					alert("상품코드를 입력하셔야 합니다.   ");
					form.code.focus();
					return false;
				}
				if(!form.name.value) {
					alert("상품이름을 입력하셔야 합니다.   ");
					form.name.focus();
					return false;
				}
				if(!form.customerCode.value) {
					alert("공급업체를 입력하셔야 합니다.   ");
					customerWin();
					return false;
				}


			}

			function snsWindow(name,url,width,height,scrollbar,resizable,status) {
				window.open(url,name,'width='+width+',height='+height+',scrollbars='+scrollbar+',resizable='+resizable+',status='+status);
			}
			function valueMouseDown(fieldTemp,type) {
				if(!fieldTemp.value && type) fieldTemp.value = fieldTemp.defaultValue;
			}
			function valueMouseOver(fieldTemp,type) {
				if(fieldTemp.value == fieldTemp.defaultValue && type) fieldTemp.value = '';
			}
			function valueMouseNone(fieldTemp,type) {
				if(!fieldTemp.value && type) fieldTemp.value = fieldTemp.defaultValue = '';
			}
			function delField(objTemp) {
				objTemp.value='';
			}
			function optionWin() {
				window.open('option3od_modify.php?formname=snsForm&option3='+document.snsForm.option3.value,'optionUpdate', 'width=440, height=400, scrollbars=yes');
			}
			function relationWin() {
				window.open('relation.php?formname=inputForm&relation_procode='+document.snsForm.relation.value,'relation', 'width=600, height=700, scrollbars=yes');
			}
			function customerWin() {
				  window.open('customer.php','customer','resizable=yes,scrollbars=yes,width=420,height=410'); 
			}

			// 현재 선택한 카테고리와 날짜를 체크하여 메인상품인지 서브상품인지 체크
			function mainOrSubCheck() {
				frm = document.snsForm;
				hidden_frame.location.href="./mainOrSubCheck.php?cateCode="+frm.cateCode.value+"&sale_date="+frm.sale_date.value;
			}
			function add_menu() 
			{  
				objTbl = document.getElementById("proOption"); 
				objRow = objTbl.insertRow(objTbl.rows.length); 

				// 이름
				objCell = objRow.insertCell(0); 
				objCell.innerHTML = "<input type='text' name='optionName[]' class='border' size='20'  value=''>"; 
				objCell.align			=	"center";

				// 공급가
				objCell = objRow.insertCell(1); 
				objCell.innerHTML = "<input type='text' name='optionPurPrice[]' class='border' size='10' value=''>"; 
				objCell.align			=	"center";

				// 판매가
				objCell = objRow.insertCell(2); 
				objCell.innerHTML = "<input type='text' name='optionPrice[]' class='border' size='10' value=''>"; 
				objCell.align			=	"center";
			} 
			function add_file() 
			{  
				objTbl = document.getElementById("proFile"); 
				objRow = objTbl.insertRow(objTbl.rows.length); 

				// 기술서 파일
				objCell = objRow.insertCell(0); 
				objCell.innerHTML = "&nbsp;<input type=\"file\" name=\"proFile[]\" class=\"border\" size=\"40\">"; 

			} 

		function saleType(frm) {
			if(frm.comSaleType[0].checked == true) {
				document.getElementById('comSaleTypeTr1').style.display='';
				document.getElementById('comSaleTypeTr2').style.display='none';
			} else {
				document.getElementById('comSaleTypeTr2').style.display='';
				document.getElementById('comSaleTypeTr1').style.display='none';
			}
		}
		function epLengthCheck(obj) {

			var len = 0; 
			  
			for (var i=0; i<obj.value.length; i++) {
				if ( obj.value.substr(i, 1) > '~' ) {
					len+=2;
				} 
				else {
					len++;
				}
			}

			document.getElementById('epHTML').innerHTML = "<font color=green>"+len+"자</font>";

		}
		function limitCheck(obj,price) {
			if(Number(obj.value) < Number(price)) {
				alert(price+'원 이하로 판매하실수 없는 상품입니다.');
				obj.value = price;
			}
		}


		</script>

		<!-- 도움말 관련 스크립트 -->
<? include "help.php"; ?>
		<!-- 도움말 관련 스크립트 -->


		<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="FFFFFF">
			<tr> 
				<td height="80" bgcolor="#FFFFFF">
					<!-- top menu start -->
<? include "../odcommon/od_topMenu.inc.php"; ?>
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
<? include "../odcommon/od_leftMenu.inc.php"; ?>
								<!-- left menu end -->
							</td>
							<td width="3">&nbsp;</td>
							<td width="782" valign="top">
								<!-- main table start -->
								<table width="782" height="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="D6D6D6">
									<tr> 
										<td align="center" valign="top" bgcolor="#FFFFFF">
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 상품관리 &gt; <span class="st">상품 등록 및 수정</span></font></td>
												</tr>
												<tr> 
													<td height="2" bgcolor="D6D6D6"></td>
												</tr>
											</table>


											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="3"></td>
												</tr>
											</table>

											<iframe name="hidden_frame" src="about:blank" width=300 height=300 style="display:none;" frameborder=0></iframe>
											<table width="760" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td width="760" valign="top">
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<!-- form start ---------------------------------------------->
															<form name="snsForm" method="post" action="od_inputPro.php" enctype="multipart/form-data" target="hidden_frame" onSubmit="return valueCheck(this)">
																<input type="hidden" name="subMode" value="<?=$_GET[code] ? "edt" : "ins";?>">
																<input type="hidden" name="parent_code" value="<?=$row[parent_code] ? $row[parent_code] : $code;?>">
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">담당 MD</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<select name="md_name" class="border">
<?
$mdQue = "select * from odtMD order by mdNo ASC";
$mdRes = mysql_query($mdQue);
while($mdRow = mysql_fetch_array($mdRes)) {
?>
																	<option value="<?=$mdRow[mdName]?>" <?=$mdRow[mdName] == $row[md_name] ? "selected" : NULL;?>><?=$mdRow[mdName]?></option>
<?
}
?>
																	</select>																	
																</td>
															</tr>
															
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="6" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>															
															<tr> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">상품분류</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
																&nbsp;<input type="hidden" name="cateCode" value="06">MART
																</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="6" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>


															<tr style="display:none"> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">상품코드</td>
																<!-- 에디터관련수정 시작 -->
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="code" class="proName" size="75" value="<?=$row[code] ? $row[code] : $code;?>" onkeyup="chk_code(snsForm)">
																</td>
																<!-- 에디터관련수정 끝 -->
															</tr>
															<tr style="display:none"> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr style="display:none"> 
																<td height="6" bgcolor="FFFFFF"></td>
															</tr>
															<tr style="display:none"> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">상품이름</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="name" class="border" size="75" value="<?=$row[name]?>"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="6" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">상품 공급업체</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
<?
if($row[customerCode] == "onedaynet") {
?>
																	&nbsp;<?=$row[customerCode]?><input type="hidden" name="customerCode" class="border" size="35" value="<?=$row[customerCode]?>" readonly><br>
<?
} else {
?>
																	&nbsp;<input type="text" name="customerCode" class="border" size="35" value="<?=$row[customerCode]?>" readonly>
																	<a href="javascript:customerWin();" class="cate">[공급업체조회]</a> <a href="/odprogram/odmanager/odcustomer/od_list.php" target="_blank">[공급업체등록]</a> <br>

<?
}
?>
																	<img src="" width="1" height="3"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="6" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>

															<tr> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">업체정산형태</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
<?
if($row[customerCode] == "onedaynet") {
?>
																	&nbsp;<?=$row[comSaleType]?><input type="hidden" name="comSaleType" value="공급가" onclick='saleType(this.form)' value="<?=$row[comSaleType]?>">
<?
} else {
?>
																	&nbsp;<input type="radio" name="comSaleType" value="공급가" onclick='saleType(this.form)' <?=$row[comSaleType] == "공급가" || !$row[comSaleType] ? "checked" : NULL;?>>공급가  &nbsp; 
																	&nbsp;<input type="radio" name="comSaleType" value="수수료" onclick='saleType(this.form)' <?=$row[comSaleType] == "수수료" ? "checked" : NULL;?>>수수료
<?
}
?>
																	</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="6" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>

															<tr id='comSaleTypeTr1' style='display:<?=$row[comSaleType] == "공급가" || !$row[comSaleType] ? NULL : "none";?>'> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">매입가격 (공급가격)</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
<?
if($row[customerCode] == "onedaynet") {
?>

																	&nbsp;<?=$row[purPrice]?> 원<br><input type="hidden" name="purPrice" class="border" size="10" style='text-align:right;' value="<?=$row[purPrice]?>"> 
<?
} else {
?>

																	&nbsp;<input type="text" name="purPrice" class="border" size="10" style='text-align:right;' value="<?=$row[purPrice]?>"> 원<br>

<?
}
?>
																	<img src="" width="1" height="3"></td>
															</tr>
															<tr id='comSaleTypeTr2' style='display:<?=$row[comSaleType] == "수수료" ? NULL : "none";?>'> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">수수료</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="commission" class="border" size="10" style='text-align:right;' value="<?=$row[commission] ? $row[commission] : 10;?>"> %<br>
																	<img src="" width="1" height="3"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="6" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">입점업체 배송비 </td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
<?
if($row[customerCode] == "onedaynet") {
?>

																	&nbsp;<?=number_format($row[del_price_com])?> 원<input type="hidden" name="del_price_com" class="border" size="10" style='text-align:right;' value="<?=$row[del_price_com]?>">
<?
} else {
?>

																	&nbsp;<input type="text" name="del_price_com" class="border" size="10" style='text-align:right;' value="<?=$row[del_price_com]?>"> 원

<?
}
?>
																	
																	<br><img src="" width="1" height="3"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="6" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>

															<tr> 
<?
if($row[customerCode] == "onedaynet") {
?>
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">판매가격 <?help_pop("상품이 2개 이상일때 메인에 노출되는 대표 가격이며,<br>미체크시에는 상품중 가장 낮은값이 메인에 노출됩니다.")?></td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="price" class="border" size="10" style='text-align:right;' onblur="limitCheck(this,<?=$row[mart_price_limit]?>)" value="<?=$row[price]?>"> 원
																	
																	<input type="checkbox" name="mainPrice" value="1" <?=$row[mainPrice] == "1" ? "checked" : NULL;?>>메인가격으로 지정 
																	<br>
																	&nbsp; 이상품은 <?=number_format($row[mart_price_limit])?>원 미만으로는 판매하실수 없습니다.
																	
																	
																	</td>
<?
} else {
?>
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">판매가격 <?help_pop("상품이 2개 이상일때 메인에 노출되는 대표 가격이며,<br>미체크시에는 상품중 가장 낮은값이 메인에 노출됩니다.")?></td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="price" class="border" size="10" style='text-align:right;' value="<?=$row[price]?>"> 원
																	
																	<br>
																	<input type="checkbox" name="mainPrice" value="1" <?=$row[mainPrice] == "1" ? "checked" : NULL;?>>메인가격으로 지정 
																	</td>

<?
}
?>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="6" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">쇼핑몰 배송비 <?help_pop("0을 입력하시면 메인에 무료배송 아이콘(<img src='/img/icon_01.jpg' align=absmiddle>)이 노출됩니다.")?></td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 

																	&nbsp;<input type="text" class="border" name="del_price" size=10 style="text-align:right" value="<?=$row[del_price]?>"> 원 </td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="6" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">무료배송가</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 

																	&nbsp;<input type="text" class="border" name="del_limit" size=10 style="text-align:right" value="<?=isset($row[del_limit]) ? $row[del_limit] : "50000";?>"> 원 이상 무료배송 &nbsp; &nbsp; <font color=red>0일 경우 무조건 배송비 부과</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="6" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr > 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">옵션설정 <?help_pop("상품에 색깔이나, 사이즈등 옵션이 있을때 사용하세요.<br>옵션마다 공급가와 판매가를 지정할수 있으며, 기존 공급가 및 판매가에 추가금액을 입력하셔야 합니다.")?> <font size=3 style="cursor:pointer" onclick="add_menu()">+</font><br>
																
																</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"><table border=0 cellpadding=0 cellspacing=0 width=310 id="proOption" >
																		<tr>
																			<td align=center>옵션이름</td>
																			<td align=center>공급가(추가)</td>
																			<td align=center>판매가(추가)</td>
																		</tr>
<?
$optionNameArray			= explode("|",$row[optionName]);
$optionPurPriceArray	= explode("|",$row[optionPurPrice]);
$optionPriceArray			= explode("|",$row[optionPrice]);

for($oo=0;$oo < count($optionNameArray) ; $oo++) {
?>
																		<tr>
																			<td align=center><input type="text" name="optionName[]" class="border" size="20"  value="<?=$optionNameArray[$oo]?>"></td>
																			<td align=center><input type="text" name="optionPurPrice[]" class="border" size="10" value="<?=$optionPurPriceArray[$oo]?>"></td>
																			<td align=center><input type="text" name="optionPrice[]" class="border" size="10" value="<?=$optionPriceArray[$oo]?>"></td>
																		</tr>
<?
}
?>
																	</table>
																</td>
															</tr>
															<tr > 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr > 
																<td height="6" bgcolor="FFFFFF"></td>
															</tr>
															<tr > 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>


															<tr> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">적립금</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="point" class="border" size="3" style='text-align:right;' value="<?=isset($row[point]) ? $row[point] : "1";?>"> %<br>
																	</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="6" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>

															<tr> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">재고량</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
																	<img src="" width="1" height="3"><br>
<?
if($row[customerCode] == "onedaynet") {
?>

																	&nbsp;<input type="hidden" name="stock" class="border" value="<?=$row[stock];?>" size="10" style='text-align:right;' > <?=$row[stock];?>개
																	&nbsp;&nbsp;&nbsp;
																	구매제한 <input type="hidden" name="buy_limit" class="border" value='<?=$row[buy_limit]?>' size="3"><?=$row[buy_limit]?>개
<?
} else {
?>

																	&nbsp;<input type="text" name="stock" class="border" value="<?=isset($row[stock]) ? $row[stock] : "10000";?>" size="10" style='text-align:right;' > 개
																	&nbsp;&nbsp;&nbsp;
																	구매제한 <input type="text" name="buy_limit" class="border" value='<?=isset($row[buy_limit]) ? $row[buy_limit] : "5";?>' size="3">개

<?
}
?>
																	</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="6" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">기타설정</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
																	<img src="" width="1" height="3"><br>
																	<input type="checkbox" name="guestDisabled" value="1" <?=$row[guestDisabled] ? "checked" : NULL;?>>비회원구매불가 &nbsp;
																	<input type="checkbox" name="ipDistinct" value="1" <?=$row[ipDistinct] ? "checked" : NULL;?>>중복구매불가 &nbsp;
																	<input type="checkbox" name="bankDisabled" value="1" <?=$row[bankDisabled] ? "checked" : NULL;?>>무통장입금불가 &nbsp;
																	<input type="checkbox" name="seeDisabled" value="1" <?=$row[seeDisabled] ? "checked" : NULL;?>>상품 숨기기 &nbsp;
																	</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="6" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>



<!--
															<tr> 
																<td width="165" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">상품 옵션1</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	<table width="99%" border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td>
																				&nbsp;옵션명 : <input type="text" name="optionName1" class="border" size="15">
																				&nbsp;<font color="313D7D">* 입력예: 색상</font></td>
																			<td align="right">
																				<a href="javascript:reSize(document.snsForm.option1,5)"><img src="../odimages/button_plus.gif" border="0" align="absmiddle"></a>
																				<a href="javascript:reSize(document.snsForm.option1,'reset')"><img src="../odimages/button_reset.gif" border="0" align="absmiddle"></a>
																				<a href="javascript:reSize(document.snsForm.option1,-5)"><img src="../odimages/button_minus.gif" border="0" align="absmiddle"></a>
																				<img src="blank.gif" width="5" height="1">
																			</td>
																		</tr>
																		<tr>
																			<td height="5" colspan="2"></td>
																		</tr>
																		<tr>
																			<td colspan="2">
																				&nbsp;<textarea name="option1" class="border" rows="5" cols="95"></textarea><br>
																				<img src="" width="1" height="2"><br><font color="313D7D">
																				&nbsp;* 입력예: 검정색/보라색/카키색/주황색 (옵션값의 구분을 / 로 해주시기 바랍니다.)</font></td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="6" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
-->
															<tr> 
																<td width="165" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">상품 상세설명</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	<table width="99%" border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td colspan="2"><textarea name="comment2" class="border" rows="30" cols="94" geditor><?=stripslashes($row[comment2])?></textarea>
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>

															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="6" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td width="143" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">메인  <?help_pop("메인에 노출되는 대표 이미지 입니다.")?></td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="file" name="mart_main_img" class="border" size="40"> 215 x 215
<?
$imgName = "mart_main_img";
if($row[$imgName]) {
?>
																	<a href="<?=$row[$imgName]?>" target="_blank"><img src="<?=$row[$imgName]?>" width=50 border=0></a>
																	<input type="hidden" name="<?=$imgName?>_org" value="<?=$row[$imgName]?>">
																	<input type="checkbox" name="<?=$imgName?>_del" value="Y"> 삭제
<?
}
?>
<!-- 상품리스트 이미지 -->
																	<input type="hidden" name="prolist_img_org" value="<?=$row[prolist_img]?>">
																</td>
															</tr>


															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="6" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>


															<tr > 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">상품기술서 <font size=3 style="cursor:pointer" onclick="add_file()">+</font></td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"><table border=0 cellpadding=0 cellspacing=0 width=210 id="proFile" >

<?
$proRes = mysql_query("select * from odtProFiles where code ='".$row[code]."' order by no asc");
while($proRow = mysql_fetch_array($proRes)) {

?>
																		<tr>
																			<Td>

																				&nbsp;<input type="file" name="proFile[]" class="border" size="40">
																							<a href="./profiledown.php?no=<?=$proRow[no]?>"><?=$proRow[filename]?></a>
																							<input type="hidden" name="proFile_org[]" value="<?=$proRow[filesrc]?>">
																							<input type="hidden" name="proFileReal_org[]" value="<?=$proRow[filename]?>">
																							<input type="checkbox" name="proFile_del[]" value="Y"> 삭제
																			</td>
																		</tr>

<?
}
?>
																		<tr>
																			<Td>
																				&nbsp;<input type="file" name="proFile[]" class="border" size="40"> 
																			</td>
																		</tr>

																	</table>
																</td>
															</tr>

														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="15" bgcolor="FFFFFF"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="1" cellpadding="0">
															<tr> 
																<td align="center">
																	<input type="image" src="../odimages/odmain/btn_ok.gif" width="77" height="24" hspace="3" onfocus='this.blur();'>
																	<a onclick="reset();" onfocus='this.blur();' style='cursor:hand;'><img src="../odimages/odmain/btn_cancel.gif" width="77" height="24" hspace="3" border="0"></a>
																	<a href="od_list.php" onfocus='this.blur();'><img src="../odimages/btn_list.gif" hspace="3" border="0"></a>
																</td>
															</tr>

															</form>
														</table>
													</td>
												</tr>
												<tr> 
													<td height="15" valign="top"></td>
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
<? include "../odcommon/od_bottom.inc.php"; ?>
					<!-- bottom end -->
				</td>
			</tr>
		</table>
		<script language="Javascript" src="/odprogram/geditor/geditor.js"></script>
		
	</body>
</html>
