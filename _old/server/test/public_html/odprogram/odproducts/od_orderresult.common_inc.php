									  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td bgcolor="#ffffff"><img src="/img/order_img_32.jpg" width="75" height="24" /></td>
                                        </tr>
                                      </table>

																				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                <td height="1" bgcolor="#d2dde0"></td>
                                              </tr>
                                            </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td height="30" bgcolor="#eeeeee"><table width="781" border="0" align="center" cellpadding="0" cellspacing="0">
                                                                                                    <tr>
                                                                                                        <td width="425" height="38"><div align="center"><strong>상 품 명</strong></div></td>
                                                                                                        <td width="120"><div align="center"><b>가 격</b></div></td>
                                                                                                        <td width="120"><div align="center"><b>수 량</b></div></td>
                                                                                                        <td width="40">&nbsp;</td>
                                                                                                        <td><div align="center"><b>합 계</b></div></td>
                                                                                                    </tr>
                                                                                                </table></td>
                                                </tr>
                                              </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td height="1" bgcolor="#d2dde0"></td>
                                                </tr>
                                              </table></td>
                                          </tr>
                                        </table>
<?
// 맨 앞의 ^를 제거하기 위함..
$oLogArray = explode("^",preg_replace("[^\^]","",$oLog));
$pLog = explode("^",$pLog);
for($i=0;$i<count($pLog);$i++) {
    list($pCode,$pCount,$pPrice) = split("\|",$pLog[$i],3);
    $row_product_tmp = mysql_fetch_array(mysql_query("select * from odtProduct where code ='".$pCode."'"));
    if($oLogArray[$i]) {    // 해당상품에 대한 옵션내역이 있으면
        $oLogTmp = explode("|",$oLogArray[$i]);
        $pPrice += $oLogTmp[2];
        $row_product_tmp[name] .= "(".$oLogTmp[1].")";
    }
?>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                <td height="37" bgcolor="#ffffff"><table width="781" border="0" align="center" cellpadding="0" cellspacing="0">
                                                                                                    <tr>
                                                                                                        <td width="425" height="38"><div align="center"><strong><?=$row_product_tmp[name]?></strong></div></td>
                                                                                                        <td width="120"><div align="center"><?=number_format($pPrice)?> 원</div></td>
                                                                                                        <td width="120"><div align="center"><?=$pCount?> 개</div></td>
                                                                                                        <td width="40">&nbsp;</td>
                                                                                                        <td><div align="center"><?=number_format($pCount*$pPrice)?> 원</div></td>
                                                                                                    </tr>
                                                                                                </table></td>
                                              </tr>
                                            </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td height="1" bgcolor="#d2dde0"></td>
                                                </tr>
                                              </table></td>
                                          </tr>
                                        </table>
<?
}
?>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td height="21" bgcolor="#ffffff"></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td bgcolor="#ffffff"><img src="/img/order_img_33.jpg" width="136" height="31" /></td>
                                          </tr>
                                        </table>

                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td height="1" bgcolor="#d2dde0"></td>
                                                </tr>
                                              </table>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr>
                                                    <td height="30" bgcolor="#eeeeee"><table width="781" border="0" align="center" cellpadding="0" cellspacing="0">
                                                                                                            <tr>
                                                                                                                <td width="95" height="36"><div align="center"><b>항 목</b></div></td>
                                                                                                                <td width="580"><div align="center"><b>내 용</b></div></td>
                                                                                                                <td width="30">&nbsp;</td>
                                                                                                                <td align=right style="padding-right:10px"><b>금 액</b></td>
                                                                                                            </tr>
                                                                                                    </table></td>
                                                  </tr>
                                                </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr>
                                                    <td height="1" bgcolor="#d2dde0"></td>
                                                  </tr>
                                              </table></td>
                                          </tr>
                                        </table>
            <!-- 쿠폰 -->
<?
if($cLog) {
    $cLog = explode("^",$cLog);
    for($i=0;$i<count($cLog);$i++) {
        list($cName,$cPrice) = split("\|",$cLog[$i],2);
        if($cName) {
?>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                          <tr>
                                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td height="37"><table width="781" border="0" align="center" cellpadding="0" cellspacing="0">
                                                                                                        <tr>
                                                                                                            <td width="95" height="36"><div align="center">할인</div></td>
                                                                                                            <td width="580"><div align="center"><?=$cName?></div></td>
                                                                                                            <td width="30">&nbsp;</td>
                                                                                                            <td align=right style="padding-right:10px">- <?=number_format($cPrice)?> 원</td>
                                                                                                        </tr>
                                                                                                </table></td>
                                                </tr>
                                              </table>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr>
                                                    <td height="1" bgcolor="#d2dde0"></td>
                                                  </tr>
                                              </table></td>
                                          </tr>
                                        </table>
<?
        }
    }
}
?>

            <!-- 루프 끝 -->
<?
if($gPrice) {
?>
            <!-- 적립금 사용내역 -->
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                          <tr>
                                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td height="37"><table width="781" border="0" align="center" cellpadding="0" cellspacing="0">
                                                                                                        <tr>
                                                                                                            <td width="95" height="36"><div align="center">할인</div></td>
                                                                                                            <td width="580"><div align="center">적립금 사용</div></td>
                                                                                                            <td width="30">&nbsp;</td>
                                                                                                            <td align=right style="padding-right:10px">- <?=number_format($gPrice)?> 원</td>
                                                                                                        </tr>
                                                                                                </table></td>
                                                </tr>
                                              </table>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr>
                                                    <td height="1" bgcolor="#d2dde0"></td>
                                                  </tr>
                                              </table></td>
                                          </tr>
                                        </table>

<?
}
if($dPrice) {
?>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                          <tr>
                                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td height="37"><table width="781" border="0" align="center" cellpadding="0" cellspacing="0">
                                                                                                        <tr>
                                                                                                            <td width="95" height="36"><div align="center">추가</div></td>
                                                                                                            <td width="580"><div align="center">배송비</div></td>
                                                                                                            <td width="30">&nbsp;</td>
                                                                                                            <td background="/images/order_m_06.jpg" align=right style="padding-right:10px">+ <?=number_format($dPrice)?> 원</td>
                                                                                                        </tr>
                                                                                                </table></td>
                                                </tr>
                                              </table>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr>
                                                    <td height="1" bgcolor="#d2dde0"></td>
                                                  </tr>
                                              </table></td>
                                          </tr>
                                        </table>

<?
}
?>

                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                          <tr>
                                            <td height="15"></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                          <tr>
                                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                <td height="1" bgcolor="#d5c4b9"></td>
                                              </tr>
                                            </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="510"></td>
                                                  <td><table width="100%" border="1" bordercolor="#FFFFFF"cellspacing="0" cellpadding="0">
                                                    <tr>
                                                      <td height="28" bgcolor="#f6f2e9"><div align="center" class="style21">총 결제된 금액</div></td>
                                                      <td bgcolor="#eeeeee" align=right ><?=number_format($tPrice)?> 원</td>
                                                      </tr>
                                                    <tr>
                                                      <td height="28" bgcolor="#f6f2e9"><div align="center" class="style21">총 할인 금액</div></td>
                                                      <td bgcolor="#eeeeee" align=right ><strong><?=$sPrice ? "- ".number_format($sPrice) : "0";?> 원</strong></td>
                                                      </tr>
                                                    <tr style='display:none'>
                                                      <td height="28" bgcolor="#f6f2e9"><div align="center" class="style21">배송비</div></td>
                                                      <td bgcolor="#eeeeee" align=right ><strong><?=$dPrice ? "+ ". number_format($dPrice) : "0";?> 원</strong></td>
                                                      </tr>
                                                    <tr>
                                                      <td height="28" bgcolor="#f6f2e9"><div align="center" class="style21">금일 적립 포인트</div></td>
                                                      <td bgcolor="#eeeeee" align=right><strong><?=$gGetPrice ? number_format($gGetPrice) : "0";?> 포인트</strong></td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td height="2" bgcolor="#d5c4b9"></td>
                                                </tr>
                                              </table></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                          <tr>
                                            <td height="15"></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                          <tr>
                                            <td><img src="/img/order_img_34.jpg" width="104" height="31" /></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="171"><img src="/img/order_img_21.jpg" width="171" height="38" /></td>
                                                  <td background="/img/order_img_22.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="15"></td>
                                                        <td><?=$ordername?></td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr>
                                                    <td width="171"><img src="/img/order_img_23.jpg" width="171" height="38" /></td>
                                                    <td background="/img/order_img_22.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                          <td width="15"></td>
                                                          <td><?=$orderhtel1."-".$orderhtel2."-".$orderhtel3?></td>
                                                        </tr>
                                                    </table></td>
                                                  </tr>
                                                </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr>
                                                    <td width="171"><img src="/img/order_img_24.jpg" width="171" height="39" /></td>
                                                    <td background="/img/order_img_25.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                          <td width="15"></td>
                                                          <td><?=$orderemail?></td>
                                                        </tr>
                                                    </table></td>
                                                  </tr>
                                              </table></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                          <tr>
                                            <td height="15"></td>
                                          </tr>
                                        </table>




<?PHP
	// 배송기능 적용시 - onedaynet jjc
	if($row_product[setup_delivery] == "Y") :
?>

                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td width="85"><img src="/img/order_img_26.jpg" width="96" height="35" /></td>
                                            <td>&nbsp;</td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                <td width="171"><img src="/img/order_1_title_01.jpg" width="171" height="38" /></td>
                                                <td background="/img/order_1_title_07.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                      <td width="15"></td>
                                                      <td><?=$recname?></td>
                                                    </tr>
                                                </table></td>
                                              </tr>
                                            </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="171"><img src="/img/order_1_title_02.jpg" width="171" height="38" /></td>
                                                  <td background="/img/order_1_title_07.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="15"></td>
                                                        <td><?=$rectel1."-".$rectel2."-".$rectel3?></td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="171"><img src="/img/order_1_title_03.jpg" width="171" height="38" /></td>
                                                  <td background="/img/order_1_title_07.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="15"></td>
                                                        <td><?=$rechtel1."-".$rechtel2."-".$rechtel3?></td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="171"><img src="/img/order_1_title_05.jpg" width="171" height="99" /></td>
                                                  <td background="/img/order_1_title_08.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="15"></td>
                                                        <td>(<?=$reczip1 . "-" . $reczip2?>) <?=$recaddress?> <?=$recaddress1?></td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table>

											  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="171"><img src="/img/order_1_title_06.jpg"></td>
                                                  <td background="/img/order_1_title_09.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="15"></td>
                                                        <td><?=htmlspecialchars(stripslashes($comment))?></td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table></td>
                                          </tr>
                                        </table>

										<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                          <tr>
                                            <td height="15"></td>
                                          </tr>
                                        </table>


<?PHP
	elseif($viewDel == 1) :
?>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                          <tr>
                                            <td><img src="/img/order_img_26.jpg" /></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="171"><img src="/img/order_1_title_01.jpg" width="171" height="38" /></td>
                                                  <td background="/img/order_1_title_07.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="15"></td>
                                                        <td><?=$recname?></td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr>
                                                    <td width="171"><img src="/img/order_1_title_03.jpg" width="171" height="38" /></td>
                                                    <td background="/img/order_1_title_07.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                          <td width="15"></td>
                                                          <td><?=$rechtel1."-".$rechtel2."-".$rechtel3?></td>
                                                        </tr>
                                                    </table></td>
                                                  </tr>
                                                </table>
                                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="171"><img src="/img/order_img_24_.jpg" width="171" height="38" /></td>
                                                  <td background="/img/order_1_title_07.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="15"></td>
                                                        <td><?=$recemail?></td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="171"><img src="/img/order_img_37.jpg" width="171" height="39" /></td>
                                                  <td background="/img/order_img_25.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="15"></td>
                                                        <td><?=htmlspecialchars(stripslashes($comment))?></td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                          <tr>
                                            <td height="15"></td>
                                          </tr>
                                        </table>
<?PHP
	endif;
?>




                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                          <tr>
                                            <td><img src="/img/order_img_38.jpg" width="73" height="31" /></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                          <tr>
                                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                <td width="171"><img src="/img/order_11_title_01.jpg" width="171" height="38" /></td>
                                                <td background="/img/order_1_title_07.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                      <td width="15"></td>
                                                      <td><span class="style15"><strong><?=number_format($tPrice)?> 원</strong></span></td>
                                                    </tr>
                                                </table></td>
                                              </tr>
                                            </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="171"><img src="/img/order_img_39.jpg" width="171" height="39" /></td>
                                                  <td background="/img/order_img_25.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="15"></td>
                                                        <td>
                                            <?
                                            if($paymethod == "B") echo "무통장 입금";
                                            if($paymethod == "C") echo "신용카드결제";
                                            if($paymethod == "L") echo "실시간계좌이체";
                                            if($paymethod == "H") echo "핸드폰결제";
                                            if($paymethod == "E") echo "무통장 입금 [에스크로결제]";
                                            ?></td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                          <tr>
                                            <td height="20"></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                          <tr>
                                            <td><div align="center" class="unnamed8">결제완료 후에는 주문정보 수정이 되지 않습니다. 다시 한번 주문 사항이 맞는지 확인 하신 후 결제하여 주시기 바랍니다.</div></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                          <tr>
                                            <td height="10"></td>
                                          </tr>
                                        </table>