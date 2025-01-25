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

	$_target_path = $PHP_SELF."?Mode=modifyForm&board=".$board."&serialnum=".$serialnum."&page=".$page."&field=".$field."&value=".$value;
	$_target_path = eregi_replace("&", "@", $_target_path);

	if($Mode == "modifyForm") {
		$result = mysql_query("SELECT * FROM odtBoard WHERE serialnum=$serialnum");
		$row = mysql_fetch_array($result);
		
		if($Cooki_Member_Level != 9 && $row_member[id] != $row[writerid]) {
			$passwordDB = $row[password];		
			
			if(crypt($password,$passwordDB) != $passwordDB) { 
				error_msgback_user("비밀번호가 정확하지 않습니다.   "); 
			}
		}
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
				} else {
					return true;
				}
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
					alert("Email 주소가 부적확합니다. ( @ 와 '.'를 확인하세요.)");
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
				var checkTemp = /(http|ftp|https):\/\/[-A-Za-z0-9._/]+/;
				if(urlStr.match(checkTemp)) {
					return true;
				}else {
					alert("URL이 잘 못 되었습니다.");
					return false;
				}
			}
			function trimStr (strTemp) {
				return strTemp.replace(/(^\s*)|(\s*$)/g, "");
			}
			function formCheck() {
				formTemp = document.insertForm;
				if(trimStr(formTemp.writer.value) == '') {
					alert('작상자이름을 넣으셔야 합니다.');
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
				if(formTemp.homepage && formTemp.homepage.value != 'http://') {
					if(!urlCheck(formTemp.homepage.value) && !checkLength(formTemp.homepage.name,formTemp.homepage.value,100)) {
						return false;
					}
				}
				if(trimStr(formTemp.title.value) == '') {
					alert('제목을 넣으셔야 합니다.');
					return false;
				}
				if(!checkLength(formTemp.title.name,formTemp.title.value,200)){
					return false;
				}
				if(trimStr(formTemp.content.value) == '') {
					alert('내용을 넣으셔야 합니다.');
					return false;
				}
				if(trimStr(formTemp.password.value) == '') {
					alert('비밀번호를 넣으셔야 합니다.');
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

											<!-- form start -->
											<table width="677" border="0" cellspacing="0" cellpadding="0">
												<form method='post' enctype='multipart/form-data' action='<?=$PHP_SELF?>' name="insertForm" onsubmit="return formCheck();">
													<input type='hidden' name='Mode' value='modifyPro'>
													<input type='hidden' name='board' value='<?=$board?>'>
													<input type='hidden' name='serialnum' value='<?=$serialnum?>'>
													<input type='hidden' name='page' value='<?=$page?>'>
													<input type='hidden' name='field' value='<?=$field?>'>
													<input type='hidden' name='value' value='<?=$value?>'>
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
																	<input name="writer" type="text" class="gray" size="25" value="<?=stripslashes($row[writer])?>">
<? 
		if(($row_member[id] && $row_member[Mlevel]>8) && ($board<>3 && $board<>1 && $board<>2)) { 
?>
																	<input type="checkbox" name="notice" value="Y" <?if($row[notice]=="Y")echo"checked";?>>공지글로 지정합니다.
<?
		} 
?>
																</td>
															</tr>
															<tr> 
																<td height="1" colspan="3" background="../odimages/odorder/dot_w.gif"></td>
															</tr>
<? 
		if($row[privacy] != "Y") { 
?>
															<tr> 
																<td height="32" class="cate"><img src="../odimages/odshop/icon_dot2.gif" width="8" height="11">비밀번호</td>
																<td>:</td>
																<td><input name="password" type="password" class="gray" size="25" maxlength="12">&nbsp;&nbsp;(4자이상 12자이하/영문 및숫자 조합)</td>
															</tr>
															<tr> 
																<td height="1" colspan="3" background="../odimages/odorder/dot_w.gif"></td>
															</tr>
<? 
		}
		else { 
?>
															<input name="password" type="hidden" value="TempPasswd">
<? 
		} 

		if($configEmailUsed == "Yes") { 
?>
															<tr> 
																<td height="32" class="cate"><img src="../odimages/odshop/icon_dot2.gif" width="8" height="11">E-Mail</td>
																<td>:</td>
																<td><input name="email" type="text" class="gray" size="46" value="<?=$row[email]?>"></td>
															</tr>
															<tr> 
																<td height="1" colspan="3" background="../odimages/odorder/dot_w.gif"></td>
															</tr>
<? 
		} 

		if($configHomepageUsed == "Yes") { 
			if(!$row[homepage]) $row[homepage] = "http://"; 
?>
															<tr> 
																<td height="32" class="cate"><img src="../odimages/odshop/icon_dot2.gif" width="8" height="11">홈페이지</td>
																<td>:</td>
																<td><input name="homepage" type="text" class="gray" size="46" value="<?=$row[homepage]?>" onkeypress="checkHomepage(document.insertForm.homepage.value);"></td>
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
																<td><input name="title" type="text" class="gray" size="87" value='<?=stripslashes($row[title])?>' style="width:100%"></td>
															</tr>
															<tr> 
																<td height="1" colspan="3" background="../odimages/odorder/dot_w.gif"></td>
															</tr>
															<tr> 
																<td height="155" class="cate"><img src="../odimages/odshop/icon_dot2.gif" width="8" height="11">글내용</td>
																<td>:</td>
																<td style="padding-top:4;padding-bottom:8;">
																	<textarea name="content" cols="85" rows="10" class="gray" style="width:100%;height:300px" geditor><?=stripslashes($row[content])?></textarea></td>
															</tr>
<? 
		for($fileNum=1;$fileNum<=$configFileNum;$fileNum++) { 
?>
															<input type="hidden" name="oldfilename<?=$fileNum?>" value="<?=$row["file$fileNum"]?>">
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
															<input type="hidden" name="replyused" value="Yes">
															<tr> 
																<td height="1" colspan="3" background="../odimages/odorder/dot_w.gif"></td>
															</tr>
															<tr> 
																<td height="32" class="cate"><img src="../odimages/odshop/icon_dot2.gif" width="8" height="11">이미지설명 <?=$fileNum?></td>
																<td>:</td>
																<td><textarea name="filecomment<?=$fileNum?>" cols="85" rows="7" class="gray"><?=$row["filecomment$fileNum"]?></textarea></td>
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


<? include $_SERVER[DOCUMENT_ROOT]."/pages/subFoot.html"; ?>

<script language="Javascript" src="/odprogram/geditor/geditor.js"></script>
<?
	} 
	else if($Mode == "modifyPro") {
		$writer = addslashes($writer);
		$title = addslashes($title);
		$email = addslashes($email);
		$homepage = addslashes($homepage);
		$ip = addslashes($REMOTE_ADDR);
		
		if($htmls == "N") $content = DisableHTML($content);
		else $content =EnableHTML($content);

		$content = addslashes($content);
		
		## 수정내용 : 아래 비밀번호 암호처리부분을 주석처리 함.
		//if($password) $password = crypt($password);
		
		if($configBoardType == "ImageBoard") $filekind = "jpg/gif";
		else $filekind = "";
		
		for($i=1;$i<=5;$i++) {
			if(${"file$i"} != "none" && ${"file".$i."_name"} != "") {
				if(${"oldfilename$i"} != "") {
					$fileC = file_exists("$folderpath_board_upload/".${"oldfilename$i"});
					
					if($fileC) unlink("$folderpath_board_upload/".${"oldfilename$i"});
				}

				${"fileNameTemp$i"} = fileUpload(${"file$i"},${"file".$i."_name"},'N',$filekind,$configFileFilter);
			} 
			else {
				${"fileNameTemp$i"} = ${"oldfilename$i"};
			}
		}

		## 필터적용하기 #####
		$FilterTemp = explode(',',$configFilter);
		for($i=0;$i<count($FilterTemp);$i++) {
			if($FilterTemp[$i]){
				$pos = strpos($content,$FilterTemp[$i]);
				
				if($pos) {
					echo "
						<script>
							window.alert(\"사용불가 단어를 사용하였습니다.   \");
							history.go(-1);
						</script>";

					exit;
				}
			}
		}

		## 비밀글인 경우 기존 비밀번호를 유진한다. ##
		$passwd_result = mysql_query("SELECT * FROM odtBoard WHERE serialnum=$serialnum");
		$passwd_row = mysql_fetch_array($passwd_result);
		
		if($passwd_row[privacy] == "Y") $password = $passwd_row[password];
		else if($password) $password = crypt($password);
		
		/*
		if($privacy == "Y") {
			## 일반글이었다가 비밀글로 되는 경우 답변글도 모두 비빌글로 지정 ######################################
			$privacyquery = "UPDATE odtBoard SET privacy='$privacy', password='$password' WHERE familyid=$serialnum";
			$privacyresult = mysql_query($privacyquery, $connect);
		}
		else {
			## 비밀글이었다가 해제가 되는 경우 이전 비밀번호를 유지 ##############################################
			$privacyquery = "UPDATE odtBoard SET privacy='$privacy', password='$password' WHERE familyid=$serialnum";
			$privacyresult = mysql_query($privacyquery, $connect);
		}
		*/

		$Updateresult = mysql_query("UPDATE odtBoard SET writer='$writer', email='$email', homepage='$homepage', ip='$ip', password='$password', htmls='$htmls', title='$title', content='$content', file1='$fileNameTemp1', filecomment1='$filecomment1', file2='$fileNameTemp2', filecomment2='$filecomment2', file3='$fileNameTemp3', filecomment3='$filecomment3', file4='$fileNameTemp4', filecomment4='$filecomment4', file5='$fileNameTemp5', filecomment5='$filecomment5' WHERE serialnum=$serialnum");
		
		if($Updateresult) {
			echo "
				<script>
					window.alert(\"글이 수정되었습니다.   \");
				</script>";

			echo "<meta http-equiv='refresh' content='0; URL=$boardmoveTemp?board=$board&page=$page&field=$field&value=$value'>";
			exit;
		}
		else {
			error_msgback_user("db 접속에러 입니다.{글수정}.   ");
		}
	}
?>