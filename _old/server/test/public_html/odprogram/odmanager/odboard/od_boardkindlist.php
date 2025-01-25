<?
	# 2011-01-21 오전 10:50 박종익 수정중
	include "../../odcommon/od_config.inc.php";
	include "../odcommon/od_function.inc.php";	
	include "../odcommon/od_adminAuthority.inc.php";
	include "../odcommon/od_head.inc.php";
	include "../odcommon/od_body.inc.php";

	## 세부권한 체크
	if($row_admin[boardLevel] < 3) {
		error_msgloc("../","접근권한이 없습니다.   ");
	}
	
	## 접근권한 설정(게시판생성,필터링설정)
	if($row_admin[boardLevel] == 5 || $row_admin[boardLevel] == 9 || $row_admin[superLevel]==9) {
		$boardinsertTemp1 = "od_boardkindinsert.php";
		$filterModifyTemp1 = "od_boardfiltermodify.php";
	}
	else {
		$boardinsertTemp1 = "javascript:reject();";
		$filterModifyTemp1 = "javascript:reject();";
	}
	
	if(!strcmp($Form,"changeLineUp")) {
		mysql_query("UPDATE odtBoardConfig SET lineUp='$nLineUp' WHERE serialnum='$serialnum'");
		
		## 한개씩 증가
		if($pLineUp > $nLineUp) { 
			mysql_query("UPDATE odtBoardConfig SET lineUp=lineUp+1 WHERE serialnum!='$serialnum' AND lineUp < '$pLineUp' AND lineUp >= '$nLineUp'");
		}
		## 한개씩 감소 2가 3이 될경우 lineUp BETWEEN '$pLineUp' AND '$nLineUp'
		else if($pLineUp < $nLineUp) { 
			mysql_query("UPDATE odtBoardConfig SET lineUp=lineUp-1 WHERE serialnum!='$serialnum' AND lineUp > '$pLineUp' AND lineUp <= '$nLineUp'");
		}
		else {
			echo "<meta http-equiv='Refresh' content='0; URL=od_boardkindlist.php?page=$page'>";
			exit;
		}
		
		echo "
			<script name=javascript>
				window.alert('수정 되었습니다.   ');
			</script>";

		echo "<meta http-equiv='Refresh' content='0; URL=od_boardkindlist.php?page=$page'>";
		exit;
	}
	else {
		## 총 갯수와 네비게이션에 쓰일 변수를 지정한다. ##################
		$result3 = mysql_query("SELECT serialnum FROM odtBoardConfig");
		$Total = mysql_num_rows($result3);
		
		$limtList = 100;
		$limtNevi = 10;	
		
		if($page < 0 || $page == "") $page =1;
		
		$Start = ($page - 1) * $limtList;
		$TotalPage = ceil($Total / $limtList);
	
		$result = mysql_query("SELECT * FROM odtBoardConfig ORDER BY lineUp ASC limit $Start, $limtList");
?>
		<script language="javascript">
			function go_copy(val){
				window.clipboardData.setData("Text", val);
			}

			function lineUpFunc(which) {
				var code;
				code = which.value;
				if(code != "No")
					parent.location.href = "od_boardkindlist.php?"+code+"";
			}
		</script>

		<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="FFFFFF">
			<tr> 
				<td height="80" bgcolor="#FFFFFF">
					<!-- top menu start -->
<? include "../odcommon/od_topMenu.inc.php"; ?>
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
<? include "../odcommon/od_leftMenu.inc.php"; ?>
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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 일반관리 &gt; <span class="st">게시판 리스트</span></font></td>
													<td align="right">
														<a href="<?=$boardinsertTemp1?>"><img src="../odimages/btn_boardreg.gif" border="0"></a>&nbsp;
														<a href="<?=$filterModifyTemp1?>"><img src="../odimages/btn_filter.gif" border="0"></a>
													</td>
												</tr>
												<tr> 
													<td height="2" bgcolor="D6D6D6" colspan="2"></td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="1" cellpadding="0">
												<tr>
													<td height="5"></td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="18"><font color="313D7D">
														<img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5" align="absmiddle"><b>게시판 이름이 비활성화로 되어 있는 경우 사용자 모드에 표시되지 않는 게시판 입니다.</b></font></td>
												</tr>
												<tr>
													<td height="7"></td>
												</tr>
												<tr> 
													<td height="2" bgcolor="D6D6D6"></td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="1" cellpadding="0">
												<tr>
													<td height="10"></td>
												</tr>
											</table>
											<table width="760" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td valign="top">
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td height="27"><img src="../odimages/odmain/page_icon.gif" width="14" height="11"> 
																	<font color="3960AC">전체 [<strong><?=$Total?></strong>]개의 게시판이 있습니다.</font></td>
																<td align="right">&nbsp;</td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="1" colspan="11" bgcolor="c0bebe"></td>
															</tr>
															<tr align="center"> 
																<td width="65" height="27" bgcolor="ececec" class="white">번호</td>
																<td width="50" bgcolor="ececec" class="white">진열순위</td>
																<td bgcolor="ececec" class="white" style="padding-left:7;">게시판이름</td>
																<td bgcolor="ececec" class="white" style="padding-left:7;">등록된글</td>
																<td width="110" bgcolor="ececec" class="white" style="padding-left:7;">게시판종류</td>
																<td width="80" bgcolor="ececec" class="white">읽기권한</td>
																<td width="80" bgcolor="ececec" class="white">쓰기권한</td>
																<td width="80" bgcolor="ececec" class="white">댓글권한</td>
																<td width="60" bgcolor="ececec" class="white">수정</td>
																<td width="60" bgcolor="ececec" class="white">삭제</td>
															</tr>
															<tr> 
																<td height="1" colspan="11" bgcolor="c0bebe"></td>
															</tr>
															<tr> 
																<td height="2" colspan="11"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="1" colspan="11" bgcolor="D2D2D2"></td>
															</tr>
<?

		$arr_boardkind = array();
		$result4 = mysql_query("SELECT boardkind , count(*) as cnt FROM odtBoard group by boardkind ");
		while( $r = mysql_fetch_assoc($result4) ){
			$arr_boardkind[$r[boardkind]] = $r[cnt];
		}


		if(!$Total) {
			echo "
															<tr>
																<td height='55' align='center' class='fes'><font color='darkorange' face='Tahoma'><b>등록된 게시판이 없습니다.</b></font></td>
															</tr>";
		}

		while($row = mysql_fetch_array($result)) {
			## 표시함
			if($row[boardhidden]=="No") {	
				$boardhidden1 = "<b>";
				$boardhidden2 = "</b>";
			}
			## 표시하지 않음
			else {									
				$boardhidden1 = "<font color='999999'><b>";
				$boardhidden2 = "</b></font>";
			}
			
			if($row[boardtype] == "News") $board_type_ = "공지게시판";
			else if($row[boardtype] == "ImageBoard") $board_type_ = "이미지(갤러리)게시판";
			else $board_type_ = "일반(자료실)게시판";
			
			if($row[readauthority] == "user") $board_read_ = $row_setup[classname1];
			else if($row[readauthority] == "user1") $board_read_ = $row_setup[classname2];
			else if($row[readauthority] == "manager") $board_read_ = "관리자";
			else if($row[readauthority] == "member") $board_read_ = "일반회원";
			else $board_read_ = "전체";
			
			if($row[writeauthority] == "user") $board_write_ = $row_setup[classname1];
			else if($row[writeauthority] == "user1") $board_write_ = $row_setup[classname2];
			else if($row[writeauthority] == "manager") $board_write_ = "관리자";
			else if($row[writeauthority] == "member") $board_write_ = "일반회원";
			else $board_write_ = "전체";
			
			if($row[noticeauthority] == "user") $board_notice_ = $row_setup[classname1];
			else if($row[noticeauthority] == "user1") $board_notice_ = $row_setup[classname2];
			else if($row[noticeauthority] == "manager") $board_notice_ = "관리자";
			else if($row[noticeauthority] == "member") $board_notice_ = "일반회원";
			else $board_notice_ = "전체";
			
			if(file_exists("../../upfiles/odboard/odtitleimg/title$row[serialnum].jpg")) 
				$TitleIMG = "<font color='red' face='Tahoma'><b>사용</b></font>";
			else $TitleIMG = "<font color='blue' face='Tahoma'><b>미사용</b></font>";
			
			$maxLineUp = mysql_result(mysql_query("SELECT max(lineUp) FROM odtBoardConfig"),0);
			
			## 접근권한 설정 (수정)
			if($row_admin[boardLevel] == 5 || $row_admin[boardLevel] == 9 || $row_admin[superLevel]==9) {
				$modifyTemp1 = "od_boardkindmodify.php?serialnum=$row[serialnum]";
				$lineupTemp1 = "onChange=\"lineUpFunc(this);\"";
			}
			else {
				$modifyTemp1 = "javascript:reject();";
				$lineupTemp1 = "";
			}
			
			## 접근권한 설정 (삭제)
			if($row_admin[boardLevel] == 7 || $row_admin[boardLevel] == 9 || $row_admin[superLevel]==9) 
				$deleteTemp1 = "od_boardkinddel.php?serialnum=$row[serialnum]&pLineUp=$row[lineUp]";
			else $deleteTemp1 = "javascript:reject();";

?>
															<tr> 
																<td width="65" height="35" align="center" bgcolor="FAFAFA"><?=$row[serialnum]?> </td>
																<td width="50" align="center" bgcolor="FAFAFA">
																	<select name='select' <?=$lineupTemp1?>>
<?
			for($j=1;$j<=$maxLineUp;$j++) {
				echo "<option value='Form=changeLineUp&serialnum=$row[serialnum]&pLineUp=$row[lineUp]&nLineUp=$j&page=$page'";
				
				if($row[lineUp] == $j) echo " selected";
				
				echo ">$j</option>";
			}
?>
																	</select>
																</td>
																<td bgcolor="FAFAFA" align="center" style="padding-left:7;"><?=$boardhidden1?><?=$row[boardname]?><?=$boardhidden2?></td></td>
																<td width="80" bgcolor="FAFAFA" align="center"><?=number_format($arr_boardkind[$row[serialnum]])?></td>
																<td width="110" bgcolor="FAFAFA" align="left" style="padding-left:7;"><?=$board_type_?></td>
																<td width="80" bgcolor="FAFAFA" align="center"><?=$board_read_?></td>
																<td width="80" bgcolor="FAFAFA" align="center"><?=$board_write_?></td>
																<td width="80" align="center" bgcolor="FAFAFA"><?=$board_notice_?></td>
																<td width="60" align="center" bgcolor="FAFAFA"><a href="<?=$modifyTemp1?>"><img src='../odimages/btn_modify.gif' border='0'></a></td>
																<td width="60" align="center" bgcolor="FAFAFA">
<? 
			if($row[serialnum] != "1") { 
?>
																	<a href="<?=$deleteTemp1?>"><img src='../odimages/btn_delete.gif' border='0'></a></td>
<? 
			}
			else { 
?>
																	<font color="red">불가</font>
<? 
			} 
?>
																</td>
															</tr>
															<tr> 
																<td height="1" colspan="11" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="21" colspan="11" bgcolor="F1F1F1" style="padding-left:77;" class="cate">
																	게시판 링크경로 : <?=$path_home?>/odboard/od_board.php?board=<b><font color='blue'><?=$row[serialnum]?></font></b>&nbsp;&nbsp;&nbsp;
																	<a href="javascript:go_copy('<?=$path_home?>/odboard/od_board.php?board=<?=$row[serialnum]?>')"><strong>복사하기</strong>
																</td>
															</tr>
															<tr> 
																<td height="1" colspan="11" bgcolor="D2D2D2"></td>
															</tr>
<? 
		} 
?>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="2"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7"></td>
															</tr>
															<tr> 
																<td align="right">
																  <a href="<?=$boardinsertTemp1?>"><img src="../odimages/btn_boardreg.gif" border="0"></a>&nbsp;
																  <a href="<?=$filterModifyTemp1?>"><img src="../odimages/btn_filter.gif" border="0"></a></td>
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
<? include "../odcommon/od_bottom.inc.php"; ?>
					<!-- bottom end -->
				</td>
			</tr>
		</table>
	</body>
</html>
<? 
	} 
?>