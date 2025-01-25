<?
	# 다음방송일 추출
	$que4 = "select live_start_time from odtProduct where cateCode ='03' and live_start_time > '".date('Y-m-d H:i:s')."' order by live_start_time asc limit 1";
	$nextTime	= @mysql_result(mysql_query($que4),0);
?>


<script>
function layerView(name) {
	obj = document.getElementById(name);

	// 레이어 컨트롤
	if(obj.style.visibility == "") {
		obj.style.visibility = "hidden";
	} else {
		obj.style.visibility = "";
	}

	iconOnOff(name);
}

function iconOnOff(name) {
	// 이미지 on off
	obj2 = document.getElementById(name+"_2");
	src2 = String(obj2.src)
	if(src2.match('_on_')) {
		obj2.src = src2.replace('_on_','_off_');
	} else {
		obj2.src = src2.replace('_off_','_on_');
	}
}

function reset(name) {
	var nameArray = ['layerIcon','layerFont','layerPalette','layerNick'];
	for(i=0;i<nameArray.length;i++) {
		if(nameArray[i] != name) {
			obj = document.getElementById(nameArray[i]);
			obj.style.visibility = "hidden";

			obj2 = document.getElementById(nameArray[i]+"_2");
			src2 = String(obj2.src)
			obj2.src = src2.replace('_on_','_off_');

		}
	}
}
function printIcon(icon) {
	frm = document.form;
	frm.chatmsg.value += "/"+icon+"/";
	frm.chatmsg.focus();
	return;
}

function nickNameChangeFun(obj) {
	frm = document.form;
	if(event.keyCode == 13) {
		// 빈값일때 리턴
		if(obj.value.trim()) {
			frm.nickName.value = obj.value;
			layerView('layerNick');
			hidden_frame.location.href='/pages/etc/chatUpdate.php?type=nick&nick='+encodeURIComponent(obj.value);
			return false;
		} else {
			alert('닉네임을 입력하세요');
		}
	}
}


function colorChangeFun(color) {
	frm = document.form;
	frm.color.value = color;
	hidden_frame.location.href='/pages/etc/chatUpdate.php?type=color&color='+encodeURIComponent(color);
	layerView('layerPalette')
}

function fontChangeFun(font) {
	frm = document.form;
	frm.font.value = font;
	layerView('layerFont');
}
</script>

											<table width=428 border=0 cellpadding=0 cellspacing=0>
												<tr>
													<td width=428 height=2 background="/images/tv2_11.jpg"></td>
												</tr>
												<tr>
													<td  height=70 background="/images/tv2_15.jpg"><table border=0 cellpadding=0 cellspacing=0>
															<tr>
																<td width=227 style="color:eaede6;padding-left:10px;font-size:15px;font-weight:bold;font-family:굴림"><?=[mainName] ? [mainName] : [name];?></td>
<?
if($row_member[id]) {
?>
																<td rowspan=2 style="padding-right:10px;"><a href="/odprogram/products/od_order.php?code=<?=[code]?>"><img src="/images/buybtn_17.jpg" border=0></a></td>
<?
} else {
?>
																<td rowspan=2 style="padding-right:10px;"><a href="/odprogram/odlogon/od_login.php?path=<?=urlencode("/odprogram/products/od_order.php?code=".[code])?>&buyMode=live"><img src="/images/buybtn_17.jpg" border=0></a></td>
<?
}
?>
															</tr>
															<tr>
																<td style="color:ff2919;font-weight:bold;font-family:굴림;font-size:28px;padding-left:10px">
																<img src="/images/box_live.gif">
<?
$minPrice = @mysql_result(mysql_query("select price-live_sale from odtProduct where parent_code ='".[parent_code]."' order by mainPrice=1 desc, price-live_sale asc limit 1"),0);

$priceTmp = number_format($minPrice);
for($zz=0;$zz<strlen($priceTmp);$zz++) {
	echo "<img src='/images/num".substr($priceTmp,$zz,1).".jpg'>";
}	
?><img src="/images/won.jpg"></td>
															</tr>
														</table></td>
												</tr>
												<tr>
													<td  height=40 background="/images/tv2_17_.jpg">
													<!-- 카운터 -->
														<script type="text/javascript">
														AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','428','height','40','src','/flash/live_count','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','/flash/live_count' ); //end AC code
														</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0"  width="428" height="40">
															<param name="movie" value="/flash/live_count.swf" />
															<param name="quality" value="high" />
															<embed src="/flash/live_count.swf" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="428" height="40"></embed>
														</object></noscript>
													<!-- 카운터 끝 -->																												
													</td>
												</tr>
												<tr>
													<td  height=26 ><table border=0 cellpadding=0 cellspacing=0 width=428 height=26>
														<tr>
															<td width=3 height=26 background="/images/tv2_18.jpg"></td>
															<td width=422 background="/images/tv2_19.jpg" style="color:#ffffff;font-weight:bold;" align=center>*  라이브방송 중에는 <font color="07d2fe">특별할인가로</font> 판매하고 있습니다. * </td>
															<td width=3 height=26 background="/images/tv2_21.jpg"></td>
														</tr>
													</table></td>
												</tr>

												<tr>
													<td height=218 background="/images/tv2_22.jpg" style="padding-left:2px" valign=middle><div id='chat'  class="chatStyle"></div></td>
												</tr>
												<tr>
													<td  height=27 background="/images/tv2_29.jpg" valign=top><table border=0 cellpadding=0 cellspacing=0>
														<tr>
															<td width=2 height=27 background="/images/chaticon_32.gif"></td>
															<td width=30 ><a href="#none" onclick="layerView('layerIcon');reset('layerIcon')"><img  id='layerIcon_2' src="/images/chaticon_33_off_.gif" border=0></a><div id='layerIcon' style="position:relative;left:0px;top:0px;visibility:hidden" ><div  style='position:absolute; left:0; top:0; visibility:; z-index:3;'>	
																		<table width=100 border=0 cellpadding=0 cellspacing=0 style="border:1px solid #bbe061" bgcolor="#FFFFFFF">
																			<tr> 
																				<td height=15 style="padding-left:4px"  width=80><table border=0 cellpadding=0 cellspacing=0>
																						<tr> 
																							<td width=80  height=15 style="font-size:11;font-family:돋움;color:bfbfbf">이모티콘 
																								설정</td>
																							<td><a href="#none" onclick="layerView('layerIcon')"><img src="/images/chat_16.gif" border></a></td>
																						</tr>
																					</table></td>
																			</tr>
																			<tr> 
																				<td height=1 style="padding-left:2px"><table border=0 cellpadding=0 cellspacing=0>
																						<tr> 
																							<td height=1 width=94 bgcolor="ededed"></td>
																						</tr>
																					</table></td>
																			</tr>
																			<tr> 
																				<td><table border=0 cellpadding=0 cellspacing=0>
																						<tr> 
																							<?
																														$iconKey = array_keys($iconArray);
																														for($i=0;$i<count($iconKey);$i++) {
																																		if($i != 0 && $i % 5 == 0) echo "</tr><tr>";
																														?>
																							<td width=26 height=26 align=center><a href="#none" onclick="printIcon('<?=$iconKey[$i]?>');layerView('layerIcon');"><img src="/images/icon/<?=$iconArray[$iconKey[$i]]?>.gif" border=0 title='<?=$iconKey[$i]?>'></a></td>
																							<?
																														}
																														?>
																						</tr>
																					</table></td>
																			</tr>
																		</table>
																	</div>
																</div></td>
															<td width=1  bgcolor="070707"></td>
															<td width=30 ><a href="#none" onclick="layerView('layerFont');reset('layerFont');"><img id='layerFont_2' src="/images/chaticon_35_off_.gif" border=0></a><div id='layerFont' style="position:relative;left:0px;top:0px;visibility:hidden" ><div  style='position:absolute; left:0; top:0; visibility:; z-index:3;'>	
																	<table width=70  border=0 cellpadding=0 cellspacing=0 style="border:1px solid #bbe061" bgcolor="#FFFFFFF">
																		<tr> 
																			<td height=15 style="padding-left:4px"><table border=0 cellpadding=0 cellspacing=0>
																					<tr> 
																						<td width=70 height=15 style="font-size:11;font-family:돋움;color:bfbfbf">폰트 
																							설정</td>
																						<td><a href="#none" onclick="layerView('layerFont');"><img src="/images/chat_16.gif" border></a></td>
																					</tr>
																				</table></td>
																		</tr>
																		<tr> 
																			<td height=1 style="padding-left:2px;padding-right:2px"><table border=0 cellpadding=0 cellspacing=0>
																					<tr> 
																						<td height=1 width=66 bgcolor="ededed"></td>
																					</tr>
																				</table></td>
																		</tr>
																		<tr onmouseover=setColor(this,'#f3f3b9')  onmouseout=setColor(this,'#ffffff')> 
																			<td height=25 align=center style="cursor:hand;color:aaaaaa" onclick="fontChangeFun('굴림');">굴림</td>
																		</tr>
																		<tr onmouseover=setColor(this,'#f3f3b9')  onmouseout=setColor(this,'#ffffff')> 
																			<td height=25 align=center style="cursor:hand;color:aaaaaa" onclick="fontChangeFun('돋움');">돋움</td>
																		</tr>
																		<tr onmouseover=setColor(this,'#f3f3b9')  onmouseout=setColor(this,'#ffffff')> 
																			<td height=25 align=center style="cursor:hand;color:aaaaaa" onclick="fontChangeFun('궁서');">궁서</td>
																		</tr>
																	</table>
																</div>
															</div></td>
															<td width=1  bgcolor="070707"></td>
															<td width=30 ><a href="#none" onclick="layerView('layerPalette');reset('layerPalette')"><img  id='layerPalette_2' src="/images/chaticon_37_off_.gif" border=0></a><div id='layerPalette' style="position:relative;left:0px;top:0px;visibility:hidden"><div  style='position:absolute; left:0; top:0; visibility:; z-index:3;' >	
																	<table border=0 cellpadding=0 cellspacing=0 style="border:1px solid #bbe061" bgcolor="#FFFFFFF">
																		<tr> 
																			<td height=15 style="padding-left:4px" ><table border=0 cellpadding=0 cellspacing=0>
																					<tr> 
																						<td width=130 height=15 style="font-size:11;font-family:돋움;color:bfbfbf">색깔 
																							설정</td>
																						<td align=right><a href="#none" onclick="layerView('layerPalette');"><img src="/images/chat_16.gif" border></a></td>
																					</tr>
																				</table></td>
																		</tr>
																		<tr> 
																			<td height=1 style="padding-left:2px"><table border=0 cellpadding=0 cellspacing=0>
																					<tr> 
																						<td height=1 width=142  bgcolor="ededed"></td>
																					</tr>
																				</table></td>
																		</tr>
																		<tr> 
																			<td style="padding-top:2px"> <img src="images/palette.gif" usemap="#palette" border=0   > 
																				<map name="palette" id="palette">
																					<area shape="rect" coords="5,5,17,17" href="#none" onclick="colorChangeFun('#000000');" />
																					<area shape="rect" coords="23,5,35,17" href="#none" onclick="colorChangeFun('#A52A00')" />
																					<area shape="rect" coords="41,5,53,17" href="#none" onclick="colorChangeFun('#004040')" />
																					<area shape="rect" coords="59,5,71,17" href="#none" onclick="colorChangeFun('#005500')" />
																					<area shape="rect" coords="77,5,89,17" href="#none" onclick="colorChangeFun('#00005E')" />
																					<area shape="rect" coords="95,5,107,17" href="#none" onclick="colorChangeFun('#00008B')" />
																					<area shape="rect" coords="113,5,125,17" href="#none" onclick="colorChangeFun('#4B0082')" />
																					<area shape="rect" coords="131,5,143,17" href="#none" onclick="colorChangeFun('#282828')" />
																					<area shape="rect" coords="5,23,17,35" href="#none" onclick="colorChangeFun('#8B0000')" />
																					<area shape="rect" coords="23,23,35,35" href="#none" onclick="colorChangeFun('#FF6820')" />
																					<area shape="rect" coords="41,23,53,35" href="#none" onclick="colorChangeFun('#8B8B00')" />
																					<area shape="rect" coords="59,23,71,35" href="#none" onclick="colorChangeFun('#009300')" />
																					<area shape="rect" coords="77,23,89,35" href="#none" onclick="colorChangeFun('#388E8E')" />
																					<area shape="rect" coords="95,23,107,35" href="#none" onclick="colorChangeFun('#0000FF')" />
																					<area shape="rect" coords="113,23,125,35" href="#none" onclick="colorChangeFun('#7B7BC0')" />
																					<area shape="rect" coords="131,23,143,35" href="#none" onclick="colorChangeFun('#666666')" />
																					<area shape="rect" coords="5,41,17,53" href="#none" onclick="colorChangeFun('#FF0000')" />
																					<area shape="rect" coords="23,41,35,53" href="#none" onclick="colorChangeFun('#FFAD5B')" />
																					<area shape="rect" coords="41,41,53,53" href="#none" onclick="colorChangeFun('#32CD32')" />
																					<area shape="rect" coords="59,41,71,53" href="#none" onclick="colorChangeFun('#3CB371')" />
																					<area shape="rect" coords="77,41,89,53" href="#none" onclick="colorChangeFun('#7FFFD4')" />
																					<area shape="rect" coords="95,41,107,53" href="#none" onclick="colorChangeFun('#7D9EC0')" />
																					<area shape="rect" coords="113,41,125,53" href="#none" onclick="colorChangeFun('#800080')" />
																					<area shape="rect" coords="131,41,143,53" href="#none" onclick="colorChangeFun('#7F7F7F')" />
																					<area shape="rect" coords="5,59,17,71" href="#none" onclick="colorChangeFun('#FFC0CB')" />
																					<area shape="rect" coords="23,59,35,71" href="#none" onclick="colorChangeFun('#FFD700')" />
																					<area shape="rect" coords="41,59,53,71" href="#none" onclick="colorChangeFun('#FFFF00')" />
																					<area shape="rect" coords="59,59,71,71" href="#none" onclick="colorChangeFun('#00FF00')" />
																					<area shape="rect" coords="77,59,89,71" href="#none" onclick="colorChangeFun('#40E0D0')" />
																					<area shape="rect" coords="95,59,107,71" href="#none" onclick="colorChangeFun('#C0FFFF')" />
																					<area shape="rect" coords="113,59,125,71" href="#none" onclick="colorChangeFun('#480048')" />
																					<area shape="rect" coords="131,59,143,71" href="#none" onclick="colorChangeFun('#C0C0C0')" />
																					<area shape="rect" coords="5,77,17,89" href="#none" onclick="colorChangeFun('#FFE4E1')" />
																					<area shape="rect" coords="23,77,35,89" href="#none" onclick="colorChangeFun('#D2B48C')" />
																					<area shape="rect" coords="41,77,53,89" href="#none" onclick="colorChangeFun('#FFFFE0')" />
																					<area shape="rect" coords="59,77,71,89" href="#none" onclick="colorChangeFun('#98FB98')" />
																					<area shape="rect" coords="77,77,89,89" href="#none" onclick="colorChangeFun('#AFEEEE')" />
																					<area shape="rect" coords="95,77,107,89" href="#none" onclick="colorChangeFun('#68838B')" />
																					<area shape="rect" coords="113,77,125,89" href="#none" onclick="colorChangeFun('#E6E6FA')" />
																					<area shape="rect" coords="131,77,143,89" href="#none" onclick="colorChangeFun('#FFFFFF')" />
																				</map> </td>
																		</tr>
																	</table>
																</div>
															</div></td>
<?
if(@array_key_exists($row_member[id],$array_adminid) == true) {
?>
															<td width=1  bgcolor="070707"></td>
															<td width=55 ><a href="#none" onclick="layerView('layerNick');reset('layerNick')"><img  id='layerNick_2' src="/images/chaticon_39_off_.gif" border=0></a><div id='layerNick' style="position:relative;left:0px;top:0px;visibility:hidden"><div  style='position:absolute; left:0; top:0; visibility:; z-index:3;'>	
																	<table width=84 height=30 border=0 cellpadding=0 cellspacing=0 style="border:1px solid #bbe061" bgcolor="#FFFFFFF">
																		<tr> 
																			<td height=15 style="padding-left:4px" ><table border=0 cellpadding=0 cellspacing=0>
																					<tr> 
																						<td width=61 height=15 style="font-size:11;font-family:돋움;color:bfbfbf">닉네임 
																							설정</td>
																						<td align=right><a href="#none" onclick="layerView('layerNick');"><img src="/images/chat_16.gif" border></a></td>
																					</tr>
																				</table></td>
																		</tr>
																		<tr> 
																			<td height=1 style="padding-left:2px"><table border=0 cellpadding=0 cellspacing=0>
																					<tr> 
																						<td height=1 width=78  bgcolor="ededed"></td>
																					</tr>
																				</table></td>
																		</tr>
																		<tr> 
																			<td style="padding:2px 2px 2px 2px"><input type="text" maxlength="10" style="width:70px;font-size:11px;font-family:돋움;color:aaaaaa" name="nickNameChange" onkeydown="nickNameChangeFun(this)" value="<?=$nickName?>"></td>
																		</tr>
																	</table>
																</div>
															</div></td>
<?
}
?>
															<td width=1  bgcolor="070707"></td>
															<td width=330 background="/images/chaticon_41.gif"></td>
															<td width=3 background="/images/chaticon_43.gif"></td>
														</tr>
													</table></td>
												</tr>
												<tr>
													<td  height=65 background="/images/chatbg_74.gif" valign=top>
													<form name="form" action="" method=post style="display:inline">
														<input type="hidden" name="nickName" value="<?=$nickName?>">
														<input type="hidden" name="userID" value="<?=$row_member[id]?>">
														<input type="hidden" name="color" value="<?=$color?>">
														<input type="hidden" name="font" value="<?=$font?>">
														<input type="hidden" name="code" value="<?=[code]?>">
														<input type="hidden" name="now" value="<?=urlencode([live_start_time])?>">
														<table border=0 cellpadding=0 cellspacing=0>
															<tr>
																<td width=3 height=65 background="/images/chatbg_64.gif"></td>
<?
if($row_member[id]) {	// 로그인
?>
																<td width=331 style="padding-top:4px" valign=top><textarea name="chatmsg" onkeydown=chatKeyCheck(this) class="chatBox"></textarea></td>
																<td width=2></td>
																<td style="padding-top:4px" valign=top><a href="#none" onclick="chatPro(document.form.chatmsg)"><img src="/images/chatbg_78.gif" border=0></a></td>
<?
} else {
?>
																<td width=331 style="padding-top:4px" valign=top onclick="loginConfirm('<?=urlencode($_SERVER[PHP_SELF])?>');" ><textarea name="chatmsg" class="chatBox" disabled>로그인 후 이용해주세요.</textarea></td>
																<td width=2></td>
																<td style="padding-top:4px" valign=top><a href="#none" onclick="loginConfirm('<?=urlencode($_SERVER[PHP_SELF])?>');" ><img src="/images/chatbg_78.gif" border=0></a></td>
<?
}
?>
																<td width=4 background="/images/chatbg_77.gif"></td>
															</tr>
														</table>
														</form>
													</td>
												</tr>
												<tr>
													<td  height=2 background="/images/tv2_45.jpg"></td>
												</tr>
											</table>
												

												<script>
												chatUpdate();

												// 채팅창 자동으로 하단으로이동.
												function autoFocus2() {
													obj = document.getElementById('chat');
													if(obj.scrollHeight < 350) {
														setTimeout("autoFocus2()",100);
													} else {
														obj.scrollTop = obj.scrollHeight;
													}
												}
												autoFocus2();
												</script>

												
												

																		<!-- 카운터 
																			<script type="text/javascript">
																			AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','206','height','45','src','/flash/live_count','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','/flash/live_count' ); //end AC code
																			</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0"  width="206" height="45">
																				<param name="movie" value="/flash/live_count.swf" />
																				<param name="quality" value="high" />
																				<embed src="/flash/live_count.swf" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="206" height="45"></embed>
																			</object></noscript>
																		<!-- 카운터 끝 -->															
												



