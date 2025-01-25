<?
	include "../../odcommon/od_config.inc.php";
	include "../odcommon/od_function.inc.php";		
	include "../odcommon/od_adminAuthority.inc.php";
	include "../odcommon/od_head.inc.php";
	include "../odcommon/od_body.inc.php";

	## 세부권한 체크
	if($row_admin[productLevel] < 3) {
		error_msgloc("../","접근권한이 없습니다.   ");
	}
	
?>
<script>

											function sourceFun(frm) {
												if(!confirm('소스를 수정하시겠습니까?')) return false;
											}
											
</script>
	<iframe name="hidden_frame" style='display:none'></iframe>
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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 디자인수정 > <span class="st">상단수정</span></font></td>
												</tr>
											</table>

											<table width="760" border="0" cellspacing="0" cellpadding="0">

												<tr> 
													<td colspan="3"><img src="../odimages/odmain/search_piece1.gif" width="760" height="8"></td>
												</tr>
												<tr> 
													<td width="6" background="../odimages/odmain/search_bg1.gif">&nbsp;</td>
													<td width="748" align="center" style="padding:10px;">
														<!-- search form start -->
														<table width="100%" border="0" cellspacing="1" cellpadding="0">
															<tr>
																<td style='font-size:11px;font-family:돋움'>
																- 쇼핑몰 전체의 레이아웃 및 디자인을 하실 수 있습니다.<br>
																- 주황색 네모박스를 클릭하면 디자인을 하실 수 있는곳으로 이동합니다.<br>
																- 아이템에 맞는 디자인으로 사이트를 이쁘게 꾸며 주세요.<br>
																</td>
															</tr>
														</table>
														<!-- search form end -->
													</td>
													<td width="6" background="../odimages/odmain/search_bg2.gif">&nbsp;</td>
												</tr>
												<tr> 
													<td colspan="3"><img src="../odimages/odmain/search_piece2.gif" width="760" height="8"></td>
												</tr>
											</table>

											<br>
											<br>
											<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td colspan=3><img src="/img/type5/dia_red_1.gif"> <b>이미지수정</b></td>
															</tr>
												<tr>
													<td style='border:3px solid #ff7f04' align=center><img src="/img/type5/type5_top_01.jpg" border=0 usemap="#topTmp">
													 <map name="topTmp" id="topTmp">
															<area shape="rect" coords="35,64,722,97" href="od_header_menu.php"/>
															<area shape="rect" coords="669,23,722,45" href="#none" onclick="window.open('./imgod_modify.php?mode=header_order','','width=700,height=250')"/>
															<area shape="rect" coords="625,23,670,45" href="#none" onclick="window.open('./imgod_modify.php?mode=header_mypage','','width=700,height=250')"/>
															<area shape="rect" coords="589,23,626,45" href="#none" onclick="window.open('./imgod_modify.php?mode=header_join','','width=700,height=250')"/>
															<area shape="rect" coords="556,23,590,45" href="#none" onclick="window.open('./imgod_modify.php?mode=header_login','','width=700,height=250')"/>
															<area shape="rect" coords="288,7,471,50" href="#none" onclick="window.open('./imgod_modify.php?mode=header_logo','','width=700,height=250')"/>
															<area shape="rect" coords="164,24,226,44" href="#none" onclick="window.open('./imgod_modify.php?mode=header_cs','','width=700,height=250')"/>
															<area shape="rect" coords="103,24,165,44" href="#none" onclick="window.open('./imgod_modify.php?mode=header_fav','','width=700,height=250')"/>
															<area shape="rect" coords="35,24,104,44" href="#none" onclick="window.open('./imgod_modify.php?mode=header_startpage','','width=700,height=250')"/>
														</map>													
													</td>
												</tr>
											</table>
											<br>
											<br>
											<form name="sourceFrm" method=post action='od_header_source_pro.php' target="hidden_frame" onsubmit="return sourceFun(this)">
											
											<table width=760 border=0 cellpadding=0 cellspacing=0>
												<tr>
													<td><img src="/img/type5/dia_red_1.gif"> <b>소스직접수정</b></td>
												</tr>
												<tr>
													<td width=760><textarea name="head_source" style='font-size:12px;font-family:돋움;width:100%;height:300px'><?=@mysql_result(mysql_query("select sd_header from odtDesign2 limit 1"),0);?></textarea>
												</tr>
												<tr>
													<td height=50 align=center><input type="image" src="/img/proSubmit.jpg" border=0></td>
												</tr>
											</table>

											</form>
											<br>
											<br>

											<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td colspan=3><img src="/img/type5/dia_red_1.gif"> <b>소스설명</b></td>
															</tr>
															<tr>
																<td colspan=3 style='padding:10px'>
																- 아래 코드를 참조하여 위 소스에서 메뉴를 삭제하거나, 위치를 수정하실수 있습니다.
												<tr> 
													<td colspan="3"><img src="../odimages/odmain/search_piece1.gif" width="760" height="8"></td>
												</tr>
												<tr> 
													<td width="6" background="../odimages/odmain/search_bg1.gif">&nbsp;</td>
													<td width="748" align="center" style="padding:10px;">
														<!-- search form start -->
														<table width="100%" border="0" cellspacing="1" cellpadding="5">
															<tr>
																<td width=100>[STARTPAGE]</td>
																<td>시작페이지</td>
															</tr>
															<tr>
																<td>[FAV]</td>
																<td>즐겨찾기</td>
															</tr>
															<tr>
																<td>[LOGO]</td>
																<td>로고</td>
															</tr>
															<tr>
																<td>[LOGOUT]</td>
																<td>로그아웃버튼</td>
															</tr>
															<tr>
																<td>[MODIFY]</td>
																<td>정보수정보튼</td>
															</tr>
															<tr>
																<td>[MYPAGE1]</td>
																<td>마이페이지(로그인시)</td>
															</tr>
															<tr>
																<td>[ORDER1]</td>
																<td>주문배송조회(로그인시)</td>
															</tr>
															<tr>
																<td>[LOGIN]</td>
																<td>로그인버튼</td>
															</tr>
															<tr>
																<td>[JOIN]</td>
																<td>회원가입</td>
															</tr>
															<tr>
																<td>[MYPAGE2]</td>
																<td>마이페이지(로그아웃시)</td>
															</tr>
															<tr>
																<td>[ORDER2]</td>
																<td>주문배송조회(로그아웃시)</td>
															</tr>
															<tr>
																<td>[TODAY]</td>
																<td>TODAY 메뉴버튼</td>
															</tr>
															<tr>
																<td>[THREE]</td>
																<td>THREE 메뉴버튼</td>
															</tr>
															<tr>
																<td>[FIVE]</td>
																<td>FIVE 메뉴버튼</td>
															</tr>
															<tr>
																<td>[WEEK]</td>
																<td>WEEK 메뉴버튼</td>
															</tr>
															<tr>
																<td>[MEDIA]</td>
																<td>MEDIA 메뉴버튼</td>
															</tr>
															<tr>
																<td>[MART]</td>
																<td>MART 메뉴버튼</td>
															</tr>
															<tr>
																<td>[COMMUNITY]</td>
																<td>커뮤니티 메뉴버튼</td>
															</tr>
															<tr>
																<td>[LINEBG]</td>
																<td>메뉴 밑 라인색깔</td>
															</tr>
														</table>
														<!-- search form end -->
													</td>
													<td width="6" background="../odimages/odmain/search_bg2.gif">&nbsp;</td>
												</tr>
												<tr> 
													<td colspan="3"><img src="../odimages/odmain/search_piece2.gif" width="760" height="8"></td>
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
