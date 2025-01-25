            <iframe name="hf" src="about:blank" style="display:none"></iframe>
<!--        <iframe name="hf" src="about:blank" width=700 height=500></iframe> -->
            <script>
            function orderCanceled(ordernum) {
                if(!confirm('주문을 취소하시겠습니까?')) return false;
                hf.location.href="ordercanceled.php?ordernum="+ordernum;
            }
            function orderCanceled2(ordernum) {
                if(!confirm('주문을 취소하시겠습니까?')) return false;
                hf.location.href="od_ordercanceled2.php?ordernum="+ordernum;
                //location.href="od_ordercanceled2.php?ordernum="+ordernum;
            }
            // 문자 발송
            function couponSMSSend(ordernum) {
                if(!confirm('쿠폰 발급문자를 발송하시겠습니까?')) return false;
                hf.location.href="od_sms_coupon.inc.php?OrderNum="+ordernum;
            }

            </script>
<?
$que = "select * from odtOrder where orderid = '".$row_member[id]."' and canceled ='N'  and (paystatus='Y' || (paymethod='B' || paymethod='E')) order by orderdate desc";
$res = mysql_query($que);
if(!mysql_num_rows($res)) {
?>
            <table width="95%" border="0" cellspacing="0" cellpadding="0" align=center>
        <tr>
          <td width="100%" height="60" align=center>주문 내역이 없습니다.</td>
                </tr>
                <tr>
                    <td height=1 bgcolor="D8D8D8"></td>
                </tr>
            </table>
<?
}
while($row = mysql_fetch_array($res)) {


    ## 결제상태
    if($row[paymethod] == "C") {$payMent = "신용카드";}
    if($row[paymethod] == "H") {$payMent = "핸드폰결제";}
    if($row[paymethod] == "B") {$payMent = "무통장입금";}
    if($row[paymethod] == "L") {$payMent = "계좌이체";}
    if($row[paymethod] == "G") {$payMent = "G포인트";}
    if($row[paymethod] == "E") {$payMent = "에스크로결제";}

    if($row[paystatus] == "Y") {
        if($row[paystatus2] == "C") {
            $payMent .= "<br>결제취소";
        } else {
            $payMent .= "<br>결제완료";
        }

    }
    if($row[paystatus] == "N") {
        $payMent .= "<br>미결제";
        $payMent .= "<br><a href='#none' onclick=orderCanceled('".$row[ordernum]."')><img src='/img/modify_img_41.jpg' border=0></a>";
    }


?>
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                              <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width=80><div align="center"><?=$row[ordernum]?><br><?=substr($row[orderdate],0,10)?></div></td>
                                                  <td width=306><table border=0 cellpadding=0 cellspacing=0>

        <?
        $oLogArray = explode("^",preg_replace("[^\^]","",$row[oLog]));
        $pLogArray = explode("^",$row[pLog]);
        for($i=0;$i<count($pLogArray);$i++) {

            list($pCode,$pCount,$pPrice) = explode("|",$pLogArray[$i]);
            $row_product_tmp = mysql_fetch_array(mysql_query("select name,cateCode,parent_code from odtProduct where code ='".$pCode."'"));
            $imgArray = array('01'=>'today','02'=>'week','03'=>'live','04'=>'three','05'=>'five','06'=>'mart');

            unset($url);


            if($row[paystatus] == "Y" && $row[paystatus2] <> "Y" && $row_product_tmp[parent_code] == info_nowsale($row_product_tmp[cateCode])) {
                $payMent .= "<br><a href='#none' onclick=orderCanceled2('".$row[ordernum]."')><img src='/img/modify_img_41.jpg' border=0></a>";
            }

            # 카테고리 추출
            $codeTmp = reset(explode("|",$row[pLog]));
            $cateCode = mysql_result(mysql_query("select cateCode from odtProduct where code ='".$codeTmp."'"),0);

            $url = "/?cateCode=${cateCode}&viewCode=".$row_product_tmp[parent_code];

            unset($tkBnt);
			$delMent = "";



			// 배송기능 추가에 따른 분화 - onedaynet jjc
			if($row[order_type] == "product") {
				if($row[delivstatus] == "yes") {
					$delMent = 	$row[expressname];
					if($row[expressnum]) {
						$delMent .= "<br>".$row[expressnum].link_delivery($row[expressname],$row[expressnum]);
					}
				} else {
					if($row[paystatus] == "Y") {
						$delMent = "배송대기";
					} else {
						unset($delMent);
					}
				}
			}
			else {
				if($row[delivstatus] == "yes") {
					if($row[expressnum]) {
						$delMent = 	"<font color=\"red\">발급완료</font>";
						$tkBnt = "<a href=\"#\" onclick=\"window.open('od_couponPrintPop.php?OrderNum=".$row[ordernum]."','cpPop','width=700px,height=500px');\" style=\"color:red;text-decoration:underline\">티켓출력</a>";

						//문자발송횟수 제한
						if ($row[smsCount] >= $row_setup[smsMaxCount] ) {
							$msg_maxSmscount = "문자발송은 최대 $row_setup[smsMaxCount]회 까지 가능합니다";
							$tkBnt = $tkBnt."<br><a href=\"#\" onclick=\"alert('$msg_maxSmscount')\" style=\"color:blue;text-decoration:line-through\">문자발송</a>";
						}
						else {
							$tkBnt = $tkBnt."<br><a href=\"#\" onclick=\"couponSMSSend('".$row[ordernum]."')\" style=\"color:blue;text-decoration:underline\">문자발송</a>";
						}
					}
				}
				else {
					if($row[paystatus] == "Y") {
						$delMent = "대기";
					} else {
						unset($delMent);
					}
				}
			}



			# 옵션값 추출
			if($oLogArray[$i]) {    // 해당상품에 대한 옵션내역이 있으면
				$oLogTmp = explode("|",$oLogArray[$i]);
				$row_product_tmp[name] .= "(".$oLogTmp[1].")";
			}

        ?>
                                <tr>
                                    <td width="266" height=30>&nbsp;&nbsp;<a href="<?=$url?>"><?=$row_product_tmp[name]?></a>  </td>
                                    <td width="40"><div align="center"><?=$pCount?>개</div></td>
                                </tr>
        <?
        }

        ?>
                                                                                                    </table></td>
                                                  <td width=90><div align="center"><?=number_format($row[tPrice])?> 원</div></td>
                                                  <td width=80><div align="center"><?=$payMent?></div></td>
                                                  <td width=80><div align="center"><?=$delMent?></div></td>
                                                  <td width=80><div align="center"><?=$tkBnt?></div></td>
                                                </tr>
                                              </table></td>
                                            </tr>
                                          </table>
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                        <tr>
                                                                                            <td height=5></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td height=1 bgcolor="#dddddd"></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td height=30></td>
                                                                                        </tr>
                                                                                    </table>
<?
}
?>