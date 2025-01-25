<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_common/od_class.sms.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";

	if($mode == "searchform") {
		$queryTemp="";

		if($key_sex) $queryTemp .= "substring(resinum,8,1)='$key_sex'";

		$search_tmp=explode(" ",trim($search));
		$search_tmp_str="(";

		for($ss=0;$ss<sizeof($search_tmp);$ss++){
			if($ss==0) $search_tmp_str.="$key like '%$search_tmp[$ss]%'";
			else $search_tmp_str.=" and $key like '%$search_tmp[$ss]%'";
		}

		$search_tmp_str.=")";

		if($queryTemp) $queryTemp .= " and ".$search_tmp_str;
		else $queryTemp .= $search_tmp_str;

		$query = "SELECT serialnum, id, name, htel1, htel2, htel3 FROM odtMember WHERE ".$queryTemp." ORDER BY name asc";
	}
	else {
		$query = "SELECT serialnum, id, name, htel1, htel2, htel3 FROM odtMember ORDER BY name asc";
	}
	
	$result = mysql_query($query);
	$total = mysql_num_rows($result);

	$LineNumber = 1500000;
	$LinkNumber = 10;
	
	if(!$page) {
		$page = 1;
	}
	
	if(!$total) {
		$first = 1;
		$last = 0;   
	}
	else {
		$first = $LineNumber * ($page - 1);
		$last = $LineNumber * $page;
		$IsNext = $total - $last;
		
		if($IsNext > 0) $last -= 1;
		else $last = $total - 1;
	}

	$TotalPage = ceil($total / $LineNumber);
	$parTemp = "page=$page&mode=$mode&key=$key&search=$search";
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
					<DIV STYLE='width:100%;margin-left:3px; border:1 solid'>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td align="center" width="100%">
								<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#999999">
									<form action='<?=$PHP_SELF;?>' method='post'>
										<input type='hidden' name='mode' value='searchform'>
										<input type="hidden" name="formname" value="<?=$formname?>">
									<tr bgcolor="#ffffff"> 
										<td height="30" align="center">
											<select name="key_sex">
											<option value="">성별</option>										
											<option value="1">남자</option>
											<option value="2">여자</option>
											</select>
											<select name="key_year">
											<option value="">연령대</option>										
											<option value="10">10대</option>
											<option value="20">20대</option>
											<option value="30">30대</option>
											<option value="40">40대</option>
											<option value="50">50대</option>
											<option value="60">60대</option>
											<option value="70">70대</option>
											<option value="80">80대</option>
											</select>
											<select name="key">
											<option value='name' <? if(!$key || $key=="name") echo" selected"; ?>>이름</option>
											<option value='id' <? if($key=="id") echo" selected"; ?>>아이디</option>
											<option value='address' <? if($key=="address") echo" selected"; ?>>시도</option>
											<option value='address1' <? if($key=="address1") echo" selected"; ?>>상세주소</option>
											<option value='htel3' <? if($key=="htel3") echo" selected"; ?>>전화뒷번호</option>
											</select> 
											<input name="search" type="text" class="border" size="12">
											<input type="submit" value="   검색   "> 
										</td>
									</tr>
									</form>
								</table>
							</td>
						</tr>
					</table>
					</div>
					<DIV ID=s1 STYLE='width:100%; height:86%; overflow:auto; margin-left:3px; border:1 solid'>
					<table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor='BBBBBB' style="padding:3px;">
						<tr bgcolor="FAFAFA" align="center" height="27">
							<td width="70" height="27"><b>번호</b></td>
							<td height="27"><b>고객명</b></td>
							<td height="27"><b>아이디</b></td>
							<td height="27"><b>휴대번호</b></td>
						</tr>
<?
	$serialnum_str="";

	$serialnumber = $total - $LineNumber * ($page - 1);

	for($i = $first; $i <= $last; $i++) {
		if($i<$total) {
			mysql_data_seek($result,$i);
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
		
		$serialnumber --;
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
					<!--table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="10"></td>
						</tr>
						<tr>
							<td align="center">
								<a href='<?=$PHP_SELF;?>?formname=<?=$formname?>&mode=<?=$mode?>&page=1&key=<?=$key?>&search=<?=$search?>'>첫페이지</a>&nbsp;&nbsp;&nbsp;
<?
	$TotalJump = ceil($TotalPage/$LinkNumber);
	$Jump = ceil($page/$LinkNumber);
	$FirstPage = ($Jump-1)*$LinkNumber;
	$LastPage = $Jump*$LinkNumber;	

	if($Jump >= $TotalJump) $LastPage = $TotalPage;

	if($Jump > 1) {
		$PrePage = $FirstPage;
   
		echo "<a href='$PHP_SELF?formname=$formname&mode=$mode&page=$PrePage&key=$key&search=$search'>◀</a> ";
	}

	for($NowPage = $FirstPage+1; $NowPage <= $LastPage; $NowPage++) {
		if($page == $NowPage) echo "<b><font color='blue'>$NowPage</font></b> ";
		else echo "<a href='$PHP_SELF?formname=$formname&mode=$mode&page=$NowPage&key=$key&search=$search'>$NowPage</a> ";
	}

	if($Jump < $TotalJump) {
		$PrePage = $LastPage+1;
   
		echo "<a href='$PHP_SELF?formname=$formname&mode=$mode&page=$PrePage&key=$key&search=$search'>▶</a>";
	}
?>&nbsp;&nbsp;&nbsp;
								<a href='<?=$PHP_SELF;?>?formname=<?=$formname?>&mode=<?=$mode?>&page=<?=$TotalPage?>&key=<?=$key?>&search=<?=$search?>'>마지막페이지</a>
							</td>
						</tr>
						<tr>
							<td height="10"></td>
						</tr>
					</table-->
					</div>
					<DIV STYLE='width:100%;margin-left:3px; border:1 solid'>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td align="center" width="100%">
								<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#999999">
									<form name="form_find" method="post">
										<input type="hidden" name="send_list_serial" value="<?=$serialnum_str;?>">
									<tr bgcolor="#ffffff"> 
										<td height="30" align="center">
											<input type="button" value="   선택   " onclick="select_list(form_find)">&nbsp;&nbsp;
											<input type="button" value="   취소   " onclick="self.close()">										
										</td>
									</tr>
									</form>
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