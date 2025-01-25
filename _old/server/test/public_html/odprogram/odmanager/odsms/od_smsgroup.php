<?
	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_common/od_class.sms.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";

	## 세부권한 체크
	if($row_admin[smsLevel]==3 || $row_admin[superLevel]==9) {
	}
	else {
		error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
	}

	if(eregi("-",$row_company[tel])){
		$admin_htel_tmp=explode("-",$row_company[tel]);

		$admin_htel_num1=$admin_htel_tmp[0];
		$admin_htel_num2=$admin_htel_tmp[1];
		$admin_htel_num3=$admin_htel_tmp[2];
	}
	else{
		if(strlen($row_company[tel]) == 9){
			$admin_htel_num1=substr($row_company[tel],0,2);
			$admin_htel_num2=substr($row_company[tel],2,3);
			$admin_htel_num3=substr($row_company[tel],5,4);
		}
		else if(strlen($row_company[tel]) == 10){
			$admin_htel_num1=substr($row_company[tel],0,3);
			$admin_htel_num2=substr($row_company[tel],3,3);
			$admin_htel_num3=substr($row_company[tel],6,4);
		}
		else if(strlen($row_company[tel]) == 11){
			$admin_htel_num1=substr($row_company[tel],0,3);
			$admin_htel_num2=substr($row_company[tel],3,4);
			$admin_htel_num3=substr($row_company[tel],7,4);
		}
		else{
			$admin_htel_num1="";
			$admin_htel_num2="";
			$admin_htel_num3="";
		}
	}
	$tel = explode("-",$row_company[tel]);

?>
		<script>
			//function blockKey(item){
			//	if(event.keyCode==9) {
			//		item.focus();
			//		space = "    ";
			//		item.selection=document.selection.createRange();
			//		item.selection.text=space;
			//		event.returnValue = false;  
			//	}	  
			//}

			function find_send_list(form){
				var win_find = window.open("od_find_send_list2.php","find_win","width=800, height=800, scrollbars=yes");
				win_find.focus();
			}

			function view_send_list(form){
				var win_view = window.open("","view_win","width=600, height=700, scrollbars=no");
				form.target="view_win";
				form.action="od_view_send_list.php";
				form.submit();

				win_view.focus();
			}

			function chk_message(form){
				if(form.message.value == "메시지 입력"){
					form.message.value="";
					message_len_id.innerHTML="0";
					form.message.focus();
				}
			}

			function select_char(form,val){
				if(form.message.value == "메시지 입력"){
					form.message.value="";
					message_len_id.innerHTML="0";
				}

				var message_val = form.message.value;
				message_val = message_val + val;

				form.message.value = message_val;

				var len=str_length(form);

				if(len>80){
					alert('80바이트 이내로 쓰셔야 해요');
					return false;
				}
					
				message_len_id.innerHTML=len;

				form.message.focus();
			}

			function send_ok(form){
				if(form.message.value=="메시지 입력" || form.message.value==""){
					alert("메시지를 입력해 주세요.");
					form.message.value="";
					message_len_id.innerHTML="0";
					form.message.focus();
				}
				else{
					if(document.form_frame.send_list_serial.value == ""){
						alert("메시지를 받을 사람을 선택해 주세요. 조건검색을 통해 추가가 가능합니다.");
					}
					else{
						form.send_list_serial.value = document.form_frame.send_list_serial.value;
						form.submit();
					}
				}
			}
		</script>

		<script>
			function str_length(form) {
				if ( navigator.appCodeName != 'Mozilla' ) {
					return form.message.value.length;
				}
			  
				var len = 0; 
			  
				for (var i=0; i<form.message.value.length; i++) {
					if ( form.message.value.substr(i, 1) > '~' ) {
						len+=2;
					} 
					else {
						len++;
					}
				}
			  
				return len;
			}
			
			function str_prev() {
				if ( navigator.appCodeName != 'Mozilla' ) {
					return document.SEND.h_content.value.length;
				}
				var len = 0; 
			  
				for (var i=0; i<document.SEND.h_content.value.length; i++) {
					if ( document.SEND.h_content.value.substr(i, 1) > '~' ) {
						len+=2;
					} 
					else {
						len++;
					}
				
					if (len > 200) {
						return i
					}
				}
			  
				return len;
			}

			function check_length(form){
				var len=str_length(form);

				if(len>80){
					alert('80바이트 이내로 쓰셔야 해요');
					return false;
				}
					
				message_len_id.innerHTML=len;
			}
		</script>
		<iframe name="hiddenFrame" src="about:blank" style="display:none"></iframe>
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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> 
														SMS/메일링 관리 &gt; <span class="st">SMS 그룹발송</span></font></td>
												</tr>
												<tr> 
													<td height="2" bgcolor="D6D6D6"></td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="1" cellpadding="0">
												<tr> 
													<td height="11"></td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="18"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5"><b>SMS 그룹발송</b></font></td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="25"></td>
												</tr>
											</table>
											<table border="0" cellspacing="0" cellpadding="0">
												<form name="form_sms" method="post" target="hiddenFrame" action="od_smsgroupPro.php">
													<input type="hidden" name="form" value="sendform">
													<input type="hidden" name="send_list_serial">
												<tr> 
													<td width="195" valign="top">
														<table border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td colspan="3"><img src="../odimages/sms_01.gif" width="183" height="27"></td>
															</tr>
															<tr> 
																<td colspan="3" width="176" align="center" background="../odimages/sms_04_ver2.gif">
																	<table width="157" border="0" cellspacing="0" cellpadding="0">
																		<tr> 
																			<td height="100" align="center" background="../odimages/sms_bg1.gif"> 
																				<textarea name="message" cols="18" rows="6" id="message" style="BACKGROUND-COLOR: #E2EAF9;font-size: 9pt;border: 1x SOLID #E2EAF9;color:#173979;padding: 4px;font-family:굴림체" onclick="chk_message(form_sms)" onkeyup="check_length(form_sms); return false;">메시지 입력</textarea>
																			</td>
																		</tr>
																	</table>
																	<table width="157" border="0" cellspacing="0" cellpadding="0">
																		<tr> 
																			<td height="25" align="center" bgcolor="fbfbfb"><font color="265BBC"><font id="message_len_id">11</font> bytes / 80 bytes</font></td>
																		</tr>
																	</table>
																	<!-- <table width="157" border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td><img src="../odimages/sms_03.gif" width="157" height="30"></td>
																		</tr>
																		<tr>
																			<td align="center">
												<table border="0" cellpadding="0" cellspacing="1" bgcolor="E5E5E5" class="cate" >
													<tr bgcolor="#FFFFFF" align="center"> 
														<td width="16" style='font-family:굴림체'><a href="javascript:select_char(form_sms,'▣');">▣</a></td>
														<td width="16" style='font-family:굴림체'><a href="javascript:select_char(form_sms,'◐');">◐</a></td>
														<td width="16" style='font-family:굴림체'><a href="javascript:select_char(form_sms,'◑');">◑</a></td>
														<td width="16" style='font-family:굴림체'><a href="javascript:select_char(form_sms,'▒');">▒</a></td>
														<td width="16" style='font-family:굴림체'><a href="javascript:select_char(form_sms,'▤');">▤</a></td>
														<td width="16" style='font-family:굴림체'><a href="javascript:select_char(form_sms,'▥');">▥</a></td>
														<td width="16" style='font-family:굴림체'><a href="javascript:select_char(form_sms,'▨');">▨</a></td>
														<td width="16" style='font-family:굴림체'><a href="javascript:select_char(form_sms,'▧');">▧</a></td>
													</tr>
													<tr bgcolor="#FFFFFF" align="center"> 
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'▦');">▦</a></td>
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'△');">△</a></td>
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'▲');">▲</a></td>
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'▽');">▽</a></td>
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'▼');">▼</a></td>
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'◀');">◀</a></td>
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'◁');">◁</a></td>
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'▶');">▶</a></td>
													</tr>
													<tr bgcolor="#FFFFFF" align="center"> 
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'♨');">♨</a></td>
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'☏');">☏</a></td>
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'☎');">☎</a></td>
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'☜');">☜</a></td>
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'☞');">☞</a></td>
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'†');">†</a></td>
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'＠');">＠</a></td>
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'♩');">♩</a></td>
													</tr>
													<tr bgcolor="#FFFFFF" align="center"> 
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'♪');">♪</a></td>
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'→');">→</a></td>
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'←');">←</a></td>
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'↓');">↓</a></td>
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'↑');">↑</a></td>
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'↔');">↔</a></td>
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'⊙');">⊙</a></td>
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'▷');">▷</a></td>
													</tr>
													<tr bgcolor="#FFFFFF" align="center"> 
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'※');">※</a></td>
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'☆');">☆</a></td>
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'★');">★</a></td>
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'○');">○</a></td>
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'●');">●</a></td>
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'◎');">◎</a></td>
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'◇');">◇</a></td>
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'◆');">◆</a></td>
													</tr>
													<tr bgcolor="#FFFFFF" align="center"> 
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'□');">□</a></td>
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'♠');">♠</a></td>
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'♤');">♤</a></td>
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'♥');">♥</a></td>
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'♡');">♡</a></td>
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'♣');">♣</a></td>
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'♧');">♧</a></td>
														<td style='font-family:굴림체'><a href="javascript:select_char(form_sms,'♬');">♬</a></td>
													</tr>
												</table>
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td height="5"></td>
													</tr>
												</table>
																			</td>
																		</tr>
																	</table> -->
																</td>
																<!--<td width="7" background="../odimages/sms_.gif">&nbsp;</td>-->
															</tr>
															<tr> 
																<td colspan="3"><img src="../odimages/sms_04.gif" width="183" height="17"></td>
															</tr>
														</table>
													</td>
													<td width="460" align="center" valign="top"> 
														<table border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td width="235" align="center" valign="top"> 
																	<table width="157" border="0" cellspacing="0" cellpadding="0">
																		<tr> 
																			<td colspan="3"><img src="../odimages/sms_send_01.gif" width="210" height="5"></td>
																		</tr>
																		<tr align="center" bgcolor="b4b4b4"> 
																			<td height="25" colspan="3"><font color="#FFFFFF"><strong>보내는 사람</strong></font></td>
																		</tr>
																		<tr> 
																			<td colspan="3"><img src="../odimages/sms_send_02.gif" width="210" height="4"></td>
																		</tr>
																		<tr> 
																			<td width="4" bgcolor="b4b4b4">&nbsp;</td>
																			<td width="202" height="29" align="center"> 
																				<input name="send_from_num1" type="text" class="border" size="4" maxlength=4 value="<?=$tel[count($tel)-3]?>"> - <input name="send_from_num2" type="text" class="border" size="5" maxlength=4 value="<?=$tel[count($tel)-2]?>"> - <input name="send_from_num3" type="text" class="border" size="5" maxlength=4 value="<?=$tel[count($tel)-1]?>"></td>
																			<td width="4" bgcolor="b4b4b4">&nbsp;</td>
																		</tr>
																		<tr> 
																			<td colspan="3"><img src="../odimages/sms_send_03.gif" width="210" height="7"></td>
																		</tr>
																	</table>
																	<table width="210" border="0" cellpadding="0" cellspacing="0" style="display:none">
																		<tr> 
																			<td height="35"><strong><font color="1085AF"> 
																				<input type="radio" name="send_type" value="now" checked>즉시 전송하기</font></strong></td>
																		</tr>
																		<tr> 
																			<td height="1" bgcolor="D5D5D5"></td>
																		</tr>
																		<tr> 
																			<td height="35"><strong><font color="1085AF"> 
																				<input type="radio" name="send_type" value="res">예약 전송하기</font></strong></td>
																		</tr>
																		<tr>
																			<td height="65" bgcolor="F1F1F1"> 
																				<table border="0" cellspacing="0" cellpadding="0">
																					<tr> 
																						<td width="20">&nbsp;</td>
																						<td width="190" height="25"> 
																							<select name="send_year">
																							<option value="2005" <?if(date("Y") == "2005") echo "selected";?>>2005</option>
																							<option value="2006" <?if(date("Y") == "2006") echo "selected";?>>2006</option>
																							<option value="2007" <?if(date("Y") == "2007") echo "selected";?>>2007</option>
																							<option value="2008" <?if(date("Y") == "2008") echo "selected";?>>2008</option>
																							<option value="2009" <?if(date("Y") == "2009") echo "selected";?>>2009</option>
																							<option value="2010" <?if(date("Y") == "2010") echo "selected";?>>2010</option>
																							</select>년 
																							<select name="send_month">
<?	
		for($m=1;$m<=12;$m++){
			if($m < 10) $mm="0".$m;
			else $mm=$m;

			if($mm == date("m")) echo "<option value='$mm' selected>$mm</option>";
			else echo "<option value='$mm'>$mm</option>";
		}
?>
																							</select>월 
																							<select name="send_day">
<?
		for($d=1;$d<=31;$d++){
			if($d < 10) $dd="0".$d;
			else $dd=$d;

			if($dd == date("d")) echo "<option value='$dd' selected>$dd</option>";
			else echo "<option value='$dd'>$dd</option>";
		}
?>
																							</select>일
																						</td>
																					</tr>
																					<tr> 
																						<td>&nbsp;</td>
																						<td height="25"> 
																							<select name="send_hour">
<?
		for($h=1;$h<=24;$h++){
			if($h < 10) $hh="0".$h;
			else $hh=$h;

			if($hh == date("H")) echo "<option value='$hh' selected>$hh</option>";
			else echo "<option value='$hh'>$hh</option>";
		}
?>
																							</select>시 
																							<select name="send_min">
<?
		for($mi=0;$mi<=59;$mi++){
			if($mi < 10) $mimi="0".$mi;
			else $mimi=$mi;

			if($mimi == date("i")) echo "<option value='$mimi' selected>$mimi</option>";
			else echo "<option value='$mimi'>$mimi</option>";
		}
?>
																							</select>분
																						</td>
																					</tr>
																				</table>
																			</td>
																		</tr>
																	</table> 
																</td>
																<td width="1" background="../odimages/sms_dot.gif"></td>
																<td width="235" height="200" align="center" valign="top"> 
																	<table width="157" border="0" cellspacing="0" cellpadding="0">
																		<tr> 
																			<td colspan="3"><img src="../odimages/sms_take_01.gif" width="210" height="5"></td>
																		</tr>
																		<tr align="center" bgcolor="6c6c6c"> 
																			<td height="25" colspan="3"><font color="#FFFFFF"><strong>받는 사람</strong></font></td>
																		</tr>
																		<tr> 
																			<td colspan="3"><img src="../odimages/sms_take_02.gif" width="210" height="4"></td>
																		</tr>
																		<tr> 
																			<td width="4" bgcolor="6c6c6c">&nbsp;</td>
																			<td width="202" height="29" align="center">
																				<table width="185" border="0" cellspacing="0" cellpadding="0">
																					<tr>
																						<td>발송대상자 <strong><font color="103784" id="send_count_id">00</font></strong>명 
																						</td>
																						<td align="right"><a href="javascript:find_send_list(form_sms);"><img src="../odimages/sms_btn_search.gif" width="64" height="20" border="0"></a></td>
																					</tr>
																				</table>
																			</td>
																			<td width="4" bgcolor="6c6c6c">&nbsp;</td>
																		</tr>
																		<tr> 
																			<td colspan="3"><img src="../odimages/sms_take_03.gif" width="210" height="7"></td>
																		</tr>
																		<tr align="center"> 
																			<td height="40" colspan="3"><a href="javascript:view_send_list(form_frame);"><img src="../odimages/sms_btn_view.gif" width="86" height="20" border="0"  style="display:"></a> 
																			</td>
																		</tr>
																		<tr align="center"> 
																			<td colspan="3">
																				<font id="send_list_id">
																				<select name="send_list" size=7 style="width:80%" multiple>
																				</select>
																				<!--textarea name="take_num" cols="30" rows="7" class="border"></textarea-->
																				</font>
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
                                                        <table>
                                                            <tr>
                                                                <td>
                                                                    <table width="150" border="0" cellspacing="0" cellpadding="0">
                                                                        <tr>
                                                                            <td height="11"><a href='#none' onClick="hiddenFrame.location.href='od_sms_word_list_tran.php?status=save2&smstext='+encodeURI(document.form_sms.message.value)"><img src="/images/btn_smssave.gif" width="107" height="19" border="0" /></a></td>
                                                                            <td width="10">&nbsp;&nbsp;</td>
                                                                            <td height="11"><a href='#none' onClick="window.open('od_sms_word_list.php?FORM_NAME=form_sms&FORM_FILED=message','SMS문구','width=700,height=500,toolbar=no,scrollbars=yes,top=0,left=0');"><img src="/images/btn_smsre.gif" width="107" height="19" border="0" /></a></td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                                <td>
                                                                    <table width="150" border="0" cellspacing="0" cellpadding="0">
                                                                        <tr>
                                                                            <td height="97" align="center" background="../odimages/sms_ok_bg.gif"><a href="javascript:send_ok(form_sms);"><img src="../odimages/sms_btn_ok.gif" width="142" height="62" border="0"></a></td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
													</td>
												</tr>
												</form>
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
			<form name="form_frame" method="post">
				<input type="hidden" name="send_list_serial" value="<?=implode("/",$memSerialnum)?>">
			</form>
		</table>
		<iframe name="smsgroup_frame" border=0 width=0 height=0></iframe>
		<script>
			function select_list(){
				document.form_frame.target="smsgroup_frame";
				document.form_frame.action="od_smsgroup_frame.php"
				document.form_frame.submit();
			}
			<?
			if($memSerialnum) echo "select_list()";
			?>
		</script>
	</body>
</html>
