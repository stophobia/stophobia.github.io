<?PHP

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

	## 접근권한 설정(엑셀저장)
	if($row_admin[memberLevel] > 2) $excelTemp1 = "saveExcel('od_excel.php?search=$search&key=$key');";
	else $excelTemp1 = "javascript:reject();";
	
	## 접근권한 설정(삭제)
	if($row_admin[memberLevel] > 6 || $row_admin[superLevel]==9) $deleteTemp1 = "selectCheck(this.form);";
	else $deleteTemp1 = "javascript:reject();";
	
	$EncodingKey = urlencode($key);

	## 전체 회원의 수를 구한다. ###################################################
	if(!eregi("[^[:space:]]+",$key)) {
		$qry_LML = "SELECT serialnum, id, name, chatNickName,email, tel1, tel2, tel3, htel1, htel2, htel3, address, address1 , signdate, Mlevel, visitnum, point, maildate FROM odtMember where userType='B' and isRobot = 'N' ORDER BY serialnum DESC";
		$talQue = "select count(*) from odtMember where name='탈퇴한회원'";
	}
	else {	   
		if($search == "tel") $where_LML = "where (tel2 LIKE '%$key%' or tel3 LIKE '%$key%')"; 
		else if($search == "htel") $where_LML = "where (htel2 LIKE '%$key%' or htel3 LIKE '%$key%')";
		else $where_LML = "WHERE $search LIKE '%$key%'";

		$qry_LML = "SELECT serialnum, id, name, email, chatNickName,tel1, tel2, tel3, htel1, htel2, htel3, address, address1 , signdate, Mlevel, visitnum, point, maildate FROM odtMember $where_LML and userType='B' and isRobot = 'N' ORDER BY serialnum DESC";

		$talQue = "select count(*) from odtMember $where_LML and name='탈퇴한회원'";
	}

	$talMember = mysql_result(mysql_query($talQue),0);

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

<script>
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

// 회원상세정보 출럭 Ajax 끝

</script>

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
					alert ("먼저 탈퇴 처리하실 회원을 선택하여 주세요.   ");
					return;
				}else {
					document.memberAlldelete.Form.value = "memberDelete";
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

			// 고개관리 기능 적용 - onedaynet jjc - 2011-01-19
			function send_function(type , form) {
				if(type == "email") {
					var app_alt = "메일발송을 위한 회원을 선택하여 주세요.";
					var app_link = "./od_mail.php";
				}
				else if(type == "point"){
					var app_alt = "포인트 지급을 위한 회원을 선택하여 주세요.";
					var app_link = "../odpoint/od_pointinsert.php";
				}
				else {
					var app_alt = "SMS발송을 위한 회원을 선택하여 주세요.";
					var app_link = "../odsms/od_smsgroup.php";
				}
				var check_nums = document.memberAlldelete.elements.length;
				for (var i = 0; i < check_nums;  i++) {
					var checkbox_obj = eval("document.memberAlldelete.elements[" + i + "]");
					if (checkbox_obj.checked == true) {
						break;
					}
				}
				if(i == check_nums) {
					alert (app_alt);
					return;
				}
				else {
					orgTarget = document.memberAlldelete.target;
					orgAction = document.memberAlldelete.action;

					document.memberAlldelete.target="_blank";
					document.memberAlldelete.action = app_link;
					document.memberAlldelete.submit();

					document.memberAlldelete.target=orgTarget;
					document.memberAlldelete.action=orgAction;
				}
			}

		</script>

		<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
			<tr> 
				<td height="80">
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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 회원관리 &gt; <span class="st">회원목록</span></font></td>
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
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="18"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">회원 아이디를 클릭하시면 회원 상세페이지(수정페이지)를 보실 수 있습니다.</font></td>
												</tr>
												<tr> 
													<td height="18"> <font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">회원을 삭제하고 싶은 경우 해당 회원을 선택한 뒤 "선택삭제" 버튼을 클릭 하시면 됩니다.</font></td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="7" bgcolor="FFFFFF"></td>
												</tr>
												<tr> 
													<td height="2" bgcolor="D2D2D2"></td>
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
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td><img src="../odimages/odmain/page_icon.gif" width="14" height="11"> 
																	<font color="3960AC">전체 <strong><?=$TotalPage?></strong>페이지 [<strong><?=$total?></strong>]명</font>
																	(탈퇴회원 <?=$talMember;?>명 포함)
																	</td>
																<td align="right">
																	<a href="#none" onclick="send_function('sms' , 'document.memberAlldelete')"><img src="/images/btn_sms.gif" border=0 alt="SMS발송"></a>
																	<a href="#none" onclick="send_function('email' , 'document.memberAlldelete')"><img src="../odimages/odmain/btn_mail01.gif" border=0 alt="메일발송"></a>
																	<a href="#none" onclick="send_function('point' , 'document.memberAlldelete')"><img src="../odimages/odmain/btn_point01.gif" border=0 alt="포인트지급"></a>
																	<a onclick="<?=$excelTemp1?>" style='cursor:hand;' onfocus='this.blur();'><img src="../odimages/odmain/btn_excel.gif" width="77" height="24" border="0"></a> 
																	<a onclick="<?=$deleteTemp1?>" style='cursor:hand;' onfocus='this.blur();'><img src="../odimages/odmain/btn_delete.gif" width="77" height="24" border="0"></a></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="1" colspan="11" bgcolor="c0bebe"></td>
															</tr>
<form name="memberAlldelete" method="get" action="od_delete.php">
<input type=hidden name=Form>
															<tr align="center"> 
																<td width="40" height="27" bgcolor="ececec" class="white">번호</td>
																<td width="30" bgcolor="ececec" class="white"><a href="javascript:selectAll();" class="white" onfocus='this.blur();' title=' 클릭 하시면 목록 전체를 선택 또는 해제 합니다. '>전체</a></td>
																<td width="80" bgcolor="ececec" class="white">아이디</td>
																<td width="60" bgcolor="ececec" class="white">이 름</td>
																<td width="80" bgcolor="ececec" class="white">닉네임</td>
																<td bgcolor="ececec" class="white">주소</td>
																<td width="110" bgcolor="ececec" class="white">전화번호</td>
																<td width="60" bgcolor="ececec" class="white">포인트</td>
																<td width="75" bgcolor="ececec" class="white">가입일</td>
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
																<td height='75' align='center' colspan='11'>가입된 회원이 없습니다.</td>
															</tr>";
	}
	
	$serialnumber = $total - $LineNumber * ($page - 1);
	
	for($i=$first;$i<=$last;$i++) {
		mysql_data_seek($res_LML,$i);
		$row = mysql_fetch_array($res_LML);
		
		$telTemp = $row[tel1]."-".$row[tel2]."-".$row[tel3];
		
		if($row[htel1] && $row[htel2] && $row[htel3]) 
			$htelTemp = "<br><font color='3333FF'>".$row[htel1]."-".$row[htel2]."-".$row[htel3]."</font>";
		else $htelTemp = "";
		
		$signdateTemp1 = date("Y-m-d",$row[signdate]);
		$signdateTemp2 = date("H:i:s",$row[signdate]);
		

		$visitnumTemp = number_format($row[visitnum]);
		$pointTemp = number_format($row[point]);

		## 접근권한 설정(수정)
		if($row_admin[memberLevel]==5 || $row_admin[memberLevel]==9 || $row_admin[superLevel]==9) 
			$modifyTemp1 = "od_modify.php?serialnum=$row[serialnum]&page=$page&search=$search&key=$key";
		else $modifyTemp1 = "javascript:reject();";

		$randID = rand(1,999999);

		echo "
															<tr> 
																<td height='3' colspan='11' bgcolor='FAFAFA'></td>
															</tr>
															<tr> 
																<td width='40' align='center' bgcolor='FAFAFA'>$serialnumber</td>
																<td width='30' align='center' bgcolor='FAFAFA'><input type='checkbox' name='memSerialnum[]' value='$row[serialnum]' $id_str ></td>
																<td width='80' align='center' bgcolor='FAFAFA' class='cate'><a href='$modifyTemp1'>$row[id]</a></td>
																<td width='60' align='center' bgcolor='FAFAFA'>
																	<div id=".$randID." style='Z-INDEX: 1; LEFT: 0px; WIDTH: 0px; POSITION: relative; TOP: 0px; HEIGHT: 0px;display:none'><div id='".$randID."_1' style='position:absolute;z-index:3;top:20;left:0;'></div></div><span style='font-weight:;cursor:pointer' onclick=\"showInfo('".$row[id]."','".$row[name]."','".$randID."')\">".$row[name]."</span></td>
																<td width='80' align='center' bgcolor='FAFAFA' class='cate'>".$row[chatNickName]."</td>
																<td bgcolor='FAFAFA' >$row[address] $row[address1]</td>
																<td width='110' align='center' bgcolor='FAFAFA'>$telTemp $htelTemp</td>
																<td width='60' align='center' bgcolor='FAFAFA'>$pointTemp</td>
																<td width='75' align='center' bgcolor='FAFAFA'>$signdateTemp1<br>$signdateTemp2</td>
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
																<td colspan=3 align="right">
																	<a href="#none" onclick="send_function('sms' , 'document.memberAlldelete')"><img src="/images/btn_sms.gif" border=0 alt="SMS발송"></a>
																	<a href="#none" onclick="send_function('email' , 'document.memberAlldelete')"><img src="../odimages/odmain/btn_mail01.gif" border=0 alt="메일발송"></a>
																	<a href="#none" onclick="send_function('point' , 'document.memberAlldelete')"><img src="../odimages/odmain/btn_point01.gif" border=0 alt="포인트지급"></a>
																	<a onclick="<?=$excelTemp1?>" style='cursor:hand;' onfocus='this.blur();'><img src="../odimages/odmain/btn_excel.gif" width="77" height="24" border="0"></a> 
																	<a onclick="<?=$deleteTemp1?>" style='cursor:hand;' onfocus='this.blur();'><img src="../odimages/odmain/btn_delete.gif" width="77" height="24" border="0"></a></td>
															</tr>
															<tr> 
																<td height="5" colspan="3"></td>
															</tr>
															<tr> 
																<td colspan="3" align="center" class='num'>
																	<a href='od_list.php?page=1<?=$par_page?>'>
																	<img src="../odimages/odmain/num_arrow_pre2.gif" width="13" height="11" border='0' alt="처음페이지" align="absmiddle"></a>
<?
	$TotalJump = ceil($TotalPage / $LinkNumber);
	$Jump = ceil($page / $LinkNumber);
	$FirstPage = ($Jump - 1) * $LinkNumber;
	$LastPage = $Jump * $LinkNumber;
	
	if($Jump >= $TotalJump) $LastPage = $TotalPage;
	
	if($Jump > 1) {
		$PrePage = $FirstPage;
		echo "<a href='od_list.php?page=$PrePage&search=$search&key=$key'><img src='../odimages/odmain/num_arrow_pre1.gif' width='35' height='11' hspace='3' border='0' alt='이전 ${LinkNumber}개'></a> / ";
	}
	else {
		echo " / ";
	}

	for($NowPage = $FirstPage+1; $NowPage <= $LastPage; $NowPage++) {
		if($page == $NowPage) echo "<b>$NowPage</b> / ";
		else echo "<a href='od_list.php?page=$NowPage&search=$search&key=$key'>$NowPage</a> / ";
	}

	if($Jump < $TotalJump) {
		$PrePage = $LastPage+1;
		echo "<a href='od_list.php?page=$PrePage&search=$search&key=$key'><img src='../odimages/odmain/num_arrow_next2.gif' width='35' height='11' hspace='3' border='0' alt='다음 ${LinkNumber}개'></a>";
	}
?>
																	<a href='od_list.php?page=<?=$TotalPage?><?=$par_page?>'>
																	<img src="../odimages/odmain/num_arrow_next1.gif" width="13" height="11" border='0' alt="마지막페이지" align="absmiddle"></a></td>
															</tr>

															<tr> 
																<td height="10" colspan="3"></td>
															</tr>
</form>
														</table><br>

														<table width="760" border="0" cellspacing="0" cellpadding="0">
<form name="snsSearch" method="get" action="od_list.php" onSubmit="return searchCheck(this)">
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
																				<option value="chatNickName"<?if($search=="chatNickName")echo" selected"?>>닉네임</option>
																				<option value="address"<?if($search=="address")echo" selected"?>>주소</option>
																				<option value="tel"<?if($search=="tel")echo" selected"?>>일반전화</option>
																				<option value="htel"<?if($search=="htel")echo" selected"?>>휴대전화</option>
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