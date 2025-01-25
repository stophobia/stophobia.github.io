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

																if(!confirm('작성하신내용을 추천하시겠습니까?')) return false;
                                return true;


}
</script>
<form name="smsFrm" action="/pages/etc/goodsFeedPro.php" onsubmit="return smsFunc(this)" method="post" enctype="multipart/form-data" style='display:inline'>
<input type="hidden" name="gf_id" value="<?=$row_member[id]?>">
<input type="hidden" name="gf_code" value="<?=$_GET[code]?>">
<table width="530" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><img src="/images/group/popup_img_01.jpg" width="530" height="52"></td>
      </tr>
    </table>
      <table width="501" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><img src="/images/group/popup_img_02.jpg" width="229" height="44"></td>
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
                    <td width="63">작성자</td>
                    <td><span class="spb15">
                      <input name="gf_name" type="text" class="input" style="width:206px; height:21px;line-height:160%" ment="작성자">
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
                      <td width="63">연락처</td>
                      <td><span class="spb15">
                        <input name="gf_tel" type="text" class="input"  style="width:206px; height:21px;line-height:160%" ment="연락처">
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
                      <td width="63">핸드폰</td>
                      <td><span class="spb15">
                        <input name="gf_hp" type="text" class="input"  style="width:206px; height:21px;line-height:160%" ment="핸드폰">
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
                      <td width="63">첨부파일</td>
                      <td><span class="spb15">
                        <input name="gf_file" type="file" class="input"  style="width:338px; height:21px;line-height:160%">
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
                      <td width="63">이메일</td>
                      <td><span class="spb15">
                        <input name="gf_email" type="text" class="input"  style="width:338px; height:21px;line-height:160%" ment="이메일">
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
                      <td width="63">제목</td>
                      <td><span class="spb15">
                        <input name="gf_title" type="text" class="input"  style="width:403px; height:21px;line-height:160%" ment="제목">
                      </span></td>
                    </tr>
                </table></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="180" background="/images/group/popup_img_04.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="17"></td>
                    <td width="63">내용</td>
                    <td><span class="spb15">
                      <textarea name="gf_contents" class="input"  style="width:403px; height:152px;line-height:160%"></textarea>
                    </span></td>
                  </tr>
                </table></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="30"></td>
              </tr>
            </table>
            <table width="30%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="72"><input type="image" src="/images/group/popup_img_05.jpg" width="72" height="33"></td>
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