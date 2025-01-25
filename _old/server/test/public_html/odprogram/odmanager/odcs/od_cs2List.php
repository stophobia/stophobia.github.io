<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "../../odcommon/od_lib.inc.php";
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";

	## 세부권한 체크
	if($row_admin[memberLevel] < 3) {
		error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
	}

	$EncodingKey = urlencode($key);

/*
	## 전체 쿠폰의 수를 구한다. ###################################################
	if(!eregi("[^[:space:]]+",$key)) {
		$qry_LML = "SELECT * FROM odtCS ORDER BY regidate DESC";
	}
	else
	{
		$qry_LML = " SELECT * FROM odtCS WHERE $search LIKE '%$key%' ORDER BY regidate DESC ";
	}
*/
    ## 검색 2010-12-06 (tindevil)
    unset($where_);
    if($search)
    {
        $where_ = " and ".$search." like '%".$key."%' ";
    }
    $qry_LML = "SELECT * FROM odtCS where csNo != '' $where_ ORDER BY regidate DESC";


	$res_LML = mysql_query($qry_LML);
	$num_LML = mysql_num_rows($res_LML);

	$total = $num_LML;
	
	$LineNumber = 20;
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
			function selectCheck(form) {
				var check_nums = document.memberAlldelete.elements.length;
				for (var i = 0; i < check_nums;  i++) {
					var checkbox_obj = eval("document.memberAlldelete.elements[" + i + "]");
					if (checkbox_obj.checked == true) {
						break;
					}
				}
				if(i == check_nums) {
					alert ("먼저 삭제할 항목을 선택하여 주세요.   ");
					return false;
				}else {
					if(!confirm('삭제하시겠습니까?')) return false;
					document.memberAlldelete.submit();
				}
			}
			function selectAll() {
				var form = document.memberAlldelete;
				for(var i=0;i<form.elements.length;i++) {
					obj_str = eval(form.elements[i]);
					obj_str.checked = !obj_str.checked;
				}
			}
			function searchCheck(form) {
				var form = document.snsSearch;
				if(!form.search.value) {
					alert("검색조건을 선택해 주세요.   ");
					form.search.focus();
					return false;
				}
			}
			function saveExcel(fileTemp) {
				top.location=''+fileTemp;
			}

			// 회원상세정보 출럭 Ajax 시작

			var selfID;
			// request 객체 생성
			var req = null;
			function create_request() {
					var request = null;
					try {
							request = new XMLHttpRequest();
					} catch (trymicrosoft) {
							try {
									request = new ActiveXObject("Msxml12.XMLHTTP");
							} catch (othermicrosoft) {
									try {
											request = new ActiveXObject("Microsoft.XMLHTTP");
									} catch (failed) {
											request = null;
									}
							}
					}
					if (request == null)
							alert("Error creating request object!");
					else
							return request;
			}

			function showInfo(id,name,divID) {

				selfID = divID;

				// 백그라운드로 DB 추출.
				param = "id="+id+"&name="+name;
				req = create_request();
				req.open("POST", "/showUserInfo.php", true);
				req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=UTF-8");
				req.setRequestHeader("Cache-Control","no-cache, must-revalidate");
				req.setRequestHeader("Pragma","no-cache");
				req.send(param);
				req.onreadystatechange = function () {
					printHTML();
				}

				document.getElementById(divID).style.display='';
			}
			function printHTML() {
				if (req.readyState == 4) {
					if(req.status == 200) {
						// 값이 있을때만 처리
							resultText = req.responseText;
							document.getElementById(selfID+"_1").innerHTML = resultText;
					}
				}
			}
		</script>
		<iframe src="about:blank" name="hidden_frame" style="display:none"></iframe>
		<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 회원관리 &gt; <span class="st">고객1:1문의</span></font></td>
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
											<table width="760" border="0" cellspacing="1" cellpadding="0">
												<tr>
													<td height="7"></td>
												</tr>
											</table>
											<table width="760" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td valign="top">
														<form name="memberAlldelete" method="post" action="od_cs2Pro.php" onsubmit="return selectCheck(this)" target="hidden_frame">
														<input type="hidden" name="subMode" value="del">
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td><img src="../odimages/odmain/page_icon.gif" width="14" height="11"> 
																	<font color="3960AC">전체 <strong><?=$TotalPage?></strong>페이지</font></td>
																<td align="right">
																	<input type="image" src="../odimages/odmain/btn_delete.gif" width="77" height="24" border="0"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="1" colspan="11" bgcolor="c0bebe"></td>
															</tr>
															<tr align="center"> 
																<td width="40" bgcolor="ececec" class="white"><a href="javascript:selectAll();" class="white" onfocus='this.blur();' title=' 클릭 하시면 목록 전체를 선택 또는 해제 합니다. '>전체</a></td>
																<td width="80" bgcolor="ececec" class="white">분류</td>
																<td width="80" bgcolor="ececec" class="white">아이디</td>
																<td width="80" bgcolor="ececec" class="white">이름</td>
																<td bgcolor="ececec" class="white">제목</td>
																<td width="80" bgcolor="ececec" class="white">문의일시</td>
																<td width="80" bgcolor="ececec" class="white">처리유무</td>
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
	if(!$total) {
		echo "
															<tr>
																<td height='75' align='center' colspan='11'>문의가 없습니다.</td>
															</tr>";
	}
	
	$serialnumber = $total - $LineNumber * ($page - 1);
	
	for($i=$first;$i<=$last;$i++) {
		mysql_data_seek($res_LML,$i);
		$row = mysql_fetch_array($res_LML);
	
		$randID = rand(1,999999);

		echo "
															<tr> 
																<td height='3' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td width='40' align='center' bgcolor='FAFAFA'><input type='checkbox' name='no[]' value='$row[csNo]' ></td>
																<td width='80' height=30 align='center' bgcolor='FAFAFA' class='cate'>".$row[cate]."</td>
																<td width='80' height=30 align='center' bgcolor='FAFAFA' class='cate'>".$row[id]."</td>
																<td width='80' height=30 align='center' bgcolor='FAFAFA' class='cate'><div id=".$randID." style='Z-INDEX: 1; LEFT: 0px; WIDTH: 0px; POSITION: relative; TOP: 0px; HEIGHT: 0px;display:none'><div id='".$randID."_1' style='position:absolute;z-index:3;top:20;left:0;'></div></div><span style='font-weight:;cursor:pointer' onclick=\"showInfo('".$row[id]."','".$row[name]."','".$randID."')\">".$row[name]."</span></td>
																<td bgcolor='FAFAFA' align='' class='cate'><a href='./od_cs2Insert.php?csNo=".$row[csNo]."'>".$row[title]."</a></td>
																<td width='80' align='center' bgcolor='FAFAFA'>".$row[regidate]."</td>
																<td width='80' align='center' bgcolor='FAFAFA'>".($row[status] == "Y" ? "답변완료" : "<font color=red>미답변</font>")."</td>
															</tr>
															<tr> 
																<td height='3' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td height='1' colspan='11' bgcolor='D2D2D2'></td>
															</tr>";


		$serialnumber--;
	}
?>
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
																	<a href='od_cs2List.php?page=1<?=$par_page?>'>
																	<img src="../odimages/odmain/num_arrow_pre2.gif" width="13" height="11" border='0' alt="처음페이지" align="absmiddle"></a>
<?
	$TotalJump = ceil($TotalPage / $LinkNumber);
	$Jump = ceil($page / $LinkNumber);
	$FirstPage = ($Jump - 1) * $LinkNumber;
	$LastPage = $Jump * $LinkNumber;
	
	if($Jump >= $TotalJump) $LastPage = $TotalPage;
	
	if($Jump > 1) {
		$PrePage = $FirstPage;
		echo "<a href='od_cs2List.php?page=$PrePage&search=$search&key=$key'><img src='../odimages/odmain/num_arrow_pre1.gif' width='35' height='11' hspace='3' border='0' alt='이전 ${LinkNumber}개'></a> / ";
	}
	else {
		echo " / ";
	}

	for($NowPage = $FirstPage+1; $NowPage <= $LastPage; $NowPage++) {
		if($page == $NowPage) echo "<b>$NowPage</b> / ";
		else echo "<a href='od_cs2List.php?page=$NowPage&search=$search&key=$key'>$NowPage</a> / ";
	}

	if($Jump < $TotalJump) {
		$PrePage = $LastPage+1;
		echo "<a href='od_cs2List.php?page=$PrePage&search=$search&key=$key'><img src='../odimages/odmain/num_arrow_next2.gif' width='35' height='11' hspace='3' border='0' alt='다음 ${LinkNumber}개'></a>";
	}
?>
																	<a href='od_cs2List.php?page=<?=$TotalPage?><?=$par_page?>'>
																	<img src="../odimages/odmain/num_arrow_next1.gif" width="13" height="11" border='0' alt="마지막페이지" align="absmiddle"></a></td>
																<td width="180" align="right">
																	
																	<input type="image" src="../odimages/odmain/btn_delete.gif" width="77" height="24" border="0"></td>
															</tr>
															<tr> 
																<td height="10" colspan="3"></td>
															</tr>
														</table>
															</form>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<form name="snsSearch" method="post" action="od_cs2List.php" onSubmit="return searchCheck(this)">
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
																				<option value=""<?if(!$search)echo" selected"?>>* 검색조건 선택</option>
																				<option value="">---------------</option>
																				<option value="id"<?if($search=="id")echo" selected"?>>아이디</option>
																				<option value="name"<?if($search=="name")echo" selected"?>>이름</option>
																				<option value="title"<?if($search=="title")echo" selected"?>>제목</option>
																				<option value="">---------------</option>
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