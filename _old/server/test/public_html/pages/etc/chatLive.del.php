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
			return false;
		} else {
			alert('닉네임을 입력하세요');
		}
	}
}


function colorChangeFun(color) {
	frm = document.form;
	frm.color.value = color;
	layerView('layerPalette')
}

function fontChangeFun(font) {
	frm = document.form;
	frm.font.value = font;
	layerView('layerFont');
}
</script>
												<table width="425" border="0" cellspacing="0" cellpadding="0">
                          <tr> 
                            <td width="433"><table width="425" border="0" cellspacing="0" cellpadding="0">
                                <tr> 
                                  <td width="13" height="14" background="images/img_chtop_ltop.gif"></td>
                                  <td height="14" background="images/img_chtop_ctop.gif"></td>
                                  <td width="10" height="14" background="images/img_chtop_rtop.gif"></td>
                                </tr>
                                <tr> 
                                  <td width="13" background="images/img_chtop_lbg.gif"></td>
                                  <!-- 상품이름-->
                                  <td height="53" bgcolor="#eaede6"> <table width="398" height="25" border="0" cellpadding="0" cellspacing="0">
                                      <tr> 
                                        <td width="216"><table width="203" height="100%" border="0" align="center" cellpadding="6" cellspacing="0">
                                            <tr> 
                                              <td height="53" valign=bottom><table border=0 cellpadding=0 cellspacing=0>
																								<tr>
																									<td style="font-size:16px;font-family:돋움;font-weight:bold;line-height:100%"><?=[name]?></td>
																								</tr>
																								<tr>
																									<td height="23" style="font-size:25px;font-family:Geneva, Arial;font-weight:bold;color:#FF3300;line-height:100%">
                                                  <?=number_format([price] - [live_sale])?><font size="2">원</font></td>
																								</tr>
																							</table></td>
                                            </tr>
                                          </table></td>
<?
if($row_member[id]) {
?>
                                        <td width="182" valign="bottom"><a href="/odprogram/products/od_order.php?code=<?=[code]?>"><img src="images/btn_buy.gif" width="182" height="45" border=0></a></td>
<?
} else {
?>
                                        <td width="182" valign="bottom"><a href="/odprogram/odlogon/od_login.php?path=<?=urlencode("/odprogram/products/od_order.php?code=".[code])?>&buyMode=live"><img src="images/btn_buy.gif" width="182" height="45" border=0></a></td>
<?
}
?>
                                      </tr>
                                    </table></td>
                                  <td width="13" background="images/img_chtop_rbg.gif"></td>
                                </tr>
                                <tr> 
                                  <td width="13" height="16" background="images/img_chtop_ld.gif"></td>
                                  <td colspan="2" bgcolor="#eaede6"><table width="180" border="0" align="right" cellpadding="0" cellspacing="0">
                                      <tr>
                                        <td width="211" height="16"><img src="images/img_chtop_rd.gif"></td> 
                                      </tr>
                                    </table></td>
                                </tr>
                              </table></td>
                          </tr>
                          <tr> 
                            <!-- 현재접속자-->
                            <td>
<?
if($isLive) {
?>
															<table width="425" border="0" cellspacing="0" cellpadding="0">
                                <tr> 
                                  <td width="26" background="images/ch_ltop.gif"></td> 
                                  <td width="154" background="images/ch_cenbg.gif"><table width="137" border="0" cellspacing="0" cellpadding="2">
                                      <tr> 
                                        <td height="8" colspan="2"></td>
                                      </tr>
                                      <tr> 
                                        <td width="5">&nbsp;</td>
                                        <td width="124"><font color="#333333" size="2" face="돋움">현재접속자수: 
                                          14</font> </td>
                                      </tr>
                                    </table></td>
                                  <td width="39" background="images/ch_timer.gif">&nbsp;</td>
                                  <!-- 남은시간-->
                                  <td width="206">
																		<!-- 카운터 -->
																			<script type="text/javascript">
																			AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','206','height','45','src','/flash/live_count','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','/flash/live_count' ); //end AC code
																			</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0"  width="206" height="45">
																				<param name="movie" value="/flash/live_count.swf" />
																				<param name="quality" value="high" />
																				<embed src="/flash/live_count.swf" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="206" height="45"></embed>
																			</object></noscript>
																		<!-- 카운터 끝 -->																
																	</td>
                                </tr>
                              </table>
<?
} else {
	# 다음방송일 추출
	$que4 = "select live_start_time from odtProduct where cateCode ='03' and live_start_time > '".date('Y-m-d H:i:s')."' order by live_start_time asc limit 1";
	$nextTime	= mysql_result(mysql_query($que4),0);
?>
															<table width="425" border="0" cellspacing="0" cellpadding="0">
                                <tr> 
                                  <td width="425" height=45 background="images/bg_timer.gif" align=center style="color:#333333;font-weight:bold;padding-top:10px">* 다음 생방송 시간은 <span style="color:0132FE"><?=$nextTime?></span>입니다. *</td>
                                </tr>
                              </table>
<?
}
?>
															</td>
                          </tr>
                          <tr> 
                            <td><table width="425" border="0" cellspacing="0" cellpadding="0">
                                <tr> 
                                  <td height="250" background="images/main_top_18.gif"  style="padding-left:12px"><div id='chat'  class="chatStyle"></div></td>
                                </tr>
                              </table></td>
                          </tr>
                          <tr> 
                            <!-- 채팅아이콘,저장박스-->
                            <td style="padding-top:2px"  background="images/main_top_18.gif"><table width="425" border="0" cellspacing="0" cellpadding="0">
                                <tr> 
                                  <td height="23" background="images/main_top_18.gif"><table width="388" border="0" align="center" cellpadding="0" cellspacing="0">
                                      <tr> 
                                        <td width="27">
																					<a href="#none" onclick="layerView('layerIcon');reset('layerIcon')"><img id='layerIcon_2' src="/images/chat_03_off_.gif" border=0 alt="이모티콘"></a>
                                          <div id='layerIcon' style="position:relative;left:0px;top:0px;visibility:hidden" > 
                    <div  style='position:absolute; left:0; top:0; visibility:; z-index:3;'>	
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
                  </div>
																				</td>
                                        <td width="27" align=center>
																					<a href="#none" onclick="layerView('layerFont');reset('layerFont');"><img id='layerFont_2'  src="images/chat_05_off_.gif"  border=0 alt="글꼴"></a>
                                          <div id='layerFont' style="position:relative;left:0px;top:0px;visibility:hidden" > 
                    <div  style='position:absolute; left:0; top:0; visibility:; z-index:3;'>	
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
                  </div>
																				</td>
																				<td  width="27" align=center>
																					<!-- 글씨 색깔 -->
																					<a href="#none" onclick="layerView('layerPalette');reset('layerPalette')"><img  id='layerPalette_2' src="images/chat_07_off_.gif" border=0 alt="글자색"></a>
																					<div id='layerPalette' style="position:relative;left:0px;top:0px;visibility:hidden"> 
                    <div  style='position:absolute; left:0; top:0; visibility:; z-index:3;' >	
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
                              <area shape="rect" coords="5,5,17,17" href="javascript:colorChangeFun('#000000');" />
                              <area shape="rect" coords="23,5,35,17" href="javascript:colorChangeFun('#A52A00')" />
                              <area shape="rect" coords="41,5,53,17" href="javascript:colorChangeFun('#004040')" />
                              <area shape="rect" coords="59,5,71,17" href="javascript:colorChangeFun('#005500')" />
                              <area shape="rect" coords="77,5,89,17" href="javascript:colorChangeFun('#00005E')" />
                              <area shape="rect" coords="95,5,107,17" href="javascript:colorChangeFun('#00008B')" />
                              <area shape="rect" coords="113,5,125,17" href="javascript:colorChangeFun('#4B0082')" />
                              <area shape="rect" coords="131,5,143,17" href="javascript:colorChangeFun('#282828')" />
                              <area shape="rect" coords="5,23,17,35" href="javascript:colorChangeFun('#8B0000')" />
                              <area shape="rect" coords="23,23,35,35" href="javascript:colorChangeFun('#FF6820')" />
                              <area shape="rect" coords="41,23,53,35" href="javascript:colorChangeFun('#8B8B00')" />
                              <area shape="rect" coords="59,23,71,35" href="javascript:colorChangeFun('#009300')" />
                              <area shape="rect" coords="77,23,89,35" href="javascript:colorChangeFun('#388E8E')" />
                              <area shape="rect" coords="95,23,107,35" href="javascript:colorChangeFun('#0000FF')" />
                              <area shape="rect" coords="113,23,125,35" href="javascript:colorChangeFun('#7B7BC0')" />
                              <area shape="rect" coords="131,23,143,35" href="javascript:colorChangeFun('#666666')" />
                              <area shape="rect" coords="5,41,17,53" href="javascript:colorChangeFun('#FF0000')" />
                              <area shape="rect" coords="23,41,35,53" href="javascript:colorChangeFun('#FFAD5B')" />
                              <area shape="rect" coords="41,41,53,53" href="javascript:colorChangeFun('#32CD32')" />
                              <area shape="rect" coords="59,41,71,53" href="javascript:colorChangeFun('#3CB371')" />
                              <area shape="rect" coords="77,41,89,53" href="javascript:colorChangeFun('#7FFFD4')" />
                              <area shape="rect" coords="95,41,107,53" href="javascript:colorChangeFun('#7D9EC0')" />
                              <area shape="rect" coords="113,41,125,53" href="javascript:colorChangeFun('#800080')" />
                              <area shape="rect" coords="131,41,143,53" href="javascript:colorChangeFun('#7F7F7F')" />
                              <area shape="rect" coords="5,59,17,71" href="javascript:colorChangeFun('#FFC0CB')" />
                              <area shape="rect" coords="23,59,35,71" href="javascript:colorChangeFun('#FFD700')" />
                              <area shape="rect" coords="41,59,53,71" href="javascript:colorChangeFun('#FFFF00')" />
                              <area shape="rect" coords="59,59,71,71" href="javascript:colorChangeFun('#00FF00')" />
                              <area shape="rect" coords="77,59,89,71" href="javascript:colorChangeFun('#40E0D0')" />
                              <area shape="rect" coords="95,59,107,71" href="javascript:colorChangeFun('#C0FFFF')" />
                              <area shape="rect" coords="113,59,125,71" href="javascript:colorChangeFun('#480048')" />
                              <area shape="rect" coords="131,59,143,71" href="javascript:colorChangeFun('#C0C0C0')" />
                              <area shape="rect" coords="5,77,17,89" href="javascript:colorChangeFun('#FFE4E1')" />
                              <area shape="rect" coords="23,77,35,89" href="javascript:colorChangeFun('#D2B48C')" />
                              <area shape="rect" coords="41,77,53,89" href="javascript:colorChangeFun('#FFFFE0')" />
                              <area shape="rect" coords="59,77,71,89" href="javascript:colorChangeFun('#98FB98')" />
                              <area shape="rect" coords="77,77,89,89" href="javascript:colorChangeFun('#AFEEEE')" />
                              <area shape="rect" coords="95,77,107,89" href="javascript:colorChangeFun('#68838B')" />
                              <area shape="rect" coords="113,77,125,89" href="javascript:colorChangeFun('#E6E6FA')" />
                              <area shape="rect" coords="131,77,143,89" href="javascript:colorChangeFun('#FFFFFF')" />
                            </map> </td>
                        </tr>
                      </table>
                    </div>
                  </div>
																				</td>
                                        <td width="" style="padding-left:1px">
																					<a href="#none" onclick="layerView('layerNick');reset('layerNick')"><img id='layerNick_2' src="images/chat_09_off_.gif" border=0 alt='닉네임'></a>
																					<!-- 닉네임 변경 -->
				<!--																	<a href="#none" onclick="layerView('layerNick')">닉네임변경</a>-->
																					
                                          
                  <div id='layerNick' style="position:relative;left:0px;top:0px;visibility:hidden"> 
                    <div  style='position:absolute; left:0; top:0; visibility:; z-index:3;'>	
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
                  </div>
																				</td>
                                        <td width="44">&nbsp;</td>
                                      </tr>
                                    </table></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table>
												<!-- 채팅글자입력폼-->
												<form name="form" action="" method=post style="display:inline">
													<input type="hidden" name="nickName" value="<?=$nickName?>">
													<input type="hidden" name="userID" value="<?=$row_member[id]?>">
													<input type="hidden" name="color" value="<?=$color?>">
													<input type="hidden" name="font" value="<?=$font?>">
													<input type="hidden" name="code" value="<?=[code]?>">
													<input type="hidden" name="now" value="<?=urlencode(date('Y-m-d H:i:s'))?>">

														<table width="425" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td width="13" height="52" background="images/main_top_18.gif">&nbsp;</td>
<?
if($row_member[id]) {	// 로그인
?>
																<td bgcolor="#cae58a" width=340 ><textarea name="chatmsg" onkeydown=chatKeyCheck(this) class="chatBox"></textarea></td>
																<td width="65" bgcolor="#cae58a"><a href="#none" onclick="chatPro(document.form.chatmsg)"><img src="images/btn_enter.gif" width="65" height="52" border=0></a></td>
<?
} else {	// 비회원
?>
																<td bgcolor="#cae58a" width=340 onclick="loginConfirm('<?=urlencode($_SERVER[PHP_SELF])?>');" ><textarea name="chatmsg" class="chatBox" disabled>로그인 후 이용해주세요.</textarea></td>
																<td width="65" bgcolor="#cae58a"><a href="#none" onclick="loginConfirm('<?=urlencode($_SERVER[PHP_SELF])?>');" ><img src="images/btn_enter.gif" width="65" height="52" border=0></a></td>
<?
}
?>
																<td width="13" background="images/img_ch_rdbg.gif">&nbsp;</td>
															</tr>
														</table>

												</form>
												<script>
												chatUpdate();
												</script>
													<!-- 채팅꿑-->