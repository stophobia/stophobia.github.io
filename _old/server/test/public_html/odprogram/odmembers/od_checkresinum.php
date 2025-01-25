<?
	include "../odcommon/od_config.inc.php";
	
	if((strlen($resinum1) == 6) && (strlen($resinum2) == 7)){
		$ser = $resinum1. "0$resinum2"; 
		
		for($i=0; $i <14; $i++) $a[$i] = intval($ser[$i]); 

		$j = $a[0]*2+$a[1]*3+$a[2]*4+$a[3]*5+$a[4]*6+$a[5]*7+$a[7]*8+$a[8]*9+$a[9]*2+$a[10]*3+$a[11]*4+$a[12]*5; 
		$j = $j % 11; 
		$k = 11 - $j; 
		
		if($k > 9) $k = $k % 10; 
		
		$j = $a[13]; 
		
		if($j == $k) {
			if($a[7] == 1) { 
				$sex =  "M"; 
				$Y = 1900; 
			}
			else if($a[7] == 2) { 
					$sex =  "F"; 
					$Y = 1900;               
			}
			else if($a[7] == 3) {  
				$sex =  "M"; 
				$Y = 2000;               
			}
			else if($a[7] == 4) { 
				$sex =  "F"; 
				$Y = 2000;                       
			}
			else {
				echo "
					<script>
						window.alert('성별을 확인할 수 없습니다.   \\n\\n다시 입력해 주세요.   ');
						self.close();
					</script>"; 

				exit;
			}

			$Y = $Y + $a[0]*10 + $a[1]; 
			$M = $a[2]*10 + $a[3]; 
			
			if(($M == 0) || ($M >12)) {
				echo "
					<script>
						window.alert('주민번호 앞번호 중 (월)을 잘못 입력하셨습니다.   \\n\\n다시 입력해 주세요.   ');
						self.close();
					</script>"; 

				exit;
			}

			$D = $a[4]*10 + $a[5]; 
			
			if(($D == 0) || ($D >31)) {
				echo "
					<script>
						window.alert('주민번호 앞번호 중 (일)을 잘못 입력하셨습니다.   \\n\\n다시 입력해 주세요.   ');
						self.close();
					</script>"; 

				exit;
			}

			$resinum = "$resinum1-$resinum2";
			
			if($a[7] == 1) $sex =  "M"; 
			else $sex =  "F"; 
		}
		else { 
			echo "
				<script>
					window.alert('주민번호를 잘못 입력하셨습니다.   \\n\\n다시 입력해 주세요.   ');
					self.close();
				</script>"; 

			exit;
		} 
	}
	else {
		echo "
			<script>
				window.alert('주민번호를 잘못 입력하셨습니다.   \\n\\n다시 입력해 주세요.   ');
				self.close();
			</script>"; 

		exit;
	}
?>
<html>
	<head>
		<title>주민번호 중복확인</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href="/css/style.css" rel="stylesheet" type="text/css">
		<script language="javascript">
			function replace_resinum(snsAuth) {
				opener.document.snsForm.snsAuth.value = snsAuth;
				//opener.document.snsForm.resinum1.select();
				self.close();
			}
		</script>
	</head>
	<body bgcolor="EDE3B5" leftmargin="0" topmargin="0">
<?
	## 회원 테이블에서 주민번호가 중복되는지를 체크한다. ##################################
	if($rows=mysql_num_rows(mysql_query("SELECT id FROM odtMember WHERE resinum='$resinum'"))) {
?>
		<table width="370" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr> 
				<td height="71" colspan="3"><img src="../odimages/odmember/resine_title.gif" width="370" height="71"></td>
			</tr>
			<tr> 
				<td width="5">&nbsp;</td>
				<td width="360" height="90" align="center" bgcolor="#FFFFFF"> 
					<table width="323" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="30" colspan="3">&nbsp;</td>
						</tr>
						<tr>
							<td width="75" height="100%" valign="top"><img src="../odimages/odmember/id_img.gif" width="62" height="57"></td>
							<td width="1" bgcolor="EEEEEE"></td>
							<td align="right">
								<table width="237" border="0" cellspacing="0" cellpadding="0">
									<tr> 
										<td class="cate"> 신청하신 주민번호는 <strong><font color="D93800">이미 등록되어 있습니다.</font></strong><br>다른 주민번호로 신청해 주시기 바랍니다. </td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td height="33" colspan="3">&nbsp;</td>
						</tr>
					</table>
				</td>
				<td width="5">&nbsp;</td>
			</tr>
			<tr> 
				<td></td>
				<td height="30" bgcolor="#FFFFFF">
					<table width="100%" border="0" cellspacing="4" cellpadding="0">
						<tr> 
							<td height="1" bgcolor="EDEDED"></td>
						</tr>
						<tr> 
							<td align="right"><a href="javascript:replace_resinum('no');" onfocus='this.blur();'><img src="../odimages/odauction/btn_close.gif" width="43" height="20" border="0"></a></td>
						</tr>
					</table>
				</td>
				<td></td>
			</tr>
			<tr> 
				<td height="5" colspan="3"></td>
			</tr>
		</table>
<? 
	}
	else { 
?>
		<table width="370" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr> 
				<td height="71" colspan="3"><img src="../odimages/odmember/resine_title.gif" width="370" height="71"></td>
			</tr>
			<tr> 
				<td width="5">&nbsp;</td>
				<td width="360" height="120" align="center" bgcolor="#FFFFFF"> 
					<table width="320" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="75" valign="top"><img src="../odimages/odmember/id_img.gif" width="62" height="57"></td>
							<td width="1" bgcolor="EEEEEE"></td>
							<td align="right">
								<table width="233" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td class="cate">신청하신 주민번호는 등록되어 있지 않으므로 <br>
											<strong><font color="D93800">사용가능</font></strong> 합니다.</td>
									</tr>
									<tr>
										<td height="20">&nbsp;</td>
									</tr>
									<tr>
										<td><a href="javascript:replace_resinum('yes');" onfocus='this.blur();'><img src="../odimages/odmember/resine_btn1.gif" width="175" height="25" border="0"></a></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
				<td width="5">&nbsp;</td>
			</tr>
			<tr> 
				<td></td>
				<td height="30" bgcolor="#FFFFFF">
					<table width="100%" border="0" cellspacing="4" cellpadding="0">
						<tr> 
							<td height="1" bgcolor="EDEDED"></td>
						</tr>
						<tr> 
							<td align="right"><a href="javascript:replace_resinum('yes');" onfocus='this.blur();'><img src="../odimages/odauction/btn_close.gif" width="43" height="20" border="0"></a></td>
						</tr>
					</table>
				</td>
				<td></td>
			</tr>
			<tr> 
				<td height="5" colspan="3"></td>
			</tr>
		</table>
<? 
	} 
?>
	</body>
</html>
