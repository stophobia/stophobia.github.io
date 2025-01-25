<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";

	$whereTemp = "code LIKE '%$search_str%' OR agentName LIKE '%$search_str%' OR name LIKE '%$search_str%' OR address LIKE '%$search_str%'";
	
	$result = mysql_query("SELECT code, agentName, name, tel FROM odtAgent WHERE $whereTemp ORDER BY code ASC");
	
	if(!$search_str) $number = 0;
	else $number = mysql_num_rows($result);
?>
		<script language=javascript>
			function moveFocus() {
				document.snsForm.search_str.focus();
			}
			function valueCheck() {
				str = document.snsForm.search_str.value;
				if(str == "") {
					alert("찾고자 하시는 지점의 이름 또는 담당자명 또는 지점의 위치를 입력하셔야 합니다.   ");
					document.snsForm.search_str.focus();
					return false;
				}
			}
		</script>

		<script language=javascript>
			function inputValue(code,agentName) {
				opener.snsForm.agentCode.value = code;
				opener.snsForm.agentName.value = agentName;
				window.close();
			}
		</script>

	<body onload="document.snsForm.search_str.focus();" bgcolor="F7F7EE" leftmargin="0" topmargin="0">
		<table border="0" align="center" cellpadding="0" cellspacing="0">
			<tr> 
				<td><img src="../odimages/odcommon/od_post_title.gif" width="400" height="55"></td>
			</tr>
			<tr> 
				<td height="45" align="center" valign="bottom">
					<table width="380" border="0" cellspacing="0" cellpadding="0">
						<tr> 
							<td width="9"><img src="../odimages/odcommon/od_post_line.gif" width="7" height="30"></td>
							<td>
								<font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle">
								지점 이름 또는 지점 책임자 또는 지점 위치 또는<br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;지점 코드를 입력하세요.</font></td>
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
							<td><input name="search_str" type="text" class="border" size="30" value="<?=$search_str?>"></td>
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
							<td height="20"><strong><font color="EC9300">* 아래의 입점업체를 클릭하시면 자동입력 됩니다.</font></strong></td>
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
								<a href="javascript:inputValue('<?=$row[code]?>','<?=stripslashes($row[agentName])?>');"><b><?=stripslashes($row[agentName])?> (<?=$row[code]?>)</b> - <?=stripslashes($row[name])?> <?=$row[tel]?></a></td>
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
				<td height="42" bgcolor="F7F7F7">&nbsp;</td>
			</tr>
		</table>
	</body>
</html>