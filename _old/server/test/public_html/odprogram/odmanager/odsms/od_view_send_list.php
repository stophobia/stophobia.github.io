<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_common/od_class.sms.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";
?>
<html>
	<head>
		<title>◈ 관리자모드</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<style type="text/css">
			A,TD{color:#494949;text-decoration:none;font-size:9pt}
			A:link{color:#494949;text-decoration:none;}
			A:visited{color:#494949;text-decoration:none;}
			A:active{color:#494949;text-decoration:underline;}
			A:hover{color:#494949;text-decoration:underline;}
		</style>

		<script>
			function select_list(form){
				opener.form_frame.send_list_serial.value = form.send_list_serial.value;
				opener.select_list();
				self.close();
			}
		</script>
	</head>
	<body>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
			<tr>
				<td align="center" height="100%">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr bgcolor="FFFFFF" height="5" colspan="3"><td></td></tr>
						<tr bgcolor="FFFFFF">
							<td>◈ <font face="tahoma" size="3"><b>SMS</b></font> 그룹발송 검색</td>
							<td align="right">
							</td>
						</tr>
						<tr bgcolor="FFFFFF" height="7" colspan="3"><td></td></tr>
					</table>
					<DIV ID=s1 STYLE='width:100%; height:91%; overflow:auto; margin-left:3px; border:1 solid'>
					<table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor='BBBBBB' style="padding:3px;">
						<tr bgcolor="FAFAFA" align="center" height="27">
							<td width="70" height="27"><b>번호</b></td>
							<td height="27"><b>고객명</b></td>
							<td height="27"><b>아이디</b></td>
							<td height="27"><b>휴대번호</b></td>
						</tr>
<?
	$send_list_serial_tmp = explode("/",$send_list_serial);

	for($i = 0; $i < sizeof($send_list_serial_tmp); $i++) {
		if($send_list_serial_tmp[$i]){
			$query = "SELECT serialnum, id, name, htel1, htel2, htel3 FROM odtMember where serialnum='$send_list_serial_tmp[$i]'";
			$result = mysql_query($query,$connect);

//			mysql_data_seek($result,$i);
			$row = mysql_fetch_array($result);

			if($i == $first) $serialnum_str.=$row[serialnum];
			else $serialnum_str.="/".$row[serialnum];
?>
						<tr bgcolor="FFFFFF" align="center" height="27">
							<td width="70" height="27"><?=$serialnumber?></td>
							<td height="27"><?=stripslashes($row[name])?></td>
							<td height="27"><?=$row[id]?></td>
							<td height="27"><?=$row[htel1];?>-<?=$row[htel2];?>-<?=$row[htel3];?></td>
						</tr>
<?
		}
	}
?>
					</table>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="10" colspan="2"></td>
						</tr>
						<tr>
							<td align="right">
							</td>
						</tr>
					</table>
					</div>
					<DIV STYLE='width:100%;margin-left:3px; border:1 solid'>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td align="center" width="100%">
								<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#999999">
									<tr bgcolor="#ffffff"> 
										<td height="30" align="center">
											<input type="button" value=" 닫   기 " onclick="self.close()">										
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					</div>
				</td>
			</tr>
		</table>
	</body>
</html>