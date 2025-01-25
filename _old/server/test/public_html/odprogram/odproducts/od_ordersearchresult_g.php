			<iframe name="hf" src="about:blank" style="display:none"></iframe>
			<script>
			function orderCanceled(ordernum) {
				if(!confirm('주문을 취소하시겠습니까?')) return false;
				hf.location.href="ordercanceled.php?ordernum="+ordernum;
			}
			function orderCanceled2(ordernum) {
				if(!confirm('주문을 취소하시겠습니까?')) return false;
				hf.location.href="od_ordercanceled2.php?ordernum="+ordernum;
			}
			</script>
<?
$que = "select * from odtOrder where orderid = '".$_SESSION[Gid]."' and canceled ='N' and (paystatus='Y' || (paymethod='B' || paymethod='E')) order by orderdate desc";
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
	if($row[paymethod] == "L") {$payMent = "실시간계좌이체";}
	if($row[paymethod] == "E") {$payMent = "에스크로결제";}

	if($row[paystatus] == "Y") {
		if($row[paystatus2] == "C") {
			$payMent .= "<br>결제취소";
		} else {
			$payMent .= "<br>결제완료";
		}

		if($row[paystatus2] == "N") {
			$payMent .= "<br><a href='#none' onclick=orderCanceled2('".$row[ordernum]."')><img src='/img/modify_img_41.jpg' border=0></a>";
		} else if($row[paystatus2] == "Y") {
			$payMent .= "<br><a href='#none' onclick='alert(\"결제처리가 끝난 상품이므로 온라인으로 취소하실수 없습니다.\\n\\n".(trim(reset(explode("-",$row_company[tel]))) ? $row_company[tel] : substr($row_company[tel],1,10))."로 전화주시거나, 고객문의에 결제취소요청하시면 \\n\\n처리해드리겠습니다.\")'><img src='/img/modify_img_41.jpg' border=0></a>";
		}
	}
	if($row[paystatus] == "N") {
		$payMent .= "<br>미결제";
		$payMent .= "<br><a href='#none' onclick=orderCanceled('".$row[ordernum]."')><img src='/img/modify_img_41.jpg' border=0></a>";
	}


?>
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                              <td height="30" background="/img/modify_img_25.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
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

			# 카테고리 추출
			$codeTmp = reset(explode("|",$row[pLog]));
			$cateCode = mysql_result(mysql_query("select cateCode from odtProduct where code  ='".$codeTmp."'"),0);

			
			if(!chk_nowsale($codeTmp)) {
				$url = "/?Pid=u05b01m01&code=".$row_product_tmp[parent_code];
			} else {
				if($cateCode == "01") $url = "/?main=today";
				if($cateCode == "02") $url = "/?main=week";
				if($cateCode == "03") $url = "/?main=live";
				if($cateCode == "04") $url = "/?main=three";
				if($cateCode == "05") $url = "/?main=five";
				if($cateCode == "06") $url = "/?main=mart";

			}


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

			# 옵션값 추출
			if($oLogArray[$i]) {	// 해당상품에 대한 옵션내역이 있으면
				$oLogTmp = explode("|",$oLogArray[$i]);
				$row_product_tmp[name] .= "(".$oLogTmp[1].")";
			}		

		?>
								<tr>
									<td width="266" height=30>&nbsp;&nbsp;<a href="<?=$url?>"><?=$row_product_tmp[name]?></a> </td>
									<td width="40"><div align="center"><?=$pCount?>개</div></td>
								</tr>
		<?
		}

		?>
																									</table></td>
                                                  <td width=90><div align="center"><?=number_format($row[tPrice])?> 원</div></td>
                                                  <td width=80><div align="center"><?=$payMent?></div></td>
                                                  <td width=80><div align="center"><?=$delMent?></div></td>
                                                  <td width=80><div align="center">
<?
if($url) {
?>
																										<a href="<?=$url?>"><img src="/img/modify_img_42.jpg"  border=0></a>
<?
}
?>
																									
																									</div></td>
                                                </tr>
                                              </table></td>
                                            </tr>
                                                                                        <tr>
                                                                                            <td height=30></td>
                                                                                        </tr>
                                          </table>

<?
}
?>
