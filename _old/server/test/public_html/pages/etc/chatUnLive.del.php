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
																									<td style="font-size:25px;font-family:Geneva, Arial;font-weight:bold;color:#FF3300;line-height:100%">
                                                  <?=number_format([price])?><font size="2">원</font></td>
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
	$nextTime	= @mysql_result(mysql_query($que4),0);
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
                                  <td height="250" background="images/main_top_18.gif"  style="padding-left:12px"><div id='chat'  class="chatStyle" style="height:323px"></div></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table>
