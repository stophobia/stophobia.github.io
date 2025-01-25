<?
	# 2011-01-21 오전 10:50 박종익 수정중
	include "../../odcommon/od_config.inc.php";
	include "../odcommon/od_function.inc.php";	
	include "../odcommon/od_adminAuthority.inc.php";
	include "../odcommon/od_head.inc.php";
	include "../odcommon/od_body.inc.php";

	## 세부권한 체크
	if($row_admin[boardLevel]==5 || $row_admin[boardLevel]==9 || $row_admin[superLevel]==9) {
	}else {
		error_msgloc("../","접근권한이 없습니다.   ");
	}
	if(!$form) {
		$row = mysql_fetch_array(mysql_query("SELECT * FROM odtBoardConfig WHERE serialnum=$serialnum"));
		
		$titleimgTemp = file_exists("../../upfiles/odboard/odtitleimg/title$row[serialnum].jpg");
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
                      <td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 
                        일반관리 &gt; <span class="st">게시판 정보변경</span></font></td>
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
						<!-- form start ------------------------------------------------------------------------------------------>
						<form name="snsForm" method="post" action="od_boardkindmodify.php" enctype="multipart/form-data" onSubmit="return valueCheck(this)">
						<input type="hidden" name="form" value="setupForm">
						<input type="hidden" name="serialnum" value="<?=$serialnum?>">
                          <tr> 
                            <td height="1" bgcolor="c0bebe"></td>
                            <td width="600" height="1" bgcolor="#D5D5D5"></td>
                          </tr>
                          <tr> 
                            <td width="150" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">게시판 이름</td>
                            <td bgcolor="FAFAFA" style="padding:5px;"> 
							  &nbsp;<input type="text" name="boardname" class="border" size="55" value="<?=stripslashes($row[boardname])?>"><br>
							  <img src="blank.gif" width="1" height="3"><br><font color="313D7D">
							  &nbsp;* 게시판 이름을 입력 합니다.</font></td>
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
							  <input type="radio" name="boardtype" value="Board" <?if($row[boardtype]=="Board")echo" checked";?>>일반(자료실)게시판<br>
							  <img src="blank.gif" width="1" height="3"><br><font color="313D7D">
							  &nbsp;* 신규로 등록하실 게시판의 종류를 설정 합니다.</font></td>
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
							  <input type="radio" name="readauthority" value="nobody" <?if($row[readauthority]=="nobody")echo" checked";?>>전체(회원+비회원) 
							  <input type="radio" name="readauthority" value="member" <?if($row[readauthority]=="member")echo" checked";?>>일반회원
							  <input type="radio" name="readauthority" value="manager" <?if($row[readauthority]=="manager")echo" checked";?>>관리자<br>
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
							  <input type="radio" name="writeauthority" value="nobody" <?if($row[writeauthority]=="nobody")echo" checked";?>>전체(회원+비회원)
							  <input type="radio" name="writeauthority" value="member" <?if($row[writeauthority]=="member")echo" checked";?>>일반회원
							  <input type="radio" name="writeauthority" value="manager" <?if($row[writeauthority]=="manager")echo" checked";?>>관리자<br>
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
							  <input type="radio" name="noticeauthority" value="nobody" <?if($row[noticeauthority]=="nobody")echo" checked";?>>전체(회원+비회원)
							  <input type="radio" name="noticeauthority" value="member" <?if($row[noticeauthority]=="member")echo" checked";?>>일반회원
							  <input type="radio" name="noticeauthority" value="manager" <?if($row[noticeauthority]=="manager")echo" checked";?>>관리자<br>
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
							  <input type="radio" name="filenum" value="0" <?if($row[filenum]=="0")echo" checked";?>>사용하지않음&nbsp;
							  <input type="radio" name="filenum" value="1" <?if($row[filenum]=="1")echo" checked";?>>1개&nbsp;
							  <input type="radio" name="filenum" value="2" <?if($row[filenum]=="2")echo" checked";?>>2개&nbsp;
							  <input type="radio" name="filenum" value="3" <?if($row[filenum]=="3")echo" checked";?>>3개&nbsp;
							  <input type="radio" name="filenum" value="4" <?if($row[filenum]=="4")echo" checked";?>>4개&nbsp;
							  <input type="radio" name="filenum" value="5" <?if($row[filenum]=="5")echo" checked";?>>5개<br>
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
							  <input type="radio" name="privacyused" value="Yes" <?if($row[privacyused]=="Yes")echo" checked";?>>비밀글 사용함
							  <input type="radio" name="privacyused" value="No" <?if($row[privacyused]=="No")echo" checked";?>>비밀글 사용하지 않음<br>
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
                                  <td bgcolor="ececec" class="white" style="padding:5px;" width="146"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">답변글(Reply) 사용</td>
                                  <td bgcolor="FAFAFA" style="padding:5px;" width="222"> 
                                    <input type="radio" name="replyused" value="Yes" <?if($row[replyused]=="Yes")echo" checked";?>>사용함 
                                    <input type="radio" name="replyused" value="No" <?if($row[replyused]=="No")echo" checked";?>>사용하지않음</td>
                                  <td bgcolor="ececec" class="white" style="padding:5px;" width="160"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">댓글 사용</td>
                                  <td bgcolor="FAFAFA" style="padding:5px;" width="220"> 
                                    <input type="radio" name="noticeused" value="Yes" <?if($row[noticeused]=="Yes")echo" checked";?>>사용함 
                                    <input type="radio" name="noticeused" value="No" <?if($row[noticeused]=="No")echo" checked";?>>사용하지않음</td>
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
                                  <td bgcolor="ececec" class="white" style="padding:5px;" width="146"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">관련글 사용</td>
                                  <td bgcolor="FAFAFA" style="padding:5px;" width="222"> 
                                    <input type="radio" name="relationused" value="Yes" <?if($row[relationused]=="Yes")echo" checked";?>>사용함 
                                    <input type="radio" name="relationused" value="No" <?if($row[relationused]=="No")echo" checked";?>>사용하지않음</td>
                                  <td bgcolor="ececec" class="white" style="padding:5px;" width="160"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">Email 사용</td>
                                  <td bgcolor="FAFAFA" style="padding:5px;" width="220"> 
                                    <input type="radio" name="emailused" value="Yes" <?if($row[emailused]=="Yes")echo" checked";?>>사용함 
                                    <input type="radio" name="emailused" value="No" <?if($row[emailused]=="No")echo" checked";?>>사용하지않음</td>
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
                                  <td bgcolor="ececec" class="white" style="padding:5px;" width="145"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">Homepage 사용</td>
                                  <td bgcolor="FAFAFA" style="padding:5px;" width="223"> 
                                    <input type="radio" name="homepageused" value="Yes" <?if($row[homepageused]=="Yes")echo" checked";?>>사용함 
                                    <input type="radio" name="homepageused" value="No" <?if($row[homepageused]=="No")echo" checked";?>>사용하지않음</td>
                                  <td bgcolor="ececec" class="white" style="padding:5px;" width="160"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">게시판설명 보여주기</td>
                                  <td bgcolor="FAFAFA" style="padding:5px;" width="220"> 
                                    <input type="radio" name="commentview" value="Yes" <?if($row[commentview]=="Yes")echo" checked";?>>사용함 
                                    <input type="radio" name="commentview" value="No" <?if($row[commentview]=="No")echo" checked";?>>사용하지않음</td>
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
							        &nbsp;<textarea name="boardcomment" class="border" rows="7" cols="93"><?=stripslashes($row[boardcomment])?></textarea></td>
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
							  <font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5"><b>게시판 아이콘 및 버튼</b>을 설정합니다.</font></td>
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
                            <td height="1" bgcolor="#D5D5D5"></td>
                          </tr>
                          <tr> 
                            <td width="140" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">게시판 관련 버튼</td>
                            <td bgcolor="FAFAFA" style="padding:5px;">

							  글작성일을  기준으로
							  <input type="text" name="iconNew" size="5" class="border" style="text-align:right;" value="<?=$row[iconNew]?>"> 일 이내인 글에 표시합니다.<br>
							  <? if(file_exists("../../upfiles/odboard/odicons/newicon$serialnum.gif")) { ?>
							  <img src="../../upfiles/odboard/odicons/newicon<?=$serialnum?>.gif" align="absmiddle" border="0">&nbsp;
							  <? }else { ?>
							  <img src="../../upfiles/odboard/odicons/newicon.gif" align="absmiddle" border="0">&nbsp;
							  <? } ?>
							  <input type="file" name="newicon" size="57" class="border"><br><img src="" width="1" height="7"><br>

							  타이틀 이미지<br>
							  <? if(file_exists("../../upfiles/odboard/odicons/titleicon$serialnum.gif")) { ?>
							  <img src="../../upfiles/odboard/odicons/titleicon<?=$serialnum?>.gif" align="absmiddle" border="0">&nbsp;
							  <? }else { ?>
							  <img src="../../upfiles/odboard/odicons/titleicon.gif" align="absmiddle" border="0">&nbsp;
							  <? } ?>
							  <input type="file" name="titleicon" size="57" class="border"><br><img src="" width="1" height="7"><br>

							  비밀글 아이콘<br>
							  <? if(file_exists("../../upfiles/odboard/odicons/privacyicon$serialnum.gif")) { ?>
							  <img src="../../upfiles/odboard/odicons/privacyicon<?=$serialnum?>.gif" align="absmiddle" border="0">&nbsp;
							  <? }else { ?>
							  <img src="../../upfiles/odboard/odicons/privacyicon.gif" align="absmiddle" border="0">&nbsp;
							  <? } ?>
							  <input type="file" name="privacyicon" size="57" class="border"><br><img src="" width="1" height="7"><br>

							  답변글 아이콘<br>
							  <? if(file_exists("../../upfiles/odboard/odicons/reply_icon$serialnum.gif")) { ?>
							  <img src="../../upfiles/odboard/odicons/reply_icon<?=$serialnum?>.gif" align="absmiddle" border="0">&nbsp;
							  <? }else { ?>
							  <img src="../../upfiles/odboard/odicons/reply_icon.gif" align="absmiddle" border="0">&nbsp;
							  <? } ?>
							  <input type="file" name="reply_icon" size="57" class="border"><br><img src="" width="1" height="7"><br>
							  <!------ 2006-06-15
							  테이블 바탕 이미지<br>
							  <? if(file_exists("../../upfiles/odboard/odicons/backimg$serialnum.gif")) { ?>
							  <img src="../../upfiles/odboard/odicons/backimg<?=$serialnum?>.gif" align="absmiddle" border="0">&nbsp;
							  <? }else { ?>
							  <img src="../../upfiles/odboard/odicons/backimg.gif" align="absmiddle" border="0">&nbsp;
							  <? } ?>
							  <input type="file" name="backimg" size="57" class="border"><br><img src="" width="1" height="7"><br>

							  테이블 구분선 이미지<br>
							  <? if(file_exists("../../upfiles/odboard/odicons/line$serialnum.gif")) { ?>
							  <img src="../../upfiles/odboard/odicons/line<?=$serialnum?>.gif" align="absmiddle" border="0">&nbsp;
							  <? }else { ?>
							  <img src="../../upfiles/odboard/odicons/line.gif" align="absmiddle" border="0">&nbsp;
							  <? } ?>
							  <input type="file" name="line" size="57" class="border"><br><img src="" width="1" height="7"><br>

							  테이블 바탕 색상으로
							  <input type="text" name="bgcolor" size="25" class="border" style="text-align:center;" value="<?=$row[bgcolor]?>"> 을 지정합니다.<br><img src="" width="1" height="7"><br>
							  ------>
							  글목록(리스트) 버튼<br>
							  <? if(file_exists("../../upfiles/odboard/odicons/listicon$serialnum.gif")) { ?>
							  <img src="../../upfiles/odboard/odicons/listicon<?=$serialnum?>.gif" align="absmiddle" border="0">&nbsp;
							  <? }else { ?>
							  <img src="../../upfiles/odboard/odicons/listicon.gif" align="absmiddle" border="0">&nbsp;
							  <? } ?>
							  <input type="file" name="listicon" size="57" class="border"><br><img src="" width="1" height="7"><br>

							  글쓰기 버튼<br>
							  <? if(file_exists("../../upfiles/odboard/odicons/writeicon$serialnum.gif")) { ?>
							  <img src="../../upfiles/odboard/odicons/writeicon<?=$serialnum?>.gif" align="absmiddle" border="0">&nbsp;
							  <? }else { ?>
							  <img src="../../upfiles/odboard/odicons/writeicon.gif" align="absmiddle" border="0">&nbsp;
							  <? } ?>
							  <input type="file" name="writeicon" size="57" class="border"><br><img src="" width="1" height="7"><br>

							  글수정 버튼<br>
							  <? if(file_exists("../../upfiles/odboard/odicons/modifyicon$serialnum.gif")) { ?>
							  <img src="../../upfiles/odboard/odicons/modifyicon<?=$serialnum?>.gif" align="absmiddle" border="0">&nbsp;
							  <? }else { ?>
							  <img src="../../upfiles/odboard/odicons/modifyicon.gif" align="absmiddle" border="0">&nbsp;
							  <? } ?>
							  <input type="file" name="modifyicon" size="57" class="border"><br><img src="" width="1" height="7"><br>

							  답변글(Reply) 버튼<br>
							  <? if(file_exists("../../upfiles/odboard/odicons/replyicon$serialnum.gif")) { ?>
							  <img src="../../upfiles/odboard/odicons/replyicon<?=$serialnum?>.gif" align="absmiddle" border="0">&nbsp;
							  <? }else { ?>
							  <img src="../../upfiles/odboard/odicons/replyicon.gif" align="absmiddle" border="0">&nbsp;
							  <? } ?>
							  <input type="file" name="replyicon" size="57" class="border"><br><img src="" width="1" height="7"><br>

							  글삭제 버튼<br>
							  <? if(file_exists("../../upfiles/odboard/odicons/deleteicon$serialnum.gif")) { ?>
							  <img src="../../upfiles/odboard/odicons/deleteicon<?=$serialnum?>.gif" align="absmiddle" border="0">&nbsp;
							  <? }else { ?>
							  <img src="../../upfiles/odboard/odicons/deleteicon.gif" align="absmiddle" border="0">&nbsp;
							  <? } ?>
							  <input type="file" name="deleteicon" size="57" class="border"><br><img src="" width="1" height="7"><br>

							  검색 버튼<br>
							  <? if(file_exists("../../upfiles/odboard/odicons/searchicon$serialnum.gif")) { ?>
							  <img src="../../upfiles/odboard/odicons/searchicon<?=$serialnum?>.gif" align="absmiddle" border="0">&nbsp;
							  <? }else { ?>
							  <img src="../../upfiles/odboard/odicons/searchicon.gif" align="absmiddle" border="0">&nbsp;
							  <? } ?>
							  <input type="file" name="searchicon" size="57" class="border"><br><img src="" width="1" height="7"><br>

							  확인 버튼<br>
							  <? if(file_exists("../../upfiles/odboard/odicons/okicon$serialnum.gif")) { ?>
							  <img src="../../upfiles/odboard/odicons/okicon<?=$serialnum?>.gif" align="absmiddle" border="0">&nbsp;
							  <? }else { ?>
							  <img src="../../upfiles/odboard/odicons/okicon.gif" align="absmiddle" border="0">&nbsp;
							  <? } ?>
							  <input type="file" name="okicon" size="57" class="border"><br><img src="" width="1" height="7"><br>

							  취소 버튼<br>
							  <? if(file_exists("../../upfiles/odboard/odicons/cancelicon$serialnum.gif")) { ?>
							  <img src="../../upfiles/odboard/odicons/cancelicon<?=$serialnum?>.gif" align="absmiddle" border="0">&nbsp;
							  <? }else { ?>
							  <img src="../../upfiles/odboard/odicons/cancelicon.gif" align="absmiddle" border="0">&nbsp;
							  <? } ?>
							  <input type="file" name="cancelicon" size="57" class="border"><br><img src="" width="1" height="7"><br>
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
	  <? include "../odcommon/od_bottom.inc.php"; ?>
	  <!-- bottom end -->
	</td>
  </tr>
</table>
	</body>
</html>
<?
	}
	else if(!strcmp($form,"setupForm")) {
		## icon upfiles path
		$icon_upfiles_path = "../../upfiles/odboard/odicons";
		
		## new icon ###############################################################
		if(!$newicon) $newicon = "none";
		if($newicon != "none") {
			move_upfilesed_file($newicon,"$icon_upfiles_path/$newicon_name");
			rename("$icon_upfiles_path/$newicon_name","$icon_upfiles_path/newicon$serialnum.gif");
		}
		## title icon ###############################################################
		if(!$titleicon) $titleicon = "none";
		if($titleicon != "none") {
			move_upfilesed_file($titleicon,"$icon_upfiles_path/$titleicon_name");
			rename("$icon_upfiles_path/$titleicon_name","$icon_upfiles_path/titleicon$serialnum.gif");
		}
		## privacy icon ###############################################################
		if(!$privacyicon) $privacyicon = "none";
		if($privacyicon != "none") {
			move_upfilesed_file($privacyicon,"$icon_upfiles_path/$privacyicon_name");
			rename("$icon_upfiles_path/$privacyicon_name","$icon_upfiles_path/privacyicon$serialnum.gif");
		}
		## reply_icon ###############################################################
		if(!$reply_icon) $reply_icon = "none";
		if($reply_icon != "none") {
			move_upfilesed_file($reply_icon,"$icon_upfiles_path/$reply_icon_name");
			rename("$icon_upfiles_path/$reply_icon_name","$icon_upfiles_path/reply_icon$serialnum.gif");
		}
		## background image ###############################################################
		if(!$backimg) $backimg = "none";
		if($backimg != "none") {
			move_upfilesed_file($backimg,"$icon_upfiles_path/$backimg_name");
			rename("$icon_upfiles_path/$backimg_name","$icon_upfiles_path/backimg$serialnum.gif");
		}
		## table line image ###############################################################
		if(!$line) $line = "none";
		if($line != "none") {
			move_upfilesed_file($line,"$icon_upfiles_path/$line_name");
			rename("$icon_upfiles_path/$line_name","$icon_upfiles_path/line$serialnum.gif");
		}
		## list icon ###############################################################
		if(!$listicon) $listicon = "none";
		if($listicon != "none") {
			move_upfilesed_file($listicon,"$icon_upfiles_path/$listicon_name");
			rename("$icon_upfiles_path/$listicon_name","$icon_upfiles_path/listicon$serialnum.gif");
		}
		## write icon ###############################################################
		if(!$writeicon) $writeicon = "none";
		if($writeicon != "none") {
			move_upfilesed_file($writeicon,"$icon_upfiles_path/$writeicon_name");
			rename("$icon_upfiles_path/$writeicon_name","$icon_upfiles_path/writeicon$serialnum.gif");
		}
		## modify icon ###############################################################
		if(!$modifyicon) $modifyicon = "none";
		if($modifyicon != "none") {
			move_upfilesed_file($modifyicon,"$icon_upfiles_path/$modifyicon_name");
			rename("$icon_upfiles_path/$modifyicon_name","$icon_upfiles_path/modifyicon$serialnum.gif");
		}
		## reply icon ###############################################################
		if(!$replyicon) $replyicon = "none";
		if($replyicon != "none") {
			move_upfilesed_file($replyicon,"$icon_upfiles_path/$replyicon_name");
			rename("$icon_upfiles_path/$replyicon_name","$icon_upfiles_path/replyicon$serialnum.gif");
		}
		## delete icon ###############################################################
		if(!$deleteicon) $deleteicon = "none";
		if($deleteicon != "none") {
			move_upfilesed_file($deleteicon,"$icon_upfiles_path/$deleteicon_name");
			rename("$icon_upfiles_path/$deleteicon_name","$icon_upfiles_path/deleteicon$serialnum.gif");
		}
		## search icon ###############################################################
		if(!$searchicon) $searchicon = "none";
		if($searchicon != "none") {
			move_upfilesed_file($searchicon,"$icon_upfiles_path/$searchicon_name");
			rename("$icon_upfiles_path/$searchicon_name","$icon_upfiles_path/searchicon$serialnum.gif");
		}
		## ok icon ###############################################################
		if(!$okicon) $okicon = "none";
		if($okicon != "none") {
			move_upfilesed_file($okicon,"$icon_upfiles_path/$okicon_name");
			rename("$icon_upfiles_path/$okicon_name","$icon_upfiles_path/okicon$serialnum.gif");
		}
		## cancel icon ###############################################################
		if(!$cancelicon) $cancelicon = "none";
		if($cancelicon != "none") {
			move_upfilesed_file($cancelicon,"$icon_upfiles_path/$cancelicon_name");
			rename("$icon_upfiles_path/$cancelicon_name","$icon_upfiles_path/cancelicon$serialnum.gif");
		}
		
		$boardname = addslashes(trim($boardname));
		$boardcomment = addslashes(trim($boardcomment));
		
		$title_upfiles_path = "../../upfiles/odboard/odtitleimg";
		
		## boardtitle ###############################################################
		if(!$boardtitle) $boardtitle = "none";
		if($boardtitle != "none") {
			move_upfilesed_file($boardtitle,"$title_upfiles_path/$boardtitle_name");
			rename("$title_upfiles_path/$boardtitle_name","$title_upfiles_path/title$serialnum.jpg");
		}

		$menu_upfiles_path = "../../upfiles/odboard/odmenu";

		if(!$Mboardmenu) $Mboardmenu = "none";
		if($Mboardmenu != "none") {
			move_upfilesed_file($Mboardmenu,"$menu_upfiles_path/$Mboardmenu_name");
			rename("$menu_upfiles_path/$Mboardmenu_name","$menu_upfiles_path/Mboard_menu${serialnum}.jpg");
		}
		if(!$Mboardmenu_) $Mboardmenu_ = "none";
		if($Mboardmenu_ != "none") {
			move_upfilesed_file($Mboardmenu_,"$menu_upfiles_path/$Mboardmenu__name");
			rename("$menu_upfiles_path/$Mboardmenu__name","$menu_upfiles_path/Mboard_menu${serialnum}_.jpg");
		}
		if(!$Cboardmenu) $Cboardmenu = "none";
		if($Cboardmenu != "none") {
			move_upfilesed_file($Cboardmenu,"$menu_upfiles_path/$Cboardmenu_name");
			rename("$menu_upfiles_path/$Cboardmenu_name","$menu_upfiles_path/Cboard_menu${serialnum}.jpg");
		}
		if(!$Cboardmenu_) $Cboardmenu_ = "none";
		if($Cboardmenu_ != "none") {
			move_upfilesed_file($Cboardmenu_,"$menu_upfiles_path/$Cboardmenu__name");
			rename("$menu_upfiles_path/$Cboardmenu__name","$menu_upfiles_path/Cboard_menu${serialnum}_.jpg");
		}
		
		$modifydate = time();
		
		$result = mysql_query("UPDATE odtBoardConfig SET boardname='$boardname',boardhidden='$boardhidden',boardcomment='$boardcomment',commentview='$commentview',boardtype='$boardtype',readauthority='$readauthority',writeauthority='$writeauthority',noticeauthority='$noticeauthority',replyused='$replyused',noticeused='$noticeused',relationused='$relationused',emailused='$emailused',homepageused='$homepageused',privacyused='$privacyused',filenum='$filenum',iconNew='$iconNew',bgcolor='$bgcolor',modifydate='$modifydate' WHERE serialnum='$serialnum'");
		
		if($result) {
			echo "
				<script>
					window.alert('수정이 잘 되었습니다.   ');
				</script>";

			echo "<meta http-equiv='Refresh' content='0; URL=od_boardkindlist.php'>";
			exit;
		}
		else {
			echo "
				<script>
					window.alert('수정되지 않았습니다.   ');
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