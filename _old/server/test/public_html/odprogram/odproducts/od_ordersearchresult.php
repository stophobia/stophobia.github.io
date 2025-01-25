<?
	include "../odcommon/od_config.inc.php";
	include "../odcommon/od_function.inc.php";
	include "../odcommon/od_lib.inc.php";
	include "../odcommon/od_head.inc.php";
	include "../odcommon/od_body.inc.php";
?>
<style type="text/css">
<!--
.style1 {
	color: #85a8ff;
	font-weight: bold;
}
.style2 {color: #ff6600}
-->
</style>
		<script>
			function openorderdelete(ordernum,mode) {
				window.open('pwd.php?ordernum='+ordernum+'&mode='+mode,'del','width=330,height=142');
			}
		</script>

<!-- top 시작 -->
<? include $_SERVER[DOCUMENT_ROOT]."/pages/subHead.html"; ?>
<!-- top 끝 -->

															<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td  valign="top">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td height="23"></td>
                                      </tr>
                                    </table>
                                    <table width="716" border="0" align="center" cellpadding="0" cellspacing="0">
                                      <tr>
                                        <td  valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td><img src="/img/modify_img_40.jpg" width="83" height="32" /></td>
                                          </tr>
                                        </table>
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr>
                                                    <td height="2" bgcolor="#666666"></td>
                                                  </tr>
                                                </table>
                                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                      <td height="31" background="/img/modify_img_24.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                          <tr>
                                                            <td width=80><div align="center">주문번호</div></td>
                                                            <td width=266><div align="center">상품명</div></td>
                                                            <td width=40><div align="center">수량</div></td>
                                                            <td width=90><div align="center">결제금액</div></td>
                                                            <td width=80><div align="center">결제상태</div></td>
                                                            <td width=80><div align="center">처리상황</div></td>
                                                            <td width=80><div align="center">비고</div></td>
                                                          </tr>
                                                      </table></td>
                                                    </tr>
                                                </table></td>
                                            </tr>
                                          </table>
<?
if($row_member[id]) include "./od_ordersearchresult_m.php";
else if($_SESSION[Gid]) include "./od_ordersearchresult_g.php";
else exit;
?>
																				</td>
                                      </tr>
                                    </table></td>
                                </tr>
                              </table>		


<? include $_SERVER[DOCUMENT_ROOT]."/pages/subFoot.html"; ?>
