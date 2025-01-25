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


	if($_GET[id]) $where_ = " where Connect_Route like '%".$_GET[id]."%' ";
?>

		<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
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
							<td width="10">&nbsp;</td>
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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 방문로그분석 &gt; <span class="st">접속경로별상세로그</span></font> </td>
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

													최근로그 1000개만 보여집니다. &nbsp;&nbsp;&nbsp; 접속경로가 없는 내역은 즐겨찾기나 도메인을 바로 입력해서 접속한 경우입니다.<br>

														<table  width="100%"  border="0" cellspacing="1" cellpadding="5" bgcolor=aaaaaa>

															<tr align="center"> 
																<td width="30" bgcolor="ececec" class="white">번호</td>
																<td width="85" height="27" bgcolor="ececec" class="white">아이피</td>
																<td width="120" bgcolor="ececec" class="white">접속시간</td>
																<td width="140" bgcolor="ececec" class="white">OS / 브라우져</td>
																<td width="140" bgcolor="ececec" class="white">키워드</td>
																<td bgcolor="ececec" class="white">접속경로</td>
															</tr>

<?

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

$que = "select * from odtCounter ".$where_." order by Time desc limit 2000";
$res = mysql_query($que);

while($row=mysql_fetch_array($res)) {
	unset($keyword);
	$tmp = explode("?",$row[Connect_Route]);
	$tmp = explode("&",$tmp[1]);
	for($i=0;$i<count($tmp);$i++) {
		$tmp2 = explode("=",$tmp[$i]);
		if(strtolower($tmp2[0]) == "query") {
			$keyword = iconv("euckr","utf-8",unescape($tmp2[1]));
			if(!$keyword) $keyword = unescape($tmp2[1]);
		}
	}
?>
															<tr height='23'> 
																<td bgcolor='FAFAFA' align='center'><?=++$idx?>
																<td bgcolor='FAFAFA' align='center'><?=$row[Connect_IP]?></td>
																<td bgcolor='FAFAFA' align='center'><?=date('y-m-d H:i:s',$row[Time])?></td>
																<td bgcolor='FAFAFA' align='center' style="word-wrap:break-word;word-break:break-all"><?=$row[OS]."<br>".$row[Browser]?></td>
																<td bgcolor='FAFAFA' align='center' style="word-wrap:break-word;word-break:break-all"><?=$keyword?></td>
																<td bgcolor='FAFAFA' style="word-wrap:break-word;word-break:break-all"><?=$row[Connect_Route] ? "<a href='".$row[Connect_Route]."' target='_blank'>".$row[Connect_Route]."</a>" : $row[Connect_Route];?></td>
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