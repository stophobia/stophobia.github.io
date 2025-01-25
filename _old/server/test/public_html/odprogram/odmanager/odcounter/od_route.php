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
	

    /* 
    * javascript escape 대응함수 
    */ 
    function unescape($text) 
    { 
      return urldecode(preg_replace_callback('/%u([[:alnum:]]{4})/', create_function( 
                '$word', 
                'return iconv("UTF-16LE", "UHC", chr(hexdec(substr($word[1], 2, 2))).chr(hexdec(substr($word[1], 0, 2))));' 
                ), $text)); 
    } 

	$ToDay_Time = time();
	$ToDay_Year = date("Y");
	$ToDay_Month = date("m");
	$ToDay_Day = date("d");
	$ToDay_Hour = date("H");
	
	## 총방문자수
	$result_total = mysql_fetch_array(mysql_query("SELECT SUM(Visit_Num) as CRSV FROM odtCounterRoute")); 
	
	$Total = $result_total[CRSV];	
	if(!$Total) $Total = 0;
	
	$qry_CR = "SELECT Connect_Route, Time, Visit_Num FROM odtCounterRoute ORDER BY Visit_Num DESC";
	$res_CR = mysql_query($qry_CR);
	$num_CR = mysql_num_rows($res_CR);

	$total = $num_CR;

	$LineNumber = 10;
	$LinkNumber = 15;
	
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

		<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="FFFFFF">
			<tr> 
				<td height="80" bgcolor="#FFFFFF">
					<!-- top menu start -->
<? include "$folderpath_manager_common/od_topMenu.inc.php"; ?>
					<!-- top menu end -->
				</td>
			</tr>
			<tr> 
				<td valign="top"> 
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="6"></td>
						</tr>
					</table>
					<table height="100%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="165" height="100%" valign="top"> 
								<!-- left menu start -->
<? include "$folderpath_manager_common/od_leftMenu.inc.php"; ?>
								<!-- left menu end -->
							</td>
							<td width="3">&nbsp;</td>
							<td width="782" valign="top">
								<!-- main table start -->
								<table width="782" height="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="D6D6D6">
									<tr> 
										<td align="center" valign="top" bgcolor="#FFFFFF"> 
											<table width="100%" border="0" cellspacing="0" cellpadding="0">

												<tr> 
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 방문로그분석 &gt; <span class="st">접속경로별 접속통계</span></font></td>
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
											<table width="760" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td valign="top">
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td width="7"></td>
																<td>
																	<img src="../odimages/odmain/tex_icon.gif" align="absmiddle"> 접속경로별 <b>총방문자수</b> : <font face="tahoma" style="font-size:21;" color="FF6600"><b><?=$Total?></b></font>명
																</td>
																<td align="right">&nbsp;</td>
																<td width="7"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="3" colspan="11" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" colspan="11" bgcolor="c0bebe"></td>
															</tr>
															<tr align="center"> 
																<td width="75" height="27" bgcolor="ececec" class="white">구분</td>
																<td width="115" bgcolor="ececec" class="white">접속자수</td>
																<td width="100" bgcolor="ececec" class="white">키워드</td>
																<td width="470" bgcolor="ececec" class="white" align="left">접속경로</td>
															</tr>
															<tr> 
																<td height="1" colspan="11" bgcolor="c0bebe"></td>
															</tr>
															<tr> 
																<td height="2" colspan="11"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
<?
	if(!$Total) {
		echo "
															<tr> 
																<td height='75' colspan='11' align='center'>기록이 없습니다.</td>
															</tr>
															<tr> 
																<td height='1' bgcolor='cdcdcd' colspan='11'></td>
															</tr>";
	}
	else {
		$serialnumber = $total - $LineNumber * ($page - 1);
		
		for($i = $first; $i <= $last; $i++) {
			mysql_data_seek($res_CR,$i);
			$row = mysql_fetch_array($res_CR);
			
			$Connect_Route = $row[Connect_Route];
			
			###  문자열이 긴 경우 지정한 길이만큼 잘라내기 위한 부분 시작  ###
			$strings = $Connect_Route;
			$str02 = strlen($Connect_Route);
			$lenstr = 75;
			
			for($k=0; $k<$lenstr-1; $k++) { 
				if(ord(substr($strings, $k, 1))>127) $k++; 
			} 



			if($str02 > $lenstr) {
				$str01=substr($strings, 0, $k)."...";
				$Connect_RouteD = stripslashes($str01);
			}
			else {
				$str01=$strings;
				$Connect_RouteD = stripslashes($str01);
			}
			
			###  문자열이 긴 경우 지정한 길이만큼 잘라내기 위한 부분 끝  ###
			$Time = $row[Time];
			$Time = date("Y년 m월 d일 H시 i분 s초", $Time);
			$Visit_Num = $row[Visit_Num];
			
			if(!$Connect_Route) $Connect_RouteD = "<font color='#6633CC' face='tahoma'>즐겨찾기 OR URL 직접입력을 통한 접속</font>";
			else $Connect_RouteD = "<a href='$Connect_Route' target='_blank' title='$Connect_Route' class='fes'><font color='0197C2'>$Connect_RouteD</font></a>";
			
			$Percent = round(100*$Visit_Num/$Total, 2);

			unset($keyword);
			$tmp = explode("?",$row[Connect_Route]);
			$tmp = explode("&",$tmp[1]);
			for($a=0;$a<count($tmp);$a++) {
				$tmp2 = explode("=",$tmp[$a]);
				if(strtolower($tmp2[0]) == "query") {
					$keyword = iconv("euckr","utf-8",unescape($tmp2[1]));
					if(!$keyword ) $keyword = unescape($tmp2[1]);
				}
			}

?>
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr height='23'> 
																<td width='75' bgcolor='FAFAFA' align='center'><?=$serialnumber?></td>
																<td width='115' bgcolor='FAFAFA' align='center'><b><?=$Visit_Num?></b>명</td>
																<td width='100' bgcolor='FAFAFA' align='center'><b><?=$keyword?></b></td>
																<td width='470' bgcolor='FAFAFA' align='center'>
																	<table width='565' border='0' cellspacing='0' cellpadding='0'>
																		<tr> 
																			<td width='5'>&nbsp;</td>
																			<td width='490'> 
																				<table width='490' height='16' border='0' cellspacing='0' cellpadding='0' height='8'>
																					<tr> 
																							<td class="cate"><?=$Connect_RouteD?><br><?=$Time?></td>
																					</tr>
																				</table>
																			</td>
																			<td width='70' class='text-2'>&nbsp;<b><?=$Percent?></b>%</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height='5' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
<?
			$serialnumber--;
		}
	}
?>
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="1" cellpadding="0">
															<tr> 
																<td height="30" class="cate" align="center">
																	<a href='<?=$PHP_SELF?>?page=1&search=<?=$search?>&key=<?=$EncodingKey?>'><img src="../odimages/odmain/num_arrow_pre2.gif" width="13" height="11" border='0' alt="처음페이지" align='absmiddle'></a> 
<?
	$TotalJump = ceil($TotalPage / $LinkNumber);
	$Jump = ceil($page / $LinkNumber);
	$FirstPage = ($Jump - 1) * $LinkNumber;
	$LastPage = $Jump * $LinkNumber;
	
	if($Jump >= $TotalJump)  $LastPage = $TotalPage; 
	
	if($Jump > 1) {
		$PrePage = $FirstPage;
		echo("<a href='$PHP_SELF?page=$PrePage&search=$search&key=$EncodingKey'><img src='../odimages/odmain/num_arrow_pre1.gif' width='35' height='11' hspace='3' border='0' alt='이전 ${LinkNumber}개' align='absmiddle'></a> ");
	}

	for($NowPage = $FirstPage+1; $NowPage <= $LastPage; $NowPage++) {
		if($page == $NowPage) echo("<b><font color='red'>[$NowPage]</a></b> ");
		else echo("<a href='$PHP_SELF?page=$NowPage&search=$search&key=$EncodingKey'>[$NowPage]</a> ");
	}

	if($Jump < $TotalJump) {
		$PrePage = $LastPage+1;
		echo("<a href='$PHP_SELF?page=$PrePage&search=$search&key=$EncodingKey'><img src='../odimages/odmain/num_arrow_next2.gif' width='35' height='11' hspace='3' border='0' alt='다음 ${LinkNumber}개' align='absmiddle'></a>");
	}
?>
																	<a href='<?=$PHP_SELF?>?page=<?=$TotalPage?>&search=<?=$search?>&key=<?=$EncodingKey?>'>
																	<img src="../odimages/odmain/num_arrow_next1.gif" width="13" height="11" border='0' alt="마지막페이지" align="absmiddle"></a>
																</td>
															</tr>
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