<?
	# 다음방송일 추출
	$que4 = "select live_start_time from odtProduct where cateCode ='03' and live_start_time > '".date('Y-m-d H:i:s')."' order by live_start_time asc limit 1";
	$nextTime	= @mysql_result(mysql_query($que4),0);
?>
											<table width=428 border=0 cellpadding=0 cellspacing=0>
												<tr>
													<td width=428 height=2 background="/images/tv2_11.jpg"></td>
												</tr>
												<tr>
													<td  height=70 background="/images/tv2_15.jpg"><table border=0 cellpadding=0 cellspacing=0>
															<tr>
																<td width=227 style="color:eaede6;padding-left:10px;font-size:15px;font-weight:bold;font-family:굴림"><?=[mainName] ? [mainName] : [name];?></td>
<?
if(![code]) {
?>
																<td rowspan=2 style="padding-right:10px;"><a href="#none" onclick="alert('방송중이 아닙니다.');"><img src="/images/buybtn_17.jpg" border=0></a></td>
<?
} else if($row_member[id]) {
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
<?
if([price]) {
?>
															<tr>
																<td style="color:ff2919;font-weight:bold;font-family:굴림;font-size:28px;padding-left:10px">
																<img src="/images/box_live.gif">
<?
$priceTmp = number_format([price]);
for($zz=0;$zz<strlen($priceTmp);$zz++) {
	echo "<img src='/images/num".substr($priceTmp,$zz,1).".jpg'>";
}	
?><img src="/images/won.jpg"></td>
															</tr>
<?
} else {
?>
															<tr>
																<td style="color:ffffff;font-weight:bold;font-family:굴림;font-size:20px;padding-left:10px"></td>
															</tr>
<?
}
?>
														</table></td>
												</tr>
												<tr>
													<td  height=40 background="/images/tv2_17_.jpg">
													<!-- 카운터 -->
														<script type="text/javascript">
														AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','428','height','40','src','/flash/live_count','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','/flash/next_live_count' ); //end AC code
														</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0"  width="428" height="40">
															<param name="movie" value="/flash/next_live_count.swf" />
															<param name="quality" value="high" />
															<embed src="/flash/next_live_count.swf" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="428" height="40"></embed>
														</object></noscript>
													<!-- 카운터 끝 -->																												
													</td>
												</tr>
												<tr>
													<td  height=26 ><table border=0 cellpadding=0 cellspacing=0 width=428 height=26>
														<tr>
															<td width=3 height=26 background="/images/tv2_18.jpg"></td>
															<td width=422 background="/images/tv2_19.jpg" style="color:#ffffff;font-weight:bold;" align=center>*  다음 방송시간은 <font color="07d2fe"><?=$nextTime?></font> 입니다.* </td>
															<td width=3 height=26 background="/images/tv2_21.jpg"></td>
														</tr>
													</table></td>
												</tr>
												<tr>
													<td height=218 background="/images/tv2_22.jpg" align=center valign=middle><img src="<?=[replay_img] ? [replay_img] : "/images/tv2_24.jpg";?>"></td>
												</tr>
												<tr>
													<td  height=1 background="/images/tv2_28.jpg"></td>
												</tr>
												<tr>
													<td  height=91 background="/images/tv2_29.jpg" valign=top><table border=0 cellpadding=0 cellspacing=0>
														<tr>
															<td height=10></td>
														</tr>
														<tr>
															<td width=9></td>
															<td width=80 height=55><img src="/images/no_proimg.gif" style="border:1px solid #000000"></td>
															<td width=9></td>
															<td width=80 height=55><img src="/images/no_proimg.gif" style="border:1px solid #000000"></td>
															<td width=9></td>
															<td width=80 height=55><img src="/images/no_proimg.gif" style="border:1px solid #000000"></a></td>
															<td width=9></td>
															<td width=144 height=55><img src="/images/tv2_38.jpg" style="border:1px solid #000000"></td>
														</tr>
														<tr>
															<td width=9 height=26></td>
															<td width=80  style="color:b4b5b7" align=center></td>
															<td width=9></td>
															<td width=80  style="color:b4b5b7" align=center></td>
															<td width=9></td>
															<td width=80  style="color:b4b5b7" align=center></td>
															<td width=9></td>
															<td width=144  style="color:92ff1c" align=center><?=date('n월 j일',strtotime($nextTime))?> 방송예정</td>
														</tr>
													</table></td>
												</tr>
												<tr>
													<td  height=2 background="/images/tv2_45.jpg"></td>
												</tr>
											</table>
												
												
												
												


												
