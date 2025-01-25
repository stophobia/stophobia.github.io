<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";

	if(!$CateCodeS){
		$total = 0;
	}
	else{
		if($CateCodeS=="allProducts") {
			if($formname == "inputForm") 
				$qry_MPRPL = "SELECT code, name, price, optionTag3 FROM odtProduct ORDER BY lineUp ASC";
			else 
				$qry_MPRPL = "SELECT code, name, price, optionTag3 FROM odtProduct WHERE serialnum <> $serialnum ORDER BY lineUp ASC";
		}
		else {
			if($formname == "inputForm") 
				$qry_MPRPL = "SELECT code, name, price, optionTag3 FROM odtProduct WHERE cateCode like '$CateCodeS%' ORDER BY lineUp ASC";
			else 
				$qry_MPRPL = "SELECT code, name, price, optionTag3 FROM odtProduct WHERE serialnum<>$serialnum AND cateCode like '$CateCodeS%' ORDER BY lineUp ASC";
		}

		$res_MPRPL = mysql_query($qry_MPRPL);
		$num_MPRPL = mysql_num_rows($res_MPRPL);

		$total = $num_MPRPL;
	}
?>
		<!-- 상품 보기 리스트 선택 자바스크립트 ------------------------->
		<script language="JavaScript">
			function SelectCate(which) {
				var code;
				code = which.value;
				
				if(code == "No") {
					alert("분류 선택이 올바르지 않습니다.   ");
					return false;
				}

				document.relationForm.CateCodeS.value = code;
				document.relationForm.submit();
			}

			function checkProduct(objTemp) {
				var relationTemp = new String(document.relationForm.relation_procode.value);
				
				if(objTemp.checked) {
					var isStatus = false;
					relationArray = relationTemp.split("/");
					
					for(var i=0; i<relationArray.length; i++) {
						if(relationArray[i] == objTemp.value) {
							isStatus = true;
							break;
						}
					}

					if(isStatus == false) {
						if(relationTemp.length > 0) relationTemp = relationTemp + "/" + objTemp.value;
						else relationTemp = objTemp.value;
					}
					
					document.relationForm.relation_procode.value = relationTemp;
				} 
				else {
					relationArray = relationTemp.split("/");
					relationTemp = "";
					
					for(var i=0; i<relationArray.length; i++) {
						if(relationArray[i] != objTemp.value) {
							if(relationTemp.length > 0) relationTemp = relationTemp + "/" + relationArray[i];
							else relationTemp = relationArray[i];
						}
					}

					document.relationForm.relation_procode.value = relationTemp;
				}				
			
				//alert(document.relationForm.relation_procode.value);
			}

			function putValue() {
				opener.document.snsForm.relation.value = document.relationForm.relation_procode.value;
				close();
			}
			
			function goorder(which) {
				var code;
				code = which.value;
				
				if(code != "No") parent.location.href = "od_relation.php?"+code+"";
			}
		</script>

		<table width="554" border="0" cellspacing="0" cellpadding="0" align="center">
			<form name="relationForm" method="post" action="<?=$PHP_SELF?>">
				<input type="hidden" name="formname" value="<?=$formname?>">
				<input type="hidden" name="relation_procode" value="<?=$relation_procode?>">
				<input type="hidden" name="CateCodeS" value="<?=$CateCodeS?>">
				<input type="hidden" name="serialnum" value="<?=$serialnum?>">
			</form>
			<tr> 
				<td height="15" width="140"></td>
				<td align="right"></td>
			</tr>
			<tr> 
				<td height="25">
					<font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle">
					<b>관련상품 지정</b> (총 <b><?=$total?></b>개상품)</font></td>
				<td align="right">
<?
	$BCateResult = mysql_query("SELECT catecode FROM odtCategory WHERE cateparent='00'");
	$BCateTotal = mysql_num_rows($BCateResult);
?>
					<select name="CateCodeS" onChange="SelectCate(this)">
					<option value="No" <?if(!$CateCodeS) echo" selected";?>>* 상품분류별로 상품을 정렬 합니다.</option>
					<option value="No">--------------------------------</option>
					<option value="allProducts" <?if($CateCodeS=="allProducts") echo" selected";?>>▣ 전체상품</option>
					<option value="No">--------------------------------</option>
<?
	for($i=0; $i<$BCateTotal; $i++) {
		$BCateRow = mysql_fetch_array($BCateResult);
		
		$BCateCode = $BCateRow[catecode];
		
		$SCateResult = mysql_query("SELECT catecode,catename FROM odtCategory WHERE LEFT(catecode,2)='$BCateCode' ORDER BY lineup,catecode ASC");
		$SCateTotal = mysql_num_rows($SCateResult);
		
		for($j=0; $j<$SCateTotal; $j++) {
			$SCateRow = mysql_fetch_array($SCateResult);

			$RCateCode = $SCateRow[catecode];
			$RCateName = $SCateRow[catename];
			
			$optionsdevided = explode("/",$RCateCode);
			$CateTotal = count($optionsdevided);
			
			if($CateCodeS==$RCateCode) echo "<option value='$RCateCode' selected>";
			else echo "<option value='$RCateCode'>";
			
			$k = 0;
			
			while($optionsdevided[$k]) {
				if($k==0) {
					$CateCoded = $optionsdevided[0];
				}
				else {
					$CateCoded = $CateCoded."/";
					$CateCoded = $CateCoded.$optionsdevided[$k];
				}
				
				$row_d = mysql_fetch_array(mysql_query("SELECT catecode, catename FROM odtCategory WHERE catecode='$CateCoded'"));
				
				$BankName = $row_d[catename];
				$BankCode = $row_d[catecode];
				
				if($k == "0") echo "$BankName";
				else echo " ≫ $BankName";
				
				$k++;
			}

			echo "</option>";
		}
	}
?>
					<option value="No">--------------------------------</option>
					</select>
				</td>
			</tr>
		</table>
		<table width="554" border="0" cellspacing="0" cellpadding="0" align="center">
			<tr> 
				<td height='1' bgcolor='#c0bebe'></td>
			</tr>
			<tr> 
				<td height="24" bgcolor="#ececec" align="center"> 
					<table width="550" border="0" cellspacing="0" cellpadding="0">
						<tr align="center"> 
							<td width="35" class="white" height="18">번호</td>
							<td width="50" class="white" height="18">선택</td>
							<td width="60" class="white" height="18">이미지</td>
							<td class="white" height="18">상품이름</td>
							<td width="75" class="white" height="18">상품코드</td>
							<td width="80" class="white" height="18">판매가격</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr> 
				<td height='1' bgcolor='#c0bebe'></td>
			</tr>
			<tr> 
				<td height='3'></td>
			</tr>
<?
	if(!$total) {
		echo "
			<tr> 
				<td height='45' align='center' class='text-2' bgcolor='FFFFFF'>해당분류를 선택해 주시기 바랍니다.</td>
			</tr>
			<tr> 
				<td height='3' bgcolor='FFFFFF'></td>
			</tr>
			<tr> 
				<td height='1' bgcolor='#D2D2D2'></td>
			</tr>";
	}
	
	$relation_procode_Division = explode("/",$relation_procode);
	$serialnumber = $total;
	
	for($i=0; $i<$total; $i++) {
		mysql_data_seek($res_MPRPL,$i);
		$row = mysql_fetch_array($res_MPRPL);
		
		if($row[optionTag3]=="yes") $priceD = "<font color='darkorange'>옵션별 가격</font>";
		else $priceD = number_format($row[price])."원";
		
		## 작은이미지가 없는 경우 큰이미지로 대처한다.
		if(file_exists("$folderpath_upload_root/products/${row[code]}s.jpg")) $image_path = "$_productfolderpath_image/${row[code]}s.jpg";
		else $image_path = "$_productfolderpath_image/${row[code]}b1.jpg";

		echo "
			<tr bgcolor='FFFFFF' height='55'> 
				<td align='center'> 
					<table width='550' border='0' cellspacing='0' cellpadding='0' class='text-2'>
						<tr> 
							<td width='35' height='18' align='center'>$serialnumber</td>
							<td width='50' align='center'><input type='checkbox' name='ProCode[]' value='$row[code]'";
							
		$j = 0;
	
		while($relation_procode_Division[$j]) {
			if($relation_procode_Division[$j] == $row[code]) echo "checked";
	
			$j++;
		}

		echo " onclick='checkProduct(this)'></td>
							<td width='60' align='center'><img src='$image_path' width='50' height='50'></td>
							<td style='padding-left:5;'>".stripslashes($row[name])."</td>
							<td width='75' align='center'><font color='darkorange'>$row[code]</font></td>
							<td width='80' align='right'>$priceD&nbsp;&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr> 
				<td height='1' bgcolor='#D2D2D2'></td>
			</tr>";

		$serialnumber--;
	}
?>
			<tr> 
				<td align="center" height="10"></td>
			</tr>
			<tr> 
				<td align="center" class='fes'>
					<input type="button" value="     OK     " class="button_tag" name="button" onclick="putValue();">&nbsp;&nbsp;&nbsp;
					<input type="button" value="     CLOSE     " class="button_tag" name="button" onclick="window.close();"></td>
			</tr>
			<tr> 
				<td align="center" height="10"></td>
			</tr>
		</table>
	</body>
</html>