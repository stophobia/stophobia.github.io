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
//현재 디스플레이 되고있는 상품코드
var nowDisplayCode = 0;

function copy(code) {
	window.open('od_proCopy.php?code='+code,'','width=400,height=400');
}	

function hidden_layer() {
	if(nowDisplayCode) document.getElementById(nowDisplayCode).style.display='none';
}
function show_layer(code) {
	if(nowDisplayCode) document.getElementById(nowDisplayCode).style.display='none';
	document.getElementById(code).style.display='inline';
	nowDisplayCode=code;
}
document.onmouseup = hidden_layer;
</script>
		<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
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
										<td height="40" align="center"><table width="200" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td width="21"><a href="<?=$_SERVER[PHP_SELF]?>?playYear=<?=($playYear - 1);?>&playMonth=<?=$playMonth;?>"><img src="/images/navi/navi_first.gif" alt="작년 이달" width="13" height="13" border=0 /></a></td>
												<td width="17" align="right"><a href="<?=$_SERVER[PHP_SELF]?>?playYear=<?=$pre_playYear."&playMonth=".$pre_playMonth;?>"><img src="/images/navi/navi_prev.gif" alt="이전달" width="11" height="13" border=0 /></a></td>
												<td width="119" align="center" style="color:666666;font-family:verdana;font-size:20px;font-weight:bold"><?=$playYear;?>. <?=$playMonth;?></td>
												<td width="17"><a href="<?=$_SERVER[PHP_SELF]?>?playYear=<?=$next_playYear."&playMonth=".$next_playMonth;?>"><img src="/images/navi/navi_next.gif" alt="다음날" width="11" height="13" border=0 /></a></td>
												<td width="26"><a href="<?=$_SERVER[PHP_SELF]?>?playYear=<?=($playYear + 1);?>&playMonth=<?=$playMonth;?>"><img src="/images/navi/navi_last.gif" alt="다음해 이달" width="13" height="13" border=0 /></a></td>
											</tr>
										</table></td>
									</tr>
									<tr>
										<td align="center"><table width="98%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td bgcolor="#eeeedf"><table width="100%" border="0" cellspacing="1" cellpadding="3">
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


										$que = "select * from odtProduct where parent_code = code and sale_date like '".$playYear."-".$playMonth."-".$datetmp."%'";
										$res = mysql_query($que);
										$num = mysql_num_rows($res);
										unset($calPrint,$calPrintRes);

										$cQue = "select * from odtCategory where catecode >= '07' and cHidden ='no' order by catecode asc";
										$cRes = mysql_query($cQue);
										while($cRow = mysql_fetch_array($cRes)) {

											$calPrintHead[$cRow[catecode]] = "<a href='od_input_coupon.php?cateCode=".$cRow[catecode]."&calDate=".$playYear."-".$playMonth."-".$datetmp."'><span class='calHead'>[".$cRow[catename]."]</span></a> ";

										}

										if($num) {
											while($calRow = mysql_fetch_array($res)) {
												unset($viewUrl);
												$viewUrl = "/?viewCode=$calRow[code]&cateCode=$calRow[cateCode]";
												
												# 상품목록
												$viewProListPrint="";
												$resTmp3 = mysql_query("select * from odtProduct where parent_code = '".$calRow[code]."' order by name");
												while($rowTmp3 = mysql_fetch_array($resTmp3)) {
													$viewProListPrint .= "<a href='od_input_coupon.php?code=".$rowTmp3[code]."'><span style='font-family:굴림체;font-size:12px;line-height:140%'>".($rowTmp3[name] ? $rowTmp3[name] : '미입력')."</span></a><br>";
												}

												# 상품기술서
												$proFiles="<b>상품기술서</b>";
												$resTmp4 = mysql_query("select * from odtProFiles where code = '".$calRow[code]."' order by no asc");
												
												if(!mysql_num_rows($resTmp4)) $proFiles .= " : 없음";
												while($rowTmp4 = mysql_fetch_array($resTmp4)) {
													$proFiles .= "<br><a href='profiledown.php?no=".$rowTmp4[no]."'><span style='font-family:굴림체;font-size:12px;line-height:140%'>".($rowTmp4[filename])."</span></a>";
												}


												$calPrint[$calRow[cateCode]] = "<div id=".$calRow[code]." style='Z-INDEX: 1; LEFT: 0px; WIDTH: 0px; POSITION: relative; TOP: 0px; HEIGHT: 0px;display:none;' >
																												<div style='position:absolute;z-index:3;top:5;left:20;' onblur='alert(1)'>
																												<table border='0' cellpadding='2' cellspacing='3' bgcolor='#7B7B7B'>
																													<tr>
																														<td bgcolor='#FFFFFF' style='padding:7px;' >".$viewProListPrint."</td>
																													</tr>
																													<tr>
																														<td bgcolor='#FFFFFF' style='padding:7px;' >".$proFiles."</td>
																													</tr>
																												</table>
																												</div></div>";
												$calPrint[$calRow[cateCode]] .= "<span style='font-face:돋움;font-size:11px;cursor:pointer' onclick=show_layer('".$calRow[code]."') title='".($calRow[mainName] ? $calRow[mainName] : $calRow[name])."'>".cut_str_short(($calRow[mainName] ? $calRow[mainName] : $calRow[name]),6)."</span></a> <br><a href='".$viewUrl."' target='_blank'><img src='../odimages/p.gif' border=0 alt='미리보기'></a>";

											}
										}
										$w = date("w",strtotime($playYear."-".$playMonth."-".$datetmp));
										for($z=7;$z<=100;$z++) {

											if($calPrintHead[$z < 10 ? "0".$z : $z]) 
												$calPrintRes .= $calPrintHead[$z < 10 ? "0".$z : $z] . $calPrint[$z < 10 ? "0".$z : $z]."<br>";
										}


										/* 일정 불러오기 --------------------------------------------------*/

										echo "<td height='80' valign='top' bgcolor='".$boxBgColor."'>
													".$wdate."<br>
													<span class='calMent'>
													".$calPrintRes."													
													</span>
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
