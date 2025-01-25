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
<form name="smsFrm" action="/pages/etc/tomailPro.php" onsubmit="return smsFunc(this)" method="post">
<input type="hidden" name="id" value="<?=$row_member[id]?>">
<input type="hidden" name="code" value="<?=$_GET[code]?>">
<table width="429" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><img src="/images/group/popup_img_07.jpg" width="429" height="56"></td>
      </tr>
    </table>
      <table width="429" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="17">&nbsp;</td>
              <td><img src="/images/group/popup_img_08.jpg" width="243" height="44"></td>
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
                      <td width="75">받는사람</td>
                      <td width="73"><span class="spb15">
                        <input name="toName" type="text"  class="input" style="width:73px; height:21px;line-height:160%" value="이름" onfocus="if(this.value=='이름') this.value='';">
                      </span></td>
                      <td width="5"></td>
                      <td><span class="spb15">
                        <input name="toMail" type="text"  class="input" style="width:218px; height:21px;line-height:160%" value="이메일" onfocus="if(this.value=='이메일') this.value='';">
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
                      <td width="75">보내는사람</td>
                      <td width="73"><span class="spb15">
                        <input name="fromName" type="text"  class="input" style="width:73px; height:21px;line-height:160%" value="이름" onfocus="if(this.value=='이름') this.value='';">
                      </span></td>
                      <td width="5"></td>
                      <td><span class="spb15">
                        <input name="fromMail" type="text"  class="input" style="width:218px; height:21px;line-height:160%" value="이메일" onfocus="if(this.value=='이메일') this.value='';">
                      </span></td>
                    </tr>
                </table></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="174" background="/images/group/popup_img_10.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="17"></td>
                      <td width="75">전송메세지</td>
                      <td><span class="spb15">
                        <textarea name="textarea" style="width:296px; height:152px;font-size:12px;font-family:굴림;color:333333;line-height:160%"><?=$_GET[title]?></textarea>
                      </span></td>
                    </tr>
                </table></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="20"></td>
              </tr>
            </table>
            <table width="30%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="72"><input type="image" src="/images/group/popup_img_09.jpg" width="112" height="33"></td>
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
