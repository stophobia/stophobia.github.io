<?
	include "../odcommon/od_config.inc.php";
	include "../odcommon/od_function.inc.php";
	include "../odcommon/od_lib.inc.php";
	include "../odcommon/od_head.inc.php";
	include "../odcommon/od_body.inc.php";
	include "od_board.inc.php";

	// 체험판 사용제한
	chk_authfree();

	## 글쓰기 권한체크
	if($configWriteLevel > $Cooki_Member_Level) historyBack();
	//authorityTest("Write");

	## Par 정리 ##
	$parTemp = "?board=$board";
	if($page) $parTemp .= "&page=$page";
	if($field) $parTemp .= "&field=$field";
	if($value) $parTemp .= "&value=$value";

	## 로그인 후 현재 페이지를 유지하기 위한 경로 지정 ##################
	$_target_path = $PHP_SELF."?Mode=insertForm&board=".$board."&page=".$page."&field=".$field."&value=".$value;
	$_target_path = eregi_replace("&", "@", $_target_path);

	## 입력폼 출력 #########################################################################
	if($Mode == "insertForm") {
?>

		<script>
		<!--
			function checkLength(ojbName,str,maxLength) { 
				var len = str.length; 
				var han = 0; 
				var res = 0; 
				for(i=0;i<len;i++) { 
					var a=str.charCodeAt(i); 
					if(a>128) han++; 
				} 
				res = (len-han) + (han*2); 
				if(res > maxLength) {
					alert(ojbName+'의 글자수가 '+maxLength+'를 넘었습니다.');
					return false;
				}else {
					return true;
				}
				return true;
			}
			function emailCheck (emailStr) {
				var checkTLD=1;
				var knownDomsPat=/^(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum)$/;
				var emailPat=/^(.+)@(.+)$/;
				var specialChars="\\(\\)><@,;:\\\\\\\"\\.\\[\\]";
				var validChars="\[^\\s" + specialChars + "\]";
				var quotedUser="(\"[^\"]*\")";
				var ipDomainPat=/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/;
				var atom=validChars + '+';
				var word="(" + atom + "|" + quotedUser + ")";
				var userPat=new RegExp("^" + word + "(\\." + word + ")*$");
				var domainPat=new RegExp("^" + atom + "(\\." + atom +")*$");
				var matchArray=emailStr.match(emailPat);
				if (matchArray==null) {
					alert("Email 주소가 올바르지 않습니다. ( @ 와 '.'를 확인하세요.)");
					return false;
				}
				var user=matchArray[1];
				var domain=matchArray[2];
				for (i=0; i<user.length; i++) {
					if (user.charCodeAt(i)>127) {
						alert("username에 적절하지 않는 문자가 들어갔습니다.");
						return false;
					}
				}
				for (i=0; i<domain.length; i++) {
					if (domain.charCodeAt(i)>127) {
						alert("domain에 적절하지 않는 문자가 들어갔습니다.");
						return false;
					}
				}
				if (user.match(userPat)==null) {
					alert("username이 부정확합니다.");
					return false;
				}
				var IPArray=domain.match(ipDomainPat);
				if (IPArray!=null) {
					for (var i=1;i<=4;i++) {
						if (IPArray[i]>255) {
							alert("보낼 IP address가 부정확합니다.");
							return false;
						}
					}
					return true;
				}
				var atomPat=new RegExp("^" + atom + "$");
				var domArr=domain.split(".");
				var len=domArr.length;
				for (i=0;i<len;i++) {
					if (domArr[i].search(atomPat)==-1) {
						alert("domain이 부정확합니다.");
						return false;
					}
				}
				if (checkTLD && domArr[domArr.length-1].length!=2 && domArr[domArr.length-1].search(knownDomsPat)==-1) {
					alert("E-mail 주소가 올바르지 않습니다.   ");
					return false;
				}
				if (len<2) {
					alert("호스트이름을 쓰셔야 합니다.");
					return false;
				}
				return true;
			}
			function urlCheck (urlStr) {
				formTemp = document.insertForm;
				var checkTemp = /(http|ftp|https):\/\/[-A-Za-z0-9._/]+/;
				if(urlStr.match(checkTemp)) {
					return true;
				} else {
					alert("URL이 잘 못 되었습니다.");
					formTemp.homepage.focus();
					return false;
				}
				return true;
			}
			function trimStr (strTemp) {
				return strTemp.replace(/(^\s*)|(\s*$)/g, "");
			}
			function formCheck() {
				formTemp = document.insertForm;
				if(trimStr(formTemp.writer.value) == '') {
					alert('등록자를 입력해 주세요.');
					formTemp.writer.focus();
					return false;
				}
				if(!checkLength(formTemp.writer.name,formTemp.writer.value,50)) {
					return false;
				}
				if(formTemp.email && formTemp.email.value != '') {
					if(!emailCheck(formTemp.email.value) || !checkLength(formTemp.email.name,formTemp.email.value,100)) {
						return false;
					}
				}
				if(formTemp.homepage && formTemp.homepage.value != 'http://' && formTemp.homepage.value != '') {
					if(!urlCheck(formTemp.homepage.value) && !checkLength(formTemp.homepage.name,formTemp.homepage.value,100)) {
						return false;
					}
				}
				if(trimStr(formTemp.title.value) == '') {
					alert('글제목을 입력해 주세요.');
					formTemp.title.focus();
					return false;
				}
				if(!checkLength(formTemp.title.name,formTemp.title.value,200)){
					return false;
				}
				if(trimStr(formTemp.content.value) == '') {
					alert('글내용을 입력해 주세요.');
					formTemp.content.focus();
					return false;
				}
				if(trimStr(formTemp.password.value) == '') {
					alert('비밀번호를 입력해 주세요.');
					formTemp.password.focus();
					return false;
				}
				if(!checkLength(formTemp.password.name,formTemp.password.value,12)) {
					return false;
				}
				return true;		
			}
			function checkHomepage(text) {
				var formTemp = document.insertForm;
				var str = formTemp.homepage.value;
				str = str.toLowerCase();
				if(str.substring(0, 7) == "http://") { // http:// 가 입력이 되어 있을때
					formTemp.homepage.value = str;
				}else {
					if(text.indexOf("http://",0) <= 0) { // http:// 가 입력이ㅣ 안되어 있을때
						text = "http://" +text;
						formTemp.homepage.value = text;
					}
				}
			}
		//-->
		</script>

<!-- top 시작 -->
<? include $_SERVER[DOCUMENT_ROOT]."/pages/subHead.html"; ?>
<!-- top 끝 -->

								<!-- main start -->
								<!-- 보드 설명부분 시작 -->
								<table width="677" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td height="30" valign="top" class="locat">
											<!-- form start -->
											<table width="677" border="0" cellspacing="0" cellpadding="0">
												<form method='post' enctype='multipart/form-data' action='<?=$PHP_SELF?>' name="insertForm" onsubmit="return formCheck();">
													<input type='hidden' name='Mode' value='insertPro'>
													<input type='hidden' name='board' value='<?=$board?>'>
													<input type='hidden' name='page' value='<?=$page?>'>
												<tr> 
													<td width="2" height="2"><img src="../odimages/odorder/orderw_p01.gif" width="2" height="2"></td>
													<td height="2" background="../odimages/odorder/orderw_pbg1.gif"></td>
													<td width="2" height="2"><img src="../odimages/odorder/orderw_p02.gif" width="2" height="2"></td>
												</tr>
												<tr> 
													<td width="2" background="../odimages/odorder/orderw_pbg4.gif"></td>
													<td style="padding:20px;">
														<table border="0" cellpadding="0" cellspacing="0" align="center">
															<tr> 
																<td width="80" height="32" class="cate"><img src="../odimages/odshop/icon_dot2.gif" width="8" height="11">이름</td>
																<td width="15">:</td>
																<td width="560"> 
																	<input name="writer" type="text" class="gray" size="25" value="<?=$row_member[name]?>">
<? 
		if(($row_member[id] && $row_member[Mlevel]>8) && ($board<>3 && $board<>1 && $board<>2)) { 
?>
																	<input type="checkbox" name="notice" value="Y">공지글로 지정합니다.
<?
		}
?>
																</td>
															</tr>
															<tr> 
																<td height="1" colspan="3" background="../odimages/odorder/dot_w.gif"></td>
															</tr>
															<tr> 
																<td height="32" class="cate"><img src="../odimages/odshop/icon_dot2.gif" width="8" height="11">비밀번호</td>
																<td>:</td>
																<td><input name="password" type="password" class="gray" size="25" maxlength="12">&nbsp;&nbsp;(4자이상 12자이하/영문 및숫자 조합)</td>
															</tr>
															<tr> 
																<td height="1" colspan="3" background="../odimages/odorder/dot_w.gif"></td>
															</tr>
<?
		if($configPrivacyUsed == "Yes") { 
?>
															<tr> 
																<td height="32" class="cate"><img src="../odimages/odshop/icon_dot2.gif" width="8" height="11">비밀글</td>
																<td>:</td>
																<td>
																	<input type="radio" name="privacy" value="Y">사용함&nbsp;&nbsp;
																	<input type="radio" name="privacy" value="N" checked>사용 하지 않음</td>
															</tr>
															<tr> 
																<td height="1" colspan="3" background="../odimages/odorder/dot_w.gif"></td>
															</tr>
<? 
		}
		else { 
?>
															<input type="hidden" name="privacy" value="N">
<? 
		} 

		if($configEmailUsed == "Yes") { 
?>
															<tr> 
																<td height="32" class="cate"><img src="../odimages/odshop/icon_dot2.gif" width="8" height="11">E-Mail</td>
																<td>:</td>
																<td><input name="email" type="text" class="gray" size="46" value="<?=$row_member[email];?>"></td>
															</tr>
															<tr> 
																<td height="1" colspan="3" background="../odimages/odorder/dot_w.gif"></td>
															</tr>
<? 
		} 

		if($configHomepageUsed == "Yes") { 
?>
															<tr> 
																<td height="32" class="cate"><img src="../odimages/odshop/icon_dot2.gif" width="8" height="11">홈페이지</td>
																<td>:</td>
																<td><input name="homepage" type="text" class="gray" size="46" value="http://" onkeypress="checkHomepage(document.insertForm.homepage.value);"></td>
															</tr>
															<tr> 
																<td height="1" colspan="3" background="../odimages/odorder/dot_w.gif"></td>
															</tr>
<? 
		} 
?>
															<tr> 
																<td height="32" class="cate"><img src="../odimages/odshop/icon_dot2.gif" width="8" height="11">글제목</td>
																<td>:</td>
																<td><input name="title" type="text" class="gray" size="87" style="width:100%"></td>
															</tr>
															<tr> 
																<td height="1" colspan="3" background="../odimages/odorder/dot_w.gif"></td>
															</tr>
															<tr> 
																<td height="155" class="cate"><img src="../odimages/odshop/icon_dot2.gif" width="8" height="11">글내용</td>
																<td>:</td>
																<td style="padding-top:4;padding-bottom:8;"><textarea name="content" cols="85" rows="10" class="gray" style="width:100%;height:300px" geditor></textarea></td>
															</tr>
<? 
		for($fileNum=1;$fileNum<=$configFileNum;$fileNum++) { 
?>
															<input type="hidden" name="replyused" value="Yes">
															<tr> 
																<td height="1" colspan="3" background="../odimages/odorder/dot_w.gif"></td>
															</tr>
															<tr> 
																<td height="32" class="cate"><img src="../odimages/odshop/icon_dot2.gif" width="8" height="11">첨부파일 <?=$fileNum?></td>
																<td>:</td>
																<td><input name="file<?=$fileNum?>" type="file" class="gray" size="66"> </td>
															</tr>
<? 
			if($configBoardType == "ImageBoard") { 
?>
															<tr> 
																<td height="1" colspan="3" background="../odimages/odorder/dot_w.gif"></td>
															</tr>
															<tr> 
																<td height="32" class="cate"><img src="../odimages/odshop/icon_dot2.gif" width="8" height="11">이미지설명 <?=$fileNum?></td>
																<td>:</td>
																<td><textarea name="filecomment<?=$fileNum?>" cols="85" rows="7" class="gray"></textarea></td>
															</tr>
<? 
			} 
		} 
?>
														</table>
													</td>
													<td background="../odimages/odorder/orderw_pbg2.gif"></td>
												</tr>
												<tr> 
													<td width="2" height="2"><img src="../odimages/odorder/orderw_p04.gif" width="2" height="2"></td>
													<td height="2" background="../odimages/odorder/orderw_pbg3.gif"></td>
													<td width="2" height="2"><img src="../odimages/odorder/orderw_p03.gif" width="2" height="2"></td>
												</tr>
											</table>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr> 
													<td height="60" align="center"><input type="image" src="<?=$board_ok_img?>" hspace="3"><a href="<?=$boardmoveTemp?>?board=<?=$board?>" onfocus='this.blur();'><img src="<?=$board_cancel_img?>" hspace="3" border="0"></a></td>
												</tr>
												</form>
											</table>
										  <!-- form end -->
										</td>
									</tr>
								</table>

<script language="Javascript" src="/odprogram/geditor/geditor.js"></script>
<? include $_SERVER[DOCUMENT_ROOT]."/pages/subFoot.html"; ?>


<?
	}
	else if($Mode == "insertPro") {
		if(!$board) {
			echo "
				<script>
					window.alert(\"해당 게시판이 없습니다.!\");
					history.go(-1);
				</script>";

			exit;
		}

		if(!$writer) {
			echo "
				<script>
					window.alert(\"이름을 입력해 주세요!\");
					history.go(-1);
				</script>";

			exit;
		}

		if(!$password) {
			echo "
				<script>
					window.alert(\"비밀번호를 입력해 주세요!\");
					history.go(-1);
				</script>";

			exit;
		}

		if(!$title) {
			echo "
				<script>
					window.alert(\"제목을 입력해 주세요!\");
					history.go(-1);
				</script>";

			exit;
		}

		if(!$content) {
			echo "
				<script>
					window.alert(\"내용을 입력해 주세요!\");
					history.go(-1);
				</script>";

			exit;
		}

		## 필터적용하기 #####
		$FilterTemp = explode(',',$configFilter);
		for($i=0;$i<count($FilterTemp);$i++) {
			if($FilterTemp[$i]){
				$pos = strpos($content,$FilterTemp[$i]);
				
				if($pos !== false) {
					echo "
						<script>
							window.alert(\"사용불가 단어를 사용하였습니다.   \");
							history.go(-1);
						</script>";

					exit;
				}
			}
		}	

		$writer = addslashes($writer);
		$title = addslashes($title);
		$email = addslashes($email);
		$homepage = addslashes($homepage);
		$ip = addslashes($REMOTE_ADDR);
		
		if($htmls == "N") $content = DisableHTML($content);
		else $content =EnableHTML($content);
		
		$content = addslashes($content);
		
		if($password) $password = crypt($password);
		
		if($configBoardType == "ImageBoard") $filekind = "jpg/gif";
		else $filekind = "";
		
		for($i=1;$i<=5;$i++) {
			if(${"file$i"} != "none" && ${"file".$i."_name"} != "") 
				${"fileNameTemp$i"} = fileUpload(${"file$i"},${"file".$i."_name"},'N',$filekind,$configFileFilter);
			else ${"fileNameTemp$i"} = "";
		}

		## serialnum 구하기 ######
		$query="SELECT IFNULL(max(serialnum),0) + 1 FROM odtBoard";
		$result=mysql_query($query,$connect);
		$row= mysql_fetch_array($result);
		
		$serialnum = $row[0];
		
		if(!$privacy) $privacy = "N";
		if(!$row_member[id]) $row_member[id] = "guest";
		if(!$notice) $notice = "N";
		
		$INquery="INSERT INTO odtBoard VALUES ( '$serialnum','$serialnum','A','$board','$writer','$row_member[id]','$privacy','$email','$homepage','$ip','$password','$htmls','$title','$content','$fileNameTemp1','$filecomment1','$fileNameTemp2','$filecomment2','$fileNameTemp3','$filecomment3','$fileNameTemp4','$filecomment4','$fileNameTemp5','$filecomment5',now(),0,'','','$notice')";
		$INresult = mysql_query($INquery, $connect);


		
		if($INresult) {
			echo "
				<script>
					window.alert('글이 등록되었습니다.   ');
				</script>";

			echo "<meta http-equiv='refresh' content='0; URL=$boardmoveTemp?board=$board'>";
			exit;
		}
		else {
			echo "
				<script>
					window.alert(\"DB 접속 에러입니다!\");
					history.go(-1);
				</script>";

			exit;
		}
	}
?>