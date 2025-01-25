<?
	# 2011-01-21 오전 10:50 박종익 수정중
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";

	## 세부권한 체크
	if($row_admin[boardLevel]==5 || $row_admin[boardLevel]==9 || $row_admin[superLevel]==9) {
	}
	else {
		error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
	}
	
	if(!$form) {
?>

		<script language="javascript">
			function valueCheck(form) {
				var form = document.snsForm;
				if(!form.boardname.value) {
					alert("게시판 이름을 입력해 주세요.   ");
					form.boardname.focus();
					return false;
				}
			}
			function reSize(formname,size) {
				if(size == 'reset') {
					formname.rows = 7;
				}else{
					var value = formname.rows+size;
					if(value>0) formname.rows = value
					else return;
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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 일반관리 &gt; <span class="st">게시판 신규등록</span></font></td>
												</tr>
												<tr> 
													<td height="2" bgcolor="D6D6D6"></td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="1" cellpadding="0">
												<tr> 
													<td height="15">&nbsp;</td>
												</tr>
											</table>
											<table width="760" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td width="760" valign="top">
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<!-- form start ------------------------------------------>
															<form name="snsForm" method="post" action="od_boardkindinsert.php" enctype="multipart/form-data" onSubmit="return valueCheck(this)">
																<input type="hidden" name="form" value="setupForm">
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td width="150" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">게시판 이름</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="boardname" class="border" size="55"><br>
																	<img src="blank.gif" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 신규로 등록하실 게시판 이름을 입력 합니다.</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">게시판 종류</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	<input type="radio" name="boardtype" value="Board" checked>일반(자료실)게시판
																	<br><font color="313D7D">&nbsp;* 신규로 등록하실 게시판의 종류를 설정 합니다.</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">글읽기 권한설정</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	<input type="radio" name="readauthority" value="nobody" checked>전체(회원+비회원)
																	<input type="radio" name="readauthority" value="member">일반회원
																	<input type="radio" name="readauthority" value="manager">관리자<br>
																	<img src="blank.gif" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 신규로 등록하실 게시판의 글읽기 권한을 설정 합니다.</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">글쓰기 권한설정</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	<input type="radio" name="writeauthority" value="nobody" checked>전체(회원+비회원)
																	<input type="radio" name="writeauthority" value="member">일반회원
																	<input type="radio" name="writeauthority" value="manager">관리자<br>
																	<img src="blank.gif" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 신규로 등록하실 게시판의 글쓰기 권한을 설정 합니다.</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">댓글쓰기 권한설정</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	<input type="radio" name="noticeauthority" value="nobody" checked>전체(회원+비회원)
																	<input type="radio" name="noticeauthority" value="member">일반회원
																	<input type="radio" name="noticeauthority" value="manager">관리자<br>
																	<img src="blank.gif" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 신규로 등록하실 게시판의 댓글쓰기 권한을 설정 합니다.</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">첨부파일 개수 설정</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	<input type="radio" name="filenum" value="0" checked>사용하지않음&nbsp;
																	<input type="radio" name="filenum" value="1">1개&nbsp;
																	<input type="radio" name="filenum" value="2">2개&nbsp;
																	<input type="radio" name="filenum" value="3">3개&nbsp;
																	<input type="radio" name="filenum" value="4">4개&nbsp;
																	<input type="radio" name="filenum" value="5">5개<br>
																	<img src="blank.gif" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 글쓰기 시에 사용할 첨부파일의 개수를 설정 합니다.</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">비밀글 사용여부 설정</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	<input type="radio" name="privacyused" value="Yes">비밀글 사용함
																	<input type="radio" name="privacyused" value="No" checked>비밀글 사용하지 않음<br>
																	<img src="blank.gif" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 해당 게시판에서의 비밀글 사용여부를 설정합니다.</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr>
																<td colspan="2">
																	<table width="760" border="0" cellspacing="0" cellpadding="0">
																		<tr> 
																			<td bgcolor="ececec" class="white" style="padding:5px;" width="158"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">답변글(Reply) 사용</td>
																			<td bgcolor="FAFAFA" style="padding:5px;" width="222"> 
																				<input type="radio" name="replyused" value="Yes" checked>사용함 
																				<input type="radio" name="replyused" value="No">사용하지않음</td>
																			<td bgcolor="ececec" class="white" style="padding:5px;" width="160"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">댓글 사용</td>
																			<td bgcolor="FAFAFA" style="padding:5px;" width="220"> 
																				<input type="radio" name="noticeused" value="Yes" checked>사용함 
																				<input type="radio" name="noticeused" value="No">사용하지않음</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr>
																<td colspan="2">
																	<table width="760" border="0" cellspacing="0" cellpadding="0">
																		<tr> 
																			<td bgcolor="ececec" class="white" style="padding:5px;" width="158"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">관련글 사용</td>
																			<td bgcolor="FAFAFA" style="padding:5px;" width="222"> 
																				<input type="radio" name="relationused" value="Yes" checked>사용함 
																				<input type="radio" name="relationused" value="No">사용하지않음</td>
																			<td bgcolor="ececec" class="white" style="padding:5px;" width="160"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">Email 사용</td>
																			<td bgcolor="FAFAFA" style="padding:5px;" width="220"> 
																				<input type="radio" name="emailused" value="Yes" checked>사용함 
																				<input type="radio" name="emailused" value="No">사용하지않음</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr>
																<td colspan="2">
																	<table width="760" border="0" cellspacing="0" cellpadding="0">
																		<tr> 
																			<td bgcolor="ececec" class="white" style="padding:5px;" width="158"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">Homepage 사용</td>
																			<td bgcolor="FAFAFA" style="padding:5px;" width="222"> 
																				<input type="radio" name="homepageused" value="Yes" checked>사용함 
																				<input type="radio" name="homepageused" value="No">사용하지않음</td>
																			<td bgcolor="ececec" class="white" style="padding:5px;" width="160"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">게시판설명 보여주기</td>
																			<td bgcolor="FAFAFA" style="padding:5px;" width="220"> 
																				<input type="radio" name="commentview" value="Yes" checked>사용함 
																				<input type="radio" name="commentview" value="No">사용하지않음</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="7" bgcolor="FFFFFF"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">게시판 설명</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	<table width="99%" border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td>&nbsp;</td>
																			<td align="right">
																				<a href="javascript:reSize(document.snsForm.boardcomment,5)" onfocus='this.blur();'><img src="../odimages/button_plus.gif" border="0" align="absmiddle"></a>
																				<a href="javascript:reSize(document.snsForm.boardcomment,'reset')" onfocus='this.blur();'><img src="../odimages/button_reset.gif" border="0" align="absmiddle"></a>
																				<a href="javascript:reSize(document.snsForm.boardcomment,-5)" onfocus='this.blur();'><img src="../odimages/button_minus.gif" border="0" align="absmiddle"></a>
																			</td>
																		</tr>
																		<tr>
																			<td colspan="2" height="3"></td>
																		</tr>
																		<tr>
																			<td colspan="2">
																				&nbsp;<textarea name="boardcomment" class="border" rows="7" cols="93"></textarea></td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
														</table>

														<!-- 상품 아이콘 설정 ------->
														<table width="100%" border="0" cellspacing="1" cellpadding="0" style='display:none'>
															<tr> 
																<td height="11"></td>
															</tr>
														</table>
														<table width="100%" border="0" cellspacing="0" cellpadding="0" style='display:none'>
															<tr> 
																<td height="18">
																	<font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5"><b>상품 아이콘</b>을 설정합니다.</font></td>
																<td height="18" align="right"><a href="#" onfocus='this.blur();' class='cate'>▲ TOP</a></td>
															</tr>
														</table>
														<table width="100%" border="0" cellspacing="0" cellpadding="0" style='display:none'>
															<tr> 
																<td height="3"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0" style='display:none'>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td width="600" height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td width="163" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">게시판 관련 버튼</td>
																<td bgcolor="FAFAFA" style="padding:5px;">
																	글작성일을  기준으로
																	<input type="text" name="iconNew" size="5" class="border" style="text-align:right;"> 일 이내인 글에 표시합니다.<br>
																	<img src="<?=$folderpath_upload?>/odboard/odicons/newicon.gif" align="absmiddle" border="0">&nbsp;
																	<input type="file" name="newicon" size="57" class="border"><br><img src="" width="1" height="5"><br>
																	타이틀 아이콘<br>
<? 
		if(file_exists("$folderpath_upload_root/odboard/odicons/titleicon$serialnum.gif")) { 
?>
																	<img src="<?=$folderpath_upload?>/odboard/odicons/titleicon<?=$serialnum?>.gif" align="absmiddle" border="0">&nbsp;
<? 
		}
		else { 
?>
																	<img src="<?=$folderpath_upload?>/odboard/odicons/titleicon.gif" align="absmiddle" border="0">&nbsp;
<? 
		} 
?>
																	<input type="file" name="titleicon" size="57" class="border"><br><img src="" width="1" height="7"><br>
																	비밀글 아이콘<br>
<? 
		if(file_exists("$folderpath_upload_root/odboard/odicons/privacyicon$serialnum.gif")) { 
?>
																	<img src="<?=$folderpath_upload?>/odboard/odicons/privacyicon<?=$serialnum?>.gif" align="absmiddle" border="0">&nbsp;
<? 
		}
		else { 
?>
																	<img src="<?=$folderpath_upload?>/odboard/odicons/privacyicon.gif" align="absmiddle" border="0">&nbsp;
<? 
		} 
?>
																	<input type="file" name="privacyicon" size="57" class="border"><br><img src="" width="1" height="7"><br>
																	답변글 아이콘<br>
<? 
		if(file_exists("$folderpath_upload_root/odboard/odicons/reply_icon$serialnum.gif")) { 
?>
																	<img src="<?=$folderpath_upload?>/odboard/odicons/reply_icon<?=$serialnum?>.gif" align="absmiddle" border="0">&nbsp;
<? 
		}
		else { 
?>
																	<img src="<?=$folderpath_upload?>/odboard/odicons/reply_icon.gif" align="absmiddle" border="0">&nbsp;
<? 
		} 
?>
																	<input type="file" name="reply_icon" size="57" class="border"><br><img src="" width="1" height="7"><br>
																	테이블 바탕 이미지<br>
<? 
		if(file_exists("$folderpath_upload_root/odboard/odicons/backimg$serialnum.gif")) { 
?>
																	<img src="<?=$folderpath_upload?>/odboard/odicons/backimg<?=$serialnum?>.gif" align="absmiddle" border="0">&nbsp;
<? 
		}
		else { 
?>
																	<img src="<?=$folderpath_upload?>/odboard/odicons/backimg.gif" align="absmiddle" border="0">&nbsp;
<? 
		} 
?>
																	<input type="file" name="backimg" size="57" class="border"><br><img src="" width="1" height="7"><br>
																	테이블 구분선 이미지<br>
<? 
		if(file_exists("$folderpath_upload_root/odboard/odicons/line$serialnum.gif")) { 
?>
																	<img src="<?=$folderpath_upload?>/odboard/odicons/line<?=$serialnum?>.gif" align="absmiddle" border="0">&nbsp;
<? 
		}
		else { 
?>
																	<img src="<?=$folderpath_upload?>/odboard/odicons/line.gif" align="absmiddle" border="0">&nbsp;
<? 
		} 
?>
																	<input type="file" name="line" size="57" class="border"><br><img src="" width="1" height="7"><br>
																	테이블 바탕 색상으로
																	<input type="text" name="bgcolor" size="25" class="border" style="text-align:center;" value="D2CB35"> 을 지정합니다.<br><img src="" width="1" height="7"><br>
																	글목록(리스트) 버튼<br>
																	<img src="<?=$folderpath_upload?>/odboard/odicons/listicon.gif" align="absmiddle" border="0">&nbsp;
																	<input type="file" name="listicon" size="57" class="border"><br><img src="" width="1" height="5"><br>
																	글쓰기 버튼<br>
																	<img src="<?=$folderpath_upload?>/odboard/odicons/writeicon.gif" align="absmiddle" border="0">&nbsp;
																	<input type="file" name="writeicon" size="57" class="border"><br><img src="" width="1" height="5"><br>
																	글수정 버튼<br>
																	<img src="<?=$folderpath_upload?>/odboard/odicons/modifyicon.gif" align="absmiddle" border="0">&nbsp;
																	<input type="file" name="modifyicon" size="57" class="border"><br><img src="" width="1" height="5"><br>
																	답변글(Reply) 버튼<br>
																	<img src="<?=$folderpath_upload?>/odboard/odicons/replyicon.gif" align="absmiddle" border="0">&nbsp;
																	<input type="file" name="replyicon" size="57" class="border"><br><img src="" width="1" height="5"><br>
																	글삭제 버튼<br>
																	<img src="<?=$folderpath_upload?>/odboard/odicons/deleteicon.gif" align="absmiddle" border="0">&nbsp;
																	<input type="file" name="deleteicon" size="57" class="border"><br><img src="" width="1" height="5"><br>
																	검색 버튼<br>
<? 
		if(file_exists("$folderpath_upload_root/odboard/odicons/searchicon$serialnum.gif")) { 
?>
																	<img src="<?=$folderpath_upload?>/odboard/odicons/searchicon<?=$serialnum?>.gif" align="absmiddle" border="0">&nbsp;
<? 
		}
		else { 
?>
																	<img src="<?=$folderpath_upload?>/odboard/odicons/searchicon.gif" align="absmiddle" border="0">&nbsp;
<? 
		} 
?>
																	<input type="file" name="searchicon" size="57" class="border"><br><img src="" width="1" height="7"><br>
																	확인 버튼<br>
																	<img src="<?=$folderpath_upload?>/odboard/odicons/okicon.gif" align="absmiddle" border="0">&nbsp;
																	<input type="file" name="okicon" size="57" class="border"><br><img src="" width="1" height="5"><br>
																	취소 버튼<br>
																	<img src="<?=$folderpath_upload?>/odboard/odicons/cancelicon.gif" align="absmiddle" border="0">&nbsp;
																	<input type="file" name="cancelicon" size="57" class="border"><br><img src="" width="1" height="5"><br>
																</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="15" bgcolor="FFFFFF"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="1" cellpadding="0">
															<tr> 
																<td align="center">
																	<input type="image" src="../odimages/odmain/btn_ok.gif" width="77" height="24" hspace="3" style='cursor:hand;' onfocus='this.blur();'>
																	<a onclick="reset();" onfocus='this.blur();' style='cursor:hand;'><img src="../odimages/odmain/btn_cancel.gif" width="77" height="24" hspace="3" border="0"></a>
																	<a href="od_boardkindlist.php" onfocus='this.blur();'><img src="../odimages/btn_list.gif" hspace="3" border="0"></a></td>
															</tr>
															</form>
														</table>
													</td>
												</tr>
												<tr> 
													<td height="15" valign="top"></td>
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
<?
	}
	else if(!strcmp($form,"setupForm")) {
		## serialnum 구하기
		$result = mysql_query("SELECT IFNULL(max(serialnum),0)+1 as NMS FROM odtBoardConfig");
		$row = mysql_fetch_array($result);
		$serialnum = $row[NMS];
		
		## icon upload path
		$icon_upload_path = $folderpath_upload_root."/odboard/odicons";

		## new icon ###############################################################
		if(!$newicon) $newicon = "none";
		if($newicon != "none") {
			move_uploaded_file($newicon,"$icon_upload_path/$newicon_name");
			rename("$icon_upload_path/$newicon_name","$icon_upload_path/newicon$serialnum.gif");
		}
		## title icon ###############################################################
		if(!$titleicon) $titleicon = "none";
		if($titleicon != "none") {
			move_uploaded_file($titleicon,"$icon_upload_path/$titleicon_name");
			rename("$icon_upload_path/$titleicon_name","$icon_upload_path/titleicon$serialnum.gif");
		}
		## privacy icon ###############################################################
		if(!$privacyicon) $privacyicon = "none";
		if($privacyicon != "none") {
			move_uploaded_file($privacyicon,"$icon_upload_path/$privacyicon_name");
			rename("$icon_upload_path/$privacyicon_name","$icon_upload_path/privacyicon$serialnum.gif");
		}
		## reply_icon ###############################################################
		if(!$reply_icon) $reply_icon = "none";
		if($reply_icon != "none") {
			move_uploaded_file($reply_icon,"$icon_upload_path/$reply_icon_name");
			rename("$icon_upload_path/$reply_icon_name","$icon_upload_path/reply_icon$serialnum.gif");
		}
		## background image ###############################################################
		if(!$backimg) $backimg = "none";
		if($backimg != "none") {
			move_uploaded_file($backimg,"$icon_upload_path/$backimg_name");
			rename("$icon_upload_path/$backimg_name","$icon_upload_path/backimg$serialnum.gif");
		}
		## table line image ###############################################################
		if(!$line) $line = "none";
		if($line != "none") {
			move_uploaded_file($line,"$icon_upload_path/$line_name");
			rename("$icon_upload_path/$line_name","$icon_upload_path/line$serialnum.gif");
		}
		## list icon ###############################################################
		if(!$listicon) $listicon = "none";
		if($listicon != "none") {
			move_uploaded_file($listicon,"$icon_upload_path/$listicon_name");
			rename("$icon_upload_path/$listicon_name","$icon_upload_path/listicon$serialnum.gif");
		}
		## write icon ###############################################################
		if(!$writeicon) $writeicon = "none";
		if($writeicon != "none") {
			move_uploaded_file($writeicon,"$icon_upload_path/$writeicon_name");
			rename("$icon_upload_path/$writeicon_name","$icon_upload_path/writeicon$serialnum.gif");
		}
		## modify icon ###############################################################
		if(!$modifyicon) $modifyicon = "none";
		if($modifyicon != "none") {
			move_uploaded_file($modifyicon,"$icon_upload_path/$modifyicon_name");
			rename("$icon_upload_path/$modifyicon_name","$icon_upload_path/modifyicon$serialnum.gif");
		}
		## reply icon ###############################################################
		if(!$replyicon) $replyicon = "none";
		if($replyicon != "none") {
			move_uploaded_file($replyicon,"$icon_upload_path/$replyicon_name");
			rename("$icon_upload_path/$replyicon_name","$icon_upload_path/replyicon$serialnum.gif");
		}
		## delete icon ###############################################################
		if(!$deleteicon) $deleteicon = "none";
		if($deleteicon != "none") {
			move_uploaded_file($deleteicon,"$icon_upload_path/$deleteicon_name");
			rename("$icon_upload_path/$deleteicon_name","$icon_upload_path/deleteicon$serialnum.gif");
		}
		## ok icon ###############################################################
		if(!$okicon) $okicon = "none";
		if($okicon != "none") {
			move_uploaded_file($okicon,"$icon_upload_path/$okicon_name");
			rename("$icon_upload_path/$okicon_name","$icon_upload_path/okicon$serialnum.gif");
		}
		## cancel icon ###############################################################
		if(!$cancelicon) $cancelicon = "none";
		if($cancelicon != "none") {
			move_uploaded_file($cancelicon,"$icon_upload_path/$cancelicon_name");
			rename("$icon_upload_path/$cancelicon_name","$icon_upload_path/cancelicon$serialnum.gif");
		}
		## search icon ###############################################################
		if(!$searchicon) $searchicon = "none";
		if($searchicon != "none") {
			move_uploaded_file($searchicon,"$icon_upload_path/$searchicon_name");
			rename("$icon_upload_path/$searchicon_name","$icon_upload_path/searchicon$serialnum.gif");
		}
		
		$title_upload_path = $folderpath_upload_root."/odboard/odtitleimg";
		
		## boardtitle ###############################################################
		if(!$boardtitle) $boardtitle = "none";
		if($boardtitle != "none") {
			move_uploaded_file($boardtitle,"$title_upload_path/$boardtitle_name");
			rename("$title_upload_path/$boardtitle_name","$title_upload_path/title$serialnum.jpg");
		}

		$menu_upload_path = "../../upfiles/odboard/odmenu";
		
		if(!$Cboardmenu) $Cboardmenu = "none";
		if($Cboardmenu != "none") {
			move_uploaded_file($Cboardmenu,"$menu_upload_path/$Cboardmenu_name");
			rename("$menu_upload_path/$Cboardmenu_name","$menu_upload_path/Cboard_menu${serialnum}.jpg");
		}
		if(!$Cboardmenu_) $Cboardmenu_ = "none";
		if($Cboardmenu_ != "none") {
			move_uploaded_file($Cboardmenu_,"$menu_upload_path/$Cboardmenu__name");
			rename("$menu_upload_path/$Cboardmenu__name","$menu_upload_path/Cboard_menu${serialnum}_.jpg");
		}
		
		$boardname = addslashes(trim($boardname));
		$boardcomment = addslashes(trim($boardcomment));
		$inputdate = time();
		
		## 정렬순위 조정(신규로 등록하는 게시판을 1 진열순위로 준다.)
		mysql_query("UPDATE odtBoardConfig SET lineUp=lineUp+1");
		
		$result = mysql_query("INSERT INTO odtBoardConfig (serialnum,boardname,boardhidden,boardcomment,commentview,boardtype,readauthority,writeauthority,noticeauthority,replyused,noticeused,relationused,emailused,homepageused,privacyused,filenum,iconNew,bgcolor,inputdate,lineUp) VALUES ('$serialnum','$boardname','$boardhidden','$boardcomment','$commentview','$boardtype','$readauthority','$writeauthority','$noticeauthority','$replyused','$noticeused','$relationused','$emailused','$homepageused','$privacyused','$filenum','$iconNew','$bgcolor','$inputdate','1')");
		
		if($result) {
			echo "
				<script>
					window.alert('등록이 잘 되었습니다.   ');
				</script>";

			echo "<meta http-equiv='Refresh' content='0; URL=od_boardkindlist.php'>";
			exit;
		}
		else {
			echo "
				<script>
					window.alert('등록되지 않았습니다.   ');
					history.go(-1);
				</script>";

			exit;
		}
	}
	else {
		echo "<div align='center' class='fes'><br><br><br><br><font color='red'>허용되지 않은 접근 방식입니다.</font></div>";
		exit;
	}
?>