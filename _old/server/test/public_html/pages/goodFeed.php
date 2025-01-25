
						<!--친구에게 알리기-->
						<table width="253" border="0" align="right" cellpadding="0" cellspacing="0">
								<tr>
										<td>
												<table width="253" border="0" align="right" cellpadding="0" cellspacing="0" background="/images/group/frend_bg.gif" class="smt10">
														<tr>
																<td height="79" align="center">
																		<table width="232" border="0" cellspacing="0" cellpadding="0">
																				<tr>
																						<td><img src="/images/group/frend_title.gif" width="89" height="21"></td>
																				</tr>
																				<tr>
																						<td><table border=0 cellpadding=0 cellspacing=0>
																							<tr>
																								<td><a href="javascript:sendTwitter('<?=str_replace("'","`",$row_product[mainName] ? $row_product[mainName] : $row_product[name]);?>', 'http://<?=$_SERVER[HTTP_HOST]?>')" ><img src="/images/group/frend_icon_01.jpg" width="38" height="38" border=0></a></td>
																								<td><a href="javascript:sendFaceBook('<?=str_replace("'","`",$row_product[mainName] ? $row_product[mainName] : $row_product[name]);?>', 'http://<?=$_SERVER[HTTP_HOST]?>?viewCode=<?=$row_product[code]?>')"><img src="/images/group/frend_icon_02.jpg" width="39" height="38"border=0></a></td>
																								<td><a href="javascript:sendMe2Day('<?=str_replace("'","`",$row_product[mainName] ? $row_product[mainName] : $row_product[name]);?>', 'http://<?=$_SERVER[HTTP_HOST]?>', '<?=$row_company[homepage_title]?>', '<?=$row_company[homepage]?>')"><img src="/images/group/frend_icon_03.jpg" width="40" height="38" border=0></a></td>
																								<td><a href="#none" onclick="javascript:goYozmDaum('http://<?=$_SERVER[HTTP_HOST]?>','<?=str_replace("'","`",$row_product[mainName] ? $row_product[mainName] : $row_product[name]);?>','<?=$row_company[homepage_title]?>', '<?=$row_company[homepage]?>')"><img src="/images/group/frend_icon_04.jpg" width="39" height="38" border=0></a></td>
																								<td><a href="#none" onclick="javascript:sendMail('<?=str_replace("'","`",$row_product[mainName] ? $row_product[mainName] : $row_product[name]);?>','<?=$row_product[code]?>')" /><img src="/images/group/frend_icon_05.jpg" width="39" height="38" border=0></a></td>
																								<td><a href="#none" onclick="javascript:sendSms('<?=str_replace("'","`",$row_product[mainName] ? $row_product[mainName] : $row_product[name]);?>','<?=$row_product[code]?>')" /><img src="/images/group/frend_icon_06.jpg" width="39" height="38" border=0></a></td>
																							</tr>
																						</table></td>
																				</tr>
																		</table>
																</td>
														</tr>
												</table>
												<!--//친구에게 알리기-->
										</td>
								</tr>
								<tr>
										<td>
												<!--구독하기-->
												<form name="feedFrm" action="/feedPro.php" method="post" target="feedFrmFrame" style='display:inline' onsubmit="return feedFunc(this)">
												<table width="253" border="0" align="right" cellpadding="0" cellspacing="0" background="/images/group/subscrip_bg.gif" class="smt10">
														<tr>
																<td height="101" align="center">
																		<table width="232" border="0" cellspacing="0" cellpadding="0">
																				<tr>
																						<td colspan="3"><img src="/images/group/subscrip_title.gif" width="110" height="24"></td>
																				</tr>
																				<tr>
																						<td class="s">이메일
																								<input type="checkbox" name="emailCheck" value="1"onclick="if(this.checked) this.form.feedEmail.disabled=false; else this.form.feedEmail.disabled=true;" checked>
																						</td>
																						<td><span class="spb15">
																								<input name="feedEmail" type="text" style="width:114px; height:23px"  class="input"  style='line-height:160%' >
																								</span></td>
																						<td rowspan="2"><input type="image" src="/images/group/btn_subscrip.gif" width="52" height="50" border=0></td>
																				</tr>
																				<tr>
																						<td class="s">핸드폰
																								<input type="checkbox" name="smsCheck" value="1"  onclick="if(this.checked) this.form.feedSms.disabled=false; else this.form.feedSms.disabled=true;" >
																						</td>
																						<td><span class="spb15">
																								<input name="feedSms" type="text" style="width:114px; height:23px" class="input"  style='line-height:160%'  maxlength="13" disabled onkeyup='toCheck(this)'>
																								</span></td>
																				</tr>
																		</table>
																</td>
														</tr>
												</table>
												</form>
												<!--//구독하기-->
										</td>
								</tr>
								<tr>
										<td class="spt10"><a href="/?Pid=u01b05"><img src="/images/group/banner.gif" width="253" height="79" border=0></a></td>
								</tr>
						</table>


<iframe name="feedFrmFrame" src="about:blank" width=0 height=0 style="display:none"></iframe>