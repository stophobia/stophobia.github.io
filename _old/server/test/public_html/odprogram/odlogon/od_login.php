<?
	include "../odcommon/od_config.inc.php";
	include "../odcommon/od_function.inc.php";
	include "../odcommon/od_head.inc.php";

	if($row_member[id]) {
		echo "<script>location.href='/';</script>";
		exit;
	}

	session_destroy();

	## 로그인 전 페이지로 이동하기 위한 경로 지정 ################################################
	$path = eregi_replace("@", "&", $path);
	$_move_path = "$path_domain"."$path";
	
	if($_move_path == "$path_home/index.php" || !$path) $_move_path = "$path_home/";
	else if($_move_path == "$path_domain/MemOrder") $_move_path = "$path_home/odproducts/od_order.php";
	else if($_move_path == "$path_home/odmembers/od_membersearch.php?Form=MemberSearch" || $_move_path == "$path_home/odmembers/od_memberinput.php?Form=SingUpFORM") $_move_path = "$path_home/odmembers/mypage.php";
?>
		<script language="javascript">
			function valueCheck2(form) {
				var form = document.snsFormMem;
				if(!form.id.value) {
					alert("회원님의 아이디를 입력해 주세요.   ");
					form.id.focus();
					return false;
				}
				if(!form.passwd.value) {
					alert("회원님의 비밀번호를 입력해 주세요.   ");
					form.passwd.focus();
					return false;
				}
			}
		</script>

	<body leftmargin='0' topmargin='0' onload="document.snsFormMem.id.focus();">
					<!-- top 시작 -->
<? include $_SERVER[DOCUMENT_ROOT]."/pages/subHead.html"; ?>
					<!-- top 끝 -->
					<!-- main start -->
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="31">&nbsp;</td>
                  </tr>
                </table>

								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td height=30></td>
									</tr>
                  <tr>
                    <td valign="top"  height=400 ><table width="775" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td><img src="/img/login_img_01.jpg" width="775" height="123" /></td>
                      </tr>
                    </table>
                      <table width="775"border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td valign="top">
													
													<table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td><img src="/img/login_img_02.jpg" width="330" height="46" /></td>
                            </tr>
                          </table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="353" height="82" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td height="18"></td>
                                  </tr>
                                </table>
																<form name="snsFormMem" method="post" action="od_loginForm.php" onSubmit="return valueCheck2(this)" style="display:inline">
																<input type="hidden" name="_move_path" value="<?=$_move_path?>">
                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td width="85"><img src="/img/login_img_03.jpg" width="85" height="20" /></td>
                                      <td width="190"><input style="IME-MODE: disabled;width:185px" height="20" class="gray" tabindex="1" name="id" value="" /></td>
                                      <td width="5" rowspan="3"></td>
                                      <td rowspan="3"><input type="image" src="/img/login_img_05.jpg" width="73" height="45" border=0 tabindex="3" /></td>
                                    </tr>
                                    <tr>
                                      <td height="5" colspan="2"></td>
                                    </tr>
                                    <tr>
                                      <td width="85"><img src="/img/login_img_04.jpg" width="85" height="20" /></td>
                                      <td><input style="width:185px" height="20" class="gray" tabindex="2" name="passwd" type="password" value=""/></td>
                                    </tr>
                                  </table>
																</form>	
																</td>
                                <td width="90" background="/img/login_img_06.jpg">&nbsp;</td>
                                <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td height="5"></td>
                                  </tr>
                                </table>
<!-- 
                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td width="203"><img src="/img/login_img_07.jpg" width="203" height="25" /></td>
                                      <td><a href="/odprogram/odboard/od_boardread.php?board=1&page=1&serialnum=23&pTemp=cGFzc1dvcmQ9$!" target="_self"><img src="/img/login_img_10.jpg" width="94" height="19" border=0 /></a></td>
                                    </tr>
                                  </table>
 -->
                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td width="203"><img src="/img/login_img_08.jpg" width="203" height="24" /></td>
                                      <td><a href="#none" onclick="javascript:openwindow('msearch','../odmembers/od_membersearch.php',370,352,0);" onfocus='this.blur()' ><img src="/img/login_img_11.jpg" width="94" height="19" border=0 /></a></td>
                                    </tr>
                                  </table>
                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td width="203"><img src="/img/login_img_09.jpg" width="203" height="23" /></td>
                                      <td><a href="/odprogram/odmembers/od_join.php"><img src="/img/login_img_12.jpg" width="94" height="19" border=0 /></a></td>
                                    </tr>
                                  </table></td>
                              </tr>
                            </table>
                            </td>
                        </tr>
                      </table>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td height="33"></td>
                        </tr>
                      </table>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td height="23" background="/img/login_img_13.jpg">&nbsp;</td>
                        </tr>
                      </table></td>
                    </tr>
                </table>


					<!-- bottom 시작 -->
<? include_once $_SERVER[DOCUMENT_ROOT]."/pages/subFoot.html"; ?>
					<!-- bottom 끝 -->
