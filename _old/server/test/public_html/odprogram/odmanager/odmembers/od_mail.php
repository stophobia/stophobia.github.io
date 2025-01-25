<?PHP

	include "../../odcommon/od_config.inc.php";
	include "$folderpath_manager_common/od_function.inc.php";	
	include "$folderpath_manager_common/od_adminAuthority.inc.php";
	include "$folderpath_manager_common/od_head.inc.php";
	include "$folderpath_manager_common/od_body.inc.php";

	## 세부권한 체크
	if($row_admin[memberLevel]==5 || $row_admin[superLevel]==9) {
	}
	else {
		error_msgloc("$folderpath_manager/","접근권한이 없습니다.   ");
	}
	
	if(!strcmp($Form,"")) {
		$mailling_T = 0;		
		$mailling_Y = 0;
		$mailling_N = 0;

		$qry_ML = "select mailling, count(serialnum) as CS from odtMember where secession='N' and resinum != '' group by mailling";
		$res_ML = mysql_query($qry_ML);

		while($row_ML = mysql_fetch_array($res_ML)){
			if($row_ML[mailling] == "Y") $mailling_Y = $row_ML[CS];
			else if($row_ML[mailling] == "N") $mailling_N = $row_ML[CS];

			$mailling_T += $row_ML[CS];
		}

		if($mailling_Y == 0){
			$mailling_T_str = "checked";
			$mailling_Y_str = "disabled";
		}
		else{
			$mailling_T_str = "";
			$mailling_Y_str = "checked";
		}

		$qry_MD = "select maildate, count(serialnum) CS from odtMember  where resinum != '' group by maildate order by maildate desc limit 1";
		$res_MD = mysql_query($qry_MD);
		$num_MD = mysql_num_rows($res_MD);

		if($num_MD){
			$row_MD = mysql_fetch_array($res_MD);
			
			if($row_MD[maildate]){
				$last_MD = date("Y년m월d일 H시i분",$row_MD[maildate]);
				$last_num = $row_MD[CS];
			}
			else{
				$last_MD = "-";
				$last_num = 0;
			}
		}
		else{
			$last_MD = "-";
			$last_num = 0;
		}



		// 구독하기 메일링 회원수 추출 
		$res_ss = mysql_query("SELECT count(ft_email) as cnt FROM feedTable WHERE ft_email !='' group by ft_email ");
		$sum_ss = mysql_num_rows($res_ss);

?>

		<script language="javascript">
			function valueCheck (form) {
				var form = document.snsForm;
				if(!form.subject.value) {
					alert("메일 제목을 입력하세요.   ");
					form.subject.focus(); 
					return false;
				}
				if(!form.comment.value) {
					alert("메일 내용을 입력하세요.   ");
					form.comment.focus(); 
					return false;
				}
			}
			function reSize(formname,size){
				if(size == 'reset') {
					formname.rows = 25;
				}else{
					var value = formname.rows+size;
					if(value>0) formname.rows = value
					else return;
				}
			}
		</script>

		<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
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
													<td height="33"><font color="313D7D"><img src="../odimages/odmain/title_icon.gif" width="13" height="13" hspace="1" align="absmiddle"> SMS/메일링 관리 &gt; <span class="st">전체메일발송</span></font></td>
												</tr>
												<tr> 
													<td height="2" bgcolor="D6D6D6"></td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="1" cellpadding="0">
												<tr> 
													<td height="7"></td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="18"><font color="313D7D"><img src="../odimages/odmain/tex_icon.gif" width="5" height="11" hspace="5">가입된 회원분들께 전체적으로 메일을 발송합니다.</font></td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="3"></td>
												</tr>
											</table>
											<table width="760" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td width="760" valign="top">
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<!-- form start -------------------------------------------->
															<form name="snsForm" method="post" action="<?=$php_self?>" onSubmit="return valueCheck(this)">
																<input type="hidden" name="Form" value="sendGroupmail">
																<input type="hidden" name="maildate" value="<?=$row_MD[maildate];?>">
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="#D5D5D5"></td>
															</tr>
															<tr> 
																<td width="150" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">참고사항</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	<b>가장최근 메일링 일시 &nbsp;&nbsp;&nbsp;&nbsp;:</b> &nbsp;<?=$last_MD;?><br>
																	<b>가장최근 메일링 회원수 &nbsp;:</b> &nbsp;<?=number_format($last_num);?>명
																	<br><img src="blank.gif" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* ....</font>
																</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="15" bgcolor="FFFFFF" colspan="2"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td width="150" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">발송대상</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
<?PHP


	// 회원검색에 의한 메일링 처리 - onedaynet jjc - 2011-01-19
	if( sizeof($_GET[memSerialnum]) > 0 ) :
		echo "<input type=\"radio\" name=\"MailPerson\" value=\"SearchMember\" checked>선택회원<b>(" . number_format(sizeof($_GET[memSerialnum])) . "명)</b>";

		foreach( $_GET[memSerialnum] as $k=>$v ){
			echo "<input type=\"hidden\" name=\"memSerialnum[]\" value=\"${v}\">";
		}


	else :
?>
																	<input type="radio" name="MailPerson" value="TEST" checked>테스트(<?=@mysql_result(mysql_query("select email from odtMember where id='admin'"),0)?>)
																	<input type="radio" name="MailPerson" value="All" >전체회원<b>(<?=number_format($mailling_T);?>명)</b>
																	<input type="radio" name="MailPerson" value="Y" >메일링회원<b>(<?=number_format($mailling_Y);?>명)</b>
																	<input type="radio" name="MailPerson" value="SS" >구독회원<b>(<?=number_format($sum_ss);?>명)</b>
<?endif;?>

																	<br>
																	<img src="blank.gif" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 발송 대상을 선택하세요.</font></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="15" bgcolor="FFFFFF" colspan="2"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr style='display:none'> 
																<td width="150" bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">발송조건</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	최근 <input type="text" class="border" name="mailday" size="3"> 일 이내 메일발송된 회원은 제외.<br>
																	<img src="blank.gif" width="1" height="3"><br><font color="313D7D">
																	&nbsp;* 발송조건(숫자로만 입력)을 입력하지 않으면 발송대상으로만 발송됩니다.</font></td>
																</td>
															</tr>
															<tr style='display:none'> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr style='display:none'> 
																<td height="15" bgcolor="FFFFFF" colspan="2"></td>
															</tr>
															<tr style='display:none'> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">메일제목</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	&nbsp;<input type="text" name="subject" class="border" size=55></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td height="15" bgcolor="FFFFFF" colspan="2"></td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
															<tr> 
																<td bgcolor="ececec" class="white" style="padding:5px;"><img src="../odimages/odmain/table_icon.gif" width="5" height="11" hspace="5">메일내용</td>
																<td bgcolor="FAFAFA" style="padding:5px;"> 
																	<table width="99%" border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td colspan="2">
																				&nbsp;<textarea name="comment" class="border" rows="25" cols="95" geditor></textarea>
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr> 
																<td height="1" bgcolor="c0bebe"></td>
																<td height="1" bgcolor="D2D2D2"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="0" cellpadding="0">
															<tr> 
																<td height="10" bgcolor="FFFFFF"></td>
															</tr>
														</table>
														<table width="760" border="0" cellspacing="1" cellpadding="0">
															<tr> 
																<td align="center">
																	<input type="image" src="../odimages/odmain/btn_ok.gif" width="77" height="24" hspace="3" style='cursor:hand;' onfocus='this.blur();'>
																	<a onclick="reset();" onfocus='this.blur();' style='cursor:hand;'><img src="../odimages/odmain/btn_cancel.gif" width="77" height="24" hspace="3" border="0"></a></td>
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
		<script language="Javascript" src="/odprogram/geditor/geditor.js"></script>
	</body>
</html>
<?
	}
	else if(!strcmp($Form,"sendGroupmail")) {


		// 체험판 사용제한
		chk_authfree();

		$mailheaders = "From: [$row_company[name]]<$row_company[email]> \n"; 
		$mailheaders .= "Content-Type: text/html; charset=euc-kr";
		
		if($html == "html") $comment = stripslashes($comment);
		else $comment = nl2br(stripslashes($comment));


		$maildate = time();

		$numT = 0;
		$numY = 0;


		$grpCnt = 100;	// 한번에 보낼 메일 갯수
		$code = time();
		###########################
		## 메일 내용을 저장
		###########################
		mysql_query("insert into odtMailContent set code ='".$code."',subject = '".$subject."', body ='".$comment."', header='".$mailheaders."'");



		$maildate = $maidate;
		$mailday = time() - (trim($mailday) * 86400);

		if($mailday) $mailday_q = "and maildate<'$mailday'";
		else $mailday_q = "";
	
		

		// 회원검색에 의한 메일링 처리 - onedaynet jjc - 2011-01-19
		if( $MailPerson == "SearchMember" ) {

			$arr_mem_data = array();
			$result = mysql_query("SELECT email, name FROM odtMember WHERE  serialnum in ('".@implode("','" , $_POST[memSerialnum])."') ");
			while($row = mysql_fetch_assoc($result)){
				$arr_mem_data[email][] = $row[email];
				$arr_mem_data[name][] = $row[name];
			}

			mysql_query("insert into odtMailLog set email = '".@implode(",",$arr_mem_data[email])."', name = '".@implode(",",$arr_mem_data[name])."', code ='".$code."'");

			$alert_str = "총 ".sizeof($arr_mem_data[email])."건의 메일 발송이 예약되었습니다.";

		}



		else {

			if($MailPerson == "TEST") {
				$result = mysql_query("SELECT serialnum, id, email, name FROM odtMember WHERE  resinum != '' and id='admin'");
			}

			## 메일링 유무에 관계없이 모든 회원에게 발송 ######################
			else if($MailPerson == "All") {
				$result = mysql_query("SELECT serialnum, id, email, name FROM odtMember WHERE  resinum != '' and secession='N' and email !='' $mailday_q group by email");
			}

			## 메일링에 가입한 회원에게만 발송 #################################################
			else if($MailPerson == "Y") {
				$result = mysql_query("SELECT serialnum, id, email, name FROM odtMember WHERE mailling = 'Y' AND  resinum != '' and secession='N' and email !='' $mailday_q group by email");
			}

			## 구독하기 등록 회원에게 발송 #################################################
			else if($MailPerson == "SS") {
				$result = mysql_query("SELECT ft_email as email FROM feedTable WHERE ft_email !='' group by ft_email");
			}

			###################################
			## 메일 보낼 유저들을 저장
			###################################
			while($row = mysql_fetch_array($result)) {
				if(++$idx % $grpCnt == 0) {
					mysql_query("insert into odtMailLog set email = '".@implode(",",$email)."', name = '".@implode(",",$name)."', code ='".$code."'");
					unset($email,$name);
				}
				if($MailPerson == "SS") {
					$row[name] = "구독회원";
				}
				$email[] = trim(str_replace(",","",$row[email]));
				$name[] = trim(str_replace(",","",$row[name]));
			}
			mysql_query("insert into odtMailLog set email = '".@implode(",",$email)."', name = '".@implode(",",$name)."', code ='".$code."'");

			$alert_str = "총 ".$idx."건의 메일 발송이 예약되었습니다.\\n\\n15분간격으로 ".$grpCnt."명에게 메일을 보냅니다.";

		}


		echo "
			<script name=javascript>
				window.alert('$alert_str');
			</script>";

		echo "<meta http-equiv='Refresh' content='0; URL=od_mail.php'>";


	}
	else {
		echo "none";
		exit;
	}

?>