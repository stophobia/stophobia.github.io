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
													<td  align=center><img src="/img/type5/type5_menu_01.jpg" border=0 usemap="#menuTmp">
													<map name="menuTmp" id="menuTmp">
  <area shape="rect" coords="600,0,729,26" href="#none" onclick="window.open('./menuod_modify.php?mode=menu_community','','width=700,height=300')"/>
  <area shape="rect" coords="498,0,596,26" href="#none" onclick="window.open('./menuod_modify.php?mode=menu_mart','','width=700,height=300')"/>
  <area shape="rect" coords="396,0,494,26" href="#none" onclick="window.open('./menuod_modify.php?mode=menu_media','','width=700,height=300')"/>
  <area shape="rect" coords="295,0,393,26" href="#none" onclick="window.open('./menuod_modify.php?mode=menu_week','','width=700,height=300')"/>
  <area shape="rect" coords="198,0,296,26" href="#none" onclick="window.open('./menuod_modify.php?mode=menu_five','','width=700,height=300')"/>
  <area shape="rect" coords="100,0,198,26" href="#none" onclick="window.open('./menuod_modify.php?mode=menu_three','','width=700,height=300')"/>
  <area shape="rect" coords="0,0,98,26"  href="#none" onclick="window.open('./menuod_modify.php?mode=menu_today','','width=700,height=300')"/>
</map>
								
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
