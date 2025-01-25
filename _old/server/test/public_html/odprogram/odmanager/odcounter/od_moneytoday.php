<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";

	## 세부권한 체크
	if($row_admin[logLevel]==3 || $row_admin[superLevel]==9) {
	}
	else {
		error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
	}


	$where_ = " and mode = 'click' ";
	if($mode == "view") $where_ = " and mode = 'view' ";

?>

		<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="FFFFFF">
			<tr> 
				<td height="80" bgcolor="#FFFFFF">
					<!-- top menu start -->
<? include "$folderpath_manager_common/od_topMenu.inc.php"; ?>
					<!-- top menu end -->
				</td>
			</tr>
			<tr> 
				<td  width="100%" valign="top"> 
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="6"></td>
						</tr>
					</table>
					<table  width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="165" height="100%" valign="top"> 
								<!-- left menu start -->
<? include "$folderpath_manager_common/od_leftMenu.inc.php"; ?>
								<!-- left menu end -->
							</td>
							<td width="3">&nbsp;</td>
							<td  width="100%"  valign="top">
								<!-- main table start -->
								<table width="100%"  height="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="D6D6D6">
									<tr> 
										<td  width="100%" align="center" valign="top" bgcolor="#FFFFFF"> 
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 방문로그분석 &gt; <span class="st">상세로그</span></font> </td>
												</tr>
												<tr> 
													<td height="2" bgcolor="D6D6D6"></td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="1" cellpadding="0">
												<tr>
													<td height="7"></td>
												</tr>
											</table>
											<table  width="100%"  border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td valign="top" width="100%" >
													최근로그 1000개만 보여집니다. 
													&nbsp;&nbsp;&nbsp;
													보기 : 
													<select name="mode" onchange="location.href='od_moneytoday.php?mode='+this.value">
														<option value="click" <?=$mode == "click" ? "selected" : NULL;?>>클릭</option>
														<option value="view" <?=$mode == "view" ? "selected" : NULL;?>>뷰</option>
													</select>
													&nbsp;&nbsp;
													총 : <?=mysql_result(mysql_query("select count(*) from odtAdCounter where id = 'moneytoday1'  ".$where_),0);?> 건
													
													<br>
														<table  width="100%"  border="0" cellspacing="1" cellpadding="5" bgcolor=aaaaaa>

															<tr align="center"> 
																<td width="40" height="27" bgcolor="ececec" class="white">no</td>
																<td width="100" height="27" bgcolor="ececec" class="white">아이피</td>
																<td width="120" bgcolor="ececec" class="white">접속시간</td>
																<td bgcolor="ececec" class="white">접속경로</td>
																<td width="100" bgcolor="ececec" class="white">상태</td>
															</tr>

<?
$que = "select * from odtAdCounter where id = 'moneytoday1'  ".$where_." order by time desc limit 1000";
$res = mysql_query($que);
while($row=mysql_fetch_array($res)) {
?>
															<tr height='23'> 
																<td bgcolor='FAFAFA' align='center'><?=++$idx?></td>
																<td bgcolor='FAFAFA' align='center'><?=$row[ip]?></td>
																<td bgcolor='FAFAFA' align='center'><?=$row['time']?></td>
																<td bgcolor='FAFAFA' style="word-wrap:break-word;word-break:break-all"><a href="<?=$row[referer]?>" target="_blank"><?=$row[referer]?></a></td>
																<td bgcolor='FAFAFA' ><?=$row[mode]?></td>
															</tr>

<?
}
?>


														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td height="5" bgcolor="#FFFFFF"></td>
									</tr>
								</table>
								<!-- main table end -->
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td height="83">
					<!-- bottom start -->
<? include "$folderpath_manager_common/od_bottom.inc.php"; ?>
					<!-- bottom end -->
				</td>
			</tr>
		</table>
	</body>
</html>