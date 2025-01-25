<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	
	$option3Array  = explode("/",$option3);
	$option3Count = count($option3Array);
?>

		<script language="JavaScript">
			function putValue() {
				workForm = document.optionForm;
				workTemp = '';
				for(var i=0;i<<?=$option3Count?>;i++) {
					if(workTemp.length > 0 && eval('workForm.optionName'+i).value != "" && eval('workForm.optionPrice'+i).value!="") 
						workTemp += '/';

					if(eval('workForm.optionName'+i).value != "" && eval('workForm.optionPrice'+i).value!="") {
						workTemp += eval('workForm.optionName'+i).value + ":" + eval('workForm.optionPrice'+i).value + ";" + eval('workForm.optionPoint'+i).value + "," + eval('workForm.optionStock'+i).value;
					}
				}

				opener.document.<?=$formname?>.option3.value = workTemp;
				
				close();
			}

			function delValue() {
				var option_idx = '';
				
				for(i = 0; i < document.optionForm.elements.length; ++i) {
					if(document.optionForm.elements[i].name == 'checkValue') {
						if(document.optionForm.elements[i].checked == false) {
							if(option_idx != '') option_idx = option_idx + '/';
							
							option_idx = option_idx + document.optionForm.elements[i].value;
						}
					}
				}

				document.deleteForm.option3.value = option_idx;
				document.deleteForm.submit();
			}
		</script>

	<body bgcolor="F7F7EE" leftmargin="0" topmargin="0">
		<form name="deleteForm" method="post">
			<input type="hidden" name="formname" value="snsForm">
			<input type="hidden" name="option3" value="">
		</form>
		<br>
		<table width="400" border="0" cellspacing="0" cellpadding="0" align="center">
			<form name="optionForm" method="post" action="od_option3modify.php">
				<input type="hidden" name="formname" value="<?=$formname?>">
			<tr> 
				<td width="140">
					<font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle">
					<b>상품 옵션3 리스트</b></font></td>
				<td align="right">
					<font color="#666666">총 [<b><?=$option3Count?></b>]개 옵션</font></td>
			</tr>
		</table>
		<table width="400" border="0" cellspacing="0" cellpadding="0" align="center">
			<tr> 
				<td height='3'></td>
			</tr>
			<tr> 
				<td height='1' bgcolor='#c0bebe'></td>
			</tr>
			<tr> 
				<td height="24" bgcolor="#ececec" align="center"> 
					<table width="400" border="0" cellspacing="0" cellpadding="0">
						<tr align="center"> 
							<td width="35" height="18" class="white">번호</td>
							<td width="40" height="18" class="white">선택</td>
							<td height="18" class="white">옵션명</td>
							<td width="65" height="18" class="white">가격</td>
							<td width="60" height="18" class="white">포인트</td>
							<td width="55" height="18" class="white">수량</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr> 
				<td height='1' bgcolor='#c0bebe'></td>
			</tr>
<?
	for($i=0;$i<$option3Count;$i++) {
		list($optionName,$optionTemp) = split(":",$option3Array[$i],2);
		list($optionPrice,$optionTemp1) = split(";",$optionTemp,2);
		list($optionPoint,$optionStock) = split(",",$optionTemp1,2);
?>
			<tr bgcolor="FFFFFF"> 
				<td height='24' align='center' style="padding-top:5;padding-bottom:5;"> 
					<table width='400' border='0' cellspacing='0' cellpadding='0'>
						<tr> 
							<td width='35' height='18' align='center'><?=$i+1?></td>
							<td width="40" align='center'><input type='checkbox' name='checkValue' value='<?=$optionName?>:<?=$optionPrice?>;<?=$optionPoint?>,<?=$optionStock?>'></td>
							<td align='center'><input type='text' name='optionName<?=$i?>' value='<?=$optionName?>' size='19' class="border"></td>
							<td width='65' align='center'><input type='text' name='optionPrice<?=$i?>' value='<?=$optionPrice?>' size='7' class="border"></td>
							<td width='60' align='center'><input type='text' name='optionPoint<?=$i?>' value='<?=$optionPoint?>' size='6' class="border"></td>
							<td width='55' align='center'><input type='text' name='optionStock<?=$i?>' value='<?=$optionStock?>' size='6' class="border"></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr> 
				<td height='1' bgcolor='#D2D2D2'></td>
			</tr>
<?
	} 
?>
			<tr> 
				<td align="center" height="7"></td>
			</tr>
			<tr> 
				<td align="center" class='fes'>
				  <input type="button" value="    OK    " class="button_tag" name="button" onclick="putValue();">&nbsp;
				  <input type="button" value="  DELETE  " class="button_tag" name="button" onclick="delValue();">&nbsp;
				  <input type="button" value="   CLOSE  " class="button_tag" name="button" onclick="window.close();"></td>
			</tr>
			<tr> 
				<td align="center" height="10"></td>
			</tr>
			</form>
		</table>
	</body>
</html>