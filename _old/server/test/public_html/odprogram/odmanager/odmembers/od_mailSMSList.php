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
<iframe name="hidden_frame" src="about:blank" style='display:none'></iframe>
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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 회원목록 &gt; <span class="st">구독자리스트</span></font> </td>
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
<script>
function feedDel(idx) {
	if(!confirm('삭제하시겠습니까?')) return;
	hidden_frame.location.href='od_feedDel.php?idx='+idx;
}
</script>
											<table  width="100%"  border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td valign="top" width="100%">

													<table width=100% border=0 cellpadding=0 cellspacing=0>
<form name="feedFrm" action="od_mailSMSList.php" style='display:inline'>
														<tr>
															<td width="200"><span id="totalView"></span></td>
															<td align=right width="200">E-mail/휴대폰 <input type="text" name="word" class="border" size=14 style='height:17px' value="<?=$_GET[word]?>"></td> 
															<td width="50" align=right><input type="image" src="../odimages/odmain/btn_search.gif" width="43" height="19" onfocus='this.blur();' border=0></td> 
															<td width="85">&nbsp;<a href="od_mailSMSList.php"><img src="../odimages/btn_list.gif" border=0></a></td>
															<td width="85">&nbsp;<a href="od_mailSMSExcel.php?word=<?=$_GET[word]?>"><img src="../odimages/odmain/btn_excel.gif" border=0></a></td>
															<td width="85">&nbsp;<a href="od_mail_ssform.php"><img src="../odimages/odmain/btn_ok3.gif" border=0></a></td>
														</tr>
</form>
													</table>


																<table  width="100%"  border="0" cellspacing="1" cellpadding="5" bgcolor=aaaaaa>
																	<tr align="center"> 
																		<td width="100" height="27" bgcolor="ececec" class="white">번호</td>
																		<td width="250" bgcolor="ececec" class="white">E-mail</td>
																		<td width="250" bgcolor="ececec" class="white">휴대폰</td>
																		<td width="200" bgcolor="ececec" class="white">등록일시</td>
																		<td width="50" bgcolor="ececec" class="white">기능</td>
																	</tr>

<?
unset($where_);
if($_GET[word]) {
	$where_ = "and (ft_email like '%".$_GET[word]."%' or ft_sms like '%".$_GET[word]."%') ";
}
$que = "select * from feedTable where (ft_email != '' or ft_sms != '') ".$where_." group by ft_email, ft_sms order by ft_regidate desc";
$res = mysql_query($que);
$num = mysql_num_rows($res);
while($row=mysql_fetch_array($res)) {

if($_GET[word]) {
	$ft_emailTmp	= str_replace($_GET[word],"<span style='background-color:yellow'>".$_GET[word]."</span>",$row[ft_email]	);
	$ft_smsTmp		= str_replace($_GET[word],"<span style='background-color:yellow'>".$_GET[word]."</span>",$row[ft_sms]		);
} else {
	$ft_emailTmp	= $row[ft_email];
	$ft_smsTmp		= $row[ft_sms];
}

?>
															<tr height='23'> 
																<td bgcolor='FAFAFA' align='center'><?=$num--?></td>
																<td bgcolor='FAFAFA' align='center'><?=$ft_emailTmp?></td>
																<td bgcolor='FAFAFA' align='center' style="word-wrap:break-word;word-break:break-all"><?=$ft_smsTmp?></td>
																<td bgcolor='FAFAFA' align='center' style="word-wrap:break-word;word-break:break-all"><?=$row[ft_regidate]?></td>
																<td bgcolor='FAFAFA' align=center><input type='button' value="삭제" class="border" onclick="feedDel('<?=$row[ft_idx]?>');"></td>
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
document.getElementById('totalView').innerHTML = "총 건수 : <b><?=mysql_num_rows($res)?></b>건";
</script>
	</body>
</html>