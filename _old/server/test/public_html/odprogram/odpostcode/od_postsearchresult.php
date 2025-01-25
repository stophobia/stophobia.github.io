<?
	include "../odcommon/od_config.inc.php";
	include "../odcommon/od_function.inc.php";

	$result = mysql_query("SELECT * FROM odtZipcode WHERE DONG LIKE '%$search_str%' ORDER BY ZIPCODE");
	$number = mysql_affected_rows();
?>
<html>
	<head>
		<title>우편번호 검색</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href="/css/style.css" rel="stylesheet" type="text/css">
		<script language=javascript>
			function MoveFocus() {
				document.snsForm.search_str.focus();
			}

			function SendPostCheck() {
				str = document.snsForm.search_str.value;
				
				if(str == "") {
					alert("검색어를 기입해 주십시오.");
					document.snsForm.search_str.focus();
					return false;
				}
			}
		</script>
<? 
	if($Mode == "ProdOrder") { 
?>
		<script language=javascript>
			function Copy(reczip1,reczip2, recadd) {
				opener.orderFrm4.reczip1.value = reczip1;
				opener.orderFrm4.reczip2.value = reczip2;
				opener.orderFrm4.recaddress.value = recadd;
				window.close();
			}
		</script>
<? 
	}
	else if($Mode == "MemberO") { 
?>
		<script language=javascript>
			function Copy(ozip1,ozip2, oadd) {
				opener.snsForm.ozip1.value = ozip1;
				opener.snsForm.ozip2.value = ozip2;
				opener.snsForm.oaddress.value = oadd;
				window.close();
			}
		</script>
<? 
	}
	else if($Mode == "manager") { 
?>
		<script language=javascript>
			function Copy(ozip1,ozip2, oadd) {
				opener.snsForm.comZip1.value = ozip1;
				opener.snsForm.comZip2.value = ozip2;
				opener.snsForm.comAddress1.value = oadd;
				window.close();
			}
		</script>
<? 
	}
	else if($Mode == "memberModify") { 
?>
		<script language=javascript>
			function Copy(ozip1,ozip2, oadd) {
				opener.snsForm.zip1.value = ozip1;
				opener.snsForm.zip2.value = ozip2;
				opener.snsForm.address.value = oadd;
				window.close();
			}
		</script>
<? 
	}
	else if($Mode == "memberOption") { 
?>
		<script language=javascript>
			function Copy(ozip1,ozip2, oadd) {
				opener.snsForm.ozip1.value = ozip1;
				opener.snsForm.ozip2.value = ozip2;
				opener.snsForm.oaddress.value = oadd;
				window.close();
			}
		</script>
<? 
	}
	else if($Mode == "Odetail") { 
?>
		<script language=javascript>
			function Copy(zip1,zip2, add) {
				opener.OrderForm.zip1.value = zip1;
				opener.OrderForm.zip2.value = zip2;
				opener.OrderForm.address.value = add;
				window.close();
			}
		</script>
<? 
	}
	else { 
?>
		<script language=javascript>
			function Copy(zip1,zip2, add) {
				opener.snsForm.zip1.value = zip1;
				opener.snsForm.zip2.value = zip2;
				opener.snsForm.address.value = add;
				window.close();
			}
		</script>
<?
	} 
?>
	</head>
	<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" onload="document.snsForm.search_str.focus();">
	
	<table border=0 cellpadding=0 cellspacing=0 width=100% height=100%>
		<tr>
			<td background="/img/popup_img_01.jpg" height=49><table width=100%  height=49 border=0 cellpadding=0 cellspacing=0>
				<tr>
					<td width=50% height=49 style="padding-left:11px"><img src="/img/popup_img_07.jpg" border=0></td>
					<td width=50% height=49 style="padding-right:7px" align=right><a href="#none" onclick="self.close()"><img src="/img/popup_img_03.jpg" border=0></a></td>
				</tr>
			</table></td>
		</tr>
		<tr>
			<td width=100% height=100% ><table width=100% height=100% border=0 cellpadding=0 cellspacing=0>
				<tr>
					<td width=100% height=100% align=center>
					<!-- 내용 시작 -->
					<table width="330" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td>
								<table width="330" border="0" cellspacing="1" cellpadding="0">
									<tr> 
										<td width="10" height="60" align="center" class="cate"><img src="../odimages/odmypage/icon_oranarrow.gif" width="10" height="11" align="absmiddle"><br> 
											<br> <br> </td>
										<td class="locat">찾고자 하는 주소의 동/읍/면 이름을 입력하세요.<br>
											<font color="FF7019">예) 압구정동/단양읍/수산면/설운동</font></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td height="55" align="center"> 
								<table border="0" cellspacing="1" cellpadding="0">
									<form name=snsForm action='od_postsearchresult.php' method=post onSubmit="return SendPostCheck(this)">
										<input type="hidden" name="Mode" value="<?=$Mode?>">
									<tr> 
										<td width="45" class="cate"><strong><img src="../odimages/odmypage/icon_oranarrow.gif" width="10" height="11" align="absmiddle">검색</strong></td>
										<td>
											<input name="search_str" type="text" class="gray" size="27"> 
											<input type="image" src="../odimages/odcommunity/bbtn_search.gif" width="35" height="24" align="absmiddle"></td>
									</tr>
									</form>
								</table>
							</td>
						</tr>
						<tr>
							<td>
								<table width="330" border="0" cellspacing="1" cellpadding="0">
									<tr> 
										<td class="locat">* 아래 주소중에서 선택해 주세요.</td>
									</tr>
								</table>
								<table width="330" border="0" cellpadding="2" cellspacing="1" bgcolor="E3E3E3">
<?
	for($i=0 ; $i<$number  ; $i++) {
		mysql_data_seek($result,$i);
		$row = mysql_fetch_array($result);
		
		$zip1 = substr($row[ZIPCODE],0,3);
		$zip2 = substr($row[ZIPCODE],4,3);
		$ZipNumber = $row[ZIPCODE];
		$viewAdd = $row[SIDO]." ".$row[GUGUN]." ".$row[DONG]." ".$row[BUNJI];
		$viewAdd = eregi_replace("\"","",$viewAdd);
		$insertAdd = $row[SIDO]." ".$row[GUGUN]." ".$row[DONG];
		$insertAdd = eregi_replace("\"","",$insertAdd);
?>
									<tr> 
										<td bgcolor="#FFFFFF" class="blue">
											<a href="javascript:Copy('<?=$zip1?>','<?=$zip2?>','<?=$insertAdd?>');"><strong><?=$ZipNumber?></strong> <?=$viewAdd?></a></td>
									</tr>
<? 
	} 
?>
								</table>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td>&nbsp;</td>
									</tr>
								</table>
							</td>
						</tr>
					</table> 
					<!-- 내용 끝 -->
					</td>
				</tr>
			</table></td>
		</tr>
    <tr>
      <td height="6" bgcolor="#aaa698"></td>
    </tr>
	</table>
	</body>
</html>
