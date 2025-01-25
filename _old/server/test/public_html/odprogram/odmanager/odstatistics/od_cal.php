<?
	include "../../odcommon/od_config.inc.php";
	include "../odcommon/od_function.inc.php";		
	include "../odcommon/od_adminAuthority.inc.php";
	include "../odcommon/od_head.inc.php";
	include "../odcommon/od_body.inc.php";

	## 세부권한 체크
	if($row_admin[productLevel] < 3) {
		error_msgloc("../","접근권한이 없습니다.   ");
	}


	function proName($code) {
		return @mysql_result(mysql_query("select mainName from odtProduct where code ='".$code."'"),0);
	}
?>
<style>
.calHead {
	font-size:11px;
	font-family:돋움;
	color:008000;
}
.calMent {
	font-size:11px;
	font-family:돋움;
	color:#000000;
}
.calMent A{
	font-size:11px;
	font-family:돋움;
	color:#000000;
	text-decoration:none;
}
.calMent A:hover{
	font-size:11px;
	font-family:돋움;
	color:#000000;
	text-decoration:underline;
}

</style>
<script>
function copy(code) {
	window.open('od_proCopy.php?code='+code,'','width=400,height=400');
}	
</script>
		<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="FFFFFF">
			<tr> 
				<td height="80" bgcolor="#FFFFFF">
					<!-- top menu start -->
<? include "../odcommon/od_topMenu.inc.php"; ?>
					<!-- top menu end -->
				</td>
			</tr>
			<tr> 
				<td valign="top"> 
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="6"></td>
						</tr>
					</table>
					<table height="100%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="165" height="100%" valign="top"> 
								<!-- left menu start -->
<? include "../odcommon/od_leftMenu.inc.php"; ?>
								<!-- left menu end -->
							</td>
							<td width="3">&nbsp;</td>
							<td width="100%" valign="top">
								<!-- main table start -->
								<table border="0" width=100% cellspacing="0" cellpadding="0">
									<tr>
										<td background="/images/sub_14.gif" style="background-repeat: no-repeat" height="300" valign="top"><table width=100%  border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td>
													<!-- 서브 본문 -->


												
								<?php
									if(!$playYear)		$playYear		= date("Y");
									if(!$playMonth)		$playMonth	= (int)date("m");
									if(!$playDay)			$playDay		= (int)date("d");

									if ($playMonth == "1") {
										$pre_playYear = $playYear-1;
										$pre_playMonth = 12;
									} else {
										$pre_playYear = $playYear;
										$pre_playMonth = $playMonth-1;
									}
									if ($playMonth == "12") {
										$next_playYear = $playYear+1;
										$next_playMonth = 1;
									} else {
										$next_playYear = $playYear;
										$next_playMonth = $playMonth+1;
									}

									if(strlen($playMonth) < 2)	$playMonth = "0".$playMonth;
									if(strlen($playDay)		< 2)	$playDay = "0".$playDay;

									$res = mktime(0,0,0,$playMonth,1,$playYear);
									$firstyoil = date(w,$res);
									$limit = date(t,$res);
								?>

								<script language='javascript'>
/*
								var help_doc = new Array(30);

								function hidden_help() {
									if(document.all.help_layer.style.display =='block') {
										document.all.help_layer.style.display='none';
										document.all.help_doc.innerHTML = '';

										document.all.help_layer.style.top = 0;
										document.all.help_layer.style.left = 0;
									}
								}
								function show_help(num) {
									x = (document.layers) ? e.pageX : document.body.scrollLeft+event.clientX;
									y = (document.layers) ? e.pageY : document.body.scrollTop+event.clientY;
									document.all.help_layer.style.top = y + 15;
									document.all.help_layer.style.left = x;
									document.all.help_layer.style.display='block';
									document.all.help_doc.innerHTML = eval('help_doc['+num+']');
								}
								document.onmouseup = hidden_help;
*/
								</script>
								<!--  도움말 레이어  -->
								<div id='help_layer' style='position:absolute;z-index:3;top:0;left:0;display:none'>
								<table border='0' cellpadding='2' cellspacing='3' bgcolor='#7B7B7B'>
									<tr>
										<td nowrap bgcolor='#FFFFFF' style='padding:7;'><font id='help_doc'></font></td>
									</tr>
								</table>
								</div>
								<!--  //  -->
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
								<!--내용 시작-->
									<td align="center" style='padding-top:10px;'>

								<table  width=100%  border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td height="40" align="center"><table width=100% border=0 cellpadding=0 cellspacing=0>
											<tr>
												<td id="totalPrice" style="font-size:20px;color:blud;font-weight:bold;padding-left:20px"></td>
												<td><table width="200" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td width="21"><a href="<?=$_SERVER[PHP_SELF]?>?playYear=<?=($playYear - 1);?>&playMonth=<?=$playMonth;?>"><img src="/images/navi/navi_first.gif" alt="작년 이달" width="13" height="13" border=0 /></a></td>
														<td width="17" align="right"><a href="<?=$_SERVER[PHP_SELF]?>?playYear=<?=$pre_playYear."&playMonth=".$pre_playMonth;?>"><img src="/images/navi/navi_prev.gif" alt="이전달" width="11" height="13" border=0 /></a></td>
														<td width="119" align="center" style="color:666666;font-family:verdana;font-size:20px;font-weight:bold"><?=$playYear;?>. <?=$playMonth;?></td>
														<td width="17"><a href="<?=$_SERVER[PHP_SELF]?>?playYear=<?=$next_playYear."&playMonth=".$next_playMonth;?>"><img src="/images/navi/navi_next.gif" alt="다음날" width="11" height="13" border=0 /></a></td>
														<td width="26"><a href="<?=$_SERVER[PHP_SELF]?>?playYear=<?=($playYear + 1);?>&playMonth=<?=$playMonth;?>"><img src="/images/navi/navi_last.gif" alt="다음해 이달" width="13" height="13" border=0 /></a></td>
													</tr>
												</table></td>
											</tr>
										</table></td>
									</tr>
									<tr>
										<td align="center"><table width="98%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td bgcolor="#777777"><table width="100%" border="0" cellspacing="1" cellpadding="3">
													<tr>
														<td width="15%" height=24 align="center" bgcolor="#FF6600" style="color:ffffff"><b>일요일</b></td>
														<td width="14%" align="center" bgcolor="#CCCCCC">월요일</td>
														<td width="14%" align="center" bgcolor="#CCCCCC">화요일</td>
														<td width="14%" align="center" bgcolor="#CCCCCC">수요일</td>
														<td width="14%" align="center" bgcolor="#CCCCCC">목요일</td>
														<td width="14%" align="center" bgcolor="#CCCCCC">금요일</td>
														<td width="15%" align="center" bgcolor="#0099FF" style="color:ffffff"><b>토요일</b></td>
													</tr>
													<tr>

								<?php
									$toplayDay = time();
									$height = 120;
									$eventscript = "";
									$totalPrice = 0;
									for($i = 0 ; $i < $firstyoil ; $i++)
									{
										echo "<td height='80' valign='top' bgcolor='#FFFFFF'>&nbsp;</td>";
									}
									for ($date = 1; $date <= $limit ; $date++)
									{
										$weekplayDay = date(w, mktime(0,0,0,$playMonth,$date,$playYear));
										if (!$weekplayDay && $date!=1)
										{
											echo "</tr>";
											echo "<tr>";
											$cnt++;
										}
										if($playYear."-".$playMonth."-".$date == date('Y-m').(date('-d')*1)) $boxBgColor = "#fff3dd"; else $boxBgColor = "#ffffff";

										if($weekplayDay == "6")
										{
											$wdate = "<font color=#BA7705>$date</font>";
										}else if($weekplayDay == "0")
										{
											$wdate = "<font color=#FF0000>$date</font>";
										}else
											$wdate = $date;
										
										unset($eventList);

										/* 한글자일경우 0 붙임 ----------------------------------*/
										if(strlen($date) < 2) $datetmp = "0".$date;
										else $datetmp = $date;
										/* 한글자일경우 0 붙임 ----------------------------------*/

										if($isAdmin) {
											$wdate = "<a href='/C_BOARD/od_board.php?bbsid=plan&bbsMode=write&regidate=".$playYear."-".$playMonth."-".$datetmp."'>".$wdate."</a>";
										}


										/* 일정 불러오기 --------------------------------------------------*/
										unset($pPrint,$script);

										$tmpCnt = 0;

										$queTmp = "select * from odtOrder where paystatus  = 'Y' and canceled='N' and paydate like '".$playYear."-".$playMonth."-".$datetmp."%'";

										$resTmp = mysql_query($queTmp);
										while($rowTmp = mysql_fetch_array($resTmp)) {
											$pLogArray = explode("^",$rowTmp[pLog]);
											$ptmp      = explode("|",$rowTmp[pLog]);

											$tmpCnt = $tmpCnt + $ptmp[1];


											for($p=0;$p<count($pLogArray);$p++) {
												$pCode = reset(explode("|",$pLogArray[$p]));
												$row_product_tmp = mysql_fetch_array(mysql_query("select cateCode,mainName from odtProduct where code ='".$pCode."'"));
												$pPrint[$row_product_tmp[cateCode]][name] .= $row_product_tmp[mainName]."|";
											}
											$pPrint[$row_product_tmp[cateCode]][price] += $rowTmp[tPrice];
										}
										unset($calPrintRes,$sumPrice);
										$resTmp2= mysql_query("select * from odtCategory where cHidden ='no' order by catecode");
										while($rowTmp2 = mysql_fetch_array($resTmp2)) {
											
											$calPrintRes .=  "[".$rowTmp2[catename]."] <b>".($pPrint[$rowTmp2[catecode]][price] ? number_format($pPrint[$rowTmp2[catecode]][price]) : "0")."</b><br>";
										
											$sumPrice +=	$pPrint[$rowTmp2[catecode]][price];

										}
										$totalPrice += $sumPrice;

										/* 일정 불러오기 --------------------------------------------------*/

										echo "<td height='80' valign='top' bgcolor='".$boxBgColor."'>
													".$wdate."<br>
													<span class='calMent'>
													".$calPrintRes."		<br>											
													</span>
													<hr>".$tmpCnt."
													<b>합계 : ".number_format($sumPrice)."원</b>
													</td>";

									}
									
									for ($space = date(w, mktime(0,0,0,$playMonth,$limit,$playYear)); $space < 6 ; $space++)
									{
										echo "<td height='80' valign='top' bgcolor='#FFFFFF'>&nbsp;</td>";
									}

								?>                	

													</tr>
												</table></td>
											</tr><tr>
												<td height="36" align="right">
								<?
								if($isAdmin) 
								 echo "
													- 해당 날짜를 <font color=BA7705>클릭</font>하시면 일정을 등록하실 수 있습니다.
											";
								?>





												</td>
											</tr>
										</table></td>
									</tr>
								</table>

									</td>
								<!--내용 끝-->
								</tr>
								</table>
															
													<!-- // -->
												</td>
											</tr>
										</table></td>
									</tr>
								</table>
								<!-- main table end -->
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td height="83">
					<!-- bottom start -->
<? include "../odcommon/od_bottom.inc.php"; ?>
					<!-- bottom end -->
				</td>
			</tr>
		</table>
	</body>
</html>
<script>
document.getElementById('totalPrice').innerHTML = "총매출 : <?=number_format($totalPrice)?>";
</script>
