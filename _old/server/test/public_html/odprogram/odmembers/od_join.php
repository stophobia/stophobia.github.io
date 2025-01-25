<?
    include "../odcommon/od_config.inc.php";
    include "../odcommon/od_function.inc.php";
    include "../odcommon/od_lib.inc.php";
    include "../odcommon/od_head.inc.php";
    include "../odcommon/od_body.inc.php";
    include "./COkname.php";

    ##아이핀필드조건검사
    $sSiteID = $row_setup[nauthen_id2];  	// 사이트 id(KCB)
    $KCB = new COkName($sSiteID);
   
    ##없는필드확인하여서 추가
    $add_fields = "'kcb_encPsnlInfo','kcb_virtualno','kcb_realname','kcb_age','kcb_sex','kcb_birthdate','kcb_dupinfo'";
    $add_fields_type = "varchar(80),varchar(30),varchar(30),varchar(30),varchar(30),varchar(30),varchar(80)";
    $add_fields_value = ",,,,,,";
    $KCB->Add_Fileds("odtMember",$add_fields,$add_fields_type,$add_fields_value);
    ###########################################


    ##로그인된 사용자라면 정보수정화면으로 이동
    if($row_member[id]) {
        echo "<script>location.href='/odprogram/odmembers/od_modify.php';</script>";
        exit;
    }
    ##KCB로부터 인증을 받고왔는지체크
    $check_ok = $_POST[check_ok];
    //echo "<script>alert('$check_ok')</script>";

    ##KCB사용자라면 실명인증창으로 이동한다.
    if ( $realCheck != "1" && $row_setup[nauthen_com] == "K" && $row_setup[nauthen_use] == "yes" ) {
        echo "<script>location.href='/odprogram/odmembers/kcb_okname.php';</script>";
        exit;
    }

    //인증여부에따른 조건활성화
    if ($realCheck=="1") {
        if ($virtualno=="") {   $msg="KCB 실명인증이 완료되었습니다"; }
        else                {   $msg="KCB 아이핀인증이 완료되었습니다"; }
        $style="readonly style='background-Color=eeeeee'";
        $check_button = "<img src='/img/member_img_11.jpg' width='64' height='18' border=0 />";
    } else {
        $style="";
        $msg="주민등록번호는 해독할 수 없게 암호화 되어 저장됩니다.";
        $check_button = "<a href='#none' onclick='realCheckFun()' ><img src='/img/member_img_11.jpg' width='64' height='18' border=0 /></a>";
    }

?>

        <script language="javascript">

			function isnum(NUM) {
				for(var i=0;i<NUM.length;i++) {
					achar = NUM.substring(i,i+1);
					if( achar < "0" || achar > "9" ) {
						return false;
					}
				}
				return true;
			}
			function valueCheck(theForm) {
				if(theForm.agree[0].checked != true) {
					alert('이용약관을 읽고 동의해주시기 바랍니다.');
					theForm.agree[0].focus();
					return false;
				}

				if(theForm.agree2[0].checked != true) {
					alert('개인정보 취급방침을 읽고 동의해주시기 바랍니다.');
					theForm.agree2[0].focus();
					return false;
				}


				if(!theForm.idCheck1.value) {
					alert('ID 중복확인을 해주시기 바랍니다.');
					return false;
				}

				if(!theForm.nickCheck1.value) {
					alert('닉네임중복확인을 해주시기 바랍니다.');
					return false;
				}				


				if(!theForm.realCheck.value) {
					alert('실명인증을 해주시기 바랍니다.');
					return false;
				}

				if(!theForm.id.value) {
					window.alert("아이디를 입력해 주세요.   ");
					theForm.id.focus();
					return false;
				}

				if(!theForm.nickName.value) {
					window.alert("닉네임을 입력해 주세요.   ");
					theForm.nickName.focus();
					return false;
				}
				if(theForm.id.value) {
					<?
					$none_id_division = explode("/",$row_setup[noneid]);
					$none = 0;
					while($none_id_division[$none]) {
					?>
						if(theForm.id.value == "<?=$none_id_division[$none]?>") { //noneid
							window.alert("아이디로 <?=$none_id_division[$none]?>는 사용하실 수 없습니다.   \n\n다른 아이디를 입력해 주세요.   ");
							theForm.id.focus();
							return false;
						}
					<?
						$none++;
					}
					?>
				}
				if(theForm.id.value.length < 4 || theForm.id.value.length > 12) {
					window.alert("아이디는 4자 이상  12자 이하의 영문/숫자 또는 영문과 숫자 조합의 문자열이어야 합니다.   ");
					theForm.id.focus();
					return false;
				}
				if(!theForm.passwd.value) {
					window.alert("비밀번호를 입력해 주세요.   ");
					theForm.passwd.focus();
					return false;
				}
				if(theForm.passwd.value.length < 4 || theForm.passwd.value.length > 12) {
					window.alert("비밀번호는 4자 이상 12자 이하의 숫자/영문 또는 숫자와 영문 조합의 문자열이어야 합니다.   ");
					theForm.passwd.focus();
					return false;
				}
				if(!theForm.repasswd.value) {
					window.alert("비밀번호 확인을 위해 비밀번호를 다시 입력하셔야 합니다.   ");
					theForm.repasswd.focus();
					return false;
				}
				if(theForm.passwd.value != theForm.repasswd.value) {
					window.alert("비밀번호가 서로 일치하지 않습니다.   \n\n정확하게 입력해 주세요.   ");
					theForm.repasswd.focus();
					return false;
				}
				if(!theForm.name.value) {
					window.alert("이름을 입력하세요.   ");
					theForm.name.focus();
					return false;
				}
				if(!theForm.resinum1.value) {
					window.alert("주민번호 앞자리를 입력해 주세요.   ");
					theForm.resinum1.focus();
					return false;
				}
				if(!theForm.resinum2.value) {
					window.alert("주민번호 뒷자리를 입력해 주세요.   ");
					theForm.resinum2.focus();
					return false;
				}
				if(theForm.resinum1.value.length != 6 || !isnum(theForm.resinum1.value)) {
					window.alert("올바르지않은 주민번호 입니다.   \n\n다시 입력해 주세요.   ");
					theForm.resinum1.focus();
					return false;
				}
				if(theForm.resinum2.value.length != 7 || !isnum(theForm.resinum2.value)) {
					window.alert("올바르지않은 주민번호 입니다.   \n\n다시 입력해 주세요.   ");
					theForm.resinum2.focus();
					return false;
				}
				if(!theForm.email.value) {
					window.alert("E-mail을 입력해 주세요.   ");
					theForm.email.focus();
					return false;
				}
				if((!theForm.email.value) || ((theForm.email.value.indexOf("@") == -1) || (theForm.email.value.indexOf(".") == -1))) {
					window.alert("올바르지않은 E-mail 입니다.   \n\n다시 입력해 주세요.   ");
					theForm.email.focus();
					return false;
				}
				if(!theForm.zip1.value) {
					window.alert("우편번호 앞자리를 입력해 주세요.   ");
					theForm.zip1.focus();
					return false;
				}
				if(!theForm.zip2.value) {
					window.alert("우편번호 뒷자리를 입력해 주세요.   ");
					theForm.zip2.focus();
					return false;
				}
				if(!theForm.zip1.value || theForm.zip1.value.length != 3 || !isnum(theForm.zip1.value)) {
					window.alert("올바르지않은 우편번호 입니다.   \n\n다시 입력해 주세요.   ");
					theForm.zip1.focus();
					return false;
				}
				if(!theForm.zip2.value || theForm.zip2.value.length != 3 ||  !isnum(theForm.zip2.value)) {
					window.alert("올바르지않은 우편번호 입니다.   \n\n다시 입력해 주세요.   ");
					theForm.zip2.focus();
					return false;
				}
				if(!theForm.address.value) {
					window.alert("주소를 입력해 주세요.   ");
					theForm.address.focus();
					return false;
				}
				if(!theForm.address1.value) {
					window.alert("상세주소를 입력해 주세요.   ");
					theForm.address1.focus();
					return false;
				}
				if(!theForm.tel1.value) {
					window.alert("전화번호 중 지역번호를 입력해 주세요.   ");
					theForm.tel1.focus();
					return false;
				}
				if(!theForm.tel2.value) {
					window.alert("전화번호 중 국번을 입력해 주세요.   ");
					theForm.tel2.focus();
					return false;
				}
				if(!theForm.tel3.value) {
					window.alert("전화번호 중 번호를 입력해 주세요.   ");
					theForm.tel3.focus();
					return false;
				}
				if(!theForm.tel1.value || theForm.tel1.value.length < 2 || !isnum(theForm.tel1.value)) {
					window.alert("올바르지않은 전화번호 입니다.   \n\n다시 입력해 주세요.   ");
					theForm.tel1.focus();
					return false;
				}
				if(!theForm.tel2.value || theForm.tel2.value.length < 3 || !isnum(theForm.tel2.value)) {
					window.alert("올바르지않은 전화번호 입니다.   \n\n다시 입력해 주세요.   ");
					theForm.tel2.focus();
					return false;
				}
				if(!theForm.tel3.value || theForm.tel3.value.length < 4 || !isnum(theForm.tel3.value)) {
					window.alert("올바르지않은 전화번호 입니다.   \n\n다시 입력해 주세요.   ");
					theForm.tel3.focus();
					return false;
				}
				frm.action = "/odprogram/odmembers/od_memberinput.inc.php";
				frm.target = "hidden_frame";

			}
			function idCheck(){
				if(!document.snsForm.id.value) {
					alert('아이디 입력 후 중복확인을 해 주세요.   ');
					snsForm.id.focus();
					return;
				}
				conflict=	window.open("","conflict","scrollbars=no, resizable=no, width=370, height=229");
				var check_url = "od_checkid.php?id=" + document.snsForm.id.value;
				conflict.document.location = check_url ;
				conflict.focus() ;
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

			function moveNext (num, from, to) {
				var len = from.value.length;
				if(len == num)
					to.focus ();
			}
			function postsearch() {
				  window.open('../odpostcode/od_postsearch.php?Mode=Member','post_find','resizable=yes,scrollbars=yes,width=386,height=410'); 
			}
			function postsearch1() {
				  window.open('../odpostcode/od_postsearch.php?Mode=MemberO','post_find','resizable=yes,scrollbars=yes,width=386,height=410'); 
			}

            //실명인증확인
            function realCheckFun() {
                frm = document.snsForm;

                if(!frm.name.value) {
                    alert('실명을 입력해주세요.');
                    frm.name.focus();
                    return false;
                }
                if(!frm.resinum1.value) {
                    alert('주민번호를 입력해주세요.');
                    frm.resinum1.focus();
                    return false;
                }
                if(!frm.resinum2.value) {
                    alert('주민번호를 입력해주세요.');
                    frm.resinum2.focus();
                    return false;
                }

                frm.action = "/odprogram/odmembers/od_realCheck.php";
                frm.target = "hidden_frame";
                frm.submit();

                return false;
            }
		</script>

		<iframe name="hidden_frame" src="about:blank" width=500px height=500px style="display:none"></iframe>
					<!-- top 시작 -->
<? include $_SERVER[DOCUMENT_ROOT]."/pages/subHead.html"; ?>
					<!-- top 끝 -->
					<!-- main start -->
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="31">&nbsp;</td>
                  </tr>
                </table>

<form name="snsForm" method="post" action="od_memberinput.inc.php" onsubmit="return valueCheck(this)" style="display:inline" target="hidden_frame">
<input type="hidden" name="realCheck" value="<?=$realCheck?>">
<input type="hidden" name="idCheck1" value="">
<input type="hidden" name="nickCheck1" value="">
<input type="hidden" name="authtype" value="<?=$authtype?>"><!-- -->
<!-- KCB 아이핀추가데이터 -->
<input type="hidden" name="kcb_encPsnlInfo" value="<?=$encPsnlInfo?>">
<input type="hidden" name="kcb_virtualno" value="<?=$virtualno?>">
<input type="hidden" name="kcb_realname" value="<?=$realname?>">
<input type="hidden" name="kcb_age" value="<?=$age?>">
<input type="hidden" name="kcb_sex" value="<?=$sex?>">
<input type="hidden" name="kcb_birthdate" value="<?=$birthdate?>">
<input type="hidden" name="kcb_dupinfo" value="<?=$dupinfo?>">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><table width="775" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="493"><img src="/img/member_img_01.jpg" width="493" height="123" /></td>
        <td rowspan="2"><img src="/img/member_img_03.jpg" width="282" height="179" /></td>
      </tr>
      <tr>
        <td><img src="/img/member_img_02.jpg" width="168" height="56" /></td>
        </tr>
    </table>
      <table width="716" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><img src="/img/member_img_04.jpg" width="60" height="32" /></td>
            </tr>
          </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="2" bgcolor="#666666"></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="9" bgcolor="#f5f5f5"></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="258" valign="top" bgcolor="#f5f5f5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="9"></td>
                    <td><textarea class="personrecordtextarea" readonly="readOnly" name="textarea"><?=stripslashes(mysql_result(mysql_query("select guideinfo from odtCompany limit 1"),0))?></textarea></td>
                  </tr>
                </table>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="582" height="28" background="/img/member_img_05.jpg">&nbsp;</td>
                      <td width="10"><font color="#1b436d">
                         <input type="radio" value="yes" name="agree" />
                      </font></td>
                      <td width="36">동의함</td>
                      <td width="10"><font color="#1b436d">
                        <input type="radio" value="no" 
                name="agree" />
                      </font></td>
                      <td>동의안함</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="1" bgcolor="#dcdcdc"></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="21"></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><img src="/img/member_img_06.jpg" width="113" height="30" /></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="2" bgcolor="#666666"></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="9" bgcolor="#f5f5f5"></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="258" valign="top" bgcolor="#f5f5f5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="9"></td>
                      <td><textarea class="personrecordtextarea" readonly="readOnly" name="textarea2"><?=stripslashes(mysql_result(mysql_query("select privacyinfo from odtCompany limit 1"),0))?></textarea></td>
                    </tr>
                  </table>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="582" height="28" background="/img/member_img_07.jpg">&nbsp;</td>
                        <td width="10"><font color="#1b436d">
                          <input type="radio" value="yes" 
                name="agree2" />
                        </font></td>
                        <td width="36">동의함</td>
                        <td width="10"><font color="#1b436d">
                          <input type="radio" value="no" 
                name="agree2" />
                        </font></td>
                        <td>동의안함</td>
                      </tr>
                  </table></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="1" bgcolor="#dcdcdc"></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="21"></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><img src="/img/member_img_08.jpg" width="92" height="33" /></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="2" bgcolor="#666666"></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="108"><img src="/img/member_img_title__01.jpg" width="108" height="31" /></td>
                    <td background="/img/member_img_title__13.jpg"><table border="0" cellspacing="0" cellpadding="0" 
                width="100%">
                      <tbody>
                        <tr>
                          <td width="10"></td>
                          <td width="10"><input style="IME-MODE: disabled" class="gray_3" onchange="this.form.idCheck1.value=''" maxlength="12" size="24" name="id" /></td>
                          <td width="8">&nbsp;</td>
                          <td width="74"><a href="#none" onclick="idCheck();" ><img src="/img/member_img_09.jpg" width="74" height="18" border=0 /></a></td>
                          <td width="8">&nbsp;</td>
                          <td class="pro_best_2">영, 숫자조합 
                            (4~12자)</td>
                        </tr>
                      </tbody>
                    </table></td>
                  </tr>
                </table>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="108"><img src="/img/member_img_title__02.jpg" width="108" height="31" /></td>
                      <td background="/img/member_img_title__13.jpg"><table border="0" cellspacing="0" cellpadding="0" 
                width="100%">
                        <tbody>
                          <tr>
                            <td width="10"></td>
                            <td width="10"><input class="gray_3" onchange="this.form.nickCheck1.value=''" maxlength="10" size="24" name="nickName" /></td>
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
                      <td background="/img/member_img_title__13.jpg"><table border="0" cellspacing="0" cellpadding="0" 
                width="100%">
                        <tbody>
                          <tr>
                            <td width="10"></td>
                            <td width="10"><input class="gray_3" maxlength="12" 
                size="24" type="password" name="passwd" /></td>
                            <td width="8">&nbsp;</td>
                            <td class="pro_best_2">영, 숫자조합 
                              (4~12자)</td>
                          </tr>
                        </tbody>
                      </table></td>
                    </tr>
                  </table>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="108"><img src="/img/member_img_title__04.jpg" width="108" height="31" /></td>
                      <td background="/img/member_img_title__13.jpg"><table border="0" cellspacing="0" cellpadding="0" 
                width="100%">
                        <tbody>
                          <tr>
                            <td width="10"></td>
                            <td width="10"><input class="gray_3" maxlength="12" 
                size="24" type="password" name="repasswd" /></td>
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
                      <td width="108"><img src="/img/member_img_title__05.jpg" width="108" height="31" /></td>
                      <td background="/img/member_img_title__13.jpg"><table border="0" cellspacing="0" cellpadding="0" 
                width="100%">
                        <tbody>
                          <tr>
                            <td width="10"></td>
                            <td width="10"><input class="gray_3" size="24" 
                name="name" value="<?=$realname?>" <?=$style?>/></td>
                            <td width="8">&nbsp;</td>
                            <td class="pro_best_2">실명 한글 이름을 
                              입력하세요.</td>
                          </tr>
                        </tbody>
                      </table></td>
                    </tr>
                  </table>
<!--실명인증-->
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="108"><img src="/img/member_img_title__07_ver2.jpg" width="108"/></td>
                      <td background="/img/member_img_title__14.jpg">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td height="3"></td>
                          </tr>
                        </table>
<div name="panel_auth" style="display:">
                        <table border="0" cellspacing="0" cellpadding="0" width="100%">
                        <tbody>
                          <tr>
                            <td width="10"></td>
                            <td width="60">
                                <input class="gray_4" onkeyup="if(this.value.length==6) {this.form.resinum2.focus();}" maxlength="6" size="24" name="resinum1" value="<?=$resinum1?>" <?=$style?>/></td>
                            <td width="15"><div align="center">-</div></td>
                            <td width="33">
                                <input class="gray_4" maxlength="7" size="24" type="password" name="resinum2" value="<?=$resinum2?>" <?=$style?>/></td>
                            <td width="8">&nbsp;</td>
                            <td class="pro_best_2" width="70"><?=$check_button?></td>
                            <td class="pro_best_2" width="1">&nbsp;</td>
                            <td class="pro_best_2"><?=$msg?></td>
                          </tr>
                        </tbody>
                        </table>
</div>
                        </td>
                    </tr>
                  </table>
<!--실명인증-->


<!--주소-->
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="108"><img src="/img/member_img_title__07.jpg" width="108" height="82" /></td>
                      <td background="/img/member_img_title__14.jpg"><table border="0" cellspacing="0" cellpadding="0" 
                width="100%">
                        <tbody>
                          <tr>
                            <td width="10"></td>
                            <td width="60"><input class="gray_4" readonly 
                size="24" name="zip1" /></td>
                            <td width="15"><div align="center">-</div></td>
                            <td width="33"><input class="gray_4" readonly 
                size="24" name="zip2" /></td>
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
                        <table border="0" cellspacing="0" cellpadding="0" 
                width="100%">
                          <tbody>
                            <tr>
                              <td width="10"></td>
                              <td width="10"><input class="gray_5" readonly size="24" name="address" /></td>
                              <td width="8">&nbsp;</td>
                              <td 
                class="pro_best_2">&nbsp;</td>
                            </tr>
                          </tbody>
                        </table>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td height="3"></td>
                          </tr>
                        </table>
                        <table border="0" cellspacing="0" cellpadding="0" 
                width="100%">
                          <tbody>
                            <tr>
                              <td width="10"></td>
                              <td width="10"><input class="gray_5" size="24" name="address1" /></td>
                              <td width="8">&nbsp;</td>
                              <td 
                class="pro_best_2">&nbsp;</td>
                            </tr>
                          </tbody>
                        </table></td>
                    </tr>
                  </table>
<!--주소-->

                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="108"><img src="/img/member_img_title__08.jpg" width="108" height="31" /></td>
                      <td background="/img/member_img_title__13.jpg"><table border="0" cellspacing="0" cellpadding="0" 
                width="100%">
                        <tbody>
                          <tr>
                            <td width="10"></td>
                            <td><input style="WIDTH: 40px" class="gray_3" maxlength="4" size="24" name="tel1" />
                              -
                              <input style="WIDTH: 40px" class="gray_3" maxlength="4" size="24" name="tel2" />
                              -
                              <input style="WIDTH: 40px" class="gray_3" maxlength="4" size="24" name="tel3" />
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
                              <td><input style="WIDTH: 40px" class="gray_3" maxlength="4" size="24" name="htel1" />
                                -
                                <input style="WIDTH: 40px" class="gray_3" maxlength="4" size="24" name="htel2" />
                                -
                                <input style="WIDTH: 40px" class="gray_3" maxlength="4" size="24" name="htel3" />
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
                      <td width="108"><img src="/img/member_img_title__10.jpg" width="108" height="31" /></td>
                      <td background="/img/member_img_title__13.jpg"><table border="0" cellspacing="0" cellpadding="0" width="100%">
                        <tbody>
                          <tr>
                            <td width="10"></td>
                            <td width="10"><input style="IME-MODE: disabled; WIDTH: 200px" class="gray_3" size="24" name="email" /></td>
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
                            <td width="10"><input value="Y" checked type="radio" name="mailling" /></td>
                            <td width="20">예</td>
                            <td class="pro_best_2" width="10"><input value="N" type="radio" name="mailling" /></td>
                            <td class="pro_best_2" width="60">아니요</td>
                            <td class="pro_best_2">이벤트, 제품 정보, 주문 정보등에 대한 메일링 서비스</td>
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
                            <td width="10"><input value="Y" checked type="radio" name="sms" /></td>
                            <td width="20">예</td>
                            <td class="pro_best_2" width="10"><input value="N" type="radio" name="sms" /></td>
                            <td class="pro_best_2" width="60">아니요</td>
                            <td class="pro_best_2">이벤트, 제품 정보, 주문 정보등에 대한 SMS 서비스</td>
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
                      <td><div align="center"><input type="image" src="/img/member_img_title__16.jpg" width="75" height="30" /></div></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>

</form>
<!-- main end -->


<!-- bottom 시작 -->
<? include_once $_SERVER[DOCUMENT_ROOT]."/pages/subFoot.html"; ?>
<!-- bottom 끝 -->
