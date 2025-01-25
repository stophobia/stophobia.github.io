<?
	include "../odcommon/od_config.inc.php";
	include "../odcommon/od_function.inc.php";
	include "../odcommon/od_lib.inc.php";
	include "../odcommon/od_head.inc.php";
	include "../odcommon/od_body.inc.php";
	include "../odcommon/od_myPageInclude.php";

	chk_login("$path_home/ododlogon/od_login.php?TarGetURL=$TarGetURL", "로그인 후 사용해 주세요.   ",$row_setup[ranDsum],$addSum);
	
	if(!$Form) {
		$MPoint = number_format($row_member[point]);
		$MSignDate = date("Y년 m월 d일 H시 i분 s초", $row_member[signdate]);
		$MModifyDate = date("Y년 m월 d일 H시 i분 s초", $row_member[modifydate]);
		$MRecentDate = date("Y년 m월 d일 H시 i분 s초", $row_member[recentdate]);
?>
		<script language="javascript">
			function isnum(NUM) {
				for(var i=0;i<NUM.length;i++){
					achar = NUM.substring(i,i+1);
					if( achar < "0" || achar > "9" ){
						return false;
					}
				}
				return true;
			}
			function epLengthCheck(obj) {

				var len = 0; 
					
				for (var i=0; i<obj.value.length; i++) {
					if ( obj.value.substr(i, 1) > '~' ) {
						len+=2;
					} 
					else {
						len++;
					}
				}

				return len;
			}
			function nickCheck(){
				if(!document.snsForm.nickName.value) {
					alert('닉네임을 입력 후 중복확인을 해 주세요.   ');
					snsForm.nickName.focus();
					return;
				}
				
				if(epLengthCheck(document.snsForm.nickName) > 10) {
					alert('닉네임은 한글5자, 영문 및 숫자 10자 이내로 입력해주세요');
					snsForm.nickName.focus();
					return false;
				}


				conflict=	window.open("","conflict","scrollbars=no, resizable=no, width=370, height=229");
				var check_url = "od_checkNick.php?nick=" + encodeURIComponent(document.snsForm.nickName.value);
				conflict.document.location = check_url ;
				conflict.focus() ;
			}
			function valueCheck(form) {
				if (form.passwd.value) {
					if(form.passwd.value.length < 4 || form.passwd.value.length > 12) {
						window.alert("비밀번호는 4자 이상 12자 이하의 숫자/영문 또는 숫자와 영문 조합의 문자열이어야 합니다.   ");
						form.passwd.focus();
						return false;
					}
					if(!form.repasswd.value) {
						window.alert("비밀번호 확인을 위해 비밀번호를 다시 입력하셔야 합니다.   ");
						form.repasswd.focus();
						return false;
					}
					if(form.passwd.value != form.repasswd.value) {
						window.alert("비밀번호가 서로 일치하지 않습니다.   \n\n정확하게 입력해 주세요.   ");
						form.repasswd.focus();
						return false;
					}
				}
				if(!form.nickCheck1.value) {
					alert('닉네임중복확인을 해주시기 바랍니다.');
					return false;
				}				

				if(!form.nickName.value) {
					window.alert("닉네임을 입력해 주세요.   ");
					form.nickName.focus();
					return false;
				}

<?
if($row_member[isRobot] != "Y") {
?>
				if(!form.email.value) {
					window.alert("E-mail을 입력해 주세요.   ");
					form.email.focus();
					return false;
				}
				if((!form.email.value) || ((form.email.value.indexOf("@") == -1) || (form.email.value.indexOf(".") == -1))) {
					window.alert("올바르지않은 E-mail 입니다.   \n\n다시 입력해 주세요.   ");
					form.email.focus();
					return false;
				}
				if(!form.zip1.value) {
					window.alert("우편번호 앞자리를 입력해 주세요.   ");
					form.zip1.focus();
					return false;
				}
				if(!form.zip2.value) {
					window.alert("우편번호 뒷자리를 입력해 주세요.   ");
					form.zip2.focus();
					return false;
				}
				if(!form.zip1.value || form.zip1.value.length != 3 || !isnum(form.zip1.value)) {
					window.alert("올바르지않은 우편번호 입니다.   \n\n다시 입력해 주세요.   ");
					form.zip1.focus();
					return false;
				}
				if(!form.zip2.value || form.zip2.value.length != 3 ||  !isnum(form.zip2.value)) {
					window.alert("올바르지않은 우편번호 입니다.   \n\n다시 입력해 주세요.   ");
					form.zip2.focus();
					return false;
				}
				if(!form.address.value) {
					window.alert("주소를 입력해 주세요.   ");
					form.address.focus();
					return false;
				}
				if(!form.address1.value) {
					window.alert("상세주소지를 입력해 주세요.   ");
					form.address1.focus();
					return false;
				}


<?
}
?>

			}
			function postsearch() {
				  window.open('../odpostcode/od_postsearch.php?Mode=Member','post_find','resizable=yes,scrollbars=yes,width=386,height=410'); 
			}
			function postsearch1() {
				  window.open('../odpostcode/od_postsearch.php?Mode=MemberO','post_find','resizable=yes,scrollbars=yes,width=386,height=410'); 
			}
		</script>

<!-- top 시작 -->
<? include $_SERVER[DOCUMENT_ROOT]."/pages/subHead.html"; ?>
<!-- top 끝 -->
			
								<!-- main start -->


			<form name="snsForm" method="post" action="od_modify.php" onsubmit="return valueCheck(this);" style="display:inline"  enctype="multipart/form-data">
			<input type="hidden" name="Form" value="UpdateMemberInfo">
			<input type="hidden" name="nickCheck1" value="1">




															<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td valign="top">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td height="23"></td>
                                      </tr>
                                    </table>
                                    <table width="716" border="0" align="center" cellpadding="0" cellspacing="0">
                                      <tr>
                                        <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td><img src="/img/modify_img_03.jpg" width="103" height="32" /></td>
                                          </tr>
                                        </table>

                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td height="2" bgcolor="#666666"></td>
                                          </tr>
                                        </table>
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                              <td width="108"><img src="/img/member_img_title__01.jpg" width="108" height="31" /></td>
                                              <td background="/img/member_img_title__13.jpg"><table border="0" cellspacing="0" cellpadding="0" width="100%">
                                                  <tbody>
                                                    <tr>
                                                      <td width="10"></td>
                                                      <td><strong><font color="FF7019"><?=$row_member[id]?></font></strong></td>
                                                      </tr>
                                                  </tbody>
                                              </table></td>
                                            </tr>
                                          </table>
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                              <td width="108"><img src="/img/member_img_title__05.jpg" width="108" height="31" /></td>
                                              <td background="/img/member_img_title__13.jpg"><table border="0" cellspacing="0" cellpadding="0" width="100%">
                                                  <tbody>
                                                    <tr>
                                                      <td width="10"></td>
                                                      <td><strong><?=$row_member[name]?></strong></td>
                                                      </tr>
                                                  </tbody>
                                              </table></td>
                                            </tr>
                                          </table>
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                              <td width="108"><img src="/img/member_img_title__02.jpg" width="108" height="31" /></td>
                                              <td background="/img/member_img_title__13.jpg"><table border="0" cellspacing="0" cellpadding="0" width="100%">
                                                  <tbody>
                                                    <tr>
                                                      <td width="10"></td>
                                                      <td width="10">
																											<input class="gray_3" onchange="this.form.nickCheck1.value=''" maxlength="10" size="24" name="nickName"  value="<?=$row_member[chatNickName]?>"/>
																											</td>
                                                      <td width="8">&nbsp;</td>
                                                      <td width="72"><a href="#none" onclick="nickCheck();" ><img src="/img/member_img_10.jpg" width="99" height="18" border=0 /></a></td>
                                                      <td width="8">&nbsp;</td>
                                                      <td class="pro_best_2">한글 5자 이내, 영문 또는 숫자 
                                                        10자이내</td>
                                                    </tr>
                                                  </tbody>
                                              </table></td>
                                            </tr>
                                          </table>
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                              <td width="108"><img src="/img/member_img_title__03.jpg" width="108" height="31" /></td>
                                              <td background="/img/member_img_title__13.jpg"><table border="0" cellspacing="0" cellpadding="0" width="100%">
                                                  <tbody>
                                                    <tr>
                                                      <td width="10"></td>
                                                      <td width="10">
																											<input class="gray_3" maxlength="12" size="24" type="password" name="passwd" />
																											</td>
                                                      <td width="8">&nbsp;</td>
                                                      <td class="pro_best_2">영, 숫자조합 
                                                        (4~12자), 변경시에만 입력하세요.</td>
                                                    </tr>
                                                  </tbody>
                                              </table></td>
                                            </tr>
                                          </table>
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                              <td width="108"><img src="/img/member_img_title__04.jpg" width="108" height="31" /></td>
                                              <td background="/img/member_img_title__13.jpg"><table border="0" cellspacing="0" cellpadding="0" width="100%">
                                                  <tbody>
                                                    <tr>
                                                      <td width="10"></td>
                                                      <td width="10"><input class="gray_3" maxlength="12" size="24" type="password" name="repasswd" /></td>
                                                      <td width="8">&nbsp;</td>
                                                      <td class="pro_best_2">비밀번호를 다시 한 번 입력하여 
                                                        주십시요.</td>
                                                    </tr>
                                                  </tbody>
                                              </table></td>
                                            </tr>
                                          </table>
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                              <td width="108"><img src="/img/member_img_title__07.jpg" width="108" height="82" /></td>
                                              <td background="/img/member_img_title__14.jpg"><table border="0" cellspacing="0" cellpadding="0" width="100%">
                                                  <tbody>
                                                    <tr>
                                                      <td width="10"></td>
                                                      <td width="60"><input class="gray_4" size="24" name="zip1" value="<?=$row_member[zip1]?>" readonly/></td>
                                                      <td width="15"><div align="center">-</div></td>
                                                      <td width="33"><input class="gray_4" size="24" name="zip2"  value="<?=$row_member[zip2]?>" readonly/></td>
                                                      <td width="8">&nbsp;</td>
                                                      <td class="pro_best_2" width="83"><a href="#none" onclick="postsearch();" ><img src="/img/member_img_12.jpg" width="88" height="18" border=0 /></a></td>
                                                      <td class="pro_best_2" width="8">&nbsp;</td>
                                                      <td class="pro_best_2">입력하시면 구매하실때 
                                                        편리합니다.</td>
                                                    </tr>
                                                  </tbody>
                                                </table>
                                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                      <td height="3"></td>
                                                    </tr>
                                                  </table>
                                                <table border="0" cellspacing="0" cellpadding="0" width="100%">
                                                    <tbody>
                                                      <tr>
                                                        <td width="10"></td>
                                                        <td width="10"><input class="gray_5" size="24" name="address" value="<?=$row_member[address]?>"  readonly/></td>
                                                        <td width="8">&nbsp;</td>
                                                        <td class="pro_best_2">&nbsp;</td>
                                                      </tr>
                                                    </tbody>
                                                  </table>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                      <td height="3"></td>
                                                    </tr>
                                                  </table>
                                                <table border="0" cellspacing="0" cellpadding="0" width="100%">
                                                    <tbody>
                                                      <tr>
                                                        <td width="10"></td>
                                                        <td width="10"><input class="gray_5" size="24" name="address1" value="<?=$row_member[address1]?>" /></td>
                                                        <td width="8">&nbsp;</td>
                                                        <td class="pro_best_2">&nbsp;</td>
                                                      </tr>
                                                    </tbody>
                                                </table></td>
                                            </tr>
                                          </table>
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                              <td width="108"><img src="/img/member_img_title__08.jpg" width="108" height="31" /></td>
                                              <td background="/img/member_img_title__13.jpg"><table border="0" cellspacing="0" cellpadding="0" width="100%">
                                                  <tbody>
                                                    <tr>
                                                      <td width="10"></td>
                                                      <td>
																												<input class="gray_3" size="24" name="tel1" style="width:40px" maxlength="4"  value="<?=$row_member[tel1]?>"/> -
																												<input class="gray_3" size="24" name="tel2" style="width:40px" maxlength="4"  value="<?=$row_member[tel2]?>"/> -
																												<input class="gray_3" size="24" name="tel3" style="width:40px" maxlength="4"  value="<?=$row_member[tel3]?>"/>		
                                                      </td>
                                                      <td width="8">&nbsp;</td>
                                                      <td class="pro_best_2">&nbsp;</td>
                                                    </tr>
                                                  </tbody>
                                              </table></td>
                                            </tr>
                                          </table>
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                              <td width="108"><img src="/img/member_img_title__09.jpg" width="108" height="31" /></td>
                                              <td background="/img/member_img_title__13.jpg"><table border="0" cellspacing="0" cellpadding="0" width="100%">
                                                  <tbody>
                                                    <tr>
                                                      <td width="10"></td>
                                                      <td>
																											<input class="gray_3" size="24" name="htel1" style="width:40px" maxlength="4" value="<?=$row_member[htel1]?>" /> -
																											<input class="gray_3" size="24" name="htel2" style="width:40px" maxlength="4" value="<?=$row_member[htel2]?>" /> -
																											<input class="gray_3" size="24" name="htel3" style="width:40px" maxlength="4" value="<?=$row_member[htel3]?>" />			
                                                      </td>
                                                      <td width="8">&nbsp;</td>
                                                      <td class="pro_best_2">&nbsp;</td>
                                                    </tr>
                                                  </tbody>
                                              </table></td>
                                            </tr>
                                          </table>
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                              <td width="108"><img src="/img/modify_img_04.jpg" width="108" height="82" /></td>
                                              <td background="/img/member_img_title__14.jpg"><table border="0" cellspacing="0" cellpadding="0" width="100%">
                                                  <tbody>
                                                    <tr>
                                                      <td width="10"></td>
                                                      <td>
                                      <?
$imgName = "pic";
if($row_member[$imgName]) {
?>
                                      <img src="<?=$row_member[$imgName]?>" width=70 height=70 border=0 align=absmiddle style='border:1px solid #eeeeee'></a> 
                                      <input type="hidden" name="<?=$imgName?>_org" value="<?=$row_member[$imgName]?>"> 
                                      <input type="checkbox" name="<?=$imgName?>_del" value="Y">
                                      삭제 
                                      <?
}
?>																											
																												<input type="file" name="pic" size=20 class=gray_3 style="width:200px">
																												(70x70 jpg/gif) 

																											</td>
																											<td width="8">&nbsp;</td>
																											<td class="pro_best_2">&nbsp; </td>
                                                    </tr>
                                                  </tbody>
                                                </table>
																							</td>
                                            </tr>
                                          </table>
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                              <td width="108"><img src="/img/member_img_title__10.jpg" width="108" height="31" /></td>
                                              <td background="/img/member_img_title__13.jpg"><table border="0" cellspacing="0" cellpadding="0" width="100%">
                                                  <tbody>
                                                    <tr>
                                                      <td width="10"></td>
                                                      <td width="10"><input class="gray_3" size="24" name="email" style="width:200px"  value="<?=$row_member[email]?>"/></td>
                                                      <td width="8">&nbsp;</td>
                                                      <td class="pro_best_2">메일수신이 가능한 이메일주소 </td>
                                                    </tr>
                                                  </tbody>
                                              </table></td>
                                            </tr>
                                          </table>
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                              <td width="108"><img src="/img/member_img_title__11.jpg" width="108" height="31" /></td>
                                              <td background="/img/member_img_title__13.jpg"><table border="0" cellspacing="0" cellpadding="0" width="100%">
                                                  <tbody>
                                                    <tr>
                                                      <td width="10"></td>
                                                      <td width="10"><input type="radio" value="Y" name="mailling" <?=$row_member[mailling]=="Y" ? "checked" : NULL;?> /></td>
                                                      <td width="20">예</td>
                                                      <td class="pro_best_2" width="10"><input type="radio" value="N" name="mailling" <?=$row_member[mailling]=="N" ? "checked" : NULL;?> /></td>
                                                      <td class="pro_best_2" width="60">아니요</td>
                                                      <td class="pro_best_2">이벤트, 제품 정보에 대한 메일링 서비스</td>
                                                    </tr>
                                                  </tbody>
                                              </table></td>
                                            </tr>
                                          </table>
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                              <td width="108"><img src="/img/member_img_title__12.jpg" width="108" height="32" /></td>
                                              <td background="/img/member_img_title__15.jpg"><table border="0" cellspacing="0" cellpadding="0" width="100%">
                                                  <tbody>
                                                    <tr>
                                                      <td width="10"></td>
                                                      <td width="10"><input type="radio" value="Y" name="sms"  <?=$row_member[sms]=="Y" ? "checked" : NULL;?> /></td>
                                                      <td width="20">예</td>
                                                      <td class="pro_best_2" width="10"><input type="radio" value="N" name="sms"  <?=$row_member[sms]=="N" ? "checked" : NULL;?>  /></td>
                                                      <td class="pro_best_2" width="60">아니요</td>
                                                      <td class="pro_best_2">이벤트, 제품 정보에 대한 SMS 서비스</td>
                                                    </tr>
                                                  </tbody>
                                              </table></td>
                                            </tr>
                                          </table>
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                              <td>&nbsp;</td>
                                            </tr>
                                          </table>
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                              <td><div align="center"><input type="image" src="/img/member_img_title__16.jpg" width="75" height="30" border=0 /></div></td>
                                            </tr>
                                          </table></td>
                                      </tr>
                                    </table></td>
                                </tr>
                              </table>
			</form>
<!-- main end -->


<? include $_SERVER[DOCUMENT_ROOT]."/pages/subFoot.html"; ?>

<?
	}
	else if(!strcmp($Form,"UpdateMemberInfo")) {
		// 비밀번호 입력하지 않은경우 이전 비밀 번호 유지
		if(!$passwd) {
			$pw_row = mysql_fetch_array(mysql_query("SELECT * FROM odtMember WHERE id='$row_member[id]'"));

			$passwd = $pw_row[passwd];
			$repasswd = $row_member[repasswd];
		}
		else {
			if(!ereg("[[:alnum:]+]{4,8}",$passwd)) {
				error_msgback_user('비밀번호는 4자이상 8자이하 영문, 숫자 또는 영문/숫자 조합이어야 합니다.   ');
			}
			
			## 비밀번호 입력한 경우 비밀번호 암호화
			$pw_result = mysql_query("SELECT password('$passwd')");
			$passwd = mysql_result($pw_result,0,0);
		}

		$mod_row = mysql_fetch_array(mysql_query("SELECT * FROM odtMember WHERE id='$row_member[id]'"));
		
		if(!$recomid) $recomid = $mod_row[recomid];
		if(!$calendar) $calendar = $mod_row[calendar];
		if(!$birthy) $birthy = $mod_row[birthy];
		if(!$birthm) $birthm = $mod_row[birthm];
		if(!$birthd) $birthd = $mod_row[birthd];
		if(!$interest) $interest = $mod_row[interest];
		if(!$marriage) $marriage = $mod_row[marriage];
		if(!$weddingy) $weddingy = $mod_row[weddingy];
		if(!$weddingm) $weddingm = $mod_row[weddingm];
		if(!$weddingd) $weddingd = $mod_row[weddingd];
		if(!$finalsch) $finalsch = $mod_row[finalsch];
		if(!$oname) $oname = $mod_row[oname];
		if(!$ozip1) $ozip1 = $mod_row[ozip1];
		if(!$ozip2) $ozip2 = $mod_row[ozip2];
		if(!$oaddress) $oaddress = $mod_row[oaddress];
		if(!$otel1) $otel1 = $mod_row[otel1];
		if(!$otel2) $otel2 = $mod_row[otel2];
		if(!$otel3) $otel3 = $mod_row[otel3];
		if(!$ofax1) $ofax1 = $mod_row[ofax1];
		if(!$ofax2) $ofax2 = $mod_row[ofax2];
		if(!$ofax3) $ofax3 = $mod_row[ofax3];
		if(!$odept) $odept = $mod_row[odept];
		if(!$opost) $opost = $mod_row[opost];
		if(!$mincome) $mincome = $mod_row[mincome];
		if(!$course) $course = $mod_row[course];
		
		$modifydate = time();

		# 파일 삭제
		$pic_org			= $pic_del			== "Y" || $pic[name]			? @unlink($_SERVER[DOCUMENT_ROOT].$pic_org)			: $pic_org;

		# 파일 업로드
		$dir = "/odprogram/upfiles/member";
		$pic			= $pic[name]			? file_upload_resize($_FILES[pic],$dir,70,70)		: $pic_org;
		
		$result = mysql_query("UPDATE odtMember SET																	
													passwd				='$passwd',
													repasswd			='$repasswd',
													chatNickname	='$nickName',
													email					='$email',
													zip1					='$zip1',
													zip2					='$zip2',
													address				='$address',
													address1			='$address1',
													tel1					='$tel1',
													tel2					='$tel2',
													tel3					='$tel3',
													htel1					='$htel1',
													htel2					='$htel2',
													htel3					='$htel3',
													job						='$job',
													mailling			='$mailling',
													sms						='$sms',
													calendar			='$calendar',
													birthy				='$birthy',
													birthm				='$birthm',
													birthd				='$birthd',
													interest			='$interest',
													marriage			='$marriage',
													weddingy			='$weddingy',
													weddingm			='$weddingm',
													weddingd			='$weddingd',
													finalsch			='$finalsch',
													oname					='$oname',
													ozip1					='$ozip1',
													ozip2					='$ozip2',
													oaddress			='$oaddress',
													oaddress1			='$oaddress1',
													otel1					='$otel1',
													otel2					='$otel2',
													otel3					='$otel3',
													ofax1					='$ofax1',
													ofax2					='$ofax2',
													ofax3					='$ofax3',
													odept					='$odept',
													opost					='$opost',
													pic						='$pic',
													mincome				='$mincome',
													motive				='$motive',
													course				='$course',
													modifydate		='$modifydate' 
													WHERE 
													id						='$row_member[id]'");

		/*

		##########################
		## 사진 등록이벤트!!! 3월 이후 삭제
		##########################
		function eventPic($id) {
			$isPic = mysql_result(mysql_query("select count(*) from odtEventPic where id='".$id."'"),0);
			if(!$isPic) {	// 사진을 처음등록했을시.

				mysql_query("insert into odtEventPic set id='".$id."', regidate = now()");	// 이벤트 지급 내역을 남김
				mysql_query("insert into odtPointLog set 
											pointID				='".$id."', 
											pointTitle		='사진등록 이벤트', 
											pointPoint		='1000',
											pointResult		=(select point from odtMember where id='".$id."')+1000, 
											pointStatus		='Y', 
											pointRegidate = now()");
				mysql_query("update odtMember set point = point + 1000 where id ='".$id."'");
				error_msgall("사진등록 이벤트에 참여해주셔서 감사드립니다.\\n\\n지포인트 1,000p 가 지급되었습니다.");
			}
		}

		if(time() > strtotime("2009-02-01 00:00:00") && time() < strtotime("2009-03-01 00:00:00")) {
			if($pic) eventPic($row_member[id]);	// 사진이 있다면, 함수 호출
		}
		*/
		##########################
		## 사진 등록이벤트 끝!!!
		##########################


		if(!$result) {
			error_msgback_user("$row_member[name]님의 정보가 수정되지 않았습니다.   ");
		}
		else {
			error_msgloc("$path_home/odmembers/od_modify.php","$row_member[name]님의 정보가 수정 되었습니다.   ");
		}
	}
?>