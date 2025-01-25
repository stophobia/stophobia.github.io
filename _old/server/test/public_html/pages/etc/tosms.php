<?php
// 필요한 설정파일 불러오기
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_config.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_lib.inc.php";
include $_SERVER[DOCUMENT_ROOT]."/odprogram/odcommon/od_function.inc.php";
?>
<link href="/css/style.css" rel="stylesheet" type="text/css">
<script>
function smsFunc(frm) {

                                arr = frm.elements;
                                for(i=0;i<arr.length;i++) {
                                        if(arr[i].ment != undefined) {
                                                if(arr[i].type == "text" || arr[i].type == "textarea" || arr[i].type == "password" ||arr[i].type == "select" ||arr[i].type == "select-one") {
                                                        if(!arr[i].value) {
                                                                alert('필수 항목 입니다. : ' + arr[i].ment);
                                                                arr[i].focus();
                                                                return false;
                                                        }
                                                }
                                        }
                                }

																if(!confirm('친구에게 추천하시겠습니까?')) return false;
                                return true;


}
</script>
<form name="smsFrm" action="/pages/etc/tosmsPro.php" onsubmit="return smsFunc(this)" method="post">
<input type="hidden" name="id" value="<?=$row_member[id]?>">
<input type="hidden" name="code" value="<?=$_GET[code]?>">

<table width="429" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><img src="/images/group/popup_img_31.jpg" width="429" height="56"></td>
      </tr>
    </table>
      <table width="429" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="17">&nbsp;</td>
              <td><img src="/images/group/popup_img_32.jpg" width="284" height="44"></td>
            </tr>
          </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="2" bgcolor="#cccccc"></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="35" background="/images/group/popup_img_03.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="17"></td>
                      <td width="121">보내는사람</td>
                      <td><span class="spb15">
                        <input name="fromName" type="text"  class="input" style="width:121px; height:21px;line-height:160%" ment="보내는사람이름">
                      </span></td>
                    </tr>
                </table></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="35" background="/images/group/popup_img_03.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="17"></td>
                      <td width="121">보내는사람 전화번호</td>
                      <td width="54"><span class="spb15">
                        <input name="fromHp1" type="text"  class="input" style="width:54px; height:21px;line-height:160%" maxlength=3 ment="보내는사람전화번호">
                      </span></td>
                      <td width="13"><div align="center">-</div></td>
                      <td width="54"><span class="spb15">
                        <input name="fromHp2" type="text"  class="input" style="width:54px; height:21px;line-height:160%" maxlength=4  ment="보내는사람전화번호">
                      </span></td>
                      <td width="13"><div align="center">-</div></td>
                      <td><span class="spb15">
                        <input name="fromHp3" type="text"  class="input" style="width:54px; height:21px;line-height:160%" maxlength=4  ment="보내는사람전화번호">
                      </span></td>
                    </tr>
                </table></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="35" background="/images/group/popup_img_03.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="17"></td>
                      <td width="121">받는사람 전화번호</td>
                      <td width="54"><span class="spb15">
                        <input name="toHp1" type="text"  class="input" style="width:54px; height:21px;line-height:160%"  maxlength=3 ment="받는사람전화번호">
                      </span></td>
                      <td width="13"><div align="center">-</div></td>
                      <td width="54"><span class="spb15">
                        <input name="toHp2" type="text"  class="input" style="width:54px; height:21px;line-height:160%"  maxlength=4 ment="받는사람전화번호">
                      </span></td>
                      <td width="13"><div align="center">-</div></td>
                      <td><span class="spb15">
                        <input name="toHp3" type="text"  class="input" style="width:54px; height:21px;line-height:160%"  maxlength=4 ment="받는사람전화번호">
                      </span></td>
                    </tr>
                </table></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="104" background="/images/group/popup_img_10.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="17"></td>
                      <td width="121">전송메세지</td>
                      <td><span class="spb15">
                        <textarea name="textarea" style="width:286px; height:82px;font-size:12px;font-family:굴림;color:333333;line-height:160%" readonly><?=$_GET[title]?></textarea>
                      </span></td>
                    </tr>
                </table></td>
              </tr>
							<tr>
								<td height=1 bgcolor="#CCCCCC"></td>
							</tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="40"></td>
              </tr>
            </table>
            <table width="30%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="72"><input type="image" src="/images/group/popup_img_09.jpg" width="112" height="33" border></td>
                <td>&nbsp;</td>
                <td width="72"><a href="#none" onclick="self.close()"><img src="/images/group/popup_img_06.jpg" width="72" height="33" border=0></a></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
</form>
</body>











