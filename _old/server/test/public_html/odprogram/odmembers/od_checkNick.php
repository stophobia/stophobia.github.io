<?
	include "../odcommon/od_config.inc.php";
	
	$nickName = $_GET[nick];

?>
<html>
	<head>
		<title>닉네임 중복확인</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href="/css/style.css" rel="stylesheet" type="text/css">
	</head>
	<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0">

		<script language="javascript">
			function replace_nickName() {
				opener.document.snsForm.nickName.select();
				self.close();
			}
		</script>
	<table border=0 cellpadding=0 cellspacing=0 width=100% height=100%>
		<tr>
			<td background="/img/popup_img_01.jpg" height=49><table width=100%  height=49 border=0 cellpadding=0 cellspacing=0>
				<tr>
					<td width=50% height=49 style="padding-left:11px"><img src="/img/popup_img_04.jpg" border=0></td>
					<td width=50% height=49 style="padding-right:7px" align=right><a href="#none" onclick="self.close()"><img src="/img/popup_img_03.jpg" border=0></a></td>
				</tr>
			</table></td>
		</tr>
		<tr>
			<td width=100% height=100% ><table width=100% height=100% border=0 cellpadding=0 cellspacing=0>
				<tr>
					<td width=100% height=100% align=center>
					<!-- 내용 -->
<? 
	if($rows=mysql_num_rows(mysql_query("SELECT chatNickName FROM odtMember WHERE chatNickName='$nickName'"))) {	// 닉네임 중복확인 
?>
					<table width="320" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="24" colspan="3">&nbsp;</td>
						</tr>
						<tr>
							<td width="75" valign="top"><img src="../odimages/odmember/id_img.gif" width="62" height="57"></td>
							<td width="1" bgcolor="EEEEEE"></td>
							<td align="right">
								<table width="233" border="0" cellspacing="0" cellpadding="0">
									<tr> 
										<td class="cate">
											신청하신 닉네임(<b><font color="D93800"><?=$nickName?></font></b>)은<br>
											<strong><font color="D93800">이미 등록되어 있습니다.</font></strong><br><br><br>
											다른 닉네임로 신청해 주시기 바랍니다. </td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td height="33" colspan="3">&nbsp;</td>
						</tr>
					</table>
<? 
	}
	else { 
?>
					<table width="320" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="75" valign="top"><img src="../odimages/odmember/id_img.gif" width="62" height="57"></td>
							<td width="1" bgcolor="EEEEEE"></td>
							<td align="right">
								<table width="233" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td class="cate">
											신청하신 닉네임(<b><font color="D93800"><?=$nickName?></font></b>)은<br>
											등록되어 있지 않으므로 <strong><font color="D93800">사용가능</font></strong> 합니다.</td>
									</tr>
									<tr>
										<td height="20">&nbsp;</td>
									</tr>
									<tr>
										<td><a href="#none" onclick="opener.document.snsForm.nickCheck1.value=1;self.close();" onfocus='this.blur();'><img src="/images/id_btn2.gif" width="175" height="25" border="0"></a></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>

<?
}
?>
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
