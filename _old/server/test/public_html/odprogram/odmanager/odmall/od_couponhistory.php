<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";

	## 세부권한 체크
	if($row_admin[basicLevel] < 3) {
		error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
	}

	if(!$order) $order = "offerdate";
	if(!$by) $by = "desc";	

	if(!eregi("[^[:space:]]+",$key)) {
		$qry_CHL = "SELECT serialnum, ordernum, couponstatus, status, statusdate, duedate, price, id, offerdate FROM odtCouponHistory WHERE couponnumber='$cnumber' ORDER BY $order $by";
	}
	else {
		$EncodingKey = urlencode($key);

		$qry_CHL = "SELECT serialnum, ordernum, couponstatus, status, statusdate, duedate, price, id, offerdate FROM odtCouponHistory WHERE couponnumber='$cnumber' AND $search LIKE '%$key%' ORDER BY $order $by";
	}

	$res_CHL = mysql_query($qry_CHL);
	$num_CHL = mysql_num_rows($res_CHL);

	$total = $num_CHL;
	
	$LineNumber = 10;
	$LinkNumber = 10;
	
	if(!$page) $page = 1;
	
	if(!$total) {
		$first = 1;
		$last = 0;   
	}
	else {
		$first = $LineNumber * ($page - 1);
		$last = $LineNumber * $page;
		$NomLine = $total - $last;
	   
		if($NomLine > 0) $last -= 1;
		else $last = $total - 1; 
	}

	$TotalPage = ceil($total / $LineNumber);
	
	$crow = mysql_fetch_array(mysql_query("SELECT name FROM odtCouponHistory WHERE couponnumber='$cnumber' LIMIT 1"));
?>

		<script language="JavaScript">
			function productsView(which) {
				var code;
				code=which.value;
				if(code != "none")
					parent.location.href = "od_couponhistory.php?"+code+"";
			}
		</script>

		<script>
			function couponDelete(fileTemp) {
				top.location=''+fileTemp;
			}
		</script>

		<table width="760" border="0" cellspacing="0" cellpadding="0" align="center">
			<tr> 
				<td height="2"></td>
			</tr>
			<tr> 
				<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 
					<span class="st">쿠폰발급내역</span></font></td>
			</tr>
			<tr> 
				<td height="2" bgcolor="D6D6D6"></td>
			</tr>
		</table>
		<table width="760" border="0" cellspacing="1" cellpadding="0" align="center">
			<tr>
				<td height="21"></td>
			</tr>
		</table>
		<table width="730" border="0" cellspacing="0" cellpadding="0" align="center">
			<tr> 
				<td colspan="2"></td>
			</tr>
			<tr> 
				<td><b><font style="font-size:15;"><?=$crow[name]?></font></b> 총발급수 <b><?=$total?></b>개 쿠폰</td>
				<td align="right">
					<select name="orderby" onChange="productsView(this)">
					<option value="none">:: 정렬기준 ::</option>
					<option value="<?echo"cnumber=$cnumber&order=offerdate&by=desc&page=$page&search=$search&key=$key";?>"<?if($order=="offerdate" AND $by=="desc")echo" selected";?>>발급일(오름차순)</option>
					<option value="<?echo"cnumber=$cnumber&order=offerdate&by=asc&page=$page&search=$search&key=$key";?>"<?if($order=="offerdate" AND $by=="asc")echo" selected";?>>발급일(내림차순)</option>
					<option value="<?echo"cnumber=$cnumber&order=statusdate&by=desc&page=$page&search=$search&key=$key";?>"<?if($order=="statusdate" AND $by=="desc")echo" selected";?>>전환일(오름차순)</option>
					<option value="<?echo"cnumber=$cnumber&order=statusdate&by=asc&page=$page&search=$search&key=$key";?>"<?if($order=="statusdate" AND $by=="asc")echo" selected";?>>전환일(내림차순)</option>
					</select>
				</td>
			</tr>
			<tr> 
				<td colspan="2" height="1"></td>
			</tr>
		</table>
		<table width="730" border="0" cellspacing="0" cellpadding="0" align="center">
			<tr> 
				<td height="0" colspan="11" bgcolor="c0bebe"></td>
			</tr>
			<tr align="center" style="padding-top:5;padding-bottom:5;"> 
				<td height="27" bgcolor="ececec" class="white"><img src="blank.gif" width="15" height="1">주문번호</td>
				<td width="85" bgcolor="ececec" class="white">쿠폰금액</td>
				<td width="70" bgcolor="ececec" class="white">발급상태</td>
				<td width="70" bgcolor="ececec" class="white">아이디</td>
				<td width="80" bgcolor="ececec" class="white">쿠폰발급일</td>
				<td width="60" bgcolor="ececec" class="white">유효기간</td>
				<td width="100" bgcolor="ececec" class="white">적립금전환여부</td>
				<td width="80" bgcolor="ececec" class="white">적립금전환일</td>
				<td width="70" bgcolor="ececec" class="white">쿠폰회수</td>
			</tr>
			<tr> 
				<td height="1" colspan="11" bgcolor="c0bebe"></td>
			</tr>
			<tr> 
				<td height="2" colspan="11"></td>
			</tr>
		</table>
		<table width="730" border="0" cellspacing="0" cellpadding="0" align="center">
			<tr> 
				<td height="1" colspan="11" bgcolor="D2D2D2"></td>
			</tr>
<?	
	if(!$total) {
		echo "
			<tr>
				<td height='75' align='center' colspan='11'>발급된 쿠폰이 없습니다.</td></tr><tr><td height='1' colspan='11' bgcolor='D2D2D2'></td>
			</tr>";
	}

	$serialnumber = $total - $LineNumber * ($page - 1);
	
	for($i=$first;$i<=$last;$i++) {
		mysql_data_seek($res_CHL,$i);
		$row = mysql_fetch_array($res_CHL);
		
		if($row[ordernum]) $ordernumTemp = "$row[ordernum]";
		else $ordernumTemp = "-";
		
		if($row[couponstatus] == "yes") $couponstatusTemp = "<font color='FF0000'><b>발급완료</b></font>";
		else $couponstatusTemp = "<font color='0000FF'>발급대기</font>";
		
		if($row[status] == "yes") $statusTemp = "<font color='FF0000'><b>적립금전환완료</b></font>";
		else $statusTemp = "<font color='0000FF'>적립금전환대기</font>";
		
		if($row[statusdate]) $statusdateTemp = date("Y-m-d",$row[statusdate]);
		else $statusdateTemp = "-";
		
		if($row[duedate] > 0) $duedateTemp = "<b>$row[duedate]</b>일";
		else $duedateTemp = "<font color='FF0000'><b>발급즉시</b></font>";
		
		## 세부권한 체크(쿠폰회수)
		if($row_admin[basicLevel]==5 || $row_admin[superLevel]==9) {
			$coupondelTemp1 = "couponDelete('od_coupondelete.inc.php?cnumber=$cnumber&serialnum=$row[serialnum]&page=$PrePage&search=$search&key=$key');";
		}
		else {
			$coupondelTemp1 = "javascript:reject();";
		}

		echo "
			<tr style='padding-top:7;padding-bottom:7;'> 
				<td bgcolor='FAFAFA' align='center'>$row[ordernum]</td>
				<td width='85' bgcolor='FAFAFA' align='center'>".number_format($row[price])."원</td>
				<td width='70' bgcolor='FAFAFA' align='center'>$couponstatusTemp</td>
				<td width='70' bgcolor='FAFAFA' align='center'>$row[id]</td>
				<td width='80' bgcolor='FAFAFA' align='center'>".date("Y-m-d",$row[offerdate])."</td>
				<td width='60' bgcolor='FAFAFA' align='center'>$duedateTemp</td>
				<td width='100' bgcolor='FAFAFA' align='center'>$statusTemp</td>
				<td width='80' bgcolor='FAFAFA' align='center'>$statusdateTemp</td>
				<td width='70' bgcolor='FAFAFA' align='center'><a onclick=\"$coupondelTemp1\" style='cursor:hand;'><img src='../odimages/btn_coupon_del.gif' border='0'></a></td>
			</tr>
			<tr> 
				<td height='1' colspan='11' bgcolor='D2D2D2'></td>
			</tr>";
		}
?>
		</table>
		<table width="730" border="0" cellspacing="1" cellpadding="0" align="center">
			<tr>
				<td height="7" align="center"></td>
			</tr>
			<tr>
				<td align="center" class='num'>
					<a href='od_couponhistory.php?cnumber=<?=$cnumber?>&order=<?=$order?>&by=<?=$by?>&page=1<?=$par_page?>'>
					<img src="../odimages/odmain/num_arrow_pre2.gif" width="13" height="11" border='0' alt="처음페이지" align="absmiddle"></a>
<?
		$TotalJump = ceil($TotalPage / $LinkNumber);
		$Jump = ceil($page / $LinkNumber);
		$FirstPage = ($Jump - 1) * $LinkNumber;
		$LastPage = $Jump * $LinkNumber;
		
		if($Jump >= $TotalJump) $LastPage = $TotalPage;
		
		if($Jump > 1) {
			$PrePage = $FirstPage;
			echo "<a href='od_couponhistory.php?cnumber=$cnumber&order=$order&by=$by&page=$PrePage&search=$search&key=$key'><img src='../odimages/odmain/num_arrow_pre1.gif' width='35' height='11' hspace='3' border='0' alt='이전 ${LinkNumber}개'></a> / ";
		}
		else {
			echo " / ";
		}
		
		for($NowPage = $FirstPage+1; $NowPage <= $LastPage; $NowPage++) {
			if($page == $NowPage) echo "<b>$NowPage</b> / ";
			else echo "<a href='od_couponhistory.php?cnumber=$cnumber&order=$order&by=$by&page=$NowPage&search=$search&key=$key'>$NowPage</a> / ";
		}

		if($Jump < $TotalJump) {
			$PrePage = $LastPage+1;
			echo "<a href='od_couponhistory.php?cnumber=$cnumber&order=$order&by=$by&page=$PrePage&search=$search&key=$key'><img src='../odimages/odmain/num_arrow_next2.gif' width='35' height='11' hspace='3' border='0' alt='다음 ${LinkNumber}개'></a>";
		}
?>
					<a href='od_couponhistory.php?cnumber=<?=$cnumber?>&order=<?=$order?>&by=<?=$by?>&page=<?=$TotalPage?><?=$par_page?>'>
					<img src="../odimages/odmain/num_arrow_next1.gif" width="13" height="11" border='0' alt="마지막페이지" align="absmiddle"></a></td>
				<td width="180" align="right">
					<a href="javascript:self.close();"><img src="../odimages/win_close.gif" border="0"></a></td>
			</tr>
			<tr> 
				<td height="10" colspan="3"></td>
			</tr>
		</table>
		<table width="730" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td height="17" align="center"></td>
			</tr>
		</table>
	</body>
</html>