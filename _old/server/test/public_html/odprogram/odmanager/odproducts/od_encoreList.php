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

	$EncodingKey = urlencode($key);

	## 전체 쿠폰의 수를 구한다. ###################################################
	if(!eregi("[^[:space:]]+",$key)) {
		$qry_LML = "SELECT * FROM odtProduct ORDER BY serialnum DESC";
	} else {
		$qry_LML = "SELECT * FROM odtProduct where ".$search." like '%".$key."%' ORDER BY serialnum DESC";
	}

  //echo $qry_LML;

	$res_LML = mysql_query($qry_LML);
	$num_LML = mysql_num_rows($res_LML);

	$total = $num_LML;
	
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

?>

		<script language="javascript">

			function searchCheck(form) {
				var form = document.snsSearch;
				if(!form.search.value) {
					alert("검색조건을 선택해 주세요.   ");
					form.search.focus();
					return false;
				}
			}

		</script>
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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 상품관리 &gt; <span class="st">앵콜관리</span></font> </td>
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
														<form name="form" action="od_mailSMSList.php" method="post">
														<input type="hidden" name="type_check" value="0" />
														<input type="hidden" name="ft_idx" value="0" />
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td><img src="../odimages/odmain/page_icon.gif" width="14" height="11"> 
																	<font color="3960AC">전체 <strong><?=$TotalPage?></strong>페이지</font></td>
																<td align="right">
																</td>
															</tr>
														</table>
														<table width="100%" border="0" cellspacing="1" cellpadding="5" bgcolor=aaaaaa>
															<colgroup>
																<col width="80px"></col>
																<col width="60px"></col>
																<col></col>
															</colgroup>
															<tr align="center"> 
																<td bgcolor="ececec" class="white">상품코드</td>
																<td bgcolor="ececec" class="white">앵콜수</td>
																<td bgcolor="ececec" class="white">앵콜신청자</td>
															</tr>

<?
	if(!$total)
	{
															echo "
															<tr>
																<td height='75' align='center' colspan='11'>등록된 데이타가 없습니다.</td>
															</tr>";
	}
	
	$serialnumber = $total - $LineNumber * ($page - 1);
	
	for($i=$first;$i<=$last;$i++)
	{
			mysql_data_seek($res_LML,$i);
			$row = mysql_fetch_array($res_LML);

			$Query  = " select * from odtEncore where enCode = '$row[code]'  ";
			$Result = mysql_query($Query);
			$Record = mysql_fetch_array($Result);
			$enLog  = $Record[enLog] ? $Record[enLog] : "";

			$arr_enLog = explode(",",$enLog);
			$cnt = count($arr_enLog) - 1;


															echo "
															<tr height='100'> 
																<td bgcolor='FAFAFA' align='center'>$row[name]<br /><font color='red'>$row[code]</font></td>
																<td bgcolor='FAFAFA' align='center'>$cnt</td>
																<td bgcolor='FAFAFA'>
																	<table width='100%'>
																		<tr>";
																			
			for ($j = 1; $j <= $cnt; $j++)
			{
					$que2 = "select * from odtMember where id='$arr_enLog[$j]'	";
					$res2 = mysql_query($que2);
					$row2 = mysql_fetch_array($res2);

					echo "<td><font color=blue>$row2[name]</font> ($arr_enLog[$j])</td>";


					if (($j % 4) == 0)
					{
							echo "</tr><tr>";
					}
			}

			for ($k = $j; $k <= 4; $k++)
			{
					echo "<td>&nbsp;</td>";
			}
																	echo "
																	</tr>
																</table>
																</td>
															</tr>
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>";


			$serialnumber--;
	}

?>
		
																</td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="2" colspan="3"></td>
															</tr>
															<tr> 
																<td height="1" colspan="3" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="5" colspan="3"></td>
															</tr>
															<tr> 
																<td width="3"></td>
																<td align="center" class='num'>
																	<a href='od_encoreList.php?page=1<?=$par_page?>&search=<?=$search?>&key=<?=$key?>'>
																	<img src="../odimages/odmain/num_arrow_pre2.gif" width="13" height="11" border='0' alt="처음페이지" align="absmiddle"></a>
<?
	$TotalJump = ceil($TotalPage / $LinkNumber);
	$Jump = ceil($page / $LinkNumber);
	$FirstPage = ($Jump - 1) * $LinkNumber;
	$LastPage = $Jump * $LinkNumber;
	
	if($Jump >= $TotalJump) $LastPage = $TotalPage;
	
	if($Jump > 1) {
		$PrePage = $FirstPage;
		echo "<a href='od_encoreList.php?page=$PrePage&search=$search&key=$key'><img src='../odimages/odmain/num_arrow_pre1.gif' width='35' height='11' hspace='3' border='0' alt='이전 ${LinkNumber}개'></a> / ";
	}
	else {
		echo " / ";
	}

	for($NowPage = $FirstPage+1; $NowPage <= $LastPage; $NowPage++) {
		if($page == $NowPage) echo "<b>$NowPage</b> / ";
		else echo "<a href='od_encoreList.php?page=$NowPage&search=$search&key=$key'>$NowPage</a> / ";
	}

	if($Jump < $TotalJump) {
		$PrePage = $LastPage+1;
		echo "<a href='od_encoreList.php?page=$PrePage&search=$search&key=$key'><img src='../odimages/odmain/num_arrow_next2.gif' width='35' height='11' hspace='3' border='0' alt='다음 ${LinkNumber}개'></a>";
	}
?>
																	<a href='od_encoreList.php?page=<?=$TotalPage?>&search=<?=$search?>&key=<?=$key?>'>
																	<img src="../odimages/odmain/num_arrow_next1.gif" width="13" height="11" border='0' alt="마지막페이지" align="absmiddle"></a></td>
															</tr>
															<tr> 
																<td height="10" colspan="3"></td>
															</tr>
														</table>
															</form>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<form name="snsSearch" method="post" action="od_encoreList.php" onSubmit="return searchCheck(this)">
															<tr> 
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="11" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td align="center">
																	<table border="0" cellspacing="2" cellpadding="0">
																		<tr>
																			<td>
																				<select name="search">
																				<option value="name"<?if($search=="name")echo" selected"?>>상품명</option>
																				<option value="code"<?if($search=="code")echo" selected"?>>상품코드</option>
																				</select>&nbsp;
																			</td>
																			<td><input name="key" type="text" class="border" size="35" value="<?=$key?>">&nbsp;</td>
																			<td><input type="image" src="../odimages/odmain/btn_search.gif" width="43" height="19" onfocus='this.blur();'></td>
																		</tr>
																	</table>
																</td>
															</tr>
															</form>
														</table>
														<table width="760" border="0" cellspacing="1" cellpadding="0">
															<tr> 
																<td height="30">&nbsp;</td>
															</tr>
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