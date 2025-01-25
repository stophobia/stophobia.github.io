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
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">판매일</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
																	<img src="blank.gif" width="1" height="1">
<?
if($row[customerCode] == "onedaynet") {
?>												
																	<?=$sale_date?>
																	<input type="hidden" name=sale_date size=10 class="border" readonly style="cursor:hand" value="<?=$sale_date?>">
																	<span id="pro_type" style="color:red;display:none">(메인상품)</span>
																	<br><span style='color:red;font-size:11px;font-family:돋움'>( 상품공급서포트로 등록된 상품은 날짜를 수정하실수 없습니다. )</span>
<?
} else {
?>
																	<input id='ipt01' type="text" name=sale_date size=10 class="border" readonly style="cursor:hand" value="<?=$sale_date?>">
																	<span id="pro_type" style="color:red">(메인상품)</span>
																	<script>var cal1 = new jsCalendar(document.getElementById('ipt01'));</script><br>
																	( WEEK상품은 월요일 날짜를 선택하세요. )
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
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">상품분류</td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
<?
if($row[customerCode] == "onedaynet") {
?>

																	<img src="blank.gif" width="1" height="1"><?=$row[cateName]?>
																	<input type="hidden" name="cateCode" value="<?=$cateCode?>">
																	<br><span style='color:red;font-size:11px;font-family:돋움'>( 상품공급서포트로 등록된 상품은 TODAY에서만 판매하실수 있습니다. )</span>

<?
} else {
?>
																	<img src="blank.gif" width="1" height="1"><select name="cateCode" class="border" onchange="mainOrSubCheck();" >
	<?
	$res3 = mysql_query("select * from odtCategory");
	while($row3 = mysql_fetch_array($res3)) {
	?>
																		<option value="<?=$row3[catecode]?>" <?=$cateCode == $row3[catecode] ? "selected" : NULL;?>><?=$row3[catename]?></option>
	<?
	}
	?>
																	</select>
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
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">대표상품명 <?help_pop("사용자페이지에 노출될 상품명으로서 텍스트와 이미지중 올릴수 있으며<br>텍스트는 10글자 내외로 작성해주시고, 이미지는 지정사이즈를 많이 벗어나지 않도록 올려주시기 바랍니다.")?></td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<b>※ 이미지가 우선적으로 등록됩니다.</b><br>
																	&nbsp;텍스트 : <input type="text" name="mainName" class="proName" size="75" value="<?=$row[mainName]?>"><br>
																	&nbsp;이미지 : <input type="file" name="mainNameImg" class="border" size="40" value="<?=$row[mainNameImg]?>"> 380 x 60 이내<br>									
<?
$imgName = "mainNameImg";
if($row[$imgName]) {
?>
																	<a href="<?=$row[$imgName]?>" target="_blank"><img src="<?=$row[$imgName]?>" border=0 style='border:1px solid #dddddd'></a>
																	<input type="hidden" name="<?=$imgName?>_org" value="<?=$row[$imgName]?>"><br>
																	<input type="checkbox" name="<?=$imgName?>_del" value="Y"> 삭제
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
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">최저가검색 링크 <?help_pop("url을 입력하면 사용자페이지에 최저가검색 아이콘(<img src='/img/icon_03.jpg' align=absmiddle>)이 노출됩니다.")?></td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;">
																	&nbsp;<input type="text" name="sLink" class="border" size="80" value="<?=$row[sLink]?>">
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
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">판매가격 <?help_pop("상품이 2개 이상일때 메인에 노출되는 대표 가격이며,<br>미체크시에는 상품중 가장 낮은값이 메인에 노출됩니다.")?></td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="price" class="border" size="10" style='text-align:right;' value="<?=$row[price]?>"> 원
																	
																	<input type="checkbox" name="mainPrice" value="1" <?=$row[mainPrice] == "1" ? "checked" : NULL;?>>메인가격으로 지정 
																	
																	<br>
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
															<tr> 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">쿠폰할인가 <?help_pop("회원만 이용할수 있는 할인쿠폰이 발행되며 메인화면에 할인쿠폰 아이콘(<img src='/img/coupon_01_on_.jpg' align=absmiddle>)이 노출됩니다.")?></td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="coupon_sale" class="border" size="10" style='text-align:right;' value="<?=$row[coupon_sale]?>"> 원</td>
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
<?
if($freeid != "type6") {
?>
															<tr > 
																<td width="160" bgcolor="ececec" class="white" style="padding:5px;" height="41"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">채팅시간 <?help_pop("MEDIA 메뉴에서만 사용할수 있으며 지정된 시간동안 MD와 판매자와 유저가 채팅할수 있는 기능입니다.")?></td>
																<td width="600" bgcolor="FAFAFA" style="padding:5px;"> 
<?
if(!isset($row[live_start_time])) {
	if($row[sale_date]) {
		$live_start_time = $row[sale_date] ." 00:00:00";
	} else {
		$live_start_time =$calDate . " 00:00:00";
	}
} else { 
	if(strstr($row[live_start_time],"0000-00-00")) {
		if($row[sale_date]) {
			$live_start_time = $row[sale_date] ." 00:00:00";
		} else {
			$live_start_time = $calDate . " 00:00:00";
		}
	} else {
		$live_start_time = $row[live_start_time];
	}
}
?>
																	&nbsp;<input type="checkbox" name="talkDisabled" value="1" <?=$row[talkDisabled] || !isset($row[talkDisabled]) ? "checked" : NULL;?>>채팅비활성화 <br>
																	&nbsp;<input type="text" name="live_start_time" class="border" size="20" value="<?=$live_start_time?>"> 부터 <input type="text" name="live_time" class="border" size=5 value="<?=$row[live_time] ? $row[live_time] : 0;?>">분  <input type="text" name="live_time_sec" class="border" size=5 value="<?=$row[live_time_sec] ? $row[live_time_sec] : 0;?>">초 동안 </td>
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
<?
}
?>
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
																	<input type="checkbox" name="seeDisabled" value="1" <?=$row[seeDisabled] ? "checked" : NULL;?>>지난상품LIST 숨기기 &nbsp;
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
																<td width="165" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">MD 한마디</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	<table width="99%" border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td colspan="2">
																				&nbsp;<textarea name="md_ment" class="border" rows="10" cols="95" geditor><?=stripslashes($row[md_ment])?></textarea><br>
																				<img src="" width="1" height="2"></td>
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
																<td width="165" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">판매자 한마디</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	<table width="99%" border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td colspan="2">
																				&nbsp;<textarea name="seller_ment" class="border" rows="10" cols="95" geditor><?=stripslashes($row[seller_ment])?></textarea><br>
																				<img src="" width="1" height="2"></td>
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
																<td width="608" height="1" bgcolor="#D5D5D5"></td>
															</tr>

															<tr> 
																<td width="143" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">메인  <?help_pop("메인에 노출되는 대표 이미지 입니다.")?></td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="file" name="main_img" class="border" size="40"> 550 x 358
<?
$imgName = "main_img";
if($row[$imgName]) {
?>
																	<a href="<?=$row[$imgName]?>" target="_blank"><img src="<?=$row[$imgName]?>" width=50 border=0></a>
																	<input type="hidden" name="<?=$imgName?>_org" value="<?=$row[$imgName]?>">
																	<input type="checkbox" name="<?=$imgName?>_del" value="Y"> 삭제
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
																<td height="15" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td width="143" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">확대 1 <?help_pop("대표 이미지를 클릭시 새창으로 뜨는 확대 이미지 입니다.")?></td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="file" name="big1_img" class="border" size="40"> 600 x 600  
<?
$imgName = "big1_img";
if($row[$imgName]) {
?>
																	<a href="<?=$row[$imgName]?>" target="_blank"><img src="<?=$row[$imgName]?>" width=50 border=0></a>
																	<input type="hidden" name="<?=$imgName?>_org" value="<?=$row[$imgName]?>">
																	<input type="checkbox" name="<?=$imgName?>_del" value="Y"> 삭제
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
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">확대 2</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="file" name="big2_img" class="border" size="40"> 600 x 600 
<?
$imgName = "big2_img";
if($row[$imgName]) {
?>
																	<a href="<?=$row[$imgName]?>" target="_blank"><img src="<?=$row[$imgName]?>" width=50 border=0></a>
																	<input type="hidden" name="<?=$imgName?>_org" value="<?=$row[$imgName]?>">
																	<input type="checkbox" name="<?=$imgName?>_del" value="Y"> 삭제
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
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">확대 3</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="file" name="big3_img" class="border" size="40"> 600 x 600  
<?
$imgName = "big3_img";
if($row[$imgName]) {
?>
																	<a href="<?=$row[$imgName]?>" target="_blank"><img src="<?=$row[$imgName]?>" width=50 border=0></a>
																	<input type="hidden" name="<?=$imgName?>_org" value="<?=$row[$imgName]?>">
																	<input type="checkbox" name="<?=$imgName?>_del" value="Y"> 삭제
<?
}
?>																	
																	</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">확대 4</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="file" name="big4_img" class="border" size="40"> 600 x 600  
<?
$imgName = "big4_img";
if($row[$imgName]) {
?>
																	<a href="<?=$row[$imgName]?>" target="_blank"><img src="<?=$row[$imgName]?>" width=50 border=0></a>
																	<input type="hidden" name="<?=$imgName?>_org" value="<?=$row[$imgName]?>">
																	<input type="checkbox" name="<?=$imgName?>_del" value="Y"> 삭제
<?
}
?>																	
																	</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">확대 5</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="file" name="big5_img" class="border" size="40"> 600 x 600  
<?
$imgName = "big5_img";
if($row[$imgName]) {
?>
																	<a href="<?=$row[$imgName]?>" target="_blank"><img src="<?=$row[$imgName]?>" width=50 border=0></a>
																	<input type="hidden" name="<?=$imgName?>_org" value="<?=$row[$imgName]?>">
																	<input type="checkbox" name="<?=$imgName?>_del" value="Y"> 삭제
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
																<td height="15" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">한컷이미지 <?help_pop("한장의 이미지로 상품을 설명할수 있는 한컷이미지입니다.<br><img src='/img/help_onecut1.jpg' align=absmiddle>")?></td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="file" name="onecut_img" class="border" size="40"> 560 x  
<?
$imgName = "onecut_img";
if($row[$imgName]) {
?>
																	<a href="<?=$row[$imgName]?>" target="_blank"><img src="<?=$row[$imgName]?>" width=50 border=0></a>
																	<input type="hidden" name="<?=$imgName?>_org" value="<?=$row[$imgName]?>">
																	<input type="checkbox" name="<?=$imgName?>_del" value="Y"> 삭제
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
																<td height="15" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>

															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">사이드이미지 <?help_pop("메인 오른쪽에 노출될 상품 이미지 입니다.<br><img src='/img/help_onecut3.jpg' align=absmiddle>")?></td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="file" name="side_img" class="border" size="40"> 156 x 174  
<?
$imgName = "side_img";
if($row[$imgName]) {
?>
																	<a href="<?=$row[$imgName]?>" target="_blank"><img src="<?=$row[$imgName]?>" width=50 border=0></a>
																	<input type="hidden" name="<?=$imgName?>_org" value="<?=$row[$imgName]?>">
																	<input type="checkbox" name="<?=$imgName?>_del" value="Y"> 삭제
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
																<td height="15" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">상품 리스트 <?help_pop("구매하기 페이지 리스트에 보여질 이미지입니다.")?></td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="file" name="prolist_img" class="border" size="40"> 80 x 80 
<?
$imgName = "prolist_img";
if($row[$imgName]) {
?>
																	<a href="<?=$row[$imgName]?>" target="_blank"><img src="<?=$row[$imgName]?>" width=50 border=0></a>
																	<input type="hidden" name="<?=$imgName?>_org" value="<?=$row[$imgName]?>">
																	<input type="checkbox" name="<?=$imgName?>_del" value="Y"> 삭제
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
																<td height="15" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">지난상품보기 리스트 <?help_pop("지난 상품 보기 리스트에 보여질 이미지입니다.<br><img src='/img/help_onecut2.jpg' align=absmiddle>")?></td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="file" name="oldlist_img" class="border" size="40"> 50 x 50 
<?
$imgName = "oldlist_img";
if($row[$imgName]) {
?>
																	<a href="<?=$row[$imgName]?>" target="_blank"><img src="<?=$row[$imgName]?>" width=50 border=0></a>
																	<input type="hidden" name="<?=$imgName?>_org" value="<?=$row[$imgName]?>">
																	<input type="checkbox" name="<?=$imgName?>_del" value="Y"> 삭제
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
																<td height="15" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">지난상품보기 뷰 <?help_pop("지난 상품보기의 대표이미지 입니다.<br><img src='/img/help_onecut4.jpg' align=absmiddle>")?></td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="file" name="oldview_img" class="border" size="40"> 508 x 430 
<?
$imgName = "oldview_img";
if($row[$imgName]) {
?>
																	<a href="<?=$row[$imgName]?>" target="_blank"><img src="<?=$row[$imgName]?>" width=50 border=0></a>
																	<input type="hidden" name="<?=$imgName?>_org" value="<?=$row[$imgName]?>">
																	<input type="checkbox" name="<?=$imgName?>_del" value="Y"> 삭제
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
																<td height="15" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">동영상 <?help_pop("동영상 등록시 MEDIA 메뉴의 상품 이미지가 동영상으로 변경되며 wmv/20mb 이내로 등록바랍니다.<br><img src='/img/help_onecut5.jpg' align=absmiddle>")?></td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="file" name="movie" class="border" size="40">  20MB 이내
<?
$imgName = "movie";
if($row[$imgName]) {
?>
																	<input type="hidden" name="<?=$imgName?>_org" value="<?=$row[$imgName]?>">
																	<input type="checkbox" name="<?=$imgName?>_del" value="Y"> 삭제
<?
}
?>																			
																	</td>
															</tr>

															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>

															<tr id="eventimg_layer6_2" style="display:none"> 
																<td height="15" bgcolor="FFFFFF"></td>
															</tr>
															<tr id="eventimg_layer6_3" style="display:none"> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td height="15" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="#D5D5D5"></td>
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
		<script>
		//메인인지 서브인지 체크
		mainOrSubCheck();
		</script>
	</body>
</html>
