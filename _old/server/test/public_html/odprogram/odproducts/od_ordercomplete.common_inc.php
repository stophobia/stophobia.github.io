<?PHP

// od_ordercomplete*.php에 포함되는 파일임

include "../odcommon/od_head.inc.php";
include "../odcommon/od_body.inc.php";
?>
</head>

<!-- top 시작 -->
<? include $_SERVER[DOCUMENT_ROOT]."/pages/subHead.html"; ?>
                    <!-- top 끝 -->
                    <!-- main start -->
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td height="31">&nbsp;</td>
                        </tr>
          </table>


<style type="text/css">
<!--
.style20 {
    color: #FF0000;
    font-weight: bold;
    font-size: 14px;
}
.style21 {color: #333333}
.style24 {
    color: #18abe1;
    font-weight: bold;
}
-->
</style>

                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td valign="top"><table width="855" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td><img src="/img/order_img_02.jpg" width="855" height="123" /></td>
                      </tr>
                    </table>
                      <table width="855" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td height="23"></td>
                            </tr>
                          </table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                              <tr>
                                <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td><img src="/img/order_img_31.jpg" width="855" height="46" /></td>
                                  </tr>
                                </table>
                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td><img src="/img/order_img_05.jpg" width="855" height="20" /></td>
                                    </tr>
                                  </table>
                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td width="36" valign="top" background="/img/order_img_06.jpg">&nbsp;</td>
                                      <td width="783" valign="top">


                                       <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td><img src="/images/reload_no.jpg" width="783" height="81" /></td>
                                        </tr>
                                                                                <tr>
                                                                                    <td height='20'></td>
                                                                            </tr>
                                      </table>
                                                                            
                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td><img src="/img/order_img_32.jpg" width="75" height="24" /></td>
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
$oLogArray = explode("^",preg_replace("[^\^]","",$orow[oLog]));
$pLogArray = explode("^",$orow[pLog]);
for($i=0;$i<count($pLogArray);$i++) {
    list($buyCode,$buyCnt,$buyPrice) = explode("|",$pLogArray[$i]);
    $tmpRow = mysql_fetch_array(mysql_query("select * from odtProduct where code ='".$buyCode."'"));
    if($oLogArray[$i]) {    // 해당상품에 대한 옵션내역이 있으면
        $oLogTmp = explode("|",$oLogArray[$i]);
        $buyPrice += $oLogTmp[2];
        $tmpRow[name] .= "(".$oLogTmp[1].")";
    }
?>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                <td height="37"><table width="781" border="0" align="center" cellpadding="0" cellspacing="0">
                                                                                                    <tr>
                                                                                                        <td width="425" height="38"><div align="center"><strong><?=$tmpRow[name]?></strong></div></td>
                                                                                                        <td width="120"><div align="center"><?=number_format($buyPrice)?> 원</div></td>
                                                                                                        <td width="120"><div align="center"><?=$buyCnt?> 개</div></td>
                                                                                                        <td width="40">&nbsp;</td>
                                                                                                        <td><div align="center"><?=number_format($buyPrice * $buyCnt)?> 원</div></td>
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
                                                                                <!-- 결제정보 -->
                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td><img src="/img/order_img_28.jpg" width="92" height="35" /></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td valign="top">
                                                                                            <table width="100%" border=0 cellspacing=0 cellpadding=0>
                                                                                                <tr>
                                                                                                    <td height="1" bgcolor="d2dddf"></td>
                                                                                                </tr>
                                                                                            </table>

                                              <table width="100%" border="0" cellspacing="0" cellpadding="0" id="gDisplay" style="display:">
                                                <tr>
                                                  <td width="171"><img src="/img/order_img_43.jpg" width="171" height="38" /></td>
                                                  <td background="/img/order_1_title_07.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="15"></td>
                                                        <td><?=$orow[ordernum]?>                        
                                                                                                                </td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0" id="gDisplay" style="display:">
                                                <tr>
                                                  <td width="171"><img src="/img/order_11_title_02.jpg" width="171" height="38" /></td>
                                                  <td background="/img/order_1_title_07.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="15"></td>
                                                        <td>                                                                
                                            <?
                                            if($orow[paymethod] == "C") echo "카드결제";
                                            if($orow[paymethod] == "H") echo "핸드폰결제";
                                            if($orow[paymethod] == "B") echo "무통장입금";
                                            if($orow[paymethod] == "L") echo "실시간계좌이체";
                                            if($orow[paymethod] == "G") echo "전액 포인트 결제";
                                            if($orow[paymethod] == "E") echo "무통장입금 [에스크로]";
                                            ?>                                                                                                              
                                                                                                                </td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table>
<?
if(!ereg("B|E",$orow[paymethod])) {
?>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="171"><img src="/img/order_11_title_03_.jpg" width="171" height="38" /></td>
                                                  <td background="/img/order_1_title_07.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="15"></td>
                                                        <td>결제성공</td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table>
 <?
} else if(ereg("B|E",$orow[paymethod])) {
    $payNumTmp = explode("/",$orow[paybankname]);

    if($orow[paymethod] == "B") {
        $inputInfoName = $payNumTmp[0]." ".$orow[paybanknum]." ".$payNumTmp[1];
        $inputInfoDate = $orow[paydatey]."년 ".$orow[paydatem]."월 ".$orow[paydated]."일";
        $inputInfoUser = $orow[payname];
    } else {
        $inputInfoName = $escrowBankName." ".$escrowBankNum." (예금주:".$escrowName.")";
        $inputInfoDate = $escrowInputDate." ".$escrowInputTime;
        $inputInfoUser = $escrowInputName;
    }
?>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="171"><img src="/img/order_11_title_03.jpg" width="171" height="38" /></td>
                                                  <td background="/img/order_1_title_07.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="15"></td>
                                                        <td><?=$inputInfoName?></td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table>
                                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="171"><img src="/img/order_11_title_04.jpg" width="171" height="38" /></td>
                                                  <td background="/img/order_1_title_07.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="15"></td>
                                                        <td><?=$inputInfoDate?>                                                                                                     
                                                                                                                </td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table>
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="171"><img src="/img/order_11_title_05.jpg" width="171" height="39" /></td>
                                                  <td background="/img/order_1_title_07.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="15"></td>
                                                        <td><?=$inputInfoUser?></td>
                                                      </tr>
                                                  </table></td>
                                                </tr>
                                              </table>
<?
}
?>
                                                                                            <table width="100%" border=0 cellspacing=0 cellpadding=0>
                                                                                                <tr>
                                                                                                    <td height="1" bgcolor="d2dddf"></td>
                                                                                                </tr>
                                                                                            </table>
                                                                                            </td>
                                          </tr>
                                        </table>




                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td height="21"></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td><img src="/img/order_img_33.jpg" width="136" height="31" /></td>
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
if($orow[cLog]) {
    $cLogArray = explode("^",$orow[cLog]);
    for($i=0;$i<count($cLogArray);$i++) {
        list($cName,$cPrice) = explode("|",$cLogArray[$i]);
    ?>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td height="37"><table width="781" border="0" align="center" cellpadding="0" cellspacing="0">
                                                                                                        <tr>
                                                                                                            <td width="95" height="36"><div align="center">할인</div></td>
                                                                                                            <td width="580" ><div align="center"><?=$cName?></div></td>
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
?>

<?
if($orow[gPrice]) {
?>
            <!-- 적립금 사용내역 -->
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td height="37"><table width="781" border="0" align="center" cellpadding="0" cellspacing="0">
                                                                                                        <tr>
                                                                                                            <td width="95" height="36"><div align="center">할인</div></td>
                                                                                                            <td width="580" ><div align="center">적립금 사용</div></td>
                                                                                                            <td width="30" >&nbsp;</td>
                                                                                                            <td  align=right style="padding-right:10px">- <?=number_format($orow[gPrice])?> 원</td>
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
<?
if($orow[dPrice]) {
?>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td height="37"><table width="781" border="0" align="center" cellpadding="0" cellspacing="0">
                                                                                                        <tr>
                                                                                                            <td width="95" height="36" ><div align="center">추가</div></td>
                                                                                                            <td width="580" ><div align="center">배송비</div></td>
                                                                                                            <td width="30" >&nbsp;</td>
                                                                                                            <td  align=right style="padding-right:10px">+ <?=number_format($orow[dPrice])?> 원</td>
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
                                            <td height="15"></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
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
                                                      <td bgcolor="#eeeeee" align=right ><?=number_format($orow[tPrice])?> 원</td>
                                                      </tr>
                                                    <tr>
                                                      <td height="28" bgcolor="#f6f2e9"><div align="center" class="style21">총 할인 금액</div></td>
                                                      <td bgcolor="#eeeeee" align=right ><strong><?=$orow[sPrice] ? "- ".number_format($orow[sPrice]) : "0";?> 원</strong></td>
                                                      </tr>
                                                    <tr style='display:none'>
                                                      <td height="28" bgcolor="#f6f2e9"><div align="center" class="style21">배송비</div></td>
                                                      <td bgcolor="#eeeeee" align=right ><strong><?=$orow[dPrice] ? "+ ". number_format($orow[dPrice]) : "0";?> 원</strong></td>
                                                      </tr>
                                                    <tr>
                                                      <td height="28" bgcolor="#f6f2e9"><div align="center" class="style21">금일 적립 포인트</div></td>
                                                      <td bgcolor="#eeeeee" align=right><strong><?=$orow[gGetPrice] ? number_format($orow[gGetPrice]) : "0";?> 포인트</strong></td>
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
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td height="15"></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
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
                                                        <td><?=$orow[ordername]?></td>
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
                                                          <td><?=$orow[orderhtel1] ."-".$orow[orderhtel2]."-".$orow[orderhtel3];?></td>
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
                                                          <td><?=$orow[orderemail]?></td>
                                                        </tr>
                                                    </table></td>
                                                  </tr>
                                              </table></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
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
                                                      <td><?=$orow[recname]?></td>
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
                                                        <td><?=$orow[rectel1]."-".$orow[rectel2]."-".$orow[rectel3]?></td>
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
                                                        <td><?=$orow[rechtel1]."-".$orow[rechtel2]."-".$orow[rechtel3]?></td>
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
                                                        <td>(<?=$orow[reczip1]. "-" . $orow[reczip2]?>) <?=$orow[recaddress]?> <?=$orow[recaddress1]?></td>
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
                                                        <td><?=htmlspecialchars(stripslashes($orow[comment]))?></td>
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
                                                        <td><?=$orow[recname]?></td>
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
                                                          <td><?=$orow[rechtel1]."-".$orow[rechtel2]."-".$orow[rechtel3]?></td>
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
                                                        <td><?=$orow[recemail]?></td>
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
                                                        <td><?=htmlspecialchars(stripslashes($orow[comment]))?></td>
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


                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td><div align="center" class="unnamed8">주문해 주셔서 감사합니다. 자세한 내용은 MY페이지에서 확인하실 수 있습니다</div></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td height="10"></td>
                                          </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td><div align="center"><a href="/"><img src="/img/order_img_44.jpg" width="133" height="40" border=0></a></div></td>
                                          </tr>
                                        </table></td>
                                      <td width="36" valign="top" background="/img/order_img_08.jpg">&nbsp;</td>
                                    </tr>
                                  </table>





								  </td>
                              </tr>
                            </table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td><img src="/img/order_img_29.jpg" width="855" height="35" /></td>
                              </tr>
                            </table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td>&nbsp;</td>
                              </tr>
                            </table></td>
                        </tr>
                      </table>


        </td>
    </tr>
</table>
                    <!-- bottom 시작 -->
<? include_once $_SERVER[DOCUMENT_ROOT]."/pages/subFoot.html"; ?>
                    <!-- bottom 끝 -->
