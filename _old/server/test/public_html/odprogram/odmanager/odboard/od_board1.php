<?
	include "../../odcommon/od_config.inc.php";
	include "../../odcommon/od_lib.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";
	include "../../odboard/od_board.inc.php";

	$LtitleLimit = 80;	
	
	## Par 정리 ##########################################################################
	$parTemp = "?board=$board";
	if($field) $parTemp .= "&field=$field";
	if($value) $parTemp .= "&value=$value";

	## 로그인 후 현재 페이지를 유지하기 위한 경로 지정 ##################
	$_target_path = $PHP_SELF."?board=".$board."&page=".$page."&field=".$field."&value=".$value;
	$_target_path = eregi_replace("&", "@", $_target_path);

	## 총 갯수와 네비게이션에 쓰일 변수를 지정한다. ##################
	if($value != "") $WhereQuery = " and $field like '%$value%'";
	else $WhereQuery = "";
	
	$result2 = mysql_query("SELECT serialnum FROM odtBoard WHERE boardkind = $board AND notice='N' $WhereQuery");
	$num2 = mysql_num_rows($result2);
	$Total = $num2;

	$limtList = 10;
	$limtNevi = 10;	
	
	if($page < 0 || $page == "") $page = 1;
	
	$Start = ($page - 1) * $limtList;
	$TotalPage = ceil($Total/$limtList);
	
	$result = mysql_query("SELECT serialnum, writer, writerid, email, privacy, title, depth, wdate, procode, file1, file2, file3, file4, file5, readcount FROM odtBoard WHERE boardkind = $board $WhereQuery AND notice='N' ORDER BY familyid DESC, depth LIMIT $Start, $limtList");
?>

		<iframe name="hiddenFrame" src="about:blank" style="display:none"></iframe>
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


								<!-- main start -->

								<!-- 보드 설명부분 시작 -->

								<table width="676" border="0" cellspacing="0" cellpadding="0">
									<tr> 
										<td></td>
										<td height="30" valign="top" class="locat">
											<table border="0" cellspacing="1" cellpadding="0">
												<form action="od_board.php" method="post" name="searchForm">
													<input type="hidden" name="board" value="<?=$board?>">
													<input type="hidden" name="page" value="<?=$page?>">
												<tr> 
													<td>
														<select name="field" style='font-size:12px'>
														<option value='title'<?if($field=="title") echo " selected"?>>글제목</option>
														<option value='content'<?if($field=="content") echo " selected"?>>글내용</option>
														<option value='writer'<?if($field=="writer") echo " selected"?>>작성자</option>
														</select></td>
													<td><input name="value" type="text" class="gray" size="15" value="<?=$value?>"> 
														<input type="image" src="<?=$board_search_img?>" align="absmiddle"></td>
												</tr>
												</form>
											</table>
										</td>
									</tr>
								</table>

								<table width="660" border="0" cellspacing="0" cellpadding="0">
									<tr> 
										<td valign="top">
											<table width="660" border="0" cellpadding="0" cellspacing="0" align="center">
												<tr bgcolor="CDCDCD"> 
													<td height="1" colspan="6"></td>
												</tr>
												<tr align="center" bgcolor="F7F7F7"> 
													<td width="75" height="30" bgcolor="F7F7F7" align="center" style="font-size:12px;LETTER-SPACING: -0.05em;font-family:돋움;"><b><font color="1A4775">번호</font></b></td>

													<td width="40" height="30" bgcolor="F7F7F7" class='cate'><font color="1A4775"><a href="javascript:selectAll();">전체</a></font></td>
													<td style="font-size:12px;LETTER-SPACING: -0.05em;font-family:돋움;"><b><font color="1A4775">글제목</font></b></td>
													<td width="55" style="font-size:12px;LETTER-SPACING: -0.05em;font-family:돋움;"><b><font color='1A4775'>이름</font></b></td>
													<td width="75" bgcolor="F7F7F7" style="font-size:12px;LETTER-SPACING: -0.05em;font-family:돋움;"><b><font color="1A4775">등록일</font></b></td>
													<td width="40" bgcolor="F7F7F7" style="font-size:12px;LETTER-SPACING: -0.05em;font-family:돋움;"><b><font color="1A4775">조회</font></b></td>
												</tr>
												<tr bgcolor="CDCDCD"> 
													<td height="1" colspan="6"></td>
												</tr>
												<tr> 
													<td height="5" colspan="6"></td>
												</tr>
											</table>
											<table width="660" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
												<!-- 공지글 출력 시작 -->
<?
	$qry_BBNL = "SELECT * FROM odtBoard WHERE boardkind = $board AND notice='Y' ORDER BY familyid DESC, depth";
	$res_BBNL = mysql_query($qry_BBNL);
	$num_BBNL = mysql_num_rows($res_BBNL);

	$noticeTotal = $num_BBNL;
	
	if($noticeTotal) {
		while($noticeRow = mysql_fetch_array($res_BBNL)) {
			$Space = "";
			$noticeRow[title] = cut_str_short($noticeRow[title],68);
			
			if($page) $parTempT = "$parTemp&page=$page";
			$parTempT .= "&serialnum=".$noticeRow[serialnum];
			
			if($row[email] != "") {
				if($row_member[Mlevel] == 9) {
					$row[email] = encode_email($row[email]);
					$writerTemp = "<a href='mailto:".$noticeRow[email]."'>".stripslashes($noticeRow[writer])."</a>";
				}
				else {
					$writerTemp = stripslashes($noticeRow[writer]);
				}
			}
			else {
				$writerTemp = stripslashes($noticeRow[writer]);
			}
			
			$inputDate = mktime(substr($row[wdate],11,2),substr($row[wdate],14,2),substr($row[wdate],17,2),substr($row[wdate],5,2),substr($row[wdate],8,2),substr($row[wdate],0,4));
			
			if($inputDate <= time() AND time() <= $inputDate+($configiconNew*86400)) 
				$new_img_ = "&nbsp;<img src='$board_new_img' align='absmiddle'>";
			else $new_img_ = "";
			
			$dateTemp = substr($noticeRow[wdate],0,10);
			
			## 글읽기 권한 체크
			if($configReadLevel <= $Cooki_Member_Level) $read_href_ = "<a href='od_boardcount.php".$parTempT."'>";
			else $read_href_ = "<a onclick='authFunction();' onfocus='this.blur();' style='cursor:hand;'>";
?>
												<tr> 
													<td width="75" height="30" align="center"><img src="../odimages/board/icon_notice.gif" align="absmiddle"></td>
<? 
			if($row_member[Mlevel] == 9) { 
?>
													<td width="40" align="center">&nbsp;</td>
<? 
			} 
?>
													<td class="notice"><?=$read_href_?><b><?=stripslashes($noticeRow[title])?></b></a>
														<?=$new_img_?></td>
													<td width="55" align="center" class="notice"><?=$writerTemp?></td>
													<td width="75" align="center" class="num"><?=$dateTemp?></td>
													<td width="40" align="center" class="num"><?=$noticeRow[readcount]?></td>
												</tr>
												<tr> 
													<td height="1" colspan="6" bgcolor="E8E8E8"></td>
												</tr>
<?
		}
	}
?>
												<!-- 공지글 출력 종료 -->

		<!-- 비밀글 체크 스크립트 -->
		<script>
		<!--
			var passwdWin;
			
			function openPassword(type,serialnum) {
<? 
	if($Cooki_Member_Level != 9) { 
?>
				document.readForm.action = 'od_passwordForm.php?mod='+type+'&serialnum='+serialnum;
				document.readForm.target = 'passwdWin';
				passwdWin = window.open('','passwdWin','width=330,height=142');
				document.readForm.submit();
<? 
	}
	else { 
?>
				if(type == "read") {
					document.readForm.Mode.value = 'readForm';
					document.readForm.action = 'od_boardcount.php?serialnum='+serialnum;
				}

				document.readForm.submit();
<? 
	} 
?>
			}
		//-->
		</script>

												<form method='post' action='od_board.php' name="readForm">
													<input type='hidden' name='Mode'>
													<input type='hidden' name='board' value='<?=$board?>'>
													<input type='hidden' name='page' value='<?=$page?>'>
													<input type='hidden' name='field' value='<?=$field?>'>
													<input type='hidden' name='value' value='<?=$value?>'>
												</form>
<? 
	if($row_member[Mlevel] == 9) { 
?>
		<script>
			function selectAll() {
				var form = document.deleteform;
				for (var i=0;i<form.elements.length;i++) {
					obj_str = eval(form.elements[i]);
					obj_str.checked = !obj_str.checked;
				}
			}
		</script>
<? 
	} 
?>
												<form name='deleteform' method='post' action='od_boardAlldelete.php'>
													<input type='hidden' name='board' value='<?=$board?>'>
<?
	if(!$Total) {
		echo "
												<tr> 
													<td height='50' colspan='5' align='center' class='text_02'>게시글이 없습니다.</td>
												</tr>
												<tr bgcolor='D2D2D2'> 
													<td height='1' colspan='5' align='center'></td>
												</tr>";
	}
	
	$PageCount = $Total - $limtList * ($page - 1);

	while($row = mysql_fetch_array($result)) {
		$Space = "";
		$row[title] = cut_str_short($row[title],$LtitleLimit);
		
		if(strlen($row[depth]) > 1) {
			for($i=1;$i<strlen($row[depth]);$i++) $Space = $Space."&nbsp";

			$Space = $Space."<img src='$board_reply_icon_img' border=0>";
		}

		if($page) $parTempT = "$parTemp&page=$page";
		$parTempT .= "&serialnum=".$row[serialnum];
		
		if($row[email] != "") {
			if($row_member[Mlevel] == 9) {
				$row[email] = encode_email($row[email]);
				$writerTemp = "<a href='mailto:".$row[email]."'>".stripslashes($row[writer])."</a>";
			}
			else {
				$writerTemp = stripslashes($row[writer]);
			}
		}
		else {
			$writerTemp = stripslashes($row[writer]);
		}
		
		$inputDate = mktime(substr($row[wdate],11,2),substr($row[wdate],14,2),substr($row[wdate],17,2),substr($row[wdate],5,2),substr($row[wdate],8,2),substr($row[wdate],0,4));
		
		if($inputDate <= time() AND time() <= $inputDate+($configiconNew*86400)) 
			$new_img_ = "&nbsp;<img src='$board_new_img' align='absmiddle'>";
		else $new_img_ = "";
		
		$dateTemp = substr($row[wdate],0,10);
		
		## 글읽기 권한 체크
		if($configReadLevel <= $Cooki_Member_Level) {
			if($row[privacy] == "Y") {
				if($row_member[id] && $row_member[id] == $row[writerid]) $read_href_ = "<a href='od_boardcount.php".$parTempT."'>";
				else $read_href_ = "<a href=\"javascript:openPassword('read','$row[serialnum]');\">";
				
				$privacy_img_ = "<img src='$board_privacy_img' border=0 align='absmiddle'>";
			}
			else {
				$read_href_ = "<a href='od_boardcount.php".$parTempT."'>";
				$privacy_img_ = "";
			}
		}
		else {
			$read_href_ = "<a onclick='authFunction();' onfocus='this.blur();' style='cursor:hand;'>";
			
			if($row[privacy] == "Y") $privacy_img_ = "<img src='$board_privacy_img' border=0 align='absmiddle'>";
			else $privacy_img_ = "";
		}

		if($configNoticeUsed == "Yes") {
			## 댓글 수 구하기 ##
			$notice_result = mysql_query("SELECT serialnum FROM odtBoardNotice WHERE boardserialnum = '$row[serialnum]'");
			$notice_Total = mysql_num_rows($notice_result);
			
			if($notice_Total>0) $notice_TotalTemp = " <font color='#61A7D1'>[$notice_Total]</font>"; 
			else $notice_TotalTemp = " ";
		}
?>
												<tr style="padding-top:4;padding-bottom:4;"> 
													<td width="75" height="25" align="center" class="num"><?=$PageCount?></td>
<? 
		if($row_member[Mlevel] == 9) { 
?>
													<td width="40" align="center">
														<input type="checkbox" name="checkSerialnum[]" value="<?=$row[serialnum]?>">
													</td>
<? 
		} 
?>
													<td class="notice">
<? 
		if($board == 3 AND $row[procode]) { 
			$arow = mysql_fetch_array(mysql_query("SELECT auctionCode FROM odtAuction WHERE auctionCode='$row[procode]'")); 
?>
														<img src="<?=$folderpath_upload?>/auction/<?=$row[procode]?>s.jpg" width="50" height="50" align="absmiddle">&nbsp;&nbsp;
<?
		}
		else if($board == 2 AND $row[procode]) {
			$prow = mysql_fetch_array(mysql_query("SELECT code FROM odtProduct WHERE code='$row[procode]'"));
			
			$proFilename = $row[procode]."s.jpg";
?>
														<img src="<?=$folderpath_upload?>/odproducts/<?=$proFilename?>" width="50" height="50" align="absmiddle">&nbsp;&nbsp;
<? 
		} 

		if($configBoardType == "ImageBoard" && $row[file1] != "") { 
?>
														<img src="<?=$folderpath_upload?>/odboard/odupload/<?=$row[file1]?>" width="50" height="50" align="absmiddle">
<? 
		} 
?>
														<?=$Space?> <?=$read_href_?><?=stripslashes($row[title])?></a><?=$notice_TotalTemp?></font><?=$new_img_?> <?=$privacy_img_?>
													</td>
													<td width="55" align="center" class="notice"><?=$writerTemp?></td>
													<td width="75" align="center" class="num"><?=$dateTemp?></td>
													<td width="40" align="center" class="num"><?=$row[readcount]?></td>
												</tr>
												<tr> 
													<td height="1" colspan="6" bgcolor="E8E8E8"></td>
												</tr>
<?
		$PageCount--;
	}
?>
											</table>
											</form>
										</td>
									</tr>
									<tr> 
										<td height="32" align="center" class="cate">
											<!-- 페이지 링크 -->
											<a href='od_board.php?board=<?=$board;?>&page=1'><img src='../odimages/odshop/arrow_pre2.gif' width='14' height='19' border='0' align='absmiddle'></a>
<?
	$TotalJump = ceil($TotalPage / $limtNevi);
	$Jump = ceil($page / $limtNevi);
	$FirstPage = ($Jump - 1) * $limtNevi;
	$LastPage = $Jump * $limtNevi;

	$ParameterDump = "";
	
	if($Jump >= $TotalJump) $LastPage = $TotalPage;
	
	if($Jump > 1) {
		$PrePage = $FirstPage;
		echo "<a href='od_board.php?board=$board&page=$PrePage$ParameterDump'><img src='../odimages/odshop/arrow_pre1.gif' width='14' height='19' border='0' align='absmiddle'></a>";
	}

	echo "<img src='../odimages/odmain/tbtn_line.gif' width='19' height='13' border='0' align='absmiddle'>";
	
	for($NowPage = $FirstPage+1; $NowPage <= $LastPage; $NowPage++) {
		if($page == $NowPage) {
			echo("<b>$NowPage</b><img src='../odimages/odmain/tbtn_line.gif' width='19' height='13' border='0' align='absmiddle'>");
		} 
		else {
			echo("<a href='od_board.php?board=$board&page=$NowPage$ParameterDump'>$NowPage</a><img src='../odimages/odmain/tbtn_line.gif' width='19' height='13' border='0' align='absmiddle'>");
		}
	}

	if($Jump < $TotalJump) {
		$PrePage = $LastPage+1;
		echo "<a href='od_board.php?board=$board&page=$PrePage$ParameterDump'><img src='../odimages/odshop/arrow_next1.gif' width='14' height='19' border='0' align='absmiddle'></a>";
	}

	if($TotalPage < 2) $TotalPage = 1;
?>
											<a href='od_board.php?board=<?=$board;?>&page=<?=$TotalPage;?>'><img src='../odimages/odshop/arrow_next2.gif' width='14' height='19' border='0' align='absmiddle'></a>
										</td>
									</tr>
									<tr> 
										<td align="center" >
											<table width="660" border="0" cellpadding="0" cellspacing="0">
												<tr> 
													<td align="right">
<?
	## 권한체크
	//if(($configWriteAuthority == "user" && $Cooki_Member_Level != "") || ($configWriteAuthority == "manager" && $Cooki_Member_Level == $Cooki_Manager_Level) || $configWriteAuthority == "nobody") {
	if($configWriteLevel <= $Cooki_Member_Level) {
?>
														<!-- 글삭제 버튼 (관리자인 경우 게시글을 지울수 있도록 처리) -->
<? 
		if($row_member[id] && $row_member[Mlevel] > 8) { 
?>
			<script language="javascript">
				function Check_Select(form) {
					var check_nums = document.deleteform.elements.length;
					for(var i = 0; i < check_nums;  i++) {
						var checkbox_obj = eval("document.deleteform.elements[" + i + "]");
						if(checkbox_obj.checked == true) {
							break;
						}
					}
					if(i == check_nums) {
						alert ("먼저 삭제하고자 하는 글을 선택하여 주세요.   ");
						return;
					}else {
						document.deleteform.submit();
					}
				}
			</script>
														<img src='<?=$board_delete_img?>' border="0" onClick="javascript:Check_Select(this.form);" style="cursor:hand;" title="선택글 삭제">
<? 
		} 
?>
														<!-- 글쓰기 버튼 -->
														<a href="od_boardinsert.php?Mode=insertForm&board=<?=$board?>"><img src="<?=$board_write_img?>" border="0" title="글쓰기"></a>
<? 
	}
	else { 
?>
														<a href='od_board.php?board=<?=$board?>'><img src='<?=$board_list_img?>' border='0' title="리스트"></a></td>
<? 
	} 

	if($row_member[id] && $row_member[Mlevel] > 8) { 
?>
												</form>
<? 
	} 
?>
															</tr>
														</table>
													</td>
												</tr>
											</table>


<? include $_SERVER[DOCUMENT_ROOT]."/pages/subFoot.html"; ?>
