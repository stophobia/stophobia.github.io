<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";

	$whereTemp = "and id LIKE '%$search_str%' OR cName LIKE '%$search_str%' OR ceoName LIKE '%$search_str%' OR name LIKE '%$search_str%'";
	
	$result = mysql_query("SELECT * FROM odtMember WHERE userType='C' and id !='onedaynet' $whereTemp ORDER BY binary cName");
	
	if(!$search_str) $number = 0;
	else $number = mysql_affected_rows();
?>
		<script language=javascript>
			function moveFocus() {
				document.snsForm.search_str.focus();
			}
			function valueCheck() {
				str = document.snsForm.search_str.value;
				if(str == "") {
					alert("공급업체 이름 또는 아이디를 입력하셔야 합니다.   ");
					document.snsForm.search_str.focus();
					return false;
				}
			}
		</script>

		<script language=javascript>
			function inputValue(code, cname, addr) {
				opener.snsForm.customerCode.value = code;
				//opener.snsForm.com_name.value = cname;
				//opener.snsForm.com_juso.value = addr;
				window.close();
			}
		</script>

	<body onload="document.snsForm.search_str.focus();" bgcolor="F7F7EE" leftmargin="0" topmargin="0">
		<table border="0" align="center" cellpadding="0" cellspacing="0">
			<tr> 
				<td height="1"></td>
			</tr>
			<tr> 
				<td><img src="../odimages/pop_supply_title.gif"></td>
			</tr>
			<tr> 
				<td height="45" align="center" valign="bottom">
					<table width="380" border="0" cellspacing="0" cellpadding="0">
						<tr> 
							<td width="9"><img src="../odimages/odcommon/post_line.gif" width="7" height="30"></td>
							<td>
								<font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle">업체이름 또는 아이디 또는 대표자이름 또는<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;담당자이름을 입력하세요.</font></td>
						</tr>
					</table>
				</td>
			</tr>
			<form name=snsForm action='<?=$php_self?>' method=post onSubmit="return valueCheck(this)">
				<input type="hidden" name="Mode" value="<?=$Mode?>">
			<tr> 
				<td height="70" align="center"> 
					<table border="0" cellspacing="0" cellpadding="0">
						<tr> 
							<td width="55" height="28"><img src="../odimages/icon_orange_arrow.gif" width="5" height="8" hspace="8"><strong>검색</strong></td>
							<td><input name="search_str" type="text" class="border" size="30" value="<?=$search_str ? $search_str : "샘플";?>"></td>
							<td width="80" align="center"><input type="image" src="../odimages/btn_search.gif" width="70" height="18" onfocus='this.blur();'></td>
						</tr>
					</table> 
				</td>
			</tr>
			</form>
			<tr> 
				<td height="193" align="center" valign="top"> 
					<table width="380" border="0" cellspacing="1" cellpadding="0">
						<tr> 
							<td height="20"><strong><font color="EC9300">* 아래의 공급업체를 클릭하시면 자동입력 됩니다.</font></strong></td>
						</tr>
					</table>
					<table width="380" border="0" cellpadding="2" cellspacing="1" bgcolor="E3E3E3">
<?
	for($i=0 ;$i<$number;$i++) {
		mysql_data_seek($result,$i);
		$row = mysql_fetch_array($result);
?>
						<tr> 
							<td bgcolor="#FFFFFF" class="cate" height="27">&nbsp; 
								<a href="javascript:inputValue('<?=$row[id]?>', '<?=$row[cName]?>', '<?=$row[address]?>');"><b><?=$row[cName]?></b> <?=$row[name]?> <?=$row[tel1]."-".$row[tel2]."-".$row[tel3]?> <?=$row[email]?></a></td>
						</tr>
<? 
	} 
?>
					</table>
					<table width="380" border="0" cellspacing="1" cellpadding="0">
						<tr> 
							<td height="20"><strong></strong></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td height="42">&nbsp;</td>
			</tr>
		</table>
	</body>
</html>