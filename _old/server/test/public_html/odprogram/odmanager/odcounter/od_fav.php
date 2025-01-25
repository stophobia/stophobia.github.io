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
								<table width="700"  height="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="D6D6D6">
									<tr> 
										<td  width="100%" align="center" valign="top" bgcolor="#FFFFFF"> 
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 방문로그분석 &gt; <span class="st">즐겨찾기/시작페이지 등록 카운터</span></font> </td>
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
													<span id="totalView"></span>
														<table  width="100%"  border="0" cellspacing="1" cellpadding="5" bgcolor=aaaaaa>
															<tr align="center"> 
																<td width="200" height="27" bgcolor="ececec" class="white">구분</td>
																<td width="200" bgcolor="ececec" class="white">아이디</td>
																<td width="200" bgcolor="ececec" class="white">아이피</td>
																<td width="200" bgcolor="ececec" class="white">시간</td>
															</tr>

<?
$fav = $home = 0;

$que = "select * from odtCounterSet  group by id,ip, type order by regidate desc";
$res = mysql_query($que);

while($row=mysql_fetch_array($res)) {
	if($row[type] == "home") {$type = "시작페이지";$home++;}
	if($row[type] == "fav") {$type = "즐겨찾기";$fav++;}

?>
															<tr height='23'> 
																<td bgcolor='FAFAFA' align='center'><?=$type?></td>
																<td bgcolor='FAFAFA' align='center'><?=$row[id]?></td>
																<td bgcolor='FAFAFA' align='center' style="word-wrap:break-word;word-break:break-all"><?=$row[ip]?></td>
																<td bgcolor='FAFAFA' align='center' style="word-wrap:break-word;word-break:break-all"><?=$row[regidate]?></td>
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
<script>
document.getElementById('totalView').innerHTML = "즐겨찾기 : <b><?=$fav?></b>건 ,  시작페이지 : <b><?=$home?></b>건";
</script>
	</body>
</html>